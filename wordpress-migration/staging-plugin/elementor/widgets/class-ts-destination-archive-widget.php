<?php
/** Editable Destination Archive backed by WordPress and ACF. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_Destination_Archive_Widget extends Widget_Base {
    public function get_name() { return 'ts_destination_archive'; }
    public function get_title() { return __( 'TS Destination Archive', 'tanzania-sensational' ); }
    public function get_icon() { return 'eicon-posts-masonry'; }
    public function get_categories() { return [ 'ts-widgets' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [ 'label' => __( 'Archive Content', 'tanzania-sensational' ) ] );
        $this->add_control( 'eyebrow', [ 'label' => __( 'Eyebrow', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Choose Your Wilderness', 'tanzania-sensational' ) ] );
        $this->add_control( 'title', [ 'label' => __( 'Title', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Safari Destinations', 'tanzania-sensational' ) ] );
        $this->add_control( 'emphasized_word', [ 'label' => __( 'Italicized Word', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Destinations', 'tanzania-sensational' ) ] );
        $this->add_control( 'count', [ 'label' => __( 'Number of Destinations', 'tanzania-sensational' ), 'type' => Controls_Manager::NUMBER, 'min' => -1, 'max' => 50, 'default' => -1, 'description' => __( 'Use -1 to show all destinations.', 'tanzania-sensational' ) ] );
        $this->add_control( 'featured_only', [ 'label' => __( 'Featured Only', 'tanzania-sensational' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '' ] );
        $this->add_control( 'empty_message', [ 'label' => __( 'Empty Message', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'New destinations are being prepared. Please check back soon.', 'tanzania-sensational' ) ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $args = [ 'posts_per_page' => (int) $s['count'] ];
        if ( 'yes' === $s['featured_only'] ) {
            $args['meta_query'] = [ [ 'key' => 'ts_dest_featured', 'value' => '1' ] ];
        }
        $destinations = ts_get_destinations( $args );
        $title = esc_html( $s['title'] );
        if ( trim( $s['emphasized_word'] ) ) {
            $title = preg_replace( '/(' . preg_quote( esc_html( trim( $s['emphasized_word'] ) ), '/' ) . ')/', '<em>$1</em>', $title, 1 );
        }
        ?>
        <section class="ts-dest-archive-section">
            <div class="ts-dest-archive-header">
                <span class="ts-dest-archive-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
                <h1 class="ts-dest-archive-title"><?php echo wp_kses( $title, [ 'em' => [] ] ); ?></h1>
            </div>
            <?php if ( $destinations ) : ?>
                <div class="ts-dest-archive-grid"><?php foreach ( $destinations as $destination ) { echo ts_render_dest_card( $destination->ID, 'medium' ); } ?></div>
            <?php else : ?>
                <p class="ts-elementor-placeholder"><?php echo esc_html( $s['empty_message'] ); ?></p>
            <?php endif; ?>
        </section>
        <?php
    }
}
