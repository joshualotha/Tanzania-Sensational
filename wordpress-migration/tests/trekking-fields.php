<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

$GLOBALS['ts_trekking_test_actions'] = [];
$GLOBALS['ts_trekking_test_groups'] = [];

function add_action(string $hook, callable $callback): void
{
    $GLOBALS['ts_trekking_test_actions'][$hook][] = $callback;
}

function __(string $text, string $domain = ''): string
{
    return $text;
}

function acf_add_local_field_group(array $group): void
{
    $GLOBALS['ts_trekking_test_groups'][$group['key']] = $group;
}

$field_file = dirname(__DIR__) . '/staging-plugin/trekking-fields.php';
if (is_file($field_file)) {
    require $field_file;
}

foreach ($GLOBALS['ts_trekking_test_actions']['acf/init'] ?? [] as $callback) {
    $callback();
}

$group = $GLOBALS['ts_trekking_test_groups']['group_ts_trek_route'] ?? null;
if (!is_array($group)) {
    throw new RuntimeException('Trekking route ACF fields must be registered for editors.');
}

$fields = [];
foreach ($group['fields'] as $field) {
    $fields[$field['name']] = $field;
}
$required_types = [
    'ts_trek_duration' => 'text',
    'ts_trek_route_family' => 'text',
    'ts_trek_duration_variant' => 'text',
    'ts_trek_difficulty' => 'text',
    'ts_trek_distance' => 'text',
    'ts_trek_elevation_gain' => 'text',
    'ts_trek_success_rate' => 'text',
    'ts_trek_accommodation_style' => 'text',
    'ts_trek_base_price' => 'number',
    'ts_trek_currency' => 'text',
    'ts_trek_featured' => 'true_false',
    'ts_trek_display_order' => 'number',
    'ts_trek_hero_image_url' => 'url',
    'ts_trek_hero_image_alt' => 'text',
    'ts_trek_editorial_image_url' => 'url',
    'ts_trek_gallery_urls' => 'repeater',
    'ts_trek_overview' => 'wysiwyg',
    'ts_trek_highlights' => 'repeater',
    'ts_trek_itinerary' => 'repeater',
    'ts_trek_inclusions' => 'repeater',
    'ts_trek_exclusions' => 'repeater',
    'ts_trek_source_url' => 'url',
    'ts_trek_meta_title' => 'text',
    'ts_trek_meta_description' => 'textarea',
];
foreach ($required_types as $name => $type) {
    if (($fields[$name]['type'] ?? null) !== $type) {
        throw new RuntimeException(sprintf('Expected trekking field %s of type %s.', $name, $type));
    }
}

$locations = $group['location'][0] ?? [];
if (($locations[0]['param'] ?? null) !== 'post_type' || ($locations[0]['value'] ?? null) !== 'ts_trek_route') {
    throw new RuntimeException('Trekking route fields must only attach to the dedicated route post type.');
}

$itinerary_names = array_column($fields['ts_trek_itinerary']['sub_fields'] ?? [], 'name');
foreach (['day', 'title', 'description', 'elevation', 'distance', 'habitat', 'meals', 'camp'] as $name) {
    if (!in_array($name, $itinerary_names, true)) {
        throw new RuntimeException('Trekking itinerary is missing structured day field: ' . $name);
    }
}

$gallery_names = array_column($fields['ts_trek_gallery_urls']['sub_fields'] ?? [], 'name');
if (!in_array('url', $gallery_names, true) || !in_array('alt', $gallery_names, true)) {
    throw new RuntimeException('Trekking gallery rows must keep verified source URLs with their alt text.');
}

echo "PASS: trekking route ACF schema exposes source-backed editorial fields.\n";
