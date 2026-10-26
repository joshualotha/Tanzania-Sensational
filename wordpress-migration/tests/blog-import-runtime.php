<?php

declare(strict_types=1);

$GLOBALS['blog_runtime_posts'] = [];
$GLOBALS['blog_runtime_meta'] = [];
$GLOBALS['blog_runtime_fields'] = [];
$GLOBALS['blog_runtime_categories'] = [];

function get_posts(array $args): array
{
    return array_values($GLOBALS['blog_runtime_posts']);
}

function get_post(int $post_id)
{
    return $GLOBALS['blog_runtime_posts'][$post_id] ?? null;
}

function get_post_meta(int $post_id, string $key, bool $single = false)
{
    return $GLOBALS['blog_runtime_meta'][$post_id][$key] ?? '';
}

function wp_slash(string $value): string
{
    return addslashes($value);
}

function update_post_meta(int $post_id, string $key, $value): bool
{
    $GLOBALS['blog_runtime_meta'][$post_id][$key] = is_string($value) ? stripslashes($value) : $value;
    return true;
}

function get_field(string $field_name, int $post_id)
{
    return $GLOBALS['blog_runtime_fields'][$post_id][$field_name] ?? null;
}

function get_the_category(int $post_id): array
{
    return $GLOBALS['blog_runtime_categories'][$post_id] ?? [];
}

function blog_runtime_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

require_once __DIR__ . '/../migration/blog-import-runtime.php';

$manifest = json_decode((string) file_get_contents(__DIR__ . '/../migration/blog-import-manifest.json'), true, 512, JSON_THROW_ON_ERROR);
$record = $manifest['posts'][0];
$post_id = 501;
$expected = ts_blog_expected_post_state($record, 'publish');
$snapshot_json = json_encode($expected, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS | JSON_THROW_ON_ERROR);

$GLOBALS['blog_runtime_posts'][$post_id] = (object) [
    'ID' => $post_id,
    'post_type' => 'post',
    'post_status' => 'publish',
    'post_name' => $record['slug'],
    'post_title' => $record['title'],
    'post_excerpt' => $record['excerpt'],
    'post_content' => $record['content_html'],
    'post_date' => $record['published_at'] . ' 12:00:00',
];
$GLOBALS['blog_runtime_meta'][$post_id] = [
    '_ts_blog_import_source_slug' => $record['slug'],
    '_ts_blog_import_record_hash' => ts_blog_source_record_hash($record),
    '_ts_blog_import_state' => 'ready',
];
ts_blog_save_meta($post_id, '_ts_blog_import_snapshot', $snapshot_json);
ts_blog_save_meta($post_id, '_ts_blog_import_snapshot_hash', ts_blog_state_hash($expected));
$GLOBALS['blog_runtime_fields'][$post_id] = [
    'ts_blog_author_display' => $record['author_display'],
    'ts_blog_featured' => $record['featured'] ? 1 : 0,
    'ts_blog_hero_image_url' => $record['hero_image_url'],
    'ts_blog_hero_image_alt' => $record['hero_image_alt'],
    'ts_blog_source_url' => $record['source_url'],
];
$GLOBALS['blog_runtime_categories'][$post_id] = [(object) ['name' => htmlspecialchars($record['category_name'], ENT_QUOTES | ENT_HTML5, 'UTF-8')]];

$plan = ts_blog_collect_post_plan($manifest);
blog_runtime_assert(12 === count($plan), 'A partial import must still plan all twelve approved articles.');
blog_runtime_assert('unchanged' === $plan[0]['action'] && $post_id === $plan[0]['post_id'], 'A JSON snapshot stored by the importer must round-trip as unchanged.');
blog_runtime_assert(11 === count(array_filter($plan, static fn(array $item): bool => 'create' === $item['action'])), 'A partial import must resume by creating only the eleven missing articles.');

$literal_entity_post_id = 502;
$GLOBALS['blog_runtime_posts'][$literal_entity_post_id] = clone $GLOBALS['blog_runtime_posts'][$post_id];
$GLOBALS['blog_runtime_posts'][$literal_entity_post_id]->ID = $literal_entity_post_id;
$GLOBALS['blog_runtime_fields'][$literal_entity_post_id] = $GLOBALS['blog_runtime_fields'][$post_id];
$GLOBALS['blog_runtime_categories'][$literal_entity_post_id] = [(object) ['name' => htmlspecialchars('Literal &amp; Label', ENT_QUOTES | ENT_HTML5, 'UTF-8')]];
$literal_entity_state = ts_blog_current_post_state($literal_entity_post_id);
blog_runtime_assert(['Literal &amp; Label'] === $literal_entity_state['categories'], 'Category snapshot normalization must decode exactly one HTML-escaped layer.');

fwrite(STDOUT, "PASS: WordPress runtime recognizes a stored snapshot and safely resumes a partial import.\n");
