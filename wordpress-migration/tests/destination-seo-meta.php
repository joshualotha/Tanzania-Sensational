<?php

declare(strict_types=1);

define('ABSPATH', __DIR__);
$GLOBALS['destination_seo_filters'] = [];
$GLOBALS['destination_seo_fields'] = [];
$GLOBALS['destination_seo_post_type'] = 'ts_destination';

function add_filter(string $tag, callable $callback, int $priority = 10, int $accepted_args = 1): void
{
    $GLOBALS['destination_seo_filters'][$tag] = $callback;
}

function add_shortcode(string $tag, callable $callback): void
{
}

function is_singular(string $post_type = ''): bool
{
    return $GLOBALS['destination_seo_post_type'] === $post_type;
}

function get_the_ID(): int
{
    return 701;
}

function get_queried_object_id(): int
{
    return 701;
}

function get_field(string $key, int $post_id = 0)
{
    return $GLOBALS['destination_seo_fields'][$key] ?? null;
}

function get_permalink(int $post_id = 0): string
{
    return 'https://test.tanzaniasensational.com/safaris/destinations/ruaha';
}

require dirname(__DIR__) . '/staging-plugin/dynamic-content.php';

$expected_filters = [
    'rank_math/frontend/title',
    'rank_math/frontend/description',
    'rank_math/frontend/canonical',
    'hello_elementor_description_meta_tag',
];
foreach ($expected_filters as $tag) {
    if (!isset($GLOBALS['destination_seo_filters'][$tag])) {
        throw new RuntimeException('Destination SEO filter is not registered: ' . $tag);
    }
}

$GLOBALS['destination_seo_fields'] = [
    'ts_dest_meta_title' => 'Ruaha National Park Safari | Tanzania Safari Destinations',
    'ts_dest_meta_description' => 'Explore Ruaha National Park and plan a source-matched Tanzania safari.',
];
$filtered_title = ($GLOBALS['destination_seo_filters']['rank_math/frontend/title'])('Fallback title');
$filtered_description = ($GLOBALS['destination_seo_filters']['rank_math/frontend/description'])('Fallback description');
$filtered_canonical = ($GLOBALS['destination_seo_filters']['rank_math/frontend/canonical'])('https://test.tanzaniasensational.com/');
$hello_elementor_description_enabled = ($GLOBALS['destination_seo_filters']['hello_elementor_description_meta_tag'])(true);
if ('Ruaha National Park Safari | Tanzania Safari Destinations' !== $filtered_title) {
    throw new RuntimeException('Destination pages must use their stored source-backed SEO title.');
}
if ('Explore Ruaha National Park and plan a source-matched Tanzania safari.' !== $filtered_description) {
    throw new RuntimeException('Destination pages must use their stored source-backed SEO description.');
}
if ('https://test.tanzaniasensational.com/safaris/destinations/ruaha' !== $filtered_canonical) {
    throw new RuntimeException('Destination pages must use their target permalink as canonical.');
}
if (false !== $hello_elementor_description_enabled) {
    throw new RuntimeException('Destination pages must suppress Hello Elementor\'s excerpt description when Rank Math supplies the SEO description.');
}

$GLOBALS['destination_seo_post_type'] = 'post';
if ('Fallback title' !== ($GLOBALS['destination_seo_filters']['rank_math/frontend/title'])('Fallback title')) {
    throw new RuntimeException('Destination SEO filters must not change non-destination titles.');
}
if ('Fallback description' !== ($GLOBALS['destination_seo_filters']['rank_math/frontend/description'])('Fallback description')) {
    throw new RuntimeException('Destination SEO filters must not change non-destination descriptions.');
}
if ('https://test.tanzaniasensational.com/' !== ($GLOBALS['destination_seo_filters']['rank_math/frontend/canonical'])('https://test.tanzaniasensational.com/')) {
    throw new RuntimeException('Destination SEO filters must not change non-destination canonicals.');
}
if (true !== ($GLOBALS['destination_seo_filters']['hello_elementor_description_meta_tag'])(true)) {
    throw new RuntimeException('The site theme description must remain enabled for non-destination content.');
}

echo "PASS: Rank Math metadata is overridden only for destination pages with stored values.\n";
