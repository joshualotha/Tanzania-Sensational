<?php

declare(strict_types=1);

require_once __DIR__ . '/../migration/blog-importer.php';

function blog_import_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function blog_import_assert_throws(callable $callable, string $message): void
{
    try {
        $callable();
    } catch (RuntimeException $exception) {
        return;
    }

    throw new RuntimeException($message);
}

$manifest = json_decode((string) file_get_contents(__DIR__ . '/../migration/blog-import-manifest.json'), true, 512, JSON_THROW_ON_ERROR);
ts_blog_validate_manifest($manifest);

$create_plan = ts_blog_build_import_plan($manifest, []);
blog_import_assert(12 === count($create_plan), 'A clean staging database plans twelve creates.');
blog_import_assert(12 === count(array_filter($create_plan, static fn(array $item): bool => 'create' === $item['action'])), 'All new source-matched posts are creates.');

$first = $manifest['posts'][0];
$existing = [
    $first['slug'] => [
        'source_slug' => $first['slug'],
        'import_hash' => ts_blog_source_record_hash($first),
        'state_marker' => 'ready',
        'snapshot_hash' => 'stored-snapshot',
        'actual_snapshot_hash' => 'stored-snapshot',
    ],
];
$repeat_plan = ts_blog_build_import_plan($manifest, $existing);
blog_import_assert('unchanged' === $repeat_plan[0]['action'], 'An intact importer-owned post is idempotently skipped.');
blog_import_assert(11 === count(array_filter($repeat_plan, static fn(array $item): bool => 'create' === $item['action'])), 'Only absent posts remain creates on rerun.');

$partial_import = $existing;
$partial_import[$first['slug']]['state_marker'] = 'pending';
blog_import_assert_throws(
    static fn() => ts_blog_build_import_plan($manifest, $partial_import),
    'A partially imported post without a ready marker must be refused.'
);

$unowned_collision = $existing;
$unowned_collision[$first['slug']]['source_slug'] = '';
blog_import_assert_throws(
    static fn() => ts_blog_build_import_plan($manifest, $unowned_collision),
    'An existing unowned record with a source slug must be refused.'
);

$editor_drift = $existing;
$editor_drift[$first['slug']]['actual_snapshot_hash'] = 'editor-modified-snapshot';
blog_import_assert_throws(
    static fn() => ts_blog_build_import_plan($manifest, $editor_drift),
    'An importer-owned record changed by an editor must be refused, not overwritten.'
);

$changed_source = $manifest;
$changed_source['posts'][0]['content_html'] .= '<p>Mutation.</p>';
blog_import_assert_throws(
    static fn() => ts_blog_validate_manifest($changed_source),
    'A manifest body that no longer matches its SHA-256 must be refused.'
);

$stale_link_variant = $manifest;
$stale_link_variant['posts'][0]['content_html'] = preg_replace(
    '/href="\\/kilimanjaro-pillar\\/"/',
    'href="https://tanzaniasensational.com/trekking?from=blog#routes"',
    $stale_link_variant['posts'][0]['content_html'],
    1
);
$stale_link_variant['posts'][0]['content_sha256'] = hash('sha256', $stale_link_variant['posts'][0]['content_html']);
blog_import_assert_throws(
    static fn() => ts_blog_validate_manifest($stale_link_variant),
    'Absolute, query, and fragment variants of a repaired source route must be refused.'
);

$unquoted_link_variant = $manifest;
$unquoted_link_variant['posts'][0]['content_html'] = preg_replace(
    '/href="\\/kilimanjaro-pillar\\/"/',
    'href=https://tanzaniasensational.com/trekking?from=blog',
    $unquoted_link_variant['posts'][0]['content_html'],
    1
);
$unquoted_link_variant['posts'][0]['content_sha256'] = hash('sha256', $unquoted_link_variant['posts'][0]['content_html']);
blog_import_assert_throws(
    static fn() => ts_blog_validate_manifest($unquoted_link_variant),
    'Unquoted href attributes must not bypass source-route validation.'
);

$wrong_record_repair = $manifest;
$wrong_record_repair['posts'][0]['link_repairs_applied']['/trekking'] = '/contact';
blog_import_assert_throws(
    static fn() => ts_blog_validate_manifest($wrong_record_repair),
    'Per-article repair metadata must match the reviewed source-to-target mapping.'
);

$wrong_global_target = $manifest;
$wrong_global_target['link_repairs']['/trekking'] = '/contact';
blog_import_assert_throws(
    static fn() => ts_blog_validate_manifest($wrong_global_target),
    'A globally claimed target must match the target used for that source route.'
);

ts_blog_validate_run_mode(false, false, false, 'https://test.tanzaniasensational.com/', 0);
ts_blog_validate_run_mode(true, true, true, 'https://test.tanzaniasensational.com/', 0);
blog_import_assert_throws(
    static fn() => ts_blog_validate_run_mode(true, true, true, 'https://tanzaniasensational.com/', 0),
    'Applying outside the staging host must be refused.'
);
blog_import_assert_throws(
    static fn() => ts_blog_validate_run_mode(true, true, true, 'http://test.tanzaniasensational.com/', 0),
    'Applying over plain HTTP must be refused.'
);
blog_import_assert_throws(
    static fn() => ts_blog_validate_run_mode(true, true, true, 'https://test.tanzaniasensational.com:8080/', 0),
    'Applying through a nonstandard staging port must be refused.'
);
blog_import_assert_throws(
    static fn() => ts_blog_validate_run_mode(true, true, true, 'https://@test.tanzaniasensational.com/', 0),
    'An empty user-info authority must not be treated as the staging origin.'
);
blog_import_assert_throws(
    static fn() => ts_blog_validate_run_mode(true, true, true, 'https://user:@test.tanzaniasensational.com/', 0),
    'A user-info authority must not be treated as the staging origin.'
);
blog_import_assert_throws(
    static fn() => ts_blog_validate_run_mode(true, true, true, 'https://test.tanzaniasensational.com/', 1),
    'Applying while staging is indexable must be refused.'
);
blog_import_assert_throws(
    static fn() => ts_blog_validate_run_mode(true, false, true, 'https://test.tanzaniasensational.com/', 0),
    'Applying without explicit confirmation must be refused.'
);
blog_import_assert_throws(
    static fn() => ts_blog_validate_run_mode(true, true, false, 'https://test.tanzaniasensational.com/', 0),
    'Applying without staging administrator privileges must be refused.'
);

$scratch = getenv('TMPDIR');
blog_import_assert(is_string($scratch) && is_dir($scratch), 'The configured scratch directory is available for backup tests.');
$test_root = rtrim($scratch, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . 'blog-backup-test-' . bin2hex(random_bytes(6));
$public_root = $test_root . '/public';
$backup_root = $test_root . '/private-backup';
mkdir($public_root, 0700, true);
mkdir($backup_root, 0700, true);
$backup_files = [
    'database.sql' => 'database snapshot',
    'custom-plugins.tgz' => 'plugin archive',
    'plugin-inventory.txt' => 'active plugins',
    'theme-inventory.txt' => 'active themes',
];
$checksum_lines = [];
foreach ($backup_files as $name => $contents) {
    file_put_contents($backup_root . '/' . $name, $contents);
    $checksum_lines[] = hash('sha256', $contents) . '  ' . $name;
}
file_put_contents($backup_root . '/SHA256SUMS', implode("\n", $checksum_lines) . "\n");
blog_import_assert(4 === count(ts_blog_verify_backup_directory($backup_root, $public_root)), 'A complete checksummed backup outside the public root is accepted.');
blog_import_assert_throws(
    static fn() => ts_blog_verify_backup_directory($public_root, $public_root),
    'A backup stored inside the public root must be refused.'
);
file_put_contents($backup_root . '/database.sql', 'tampered snapshot');
blog_import_assert_throws(
    static fn() => ts_blog_verify_backup_directory($backup_root, $public_root),
    'A backup with a checksum mismatch must be refused.'
);
foreach (glob($backup_root . '/*') ?: [] as $path) {
    unlink($path);
}
rmdir($backup_root);
rmdir($public_root);
rmdir($test_root);

$conditions = ts_blog_build_single_template_conditions([501, 507, 512]);
blog_import_assert(
    ['include/singular/post/501', 'include/singular/post/507', 'include/singular/post/512'] === $conditions,
    'The single template is scoped to exact imported posts, not every standard post.'
);
blog_import_assert_throws(
    static fn() => ts_blog_build_single_template_conditions([501, 501]),
    'Duplicate post IDs must be refused in template conditions.'
);
blog_import_assert_throws(
    static fn() => ts_blog_build_single_template_conditions([0]),
    'Non-positive post IDs must be refused in template conditions.'
);

$runtime_source = (string) file_get_contents(__DIR__ . '/../migration/blog-import-runtime.php');
$template_apply_offset = strpos($runtime_source, '$template_result = ts_blog_apply_resource($template_plan, $conditions_api);');
$cache_refresh_offset = false === $template_apply_offset
    ? false
    : strpos($runtime_source, 'ts_blog_refresh_single_template_conditions((int) $template_result[\'post_id\'], $template_conditions, $conditions_api);', $template_apply_offset);
$rewrite_flush_offset = false === $template_apply_offset
    ? false
    : strpos($runtime_source, 'flush_rewrite_rules(false);', $template_apply_offset);
blog_import_assert(
    false !== $template_apply_offset
        && false !== $cache_refresh_offset
        && false !== $rewrite_flush_offset
        && $template_apply_offset < $cache_refresh_offset
        && $cache_refresh_offset < $rewrite_flush_offset,
    'Elementor single-template conditions must be refreshed after publication before post-apply verification.'
);

fwrite(STDOUT, "PASS: blog importer validation, idempotency, and collision refusal.\n");
