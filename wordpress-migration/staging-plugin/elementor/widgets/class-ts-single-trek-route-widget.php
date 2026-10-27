<?php
/** Editable Elementor Theme Builder widget for individual trekking routes. */

if (!defined('ABSPATH')) {
    exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

class TS_Single_Trek_Route_Widget extends Widget_Base
{
    public function get_name()
    {
        return 'ts_single_trek_route';
    }

    public function get_title()
    {
        return __('TS Single Trekking Route', 'tanzania-sensational');
    }

    public function get_icon()
    {
        return 'eicon-map-pin';
    }

    public function get_categories()
    {
        return ['ts-widgets'];
    }

    protected function register_controls()
    {
        $this->start_controls_section('labels', [
            'label' => __('Section Labels', 'tanzania-sensational'),
        ]);

        foreach ([
            'overview_title' => ['Overview Heading', 'Route Overview'],
            'highlights_title' => ['Highlights Heading', 'Route Highlights'],
            'itinerary_title' => ['Itinerary Heading', 'Day-by-Day Itinerary'],
            'included_title' => ['Included Heading', 'Included'],
            'excluded_title' => ['Not Included Heading', 'Not Included'],
            'inclusions_section_title' => ['Included & Excluded Section Heading', ''],
            'cta_title' => ['Contact Heading', 'Plan this route with our team'],
        ] as $key => $control) {
            $this->add_control($key, [
                'label' => __($control[0], 'tanzania-sensational'),
                'type' => Controls_Manager::TEXT,
                'default' => __($control[1], 'tanzania-sensational'),
            ]);
        }

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $post_id = function_exists('get_the_ID') ? (int) get_the_ID() : 0;
        $html = function_exists('ts_render_trek_route_post')
            ? ts_render_trek_route_post($post_id, $settings)
            : '';

        if ('' === trim($html)) {
            $elementor = class_exists(\Elementor\Plugin::class) && isset(\Elementor\Plugin::$instance)
                ? \Elementor\Plugin::$instance
                : null;
            $editor = is_object($elementor) ? ($elementor->editor ?? null) : null;
            if (is_object($editor) && is_callable([$editor, 'is_edit_mode']) && $editor->is_edit_mode()) {
                echo '<div class="ts-elementor-placeholder">' . esc_html__('Choose a Trekking Route in Elementor Preview Settings to preview this template.', 'tanzania-sensational') . '</div>';
            }
            return;
        }

        echo $html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- renderer escapes route data and Elementor labels.
    }
}
