<?php

declare(strict_types=1);

function kilimanjaro_hero_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$plugin_dir = __DIR__ . '/../staging-plugin';
$expected_source_hero = 'https://tanzaniasensational.com/storage/visual-assets/trekking_pillar_hero/ruHzpY38hak9YFhLs849fPJ8FgpLdM2jV0jmr6Zq.jpg';
$shortcodes = (string) file_get_contents($plugin_dir . '/static-pages.php');
$widgets = (string) file_get_contents($plugin_dir . '/elementor/widgets/class-ts-static-pages-widgets.php');
$pages_css = (string) file_get_contents($plugin_dir . '/pages.css');

kilimanjaro_hero_assert(
    str_contains($shortcodes, $expected_source_hero),
    'The Kilimanjaro shortcode must use the exact image displayed by the live source page.'
);
kilimanjaro_hero_assert(
    str_contains($widgets, $expected_source_hero),
    'The Kilimanjaro Elementor hero default must use the exact live-source image.'
);
$hero_selector = '.field-root .field-hero-img img';
$hero_rule_start = strpos($pages_css, $hero_selector);
$hero_rule_end = false === $hero_rule_start ? false : strpos($pages_css, '}', $hero_rule_start);
$hero_rule = false === $hero_rule_end ? '' : substr($pages_css, $hero_rule_start, $hero_rule_end - $hero_rule_start);
kilimanjaro_hero_assert(
    str_contains($hero_rule, 'height: 100%;')
        && str_contains($hero_rule, 'object-fit: cover;'),
    'The more-specific Elementor hero rule must fill and crop the hero container at every breakpoint.'
);

$plugin_bootstrap = (string) file_get_contents($plugin_dir . '/tanzania-sensational-design.php');
kilimanjaro_hero_assert(
    str_contains($plugin_bootstrap, "ts_design_asset_version( __DIR__ . '/pages.css', '1.0.1' )"),
    'The structured-page stylesheet cache version must change when its source file changes.'
);

fwrite(STDOUT, 'PASS: Kilimanjaro hero uses source media, fills responsive containers, and cache-busts page styles.' . PHP_EOL);
