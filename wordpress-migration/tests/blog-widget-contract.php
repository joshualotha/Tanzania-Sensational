<?php

declare(strict_types=1);

function blog_contract_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$plugin_root = __DIR__ . '/../staging-plugin';
$archive_widget = $plugin_root . '/elementor/widgets/class-ts-blog-archive-widget.php';
$single_widget = $plugin_root . '/elementor/widgets/class-ts-single-blog-widget.php';
$elementor_bootstrap = (string) file_get_contents($plugin_root . '/elementor-widgets.php');
$plugin_bootstrap = (string) file_get_contents($plugin_root . '/tanzania-sensational-design.php');

blog_contract_assert(is_file($archive_widget), 'The editable archive Elementor widget exists.');
blog_contract_assert(is_file($single_widget), 'The editable single-post Elementor widget exists.');
$archive_source = (string) file_get_contents($archive_widget);
$single_source = (string) file_get_contents($single_widget);
$blog_css = (string) file_get_contents($plugin_root . '/blog.css');
$import_runtime = (string) file_get_contents(__DIR__ . '/../migration/blog-import-runtime.php');
blog_contract_assert(str_contains($archive_source, "return 'ts_blog_archive';"), 'The archive widget has a stable Elementor identifier.');
blog_contract_assert(str_contains($single_source, "return 'ts_single_blog';"), 'The single-post widget has a stable Elementor identifier.');
blog_contract_assert(str_contains($elementor_bootstrap, "class-ts-blog-archive-widget.php"), 'The archive widget is loaded by the Elementor bootstrap.');
blog_contract_assert(str_contains($elementor_bootstrap, "class-ts-single-blog-widget.php"), 'The single-post widget is loaded by the Elementor bootstrap.');
blog_contract_assert(str_contains($elementor_bootstrap, 'new TS_Blog_Archive_Widget()'), 'The archive widget is registered.');
blog_contract_assert(str_contains($elementor_bootstrap, 'new TS_Single_Blog_Widget()'), 'The single-post widget is registered.');
blog_contract_assert(str_contains($plugin_bootstrap, "'/blog-fields.php'"), 'The editable blog ACF fields are loaded.');
blog_contract_assert(str_contains($plugin_bootstrap, "'/blog-routing.php'"), 'The source-compatible blog route rules are active.');
blog_contract_assert(str_contains($plugin_bootstrap, "'/blog-render-helpers.php'"), 'The safe image and field helpers are loaded.');
blog_contract_assert(str_contains($plugin_bootstrap, "'blog.css'"), 'The source-matched blog stylesheet is enqueued.');

blog_contract_assert(str_contains($archive_source, 'ts_blog_legacy_sample_post_ids()'), 'The archive resolves the untouched Hello World exclusion.');
blog_contract_assert(3 <= substr_count($archive_source, 'post__not_in'), 'Featured and story queries exclude legacy sample and featured-post IDs.');
blog_contract_assert(str_contains($single_source, 'ts_blog_legacy_sample_post_ids()'), 'Related stories exclude the untouched Hello World sample.');
blog_contract_assert(!str_contains($archive_source, 'blog-featured-eyebrow') && !str_contains($archive_source, 'featured_label'), 'The featured-story heading has no kicker label.');
blog_contract_assert(!str_contains($blog_css, '.blog-featured-eyebrow'), 'The featured-story stylesheet has no kicker treatment.');
blog_contract_assert(!str_contains($import_runtime, "'featured_label'"), 'The imported archive template has no stale kicker setting.');
blog_contract_assert((bool) preg_match('/\\.blog-article-title\\s*\\{[^}]*font-size:\\s*clamp\\([^;]*6rem\\)/s', $blog_css), 'Article display type respects the six-rem craft cap.');
$archive_hero_rule = [];
blog_contract_assert(
    1 === preg_match('/\\.blog-featured-hero\\s*\\{([^}]*)\\}/s', $blog_css, $archive_hero_rule)
        && 1 === preg_match('/height:\\s*auto\\s*;/', $archive_hero_rule[1])
        && 1 === preg_match('/min-height:\\s*90vh\\s*;/', $archive_hero_rule[1])
        && 1 === preg_match('/padding:\\s*clamp\\(150px,\\s*18vh,\\s*220px\\)\\s+5%\\s+100px\\s*;/', $archive_hero_rule[1]),
    'The desktop featured hero must clear the overlaid navigation and grow to fit long headlines.'
);
$featured_title_rule = [];
blog_contract_assert(
    1 === preg_match('/\\.blog-featured-title\\s*\\{([^}]*)\\}/s', $blog_css, $featured_title_rule)
        && 1 === preg_match('/font-size:\\s*clamp\\(3rem,\\s*6vw,\\s*5rem\\)\\s*;/', $featured_title_rule[1]),
    'The featured headline scale must keep the longest imported title to two desktop lines.'
);

$related_image_rule = [];
blog_contract_assert(
    1 === preg_match('/\\.blog-related-img img\\s*\\{([^}]*)\\}/s', $blog_css, $related_image_rule)
        && 1 === preg_match('/display:\\s*block\\s*;/', $related_image_rule[1])
        && 1 === preg_match('/height:\\s*100px\\s*;/', $related_image_rule[1]),
    'Related thumbnails need a block box so native lazy loading can request images.'
);

fwrite(STDOUT, "PASS: blog widgets and route/content styles are integrated into the design plugin.\n");
