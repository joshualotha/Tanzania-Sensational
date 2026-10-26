<?php
/**
 * WP-CLI entrypoint for the reviewed staging blog import.
 * Load with --require, then run: wp ts blog import
 */

if (!class_exists('WP_CLI')) {
    throw new RuntimeException('This entrypoint must be loaded by WP-CLI.');
}

/**
 * Run a read-only preflight or explicitly confirmed staging import.
 *
 * @when after_wp_load
 *
 * ## OPTIONS
 *
 * [--apply]
 * : Apply the reviewed posts and Elementor layouts. Omit for a read-only dry run.
 *
 * [--confirm-staging-write]
 * : Explicitly confirm a staging write; required together with --apply.
 *
 * [--backup-dir=<path>]
 * : Path to the pre-write staging backup; required together with --apply.
 *
 * ## EXAMPLES
 *
 *     wp ts blog import
 *     wp --user=<staging-admin-id> ts blog import --apply --confirm-staging-write --backup-dir=/home/tanzhihb/ts-migration-backups/<backup-id>
 */
function ts_blog_wp_cli_import(array $args, array $assoc_args): void
{
    if ($args) {
        WP_CLI::error('This command does not accept positional arguments.');
    }

    $allowed = ['apply', 'confirm-staging-write', 'backup-dir'];
    $unexpected = array_diff(array_keys($assoc_args), $allowed);
    if ($unexpected) {
        WP_CLI::error('Unexpected option(s): ' . implode(', ', $unexpected));
    }
    foreach (['apply', 'confirm-staging-write'] as $flag) {
        if (array_key_exists($flag, $assoc_args) && true !== $assoc_args[$flag]) {
            WP_CLI::error('Options must be supplied as bare flags; received invalid --' . $flag . '.');
        }
    }

    $apply = array_key_exists('apply', $assoc_args);
    $confirmed = array_key_exists('confirm-staging-write', $assoc_args);
    $backup_dir = $assoc_args['backup-dir'] ?? '';
    if (!is_string($backup_dir)) {
        WP_CLI::error('--backup-dir must be a filesystem path.');
    }
    if ($apply && (!$confirmed || '' === $backup_dir)) {
        WP_CLI::error('Applying changes requires --apply, --confirm-staging-write, and --backup-dir.');
    }
    if (!$apply && ($confirmed || '' !== $backup_dir)) {
        WP_CLI::error('--confirm-staging-write and --backup-dir are only valid together with --apply.');
    }

    require_once __DIR__ . '/blog-import-runtime.php';
    $manifest_path = __DIR__ . '/blog-import-manifest.json';
    if (!is_readable($manifest_path)) {
        WP_CLI::error('Blog import manifest is missing or unreadable.');
    }

    try {
        $manifest = json_decode((string) file_get_contents($manifest_path), true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($manifest)) {
            WP_CLI::error('Blog import manifest must decode to an object.');
        }
        $result = ts_blog_import_manifest($manifest, !$apply, $confirmed, $backup_dir);
        $json = wp_json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if (!is_string($json)) {
            WP_CLI::error('Could not encode blog import results.');
        }
        WP_CLI::log($json);
    } catch (Throwable $error) {
        WP_CLI::error($error->getMessage());
    }

    if ($apply) {
        WP_CLI::success('Staging blog posts and Elementor layouts applied and verified.');
        return;
    }
    WP_CLI::success('Dry run complete; no database records were changed.');
}

WP_CLI::add_command('ts blog import', 'ts_blog_wp_cli_import');
