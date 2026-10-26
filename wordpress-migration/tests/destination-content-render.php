<?php

declare(strict_types=1);

define('ABSPATH', __DIR__);

$GLOBALS['destination_test_shortcodes'] = [];
$GLOBALS['destination_test_fields'] = [];
$GLOBALS['destination_test_content'] = '';

function add_shortcode(string $tag, callable $callback): void
{
    $GLOBALS['destination_test_shortcodes'][$tag] = $callback;
}

function add_filter(string $tag, callable $callback, int $priority = 10, int $accepted_args = 1): void
{
}

function is_singular(string $post_type = ''): bool
{
    return 'ts_destination' === $post_type;
}

function get_the_ID(): int
{
    return 101;
}

function get_the_title(int $post_id = 0): string
{
    return 'Nyerere National Park';
}

function get_post_field(string $field, int $post_id): string
{
    return $GLOBALS['destination_test_content'];
}

function get_field(string $key, int $post_id = 0)
{
    return $GLOBALS['destination_test_fields'][$key] ?? null;
}

function apply_filters(string $hook, $value)
{
    return $value;
}

function esc_html($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function esc_attr($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function esc_url($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function wp_kses_post($value): string
{
    return strip_tags((string) $value, '<p><strong><em><a><ul><ol><li><br>');
}

require dirname(__DIR__) . '/staging-plugin/dynamic-content.php';

$GLOBALS['destination_test_content'] = '<p>Source-backed Rufiji River overview.</p>';
$GLOBALS['destination_test_fields'] = [
    'ts_dest_subtitle' => '. River.',
    'ts_dest_tag' => 'EXPERTLY CURATED DESTINATION',
    'ts_dest_short_description' => 'An expansive wilderness shaped by the Rufiji River.',
    'ts_dest_overview_quote' => 'Drifting down the Rufiji at dusk.',
    'ts_dest_coordinates' => '8.8000° S, 37.8333° E',
    'ts_dest_elevation' => '100m – 400m',
    'ts_dest_best_time' => 'June to October (Dry Season)',
    'ts_dest_encounter_rate' => '91.5%',
    'ts_dest_expedition_tier' => 'Frontier Tier 03',
    'ts_dest_tracking_method' => 'Boat Safari & Bush Walk',
    'ts_dest_hero_image_url' => 'https://tanzaniasensational.com/storage/destinations/nyerere.jpg',
    'ts_dest_gallery_urls' => [
        ['url' => 'https://tanzaniasensational.com/storage/destinations/gallery/nyerere-1.jpg', 'alt' => 'Nyerere River — gallery image 1'],
    ],
    'ts_dest_atmosphere_vitals' => [
        ['label' => 'Sensory Vibe', 'text' => 'Humid riverine lushness meeting dry bush.'],
        ['label' => 'Audio Profile', 'text' => 'Hippo grunts and the cry of the Fish Eagle.'],
    ],
    'ts_dest_atmosphere_footer' => 'Life orchestrated by the flow of the mighty Rufiji.',
    'ts_dest_wildlife_vitals' => [
        ['label' => 'Key Species', 'text' => 'Wild Dogs, Hippos, Crocs, Buffalo, Elephants.'],
        ['label' => 'ENCOUNTER PROB', 'text' => '91.5% (Riverine zones)'],
    ],
    'ts_dest_wildlife_footer' => 'Superb aquatic birding with over 440 species.',
];

$html = ($GLOBALS['destination_test_shortcodes']['ts_single_destination'])();
$expected = [
    'Source-backed Rufiji River overview.',
    'Humid riverine lushness meeting dry bush.',
    'Hippo grunts and the cry of the Fish Eagle.',
    'Life orchestrated by the flow of the mighty Rufiji.',
    'Wild Dogs, Hippos, Crocs, Buffalo, Elephants.',
    '91.5% (Riverine zones)',
    'Superb aquatic birding with over 440 species.',
    'https://tanzaniasensational.com/storage/destinations/nyerere.jpg',
];
foreach ($expected as $value) {
    if (!str_contains($html, $value)) {
        throw new RuntimeException('Destination page omitted source-backed content: ' . $value);
    }
}
if (substr_count($html, '<h1') !== 1 || substr_count($html, '<img') < 2) {
    throw new RuntimeException('Destination page must keep one page heading and render hero plus gallery media.');
}
if (!str_contains($html, '<span class="ts-single-dest-tag">EXPERTLY CURATED DESTINATION</span>')
    || !str_contains($html, '<h1>Nyerere National Park<em>. River.</em></h1>')
    || str_contains($html, '<p class="ts-single-dest-subtitle">')) {
    throw new RuntimeException('Destination hero must preserve the live source label and combined heading markup.');
}
foreach (['Best Season', 'Expedition Ledger', 'Primary Success', 'Optimal Cycle', 'Expedition Level', 'Tracking Protocol'] as $source_label) {
    if (!str_contains($html, $source_label)) {
        throw new RuntimeException('Destination page omitted a live source detail label: ' . $source_label);
    }
}
if (substr_count($html, 'June to October (Dry Season)') < 2) {
    throw new RuntimeException('Destination expedition ledger must retain the source best-season value.');
}
if (str_contains($html, 'Life orchestrated by the flow of the mighty Rufiji.</script>')) {
    throw new RuntimeException('Destination content must remain escaped/rendered as safe text.');
}

echo "PASS: destination page renders source-backed overview, vitals, footers and live media.\n";
