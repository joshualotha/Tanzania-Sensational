<?php
/**
 * TS Safari Packages Widget for Elementor.
 *
 * @package Tanzania_Sensational
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;

class TS_Packages_Widget extends Widget_Base {

    public function get_name() {
        return 'ts_packages';
    }

    public function get_title() {
        return __( 'TS Safari Packages', 'tanzania-sensational' );
    }

    public function get_icon() {
        return 'eicon-gallery-grid';
    }

    public function get_categories() {
        return [ 'ts-widgets' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'header_section',
            [
                'label' => __( 'Header', 'tanzania-sensational' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'eyebrow',
            [
                'label'   => __( 'Eyebrow', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Curated Expeditions', 'tanzania-sensational' ),
            ]
        );

        $this->add_control(
            'title',
            [
                'label'   => __( 'Title', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( "Safari \nPackages", 'tanzania-sensational' ),
                'rows'    => 2,
                'description' => __( 'Use a new line for the italic portion.', 'tanzania-sensational' ),
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label'   => __( 'Subtitle', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( 'From intimate 3-day getaways to comprehensive 14-day expeditions — each safari is designed to immerse you in the raw beauty of East Africa\'s wildlife.', 'tanzania-sensational' ),
                'rows'    => 3,
            ]
        );

        $this->add_control(
            'view_all_text',
            [
                'label'   => __( 'View All Text', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'View All Packages', 'tanzania-sensational' ),
            ]
        );

        $this->add_control(
            'view_all_url',
            [
                'label'   => __( 'View All URL', 'tanzania-sensational' ),
                'type'    => Controls_Manager::URL,
                'default' => [
                    'url' => '/safaris/packages',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'query_section',
            [
                'label' => __( 'Query', 'tanzania-sensational' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'   => __( 'Number of Packages', 'tanzania-sensational' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
                'min'     => 1,
                'max'     => 12,
            ]
        );

        $this->add_control(
            'fallback_to_any',
            [
                'label'   => __( 'Fallback to Any Tours', 'tanzania-sensational' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'description' => __( 'If no featured tours are found, show any published tours.', 'tanzania-sensational' ),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $eyebrow    = $settings['eyebrow'];
        $title      = $settings['title'];
        $subtitle   = $settings['subtitle'];
        $view_text  = $settings['view_all_text'];
        $view_url   = ! empty( $settings['view_all_url']['url'] ) ? $settings['view_all_url']['url'] : '#';
        $view_target = ! empty( $settings['view_all_url']['is_external'] ) ? ' target="_blank"' : '';
        $view_nofollow = ! empty( $settings['view_all_url']['nofollow'] ) ? ' rel="nofollow"' : '';

        $count = absint( $settings['posts_per_page'] ) ?: 6;

        $packages = ts_get_tours( [
            'posts_per_page' => $count,
            'meta_query'     => [
                [
                    'key'   => 'ts_tour_featured',
                    'value' => '1',
                ],
            ],
        ] );

        if ( empty( $packages ) && 'yes' === $settings['fallback_to_any'] ) {
            $packages = ts_get_tours( [ 'posts_per_page' => $count ] );
        }

        if ( empty( $packages ) ) {
            return;
        }

        $title_lines = array_map( 'trim', explode( "\n", $title ) );
        ?>
        <section class="safari-home">
            <div class="safari-home-inner">
                <div class="safari-home-header">
                    <div>
                        <?php if ( $eyebrow ) : ?><span class="safari-home-eyebrow"><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?>
                        <h2 class="safari-home-title">
                            <?php echo esc_html( $title_lines[0] ); ?>
                            <?php if ( ! empty( $title_lines[1] ) ) : ?><em><?php echo esc_html( $title_lines[1] ); ?></em><?php endif; ?>
                        </h2>
                        <?php if ( $subtitle ) : ?><p class="safari-home-sub"><?php echo esc_html( $subtitle ); ?></p><?php endif; ?>
                    </div>
                    <?php if ( $view_text ) : ?>
                        <a href="<?php echo esc_url( $view_url ); ?>" class="safari-home-viewall"<?php echo $view_target . $view_nofollow; ?>><?php echo esc_html( $view_text ); ?> <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                    <?php endif; ?>
                </div>
                <div class="safari-home-grid">
                    <?php foreach ( $packages as $pkg ) :
                        $pkg_duration   = ts_get_field( 'ts_tour_duration', $pkg->ID ) ?: '';
                        $pkg_parks      = ts_get_field( 'ts_tour_parks', $pkg->ID ) ?: 'Tanzania';
                        $pkg_price      = ts_get_field( 'ts_tour_price', $pkg->ID ) ?: '';
                        $pkg_price_note = ts_get_field( 'ts_tour_price_note', $pkg->ID ) ?: __( 'per person', 'tanzania-sensational' );
                        $pkg_badge      = ts_get_field( 'ts_tour_badge', $pkg->ID ) ?: '';
                        $pkg_overview   = ts_get_field( 'ts_tour_overview', $pkg->ID );
                        $pkg_desc       = $pkg_overview ? wp_trim_words( strip_tags( $pkg_overview ), 18 ) : '';
                        $pkg_hero       = ts_get_field( 'ts_tour_hero_image', $pkg->ID );
                        $pkg_hero_url   = is_array( $pkg_hero ) ? ( $pkg_hero['url'] ?? '' ) : ( is_numeric( $pkg_hero ) ? wp_get_attachment_url( $pkg_hero ) : $pkg_hero );
                        $pkg_hero_url   = $pkg_hero_url ?: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=800&auto=format&fit=crop';
                        $pkg_duration_num = (int) preg_replace( '/\D/', '', $pkg_duration );
                    ?>
                    <a href="<?php echo esc_url( get_permalink( $pkg->ID ) ); ?>" class="safari-home-card">
                        <div class="safari-home-card-img">
                            <img src="<?php echo esc_url( $pkg_hero_url ); ?>" alt="<?php echo esc_attr( get_the_title( $pkg->ID ) ); ?>" loading="lazy" />
                            <div class="safari-home-card-overlay"></div>
                            <?php if ( $pkg_badge ) : ?><span class="safari-home-card-badge"><?php echo esc_html( $pkg_badge ); ?></span><?php endif; ?>
                        </div>
                        <div class="safari-home-card-body">
                            <div class="safari-home-card-meta">
                                <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> <?php echo intval( $pkg_duration_num ); ?> Days</span>
                                <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> <?php echo esc_html( $pkg_parks ); ?></span>
                            </div>
                            <h3 class="safari-home-card-title"><?php echo esc_html( get_the_title( $pkg->ID ) ); ?></h3>
                            <p class="safari-home-card-desc"><?php echo esc_html( $pkg_desc ); ?></p>
                            <?php if ( $pkg_price ) : ?>
                                <div class="safari-home-card-price"><?php echo esc_html( $pkg_price ); ?> <span><?php echo esc_html( $pkg_price_note ); ?></span></div>
                            <?php endif; ?>
                            <div class="safari-home-card-cta"><?php esc_html_e( 'Explore Safari', 'tanzania-sensational' ); ?> <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></div>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }

    protected function content_template() {
        ?>
        <section class="safari-home">
            <div class="safari-home-inner">
                <div class="safari-home-header">
                    <div>
                        <# if ( settings.eyebrow ) { #><span class="safari-home-eyebrow">{{{ settings.eyebrow }}}</span><# } #>
                        <h2 class="safari-home-title">{{{ settings.title }}}</h2>
                        <# if ( settings.subtitle ) { #><p class="safari-home-sub">{{{ settings.subtitle }}}</p><# } #>
                    </div>
                    <# if ( settings.view_all_text ) { #>
                        <a href="{{{ settings.view_all_url.url }}}" class="safari-home-viewall">{{{ settings.view_all_text }}} <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                    <# } #>
                </div>
                <div class="safari-home-grid">
                    <div class="safari-home-card">
                        <div class="safari-home-card-img">
                            <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=800&auto=format&fit=crop" alt="" loading="lazy" />
                            <div class="safari-home-card-overlay"></div>
                            <span class="safari-home-card-badge">Featured</span>
                        </div>
                        <div class="safari-home-card-body">
                            <div class="safari-home-card-meta">
                                <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> 7 Days</span>
                                <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> Serengeti</span>
                            </div>
                            <h3 class="safari-home-card-title"><?php esc_html_e( 'Sample Safari Package', 'tanzania-sensational' ); ?></h3>
                            <p class="safari-home-card-desc"><?php esc_html_e( 'A preview of how featured safari packages will appear here.', 'tanzania-sensational' ); ?></p>
                            <div class="safari-home-card-cta"><?php esc_html_e( 'Explore Safari', 'tanzania-sensational' ); ?> <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}
