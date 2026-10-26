<?php

declare(strict_types=1);

function esc_url(string $url): string
{
    return htmlspecialchars($url, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function esc_attr(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$GLOBALS['blog_render_posts'] = [];
$GLOBALS['blog_render_query'] = [];
function get_posts(array $args): array
{
    $GLOBALS['blog_render_query'] = $args;
    return $GLOBALS['blog_render_posts'];
}

require_once __DIR__ . '/../staging-plugin/blog-render-helpers.php';

function blog_render_assert_same($expected, $actual, string $message): void
{
    if ($expected !== $actual) {
        throw new RuntimeException($message . '\nExpected: ' . var_export($expected, true) . '\nActual: ' . var_export($actual, true));
    }
}

blog_render_assert_same('', ts_blog_image_markup('', 'No image', 'blog-article-bg'), 'A missing source image renders no substitute image.');
blog_render_assert_same('', ts_blog_image_markup('javascript:alert(1)', 'Unsafe', 'blog-article-bg'), 'A non-HTTPS image URL is omitted.');

$image = ts_blog_image_markup('https://images.example.test/mountain.jpg?crop=wide&fit=cover', 'Mountain & summit', 'blog-article-bg', 'eager', true);
blog_render_assert_same(true, str_contains($image, 'src="https://images.example.test/mountain.jpg?crop=wide&amp;fit=cover"'), 'The exact HTTPS source URL is escaped into the image.');
blog_render_assert_same(true, str_contains($image, 'alt="Mountain &amp; summit"'), 'Image alt text is escaped and retained.');
blog_render_assert_same(true, str_contains($image, 'fetchpriority="high"'), 'Only explicitly high-priority hero images receive fetch priority.');

$GLOBALS['blog_render_posts'] = [(object) ['ID' => 42], 42, (object) ['ID' => 57]];
blog_render_assert_same([42, 57], ts_blog_legacy_sample_post_ids(), 'The blog archive excludes only the exact default Hello World post ID.');
blog_render_assert_same('hello-world', $GLOBALS['blog_render_query']['name'] ?? '', 'Sample-post exclusion resolves by the exact legacy slug.');
blog_render_assert_same('post', $GLOBALS['blog_render_query']['post_type'] ?? '', 'Sample-post exclusion is limited to standard posts.');
$GLOBALS['blog_render_posts'] = [];
blog_render_assert_same([], ts_blog_legacy_sample_post_ids(), 'No missing Hello World sample creates a phantom exclusion.');

fwrite(STDOUT, "PASS: blog image helper omits missing media and escapes verified sources.\n");
