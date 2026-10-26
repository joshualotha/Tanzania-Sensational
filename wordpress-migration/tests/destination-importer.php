<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

$GLOBALS['destination_import_test_posts'] = [];
$GLOBALS['destination_import_test_fields'] = [];
$GLOBALS['destination_import_test_meta'] = [];
$GLOBALS['destination_import_test_writes'] = 0;
$GLOBALS['destination_import_test_home_url'] = 'https://test.tanzaniasensational.com/';
$GLOBALS['destination_import_test_blog_public'] = '0';
$GLOBALS['destination_import_test_admin'] = true;
$GLOBALS['destination_import_test_missing_acf_field'] = null;
$GLOBALS['destination_import_test_fail_acf_field'] = null;
$GLOBALS['destination_import_test_fail_meta_key'] = null;
$GLOBALS['destination_import_test_fail_meta_value'] = null;
$GLOBALS['destination_import_test_post_read_counts'] = [];
$GLOBALS['destination_import_test_mutate_post_on_second_read'] = null;
$GLOBALS['destination_import_test_mutate_on_publish'] = false;
$GLOBALS['destination_import_test_mutate_during_first_update'] = null;
$GLOBALS['destination_import_test_deferred_editor_change'] = null;

class DestinationImportTestError
{
}

class DestinationImportTestWpdb
{
    public string $posts = 'wp_posts';
    public string $postmeta = 'wp_postmeta';
    public string $engine = 'InnoDB';
    public bool $transaction_active = false;
    public array $locking_queries = [];

    public function prepare(string $query, $value): string
    {
        if (str_contains($query, '%d')) {
            return str_replace('%d', (string) (int) $value, $query);
        }
        return str_replace('%s', "'" . addslashes((string) $value) . "'", $query);
    }

    public function get_var(string $query)
    {
        if (str_contains($query, 'information_schema.TABLES')) {
            return $this->engine;
        }
        if (str_contains($query, 'FOR UPDATE') && preg_match('/WHERE ID = (\\d+)/', $query, $matches)) {
            $this->locking_queries[] = $query;
            return isset($GLOBALS['destination_import_test_posts'][(int) $matches[1]]) ? (int) $matches[1] : null;
        }
        return null;
    }

    public function query(string $query)
    {
        if (str_contains($query, 'FOR UPDATE')) {
            $this->locking_queries[] = $query;
            return 0;
        }
        if ('START TRANSACTION' === $query) {
            $this->transaction_active = true;
            return 0;
        }
        if ('COMMIT' === $query) {
            $this->transaction_active = false;
            $deferred = $GLOBALS['destination_import_test_deferred_editor_change'];
            if (is_array($deferred)) {
                $GLOBALS['destination_import_test_posts'][$deferred['post_id']]->post_content = $deferred['content'];
                $GLOBALS['destination_import_test_deferred_editor_change'] = null;
            }
            return 0;
        }
        if ('ROLLBACK' === $query) {
            $this->transaction_active = false;
            return 0;
        }
        return false;
    }
}

class WP_CLI
{
    public static array $commands = [];
    public static array $messages = [];

    public static function add_command(string $name, callable $callback, array $args = []): bool
    {
        self::$commands[$name] = $callback;
        return true;
    }

    public static function log(string $message): void
    {
        self::$messages[] = $message;
    }

    public static function success(string $message): void
    {
        self::$messages[] = $message;
    }

    public static function error(string $message): void
    {
        throw new RuntimeException('WP-CLI error: ' . $message);
    }
}

$GLOBALS['wpdb'] = new DestinationImportTestWpdb();

function get_posts(array $args = []): array
{
    return array_values($GLOBALS['destination_import_test_posts']);
}

function get_post(int $post_id)
{
    $GLOBALS['destination_import_test_post_read_counts'][$post_id] = ($GLOBALS['destination_import_test_post_read_counts'][$post_id] ?? 0) + 1;
    if ($post_id === $GLOBALS['destination_import_test_mutate_post_on_second_read']
        && 2 === $GLOBALS['destination_import_test_post_read_counts'][$post_id]) {
        $GLOBALS['destination_import_test_posts'][$post_id]->post_content .= ' Concurrent editor change.';
        $GLOBALS['destination_import_test_mutate_post_on_second_read'] = null;
    }
    return $GLOBALS['destination_import_test_posts'][$post_id] ?? null;
}

function clean_post_cache(int $post_id): void
{
}

function get_post_meta(int $post_id, string $key, bool $single = true)
{
    return $GLOBALS['destination_import_test_meta'][$post_id][$key] ?? '';
}

function update_post_meta(int $post_id, string $key, $value): bool
{
    if ($key === $GLOBALS['destination_import_test_fail_meta_key']
        && (null === $GLOBALS['destination_import_test_fail_meta_value'] || $value === $GLOBALS['destination_import_test_fail_meta_value'])) {
        return false;
    }
    $GLOBALS['destination_import_test_meta'][$post_id][$key] = $value;
    $GLOBALS['destination_import_test_writes']++;
    return true;
}

function get_field(string $field_name, int $post_id = 0)
{
    return $GLOBALS['destination_import_test_fields'][$post_id][$field_name] ?? null;
}

function update_field(string $field_key, $value, int $post_id): bool
{
    if ($field_key === $GLOBALS['destination_import_test_fail_acf_field']) {
        return false;
    }
    $field_name = preg_replace('/^field_/', '', $field_key);
    $GLOBALS['destination_import_test_fields'][$post_id][$field_name] = $value;
    $GLOBALS['destination_import_test_writes']++;
    return true;
}

function wp_insert_post(array $post_data, bool $wp_error = false)
{
    $post_id = $GLOBALS['destination_import_test_posts']
        ? max(array_keys($GLOBALS['destination_import_test_posts'])) + 1
        : 1000;
    $post = [
        'ID' => $post_id,
        'post_type' => 'ts_destination',
        'post_status' => 'draft',
        'post_name' => '',
        'post_title' => '',
        'post_content' => '',
        'post_excerpt' => '',
    ];
    $meta_input = $post_data['meta_input'] ?? [];
    unset($post_data['meta_input']);
    $GLOBALS['destination_import_test_posts'][$post_id] = (object) array_merge($post, $post_data);
    foreach ($meta_input as $meta_key => $meta_value) {
        $GLOBALS['destination_import_test_meta'][$post_id][$meta_key] = $meta_value;
    }
    $GLOBALS['destination_import_test_writes']++;
    return $post_id;
}

function wp_update_post(array $post_data, bool $wp_error = false)
{
    $post_id = (int) ($post_data['ID'] ?? 0);
    if (!$post_id || !isset($GLOBALS['destination_import_test_posts'][$post_id])) {
        return 0;
    }
    if ($post_id === $GLOBALS['destination_import_test_mutate_during_first_update']) {
        $concurrent_content = 'Concurrent editor change after lock release.';
        if ($GLOBALS['wpdb']->transaction_active) {
            $GLOBALS['destination_import_test_deferred_editor_change'] = ['post_id' => $post_id, 'content' => $concurrent_content];
        } else {
            $GLOBALS['destination_import_test_posts'][$post_id]->post_content = $concurrent_content;
        }
        $GLOBALS['destination_import_test_mutate_during_first_update'] = null;
    }
    foreach ($post_data as $key => $value) {
        if ('ID' !== $key) {
            $GLOBALS['destination_import_test_posts'][$post_id]->{$key} = $value;
        }
    }
    if ('publish' === ($post_data['post_status'] ?? null) && $GLOBALS['destination_import_test_mutate_on_publish']) {
        $GLOBALS['destination_import_test_posts'][$post_id]->post_content .= ' Publish hook drift.';
        $GLOBALS['destination_import_test_mutate_on_publish'] = false;
    }
    $GLOBALS['destination_import_test_writes']++;
    return $post_id;
}

function wp_slash($value)
{
    return $value;
}

function wp_json_encode($value, int $flags = 0)
{
    return json_encode($value, $flags);
}

function wp_parse_url(string $url, int $component = -1)
{
    return parse_url($url, $component);
}

function home_url(): string
{
    return $GLOBALS['destination_import_test_home_url'];
}

function get_option(string $option, $default = null)
{
    return 'blog_public' === $option ? $GLOBALS['destination_import_test_blog_public'] : $default;
}

function current_user_can(string $capability): bool
{
    return 'manage_options' === $capability && $GLOBALS['destination_import_test_admin'];
}

function acf_get_field(string $field_key)
{
    if ($field_key === $GLOBALS['destination_import_test_missing_acf_field']) {
        return null;
    }
    return ['key' => $field_key, 'name' => substr($field_key, 6)];
}

function is_wp_error($value): bool
{
    return $value instanceof DestinationImportTestError;
}

function destination_import_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function destination_import_reset(): void
{
    $GLOBALS['destination_import_test_posts'] = [];
    $GLOBALS['destination_import_test_fields'] = [];
    $GLOBALS['destination_import_test_meta'] = [];
    $GLOBALS['destination_import_test_writes'] = 0;
    $GLOBALS['destination_import_test_home_url'] = 'https://test.tanzaniasensational.com/';
    $GLOBALS['destination_import_test_blog_public'] = '0';
    $GLOBALS['destination_import_test_admin'] = true;
    $GLOBALS['destination_import_test_missing_acf_field'] = null;
    $GLOBALS['destination_import_test_fail_acf_field'] = null;
    $GLOBALS['destination_import_test_fail_meta_key'] = null;
    $GLOBALS['destination_import_test_fail_meta_value'] = null;
    $GLOBALS['destination_import_test_post_read_counts'] = [];
    $GLOBALS['destination_import_test_mutate_post_on_second_read'] = null;
    $GLOBALS['destination_import_test_mutate_on_publish'] = false;
    $GLOBALS['destination_import_test_mutate_during_first_update'] = null;
    $GLOBALS['destination_import_test_deferred_editor_change'] = null;
    $GLOBALS['wpdb']->transaction_active = false;
    $GLOBALS['wpdb']->engine = 'InnoDB';
    $GLOBALS['wpdb']->locking_queries = [];
}

$root = dirname(__DIR__);
$manifest_path = $root . '/migration/destination-import-manifest.json';
$manifest = json_decode((string) file_get_contents($manifest_path), true, 512, JSON_THROW_ON_ERROR);
$media_map = json_decode((string) file_get_contents($root . '/migration/source-destination-media-map.json'), true, 512, JSON_THROW_ON_ERROR);
$presentation = json_decode((string) file_get_contents($root . '/migration/source-destination-presentation.json'), true, 512, JSON_THROW_ON_ERROR);
$importer_path = $root . '/migration/destination-importer.php';
if (!is_file($importer_path)) {
    throw new RuntimeException('Destination importer is not implemented yet.');
}
$unbootstrapped_probe = 'require ' . var_export($importer_path, true) . '; echo function_exists("ts_migration_import_destinations") ? "loaded" : "missing";';
exec(escapeshellarg(PHP_BINARY) . ' -r ' . escapeshellarg($unbootstrapped_probe), $unbootstrapped_output, $unbootstrapped_status);
destination_import_assert(0 === $unbootstrapped_status && '' === implode('', $unbootstrapped_output), 'Importer library must not load outside WordPress bootstrap.');
$bootstrapped_probe = 'define("ABSPATH", "/wordpress/"); require ' . var_export($importer_path, true) . '; echo function_exists("ts_migration_import_destinations") ? "loaded" : "missing";';
exec(escapeshellarg(PHP_BINARY) . ' -r ' . escapeshellarg($bootstrapped_probe), $bootstrapped_output, $bootstrapped_status);
destination_import_assert(0 === $bootstrapped_status && 'loaded' === implode('', $bootstrapped_output), 'Importer library must load in the WP-CLI --require WordPress context.');
$cli_entry_path = $root . '/migration/destination-import-cli.php';
$cli_bootstrap_probe = 'class WP_CLI { public static $commands = []; public static function add_command($name, $callable, $args = []) { self::$commands[$name] = $callable; } } require ' . var_export($cli_entry_path, true) . '; echo isset(WP_CLI::$commands["ts destinations import"]) ? "registered" : "missing";';
exec(escapeshellarg(PHP_BINARY) . ' -r ' . escapeshellarg($cli_bootstrap_probe), $cli_bootstrap_output, $cli_bootstrap_status);
destination_import_assert(0 === $cli_bootstrap_status && 'registered' === implode('', $cli_bootstrap_output), 'WP-CLI entrypoint must register without loading the importer library.');
require_once $importer_path;

destination_import_assert(6 === count($manifest['records'] ?? []), 'The manifest must contain exactly six approved destinations.');
destination_import_assert(array_keys($presentation) === array_column($manifest['records'], 'slug'), 'Manifest order and live presentation map must match.');
foreach ($manifest['records'] as $record) {
    $slug = $record['slug'];
    $source = $presentation[$slug];
    $media = $media_map[$slug];
    destination_import_assert($record['source_url'] === $source['source_url'] && $record['source_url'] === $media['source_url'], 'Source URL mismatch for ' . $slug);
    destination_import_assert($record['source_heading'] === $source['heading'], 'Source heading mismatch for ' . $slug);
    destination_import_assert($record['post_title'] . $record['fields']['ts_dest_subtitle'] === $source['heading'], 'Imported H1 composition mismatch for ' . $slug);
    destination_import_assert($record['post_excerpt'] === $source['hero_lead'] && $record['fields']['ts_dest_short_description'] === $source['hero_lead'], 'Hero lead mismatch for ' . $slug);
    destination_import_assert($record['fields']['ts_dest_tag'] === $source['eyebrow'], 'Source eyebrow mismatch for ' . $slug);
    destination_import_assert($record['fields']['ts_dest_hero_image_url'] === $media['hero']['url'] && $record['post_title'] === $media['hero']['alt'], 'Hero media mismatch for ' . $slug);
    destination_import_assert($record['fields']['ts_dest_gallery_urls'] === $media['gallery'], 'Ordered approved gallery or alt text mismatch for ' . $slug);
    $import_gallery_urls = array_column($record['fields']['ts_dest_gallery_urls'], 'url');
    foreach ($media['excluded_gallery'] ?? [] as $excluded_media) {
        destination_import_assert(404 === ($excluded_media['status'] ?? null), 'Excluded source gallery media must retain its verified HTTP status for ' . $slug);
        destination_import_assert(!in_array($excluded_media['url'] ?? '', $import_gallery_urls, true), 'Excluded source gallery media must not be included in the import for ' . $slug);
    }
}

$dry_run = ts_migration_import_destinations($manifest, true);
destination_import_assert(6 === count($dry_run), 'Dry-run should report all six destinations.');
destination_import_assert(0 === count($GLOBALS['destination_import_test_posts']), 'Dry-run must not create WordPress posts.');
destination_import_assert(0 === $GLOBALS['destination_import_test_writes'], 'Dry-run must not write post or field metadata.');
foreach ($dry_run as $item) {
    destination_import_assert('create' === $item['action'], 'Every first-run destination should be planned as create.');
}

$GLOBALS['wpdb']->engine = 'MyISAM';
$nontransactional_storage_blocked = false;
try {
    ts_migration_import_destinations($manifest, false);
} catch (RuntimeException $error) {
    $nontransactional_storage_blocked = str_contains($error->getMessage(), 'requires InnoDB');
}
destination_import_assert($nontransactional_storage_blocked, 'Apply must fail closed unless both WordPress content tables are transactional.');
destination_import_assert(0 === $GLOBALS['destination_import_test_writes'], 'The InnoDB precondition must run before any destination writes.');
$GLOBALS['wpdb']->engine = 'InnoDB';

$created = ts_migration_import_destinations($manifest, false);
destination_import_assert(6 === count($GLOBALS['destination_import_test_posts']), 'Apply should create exactly six destination posts.');
destination_import_assert(6 === count($created), 'Apply should report all six destinations.');
foreach ($manifest['records'] as $record) {
    $post = null;
    foreach ($GLOBALS['destination_import_test_posts'] as $candidate) {
        if ($candidate->post_name === $record['slug']) {
            $post = $candidate;
            break;
        }
    }
    destination_import_assert(null !== $post, 'Missing imported destination: ' . $record['slug']);
    destination_import_assert('publish' === $post->post_status, 'Imported destination must be published on staging.');
    destination_import_assert((string) $record['post_content'] === $post->post_content, 'Imported overview differs for ' . $record['slug']);
    destination_import_assert((int) $record['source_record_id'] === (int) get_post_meta($post->ID, '_ts_source_destination_id', true), 'Importer ownership marker missing for ' . $record['slug']);
    foreach ($record['fields'] as $field_name => $expected) {
        destination_import_assert($expected === get_field($field_name, $post->ID), 'ACF field mismatch for ' . $record['slug'] . ':' . $field_name);
    }
}

$writes_after_create = $GLOBALS['destination_import_test_writes'];
$unchanged = ts_migration_import_destinations($manifest, true);
destination_import_assert(6 === count($unchanged), 'Second dry-run should report all six destinations.');
destination_import_assert(0 === count(array_filter($unchanged, static function (array $item): bool { return 'unchanged' !== $item['action']; })), 'An identical re-import should be a no-op.');
destination_import_assert($writes_after_create === $GLOBALS['destination_import_test_writes'], 'An unchanged re-import must not write.');

$changed = $manifest;
$changed['records'][0]['post_content'] .= ' Updated source copy.';
$update_plan = ts_migration_import_destinations($changed, true);
destination_import_assert('update' === $update_plan[0]['action'], 'A source update should be planned when the importer-owned record has not drifted.');
$updated = ts_migration_import_destinations($changed, false);
destination_import_assert('Updated source copy.' === substr($GLOBALS['destination_import_test_posts'][1000]->post_content, -20), 'Safe source changes should update an importer-owned post.');

$race_manifest = $changed;
$race_manifest['records'][0]['post_content'] .= ' Planned before an editor change.';
$GLOBALS['destination_import_test_post_read_counts'][1000] = 0;
$GLOBALS['destination_import_test_mutate_post_on_second_read'] = 1000;
$writes_before_concurrent_edit = $GLOBALS['destination_import_test_writes'];
$concurrent_edit_rejected = false;
try {
    ts_migration_import_destinations($race_manifest, false);
} catch (RuntimeException $error) {
    $concurrent_edit_rejected = str_contains($error->getMessage(), 'changed after preflight');
}
destination_import_assert($concurrent_edit_rejected, 'Importer must recheck owned content immediately before writing and reject a concurrent editor change.');
destination_import_assert($writes_before_concurrent_edit === $GLOBALS['destination_import_test_writes'], 'Concurrent editor changes must be rejected before importer writes.');
destination_import_assert(str_ends_with($GLOBALS['destination_import_test_posts'][1000]->post_content, 'Concurrent editor change.'), 'Importer must preserve the concurrent editor change.');

$writes_before_drift = $GLOBALS['destination_import_test_writes'];
$GLOBALS['destination_import_test_posts'][1000]->post_content .= ' Editor change.';
$drift_rejected = false;
try {
    ts_migration_import_destinations($changed, false);
} catch (RuntimeException $error) {
    $drift_rejected = str_contains($error->getMessage(), 'editor-modified');
}
destination_import_assert($drift_rejected, 'Importer must refuse to overwrite editor-modified destination content.');
destination_import_assert($writes_before_drift === $GLOBALS['destination_import_test_writes'], 'Preflight must reject editor drift before writing any destination.');

destination_import_reset();
ts_migration_import_destinations($manifest, false);
$edit_race_manifest = $manifest;
$edit_race_manifest['records'][0]['post_content'] .= ' Concurrent importer copy.';
$GLOBALS['destination_import_test_mutate_during_first_update'] = 1000;
ts_migration_import_destinations($edit_race_manifest, false);
destination_import_assert(!$GLOBALS['wpdb']->transaction_active, 'Each destination write must release its database row lock at completion.');
$lock_sql = implode("\n", $GLOBALS['wpdb']->locking_queries);
destination_import_assert(str_contains($lock_sql, $GLOBALS['wpdb']->posts) && str_contains($lock_sql, $GLOBALS['wpdb']->postmeta), 'The apply transaction must lock both the WordPress post and its metadata rows.');
destination_import_assert('Concurrent editor change after lock release.' === $GLOBALS['destination_import_test_posts'][1000]->post_content, 'An editor update blocked by the importer lock must apply after commit rather than be overwritten.');
$deferred_editor_drift_rejected = false;
try {
    ts_migration_import_destinations($edit_race_manifest, true);
} catch (RuntimeException $error) {
    $deferred_editor_drift_rejected = str_contains($error->getMessage(), 'editor-modified');
}
destination_import_assert($deferred_editor_drift_rejected, 'A post-commit editor update must be recognized as drift on the next import.');

destination_import_reset();
$GLOBALS['destination_import_test_posts'][77] = (object) [
    'ID' => 77,
    'post_type' => 'ts_destination',
    'post_status' => 'publish',
    'post_name' => 'kilimanjaro',
    'post_title' => 'Editor-owned Kilimanjaro',
    'post_content' => 'Existing editorial copy.',
    'post_excerpt' => '',
];
$collision_rejected = false;
try {
    ts_migration_import_destinations($manifest, false);
} catch (RuntimeException $error) {
    $collision_rejected = str_contains($error->getMessage(), 'unowned');
}
destination_import_assert($collision_rejected, 'Importer must refuse to overwrite an unowned destination with a matching slug.');
destination_import_assert(1 === count($GLOBALS['destination_import_test_posts']), 'Slug-collision preflight must not create any posts.');
destination_import_assert(0 === $GLOBALS['destination_import_test_writes'], 'Slug-collision preflight must not write metadata.');

destination_import_reset();
$unsafe = $manifest;
$unsafe['records'][0]['source_url'] = 'https://tanzaniasensational.com.evil.example/safaris/destinations/kilimanjaro';
$unsafe_rejected = false;
try {
    ts_migration_import_destinations($unsafe, true);
} catch (RuntimeException $error) {
    $unsafe_rejected = true;
}
destination_import_assert($unsafe_rejected, 'Importer must reject untrusted source hosts before querying or writing posts.');
destination_import_assert(0 === $GLOBALS['destination_import_test_writes'], 'Invalid manifests must never write.');

destination_import_reset();
$GLOBALS['destination_import_test_home_url'] = 'https://tanzaniasensational.com/';
$production_blocked = false;
try {
    ts_migration_import_destinations($manifest, true);
} catch (RuntimeException $error) {
    $production_blocked = str_contains($error->getMessage(), 'locked to test.tanzaniasensational.com');
}
destination_import_assert($production_blocked, 'Importer must refuse to run outside the staging host.');
destination_import_assert(0 === $GLOBALS['destination_import_test_writes'], 'Production-host guard must not write.');

destination_import_reset();
$GLOBALS['destination_import_test_blog_public'] = '1';
$indexing_blocked = false;
try {
    ts_migration_import_destinations($manifest, true);
} catch (RuntimeException $error) {
    $indexing_blocked = str_contains($error->getMessage(), 'search visibility');
}
destination_import_assert($indexing_blocked, 'Importer must refuse to run if staging indexing is enabled.');
destination_import_assert(0 === $GLOBALS['destination_import_test_writes'], 'Noindex guard must not write.');

destination_import_reset();
$GLOBALS['destination_import_test_admin'] = false;
$unauthorized_blocked = false;
try {
    ts_migration_import_destinations($manifest, false);
} catch (RuntimeException $error) {
    $unauthorized_blocked = str_contains($error->getMessage(), 'staging administrator');
}
destination_import_assert($unauthorized_blocked, 'Applying destination imports must require a staging administrator.');
destination_import_assert(0 === $GLOBALS['destination_import_test_writes'], 'Authorization guard must run before the first write.');

destination_import_reset();
$GLOBALS['destination_import_test_missing_acf_field'] = 'field_ts_dest_hero_image_url';
$acf_schema_blocked = false;
try {
    ts_migration_import_destinations($manifest, true);
} catch (RuntimeException $error) {
    $acf_schema_blocked = str_contains($error->getMessage(), 'not registered in ACF');
}
destination_import_assert($acf_schema_blocked, 'Importer must verify every required ACF field is registered before planning writes.');
destination_import_assert(0 === $GLOBALS['destination_import_test_writes'], 'Missing ACF fields must be rejected before writes.');

destination_import_reset();
$GLOBALS['destination_import_test_fail_meta_key'] = '_ts_destination_import_hash';
$ownership_metadata_failure = false;
try {
    ts_migration_import_destinations($manifest, false);
} catch (RuntimeException $error) {
    $ownership_metadata_failure = str_contains($error->getMessage(), 'importer metadata');
}
$metadata_failure_post = reset($GLOBALS['destination_import_test_posts']);
destination_import_assert($ownership_metadata_failure, 'Importer must fail if it cannot persist the verified ownership hash.');
destination_import_assert($metadata_failure_post && 'draft' === $metadata_failure_post->post_status, 'A destination must remain unpublished until its ownership snapshot and hash are persisted.');
destination_import_assert('pending' === get_post_meta((int) $metadata_failure_post->ID, '_ts_destination_import_state', true), 'Metadata failure must leave a recoverable non-ready import marker.');

destination_import_reset();
$GLOBALS['destination_import_test_fail_meta_key'] = '_ts_destination_import_state';
$GLOBALS['destination_import_test_fail_meta_value'] = 'ready';
$ready_marker_failure = false;
try {
    ts_migration_import_destinations($manifest, false);
} catch (RuntimeException $error) {
    $ready_marker_failure = str_contains($error->getMessage(), 'importer metadata');
}
$publishing_post = reset($GLOBALS['destination_import_test_posts']);
destination_import_assert($ready_marker_failure, 'Importer must report a failed final ownership-state write.');
destination_import_assert($publishing_post && 'publish' === $publishing_post->post_status, 'Publishing is allowed only after ownership snapshot and hash are already persisted.');
destination_import_assert('publishing' === get_post_meta((int) $publishing_post->ID, '_ts_destination_import_state', true), 'A post-publish metadata failure must retain its recoverable publishing marker.');
$GLOBALS['destination_import_test_fail_meta_key'] = null;
$GLOBALS['destination_import_test_fail_meta_value'] = null;
$publishing_recovery_plan = ts_migration_import_destinations($manifest, true);
destination_import_assert('finalize' === $publishing_recovery_plan[0]['action'], 'A verified published record with a publishing marker should plan metadata finalization only.');
ts_migration_import_destinations($manifest, false);
destination_import_assert('ready' === get_post_meta((int) $publishing_post->ID, '_ts_destination_import_state', true), 'A publishing record must be safely resumable to the ready state.');
destination_import_assert(6 === count($GLOBALS['destination_import_test_posts']), 'Publishing recovery must continue the remaining approved records.');

destination_import_reset();
$GLOBALS['destination_import_test_mutate_on_publish'] = true;
$post_publish_drift_rejected = false;
try {
    ts_migration_import_destinations($manifest, false);
} catch (RuntimeException $error) {
    $post_publish_drift_rejected = str_contains($error->getMessage(), 'post-write verification');
}
$drifted_publishing_post = reset($GLOBALS['destination_import_test_posts']);
destination_import_assert($post_publish_drift_rejected, 'Importer must detect content changes introduced during publication.');
destination_import_assert($drifted_publishing_post && 'draft' === $drifted_publishing_post->post_status, 'A record that fails post-publish verification must be returned to draft.');
destination_import_assert('publishing' === get_post_meta((int) $drifted_publishing_post->ID, '_ts_destination_import_state', true), 'Failed post-publish verification must retain its recoverable ownership marker.');

destination_import_reset();
$GLOBALS['destination_import_test_fail_acf_field'] = 'field_ts_dest_gallery_urls';
$partial_acf_rejected = false;
try {
    ts_migration_import_destinations($manifest, false);
} catch (RuntimeException $error) {
    $partial_acf_rejected = str_contains($error->getMessage(), 'verification');
}
$partial_post = reset($GLOBALS['destination_import_test_posts']);
destination_import_assert($partial_acf_rejected, 'Incomplete ACF writes must fail verification.');
destination_import_assert($partial_post && 'draft' === $partial_post->post_status, 'A partially written destination must remain unpublished.');
destination_import_assert('pending' === get_post_meta((int) $partial_post->ID, '_ts_destination_import_state', true), 'A failed create must retain its resumable pending marker.');

destination_import_reset();
$cli_path = $root . '/migration/destination-import-cli.php';
destination_import_assert(is_file($cli_path), 'WP-CLI entrypoint is required to run the importer on staging.');
require_once $cli_path;
$cli_command = WP_CLI::$commands['ts destinations import'] ?? null;
destination_import_assert(is_callable($cli_command), 'WP-CLI import command must be registered.');

destination_import_reset();
WP_CLI::$messages = [];
$cli_command([], []);
destination_import_assert(0 === $GLOBALS['destination_import_test_writes'], 'Default WP-CLI invocation must remain dry-run.');
destination_import_assert(str_contains(strtolower(implode("\\n", WP_CLI::$messages)), 'dry run'), 'Default WP-CLI output must clearly identify dry-run mode.');

$missing_confirmation_blocked = false;
try {
    $cli_command([], ['apply' => true]);
} catch (RuntimeException $error) {
    $missing_confirmation_blocked = str_contains($error->getMessage(), 'confirm-staging-write');
}
destination_import_assert($missing_confirmation_blocked, 'WP-CLI apply requires the separate staging-write confirmation flag.');
destination_import_assert(0 === $GLOBALS['destination_import_test_writes'], 'Missing confirmation must not write.');

$orphan_confirmation_blocked = false;
try {
    $cli_command([], ['confirm-staging-write' => true]);
} catch (RuntimeException $error) {
    $orphan_confirmation_blocked = str_contains($error->getMessage(), 'requires --apply');
}
destination_import_assert($orphan_confirmation_blocked, 'Staging confirmation must not apply without the --apply flag.');
destination_import_assert(0 === $GLOBALS['destination_import_test_writes'], 'Orphan confirmation must not write.');

$cli_command([], ['apply' => true, 'confirm-staging-write' => true]);
destination_import_assert(6 === count($GLOBALS['destination_import_test_posts']), 'Explicit WP-CLI apply should import all six destinations.');
destination_import_assert(str_contains(implode("\\n", WP_CLI::$messages), 'applied'), 'Successful apply output must be explicit.');

echo "PASS: destination importer parity, dry-run/apply, idempotence, safe updates, row-lock concurrency protection, collision guards, recoverable publishing, ACF/staging guards and WP-CLI safety.\n";
