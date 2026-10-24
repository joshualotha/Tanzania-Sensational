<?php
/** Editable Theme Builder shell for individual Destination content. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_Single_Destination_Widget extends Widget_Base {
    public function get_name() { return 'ts_single_destination'; }
    public function get_title() { return __( 'TS Single Destination', 'tanzania-sensational' ); }
    public function get_icon() { return 'eicon-single-post'; }
    public function get_categories() { return [ 'ts-widgets' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'labels', [ 'label' => __( 'Section Labels', 'tanzania-sensational' ) ] );
        $controls = [
            'experience_title' => [ 'Experience Heading', 'The Experience' ],
            'atmosphere_title' => [ 'Atmosphere Heading', 'Atmosphere' ],
            'wildlife_title'   => [ 'Wildlife Heading', 'Wildlife' ],
            'impact_title'     => [ 'Impact Heading', 'Impact' ],
            'highlights_title' => [ 'Highlights Heading', 'Highlights' ],
            'gallery_title'    => [ 'Gallery Heading', 'Gallery' ],
        ];
        foreach ( $controls as $key => $control ) {
            $this->add_control( $key, [ 'label' => __( $control[0], 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( $control[1], 'tanzania-sensational' ) ] );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'vitals', [ 'label' => __( 'Vital Labels', 'tanzania-sensational' ) ] );
        $vitals = [
            'coordinates_label' => [ 'Coordinates Label', 'Coordinates' ],
            'elevation_label'   => [ 'Elevation Label', 'Elevation' ],
            'duration_label'    => [ 'Duration Label', 'Duration' ],
            'best_time_label'   => [ 'Best Time Label', 'Best Time' ],
            'encounter_label'   => [ 'Encounter Rate Label', 'Encounter Rate' ],
            'tier_label'        => [ 'Tier Label', 'Tier' ],
            'tracking_label'    => [ 'Tracking Label', 'Tracking' ],
        ];
        foreach ( $vitals as $key => $control ) {
            $this->add_control( $key, [ 'label' => __( $control[0], 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( $control[1], 'tanzania-sensational' ) ] );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'action', [ 'label' => __( 'Call to Action', 'tanzania-sensational' ) ] );
        $this->add_control( 'cta_text', [ 'label' => __( 'Button Text', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Plan a Safari Here', 'tanzania-sensational' ) ] );
        $this->add_control( 'cta_url', [ 'label' => __( 'Button Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/contact' ] ] );
        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $html = do_shortcode( '[ts_single_destination]' );
        if ( '' === trim( $html ) ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div class="ts-elementor-placeholder">' . esc_html__( 'Choose a Destination in Elementor Preview Settings to preview this dynamic template.', 'tanzania-sensational' ) . '</div>';
            }
            return;
        }
        $replace = [
            '<h2>The Experience</h2>' => '<h2>' . esc_html( $s['experience_title'] ) . '</h2>',
            '<h3>Atmosphere</h3>' => '<h3>' . esc_html( $s['atmosphere_title'] ) . '</h3>',
            '<h3>Wildlife</h3>' => '<h3>' . esc_html( $s['wildlife_title'] ) . '</h3>',
            '<h3>Impact</h3>' => '<h3>' . esc_html( $s['impact_title'] ) . '</h3>',
            '<h2>Highlights</h2>' => '<h2>' . esc_html( $s['highlights_title'] ) . '</h2>',
            '<h2>Wildlife</h2>' => '<h2>' . esc_html( $s['wildlife_title'] ) . '</h2>',
            '<h2>Gallery</h2>' => '<h2>' . esc_html( $s['gallery_title'] ) . '</h2>',
            '<span>Coordinates</span>' => '<span>' . esc_html( $s['coordinates_label'] ) . '</span>',
            '<span>Elevation</span>' => '<span>' . esc_html( $s['elevation_label'] ) . '</span>',
            '<span>Duration</span>' => '<span>' . esc_html( $s['duration_label'] ) . '</span>',
            '<span>Best Time</span>' => '<span>' . esc_html( $s['best_time_label'] ) . '</span>',
            '<span>Encounter Rate</span>' => '<span>' . esc_html( $s['encounter_label'] ) . '</span>',
            '<span>Tier</span>' => '<span>' . esc_html( $s['tier_label'] ) . '</span>',
            '<span>Tracking</span>' => '<span>' . esc_html( $s['tracking_label'] ) . '</span>',
            'href="/contact" class="ts-btn-primary">Plan a Safari Here<' => 'href="' . esc_url( $s['cta_url']['url'] ?: '/contact' ) . '" class="ts-btn-primary">' . esc_html( $s['cta_text'] ) . '<',
        ];
        echo strtr( $html, $replace ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
