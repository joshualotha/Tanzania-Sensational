<?php
/**
 * Editable homepage departures section.
 *
 * @package Tanzania_Sensational
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_Departures_Widget extends Widget_Base {
    public function get_name() { return 'ts_departures'; }
    public function get_title() { return __( 'TS Group Departures', 'tanzania-sensational' ); }
    public function get_icon() { return 'eicon-calendar'; }
    public function get_categories() { return [ 'ts-widgets' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'content', [ 'label' => __( 'Content', 'tanzania-sensational' ) ] );
        $this->add_control( 'eyebrow', [ 'label' => __( 'Eyebrow', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'Join a Team' ] );
        $this->add_control( 'title', [ 'label' => __( 'Heading', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'default' => "Group\nDepartures", 'description' => __( 'The second line is italicized.', 'tanzania-sensational' ) ] );
        $this->add_control( 'description', [ 'label' => __( 'Description', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => 'Traveling solo? Split the cost. Share the adventure. Our group departures place solo travelers into small, curated teams of like-minded explorers.' ] );
        $this->add_control( 'button_text', [ 'label' => __( 'Button Text', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'View All Dates' ] );
        $this->add_control( 'button_url', [ 'label' => __( 'Button URL', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/group-departures' ] ] );
        $this->end_controls_section();

        $this->start_controls_section( 'inventory_section', [ 'label' => __( 'Live Departure Inventory', 'tanzania-sensational' ) ] );
        $this->add_control( 'max_departures', [
            'label'   => __( 'Maximum Cards', 'tanzania-sensational' ),
            'type'    => Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 12,
            'default' => 4,
        ] );
        $this->add_control( 'empty_message', [
            'label'   => __( 'Empty-State Message', 'tanzania-sensational' ),
            'type'    => Controls_Manager::TEXTAREA,
            'default' => __( 'New departure dates are being prepared. Please contact us for a private climb.', 'tanzania-sensational' ),
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $lines    = array_map( 'trim', explode( "\n", (string) ( $settings['title'] ?? '' ) ) );
        $button   = $settings['button_url']['url'] ?? '/group-departures';
        $limit    = min( 12, max( 1, absint( $settings['max_departures'] ?? 4 ) ) );
        $departures = class_exists( 'TS_Departures_Public' ) ? TS_Departures_Public::get_available_departures( $limit ) : array();
        ?>
        <section class="departures-v3">
            <div class="departures-inner-asymmetric">
                <div class="departures-content-side">
                    <?php if ( ! empty( $settings['eyebrow'] ) ) : ?><div class="section-eyebrow"><div class="section-eyebrow-line"></div><span class="section-eyebrow-text"><?php echo esc_html( $settings['eyebrow'] ); ?></span></div><?php endif; ?>
                    <h2 class="section-title-light"><?php echo esc_html( $lines[0] ?? '' ); ?><?php if ( ! empty( $lines[1] ) ) : ?><br><em><?php echo esc_html( $lines[1] ); ?></em><?php endif; ?></h2>
                    <?php if ( ! empty( $settings['description'] ) ) : ?><p class="departures-desc-v3"><?php echo esc_html( $settings['description'] ); ?></p><?php endif; ?>
                    <?php if ( ! empty( $settings['button_text'] ) ) : ?><a href="<?php echo esc_url( $button ); ?>" class="btn-secondary-light"><?php echo esc_html( $settings['button_text'] ); ?></a><?php endif; ?>
                </div>
                <div class="departures-list-v3">
                    <?php if ( empty( $departures ) ) : ?>
                        <p class="departures-desc-v3"><?php echo esc_html( $settings['empty_message'] ?? __( 'New departure dates are being prepared. Please contact us for a private climb.', 'tanzania-sensational' ) ); ?></p>
                    <?php endif; ?>
                    <?php foreach ( (array) $departures as $departure ) :
                        $spots       = max( 0, (int) $departure->total_seats - (int) $departure->booked_seats - (int) $departure->held_seats );
                        $departure_id = absint( $departure->id );
                        $url          = home_url( '/group-departures/?departure_id=' . $departure_id );
                        $price         = (float) $departure->price_cents / 100;
                        $currency      = sanitize_text_field( $departure->currency ?? 'USD' );
                        $price_prefix  = 'USD' === $currency ? '$' : $currency . ' ';
                    ?>
                        <a href="<?php echo esc_url( $url ); ?>" class="departure-card-v3">
                            <div class="dep-info-v3"><span class="dep-route-v3"><?php echo esc_html( $departure->route_name ); ?></span><span class="dep-date-v3"><?php echo esc_html( date_i18n( 'M j', strtotime( $departure->departure_date ) ) ); ?></span></div>
                            <div class="dep-meta-v3"><span class="dep-seats-pill-v3 <?php echo $spots <= 3 ? 'low' : ''; ?>"><?php echo esc_html( sprintf( _n( '%d spot left', '%d spots left', $spots, 'tanzania-sensational' ), $spots ) ); ?></span><span class="dep-price-v3"><?php echo esc_html( 'From ' . $price_prefix . number_format_i18n( $price, 0 ) ); ?></span></div>
                            <div class="dep-arrow-v3"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    protected function content_template() {
        ?>
        <section class="departures-v3">
            <div class="departures-inner-asymmetric">
                <div class="departures-content-side">
                    <div class="section-eyebrow"><div class="section-eyebrow-line"></div><span class="section-eyebrow-text">{{{ settings.eyebrow }}}</span></div>
                    <h2 class="section-title-light">{{{ settings.title }}}</h2>
                    <p class="departures-desc-v3">{{{ settings.description }}}</p>
                    <span class="btn-secondary-light">{{{ settings.button_text }}}</span>
                </div>
                <div class="departures-list-v3">
                    <div class="departure-card-v3" aria-hidden="true">
                        <div class="dep-info-v3"><span class="dep-route-v3">Route name</span><span class="dep-date-v3">Departure date</span></div>
                        <div class="dep-meta-v3"><span class="dep-seats-pill-v3">Places left</span><span class="dep-price-v3">Price per person</span></div>
                        <div class="dep-arrow-v3"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg></div>
                    </div>
                    <p class="departures-desc-v3">Layout preview only — live departure details appear on the published page.</p>
                </div>
            </div>
        </section>
        <?php
    }
}
