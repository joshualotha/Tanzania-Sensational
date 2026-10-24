<?php
/** Editable Elementor presentation shell for the FAQ page. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_FAQ_Page_Widget extends Widget_Base {
    public function get_name() { return 'ts_faq_page'; }
    public function get_title() { return __( 'TS FAQ Page', 'tanzania-sensational' ); }
    public function get_icon() { return 'eicon-help-o'; }
    public function get_categories() { return [ 'ts-widgets' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'hero', [ 'label' => __( 'Hero', 'tanzania-sensational' ) ] );
        $this->add_control( 'eyebrow', [ 'label' => __( 'Eyebrow', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Your Questions Answered', 'tanzania-sensational' ) ] );
        $this->add_control( 'title', [ 'label' => __( 'Title', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Frequently Asked Questions', 'tanzania-sensational' ) ] );
        $this->add_control( 'subtitle', [ 'label' => __( 'Introduction', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => __( "Everything you need to know about climbing Kilimanjaro, preparation, safety, and booking. Can't find your answer? Contact our team directly.", 'tanzania-sensational' ) ] );
        $this->add_control( 'search_placeholder', [ 'label' => __( 'Search Placeholder', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Search questions...', 'tanzania-sensational' ) ] );
        $this->end_controls_section();

        $this->start_controls_section( 'cta', [ 'label' => __( 'Contact CTA', 'tanzania-sensational' ) ] );
        $this->add_control( 'cta_title', [ 'label' => __( 'Heading', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Still have questions?', 'tanzania-sensational' ) ] );
        $this->add_control( 'cta_text', [ 'label' => __( 'Description', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'default' => __( 'Our expert team is here to help you plan your perfect adventure.', 'tanzania-sensational' ) ] );
        $this->add_control( 'contact_label', [ 'label' => __( 'Contact Button', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Contact Us', 'tanzania-sensational' ) ] );
        $this->add_control( 'contact_url', [ 'label' => __( 'Contact Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/contact' ] ] );
        $this->add_control( 'phone', [ 'label' => __( 'Phone', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => '+255-621220912' ] );
        $this->end_controls_section();

        $this->start_controls_section( 'visibility', [ 'label' => __( 'Section Visibility', 'tanzania-sensational' ) ] );
        foreach ( [ 'hide_hero' => [ 'Hide Hero', '.utility-hero' ], 'hide_filters' => [ 'Hide Search & Filters', '.faq-controls-section' ], 'hide_questions' => [ 'Hide Questions', '.utility-content' ], 'hide_cta' => [ 'Hide Contact CTA', '.faq-contact-cta' ] ] as $key => $section ) {
            $this->add_control( $key, [ 'label' => __( $section[0], 'tanzania-sensational' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '', 'selectors' => [ '{{WRAPPER}} ' . $section[1] => 'display:none;' ] ] );
        }
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $html = do_shortcode( '[ts_faq_page]' );
        $digits = preg_replace( '/\D/', '', $s['phone'] );
        $replace = [
            '<span class="utility-hero-eyebrow">Your Questions Answered</span>' => '<span class="utility-hero-eyebrow">' . esc_html( $s['eyebrow'] ) . '</span>',
            '>Frequently Asked Questions</h1>' => '>' . esc_html( $s['title'] ) . '</h1>',
            '<p class="utility-hero-subtitle">Everything you need to know about climbing Kilimanjaro, preparation, safety, and booking. Can\'t find your answer? Contact our team directly.</p>' => '<p class="utility-hero-subtitle">' . esc_html( $s['subtitle'] ) . '</p>',
            'placeholder="Search questions..."' => 'placeholder="' . esc_attr( $s['search_placeholder'] ) . '"',
            '<h3>Still have questions?</h3>' => '<h3>' . esc_html( $s['cta_title'] ) . '</h3>',
            '<p>Our expert team is here to help you plan your perfect adventure.</p>' => '<p>' . esc_html( $s['cta_text'] ) . '</p>',
            'href="/contact" class="cta-btn primary"' => 'href="' . esc_url( $s['contact_url']['url'] ?: '/contact' ) . '" class="cta-btn primary"',
            '                        Contact Us' => '                        ' . esc_html( $s['contact_label'] ),
            'href="tel:+255787654321"' => 'href="tel:' . esc_attr( $digits ) . '"',
            'Call +255 787 654 321' => 'Call ' . esc_html( $s['phone'] ),
        ];
        echo strtr( $html, $replace ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
