<?php
/**
 * Transactional seat reconciliation for departure booking holds.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class TS_Booking_Workflow {
	const HOLD_HOURS = 36;

	public static function create_departure_booking( $data ) {
		$group_size = filter_var( $data['group_size'] ?? null, FILTER_VALIDATE_INT );
		if ( false === $group_size || $group_size < 1 || $group_size > 20 ) {
			return new WP_Error( 'ts_invalid_group_size', __( 'Group size must be between 1 and 20.', 'tanzania-sensational' ), array( 'status' => 400 ) );
		}

		global $wpdb;

		return self::transaction( function() use ( $wpdb, $data, $group_size ) {
			$departures = $wpdb->prefix . 'ts_departures';
			$bookings   = $wpdb->prefix . 'ts_bookings';
			$departure  = $wpdb->get_row(
				$wpdb->prepare( "SELECT * FROM {$departures} WHERE id = %d FOR UPDATE", $data['departure_id'] )
			);

			if ( ! $departure ) {
				return new WP_Error( 'ts_departure_not_found', __( 'Departure not found.', 'tanzania-sensational' ), array( 'status' => 404 ) );
			}

			if ( ! in_array( strtolower( (string) $departure->status ), array( 'available', 'limited' ), true ) || (string) $departure->departure_date < current_time( 'Y-m-d' ) ) {
				return new WP_Error( 'ts_departure_unavailable', __( 'This departure is no longer available.', 'tanzania-sensational' ), array( 'status' => 409 ) );
			}

			$remaining  = max( 0, (int) $departure->total_seats - (int) $departure->booked_seats - (int) $departure->held_seats );
			if ( $remaining < $group_size ) {
				return new WP_Error( 'ts_insufficient_seats', __( 'Not enough seats are available for this departure.', 'tanzania-sensational' ), array( 'status' => 409 ) );
			}

			$now         = current_time( 'mysql', true );
			$booking_ref = self::generate_booking_ref();
			$inserted    = $wpdb->insert(
				$bookings,
				array(
					'booking_ref'      => $booking_ref,
					'booking_type'     => 'departure',
					'departure_id'     => (int) $departure->id,
					'customer_name'    => $data['customer_name'],
					'email'            => $data['email'],
					'phone'            => $data['phone'],
					'country'          => $data['country'],
					'group_size'       => $group_size,
					'held_seats'       => $group_size,
					'hold_expires_at'  => gmdate( 'Y-m-d H:i:s', time() + self::HOLD_HOURS * HOUR_IN_SECONDS ),
					'total_price_cents'=> (int) $departure->price_cents * $group_size,
					'currency'         => $departure->currency,
					'status'           => 'new',
					'special_requests' => $data['special_requests'],
					'created_at'       => $now,
					'updated_at'       => $now,
				)
			);

			if ( false === $inserted ) {
				return new WP_Error( 'ts_booking_insert_failed', __( 'The booking request could not be saved.', 'tanzania-sensational' ), array( 'status' => 500 ) );
			}

			$held      = (int) $departure->held_seats + $group_size;
			$remaining = max( 0, (int) $departure->total_seats - (int) $departure->booked_seats - $held );
			if ( false === $wpdb->update(
				$departures,
				array(
					'held_seats' => $held,
					'status'     => self::availability_status( $remaining ),
					'updated_at' => $now,
				),
				array( 'id' => (int) $departure->id )
			) ) {
				return new WP_Error( 'ts_departure_update_failed', __( 'The departure availability could not be updated.', 'tanzania-sensational' ), array( 'status' => 500 ) );
			}

			return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$bookings} WHERE id = %d", $wpdb->insert_id ) );
		} );
	}

	public static function create_safari_booking( $data ) {
		global $wpdb;

		$tour = get_post( $data['tour_post_id'] );
		if ( ! $tour || 'ts_tour' !== $tour->post_type || 'publish' !== $tour->post_status ) {
			return new WP_Error( 'ts_tour_not_found', __( 'Safari package not found.', 'tanzania-sensational' ), array( 'status' => 404 ) );
		}

		$price       = get_post_meta( $tour->ID, 'ts_tour_price', true );
		$price_value = (float) preg_replace( '/[^0-9.]/', '', (string) $price );
		$now         = current_time( 'mysql', true );
		$bookings    = $wpdb->prefix . 'ts_bookings';
		$inserted    = $wpdb->insert(
			$bookings,
			array(
				'booking_ref'       => self::generate_booking_ref(),
				'booking_type'      => 'safari',
				'tour_post_id'      => (int) $tour->ID,
				'customer_name'     => $data['customer_name'],
				'email'             => $data['email'],
				'phone'             => $data['phone'],
				'country'           => $data['country'],
				'group_size'        => (int) $data['group_size'],
				'total_price_cents' => (int) round( $price_value * 100 ) * (int) $data['group_size'],
				'currency'          => 'USD',
				'status'            => 'new',
				'preferred_date'    => $data['preferred_date'],
				'special_requests'  => $data['special_requests'],
				'created_at'        => $now,
				'updated_at'        => $now,
			)
		);

		if ( false === $inserted ) {
			return new WP_Error( 'ts_booking_insert_failed', __( 'The booking request could not be saved.', 'tanzania-sensational' ), array( 'status' => 500 ) );
		}

		return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$bookings} WHERE id = %d", $wpdb->insert_id ) );
	}

	public static function release_expired_holds() {
		global $wpdb;

		$bookings = $wpdb->prefix . 'ts_bookings';
		$now      = current_time( 'mysql', true );
		$ids      = $wpdb->get_col(
			$wpdb->prepare(
				"SELECT id FROM {$bookings}
				 WHERE status IN ('new', 'contacted')
				 AND held_seats > 0
				 AND hold_expires_at IS NOT NULL
				 AND hold_expires_at < %s",
				$now
			)
		);

		$released = 0;
		foreach ( array_map( 'intval', $ids ) as $booking_id ) {
			$result = self::expire_hold( $booking_id );
			if ( $result && ! is_wp_error( $result ) ) {
				++$released;
			}
		}

		return $released;
	}

	public static function transition_status( $booking_id, $new_status, $require_expired_hold = false ) {
		global $wpdb;

		$allowed = array( 'new', 'contacted', 'confirmed', 'cancelled' );
		$status  = strtolower( sanitize_key( $new_status ) );
		if ( ! in_array( $status, $allowed, true ) ) {
			return new WP_Error( 'ts_invalid_booking_status', __( 'Invalid booking status.', 'tanzania-sensational' ) );
		}

		return self::transaction( function() use ( $wpdb, $booking_id, $status, $require_expired_hold ) {
			$bookings  = $wpdb->prefix . 'ts_bookings';
			$departures = $wpdb->prefix . 'ts_departures';
			$booking   = $wpdb->get_row(
				$wpdb->prepare( "SELECT * FROM {$bookings} WHERE id = %d FOR UPDATE", $booking_id )
			);

			if ( ! $booking ) {
				return new WP_Error( 'ts_booking_not_found', __( 'Booking not found.', 'tanzania-sensational' ) );
			}

			$transitions = array(
				'new'       => array( 'new', 'contacted', 'confirmed', 'cancelled' ),
				'contacted' => array( 'contacted', 'confirmed', 'cancelled' ),
				'confirmed' => array( 'confirmed', 'cancelled' ),
				'cancelled' => array( 'cancelled' ),
			);
			$current_status = strtolower( (string) $booking->status );
			if ( $require_expired_hold && ( ! in_array( $current_status, array( 'new', 'contacted' ), true ) || empty( $booking->hold_expires_at ) || (string) $booking->hold_expires_at >= current_time( 'mysql', true ) ) ) {
				return false;
			}

			if ( ! isset( $transitions[ $current_status ] ) || ! in_array( $status, $transitions[ $current_status ], true ) ) {
				return new WP_Error(
					'ts_invalid_booking_transition',
					sprintf(
						/* translators: 1: current booking status, 2: requested booking status. */
						__( 'A booking cannot move from %1$s to %2$s.', 'tanzania-sensational' ),
						$current_status,
						$status
					)
				);
			}

			$now     = current_time( 'mysql', true );
			$updates = array( 'status' => $status, 'updated_at' => $now );

			if ( 'departure' === $booking->booking_type && $booking->departure_id ) {
				$departure = $wpdb->get_row(
					$wpdb->prepare( "SELECT * FROM {$departures} WHERE id = %d FOR UPDATE", $booking->departure_id )
				);

				if ( ! $departure ) {
					return new WP_Error( 'ts_departure_not_found', __( 'Departure not found.', 'tanzania-sensational' ) );
				}

				$held   = (int) $booking->held_seats;
				$booked = (int) $departure->booked_seats;
				$dheld  = (int) $departure->held_seats;

				if ( 'contacted' === $status ) {
					$updates['last_contacted_at'] = $now;
					if ( $held > 0 ) {
						$updates['hold_expires_at'] = gmdate( 'Y-m-d H:i:s', time() + self::HOLD_HOURS * HOUR_IN_SECONDS );
					}
				} elseif ( 'confirmed' === $status && 'confirmed' !== $booking->status ) {
					if ( $held > 0 ) {
						$dheld                         = max( 0, $dheld - $held );
						$booked                       += $held;
						$updates['held_seats']         = 0;
						$updates['hold_expires_at']    = null;
					}
				} elseif ( 'cancelled' === $status && 'cancelled' !== $booking->status ) {
					if ( $held > 0 ) {
						$dheld                      = max( 0, $dheld - $held );
						$updates['held_seats']      = 0;
						$updates['hold_expires_at'] = null;
					}
					if ( 'confirmed' === $booking->status ) {
						$booked = max( 0, $booked - (int) $booking->group_size );
					}
				}

				$remaining  = max( 0, (int) $departure->total_seats - $booked - $dheld );
				$dep_status = 'closed' === strtolower( (string) $departure->status ) ? 'closed' : self::availability_status( $remaining );
				if ( false === $wpdb->update(
					$departures,
					array( 'booked_seats' => $booked, 'held_seats' => $dheld, 'status' => $dep_status, 'updated_at' => $now ),
					array( 'id' => (int) $departure->id )
				) ) {
					return new WP_Error( 'ts_departure_update_failed', __( 'The departure availability could not be updated.', 'tanzania-sensational' ) );
				}
			}

			if ( false === $wpdb->update( $bookings, $updates, array( 'id' => (int) $booking->id ) ) ) {
				return new WP_Error( 'ts_booking_update_failed', __( 'The booking status could not be updated.', 'tanzania-sensational' ) );
			}
			return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$bookings} WHERE id = %d", $booking->id ) );
		} );
	}

	private static function expire_hold( $booking_id ) {
		return self::transition_status( $booking_id, 'cancelled', true );
	}

	private static function availability_status( $remaining ) {
		return 0 === (int) $remaining ? 'full' : ( $remaining <= 3 ? 'limited' : 'available' );
	}

	private static function generate_booking_ref() {
		return 'TS-' . strtoupper( wp_generate_password( 8, false, false ) );
	}

	private static function transaction( $callback ) {
		global $wpdb;

		if ( false === $wpdb->query( 'START TRANSACTION' ) ) {
			return new WP_Error( 'ts_booking_transaction_start_failed', __( 'The booking could not be processed. Please retry.', 'tanzania-sensational' ) );
		}

		try {
			$result = $callback();
			if ( is_wp_error( $result ) || false === $result || null === $result ) {
				if ( false === $wpdb->query( 'ROLLBACK' ) ) {
					return new WP_Error( 'ts_booking_rollback_failed', __( 'The booking could not be processed. Please contact support before retrying.', 'tanzania-sensational' ) );
				}
				if ( null === $result ) {
					return new WP_Error( 'ts_booking_transaction_empty', __( 'The booking could not be processed. Please retry.', 'tanzania-sensational' ) );
				}
				return $result;
			}

			if ( false === $wpdb->query( 'COMMIT' ) ) {
				$wpdb->query( 'ROLLBACK' );
				return new WP_Error( 'ts_booking_commit_failed', __( 'The booking could not be confirmed as saved. Please check its status before retrying.', 'tanzania-sensational' ) );
			}
			return $result;
		} catch ( Throwable $error ) {
			$wpdb->query( 'ROLLBACK' );
			return new WP_Error( 'ts_booking_transaction_failed', __( 'The booking could not be processed. Please retry.', 'tanzania-sensational' ) );
		}
	}
}
