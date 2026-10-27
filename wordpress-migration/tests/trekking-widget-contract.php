<?php

declare(strict_types=1);

function ts_trekking_widget_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$plugin_root = __DIR__ . '/../staging-plugin';
$widget_path = $plugin_root . '/elementor/widgets/class-ts-single-trek-route-widget.php';
$widget_bootstrap = (string) file_get_contents($plugin_root . '/elementor-widgets.php');
$plugin_bootstrap = (string) file_get_contents($plugin_root . '/tanzania-sensational-design.php');
$css_path = $plugin_root . '/trekking-content.css';
ts_trekking_widget_assert(is_file($css_path), 'Trekking route pages have a dedicated responsive stylesheet.');
$css = (string) file_get_contents($css_path);
ts_trekking_widget_assert(str_contains($css, '.ts-trek-route-hero'), 'The route hero has a dedicated layout.');
ts_trekking_widget_assert(str_contains($css, '@media (max-width: 767px)'), 'The route layout has a mobile composition.');
ts_trekking_widget_assert(str_contains($css, 'min-width: 0'), 'Route content can shrink without forcing horizontal overflow.');
ts_trekking_widget_assert(str_contains($plugin_bootstrap, "is_singular( 'ts_trek_route' )"), 'Trekking route styles are limited to route detail pages.');
ts_trekking_widget_assert(str_contains($plugin_bootstrap, "'trekking-content.css'"), 'The active design plugin enqueues route styling.');
ts_trekking_widget_assert(is_file($widget_path), 'The single trekking route Elementor widget exists.');
$widget = (string) file_get_contents($widget_path);
ts_trekking_widget_assert(str_contains($widget, "return 'ts_single_trek_route';"), 'The widget has a stable Elementor identifier.');
ts_trekking_widget_assert(str_contains($widget, 'ts_render_trek_route_post($post_id, $settings)'), 'Elementor section-label controls flow into the route renderer.');
ts_trekking_widget_assert(str_contains($widget_bootstrap, "class-ts-single-trek-route-widget.php"), 'The widget class is loaded when Elementor registers custom widgets.');
ts_trekking_widget_assert(str_contains($widget_bootstrap, 'new TS_Single_Trek_Route_Widget()'), 'The single route widget is registered with Elementor.');
foreach (['overview_title', 'highlights_title', 'itinerary_title', 'included_title', 'excluded_title', 'inclusions_section_title', 'cta_title'] as $control) {
    ts_trekking_widget_assert(str_contains($widget, "'{$control}'"), 'The Elementor widget exposes the reusable section control ' . $control . '.');
}

echo "PASS: trekking route content is available as an editable Elementor widget.\n";
