<?php
/** Shared rendering helpers for the editable blog widgets. */

/** Render only verified HTTPS images; never replace missing media with guesses. */
function ts_blog_image_markup($url, $alt, $class, $loading = 'lazy', $high_priority = false): string
{
    if (!is_string($url) || '' === trim($url)) {
        return '';
    }

    $parts = parse_url($url);
    if (!is_array($parts) || 'https' !== strtolower((string) ($parts['scheme'] ?? '')) || '' === (string) ($parts['host'] ?? '')) {
        return '';
    }

    $safe_url = esc_url($url);
    if ('' === $safe_url) {
        return '';
    }

    $loading = in_array($loading, ['eager', 'lazy'], true) ? $loading : 'lazy';
    $priority = $high_priority ? ' fetchpriority="high"' : '';

    return '<img src="' . $safe_url . '" alt="' . esc_attr((string) $alt) . '" class="' . esc_attr((string) $class) . '" loading="' . esc_attr($loading) . '" decoding="async"' . $priority . ' />';
}

/** Read a blog ACF field with a safe fallback for imports and editor previews. */
function ts_blog_get_field(string $field_name, int $post_id, $default = '')
{
    if (function_exists('get_field')) {
        $value = get_field($field_name, $post_id);
    } else {
        $value = get_post_meta($post_id, $field_name, true);
    }

    return (null === $value || false === $value || '' === $value) ? $default : $value;
}

/** Get the first category label for an article. */
function ts_blog_primary_category(int $post_id): string
{
    $categories = get_the_category($post_id);
    if (!is_array($categories) || empty($categories[0]->name)) {
        return '';
    }

    return (string) $categories[0]->name;
}

/** Exclude the untouched WordPress Hello World sample from editorial recommendations. */
function ts_blog_legacy_sample_post_ids(): array
{
    $posts = get_posts([
        'post_type' => 'post',
        'post_status' => ['publish', 'draft', 'pending', 'private', 'future', 'trash'],
        'name' => 'hello-world',
        'numberposts' => -1,
        'fields' => 'ids',
        'suppress_filters' => true,
    ]);

    if (!is_array($posts)) {
        return [];
    }

    $ids = [];
    foreach ($posts as $post) {
        $post_id = is_numeric($post) ? (int) $post : (int) ($post->ID ?? 0);
        if ($post_id > 0) {
            $ids[] = $post_id;
        }
    }

    return array_values(array_unique($ids));
}
