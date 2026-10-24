<?php
/**
 * Administrator screen for managing public group-departure inventory.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class TS_Departures_Admin {
	public static function register_menu() {
		add_menu_page(
			__( 'Group Departures', 'tanzania-sensational' ),
			__( 'Departures', 'tanzania-sensational' ),
			'manage_options',
			'ts-departures',
			array( __CLASS__, 'render' ),
			'dashicons-calendar-alt',
			25
		);
	}

	public static function render() {
		self::require_capability();
		global $wpdb;

		$table = $wpdb->prefix . 'ts_departures';
		$page  = isset( $_GET['paged'] ) ? max( 1, absint( wp_unslash( $_GET['paged'] ) ) ) : 1;
		$limit = 50;
		$total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );
		$pages = max( 1, (int) ceil( $total / $limit ) );
		$page  = min( $page, $pages );
		$offset = ( $page - 1 ) * $limit;
		$rows  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table} ORDER BY departure_date DESC, id DESC LIMIT %d OFFSET %d", $limit, $offset ) );
		$id    = isset( $_GET['edit'] ) ? absint( wp_unslash( $_GET['edit'] ) ) : 0;
		$item  = null;
		if ( $id ) {
			$item = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", $id ) );
			if ( ! $item ) {
				wp_die( esc_html__( 'Departure not found.', 'tanzania-sensational' ), '', array( 'response' => 404 ) );
			}
		}

		self::render_page_heading();
		self::render_form( $item );
		self::render_inventory_table( $rows, $page, $pages );
	}

	public static function save_request() {
		self::require_capability();
		check_admin_referer( 'ts_save_departure' );
		$id     = isset( $_POST['departure_id'] ) ? absint( wp_unslash( $_POST['departure_id'] ) ) : 0;
		$record = TS_Departure_Inventory::save( $id, wp_unslash( $_POST ) );
		if ( is_wp_error( $record ) ) {
			wp_die( esc_html( $record->get_error_message() ), '', array( 'response' => 400 ) );
		}
		self::return_to_page( $id ? 'updated' : 'created' );
	}

	public static function close_request() {
		self::require_capability();
		$id = isset( $_POST['departure_id'] ) ? absint( wp_unslash( $_POST['departure_id'] ) ) : 0;
		check_admin_referer( 'ts_close_departure_' . $id );
		$record = TS_Departure_Inventory::close( $id );
		if ( is_wp_error( $record ) ) {
			wp_die( esc_html( $record->get_error_message() ), '', array( 'response' => 400 ) );
		}
		self::return_to_page( 'closed' );
	}

	private static function require_capability() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You are not allowed to manage departures.', 'tanzania-sensational' ), '', array( 'response' => 403 ) );
		}
	}

	private static function render_page_heading() {
		$messages = array(
			'created' => __( 'Departure created.', 'tanzania-sensational' ),
			'updated' => __( 'Departure updated.', 'tanzania-sensational' ),
			'closed'  => __( 'Departure closed to new requests.', 'tanzania-sensational' ),
		);
		$notice = isset( $_GET['notice'] ) ? sanitize_key( wp_unslash( $_GET['notice'] ) ) : '';
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Group Departures', 'tanzania-sensational' ); ?></h1>
			<?php if ( isset( $messages[ $notice ] ) ) : ?><div class="notice notice-success is-dismissible"><p><?php echo esc_html( $messages[ $notice ] ); ?></p></div><?php endif; ?>
			<p><?php esc_html_e( 'Manage public departure dates, prices, and seat capacity. Booked and held seats are protected from capacity edits.', 'tanzania-sensational' ); ?></p>
		<?php
	}

	private static function render_form( $item ) {
		$id = $item ? (int) $item->id : 0;
		?>
		<h2><?php echo $item ? esc_html__( 'Edit departure', 'tanzania-sensational' ) : esc_html__( 'Add departure', 'tanzania-sensational' ); ?></h2>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="ts_save_departure">
			<input type="hidden" name="departure_id" value="<?php echo esc_attr( $id ); ?>">
			<?php wp_nonce_field( 'ts_save_departure' ); ?>
			<table class="form-table" role="presentation"><tbody>
				<?php self::text_field( 'route_name', __( 'Route name', 'tanzania-sensational' ), $item->route_name ?? '', 'text', true, 'maxlength="255"' ); ?>
				<?php self::text_field( 'route_url', __( 'Route page URL', 'tanzania-sensational' ), $item->route_url ?? '', 'text', false, 'inputmode="url" placeholder="/trekking/kilimanjaro/route-name"' ); ?>
				<?php self::text_field( 'departure_date', __( 'Departure date', 'tanzania-sensational' ), $item->departure_date ?? '', 'date', true ); ?>
				<?php self::text_field( 'return_date', __( 'Return date', 'tanzania-sensational' ), $item->return_date ?? '', 'date' ); ?>
				<?php self::text_field( 'price', __( 'Price per person', 'tanzania-sensational' ), $item ? number_format( $item->price_cents / 100, 2, '.', '' ) : '', 'number', true, 'min="0" max="999999999.99" step="0.01"' ); ?>
				<?php self::text_field( 'currency', __( 'Currency code', 'tanzania-sensational' ), $item->currency ?? 'USD', 'text', true, 'minlength="3" maxlength="3" pattern="[A-Za-z]{3}"' ); ?>
				<?php self::text_field( 'total_seats', __( 'Total seats', 'tanzania-sensational' ), $item->total_seats ?? 12, 'number', true, 'min="1" max="250" step="1"', $item ? sprintf( __( '%1$d booked and %2$d held.', 'tanzania-sensational' ), (int) $item->booked_seats, (int) $item->held_seats ) : '' ); ?>
				<tr><th><label for="ts-inventory-state"><?php esc_html_e( 'Booking status', 'tanzania-sensational' ); ?></label></th><td><select id="ts-inventory-state" name="inventory_state"><option value="open" <?php selected( ! $item || 'closed' !== $item->status, true ); ?>><?php esc_html_e( 'Open (availability is calculated from remaining seats)', 'tanzania-sensational' ); ?></option><option value="closed" <?php selected( $item && 'closed' === $item->status, true ); ?>><?php esc_html_e( 'Closed to new requests', 'tanzania-sensational' ); ?></option></select></td></tr>
			</tbody></table>
			<?php submit_button( $item ? __( 'Save departure', 'tanzania-sensational' ) : __( 'Create departure', 'tanzania-sensational' ) ); ?>
		</form>
		<?php
	}

	private static function text_field( $name, $label, $value, $type = 'text', $required = false, $attributes = '', $description = '' ) {
		$id = 'ts-' . str_replace( '_', '-', $name );
		?>
		<tr><th><label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $label ); ?></label></th><td><input class="regular-text" id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>" type="<?php echo esc_attr( $type ); ?>" value="<?php echo esc_attr( $value ); ?>" <?php echo $required ? 'required' : ''; ?> <?php echo $attributes; ?>><?php if ( $description ) : ?><p class="description"><?php echo esc_html( $description ); ?> <?php esc_html_e( 'Capacity cannot be lower than booked plus held seats.', 'tanzania-sensational' ); ?></p><?php endif; ?></td></tr>
		<?php
	}

	private static function render_inventory_table( $rows, $page, $pages ) {
		?>
		<hr><h2><?php esc_html_e( 'Inventory', 'tanzania-sensational' ); ?></h2>
		<table class="widefat striped"><thead><tr><th><?php esc_html_e( 'Route', 'tanzania-sensational' ); ?></th><th><?php esc_html_e( 'Dates', 'tanzania-sensational' ); ?></th><th><?php esc_html_e( 'Price', 'tanzania-sensational' ); ?></th><th><?php esc_html_e( 'Capacity', 'tanzania-sensational' ); ?></th><th><?php esc_html_e( 'Status', 'tanzania-sensational' ); ?></th><th><?php esc_html_e( 'Actions', 'tanzania-sensational' ); ?></th></tr></thead><tbody>
		<?php if ( ! $rows ) : ?><tr><td colspan="6"><?php esc_html_e( 'No departures have been added.', 'tanzania-sensational' ); ?></td></tr><?php endif; ?>
		<?php foreach ( $rows as $row ) : ?>
			<tr>
				<td><strong><?php echo esc_html( $row->route_name ); ?></strong><?php if ( $row->route_url ) : ?><br><a href="<?php echo esc_url( $row->route_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'View route', 'tanzania-sensational' ); ?></a><?php endif; ?></td>
				<td><?php echo esc_html( $row->departure_date ); ?><?php if ( $row->return_date ) : ?><br><?php echo esc_html( $row->return_date ); ?><?php endif; ?></td>
				<td><?php echo esc_html( $row->currency . ' ' . number_format_i18n( $row->price_cents / 100, 2 ) ); ?></td>
				<td><?php echo esc_html( sprintf( __( '%1$d total · %2$d booked · %3$d held · %4$d available', 'tanzania-sensational' ), (int) $row->total_seats, (int) $row->booked_seats, (int) $row->held_seats, max( 0, (int) $row->total_seats - (int) $row->booked_seats - (int) $row->held_seats ) ) ); ?></td>
				<td><?php echo esc_html( ucfirst( $row->status ) ); ?></td>
				<td><?php self::render_actions( $row ); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody></table>
		<?php self::render_inventory_pagination( $page, $pages ); ?>
		</div>
		<?php
	}

	private static function render_inventory_pagination( $page, $pages ) {
		if ( $pages < 2 ) {
			return;
		}

		$links = paginate_links( array(
			'base'      => add_query_arg( array( 'page' => 'ts-departures', 'paged' => '%#%' ), admin_url( 'admin.php' ) ),
			'format'    => '',
			'current'   => $page,
			'total'     => $pages,
			'type'      => 'list',
			'prev_text' => __( 'Previous', 'tanzania-sensational' ),
			'next_text' => __( 'Next', 'tanzania-sensational' ),
		) );

		if ( $links ) {
			echo '<nav aria-label="' . esc_attr( __( 'Departure inventory pages', 'tanzania-sensational' ) ) . '" class="tablenav-pages">' . $links . '</nav>';
		}
	}

	private static function render_actions( $row ) {
		$edit_url = add_query_arg( array( 'page' => 'ts-departures', 'edit' => (int) $row->id ), admin_url( 'admin.php' ) );
		?>
		<a class="button button-secondary" href="<?php echo esc_url( $edit_url ); ?>"><?php esc_html_e( 'Edit', 'tanzania-sensational' ); ?></a>
		<?php if ( 'closed' !== $row->status ) : ?>
			<form class="ts-departure-close-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="ts_close_departure"><input type="hidden" name="departure_id" value="<?php echo esc_attr( $row->id ); ?>">
				<?php wp_nonce_field( 'ts_close_departure_' . $row->id ); ?><button class="button button-secondary" type="submit"><?php esc_html_e( 'Close', 'tanzania-sensational' ); ?></button>
			</form>
		<?php endif; ?>
		<?php
	}

	private static function return_to_page( $notice ) {
		wp_safe_redirect( add_query_arg( array( 'page' => 'ts-departures', 'notice' => $notice ), admin_url( 'admin.php' ) ) );
		exit;
	}
}
