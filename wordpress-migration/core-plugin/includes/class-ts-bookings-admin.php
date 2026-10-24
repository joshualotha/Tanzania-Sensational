<?php
/**
 * Minimal protected operations screen for booking requests.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class TS_Bookings_Admin {
	public static function register_menu() {
		add_menu_page( __( 'Bookings', 'tanzania-sensational' ), __( 'Bookings', 'tanzania-sensational' ), 'manage_options', 'ts-bookings', array( __CLASS__, 'render' ), 'dashicons-calendar-alt', 24 );
	}

	public static function render() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You are not allowed to view bookings.', 'tanzania-sensational' ) );
		}
		global $wpdb;
		$table = $wpdb->prefix . 'ts_bookings';
		$rows  = $wpdb->get_results( "SELECT * FROM {$table} ORDER BY created_at DESC LIMIT 100" );
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Bookings', 'tanzania-sensational' ); ?></h1>
			<?php if ( isset( $_GET['updated'] ) ) : ?>
				<div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Booking status updated.', 'tanzania-sensational' ); ?></p></div>
			<?php endif; ?>
			<table class="widefat striped">
				<thead><tr><th><?php esc_html_e( 'Reference', 'tanzania-sensational' ); ?></th><th><?php esc_html_e( 'Customer', 'tanzania-sensational' ); ?></th><th><?php esc_html_e( 'Request', 'tanzania-sensational' ); ?></th><th><?php esc_html_e( 'Price', 'tanzania-sensational' ); ?></th><th><?php esc_html_e( 'Status', 'tanzania-sensational' ); ?></th><th><?php esc_html_e( 'Received', 'tanzania-sensational' ); ?></th></tr></thead>
				<tbody>
				<?php if ( ! $rows ) : ?><tr><td colspan="6"><?php esc_html_e( 'No booking requests yet.', 'tanzania-sensational' ); ?></td></tr><?php endif; ?>
				<?php foreach ( $rows as $row ) : ?>
					<tr>
						<td><strong><?php echo esc_html( $row->booking_ref ); ?></strong></td>
						<td><?php echo esc_html( $row->customer_name ); ?><br><a href="mailto:<?php echo esc_attr( $row->email ); ?>"><?php echo esc_html( $row->email ); ?></a><br><?php echo esc_html( $row->phone ); ?></td>
						<td><?php echo esc_html( ucfirst( $row->booking_type ) ); ?> · <?php echo esc_html( $row->group_size ); ?> pax<br><?php echo esc_html( $row->preferred_date ); ?></td>
						<td><?php echo esc_html( $row->currency . ' ' . number_format( $row->total_price_cents / 100, 2 ) ); ?></td>
						<td>
							<form action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
								<input type="hidden" name="action" value="ts_update_booking_status">
								<input type="hidden" name="booking_id" value="<?php echo esc_attr( $row->id ); ?>">
								<?php wp_nonce_field( 'ts_update_booking_' . $row->id ); ?>
								<select name="status" aria-label="<?php esc_attr_e( 'Booking status', 'tanzania-sensational' ); ?>">
								<?php foreach ( array( 'new', 'contacted', 'confirmed', 'cancelled' ) as $status ) : ?><option value="<?php echo esc_attr( $status ); ?>" <?php selected( $row->status, $status ); ?>><?php echo esc_html( ucfirst( $status ) ); ?></option><?php endforeach; ?>
								</select>
								<button class="button"><?php esc_html_e( 'Update', 'tanzania-sensational' ); ?></button>
							</form>
						</td>
						<td><?php echo esc_html( get_date_from_gmt( $row->created_at, 'Y-m-d H:i' ) ); ?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php
	}

	public static function update_status() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You are not allowed to update bookings.', 'tanzania-sensational' ) );
		}
		$id = isset( $_POST['booking_id'] ) ? absint( $_POST['booking_id'] ) : 0;
		check_admin_referer( 'ts_update_booking_' . $id );
		$status = isset( $_POST['status'] ) ? sanitize_key( wp_unslash( $_POST['status'] ) ) : '';
		$result = TS_Booking_Workflow::transition_status( $id, $status );
		if ( is_wp_error( $result ) ) {
			wp_die( esc_html( $result->get_error_message() ) );
		}
		wp_safe_redirect( add_query_arg( 'updated', '1', admin_url( 'admin.php?page=ts-bookings' ) ) );
		exit;
	}
}
