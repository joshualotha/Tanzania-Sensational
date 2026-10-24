<?php
/**
 * Editable Theme Builder shell for individual Tour content.
 *
 * Tour-specific data is managed on each ts_tour post through ACF. This widget
 * exposes the reusable presentation labels and CTA through Elementor.
 *
 * @package Tanzania_Sensational
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_Single_Tour_Widget extends Widget_Base {

    public function get_name() {
        return 'ts_single_tour';
    }

    public function get_title() {
        return __( 'TS Single Tour', 'tanzania-sensational' );
    }

    public function get_icon() {
        return 'eicon-single-post';
    }

    public function get_categories() {
        return [ 'ts-widgets' ];
    }

    protected function register_controls() {
        $this->start_controls_section( 'labels', [
            'label' => __( 'Section Labels', 'tanzania-sensational' ),
        ] );
        foreach ( [
            'overview_title'   => [ 'Overview Heading', 'Tour Overview' ],
            'highlights_title' => [ 'Highlights Heading', 'Highlights' ],
            'included_title'   => [ 'Included Heading', 'Included' ],
            'excluded_title'   => [ 'Excluded Heading', 'Not Included' ],
            'itinerary_title'  => [ 'Itinerary Heading', 'Itinerary' ],
            'stay_label'       => [ 'Accommodation Label', 'Stay' ],
            'meals_label'      => [ 'Meals Label', 'Meals' ],
            'elevation_label'  => [ 'Elevation Label', 'Elevation' ],
        ] as $key => $control ) {
            $this->add_control( $key, [
                'label'   => __( $control[0], 'tanzania-sensational' ),
                'type'    => Controls_Manager::TEXT,
                'default' => __( $control[1], 'tanzania-sensational' ),
            ] );
        }
        $this->end_controls_section();

        $this->start_controls_section( 'action', [
            'label' => __( 'Call to Action', 'tanzania-sensational' ),
        ] );
        $this->add_control( 'cta_text', [
            'label'   => __( 'Button Text', 'tanzania-sensational' ),
            'type'    => Controls_Manager::TEXT,
            'default' => __( 'Plan This Safari', 'tanzania-sensational' ),
        ] );
        $this->add_control( 'cta_url', [
            'label'   => __( 'Button Link', 'tanzania-sensational' ),
            'type'    => Controls_Manager::URL,
            'default' => [ 'url' => '/contact' ],
        ] );
        $this->end_controls_section();
    }

    private function replace_text( $html, $from, $to ) {
        return str_replace( $from, esc_html( $to ), $html );
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $html     = do_shortcode( '[ts_single_tour]' );

        if ( '' === trim( $html ) ) {
            if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
                echo '<div class="ts-elementor-placeholder">' . esc_html__( 'Choose a Tour in Elementor Preview Settings to preview this dynamic template.', 'tanzania-sensational' ) . '</div>';
            }
            return;
        }

        $replacements = [
            '<h2>Tour Overview</h2>' => '<h2>' . esc_html( $settings['overview_title'] ) . '</h2>',
            '<h2>Highlights</h2>'    => '<h2>' . esc_html( $settings['highlights_title'] ) . '</h2>',
            '<h3>Included</h3>'      => '<h3>' . esc_html( $settings['included_title'] ) . '</h3>',
            '<h3>Not Included</h3>'  => '<h3>' . esc_html( $settings['excluded_title'] ) . '</h3>',
            '<h2>Itinerary</h2>'     => '<h2>' . esc_html( $settings['itinerary_title'] ) . '</h2>',
            '>Stay: '                => '>' . esc_html( $settings['stay_label'] ) . ': ',
            '>Meals: '               => '>' . esc_html( $settings['meals_label'] ) . ': ',
            '>Elevation: '           => '>' . esc_html( $settings['elevation_label'] ) . ': ',
            'href="#ts-safari-booking" class="ts-btn-primary">Plan This Safari<' => 'href="#ts-safari-booking" class="ts-btn-primary">' . esc_html( $settings['cta_text'] ) . '<',
        ];

        echo strtr( $html, $replacements ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- shortcode renderer escapes its dynamic values.
    }
}
