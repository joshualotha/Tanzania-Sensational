<?php
/**
 * Editable Tour Archive shell backed by ts_tour content and ACF fields.
 *
 * @package Tanzania_Sensational
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_Tour_Archive_Widget extends Widget_Base {

    public function get_name() {
        return 'ts_tour_archive';
    }

    public function get_title() {
        return __( 'TS Tour Archive', 'tanzania-sensational' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return [ 'ts-widgets' ];
    }

    protected function register_controls() {
        $this->start_controls_section( 'content', [
            'label' => __( 'Archive Content', 'tanzania-sensational' ),
        ] );
        $this->add_control( 'eyebrow', [
            'label' => __( 'Eyebrow', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Curated Expeditions', 'tanzania-sensational' ),
        ] );
        $this->add_control( 'title', [
            'label' => __( 'Title', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Safari Packages', 'tanzania-sensational' ),
        ] );
        $this->add_control( 'emphasized_word', [
            'label' => __( 'Italicized Word', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Packages', 'tanzania-sensational' ),
        ] );
        $this->add_control( 'description', [
            'label' => __( 'Introduction', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 4,
            'default' => __( "From intimate 3-day getaways to comprehensive 14-day expeditions — each safari is designed to immerse you in the raw beauty of East Africa's wildlife.", 'tanzania-sensational' ),
        ] );
        $this->add_control( 'show_cta', [
            'label' => __( 'Show Header CTA', 'tanzania-sensational' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '',
        ] );
        $this->add_control( 'cta_text', [
            'label' => __( 'CTA Text', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'View All Packages', 'tanzania-sensational' ),
            'condition' => [ 'show_cta' => 'yes' ],
        ] );
        $this->add_control( 'cta_url', [
            'label' => __( 'CTA Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/safaris/packages' ],
            'condition' => [ 'show_cta' => 'yes' ],
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'query', [ 'label' => __( 'Tour Query', 'tanzania-sensational' ) ] );
        $this->add_control( 'count', [
            'label' => __( 'Number of Tours', 'tanzania-sensational' ), 'type' => Controls_Manager::NUMBER, 'min' => -1, 'max' => 50, 'default' => -1,
            'description' => __( 'Use -1 to show every published tour.', 'tanzania-sensational' ),
        ] );
        $this->add_control( 'featured_only', [
            'label' => __( 'Featured Tours Only', 'tanzania-sensational' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '',
        ] );
        $this->add_control( 'empty_message', [
            'label' => __( 'Empty Message', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'New safari journeys are being prepared. Please check back soon.', 'tanzania-sensational' ),
        ] );
        $this->end_controls_section();
    }

    private function display_title( $title, $word ) {
        $title = esc_html( $title );
        $word  = trim( (string) $word );
        if ( '' === $word ) {
            return $title;
        }
        return preg_replace( '/(' . preg_quote( esc_html( $word ), '/' ) . ')/i', '<em>$1</em>', $title, 1 );
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $args = [ 'posts_per_page' => (int) $s['count'] ];
        if ( 'yes' === $s['featured_only'] ) {
            $args['meta_query'] = [ [ 'key' => 'ts_tour_featured', 'value' => '1' ] ];
        }
        $tours = ts_get_tours( $args );
        ?>
        <section class="ts-tours-grid-section">
            <div class="ts-tours-grid-header">
                <div>
                    <span class="ts-tours-grid-eyebrow"><?php echo esc_html( $s['eyebrow'] ); ?></span>
                    <h1 class="ts-tours-grid-title"><?php echo wp_kses( $this->display_title( $s['title'], $s['emphasized_word'] ), [ 'em' => [] ] ); ?></h1>
                    <p class="ts-tours-grid-sub"><?php echo esc_html( $s['description'] ); ?></p>
                </div>
                <?php if ( 'yes' === $s['show_cta'] ) : ?>
                    <a href="<?php echo esc_url( $s['cta_url']['url'] ?: '/safaris/packages' ); ?>" class="ts-tours-grid-viewall"><?php echo esc_html( $s['cta_text'] ); ?><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                <?php endif; ?>
            </div>
            <?php if ( $tours ) : ?>
                <div class="ts-tours-grid"><?php foreach ( $tours as $tour ) { echo ts_render_tour_card( $tour->ID ); } ?></div>
            <?php else : ?>
                <p class="ts-archive-empty"><?php echo esc_html( $s['empty_message'] ); ?></p>
            <?php endif; ?>
        </section>
        <?php
    }
}
