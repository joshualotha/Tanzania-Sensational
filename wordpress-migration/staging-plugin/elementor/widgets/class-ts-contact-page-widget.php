<?php
/** Editable Elementor presentation shell for the Contact page. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_Contact_Page_Widget extends Widget_Base {
    public function get_name() { return 'ts_contact_page'; }
    public function get_title() { return __( 'TS Contact Page', 'tanzania-sensational' ); }
    public function get_icon() { return 'eicon-form-horizontal'; }
    public function get_categories() { return [ 'ts-widgets' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'hero', [ 'label' => __( 'Hero', 'tanzania-sensational' ) ] );
        $this->add_control( 'hero_eyebrow', [ 'label' => __( 'Eyebrow', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Basecamp Communications', 'tanzania-sensational' ) ] );
        $this->add_control( 'hero_title', [ 'label' => __( 'Title', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Connect with Excellence', 'tanzania-sensational' ) ] );
        $this->add_control( 'emphasized_word', [ 'label' => __( 'Italicized Word', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Excellence', 'tanzania-sensational' ) ] );
        $this->end_controls_section();

        $this->start_controls_section( 'contact', [ 'label' => __( 'Contact Details', 'tanzania-sensational' ) ] );
        $this->add_control( 'phone', [ 'label' => __( 'Phone', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => '+255-621220912' ] );
        $this->add_control( 'email', [ 'label' => __( 'Email', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'info@tanzaniasensational.co.tz' ] );
        $this->add_control( 'whatsapp_text', [ 'label' => __( 'WhatsApp Label', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Message an Expert', 'tanzania-sensational' ) ] );
        $this->add_control( 'whatsapp_url', [ 'label' => __( 'WhatsApp Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => 'https://wa.me/255621220912' ] ] );
        $this->end_controls_section();

        $this->start_controls_section( 'form', [ 'label' => __( 'Inquiry Form', 'tanzania-sensational' ) ] );
        $this->add_control( 'form_title', [ 'label' => __( 'Heading', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Plan your journey', 'tanzania-sensational' ) ] );
        $this->add_control( 'form_subtitle', [ 'label' => __( 'Introduction', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'default' => __( 'Provide your details, and an expert will respond within 24 hours.', 'tanzania-sensational' ) ] );
        $this->add_control( 'submit_text', [ 'label' => __( 'Submit Label', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Send inquiry', 'tanzania-sensational' ) ] );
        $this->end_controls_section();

        $this->start_controls_section( 'visibility', [ 'label' => __( 'Section Visibility', 'tanzania-sensational' ) ] );
        foreach ( [ 'hide_hero' => [ 'Hide Hero', '.premium-hero' ], 'hide_form' => [ 'Hide Contact & Form', '.premium-desk-section' ], 'hide_map' => [ 'Hide Map', '.premium-map-section' ] ] as $key => $section ) {
            $this->add_control( $key, [ 'label' => __( $section[0], 'tanzania-sensational' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '', 'selectors' => [ '{{WRAPPER}} ' . $section[1] => 'display:none;' ] ] );
        }
        $this->end_controls_section();
    }

    private function styled_title( $title, $word ) {
        $title = esc_html( $title );
        return trim( $word ) ? preg_replace( '/(' . preg_quote( esc_html( trim( $word ) ), '/' ) . ')/i', '<em>$1</em>', $title, 1 ) : $title;
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $html = do_shortcode( '[ts_contact_page]' );
        $phone_digits = preg_replace( '/\D/', '', $s['phone'] );
        $replace = [
            '<span class="premium-hero-eyebrow">Basecamp Communications</span>' => '<span class="premium-hero-eyebrow">' . esc_html( $s['hero_eyebrow'] ) . '</span>',
            '<h1 class="premium-hero-title">Connect with <em>Excellence</em></h1>' => '<h1 class="premium-hero-title">' . wp_kses( $this->styled_title( $s['hero_title'], $s['emphasized_word'] ), [ 'em' => [] ] ) . '</h1>',
            'href="tel:+255-621220912" class="premium-contact-val">+255-621220912<' => 'href="tel:' . esc_attr( $phone_digits ) . '" class="premium-contact-val">' . esc_html( $s['phone'] ) . '<',
            'href="https://wa.me/255621220912" class="premium-contact-val" style="color:#25D366;">Message an Expert<' => 'href="' . esc_url( $s['whatsapp_url']['url'] ) . '" class="premium-contact-val" style="color:#25D366;">' . esc_html( $s['whatsapp_text'] ) . '<',
            'href="mailto:info@tanzaniasensational.co.tz" class="premium-contact-val">info@tanzaniasensational.co.tz<' => 'href="mailto:' . esc_attr( $s['email'] ) . '" class="premium-contact-val">' . esc_html( $s['email'] ) . '<',
            '<h2 class="premium-form-title">Plan your journey</h2>' => '<h2 class="premium-form-title">' . esc_html( $s['form_title'] ) . '</h2>',
            '<p class="premium-form-subtitle">Provide your details, and an expert will respond within 24 hours.</p>' => '<p class="premium-form-subtitle">' . esc_html( $s['form_subtitle'] ) . '</p>',
            '<button type="submit" class="premium-submit-btn"><span>Send inquiry</span>' => '<button type="submit" class="premium-submit-btn"><span>' . esc_html( $s['submit_text'] ) . '</span>',
        ];
        echo strtr( $html, $replace ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
