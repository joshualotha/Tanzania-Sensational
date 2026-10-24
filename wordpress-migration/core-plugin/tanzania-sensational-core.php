<?php
/**
 * Plugin Name: Tanzania Sensational — Core
 * Description: Business workflows for bookings, departures, pricing, and operations.
 * Version: 0.5.0
 * Author: Migration Team
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'TS_CORE_VERSION', '0.5.0' );
define( 'TS_CORE_FILE', __FILE__ );
define( 'TS_CORE_DIR', plugin_dir_path( __FILE__ ) );

require_once TS_CORE_DIR . 'includes/class-ts-core-installer.php';
require_once TS_CORE_DIR . 'includes/class-ts-booking-workflow.php';
require_once TS_CORE_DIR . 'includes/class-ts-departure-inventory.php';
require_once TS_CORE_DIR . 'includes/class-ts-booking-rest-controller.php';
require_once TS_CORE_DIR . 'includes/class-ts-bookings-admin.php';
require_once TS_CORE_DIR . 'includes/class-ts-departures-admin.php';
require_once TS_CORE_DIR . 'includes/class-ts-departures-public.php';

register_activation_hook( TS_CORE_FILE, array( 'TS_Core_Installer', 'activate' ) );
register_deactivation_hook( TS_CORE_FILE, array( 'TS_Core_Installer', 'deactivate' ) );

add_action( 'plugins_loaded', array( 'TS_Core_Installer', 'maybe_upgrade' ) );
add_action( 'ts_release_expired_booking_holds', array( 'TS_Booking_Workflow', 'release_expired_holds' ) );
add_action( 'rest_api_init', array( 'TS_Booking_REST_Controller', 'register_routes' ) );
add_action( 'admin_menu', array( 'TS_Bookings_Admin', 'register_menu' ) );
add_action( 'admin_menu', array( 'TS_Departures_Admin', 'register_menu' ) );
add_action( 'admin_post_ts_update_booking_status', array( 'TS_Bookings_Admin', 'update_status' ) );
add_action( 'admin_post_ts_save_departure', array( 'TS_Departures_Admin', 'save_request' ) );
add_action( 'admin_post_ts_close_departure', array( 'TS_Departures_Admin', 'close_request' ) );
add_shortcode( 'ts_group_departures', array( 'TS_Departures_Public', 'render' ) );
add_action( 'wp_enqueue_scripts', array( 'TS_Departures_Public', 'enqueue_assets' ) );
