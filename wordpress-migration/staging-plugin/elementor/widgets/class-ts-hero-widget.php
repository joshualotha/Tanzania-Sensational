<?php
/**
 * TS Hero Widget for Elementor.
 *
 * @package Tanzania_Sensational
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;

class TS_Hero_Widget extends Widget_Base {

    public function get_name() {
        return 'ts_hero';
    }

    public function get_title() {
        return __( 'TS Hero', 'tanzania-sensational' );
    }

    public function get_icon() {
        return 'eicon-image-rollover';
    }

    public function get_categories() {
        return [ 'ts-widgets' ];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => __( 'Content', 'tanzania-sensational' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'background_image',
            [
                'label'   => __( 'Background Image', 'tanzania-sensational' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-1.2.1&auto=format&fit=crop&w=2400&q=90',
                ],
            ]
        );

        $this->add_control(
            'title',
            [
                'label'   => __( 'Title', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( "Into the Wild.\nBeyond the Ordinary.", 'tanzania-sensational' ),
                'rows'    => 3,
            ]
        );

        $this->add_control(
            'subtitle',
            [
                'label'   => __( 'Subtitle', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => __( "East Africa's premier safari outfitter. From the Serengeti to the Crater, every expedition is a story worth telling.", 'tanzania-sensational' ),
                'rows'    => 3,
            ]
        );

        $this->add_control(
            'primary_button_text',
            [
                'label'   => __( 'Primary Button Text', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Explore Safaris', 'tanzania-sensational' ),
            ]
        );

        $this->add_control(
            'primary_button_url',
            [
                'label'   => __( 'Primary Button URL', 'tanzania-sensational' ),
                'type'    => Controls_Manager::URL,
                'default' => [
                    'url' => '/safaris',
                ],
            ]
        );

        $this->add_control(
            'secondary_button_text',
            [
                'label'   => __( 'Secondary Button Text', 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( 'Climb Kilimanjaro', 'tanzania-sensational' ),
            ]
        );

        $this->add_control(
            'secondary_button_url',
            [
                'label'   => __( 'Secondary Button URL', 'tanzania-sensational' ),
                'type'    => Controls_Manager::URL,
                'default' => [
                    'url' => '/trekking/kilimanjaro',
                ],
            ]
        );

        $this->add_control(
            'show_scroll_indicator',
            [
                'label'   => __( 'Show Scroll Indicator', 'tanzania-sensational' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $bg_url = ! empty( $settings['background_image']['url'] ) ? $settings['background_image']['url'] : '';
        $title  = nl2br( $settings['title'] );
        $subtitle = $settings['subtitle'];

        $primary_text = $settings['primary_button_text'];
        $primary_url  = ! empty( $settings['primary_button_url']['url'] ) ? $settings['primary_button_url']['url'] : '#';
        $primary_target = ! empty( $settings['primary_button_url']['is_external'] ) ? ' target="_blank"' : '';
        $primary_nofollow = ! empty( $settings['primary_button_url']['nofollow'] ) ? ' rel="nofollow"' : '';

        $secondary_text = $settings['secondary_button_text'];
        $secondary_url  = ! empty( $settings['secondary_button_url']['url'] ) ? $settings['secondary_button_url']['url'] : '#';
        $secondary_target = ! empty( $settings['secondary_button_url']['is_external'] ) ? ' target="_blank"' : '';
        $secondary_nofollow = ! empty( $settings['secondary_button_url']['nofollow'] ) ? ' rel="nofollow"' : '';

        $show_scroll = 'yes' === $settings['show_scroll_indicator'];
        ?>
        <section class="hero-v2">
            <?php if ( $bg_url ) : ?>
            <div class="hero-v2-bg">
                <img src="<?php echo esc_url( $bg_url ); ?>" alt="<?php echo esc_attr( wp_strip_all_tags( $title ) ); ?>" class="hero-v2-bg-img" fetchpriority="high" loading="eager" />
            </div>
            <?php endif; ?>
            <div class="hero-v2-overlay"></div>
            <div class="hero-v2-vignette"></div>
            <div class="hero-v2-content">
                <h1 class="hero-v2-title"><?php echo wp_kses_post( $title ); ?></h1>
                <?php if ( $subtitle ) : ?>
                    <p class="hero-v2-subtitle"><?php echo esc_html( $subtitle ); ?></p>
                <?php endif; ?>
                <div class="hero-v2-actions">
                    <?php if ( $primary_text ) : ?>
                        <a href="<?php echo esc_url( $primary_url ); ?>" class="hero-v2-btn-primary"<?php echo $primary_target . $primary_nofollow; ?>>
                            <span><?php echo esc_html( $primary_text ); ?></span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                        </a>
                    <?php endif; ?>
                    <?php if ( $secondary_text ) : ?>
                        <a href="<?php echo esc_url( $secondary_url ); ?>" class="hero-v2-btn-ghost"<?php echo $secondary_target . $secondary_nofollow; ?>><?php echo esc_html( $secondary_text ); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ( $show_scroll ) : ?>
                <div class="hero-v2-scroll"><div class="hero-v2-scroll-line"></div><span><?php esc_html_e( 'Scroll', 'tanzania-sensational' ); ?></span></div>
            <?php endif; ?>
        </section>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var title = settings.title ? settings.title.replace(/\n/g, '<br>') : '';
        #>
        <section class="hero-v2">
            <# if ( settings.background_image.url ) { #>
            <div class="hero-v2-bg">
                <img src="{{{ settings.background_image.url }}}" alt="" class="hero-v2-bg-img" />
            </div>
            <# } #>
            <div class="hero-v2-overlay"></div>
            <div class="hero-v2-vignette"></div>
            <div class="hero-v2-content">
                <h1 class="hero-v2-title">{{{ title }}}</h1>
                <# if ( settings.subtitle ) { #>
                    <p class="hero-v2-subtitle">{{{ settings.subtitle }}}</p>
                <# } #>
                <div class="hero-v2-actions">
                    <# if ( settings.primary_button_text ) { #>
                        <a href="{{{ settings.primary_button_url.url }}}" class="hero-v2-btn-primary">
                            <span>{{{ settings.primary_button_text }}}</span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                        </a>
                    <# } #>
                    <# if ( settings.secondary_button_text ) { #>
                        <a href="{{{ settings.secondary_button_url.url }}}" class="hero-v2-btn-ghost">{{{ settings.secondary_button_text }}}</a>
                    <# } #>
                </div>
            </div>
            <# if ( 'yes' === settings.show_scroll_indicator ) { #>
                <div class="hero-v2-scroll"><div class="hero-v2-scroll-line"></div><span>Scroll</span></div>
            <# } #>
        </section>
        <?php
    }
}
