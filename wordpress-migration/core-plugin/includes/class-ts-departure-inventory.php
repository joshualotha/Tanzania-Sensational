<?php
/**
 * Validated management operations for scheduled departure inventory.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class TS_Departure_Inventory {
	public static function save( $id, $input ) {
		$data = self::validate( $input );
		if ( is_wp_error( $data ) ) {
			return $data;
		}

		global $wpdb;
		$table = $wpdb->prefix . 'ts_departures';
		$id    = absint( $id );

		return self::transaction( function() use ( $wpdb, $table, $id, $data ) {
			$now = current_time( 'mysql', true );
			if ( $id > 0 ) {
				$current = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d FOR UPDATE", $id ) );
				if ( ! $current ) {
					return new WP_Error( 'ts_departure_not_found', __( 'Departure not found.', 'tanzania-sensational' ) );
				}

				$reserved = (int) $current->booked_seats + (int) $current->held_seats;
				if ( $data['total_seats'] < $reserved ) {
					return new WP_Error( 'ts_capacity_below_reservations', __( 'Capacity cannot be lower than seats already booked or held.', 'tanzania-sensational' ) );
				}

				$remaining = $data['total_seats'] - $reserved;
				$updates   = array_merge( $data, array(
					'status'     => self::status_for( $data['inventory_state'], $remaining ),
					'updated_at' => $now,
				) );
				unset( $updates['inventory_state'] );

				if ( false === $wpdb->update( $table, $updates, array( 'id' => $id ) ) ) {
					return new WP_Error( 'ts_departure_update_failed', __( 'The departure could not be updated.', 'tanzania-sensational' ) );
				}
				return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ) );
			}

			$insert = array_merge( $data, array(
				'source_post_id' => null,
				'booked_seats'   => 0,
				'held_seats'     => 0,
				'status'         => self::status_for( $data['inventory_state'], $data['total_seats'] ),
				'created_at'     => $now,
				'updated_at'     => $now,
			) );
			unset( $insert['inventory_state'] );

			if ( false === $wpdb->insert( $table, $insert ) ) {
				return new WP_Error( 'ts_departure_insert_failed', __( 'The departure could not be created.', 'tanzania-sensational' ) );
			}
			$new_id = (int) $wpdb->insert_id;
			return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $new_id ) );
		} );
	}

	public static function close( $id ) {
		global $wpdb;
		$table = $wpdb->prefix . 'ts_departures';
		$id    = absint( $id );
		if ( $id < 1 ) {
			return new WP_Error( 'ts_departure_not_found', __( 'Departure not found.', 'tanzania-sensational' ) );
		}

		return self::transaction( function() use ( $wpdb, $table, $id ) {
			$current = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d FOR UPDATE", $id ) );
			if ( ! $current ) {
				return new WP_Error( 'ts_departure_not_found', __( 'Departure not found.', 'tanzania-sensational' ) );
			}
			if ( false === $wpdb->update( $table, array(
				'status'     => 'closed',
				'updated_at' => current_time( 'mysql', true ),
			), array( 'id' => $id ) ) ) {
				return new WP_Error( 'ts_departure_update_failed', __( 'The departure could not be closed.', 'tanzania-sensational' ) );
			}
			return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ) );
		} );
	}

	public static function validate( $input ) {
		$input = is_array( $input ) ? $input : array();
		$name  = sanitize_text_field( $input['route_name'] ?? '' );
		if ( '' === $name || strlen( $name ) > 255 ) {
			return new WP_Error( 'ts_invalid_route_name', __( 'Enter a route name of 1–255 characters.', 'tanzania-sensational' ) );
		}

		$route_url = trim( (string) ( $input['route_url'] ?? '' ) );
		if ( '' !== $route_url && ( strlen( $route_url ) > 500 || ! self::is_local_url( $route_url ) ) ) {
			return new WP_Error( 'ts_invalid_route_url', __( 'Route links must be valid, no longer than 500 characters, and point to this website.', 'tanzania-sensational' ) );
		}
		if ( '' !== $route_url ) {
			$route_url = esc_url_raw( $route_url );
			if ( '' === $route_url ) {
				return new WP_Error( 'ts_invalid_route_url', __( 'Enter a valid route link.', 'tanzania-sensational' ) );
			}
		}

		$departure_date = self::valid_date( $input['departure_date'] ?? '' );
		if ( ! $departure_date ) {
			return new WP_Error( 'ts_invalid_departure_date', __( 'Enter a valid departure date.', 'tanzania-sensational' ) );
		}
		$return_date = trim( (string) ( $input['return_date'] ?? '' ) );
		if ( '' !== $return_date ) {
			$return_date = self::valid_date( $return_date );
			if ( ! $return_date || $return_date <= $departure_date ) {
				return new WP_Error( 'ts_invalid_return_date', __( 'Return date must be valid and after the departure date.', 'tanzania-sensational' ) );
			}
		}

		$price = trim( (string) ( $input['price'] ?? '' ) );
		if ( ! preg_match( '/^\d{1,9}(?:\.\d{1,2})?$/', $price ) ) {
			return new WP_Error( 'ts_invalid_departure_price', __( 'Enter a non-negative price with up to two decimal places.', 'tanzania-sensational' ) );
		}
		$parts      = explode( '.', $price, 2 );
		$price_cents = ( (int) $parts[0] * 100 ) + ( isset( $parts[1] ) ? (int) str_pad( $parts[1], 2, '0' ) : 0 );

		$currency = strtoupper( trim( (string) ( $input['currency'] ?? '' ) ) );
		if ( ! preg_match( '/^[A-Z]{3}$/', $currency ) ) {
			return new WP_Error( 'ts_invalid_departure_currency', __( 'Currency must be a three-letter code.', 'tanzania-sensational' ) );
		}

		$total_seats = filter_var( $input['total_seats'] ?? null, FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1, 'max_range' => 250 ) ) );
		if ( false === $total_seats ) {
			return new WP_Error( 'ts_invalid_departure_capacity', __( 'Capacity must be a whole number from 1 to 250.', 'tanzania-sensational' ) );
		}

		$inventory_state = sanitize_key( $input['inventory_state'] ?? 'open' );
		if ( ! in_array( $inventory_state, array( 'open', 'closed' ), true ) ) {
			return new WP_Error( 'ts_invalid_departure_state', __( 'Choose open or closed inventory.', 'tanzania-sensational' ) );
		}

		return array(
			'route_name'     => $name,
			'route_url'      => $route_url ?: null,
			'departure_date' => $departure_date,
			'return_date'    => $return_date ?: null,
			'price_cents'    => $price_cents,
			'currency'       => $currency,
			'total_seats'    => (int) $total_seats,
			'inventory_state'=> $inventory_state,
		);
	}

	private static function valid_date( $value ) {
		$value = trim( (string) $value );
		if ( ! preg_match( '/^\d{4}-\d{2}-\d{2}$/', $value ) ) {
			return false;
		}
		list( $year, $month, $day ) = array_map( 'intval', explode( '-', $value ) );
		return checkdate( $month, $day, $year ) ? $value : false;
	}

	private static function is_local_url( $url ) {
		if ( preg_match( '/[\\\\\x00-\x20]/', $url ) ) {
			return false;
		}
		$parts = wp_parse_url( $url );
		if ( false === $parts ) {
			return false;
		}
		if ( empty( $parts['host'] ) ) {
			return isset( $url[0] ) && '/' === $url[0] && ( ! isset( $url[1] ) || '/' !== $url[1] );
		}
		$site_host = strtolower( (string) wp_parse_url( home_url( '/' ), PHP_URL_HOST ) );
		return strtolower( (string) $parts['host'] ) === $site_host && in_array( strtolower( (string) ( $parts['scheme'] ?? 'https' ) ), array( 'http', 'https' ), true );
	}

	private static function status_for( $inventory_state, $remaining ) {
		if ( 'closed' === $inventory_state ) {
			return 'closed';
		}
		return $remaining <= 0 ? 'full' : ( $remaining <= 3 ? 'limited' : 'available' );
	}

	private static function transaction( $callback ) {
		global $wpdb;

		if ( false === $wpdb->query( 'START TRANSACTION' ) ) {
			return new WP_Error( 'ts_departure_transaction_start_failed', __( 'The departure could not be saved. Please retry.', 'tanzania-sensational' ) );
		}

		try {
			$result = $callback();
			if ( is_wp_error( $result ) || null === $result ) {
				if ( false === $wpdb->query( 'ROLLBACK' ) ) {
					return new WP_Error( 'ts_departure_rollback_failed', __( 'The departure could not be saved. Please check its status before retrying.', 'tanzania-sensational' ) );
				}
				return $result ?: new WP_Error( 'ts_departure_save_failed', __( 'The departure could not be saved.', 'tanzania-sensational' ) );
			}

			if ( false === $wpdb->query( 'COMMIT' ) ) {
				$wpdb->query( 'ROLLBACK' );
				return new WP_Error( 'ts_departure_commit_failed', __( 'The departure could not be confirmed as saved. Please check its status before retrying.', 'tanzania-sensational' ) );
			}
			return $result;
		} catch ( Throwable $error ) {
			$wpdb->query( 'ROLLBACK' );
			return new WP_Error( 'ts_departure_transaction_failed', __( 'The departure could not be saved. Please retry.', 'tanzania-sensational' ) );
		}
	}
}
