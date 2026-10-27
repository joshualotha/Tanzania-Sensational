<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

$GLOBALS['ts_trekking_test_actions'] = [];
$GLOBALS['ts_trekking_test_post_types'] = [];

function __(string $text, string $domain = ''): string
{
    return $text;
}

function add_action(string $hook, callable $callback): void
{
    $GLOBALS['ts_trekking_test_actions'][$hook][] = $callback;
}

function register_post_type(string $post_type, array $args): void
{
    $GLOBALS['ts_trekking_test_post_types'][$post_type] = $args;
}

function register_taxonomy(string $taxonomy, array $object_type, array $args): void
{
}

function register_activation_hook(string $file, $callback): void
{
}

require dirname(__DIR__) . '/staging-plugin/cpt.php';

foreach ($GLOBALS['ts_trekking_test_actions']['init'] ?? [] as $callback) {
    $callback();
}

$route = $GLOBALS['ts_trekking_test_post_types']['ts_trek_route'] ?? null;
if (!is_array($route)) {
    throw new RuntimeException('Trekking routes must have a dedicated editable post type.');
}
if (($route['public'] ?? false) !== true || ($route['show_in_rest'] ?? false) !== true) {
    throw new RuntimeException('Trekking routes must be public and available to the editor.');
}
if (($route['has_archive'] ?? true) !== false) {
    throw new RuntimeException('Trekking routes must not claim the existing Kilimanjaro landing URL as an archive.');
}
if (($route['rewrite']['slug'] ?? null) !== 'trekking/kilimanjaro' || ($route['rewrite']['with_front'] ?? true) !== false) {
    throw new RuntimeException('Trekking routes must retain the exact source URL base without a permalink front prefix.');
}
foreach (['title', 'editor', 'thumbnail', 'revisions'] as $support) {
    if (!in_array($support, $route['supports'] ?? [], true)) {
        throw new RuntimeException('Trekking route editor is missing required support: ' . $support);
    }
}

echo "PASS: trekking route post type preserves editable source route URLs.\n";
