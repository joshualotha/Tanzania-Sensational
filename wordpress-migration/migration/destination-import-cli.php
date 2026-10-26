<?php
/**
 * Register the staging destination importer as a WP-CLI command.
 * Load with --require, then run: wp ts destinations import
 */

if (!class_exists('WP_CLI')) {
    throw new RuntimeException('This entrypoint must be loaded by WP-CLI.');
}

/**
 * Run the approved six-destination staging import.
 *
 * @when after_wp_load
 *
 * ## OPTIONS
 *
 * [--apply]
 * : Apply changes. Omit for a read-only dry run.
 *
 * [--confirm-staging-write]
 * : Explicitly confirm a staging write; required together with --apply.
 *
 * ## EXAMPLES
 *
 *     wp ts destinations import
 *     wp --user=<staging-admin-id> ts destinations import --apply --confirm-staging-write
 */
function ts_migration_wp_cli_import_destinations(array $args, array $assoc_args): void
{
    if ($args) {
        WP_CLI::error('This command does not accept positional arguments.');
    }

    $allowed_flags = ['apply', 'confirm-staging-write'];
    $unexpected_flags = array_diff(array_keys($assoc_args), $allowed_flags);
    if ($unexpected_flags) {
        WP_CLI::error('Unexpected option(s): ' . implode(', ', $unexpected_flags));
    }

    foreach ($assoc_args as $flag => $value) {
        if (true !== $value || !in_array($flag, $allowed_flags, true)) {
            WP_CLI::error('Options must be supplied as bare flags; received invalid --' . $flag . '.');
        }
    }

    $apply = array_key_exists('apply', $assoc_args);
    $confirmed = array_key_exists('confirm-staging-write', $assoc_args);
    if ($apply && !$confirmed) {
        WP_CLI::error('Applying changes requires both --apply and --confirm-staging-write.');
    }
    if (!$apply && $confirmed) {
        WP_CLI::error('--confirm-staging-write requires --apply.');
    }

    require_once __DIR__ . '/destination-importer.php';

    $manifest_path = __DIR__ . '/destination-import-manifest.json';
    if (!is_readable($manifest_path)) {
        WP_CLI::error('Destination import manifest is missing or unreadable.');
    }

    try {
        $manifest = json_decode((string) file_get_contents($manifest_path), true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($manifest)) {
            WP_CLI::error('Destination import manifest must decode to an object.');
        }
        $results = ts_migration_import_destinations($manifest, !$apply);
        $json = wp_json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if (!is_string($json)) {
            WP_CLI::error('Could not encode destination import results.');
        }
        WP_CLI::log($json);
    } catch (Throwable $error) {
        WP_CLI::error($error->getMessage());
    }

    if ($apply) {
        WP_CLI::success('Staging destination import applied and verified.');
        return;
    }

    WP_CLI::success('Dry run complete; no database records were changed.');
}

WP_CLI::add_command('ts destinations import', 'ts_migration_wp_cli_import_destinations');
