<?php
/**
 * WordPress runtime for the approved staging blog import.
 *
 * @package Tanzania_Sensational
 */

require_once __DIR__ . '/blog-importer.php';

/** Check the WordPress and ACF APIs used by the staging importer. */
function ts_blog_assert_runtime_dependencies(): void
{
    $required = [
        'get_posts', 'get_post', 'get_post_meta', 'update_post_meta', 'get_field', 'update_field',
        'acf_get_field', 'wp_insert_post', 'wp_update_post', 'wp_set_post_terms', 'term_exists',
        'wp_insert_term', 'wp_json_encode', 'wp_slash', 'is_wp_error', 'home_url', 'get_option',
        'current_user_can', 'get_current_user_id', 'clean_post_cache', 'clean_term_cache', 'get_the_category',
        'get_gmt_from_date', 'flush_rewrite_rules',
    ];
    foreach ($required as $function) {
        if (!function_exists($function)) {
            throw new RuntimeException('WordPress or ACF importer dependency is unavailable: ' . $function);
        }
    }
    if (!defined('ABSPATH')) {
        throw new RuntimeException('The blog importer must run inside WordPress.');
    }
    if (!defined('ELEMENTOR_VERSION') || !defined('ELEMENTOR_PRO_VERSION')) {
        throw new RuntimeException('Elementor and Elementor Pro must be active before importing the blog layout.');
    }
    if (!class_exists('ElementorPro\\Modules\\ThemeBuilder\\Module')) {
        throw new RuntimeException('Elementor Pro Theme Builder is unavailable.');
    }
}

/** Require InnoDB for every table changed by the post, term, and Elementor writes. */
function ts_blog_assert_transactional_storage(): void
{
    global $wpdb;
    $tables = [
        $wpdb->posts,
        $wpdb->postmeta,
        $wpdb->terms,
        $wpdb->term_taxonomy,
        $wpdb->term_relationships,
        $wpdb->options,
    ];
    foreach ($tables as $table) {
        $engine = $wpdb->get_var($wpdb->prepare(
            'SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = %s',
            $table
        ));
        if ('INNODB' !== strtoupper((string) $engine)) {
            throw new RuntimeException('Blog import requires InnoDB for posts, metadata, taxonomy, and options tables.');
        }
    }
}

/** Hash a normalized state array for collision and editor-drift checks. */
function ts_blog_state_hash(array $state): string
{
    $json = json_encode($state, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS | JSON_THROW_ON_ERROR);
    return hash('sha256', $json);
}

/** Expected source-managed post state, excluding generated IDs and non-content audit metadata. */
function ts_blog_expected_post_state(array $record, string $status = 'publish'): array
{
    return [
        'post_type' => 'post',
        'post_status' => $status,
        'post_name' => (string) $record['slug'],
        'post_title' => (string) $record['title'],
        'post_excerpt' => (string) ($record['excerpt'] ?? ''),
        'post_content' => (string) $record['content_html'],
        'post_date' => (string) $record['published_at'],
        'categories' => [(string) $record['category_name']],
        'fields' => [
            'author_display' => (string) $record['author_display'],
            'featured' => (bool) $record['featured'],
            'hero_image_url' => (string) ($record['hero_image_url'] ?? ''),
            'hero_image_alt' => (string) ($record['hero_image_alt'] ?? ''),
            'source_url' => (string) $record['source_url'],
        ],
    ];
}

/** Read a post and all fields managed by the reviewed source manifest. */
function ts_blog_current_post_state(int $post_id): array
{
    $post = get_post($post_id);
    if (!is_object($post) || (int) ($post->ID ?? 0) !== $post_id) {
        throw new RuntimeException('Could not read imported blog post: ' . $post_id);
    }

    $categories = get_the_category($post_id);
    $category_names = [];
    if (is_array($categories)) {
        foreach ($categories as $category) {
            if (is_object($category) && isset($category->name)) {
                $category_names[] = html_entity_decode((string) $category->name, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            }
        }
    }
    sort($category_names, SORT_STRING);

    $featured = get_field('ts_blog_featured', $post_id);
    return [
        'post_type' => (string) $post->post_type,
        'post_status' => (string) $post->post_status,
        'post_name' => (string) $post->post_name,
        'post_title' => (string) $post->post_title,
        'post_excerpt' => (string) $post->post_excerpt,
        'post_content' => (string) $post->post_content,
        'post_date' => substr((string) $post->post_date, 0, 10),
        'categories' => $category_names,
        'fields' => [
            'author_display' => (string) get_field('ts_blog_author_display', $post_id),
            'featured' => in_array($featured, [true, 1, '1'], true),
            'hero_image_url' => (string) get_field('ts_blog_hero_image_url', $post_id),
            'hero_image_alt' => (string) get_field('ts_blog_hero_image_alt', $post_id),
            'source_url' => (string) get_field('ts_blog_source_url', $post_id),
        ],
    ];
}

/** Store and read back importer metadata before considering a write successful. */
function ts_blog_save_meta(int $post_id, string $key, $value): void
{
    update_post_meta($post_id, $key, is_string($value) ? wp_slash($value) : $value);
    $read_back = get_post_meta($post_id, $key, true);
    if ($read_back !== $value && (!is_scalar($read_back) || !is_scalar($value) || (string) $read_back !== (string) $value)) {
        throw new RuntimeException('Could not verify blog importer metadata: ' . $key);
    }
}

/** Return every post that can collide with an approved source slug. */
function ts_blog_posts_by_type(string $post_type): array
{
    return get_posts([
        'post_type' => $post_type,
        'post_status' => ['publish', 'draft', 'pending', 'private', 'future', 'trash'],
        'numberposts' => -1,
        'suppress_filters' => true,
        'orderby' => 'ID',
        'order' => 'ASC',
    ]);
}

/** Build the current create-only plan from WordPress records and ownership snapshots. */
function ts_blog_collect_post_plan(array $manifest): array
{
    $target_slugs = array_fill_keys(array_column($manifest['posts'], 'slug'), true);
    $matches = [];
    foreach (ts_blog_posts_by_type('post') as $post) {
        $slug = (string) ($post->post_name ?? '');
        if (isset($target_slugs[$slug])) {
            $matches[$slug][] = $post;
        }
    }

    $existing_by_slug = [];
    foreach ($matches as $slug => $posts) {
        if (1 !== count($posts)) {
            throw new RuntimeException('Multiple standard posts match approved blog slug: ' . $slug);
        }
        $post = $posts[0];
        $post_id = (int) $post->ID;
        $snapshot_raw = get_post_meta($post_id, '_ts_blog_import_snapshot', true);
        $snapshot = is_array($snapshot_raw) ? $snapshot_raw : json_decode((string) $snapshot_raw, true);
        $snapshot_hash = (string) get_post_meta($post_id, '_ts_blog_import_snapshot_hash', true);
        if (!is_array($snapshot) || '' === $snapshot_hash || !hash_equals($snapshot_hash, ts_blog_state_hash($snapshot))) {
            $snapshot_hash = '';
        }
        $existing_by_slug[$slug] = [
            'post_id' => $post_id,
            'source_slug' => (string) get_post_meta($post_id, '_ts_blog_import_source_slug', true),
            'import_hash' => (string) get_post_meta($post_id, '_ts_blog_import_record_hash', true),
            'state_marker' => (string) get_post_meta($post_id, '_ts_blog_import_state', true),
            'snapshot_hash' => $snapshot_hash,
            'actual_snapshot_hash' => ts_blog_state_hash(ts_blog_current_post_state($post_id)),
        ];
    }

    $plan = ts_blog_build_import_plan($manifest, $existing_by_slug);
    foreach ($plan as &$item) {
        $item['post_id'] = (int) ($existing_by_slug[$item['slug']]['post_id'] ?? 0);
    }
    unset($item);

    return $plan;
}

/** Build the saved Elementor section/column/widget format used by this staging site. */
function ts_blog_elementor_data(string $widget_type, array $settings, array $ids): string
{
    if (3 !== count($ids)) {
        throw new RuntimeException('Blog Elementor documents require three stable element IDs.');
    }
    $data = [[
        'id' => (string) $ids[0],
        'elType' => 'section',
        'settings' => ['stretch_section' => 'section-stretched', 'layout' => 'full_width', 'gap' => 'no'],
        'elements' => [[
            'id' => (string) $ids[1],
            'elType' => 'column',
            'settings' => [],
            'elements' => [[
                'id' => (string) $ids[2],
                'elType' => 'widget',
                'widgetType' => $widget_type,
                'settings' => $settings,
                'elements' => [],
            ]],
        ]],
    ]];
    $json = wp_json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS);
    if (!is_string($json)) {
        throw new RuntimeException('Could not encode blog Elementor layout.');
    }
    return $json;
}

/** Build the Elementor layout and managed post state for a resource. */
function ts_blog_expected_resource_state(string $kind, array $conditions = []): array
{
    if ('blog_page' === $kind) {
        $data = ts_blog_elementor_data('ts_blog_archive', [
            'featured_cta' => 'Read Featured Story',
            'card_cta' => 'Continue Reading',
            'posts_per_page' => 12,
            'show_excerpts' => 'yes',
        ], ['tblog01', 'tblog02', 'tblog03']);
        return [
            'post_type' => 'page',
            'post_status' => 'publish',
            'post_name' => 'blog',
            'post_title' => 'Trekker’s Journal',
            'post_content' => '',
            'page_template' => 'elementor_header_footer',
            'edit_mode' => 'builder',
            'elementor_version' => (string) ELEMENTOR_VERSION,
            'elementor_data' => $data,
        ];
    }

    if ('single_template' === $kind) {
        $data = ts_blog_elementor_data('ts_single_blog', [
            'back_label' => 'Trekker’s Journal',
            'back_url' => ['url' => '/blog', 'is_external' => '', 'nofollow' => ''],
            'share_heading' => 'Share Story',
            'related_heading' => 'Related Stories',
            'show_share' => 'yes',
            'show_related' => 'yes',
        ], ['tsblog11', 'tsblog12', 'tsblog13']);
        return [
            'post_type' => 'elementor_library',
            'post_status' => 'publish',
            'post_name' => 'ts-single-blog',
            'post_title' => 'TS Single Blog',
            'post_content' => '',
            'template_type' => 'single',
            'conditions' => array_values($conditions),
            'page_settings' => ['template' => 'elementor_header_footer'],
            'edit_mode' => 'builder',
            'elementor_version' => (string) ELEMENTOR_VERSION,
            'elementor_data' => $data,
        ];
    }

    throw new RuntimeException('Unrecognized blog Elementor resource type: ' . $kind);
}

/** Read the current saved Elementor page or Theme Builder template state. */
function ts_blog_current_resource_state(int $post_id, string $kind): array
{
    $post = get_post($post_id);
    if (!is_object($post) || (int) ($post->ID ?? 0) !== $post_id) {
        throw new RuntimeException('Could not read blog Elementor resource: ' . $post_id);
    }

    $state = [
        'post_type' => (string) $post->post_type,
        'post_status' => (string) $post->post_status,
        'post_name' => (string) $post->post_name,
        'post_title' => (string) $post->post_title,
        'post_content' => (string) $post->post_content,
    ];
    if ('blog_page' === $kind) {
        $state += [
            'page_template' => (string) get_post_meta($post_id, '_wp_page_template', true),
            'edit_mode' => (string) get_post_meta($post_id, '_elementor_edit_mode', true),
            'elementor_version' => (string) get_post_meta($post_id, '_elementor_version', true),
            'elementor_data' => (string) get_post_meta($post_id, '_elementor_data', true),
        ];
    } else {
        $conditions = get_post_meta($post_id, '_elementor_conditions', true);
        $page_settings = get_post_meta($post_id, '_elementor_page_settings', true);
        $state += [
            'template_type' => (string) get_post_meta($post_id, '_elementor_template_type', true),
            'conditions' => is_array($conditions) ? array_values($conditions) : [],
            'page_settings' => is_array($page_settings) ? $page_settings : [],
            'edit_mode' => (string) get_post_meta($post_id, '_elementor_edit_mode', true),
            'elementor_version' => (string) get_post_meta($post_id, '_elementor_version', true),
            'elementor_data' => (string) get_post_meta($post_id, '_elementor_data', true),
        ];
    }
    return $state;
}

/** Find pages/templates by exact post name, including non-public statuses. */
function ts_blog_resources_by_slug(string $post_type, string $slug): array
{
    $matches = [];
    foreach (ts_blog_posts_by_type($post_type) as $post) {
        if ($slug === (string) ($post->post_name ?? '')) {
            $matches[] = $post;
        }
    }
    return $matches;
}

/** Refuse existing unowned or edited page/template resources. */
function ts_blog_plan_resource(string $kind, array $expected): array
{
    $post_type = 'blog_page' === $kind ? 'page' : 'elementor_library';
    $slug = (string) $expected['post_name'];
    $matches = ts_blog_resources_by_slug($post_type, $slug);
    if ([] === $matches) {
        return ['action' => 'create', 'post_id' => 0, 'kind' => $kind, 'expected' => $expected];
    }
    if (1 !== count($matches)) {
        throw new RuntimeException('Multiple staging resources match blog slug: ' . $slug);
    }

    $post_id = (int) $matches[0]->ID;
    $owner = (string) get_post_meta($post_id, '_ts_blog_resource_owner', true);
    $import_hash = (string) get_post_meta($post_id, '_ts_blog_resource_import_hash', true);
    $snapshot_hash = (string) get_post_meta($post_id, '_ts_blog_resource_snapshot_hash', true);
    $resource_state = (string) get_post_meta($post_id, '_ts_blog_resource_state', true);
    $expected_hash = ts_blog_state_hash($expected);
    $actual_hash = ts_blog_state_hash(ts_blog_current_resource_state($post_id, $kind));
    if ('approved-blog-import-v1' !== $owner || 'ready' !== $resource_state || '' === $import_hash || !hash_equals($expected_hash, $import_hash)) {
        throw new RuntimeException('Refusing to overwrite an unowned or differently configured blog resource: ' . $slug);
    }
    if ('' === $snapshot_hash || !hash_equals($snapshot_hash, $actual_hash)) {
        throw new RuntimeException('Refusing to overwrite an editor-modified blog resource: ' . $slug);
    }

    return ['action' => 'unchanged', 'post_id' => $post_id, 'kind' => $kind, 'expected' => $expected];
}

/** Start a repeatable-read transaction so slug range locks also block inserts. */
function ts_blog_start_create_transaction(string $resource_label): void
{
    global $wpdb;
    if (!is_object($wpdb) || !method_exists($wpdb, 'query')) {
        throw new RuntimeException('Blog import requires a WordPress database connection.');
    }
    if ($wpdb->query('SET TRANSACTION ISOLATION LEVEL REPEATABLE READ') === false) {
        throw new RuntimeException('Could not set repeatable-read isolation for blog ' . $resource_label . ' creation.');
    }
    if ($wpdb->query('START TRANSACTION') === false) {
        throw new RuntimeException('Could not start a transaction for blog ' . $resource_label . ' creation.');
    }
}

/** Lock the indexed slug range and refuse a post-preflight collision. */
function ts_blog_lock_slug_for_create(string $post_type, string $slug): void
{
    global $wpdb;
    if (!is_object($wpdb) || !isset($wpdb->posts) || !method_exists($wpdb, 'prepare') || !method_exists($wpdb, 'get_var')) {
        throw new RuntimeException('Blog import requires locking reads for safe slug creation.');
    }

    $query = $wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts} FORCE INDEX (post_name) WHERE post_name = %s AND post_type = %s LIMIT 1 FOR UPDATE",
        $slug,
        $post_type
    );
    $existing_id = $wpdb->get_var($query);
    if (false === $existing_id || (isset($wpdb->last_error) && '' !== (string) $wpdb->last_error)) {
        throw new RuntimeException('Could not lock the blog slug before creation: ' . $slug);
    }
    if (null !== $existing_id && (int) $existing_id > 0) {
        throw new RuntimeException('A conflicting slug appeared after preflight; refusing duplicate creation: ' . $slug);
    }
}

/** Apply one new standard blog post atomically and verify all source-managed fields. */
function ts_blog_apply_post(array $record): array
{
    global $wpdb;
    ts_blog_start_create_transaction('post');
    $transaction_active = true;
    $post_id = 0;
    $term_id = 0;
    try {
        ts_blog_lock_slug_for_create('post', (string) $record['slug']);

        $term = term_exists((string) $record['category_name'], 'category');
        if (!$term) {
            $term = wp_insert_term((string) $record['category_name'], 'category');
        }
        if (is_wp_error($term)) {
            throw new RuntimeException('Could not create source category for ' . $record['slug'] . ': ' . $term->get_error_message());
        }
        $term_id = is_array($term) ? (int) ($term['term_id'] ?? 0) : (int) $term;
        if ($term_id < 1) {
            throw new RuntimeException('Could not resolve source category for ' . $record['slug']);
        }

        $post_date = (string) $record['published_at'] . ' 12:00:00';
        $post_id = wp_insert_post(wp_slash([
            'post_type' => 'post',
            'post_status' => 'draft',
            'post_name' => (string) $record['slug'],
            'post_title' => (string) $record['title'],
            'post_excerpt' => (string) ($record['excerpt'] ?? ''),
            'post_content' => (string) $record['content_html'],
            'post_date' => $post_date,
            'post_date_gmt' => get_gmt_from_date($post_date),
            'post_author' => get_current_user_id(),
            'comment_status' => 'closed',
            'ping_status' => 'closed',
        ]), true);
        if (is_wp_error($post_id) || !is_numeric($post_id) || (int) $post_id < 1) {
            throw new RuntimeException('Could not create staging blog post: ' . $record['slug']);
        }
        $post_id = (int) $post_id;

        $term_result = wp_set_post_terms($post_id, [$term_id], 'category', false);
        if (is_wp_error($term_result)) {
            throw new RuntimeException('Could not assign source category to ' . $record['slug'] . ': ' . $term_result->get_error_message());
        }

        $field_values = [
            'field_ts_blog_author_display' => (string) $record['author_display'],
            'field_ts_blog_featured' => !empty($record['featured']) ? 1 : 0,
            'field_ts_blog_hero_image_url' => (string) ($record['hero_image_url'] ?? ''),
            'field_ts_blog_hero_image_alt' => (string) ($record['hero_image_alt'] ?? ''),
            'field_ts_blog_source_url' => (string) $record['source_url'],
        ];
        foreach ($field_values as $field_key => $value) {
            update_field($field_key, $value, $post_id);
        }

        $record_hash = ts_blog_source_record_hash($record);
        $repairs_json = wp_json_encode($record['link_repairs_applied'] ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if (!is_string($repairs_json)) {
            throw new RuntimeException('Could not encode blog link-repair audit data: ' . $record['slug']);
        }
        $audit_meta = [
            '_ts_blog_import_source_slug' => (string) $record['slug'],
            '_ts_blog_import_record_hash' => $record_hash,
            '_ts_blog_import_source_url' => (string) $record['source_url'],
            '_ts_blog_import_source_body_sha256' => (string) $record['source_body_sha256'],
            '_ts_blog_import_content_sha256' => (string) $record['content_sha256'],
            '_ts_blog_import_hero_media_status' => (string) $record['hero_media_status'],
            '_ts_blog_import_link_repairs' => $repairs_json,
            '_ts_blog_import_state' => 'pending',
        ];
        foreach ($audit_meta as $key => $value) {
            ts_blog_save_meta($post_id, $key, $value);
        }

        clean_post_cache($post_id);
        $draft_state = ts_blog_current_post_state($post_id);
        if (ts_blog_state_hash($draft_state) !== ts_blog_state_hash(ts_blog_expected_post_state($record, 'draft'))) {
            throw new RuntimeException('Staging blog post failed draft-state verification: ' . $record['slug']);
        }

        $expected = ts_blog_expected_post_state($record, 'publish');
        $snapshot_json = wp_json_encode($expected, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS);
        if (!is_string($snapshot_json)) {
            throw new RuntimeException('Could not encode blog import snapshot: ' . $record['slug']);
        }
        ts_blog_save_meta($post_id, '_ts_blog_import_snapshot', $snapshot_json);
        ts_blog_save_meta($post_id, '_ts_blog_import_snapshot_hash', ts_blog_state_hash($expected));
        ts_blog_save_meta($post_id, '_ts_blog_import_state', 'publishing');

        $published_id = wp_update_post(wp_slash(['ID' => $post_id, 'post_status' => 'publish']), true);
        if (is_wp_error($published_id) || (int) $published_id !== $post_id) {
            throw new RuntimeException('Could not publish staging blog post: ' . $record['slug']);
        }
        clean_post_cache($post_id);
        if (ts_blog_state_hash(ts_blog_current_post_state($post_id)) !== ts_blog_state_hash($expected)) {
            wp_update_post(wp_slash(['ID' => $post_id, 'post_status' => 'draft']), true);
            throw new RuntimeException('Staging blog post failed post-publish verification: ' . $record['slug']);
        }

        ts_blog_save_meta($post_id, '_ts_blog_import_state', 'ready');
        if ($wpdb->query('COMMIT') === false) {
            $wpdb->query('ROLLBACK');
            $transaction_active = false;
            throw new RuntimeException('Blog post commit failed; the transaction was rolled back.');
        }
        $transaction_active = false;
        clean_post_cache($post_id);
        clean_term_cache($term_id, 'category');
        return ['action' => 'created', 'slug' => (string) $record['slug'], 'post_id' => $post_id];
    } catch (Throwable $error) {
        if ($transaction_active) {
            $wpdb->query('ROLLBACK');
        }
        if ($post_id > 0) {
            clean_post_cache($post_id);
        }
        if ($term_id > 0) {
            clean_term_cache($term_id, 'category');
        }
        throw $error;
    }
}

/** Build a normalized current state for a WordPress page or Elementor template. */
function ts_blog_resource_state_hash(array $state): string
{
    return ts_blog_state_hash($state);
}

/** Create a verified, importer-owned Elementor page or Theme Builder template. */
function ts_blog_apply_resource(array $plan, array $conditions_api = []): array
{
    global $wpdb;
    if ('unchanged' === $plan['action']) {
        return ['action' => 'unchanged', 'slug' => (string) $plan['expected']['post_name'], 'post_id' => (int) $plan['post_id']];
    }

    $kind = (string) $plan['kind'];
    $expected = $plan['expected'];
    $post_type = (string) $expected['post_type'];
    $slug = (string) $expected['post_name'];
    ts_blog_start_create_transaction('Elementor resource');
    $transaction_active = true;
    $post_id = 0;
    try {
        ts_blog_lock_slug_for_create($post_type, $slug);

        $post_id = wp_insert_post(wp_slash([
            'post_type' => $post_type,
            'post_status' => 'draft',
            'post_name' => $slug,
            'post_title' => (string) $expected['post_title'],
            'post_content' => (string) $expected['post_content'],
            'comment_status' => 'closed',
            'ping_status' => 'closed',
        ]), true);
        if (is_wp_error($post_id) || !is_numeric($post_id) || (int) $post_id < 1) {
            throw new RuntimeException('Could not create blog Elementor resource: ' . $slug);
        }
        $post_id = (int) $post_id;

        if ('blog_page' === $kind) {
            ts_blog_save_meta($post_id, '_wp_page_template', (string) $expected['page_template']);
        } else {
            ts_blog_save_meta($post_id, '_elementor_template_type', (string) $expected['template_type']);
            ts_blog_save_meta($post_id, '_elementor_page_settings', $expected['page_settings']);
        }
        ts_blog_save_meta($post_id, '_elementor_edit_mode', (string) $expected['edit_mode']);
        ts_blog_save_meta($post_id, '_elementor_version', (string) $expected['elementor_version']);
        ts_blog_save_meta($post_id, '_elementor_data', (string) $expected['elementor_data']);

        if ('single_template' === $kind) {
            $manager = \ElementorPro\Modules\ThemeBuilder\Module::instance()->get_conditions_manager();
            if (!is_object($manager) || !method_exists($manager, 'save_conditions') || !$manager->save_conditions($post_id, $conditions_api)) {
                throw new RuntimeException('Could not save Elementor single-post conditions for the blog template.');
            }
        }

        clean_post_cache($post_id);
        $draft_state = ts_blog_current_resource_state($post_id, $kind);
        $expected_draft = $expected;
        $expected_draft['post_status'] = 'draft';
        if (ts_blog_resource_state_hash($draft_state) !== ts_blog_resource_state_hash($expected_draft)) {
            throw new RuntimeException('Blog Elementor resource failed draft-state verification: ' . $slug);
        }

        $published_id = wp_update_post(wp_slash(['ID' => $post_id, 'post_status' => 'publish']), true);
        if (is_wp_error($published_id) || (int) $published_id !== $post_id) {
            throw new RuntimeException('Could not publish blog Elementor resource: ' . $slug);
        }
        clean_post_cache($post_id);
        $actual_state = ts_blog_current_resource_state($post_id, $kind);
        $snapshot_hash = ts_blog_resource_state_hash($actual_state);
        if (!hash_equals(ts_blog_resource_state_hash($expected), $snapshot_hash)) {
            wp_update_post(wp_slash(['ID' => $post_id, 'post_status' => 'draft']), true);
            throw new RuntimeException('Blog Elementor resource failed post-publish verification: ' . $slug);
        }

        ts_blog_save_meta($post_id, '_ts_blog_resource_owner', 'approved-blog-import-v1');
        ts_blog_save_meta($post_id, '_ts_blog_resource_import_hash', ts_blog_resource_state_hash($expected));
        ts_blog_save_meta($post_id, '_ts_blog_resource_snapshot_hash', $snapshot_hash);
        ts_blog_save_meta($post_id, '_ts_blog_resource_state', 'ready');
        if ($wpdb->query('COMMIT') === false) {
            $wpdb->query('ROLLBACK');
            $transaction_active = false;
            throw new RuntimeException('Blog Elementor resource commit failed; the transaction was rolled back.');
        }
        $transaction_active = false;
        clean_post_cache($post_id);
        return ['action' => 'created', 'slug' => $slug, 'post_id' => $post_id];
    } catch (Throwable $error) {
        if ($transaction_active) {
            $wpdb->query('ROLLBACK');
        }
        if ($post_id > 0) {
            clean_post_cache($post_id);
        }
        if ('single_template' === $kind && class_exists('ElementorPro\\Modules\\ThemeBuilder\\Module')) {
            \ElementorPro\Modules\ThemeBuilder\Module::instance()->get_conditions_manager()->clear_cache();
        }
        throw $error;
    }
}

/** Refresh published single-template conditions so Elementor's location cache includes the template. */
function ts_blog_refresh_single_template_conditions(int $post_id, array $expected_conditions, array $conditions_api): void
{
    $module = \ElementorPro\Modules\ThemeBuilder\Module::instance();
    $manager = is_object($module) ? $module->get_conditions_manager() : null;
    if (
        !is_object($manager)
        || !method_exists($manager, 'save_conditions')
        || !method_exists($manager, 'clear_location_cache')
        || 'publish' !== get_post_status($post_id)
        || !is_object($module->get_document($post_id))
    ) {
        throw new RuntimeException('Elementor cannot refresh published blog-template conditions.');
    }

    // save_conditions() regenerates its cache even when identical metadata yields a false update result.
    $manager->save_conditions($post_id, $conditions_api);
    $manager->clear_location_cache();
    clean_post_cache($post_id);

    $actual_conditions = get_post_meta($post_id, '_elementor_conditions', true);
    if (!is_array($actual_conditions) || array_values($expected_conditions) !== array_values($actual_conditions)) {
        throw new RuntimeException('Published blog template conditions failed post-publish verification.');
    }
}

/** Import the reviewed manifest, /blog page, and per-post Elementor template. */
function ts_blog_import_manifest(array $manifest, bool $dry_run = true, bool $confirmed = false, string $backup_dir = ''): array
{
    ts_blog_assert_runtime_dependencies();
    ts_blog_validate_manifest($manifest);

    $site_origin = (string) home_url('/');
    $site_host = strtolower((string) parse_url($site_origin, PHP_URL_HOST));
    $is_admin = current_user_can('manage_options');
    $blog_public = get_option('blog_public');
    ts_blog_validate_run_mode(!$dry_run, $confirmed, $is_admin, $site_origin, $blog_public);

    if (!$dry_run) {
        if ('' === $backup_dir) {
            throw new RuntimeException('Applying blog imports requires --backup-dir with a verified pre-write backup.');
        }
        ts_blog_verify_backup_directory($backup_dir, ABSPATH);
        ts_blog_assert_transactional_storage();
    }

    $acf_fields = [
        'field_ts_blog_author_display' => 'ts_blog_author_display',
        'field_ts_blog_featured' => 'ts_blog_featured',
        'field_ts_blog_hero_image_url' => 'ts_blog_hero_image_url',
        'field_ts_blog_hero_image_alt' => 'ts_blog_hero_image_alt',
        'field_ts_blog_source_url' => 'ts_blog_source_url',
    ];
    foreach ($acf_fields as $key => $name) {
        $field = acf_get_field($key);
        if (!is_array($field) || $name !== (string) ($field['name'] ?? '')) {
            throw new RuntimeException('Required blog field is not registered in ACF: ' . $name);
        }
    }

    $post_plan = ts_blog_collect_post_plan($manifest);
    $missing_posts = count(array_filter($post_plan, static fn(array $item): bool => 'create' === $item['action']));
    $page_expected = ts_blog_expected_resource_state('blog_page');
    $page_plan = ts_blog_plan_resource('blog_page', $page_expected);

    $template_matches = ts_blog_resources_by_slug('elementor_library', 'ts-single-blog');
    if ($template_matches && $missing_posts > 0) {
        throw new RuntimeException('A blog single template exists while approved posts are missing; refusing a partial template update.');
    }
    $post_ids = [];
    foreach ($post_plan as $item) {
        if ((int) $item['post_id'] > 0) {
            $post_ids[] = (int) $item['post_id'];
        }
    }
    $template_conditions = $missing_posts > 0 ? [] : ts_blog_build_single_template_conditions($post_ids);
    $template_expected = ts_blog_expected_resource_state('single_template', $template_conditions);
    $template_plan = ts_blog_plan_resource('single_template', $template_expected);

    $report = [
        'site_host' => $site_host,
        'blog_public' => $blog_public,
        'posts' => array_map(static function (array $item): array {
            return ['action' => $item['action'], 'slug' => $item['slug'], 'post_id' => (int) $item['post_id']];
        }, $post_plan),
        'blog_index' => ['action' => $page_plan['action'], 'slug' => 'blog', 'post_id' => (int) $page_plan['post_id']],
        'single_template' => ['action' => $template_plan['action'], 'slug' => 'ts-single-blog', 'conditions' => $template_conditions, 'post_id' => (int) $template_plan['post_id']],
    ];
    if ($dry_run) {
        return $report;
    }

    $applied_posts = [];
    $post_ids_by_slug = [];
    foreach ($post_plan as $item) {
        if ('unchanged' === $item['action']) {
            $result = ['action' => 'unchanged', 'slug' => $item['slug'], 'post_id' => (int) $item['post_id']];
        } else {
            $record = null;
            foreach ($manifest['posts'] as $candidate) {
                if ($candidate['slug'] === $item['slug']) {
                    $record = $candidate;
                    break;
                }
            }
            if (!is_array($record)) {
                throw new RuntimeException('Manifest record disappeared during blog import: ' . $item['slug']);
            }
            $result = ts_blog_apply_post($record);
        }
        $applied_posts[] = $result;
        $post_ids_by_slug[(string) $result['slug']] = (int) $result['post_id'];
    }

    $ordered_post_ids = [];
    foreach ($manifest['posts'] as $record) {
        $post_id = (int) ($post_ids_by_slug[(string) $record['slug']] ?? 0);
        if ($post_id < 1) {
            throw new RuntimeException('Could not resolve imported post ID for single-template conditions: ' . $record['slug']);
        }
        $ordered_post_ids[] = $post_id;
    }
    $template_conditions = ts_blog_build_single_template_conditions($ordered_post_ids);
    $template_expected = ts_blog_expected_resource_state('single_template', $template_conditions);

    $page_result = ts_blog_apply_resource($page_plan);
    $conditions_api = array_map(static function (string $condition): array {
        return explode('/', $condition);
    }, $template_conditions);
    $template_plan['expected'] = $template_expected;
    $template_result = ts_blog_apply_resource($template_plan, $conditions_api);
    ts_blog_refresh_single_template_conditions((int) $template_result['post_id'], $template_conditions, $conditions_api);

    flush_rewrite_rules(false);
    $verification = ts_blog_import_manifest($manifest, true, false, '');
    $all_posts_unchanged = 12 === count($verification['posts'])
        && 12 === count(array_filter($verification['posts'], static fn(array $item): bool => 'unchanged' === $item['action']));
    if (!$all_posts_unchanged || 'unchanged' !== $verification['blog_index']['action'] || 'unchanged' !== $verification['single_template']['action']) {
        throw new RuntimeException('Post-apply verification did not report all blog records and layouts unchanged.');
    }

    return [
        'applied' => [
            'posts' => $applied_posts,
            'blog_index' => $page_result,
            'single_template' => $template_result,
        ],
        'verification' => $verification,
    ];
}
