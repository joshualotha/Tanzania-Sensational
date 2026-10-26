<?php

declare(strict_types=1);

define('ABSPATH', __DIR__);
$GLOBALS['destination_test_field_groups'] = [];

function __(string $text, string $domain = ''): string
{
    return $text;
}

function add_action(string $hook, callable $callback): void
{
    if ('acf/include_fields' === $hook) {
        $callback();
    }
}

function acf_add_local_field_group(array $group): void
{
    $GLOBALS['destination_test_field_groups'][$group['key']] = $group;
}

require dirname(__DIR__) . '/staging-plugin/acf-fields.php';
$fields = $GLOBALS['destination_test_field_groups']['group_ts_destination']['fields'] ?? [];
$by_name = [];
foreach ($fields as $field) {
    $by_name[$field['name']] = $field;
}

$required_types = [
    'ts_dest_hero_image_url' => 'url',
    'ts_dest_gallery_urls' => 'repeater',
    'ts_dest_meta_title' => 'text',
    'ts_dest_meta_description' => 'textarea',
    'ts_dest_atmosphere_footer' => 'text',
    'ts_dest_wildlife_footer' => 'text',
];
foreach ($required_types as $name => $type) {
    if (($by_name[$name]['type'] ?? null) !== $type) {
        throw new RuntimeException(sprintf('Destination ACF field %s must use type %s.', $name, $type));
    }
}
$gallery_subfields = array_column($by_name['ts_dest_gallery_urls']['sub_fields'] ?? [], 'name');
if (!in_array('url', $gallery_subfields, true) || !in_array('alt', $gallery_subfields, true)) {
    throw new RuntimeException('Source gallery rows must preserve both the live image URL and its source alt text.');
}

echo "PASS: destination ACF schema supports exact live URLs, alt text and source closing lines.\n";
