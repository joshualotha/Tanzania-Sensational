<?php

declare(strict_types=1);

$GLOBALS['blog_acf_test_actions'] = [];
$GLOBALS['blog_acf_test_groups'] = [];

function __($text, string $domain = ''): string
{
    return (string) $text;
}

function add_action(string $hook, callable $callback, int $priority = 10, int $accepted_args = 1): bool
{
    $GLOBALS['blog_acf_test_actions'][$hook][] = $callback;
    return true;
}

function acf_add_local_field_group(array $group): void
{
    $GLOBALS['blog_acf_test_groups'][] = $group;
}

function blog_fields_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

require_once __DIR__ . '/../staging-plugin/blog-fields.php';
foreach ($GLOBALS['blog_acf_test_actions']['acf/init'] ?? [] as $callback) {
    $callback();
}

blog_fields_assert(1 === count($GLOBALS['blog_acf_test_groups']), 'The blog ACF group registers once.');
$group = $GLOBALS['blog_acf_test_groups'][0];
blog_fields_assert('group_ts_blog_article' === ($group['key'] ?? null), 'The blog field group has a stable key.');
blog_fields_assert([[[ 'param' => 'post_type', 'operator' => '==', 'value' => 'post' ]]] === ($group['location'] ?? null), 'Blog fields attach only to standard posts.');

$fields = [];
foreach ($group['fields'] ?? [] as $field) {
    $fields[$field['name']] = $field;
}
$expected = [
    'ts_blog_author_display' => 'text',
    'ts_blog_featured' => 'true_false',
    'ts_blog_hero_image_url' => 'url',
    'ts_blog_hero_image_alt' => 'text',
    'ts_blog_source_url' => 'url',
];
foreach ($expected as $name => $type) {
    blog_fields_assert(isset($fields[$name]), 'Missing editor field: ' . $name);
    blog_fields_assert($type === $fields[$name]['type'], 'Unexpected ACF type for ' . $name);
}
blog_fields_assert(!empty($group['show_in_rest']), 'Blog editor fields are available in the REST API.');

fwrite(STDOUT, "PASS: blog ACF fields are registered and editor-accessible.\n");
