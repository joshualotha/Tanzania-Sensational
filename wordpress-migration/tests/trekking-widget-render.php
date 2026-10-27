<?php

declare(strict_types=1);

namespace Elementor {
    final class Controls_Manager
    {
        public const TEXT = 'text';
    }

    class Widget_Base
    {
        public function get_settings_for_display(): array
        {
            return $GLOBALS['ts_trekking_widget_test_settings'] ?? [];
        }

        protected function start_controls_section(string $id, array $args): void {}
        protected function add_control(string $id, array $args): void {}
        protected function end_controls_section(): void {}
    }

    final class Plugin
    {
        public static ?self $instance = null;
        public ?object $editor = null;
    }

    final class Test_Editor
    {
        public function __construct(private bool $edit_mode) {}
        public function is_edit_mode(): bool { return $this->edit_mode; }
    }
}

namespace {
    if (!defined('ABSPATH')) {
        define('ABSPATH', __DIR__ . '/');
    }

    function __(string $text, string $domain = ''): string { return $text; }
    function esc_html__(string $text, string $domain = ''): string { return esc_html($text); }
    function esc_attr_e(string $text, string $domain = ''): void { echo esc_attr($text); }
    function esc_html_e(string $text, string $domain = ''): void { echo esc_html($text); }
    function esc_html($value): string { return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
    function esc_attr($value): string { return esc_html($value); }
    function esc_url($value): string { return esc_html($value); }
    function wp_kses_post($value): string { return strip_tags((string) $value, '<p><strong><em><ul><ol><li><a><br>'); }
    function home_url(string $path = ''): string { return 'https://test.tanzaniasensational.com' . $path; }
    function add_shortcode(string $tag, callable $callback): void {}

    $GLOBALS['ts_trekking_widget_test_singular'] = false;
    $GLOBALS['ts_trekking_widget_test_post_id'] = 0;
    $GLOBALS['ts_trekking_widget_test_title'] = '';
    $GLOBALS['ts_trekking_widget_test_fields'] = [];
    $GLOBALS['ts_trekking_widget_test_settings'] = [];
    function is_singular(string $post_type = ''): bool
    {
        return !empty($GLOBALS['ts_trekking_widget_test_singular']) && $post_type === 'ts_trek_route';
    }
    function get_the_ID(): int { return (int) $GLOBALS['ts_trekking_widget_test_post_id']; }
    function get_the_title(int $post_id): string { return (string) $GLOBALS['ts_trekking_widget_test_title']; }
    function get_field(string $field_name, $post_id = false) { return $GLOBALS['ts_trekking_widget_test_fields'][$field_name] ?? null; }

    $plugin_root = __DIR__ . '/../staging-plugin';
    require $plugin_root . '/trekking-content.php';
    require $plugin_root . '/elementor/widgets/class-ts-single-trek-route-widget.php';

    final class Testable_TS_Single_Trek_Route_Widget extends \TS_Single_Trek_Route_Widget
    {
        public function render_for_test(): void { $this->render(); }
    }

    function ts_trekking_widget_render_capture(): string
    {
        ob_start();
        try {
            (new Testable_TS_Single_Trek_Route_Widget())->render_for_test();
        } catch (\Throwable $error) {
            ob_end_clean();
            throw new \RuntimeException('Elementor widget rendering should tolerate an incomplete preview context: ' . $error->getMessage(), 0, $error);
        }
        return (string) ob_get_clean();
    }

    $GLOBALS['ts_trekking_widget_test_singular'] = true;
    $GLOBALS['ts_trekking_widget_test_post_id'] = 0;
    \Elementor\Plugin::$instance = new \Elementor\Plugin();
    $no_editor_context = ts_trekking_widget_render_capture();
    if ($no_editor_context !== '') {
        throw new \RuntimeException('The widget should render nothing for an empty route preview outside edit mode.');
    }

    \Elementor\Plugin::$instance = null;
    $no_elementor_instance = ts_trekking_widget_render_capture();
    if ($no_elementor_instance !== '') {
        throw new \RuntimeException('The widget should render nothing when Elementor has no initialized editor instance.');
    }

    \Elementor\Plugin::$instance = new \Elementor\Plugin();
    \Elementor\Plugin::$instance->editor = (object) [];
    $invalid_editor_context = ts_trekking_widget_render_capture();
    if ($invalid_editor_context !== '') {
        throw new \RuntimeException('The widget should ignore editor objects without the edit-mode API.');
    }

    \Elementor\Plugin::$instance = new \Elementor\Plugin();
    \Elementor\Plugin::$instance->editor = new \Elementor\Test_Editor(true);
    $preview_placeholder = ts_trekking_widget_render_capture();
    if (!str_contains($preview_placeholder, 'Choose a Trekking Route in Elementor Preview Settings')) {
        throw new \RuntimeException('An empty route preview should show guidance while Elementor is actively editing.');
    }

    $GLOBALS['ts_trekking_widget_test_singular'] = true;
    $GLOBALS['ts_trekking_widget_test_post_id'] = 481;
    $GLOBALS['ts_trekking_widget_test_title'] = 'Lemosho Route from Elementor';
    $GLOBALS['ts_trekking_widget_test_fields'] = [
        'ts_trek_duration' => '7 Days',
        'ts_trek_difficulty' => 'Challenging',
        'ts_trek_distance' => '70 km',
        'ts_trek_elevation_gain' => '4,000 m',
        'ts_trek_overview' => '<p>Widget preview route overview.</p>',
        'ts_trek_highlights' => [],
        'ts_trek_itinerary' => [],
        'ts_trek_inclusions' => [],
        'ts_trek_exclusions' => [],
        'ts_trek_hero_image_url' => '',
        'ts_trek_hero_image_alt' => '',
        'ts_trek_gallery_urls' => [],
    ];
    $GLOBALS['ts_trekking_widget_test_settings'] = [
        'overview_title' => 'Custom Widget Overview',
        'inclusions_section_title' => 'Custom Included Section',
    ];
    $route_render = ts_trekking_widget_render_capture();
    if (!str_contains($route_render, '<h1>Lemosho Route from Elementor</h1>') || !str_contains($route_render, 'Widget preview route overview.') || !str_contains($route_render, 'Custom Widget Overview')) {
        throw new \RuntimeException('The Elementor widget must render the selected route with its editor settings.');
    }

    echo "PASS: trekking Elementor widget renders route data and safely handles missing preview context.\n";
}
