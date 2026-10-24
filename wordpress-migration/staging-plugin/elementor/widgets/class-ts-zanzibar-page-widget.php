<?php
/** Editable Elementor presentation shell for the Zanzibar page. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_Zanzibar_Page_Widget extends Widget_Base {
    public function get_name() { return 'ts_zanzibar_page'; }
    public function get_title() { return __( 'TS Zanzibar Page', 'tanzania-sensational' ); }
    public function get_icon() { return 'eicon-image-rollover'; }
    public function get_categories() { return [ 'ts-widgets' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'hero', [ 'label' => __( 'Hero', 'tanzania-sensational' ) ] );
        $this->add_control( 'hero_eyebrow', [ 'label' => __( 'Eyebrow', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'The Spice Archipelago', 'tanzania-sensational' ) ] );
        $this->add_control( 'hero_title', [ 'label' => __( 'Title', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'Zanzibar.' ] );
        $this->add_control( 'hero_subtitle', [ 'label' => __( 'Subtitle', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => __( 'Where ancient stone meets endless turquoise. An island woven from coral, clove, and centuries of untold stories.', 'tanzania-sensational' ) ] );
        $this->end_controls_section();

        $this->start_controls_section( 'action', [ 'label' => __( 'Final Call to Action', 'tanzania-sensational' ) ] );
        $this->add_control( 'primary_text', [ 'label' => __( 'Primary Button', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Commission Your Stay', 'tanzania-sensational' ) ] );
        $this->add_control( 'primary_url', [ 'label' => __( 'Primary Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/contact' ] ] );
        $this->add_control( 'secondary_text', [ 'label' => __( 'Secondary Button', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Explore Safari Pairings', 'tanzania-sensational' ) ] );
        $this->add_control( 'secondary_url', [ 'label' => __( 'Secondary Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/safaris' ] ] );
        $this->end_controls_section();

        $this->start_controls_section( 'visibility', [ 'label' => __( 'Section Visibility', 'tanzania-sensational' ) ] );
        $sections = [
            'hide_hero' => [ 'Hide Hero', '.zan-hero' ],
            'hide_editorial' => [ 'Hide Stone Town Story', '.zan-editorial' ],
            'hide_regions' => [ 'Hide Regions', '.zan-regions' ],
            'hide_parallax' => [ 'Hide Image Band', '.zan-parallax' ],
            'hide_experiences' => [ 'Hide Experiences', '.zan-experiences' ],
            'hide_testimonial' => [ 'Hide Testimonial', '.zan-testimonial' ],
            'hide_cta' => [ 'Hide Final CTA', '.zan-cta-band' ],
        ];
        foreach ( $sections as $key => $section ) {
            $this->add_control( $key, [
                'label' => __( $section[0], 'tanzania-sensational' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '',
                'selectors' => [ '{{WRAPPER}} ' . $section[1] => 'display:none;' ],
            ] );
        }
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $html = do_shortcode( '[ts_zanzibar_page]' );
        $title = esc_html( rtrim( $s['hero_title'], '.' ) ) . '<em>.</em>';
        $replace = [
            '<span class="zan-eyebrow">The Spice Archipelago</span>' => '<span class="zan-eyebrow">' . esc_html( $s['hero_eyebrow'] ) . '</span>',
            '<h1 class="zan-hero-title">Zanzibar<em>.</em></h1>' => '<h1 class="zan-hero-title">' . $title . '</h1>',
            '<p class="zan-hero-subtitle">Where ancient stone meets endless turquoise. An island woven from coral, clove, and centuries of untold stories.</p>' => '<p class="zan-hero-subtitle">' . esc_html( $s['hero_subtitle'] ) . '</p>',
            '<a href="/contact" class="zan-btn-primary"><span>Commission Your Stay</span>' => '<a href="' . esc_url( $s['primary_url']['url'] ?: '/contact' ) . '" class="zan-btn-primary"><span>' . esc_html( $s['primary_text'] ) . '</span>',
            '<a href="/safaris" class="zan-btn-outline"><span>Explore Safari Pairings</span>' => '<a href="' . esc_url( $s['secondary_url']['url'] ?: '/safaris' ) . '" class="zan-btn-outline"><span>' . esc_html( $s['secondary_text'] ) . '</span>',
        ];
        echo strtr( $html, $replace ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
