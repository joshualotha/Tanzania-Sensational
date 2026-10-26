<?php

declare(strict_types=1);

$GLOBALS['blog_routing_test_filters'] = [];
$GLOBALS['blog_routing_test_actions'] = [];
$GLOBALS['blog_routing_test_rules'] = [];
$GLOBALS['blog_routing_test_posts'] = [];

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

function add_filter(string $hook, callable $callback, int $priority = 10, int $accepted_args = 1): bool
{
    $GLOBALS['blog_routing_test_filters'][$hook][] = $callback;
    return true;
}

function add_action(string $hook, callable $callback, int $priority = 10, int $accepted_args = 1): bool
{
    $GLOBALS['blog_routing_test_actions'][$hook][] = $callback;
    return true;
}

function add_rewrite_rule(string $regex, string $query, string $after = 'bottom'): void
{
    $GLOBALS['blog_routing_test_rules'][] = [$regex, $query, $after];
}

function home_url(string $path = ''): string
{
    return 'https://test.tanzaniasensational.com' . $path;
}

function get_post(int $post_id)
{
    return $GLOBALS['blog_routing_test_posts'][$post_id] ?? null;
}

function blog_routing_assert_same($expected, $actual, string $message): void
{
    if ($expected !== $actual) {
        throw new RuntimeException($message . '\nExpected: ' . var_export($expected, true) . '\nActual: ' . var_export($actual, true));
    }
}

require_once __DIR__ . '/../staging-plugin/blog-routing.php';

$standard_post = (object) ['ID' => 99, 'post_type' => 'post', 'post_name' => 'a-source-matched-story'];
blog_routing_assert_same(
    'https://test.tanzaniasensational.com/blog/a-source-matched-story',
    ts_blog_filter_post_link('/a-source-matched-story/', $standard_post),
    'Published standard posts use the source /blog/{slug} route.'
);

$hello_world = (object) ['ID' => 1, 'post_type' => 'post', 'post_name' => 'hello-world'];
blog_routing_assert_same(
    '/hello-world/',
    ts_blog_filter_post_link('/hello-world/', $hello_world),
    'The existing default Hello World post keeps its current permalink.'
);

$destination = (object) ['ID' => 100, 'post_type' => 'ts_destination', 'post_name' => 'serengeti'];
blog_routing_assert_same(
    '/serengeti/',
    ts_blog_filter_post_link('/serengeti/', $destination),
    'Non-blog post types keep their existing permalinks.'
);

$GLOBALS['blog_routing_test_posts'][200] = (object) ['ID' => 200, 'post_type' => 'page', 'post_name' => 'blog'];
blog_routing_assert_same(
    'https://test.tanzaniasensational.com/blog',
    ts_blog_filter_page_link('/blog/', 200),
    'The Blog index keeps the source /blog route without a trailing slash.'
);

foreach ($GLOBALS['blog_routing_test_actions']['init'] ?? [] as $callback) {
    $callback();
}
blog_routing_assert_same(
    ['^blog/(?!hello-world/?$)([^/]+)/?$', 'index.php?post_type=post&name=$matches[1]', 'top'],
    $GLOBALS['blog_routing_test_rules'][0] ?? null,
    'The rewrite resolves /blog/{slug} to a standard WordPress post.'
);

blog_routing_assert_same(
    'https://test.tanzaniasensational.com/blog/a-source-matched-story?ref=journal',
    ts_blog_filter_canonical('https://test.tanzaniasensational.com/blog/a-source-matched-story/', 'https://test.tanzaniasensational.com/blog/a-source-matched-story/?ref=journal'),
    'The canonical route removes the trailing slash while preserving query parameters.'
);
blog_routing_assert_same(
    'https://test.tanzaniasensational.com/blog/hello-world/',
    ts_blog_filter_canonical('https://test.tanzaniasensational.com/blog/hello-world/', 'https://test.tanzaniasensational.com/blog/hello-world/'),
    'The legacy Hello World post does not acquire a second /blog/ route.'
);
blog_routing_assert_same(
    'https://test.tanzaniasensational.com/about-us/',
    ts_blog_filter_canonical('https://test.tanzaniasensational.com/about-us/', 'https://test.tanzaniasensational.com/about-us/'),
    'Other WordPress routes are not modified.'
);

fwrite(STDOUT, "PASS: blog permalink and rewrite contracts.\n");
