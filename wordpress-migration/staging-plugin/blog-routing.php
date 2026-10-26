<?php
/**
 * Source-compatible routes for standard WordPress blog posts.
 *
 * @package Tanzania_Sensational
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Map standard posts to the public /blog/{slug} route.
 *
 * The pre-existing Hello World sample is intentionally left unchanged; it is
 * not part of the approved blog import.
 *
 * @param string  $permalink Existing permalink.
 * @param WP_Post $post      Post being linked.
 */
function ts_blog_filter_post_link($permalink, $post)
{
    if (!is_object($post) || 'post' !== ($post->post_type ?? '') || 'hello-world' === ($post->post_name ?? '')) {
        return $permalink;
    }

    $slug = (string) ($post->post_name ?? '');
    if ('' === $slug) {
        return $permalink;
    }

    return home_url('/blog/' . rawurlencode($slug));
}
add_filter('post_link', 'ts_blog_filter_post_link', 10, 2);

/**
 * Keep the blog index at the source's slashless /blog route.
 *
 * @param string $permalink Existing page permalink.
 * @param int    $post_id   Page ID.
 */
function ts_blog_filter_page_link($permalink, $post_id)
{
    $page = get_post((int) $post_id);
    if (is_object($page) && 'page' === ($page->post_type ?? '') && 'blog' === ($page->post_name ?? '')) {
        return home_url('/blog');
    }

    return $permalink;
}
add_filter('page_link', 'ts_blog_filter_page_link', 10, 2);

/** Register the nested standard-post route without changing global permalinks. */
function ts_blog_register_rewrite_rules(): void
{
    add_rewrite_rule('^blog/(?!hello-world/?$)([^/]+)/?$', 'index.php?post_type=post&name=$matches[1]', 'top');
}
add_action('init', 'ts_blog_register_rewrite_rules');

/**
 * Keep the /blog and /blog/{slug} canonical URLs slashless while preserving
 * the site's normal canonical behavior for every other route.
 *
 * @param string|null $redirect_url Canonical target proposed by WordPress.
 * @param string      $requested_url URL requested by the visitor.
 * @return string|null
 */
function ts_blog_filter_canonical($redirect_url, $requested_url)
{
    $requested = parse_url((string) $requested_url);
    $path = (string) ($requested['path'] ?? '');
    $home_path = rtrim((string) parse_url(home_url('/'), PHP_URL_PATH), '/');

    if ('' !== $home_path && str_starts_with($path, $home_path . '/')) {
        $path = substr($path, strlen($home_path));
    }

    if (function_exists('is_404') && is_404()) {
        return $redirect_url;
    }

    if ('/blog' === rtrim($path, '/')) {
        $canonical_path = '/blog';
    } elseif (!preg_match('~^/blog/hello-world/?$~', $path) && preg_match('~^/blog/([^/]+)/?$~', $path, $matches)) {
        $canonical_path = '/blog/' . rawurlencode(rawurldecode($matches[1]));
    } else {
        return $redirect_url;
    }

    $canonical = home_url($canonical_path);
    if (!empty($requested['query'])) {
        $canonical .= '?' . $requested['query'];
    }

    return $canonical;
}
add_filter('redirect_canonical', 'ts_blog_filter_canonical', 10, 2);
