<?php
/**
 * Public booking submissions and protected booking administration endpoints.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class TS_Booking_REST_Controller {
	const NAMESPACE = 'ts/v1';

	public static function register_routes() {
		register_rest_route( self::NAMESPACE, '/bookings/departure', array(
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => array( __CLASS__, 'create_departure' ),
			'permission_callback' => '__return_true',
			'args'                => self::common_args( true ),
		) );

		register_rest_route( self::NAMESPACE, '/bookings/safari', array(
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => array( __CLASS__, 'create_safari' ),
			'permission_callback' => '__return_true',
			'args'                => self::common_args( false ),
		) );

		register_rest_route( self::NAMESPACE, '/admin/bookings', array(
			'methods'             => WP_REST_Server::READABLE,
			'callback'            => array( __CLASS__, 'list_bookings' ),
			'permission_callback' => array( __CLASS__, 'can_manage' ),
		) );

		register_rest_route( self::NAMESPACE, '/admin/bookings/(?P<id>\d+)/status', array(
			'methods'             => WP_REST_Server::EDITABLE,
			'callback'            => array( __CLASS__, 'update_status' ),
			'permission_callback' => array( __CLASS__, 'can_manage' ),
			'args'                => array(
				'status' => array( 'required' => true, 'type' => 'string', 'enum' => array( 'new', 'contacted', 'confirmed', 'cancelled' ) ),
			),
		) );
	}

	public static function create_departure( WP_REST_Request $request ) {
		$blocked = self::submission_guard( $request );
		if ( is_wp_error( $blocked ) ) {
			return $blocked;
		}
		$data                  = self::clean_common( $request );
		$data['departure_id']  = absint( $request['departure_id'] );
		$booking              = TS_Booking_Workflow::create_departure_booking( $data );
		return self::creation_response( $booking );
	}

	public static function create_safari( WP_REST_Request $request ) {
		$blocked = self::submission_guard( $request );
		if ( is_wp_error( $blocked ) ) {
			return $blocked;
		}
		$data                   = self::clean_common( $request );
		$data['tour_post_id']   = absint( $request['tour_post_id'] );
		$data['preferred_date'] = sanitize_text_field( $request['preferred_date'] );
		$booking               = TS_Booking_Workflow::create_safari_booking( $data );
		return self::creation_response( $booking );
	}

	public static function list_bookings( WP_REST_Request $request ) {
		global $wpdb;
		$table = $wpdb->prefix . 'ts_bookings';
		$page  = max( 1, absint( $request->get_param( 'page' ) ) );
		$limit = min( 100, max( 1, absint( $request->get_param( 'per_page' ) ) ?: 20 ) );
		$rows  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table} ORDER BY created_at DESC LIMIT %d OFFSET %d", $limit, ( $page - 1 ) * $limit ) );
		return rest_ensure_response( array( 'items' => $rows, 'page' => $page, 'per_page' => $limit ) );
	}

	public static function update_status( WP_REST_Request $request ) {
		$result = TS_Booking_Workflow::transition_status( absint( $request['id'] ), $request['status'] );
		return is_wp_error( $result ) ? $result : rest_ensure_response( $result );
	}

	public static function can_manage() {
		return current_user_can( 'manage_options' );
	}

	private static function common_args( $departure ) {
		$args = array(
			'customer_name'    => array( 'required' => true, 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' ),
			'email'            => array( 'required' => true, 'type' => 'string', 'format' => 'email', 'sanitize_callback' => 'sanitize_email' ),
			'phone'            => array( 'type' => 'string', 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ),
			'country'          => array( 'type' => 'string', 'default' => '', 'sanitize_callback' => 'sanitize_text_field' ),
			'group_size'       => array( 'required' => true, 'type' => 'integer', 'minimum' => 1, 'maximum' => 20 ),
			'special_requests' => array( 'type' => 'string', 'default' => '', 'sanitize_callback' => 'sanitize_textarea_field' ),
			'website'          => array( 'type' => 'string', 'default' => '' ),
		);
		$args[ $departure ? 'departure_id' : 'tour_post_id' ] = array( 'required' => true, 'type' => 'integer', 'minimum' => 1 );
		if ( ! $departure ) {
			$args['preferred_date'] = array( 'required' => true, 'type' => 'string', 'sanitize_callback' => 'sanitize_text_field' );
		}
		return $args;
	}

	private static function clean_common( WP_REST_Request $request ) {
		return array(
			'customer_name'    => sanitize_text_field( $request['customer_name'] ),
			'email'            => sanitize_email( $request['email'] ),
			'phone'            => sanitize_text_field( $request['phone'] ),
			'country'          => sanitize_text_field( $request['country'] ),
			'group_size'       => absint( $request['group_size'] ),
			'special_requests' => sanitize_textarea_field( $request['special_requests'] ),
		);
	}

	private static function submission_guard( WP_REST_Request $request ) {
		if ( '' !== trim( (string) $request['website'] ) ) {
			return new WP_Error( 'ts_spam_rejected', __( 'Unable to accept this request.', 'tanzania-sensational' ), array( 'status' => 400 ) );
		}
		$key = 'ts_booking_' . md5( sanitize_email( $request['email'] ) . '|' . ( $_SERVER['REMOTE_ADDR'] ?? '' ) );
		if ( get_transient( $key ) ) {
			return new WP_Error( 'ts_booking_rate_limited', __( 'Please wait before submitting another request.', 'tanzania-sensational' ), array( 'status' => 429 ) );
		}
		set_transient( $key, 1, MINUTE_IN_SECONDS );
		return true;
	}

	private static function creation_response( $booking ) {
		if ( is_wp_error( $booking ) ) {
			return $booking;
		}
		self::send_notifications( $booking );
		return new WP_REST_Response( array(
			'message'     => __( 'Thank you. We will contact you shortly to confirm the details and arrange payment.', 'tanzania-sensational' ),
			'booking_ref' => $booking->booking_ref,
			'status'      => $booking->status,
		), 201 );
	}

	private static function send_notifications( $booking ) {
		$subject = sprintf( '[%s] New booking request', $booking->booking_ref );
		$body    = sprintf( "Reference: %s\nName: %s\nEmail: %s\nPhone: %s\nGroup size: %d\nType: %s\n", $booking->booking_ref, $booking->customer_name, $booking->email, $booking->phone, $booking->group_size, $booking->booking_type );
		wp_mail( get_option( 'admin_email' ), $subject, $body );
		wp_mail( $booking->email, sprintf( 'Your Tanzania Sensational request — %s', $booking->booking_ref ), "Thank you for your request.\n\nYour reference is {$booking->booking_ref}. Our team will contact you shortly. No payment has been taken." );
	}
}
