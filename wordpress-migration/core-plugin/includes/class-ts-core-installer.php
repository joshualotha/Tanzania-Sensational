<?php
/**
 * Database installation and scheduled-job registration.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class TS_Core_Installer {
	const DB_VERSION_OPTION = 'ts_core_db_version';
	const DB_VERSION        = '2';
	const CRON_HOOK         = 'ts_release_expired_booking_holds';

	public static function activate() {
		self::install_schema();
		self::schedule_jobs();
	}

	public static function deactivate() {
		wp_clear_scheduled_hook( self::CRON_HOOK );
	}

	public static function maybe_upgrade() {
		if ( self::DB_VERSION !== get_option( self::DB_VERSION_OPTION ) ) {
			self::install_schema();
		}

		self::schedule_jobs();
	}

	private static function install_schema() {
		global $wpdb;

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		$charset_collate = $wpdb->get_charset_collate();
		$departures      = $wpdb->prefix . 'ts_departures';
		$bookings        = $wpdb->prefix . 'ts_bookings';

		$sql_departures = "CREATE TABLE {$departures} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			source_post_id bigint(20) unsigned DEFAULT NULL,
			route_name varchar(255) NOT NULL,
			route_url varchar(500) DEFAULT NULL,
			departure_date date NOT NULL,
			return_date date DEFAULT NULL,
			price_cents bigint(20) unsigned NOT NULL DEFAULT 0,
			currency char(3) NOT NULL DEFAULT 'USD',
			total_seats smallint(5) unsigned NOT NULL DEFAULT 12,
			booked_seats smallint(5) unsigned NOT NULL DEFAULT 0,
			held_seats smallint(5) unsigned NOT NULL DEFAULT 0,
			status varchar(20) NOT NULL DEFAULT 'available',
			created_at datetime NOT NULL,
			updated_at datetime NOT NULL,
			PRIMARY KEY  (id),
			UNIQUE KEY source_post_id (source_post_id),
			KEY departure_date (departure_date),
			KEY status (status)
		) {$charset_collate};";

		$sql_bookings = "CREATE TABLE {$bookings} (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			booking_ref varchar(20) NOT NULL,
			booking_type varchar(20) NOT NULL,
			departure_id bigint(20) unsigned DEFAULT NULL,
			tour_post_id bigint(20) unsigned DEFAULT NULL,
			customer_name varchar(255) NOT NULL,
			email varchar(255) NOT NULL,
			phone varchar(50) DEFAULT NULL,
			country varchar(100) DEFAULT NULL,
			group_size smallint(5) unsigned NOT NULL DEFAULT 1,
			held_seats smallint(5) unsigned NOT NULL DEFAULT 0,
			hold_expires_at datetime DEFAULT NULL,
			last_contacted_at datetime DEFAULT NULL,
			total_price_cents bigint(20) unsigned NOT NULL DEFAULT 0,
			currency char(3) NOT NULL DEFAULT 'USD',
			status varchar(20) NOT NULL DEFAULT 'new',
			preferred_date varchar(100) DEFAULT NULL,
			special_requests text DEFAULT NULL,
			notes longtext DEFAULT NULL,
			created_at datetime NOT NULL,
			updated_at datetime NOT NULL,
			PRIMARY KEY  (id),
			UNIQUE KEY booking_ref (booking_ref),
			KEY departure_id (departure_id),
			KEY tour_post_id (tour_post_id),
			KEY status (status),
			KEY hold_expires_at (hold_expires_at),
			KEY email (email)
		) {$charset_collate};";

		dbDelta( $sql_departures );
		dbDelta( $sql_bookings );
		update_option( self::DB_VERSION_OPTION, self::DB_VERSION, false );
	}

	private static function schedule_jobs() {
		if ( ! wp_next_scheduled( self::CRON_HOOK ) ) {
			wp_schedule_event( time() + MINUTE_IN_SECONDS, 'hourly', self::CRON_HOOK );
		}
	}
}
