<?php
/** Elementor wrapper for the structured ACF About page renderer. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_About_Page_Widget extends Widget_Base {
    public function get_name() { return 'ts_about_page'; }
    public function get_title() { return __( 'TS About Page', 'tanzania-sensational' ); }
    public function get_icon() { return 'eicon-site-identity'; }
    public function get_categories() { return [ 'ts-widgets' ]; }

    protected function register_controls() {
        $pages = [];
        foreach ( get_pages( [ 'sort_column' => 'post_title' ] ) as $page ) {
            $pages[ $page->ID ] = $page->post_title;
        }
        $this->start_controls_section( 'content', [ 'label' => __( 'About Content', 'tanzania-sensational' ) ] );
        $this->add_control( 'source_page', [
            'label' => __( 'Content Source', 'tanzania-sensational' ), 'type' => Controls_Manager::SELECT2,
            'options' => $pages, 'default' => 18,
            'description' => __( 'Edit the selected page to change its structured About Page Content fields.', 'tanzania-sensational' ),
        ] );
        $this->add_control( 'editor_note', [
            'type' => Controls_Manager::RAW_HTML,
            'raw' => __( 'Page copy, images, statistics, values, mission, vision, and experience items are managed in the About Page Content fields. These controls determine which designed sections are visible.', 'tanzania-sensational' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ] );
        $this->end_controls_section();

        $this->start_controls_section( 'visibility', [ 'label' => __( 'Section Visibility', 'tanzania-sensational' ) ] );
        $sections = [
            'hide_hero' => [ 'Hide Hero & Statistics', '.premium-about-hero' ],
            'hide_story' => [ 'Hide Story', '.premium-story-section' ],
            'hide_mission' => [ 'Hide Mission & Vision', '.premium-mv-section' ],
            'hide_values' => [ 'Hide Values', '.premium-values-section' ],
            'hide_experience' => [ 'Hide Experience Band', '.premium-exp-section' ],
        ];
        foreach ( $sections as $key => $section ) {
            $this->add_control( $key, [
                'label' => __( $section[0], 'tanzania-sensational' ), 'type' => Controls_Manager::SWITCHER,
                'return_value' => 'yes', 'default' => '',
                'selectors' => [ '{{WRAPPER}} ' . $section[1] => 'display: none;' ],
            ] );
        }
        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $post_id = absint( $settings['source_page'] ) ?: get_the_ID();
        if ( function_exists( 'get_field' ) && get_field( 'ts_about_hero_title', $post_id ) ) {
            echo ts_render_about_page_acf( $post_id ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        } else {
            echo ts_about_page_legacy(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        }
    }
}
