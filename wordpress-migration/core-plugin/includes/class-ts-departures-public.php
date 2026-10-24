<?php
/**
 * Public departure inventory and booking form.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class TS_Departures_Public {
	public static function enqueue_assets() {
		if ( is_page( 'group-departures' ) ) {
			wp_enqueue_style( 'ts-core-departures', plugins_url( 'assets/departures.css', TS_CORE_FILE ), array(), TS_CORE_VERSION );
			wp_enqueue_script( 'ts-core-departures', plugins_url( 'assets/departures.js', TS_CORE_FILE ), array(), TS_CORE_VERSION, true );
		}
	}

	public static function get_available_departures( $limit = 0 ) {
		global $wpdb;

		$table = $wpdb->prefix . 'ts_departures';
		$sql   = "SELECT * FROM {$table}
			WHERE departure_date >= %s
			AND status IN ('available', 'limited')
			AND total_seats > booked_seats + held_seats
			ORDER BY departure_date ASC, id ASC";
		$args  = array( current_time( 'Y-m-d' ) );

		if ( (int) $limit > 0 ) {
			$sql    .= ' LIMIT %d';
			$args[]  = absint( $limit );
		}

		$departures = $wpdb->get_results( $wpdb->prepare( $sql, ...$args ) );
		return is_array( $departures ) ? $departures : array();
	}

	public static function render() {
		$departures = self::get_available_departures();
		ob_start();
		?>
		<main class="ts-departures-page">
			<header class="ts-departures-hero"><span><?php esc_html_e( 'Climb Together', 'tanzania-sensational' ); ?></span><h1><?php esc_html_e( 'Kilimanjaro Group Departures', 'tanzania-sensational' ); ?></h1><p><?php esc_html_e( 'Join a small team on a scheduled climb. Choose a date below and we will hold your places for 36 hours while our team confirms every detail.', 'tanzania-sensational' ); ?></p></header>
			<section class="ts-departure-grid" aria-label="<?php esc_attr_e( 'Available departures', 'tanzania-sensational' ); ?>">
			<?php if ( ! $departures ) : ?><p class="ts-departure-empty"><?php esc_html_e( 'New departure dates are being prepared. Please contact us for a private climb.', 'tanzania-sensational' ); ?></p><?php endif; ?>
			<?php foreach ( $departures as $departure ) : $remaining = max( 0, (int) $departure->total_seats - (int) $departure->booked_seats - (int) $departure->held_seats ); ?>
				<article class="ts-departure-card">
					<div><span class="ts-departure-date"><?php echo esc_html( date_i18n( 'M j, Y', strtotime( $departure->departure_date ) ) ); ?></span><h2><?php echo esc_html( $departure->route_name ); ?></h2></div>
					<div class="ts-departure-meta"><span><?php echo esc_html( sprintf( _n( '%d place left', '%d places left', $remaining, 'tanzania-sensational' ), $remaining ) ); ?></span><strong><?php echo esc_html( $departure->currency . ' ' . number_format_i18n( $departure->price_cents / 100, 0 ) ); ?> <small><?php esc_html_e( 'per person', 'tanzania-sensational' ); ?></small></strong></div>
					<button type="button" class="ts-departure-select" data-departure-id="<?php echo esc_attr( $departure->id ); ?>" data-departure-label="<?php echo esc_attr( $departure->route_name . ' — ' . date_i18n( 'M j, Y', strtotime( $departure->departure_date ) ) ); ?>"><?php esc_html_e( 'Request Places', 'tanzania-sensational' ); ?></button>
				</article>
			<?php endforeach; ?>
			</section>
			<section class="ts-departure-form-panel" id="ts-departure-booking" hidden>
				<h2><?php esc_html_e( 'Request your places', 'tanzania-sensational' ); ?></h2><p data-ts-selected-departure></p>
				<form data-ts-departure-form data-endpoint="<?php echo esc_url( rest_url( 'ts/v1/bookings/departure' ) ); ?>">
					<input type="hidden" name="departure_id" value=""><div class="ts-honeypot" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
					<div class="ts-departure-fields">
						<label><span><?php esc_html_e( 'Full name', 'tanzania-sensational' ); ?> *</span><input name="customer_name" type="text" autocomplete="name" required></label><label><span><?php esc_html_e( 'Email', 'tanzania-sensational' ); ?> *</span><input name="email" type="email" autocomplete="email" required></label>
						<label><span><?php esc_html_e( 'Phone / WhatsApp', 'tanzania-sensational' ); ?></span><input name="phone" type="tel" autocomplete="tel"></label><label><span><?php esc_html_e( 'Country', 'tanzania-sensational' ); ?></span><input name="country" type="text" autocomplete="country-name"></label>
						<label><span><?php esc_html_e( 'Group size', 'tanzania-sensational' ); ?> *</span><input name="group_size" type="number" min="1" max="20" value="1" required></label>
					</div>
					<label class="ts-departure-wide"><span><?php esc_html_e( 'Special requests', 'tanzania-sensational' ); ?></span><textarea name="special_requests" rows="4"></textarea></label>
					<button type="submit"><?php esc_html_e( 'Hold Places & Send Request', 'tanzania-sensational' ); ?></button><p class="ts-departure-note"><?php esc_html_e( 'No payment is taken online. A temporary 36-hour hold is created while our team contacts you.', 'tanzania-sensational' ); ?></p><div data-ts-departure-message role="status" aria-live="polite"></div>
				</form>
			</section>
		</main>
		<?php
		return ob_get_clean();
	}
}
