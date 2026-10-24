<?php
/**
 * Editable, data-backed homepage destinations widget.
 *
 * @package Tanzania_Sensational
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_Destinations_Widget extends Widget_Base {
    public function get_name() {
        return 'ts_destinations';
    }

    public function get_title() {
        return __( 'TS Safari Destinations', 'tanzania-sensational' );
    }

    public function get_icon() {
        return 'eicon-map-pin';
    }

    public function get_categories() {
        return [ 'ts-widgets' ];
    }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Content', 'tanzania-sensational' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow', 'tanzania-sensational' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Explore the Wild', 'tanzania-sensational' ),
        ] );

        $this->add_control( 'title', [
            'label'       => __( 'Title', 'tanzania-sensational' ),
            'type'        => Controls_Manager::TEXTAREA,
            'default'     => "Safari\nDestinations",
            'description' => __( 'Place the italic portion on the second line.', 'tanzania-sensational' ),
        ] );

        $this->add_control( 'view_all_text', [
            'label'   => __( 'View All Text', 'tanzania-sensational' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'All Destinations', 'tanzania-sensational' ),
        ] );

        $this->add_control( 'view_all_url', [
            'label'   => __( 'View All URL', 'tanzania-sensational' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/safaris/destinations' ],
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'query', [
            'label' => __( 'Query', 'tanzania-sensational' ),
            'tab'   => Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'posts_per_page', [
            'label'   => __( 'Number of Destinations', 'tanzania-sensational' ),
            'type'    => Controls_Manager::NUMBER,
            'default' => 4,
            'min'     => 2,
            'max'     => 8,
        ] );

        $this->add_control( 'featured_only', [
            'label'        => __( 'Prefer Featured Destinations', 'tanzania-sensational' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );

        $this->add_control( 'fallback_to_any', [
            'label'        => __( 'Fallback to Published Destinations', 'tanzania-sensational' ),
            'type'         => Controls_Manager::SWITCHER,
            'default'      => 'yes',
            'return_value' => 'yes',
        ] );

        $this->end_controls_section();
    }

    private function image_url( $value, $width = 1200 ) {
        if ( is_array( $value ) ) {
            return $value['url'] ?? '';
        }
        if ( is_numeric( $value ) ) {
            return wp_get_attachment_image_url( (int) $value, 'large' ) ?: '';
        }
        if ( is_string( $value ) ) {
            return $value;
        }
        return "https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w={$width}&auto=format&fit=crop";
    }

    private function render_card( $destination, $large = false ) {
        $tag       = ts_get_field( 'ts_dest_tag', $destination->ID ) ?: '';
        $subtitle  = ts_get_field( 'ts_dest_subtitle', $destination->ID ) ?: '';
        $image     = $this->image_url( ts_get_field( 'ts_dest_hero_image', $destination->ID ), $large ? 1200 : 800 );
        $modifier  = $large ? 'dest-home-card-lg' : 'dest-home-card-sm';
        ?>
        <a href="<?php echo esc_url( get_permalink( $destination->ID ) ); ?>" class="dest-home-card <?php echo esc_attr( $modifier ); ?>">
            <div class="dest-home-card-img">
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( get_the_title( $destination->ID ) ); ?>" loading="lazy" />
                <div class="dest-home-card-gradient"></div>
            </div>
            <div class="dest-home-card-content">
                <?php if ( $tag ) : ?>
                    <span class="dest-home-card-region"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> <?php echo esc_html( $tag ); ?></span>
                <?php endif; ?>
                <h3 class="dest-home-card-name"><?php echo esc_html( get_the_title( $destination->ID ) ); ?></h3>
                <?php if ( $subtitle ) : ?><p class="dest-home-card-tagline"><?php echo esc_html( $subtitle ); ?></p><?php endif; ?>
                <span class="dest-home-card-link"><?php esc_html_e( 'Explore', 'tanzania-sensational' ); ?> <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"></path></svg></span>
            </div>
        </a>
        <?php
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $count    = max( 2, min( 8, absint( $settings['posts_per_page'] ?? 4 ) ) );
        $args     = [ 'posts_per_page' => $count ];

        if ( 'yes' === ( $settings['featured_only'] ?? 'yes' ) ) {
            $args['meta_query'] = [[ 'key' => 'ts_dest_featured', 'value' => '1' ]];
        }

        $destinations = ts_get_destinations( $args );
        if ( empty( $destinations ) && 'yes' === ( $settings['fallback_to_any'] ?? 'yes' ) ) {
            $destinations = ts_get_destinations( [ 'posts_per_page' => $count ] );
        }
        if ( empty( $destinations ) ) {
            return;
        }

        $title_lines = array_map( 'trim', explode( "\n", (string) ( $settings['title'] ?? '' ) ) );
        $featured    = array_shift( $destinations );
        $url         = $settings['view_all_url']['url'] ?? '/safaris/destinations';
        ?>
        <section class="dest-home">
            <div class="dest-home-inner">
                <div class="dest-home-header">
                    <div>
                        <?php if ( ! empty( $settings['eyebrow'] ) ) : ?><span class="dest-home-eyebrow"><?php echo esc_html( $settings['eyebrow'] ); ?></span><?php endif; ?>
                        <h2 class="dest-home-title"><?php echo esc_html( $title_lines[0] ?? '' ); ?> <?php if ( ! empty( $title_lines[1] ) ) : ?><em><?php echo esc_html( $title_lines[1] ); ?></em><?php endif; ?></h2>
                    </div>
                    <?php if ( ! empty( $settings['view_all_text'] ) ) : ?><a href="<?php echo esc_url( $url ); ?>" class="dest-home-viewall"><?php echo esc_html( $settings['view_all_text'] ); ?> <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"></path></svg></a><?php endif; ?>
                </div>
                <div class="dest-home-layout">
                    <div class="dest-home-featured"><?php $this->render_card( $featured, true ); ?></div>
                    <div class="dest-home-small-grid"><?php foreach ( $destinations as $destination ) { $this->render_card( $destination ); } ?></div>
                </div>
            </div>
        </section>
        <?php
    }

    protected function content_template() {
        ?>
        <section class="dest-home"><div class="dest-home-inner"><div class="dest-home-header"><div><span class="dest-home-eyebrow">{{{ settings.eyebrow }}}</span><h2 class="dest-home-title">{{{ settings.title }}}</h2></div><span class="dest-home-viewall">{{{ settings.view_all_text }}}</span></div><p><?php esc_html_e( 'Destination cards are loaded from WordPress and ACF on the published page.', 'tanzania-sensational' ); ?></p></div></section>
        <?php
    }
}
