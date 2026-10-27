<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

function __(string $text, string $domain = ''): string
{
    return $text;
}

function esc_html_e(string $text, string $domain = ''): void
{
    echo esc_html($text);
}

function esc_attr_e(string $text, string $domain = ''): void
{
    echo esc_attr($text);
}

$GLOBALS['ts_trekking_test_shortcodes'] = [];
function add_shortcode(string $tag, callable $callback): void
{
    $GLOBALS['ts_trekking_test_shortcodes'][$tag] = $callback;
}

$GLOBALS['ts_trekking_test_is_singular'] = false;
$GLOBALS['ts_trekking_test_post_id'] = 0;
$GLOBALS['ts_trekking_test_title'] = '';
$GLOBALS['ts_trekking_test_fields'] = [];
$GLOBALS['ts_trekking_test_field_post_ids'] = [];
function is_singular(string $post_type = ''): bool
{
    return !empty($GLOBALS['ts_trekking_test_is_singular']) && $post_type === 'ts_trek_route';
}
function get_the_ID(): int
{
    return (int) $GLOBALS['ts_trekking_test_post_id'];
}
function get_the_title(int $post_id): string
{
    if ($post_id !== (int) $GLOBALS['ts_trekking_test_post_id']) {
        throw new RuntimeException('The route shortcode must use the current post ID for its title.');
    }
    return (string) $GLOBALS['ts_trekking_test_title'];
}
function get_field(string $field_name, $post_id = false)
{
    $GLOBALS['ts_trekking_test_field_post_ids'][$field_name] = (int) $post_id;
    return $GLOBALS['ts_trekking_test_fields'][$field_name] ?? null;
}

function home_url(string $path = ''): string
{
    return 'https://test.tanzaniasensational.com' . $path;
}

function esc_html($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function esc_attr($value): string
{
    return esc_html($value);
}

function esc_url($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function wp_kses_post($value): string
{
    return strip_tags((string) $value, '<p><strong><em><ul><ol><li><a><br>');
}

$renderer_file = dirname(__DIR__) . '/staging-plugin/trekking-content.php';
if (is_file($renderer_file)) {
    require $renderer_file;
}
$renderer_source = (string) file_get_contents($renderer_file);
$plugin_source = (string) file_get_contents(dirname(__DIR__) . '/staging-plugin/tanzania-sensational-design.php');
if (!str_contains($plugin_source, "require_once __DIR__ . '/trekking-content.php';")) {
    throw new RuntimeException('The route content shortcode must be loaded by the active design plugin.');
}
if (!isset($GLOBALS['ts_trekking_test_shortcodes']['ts_trek_route'])) {
    throw new RuntimeException('The route renderer must register the shortcode consumed by its Elementor template.');
}

$shortcode = $GLOBALS['ts_trekking_test_shortcodes']['ts_trek_route'];
if ($shortcode() !== '') {
    throw new RuntimeException('The route shortcode must not render outside a trekking route post.');
}

$route = [
    'duration' => '7 Days',
    'difficulty' => 'Challenging',
    'distance' => '70 km',
    'elevation_gain' => '4,000 m',
    'hero_image_url' => 'https://images.example.test/lemosho.jpg?size=large&fit=crop',
    'hero_image_alt' => 'Lemosho trail across the mountain',
    'overview' => '<p>Explore <strong>this route</strong> carefully.</p>',
    'highlights' => [['text' => 'Shira Plateau'], ['text' => '<script>alert(1)</script>Safe text']],
    'itinerary' => [[
        'day' => 1,
        'title' => 'Londorossi Gate to Mti Mkubwa',
        'description' => 'Walk through the forest.',
        'elevation' => '2,650 m',
        'distance' => '7 km',
        'habitat' => 'Montane forest',
        'meals' => 'Lunch, dinner',
        'camp' => 'Mti Mkubwa Camp',
    ]],
    'inclusions' => [['text' => 'Park fees']],
    'exclusions' => [['text' => 'International flights']],
    'gallery_urls' => [['url' => 'https://images.example.test/gallery.jpg', 'alt' => 'Mountain camp']],
    'base_price' => 1900,
];

$html = ts_render_trek_route_sections($route, 'Lemosho 7-Day Route');
foreach ([
    '<h1>Lemosho 7-Day Route</h1>' => 'route title is rendered as the sole page H1',
] as $needle => $message) {
    if (!str_contains($html, $needle)) {
        throw new RuntimeException('Missing required route output: ' . $message);
    }
}
foreach (['Shira Plateau', 'Mti Mkubwa Camp', 'Park fees', 'International flights', 'Mountain camp', 'Route Overview'] as $needle) {
    if (!str_contains($html, $needle)) {
        throw new RuntimeException('Missing route-specific content: ' . $needle);
    }
}
if (substr_count($html, '<h1') !== 1) {
    throw new RuntimeException('The route detail renderer must emit exactly one H1.');
}
if (str_contains($html, '<script>') || str_contains($html, '1900')) {
    throw new RuntimeException('Unsafe source text or unverified price must not be rendered.');
}
if (!str_contains($html, 'size=large&amp;fit=crop')) {
    throw new RuntimeException('Hero URL query separators must be escaped.');
}

$custom_html = ts_render_trek_route_sections($route, 'Lemosho 7-Day Route', [
    'overview_title' => 'The Western Approach',
    'inclusions_section_title' => 'Included and excluded on this route',
    'cta_title' => 'Talk to a mountain specialist',
]);
if (!str_contains($custom_html, '<h2 id="ts-trek-route-overview-title">The Western Approach</h2>')) {
    throw new RuntimeException('The Elementor widget must be able to customize the route overview heading.');
}
if (!str_contains($custom_html, '<h2>Talk to a mountain specialist</h2>')) {
    throw new RuntimeException('The Elementor widget must be able to customize the route contact heading.');
}
if (!str_contains($custom_html, '<h2 id="ts-trek-route-inclusions-title">Included and excluded on this route</h2>')) {
    throw new RuntimeException('The Elementor widget must be able to customize the inclusions section heading.');
}
$unsafe_section_html = ts_render_trek_route_sections($route, 'Lemosho 7-Day Route', [
    'inclusions_section_title' => '<script>alert(1)</script> Contents',
]);
if (!str_contains($unsafe_section_html, '&lt;script&gt;alert(1)&lt;/script&gt; Contents') || str_contains($unsafe_section_html, '<script>')) {
    throw new RuntimeException('The custom inclusions section heading must be escaped.');
}
if (str_contains($custom_html, '<script>')) {
    throw new RuntimeException('Custom section labels must be escaped before rendering.');
}

$exclusions_only_html = ts_render_trek_route_sections([
    'exclusions' => [['text' => 'International flights']],
], 'Lemosho 7-Day Route', ['excluded_title' => 'Not Covered']);
if (!str_contains($exclusions_only_html, '<h2 id="ts-trek-route-inclusions-title">Not Covered</h2>')) {
    throw new RuntimeException('An exclusions-only section must honor the excluded heading control.');
}
if (str_contains($exclusions_only_html, '<h3>Not Covered</h3>')) {
    throw new RuntimeException('An exclusions-only section must not repeat its heading as a subgroup title.');
}
$inclusions_only_html = ts_render_trek_route_sections([
    'inclusions' => [['text' => 'Park fees']],
], 'Lemosho 7-Day Route', ['included_title' => 'Included on this route']);
if (!str_contains($inclusions_only_html, '<h2 id="ts-trek-route-inclusions-title">Included on this route</h2>')) {
    throw new RuntimeException('An inclusions-only section must honor the included heading control.');
}
if (str_contains($inclusions_only_html, '<h3>Included on this route</h3>')) {
    throw new RuntimeException('An inclusions-only section must not repeat its heading as a subgroup title.');
}

$GLOBALS['ts_trekking_test_is_singular'] = true;
$GLOBALS['ts_trekking_test_post_id'] = 481;
$GLOBALS['ts_trekking_test_title'] = 'Lemosho 7-Day Route from WordPress';
$GLOBALS['ts_trekking_test_fields'] = [
    'ts_trek_duration' => '7 Days',
    'ts_trek_difficulty' => 'Challenging',
    'ts_trek_distance' => '70 km',
    'ts_trek_elevation_gain' => '4,000 m',
    'ts_trek_overview' => '<p>Shortcode-backed source overview.</p>',
    'ts_trek_highlights' => [['text' => 'Shira Plateau']],
    'ts_trek_itinerary' => [],
    'ts_trek_inclusions' => [['text' => 'Park fees']],
    'ts_trek_exclusions' => [],
    'ts_trek_hero_image_url' => '',
    'ts_trek_hero_image_alt' => '',
    'ts_trek_gallery_urls' => [],
];
$GLOBALS['ts_trekking_test_field_post_ids'] = [];
$shortcode_html = $shortcode();
if (!str_contains($shortcode_html, '<h1>Lemosho 7-Day Route from WordPress</h1>') || !str_contains($shortcode_html, 'Shortcode-backed source overview.') || !str_contains($shortcode_html, 'Shira Plateau')) {
    throw new RuntimeException('The route shortcode must render the current post title and structured ACF route fields.');
}
if (count(array_unique($GLOBALS['ts_trekking_test_field_post_ids'])) !== 1 || reset($GLOBALS['ts_trekking_test_field_post_ids']) !== 481) {
    throw new RuntimeException('The route shortcode must read all fields from the current route post.');
}

echo "PASS: trekking route details render source data safely and omit unverified price.\n";
