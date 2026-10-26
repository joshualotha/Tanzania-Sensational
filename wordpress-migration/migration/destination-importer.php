<?php
/**
 * Staging-only destination importer with preflight, ownership snapshots and dry-run support.
 * ACF uses field keys when writing values to newly created posts.
 * This library is loaded by a WP-CLI --require file and invoked after WordPress bootstrap.
 */

if (!defined('ABSPATH')) {
    exit;
}

function ts_migration_destination_field_names(): array
{
    return [
        'ts_dest_tag',
        'ts_dest_subtitle',
        'ts_dest_short_description',
        'ts_dest_overview_quote',
        'ts_dest_coordinates',
        'ts_dest_elevation',
        'ts_dest_best_time',
        'ts_dest_encounter_rate',
        'ts_dest_expedition_tier',
        'ts_dest_tracking_method',
        'ts_dest_atmosphere_vitals',
        'ts_dest_wildlife_vitals',
        'ts_dest_atmosphere_footer',
        'ts_dest_wildlife_footer',
        'ts_dest_hero_image_url',
        'ts_dest_gallery_urls',
        'ts_dest_meta_title',
        'ts_dest_meta_description',
        'ts_dest_featured',
        'ts_dest_display_order',
    ];
}

function ts_migration_destination_allowed_slugs(): array
{
    return ['kilimanjaro', 'lake-manyara', 'mahale', 'nyerere', 'ruaha', 'zanzibar'];
}

function ts_migration_destination_normalize_value($value, string $field_name = '')
{
    if ('ts_dest_featured' === $field_name) {
        return (bool) $value;
    }
    if ('ts_dest_display_order' === $field_name) {
        return (int) $value;
    }
    if (is_array($value)) {
        $normalized = [];
        foreach ($value as $key => $item) {
            $normalized[$key] = ts_migration_destination_normalize_value($item);
        }
        if (array_keys($normalized) !== range(0, count($normalized) - 1)) {
            ksort($normalized);
        }
        return $normalized;
    }
    if (is_bool($value) || null === $value) {
        return $value;
    }
    return is_scalar($value) ? (string) $value : null;
}

function ts_migration_destination_normalize_state(array $state): array
{
    $fields = $state['fields'] ?? [];
    $normalized_fields = [];
    foreach (ts_migration_destination_field_names() as $field_name) {
        $normalized_fields[$field_name] = ts_migration_destination_normalize_value($fields[$field_name] ?? null, $field_name);
    }
    ksort($normalized_fields);

    return [
        'post_type' => (string) ($state['post_type'] ?? ''),
        'post_status' => (string) ($state['post_status'] ?? ''),
        'post_name' => (string) ($state['post_name'] ?? ''),
        'post_title' => (string) ($state['post_title'] ?? ''),
        'post_excerpt' => (string) ($state['post_excerpt'] ?? ''),
        'post_content' => (string) ($state['post_content'] ?? ''),
        'fields' => $normalized_fields,
    ];
}

function ts_migration_destination_state_hash(array $state): string
{
    $json = wp_json_encode(
        ts_migration_destination_normalize_state($state),
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS
    );
    if (!is_string($json)) {
        throw new RuntimeException('Could not encode destination import state.');
    }
    return hash('sha256', $json);
}

function ts_migration_destination_expected_state(array $record, string $status = 'publish'): array
{
    return ts_migration_destination_normalize_state([
        'post_type' => 'ts_destination',
        'post_status' => $status,
        'post_name' => $record['slug'],
        'post_title' => $record['post_title'],
        'post_excerpt' => $record['post_excerpt'],
        'post_content' => $record['post_content'],
        'fields' => $record['fields'],
    ]);
}

function ts_migration_destination_current_state(int $post_id): array
{
    $post = get_post($post_id);
    if (!$post || 'ts_destination' !== (string) ($post->post_type ?? '')) {
        throw new RuntimeException('Destination post could not be read for import verification.');
    }

    $fields = [];
    foreach (ts_migration_destination_field_names() as $field_name) {
        $fields[$field_name] = get_field($field_name, $post_id);
    }

    return ts_migration_destination_normalize_state([
        'post_type' => $post->post_type ?? '',
        'post_status' => $post->post_status ?? '',
        'post_name' => $post->post_name ?? '',
        'post_title' => $post->post_title ?? '',
        'post_excerpt' => $post->post_excerpt ?? '',
        'post_content' => $post->post_content ?? '',
        'fields' => $fields,
    ]);
}

function ts_migration_destination_is_empty_value($value, string $field_name = ''): bool
{
    if ('ts_dest_display_order' === $field_name && 0 === (int) $value) {
        return true;
    }
    return null === $value || false === $value || '' === $value || [] === $value;
}

function ts_migration_destination_component_matches($current, array $accepted_values): bool
{
    foreach ($accepted_values as $accepted) {
        if ($current === $accepted) {
            return true;
        }
    }
    return false;
}

function ts_migration_destination_partial_state_is_safe(array $current, array $desired, ?array $previous, bool $new_pending): bool
{
    $core = ['post_type', 'post_name', 'post_title', 'post_excerpt', 'post_content'];
    if ('ts_destination' !== $current['post_type'] || $current['post_name'] !== $desired['post_name']) {
        return false;
    }

    if ($new_pending) {
        if (!in_array($current['post_status'], ['draft', 'publish'], true)) {
            return false;
        }
        foreach (array_slice($core, 2) as $key) {
            if ($current[$key] !== $desired[$key]) {
                return false;
            }
        }
        foreach (ts_migration_destination_field_names() as $field_name) {
            $value = $current['fields'][$field_name];
            if ($value !== $desired['fields'][$field_name] && !ts_migration_destination_is_empty_value($value, $field_name)) {
                return false;
            }
        }
        return true;
    }

    if (!is_array($previous)) {
        return false;
    }
    foreach (array_merge($core, ['post_status']) as $key) {
        $accepted_values = [$previous[$key] ?? null, $desired[$key] ?? null];
        if ('post_status' === $key) {
            $accepted_values[] = 'draft';
        }
        if (!ts_migration_destination_component_matches($current[$key], $accepted_values)) {
            return false;
        }
    }
    foreach (ts_migration_destination_field_names() as $field_name) {
        if (!ts_migration_destination_component_matches(
            $current['fields'][$field_name],
            [$previous['fields'][$field_name] ?? null, $desired['fields'][$field_name]]
        )) {
            return false;
        }
    }
    return true;
}

function ts_migration_destination_allowed_https_url(string $url, array $allowed_hosts): bool
{
    $parts = wp_parse_url($url);
    if (!is_array($parts) || 'https' !== strtolower((string) ($parts['scheme'] ?? '')) || empty($parts['host'])) {
        return false;
    }
    return in_array(strtolower((string) $parts['host']), $allowed_hosts, true);
}

function ts_migration_validate_destination_manifest(array $manifest): void
{
    if (1 !== (int) ($manifest['manifest_version'] ?? 0) || !isset($manifest['records']) || !is_array($manifest['records'])) {
        throw new RuntimeException('Unsupported or malformed destination import manifest.');
    }

    $allowed_slugs = ts_migration_destination_allowed_slugs();
    $seen_slugs = [];
    $seen_source_ids = [];
    $seen_orders = [];
    $required_fields = ts_migration_destination_field_names();
    $image_hosts = ['tanzaniasensational.com', 'images.unsplash.com'];

    foreach ($manifest['records'] as $record) {
        if (!is_array($record)) {
            throw new RuntimeException('Destination manifest contains a malformed record.');
        }
        $slug = (string) ($record['slug'] ?? '');
        $source_id = (int) ($record['source_record_id'] ?? 0);
        if (!in_array($slug, $allowed_slugs, true) || isset($seen_slugs[$slug])) {
            throw new RuntimeException('Destination manifest contains an unapproved or duplicate slug: ' . $slug);
        }
        if ($source_id < 1 || isset($seen_source_ids[$source_id])) {
            throw new RuntimeException('Destination manifest contains an invalid or duplicate source record ID.');
        }
        $seen_slugs[$slug] = true;
        $seen_source_ids[$source_id] = true;

        $source_url = (string) ($record['source_url'] ?? '');
        $source_parts = wp_parse_url($source_url);
        if (!is_array($source_parts)
            || 'https' !== strtolower((string) ($source_parts['scheme'] ?? ''))
            || 'tanzaniasensational.com' !== strtolower((string) ($source_parts['host'] ?? ''))
            || '/safaris/destinations/' . $slug !== (string) ($source_parts['path'] ?? '')) {
            throw new RuntimeException('Destination source URL does not match its approved live route: ' . $slug);
        }

        foreach (['post_title', 'post_excerpt', 'post_content'] as $post_key) {
            if (!isset($record[$post_key]) || !is_string($record[$post_key]) || '' === trim($record[$post_key])) {
                throw new RuntimeException('Destination record is missing required post content: ' . $slug . ':' . $post_key);
            }
        }
        if (!isset($record['fields']) || !is_array($record['fields'])) {
            throw new RuntimeException('Destination record has no ACF field map: ' . $slug);
        }
        $missing_fields = array_diff($required_fields, array_keys($record['fields']));
        $unknown_fields = array_diff(array_keys($record['fields']), $required_fields);
        if ($missing_fields || $unknown_fields) {
            throw new RuntimeException('Destination ACF fields do not match the approved schema: ' . $slug);
        }

        $fields = $record['fields'];
        foreach (['ts_dest_tag', 'ts_dest_subtitle', 'ts_dest_short_description', 'ts_dest_overview_quote', 'ts_dest_coordinates', 'ts_dest_elevation', 'ts_dest_best_time', 'ts_dest_encounter_rate', 'ts_dest_expedition_tier', 'ts_dest_tracking_method', 'ts_dest_atmosphere_footer', 'ts_dest_wildlife_footer', 'ts_dest_meta_title', 'ts_dest_meta_description'] as $field_name) {
            if (!is_string($fields[$field_name]) || '' === trim($fields[$field_name])) {
                throw new RuntimeException('Destination record has an empty required source-backed field: ' . $slug . ':' . $field_name);
            }
        }
        if (!isset($record['source_heading'])
            || !is_string($record['source_heading'])
            || $record['source_heading'] !== $record['post_title'] . $fields['ts_dest_subtitle']) {
            throw new RuntimeException('Destination heading does not match the live source heading: ' . $slug);
        }
        if (true !== $fields['ts_dest_featured'] && false !== $fields['ts_dest_featured'] && 0 !== $fields['ts_dest_featured']) {
            throw new RuntimeException('Destination import must not mark new records featured: ' . $slug);
        }
        $display_order = filter_var($fields['ts_dest_display_order'], FILTER_VALIDATE_INT);
        if (false === $display_order || $display_order < 9000 || isset($seen_orders[$display_order])) {
            throw new RuntimeException('Destination display order must be unique and reserved after existing records: ' . $slug);
        }
        $seen_orders[$display_order] = true;

        if (!ts_migration_destination_allowed_https_url((string) $fields['ts_dest_hero_image_url'], $image_hosts)) {
            throw new RuntimeException('Destination hero URL is not from an approved source host: ' . $slug);
        }
        $gallery = $fields['ts_dest_gallery_urls'];
        if (!is_array($gallery) || count($gallery) < 1) {
            throw new RuntimeException('Destination gallery must contain live source images: ' . $slug);
        }
        foreach ($gallery as $image) {
            if (!is_array($image) || !isset($image['url'], $image['alt']) || !is_string($image['alt']) || '' === trim($image['alt'])) {
                throw new RuntimeException('Destination gallery image is missing its live URL or alt text: ' . $slug);
            }
            if (!ts_migration_destination_allowed_https_url((string) $image['url'], $image_hosts)) {
                throw new RuntimeException('Destination gallery URL is not from an approved source host: ' . $slug);
            }
        }
        foreach (['ts_dest_atmosphere_vitals', 'ts_dest_wildlife_vitals'] as $repeater_name) {
            if (!is_array($fields[$repeater_name]) || empty($fields[$repeater_name])) {
                throw new RuntimeException('Destination ledger repeater is empty: ' . $slug . ':' . $repeater_name);
            }
            foreach ($fields[$repeater_name] as $row) {
                if (!is_array($row) || !isset($row['label'], $row['text']) || '' === trim((string) $row['label']) || '' === trim((string) $row['text'])) {
                    throw new RuntimeException('Destination ledger row is incomplete: ' . $slug . ':' . $repeater_name);
                }
            }
        }
    }

    if (array_keys($seen_slugs) !== $allowed_slugs) {
        $expected = $allowed_slugs;
        sort($expected);
        $actual = array_keys($seen_slugs);
        sort($actual);
        if ($expected !== $actual) {
            throw new RuntimeException('Destination manifest must contain exactly the six approved slugs.');
        }
    }
}

function ts_migration_destination_read_snapshot(int $post_id): ?array
{
    $raw = get_post_meta($post_id, '_ts_destination_import_snapshot', true);
    if (is_array($raw)) {
        return ts_migration_destination_normalize_state($raw);
    }
    if (!is_string($raw) || '' === $raw) {
        return null;
    }
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? ts_migration_destination_normalize_state($decoded) : null;
}

function ts_migration_destination_save_meta(int $post_id, string $key, $value): void
{
    $stored = is_string($value) ? wp_slash($value) : $value;
    update_post_meta($post_id, $key, $stored);
    $read_back = get_post_meta($post_id, $key, true);
    if ($read_back !== $value && (string) $read_back !== (string) $value) {
        throw new RuntimeException('Could not verify destination importer metadata: ' . $key);
    }
}

function ts_migration_destination_build_plan(array $manifest): array
{
    $posts = get_posts([
        'post_type' => 'ts_destination',
        'post_status' => 'any',
        'numberposts' => -1,
        'suppress_filters' => true,
    ]);
    $by_slug = [];
    $by_source_id = [];
    foreach ($posts as $post) {
        $post_id = (int) ($post->ID ?? 0);
        if (!$post_id) {
            continue;
        }
        $slug = (string) ($post->post_name ?? '');
        if ('' !== $slug) {
            $by_slug[$slug][] = $post;
        }
        $source_id = (int) get_post_meta($post_id, '_ts_source_destination_id', true);
        if ($source_id > 0) {
            $by_source_id[$source_id][] = $post;
        }
    }

    $plan = [];
    foreach ($manifest['records'] as $record) {
        $slug = $record['slug'];
        $source_id = (int) $record['source_record_id'];
        $slug_matches = $by_slug[$slug] ?? [];
        $source_matches = $by_source_id[$source_id] ?? [];
        if (count($slug_matches) > 1 || count($source_matches) > 1) {
            throw new RuntimeException('Multiple staging destinations match the approved record: ' . $slug);
        }
        if ($source_matches && (string) $source_matches[0]->post_name !== $slug) {
            throw new RuntimeException('Importer-owned destination slug changed; refusing to create a duplicate: ' . $slug);
        }
        if ($slug_matches && (!$source_matches || (int) $slug_matches[0]->ID !== (int) $source_matches[0]->ID)) {
            $marker = (int) get_post_meta((int) $slug_matches[0]->ID, '_ts_source_destination_id', true);
            if ($marker !== $source_id) {
                throw new RuntimeException('Destination slug collision is unowned; refusing to overwrite editor-authored content: ' . $slug);
            }
            throw new RuntimeException('Destination slug and source-record ownership markers conflict: ' . $slug);
        }

        if (!$slug_matches && !$source_matches) {
            $plan[] = ['action' => 'create', 'record' => $record, 'post_id' => 0, 'new_pending' => true];
            continue;
        }

        $post = $slug_matches[0];
        $post_id = (int) $post->ID;
        $marker = (int) get_post_meta($post_id, '_ts_source_destination_id', true);
        $source_slug = (string) get_post_meta($post_id, '_ts_source_destination_slug', true);
        if ($marker !== $source_id || $source_slug !== $slug) {
            throw new RuntimeException('Destination is not owned by this import; refusing to overwrite editor-authored content: ' . $slug);
        }

        $expected = ts_migration_destination_expected_state($record);
        $current = ts_migration_destination_current_state($post_id);
        $state_marker = (string) get_post_meta($post_id, '_ts_destination_import_state', true);
        $snapshot = ts_migration_destination_read_snapshot($post_id);
        $stored_hash = (string) get_post_meta($post_id, '_ts_destination_import_hash', true);

        if ('ready' === $state_marker) {
            if (!$snapshot || '' === $stored_hash || ts_migration_destination_state_hash($snapshot) !== $stored_hash) {
                throw new RuntimeException('Destination import ownership snapshot is missing or invalid: ' . $slug);
            }
            if (ts_migration_destination_state_hash($current) !== $stored_hash) {
                throw new RuntimeException('Destination is editor-modified; refusing to overwrite it: ' . $slug);
            }
            $action = ts_migration_destination_state_hash($current) === ts_migration_destination_state_hash($expected) ? 'unchanged' : 'update';
            $plan[] = [
                'action' => $action,
                'record' => $record,
                'post_id' => $post_id,
                'new_pending' => false,
                'previous_snapshot' => $snapshot,
                'preflight_state_marker' => $state_marker,
                'preflight_state_hash' => ts_migration_destination_state_hash($current),
            ];
            continue;
        }

        if ('publishing' === $state_marker) {
            if (!$snapshot || '' === $stored_hash
                || ts_migration_destination_state_hash($snapshot) !== $stored_hash
                || ts_migration_destination_state_hash($expected) !== $stored_hash) {
                throw new RuntimeException('Destination publishing snapshot does not match the approved source record: ' . $slug);
            }
            $draft_expected = ts_migration_destination_expected_state($record, 'draft');
            $current_hash = ts_migration_destination_state_hash($current);
            if ($current_hash === $stored_hash) {
                $action = 'finalize';
            } elseif ($current_hash === ts_migration_destination_state_hash($draft_expected)) {
                $action = 'publish';
            } else {
                throw new RuntimeException('Destination in publishing state was modified; refusing to publish or overwrite it: ' . $slug);
            }
            $plan[] = [
                'action' => $action,
                'record' => $record,
                'post_id' => $post_id,
                'new_pending' => false,
                'previous_snapshot' => $snapshot,
                'preflight_state_marker' => $state_marker,
                'preflight_state_hash' => $current_hash,
            ];
            continue;
        }

        if (!in_array($state_marker, ['pending', 'updating'], true)) {
            throw new RuntimeException('Destination import state is unrecognized; refusing to overwrite it: ' . $slug);
        }
        $new_pending = 'pending' === $state_marker && null === $snapshot;
        if (!ts_migration_destination_partial_state_is_safe($current, $expected, $snapshot, $new_pending)) {
            throw new RuntimeException('Pending destination import contains changes that are not safe to resume: ' . $slug);
        }
        $plan[] = [
            'action' => 'resume',
            'record' => $record,
            'post_id' => $post_id,
            'new_pending' => $new_pending,
            'previous_snapshot' => $snapshot,
            'preflight_state_marker' => $state_marker,
            'preflight_state_hash' => ts_migration_destination_state_hash($current),
        ];
    }

    return $plan;
}

function ts_migration_destination_assert_transactional_storage(): void
{
    /** @var \wpdb $wpdb */
    global $wpdb;
    if (!is_object($wpdb) || !isset($wpdb->posts, $wpdb->postmeta)
        || !method_exists($wpdb, 'prepare') || !method_exists($wpdb, 'get_var') || !method_exists($wpdb, 'query')) {
        throw new RuntimeException('Destination import requires a transactional WordPress database connection.');
    }

    foreach ([$wpdb->posts, $wpdb->postmeta] as $table_name) {
        $engine = $wpdb->get_var($wpdb->prepare(
            'SELECT ENGINE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = %s',
            $table_name
        ));
        if ('INNODB' !== strtoupper((string) $engine)) {
            throw new RuntimeException('Destination import requires InnoDB for the WordPress posts and postmeta tables.');
        }
    }
}

function ts_migration_destination_lock_post_row(int $post_id): void
{
    /** @var \wpdb $wpdb */
    global $wpdb;
    $post_table = $wpdb->posts;
    $locked_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM {$post_table} WHERE ID = %d FOR UPDATE",
        $post_id
    ));
    if ((int) $locked_id !== $post_id) {
        throw new RuntimeException('Could not lock destination row before apply: ' . $post_id);
    }
    $postmeta_table = $wpdb->postmeta;
    if ($wpdb->query($wpdb->prepare(
        "SELECT meta_id FROM {$postmeta_table} WHERE post_id = %d FOR UPDATE",
        $post_id
    )) === false) {
        throw new RuntimeException('Could not lock destination metadata before apply: ' . $post_id);
    }
    clean_post_cache($post_id);
}

function ts_migration_destination_assert_preflight_unchanged(array $item): void
{
    $post_id = (int) ($item['post_id'] ?? 0);
    $record = $item['record'];
    if ($post_id < 1) {
        throw new RuntimeException('Destination import preflight is missing a post ID: ' . $record['slug']);
    }

    $source_id = (int) get_post_meta($post_id, '_ts_source_destination_id', true);
    $source_slug = (string) get_post_meta($post_id, '_ts_source_destination_slug', true);
    $state_marker = (string) get_post_meta($post_id, '_ts_destination_import_state', true);
    if ($source_id !== (int) $record['source_record_id']
        || $source_slug !== $record['slug']
        || $state_marker !== (string) ($item['preflight_state_marker'] ?? '')) {
        throw new RuntimeException('Destination ownership changed after preflight; refusing to overwrite it: ' . $record['slug']);
    }

    $current = ts_migration_destination_current_state($post_id);
    if (ts_migration_destination_state_hash($current) !== (string) ($item['preflight_state_hash'] ?? '')) {
        throw new RuntimeException('Destination changed after preflight; refusing to overwrite editor changes: ' . $record['slug']);
    }
}

function ts_migration_destination_return_to_draft(int $post_id, string $slug): void
{
    $draft_id = wp_update_post(wp_slash(['ID' => $post_id, 'post_status' => 'draft']), true);
    if (is_wp_error($draft_id) || (int) $draft_id !== $post_id) {
        throw new RuntimeException('Destination failed post-write verification and could not be returned to draft: ' . $slug);
    }
    $current = ts_migration_destination_current_state($post_id);
    if ('draft' !== $current['post_status']) {
        throw new RuntimeException('Destination failed post-write verification and is still published: ' . $slug);
    }
}

function ts_migration_destination_apply_record(array $item): array
{
    /** @var \wpdb $wpdb */
    global $wpdb;
    if ($wpdb->query('START TRANSACTION') === false) {
        throw new RuntimeException('Could not start a transaction for destination import.');
    }

    $transaction_active = true;
    $post_id = (int) ($item['post_id'] ?? 0);
    try {
        if ($post_id > 0) {
            ts_migration_destination_lock_post_row($post_id);
            ts_migration_destination_assert_preflight_unchanged($item);
        }

        $result = ts_migration_destination_apply_record_locked($item);
        if ($wpdb->query('COMMIT') === false) {
            $wpdb->query('ROLLBACK');
            $transaction_active = false;
            throw new RuntimeException('Destination import commit failed; the transaction was rolled back.');
        }
        $transaction_active = false;
        $post_id = (int) ($result['post_id'] ?? $post_id);
        if ($post_id > 0) {
            clean_post_cache($post_id);
        }
        return $result;
    } catch (Throwable $error) {
        if ($transaction_active) {
            if ($wpdb->query('COMMIT') === false) {
                $wpdb->query('ROLLBACK');
                $transaction_active = false;
                if ($post_id > 0) {
                    clean_post_cache($post_id);
                }
                throw new RuntimeException('Destination import failed and its recovery state could not be committed.', 0, $error);
            }
            $transaction_active = false;
        }
        if ($post_id > 0) {
            clean_post_cache($post_id);
        }
        throw $error;
    }
}

function ts_migration_destination_apply_record_locked(array $item): array
{
    $record = $item['record'];
    $expected = ts_migration_destination_expected_state($record);
    $expected_hash = ts_migration_destination_state_hash($expected);
    $action = $item['action'];

    if ('finalize' === $action) {
        ts_migration_destination_save_meta((int) $item['post_id'], '_ts_destination_import_state', 'ready');
        return ['action' => 'finalized', 'slug' => $record['slug'], 'post_id' => (int) $item['post_id']];
    }

    if ('publish' === $action) {
        $post_id = (int) $item['post_id'];
        $published_id = wp_update_post(wp_slash(['ID' => $post_id, 'post_status' => 'publish']), true);
        if (is_wp_error($published_id) || (int) $published_id !== $post_id) {
            throw new RuntimeException('Could not publish staging destination: ' . $record['slug']);
        }
        $actual = ts_migration_destination_current_state($post_id);
        if (ts_migration_destination_state_hash($actual) !== ts_migration_destination_state_hash($expected)) {
            ts_migration_destination_return_to_draft($post_id, $record['slug']);
            throw new RuntimeException('Staging destination failed post-write verification: ' . $record['slug']);
        }
        ts_migration_destination_save_meta($post_id, '_ts_destination_import_state', 'ready');
        return ['action' => 'published', 'slug' => $record['slug'], 'post_id' => $post_id];
    }

    if ('create' === $action) {
        $post_id = wp_insert_post(wp_slash([
            'post_type' => 'ts_destination',
            'post_status' => 'draft',
            'post_name' => $record['slug'],
            'post_title' => $record['post_title'],
            'post_excerpt' => $record['post_excerpt'],
            'post_content' => $record['post_content'],
            'meta_input' => [
                '_ts_source_destination_id' => (int) $record['source_record_id'],
                '_ts_source_destination_slug' => $record['slug'],
                '_ts_destination_import_state' => 'pending',
            ],
        ]), true);
        if (is_wp_error($post_id) || !is_numeric($post_id) || (int) $post_id < 1) {
            throw new RuntimeException('Could not create staging destination: ' . $record['slug']);
        }
        $post_id = (int) $post_id;
    } else {
        $post_id = (int) $item['post_id'];
        if ('update' === $action) {
            ts_migration_destination_save_meta($post_id, '_ts_destination_import_state', 'updating');
        }
    }

    if ('resume' === $action && empty($item['new_pending'])) {
        ts_migration_destination_save_meta($post_id, '_ts_destination_import_state', 'updating');
    }

    $draft_expected = ts_migration_destination_expected_state($record, 'draft');
    $updated_id = wp_update_post(wp_slash([
        'ID' => $post_id,
        'post_type' => 'ts_destination',
        'post_status' => 'draft',
        'post_name' => $record['slug'],
        'post_title' => $record['post_title'],
        'post_excerpt' => $record['post_excerpt'],
        'post_content' => $record['post_content'],
    ]), true);
    if (is_wp_error($updated_id) || (int) $updated_id !== $post_id) {
        throw new RuntimeException('Could not update staging destination content: ' . $record['slug']);
    }

    foreach ($record['fields'] as $field_name => $value) {
        update_field('field_' . $field_name, $value, $post_id);
    }

    $draft_actual = ts_migration_destination_current_state($post_id);
    if (ts_migration_destination_state_hash($draft_actual) !== ts_migration_destination_state_hash($draft_expected)) {
        throw new RuntimeException('Staging destination failed pre-publish verification: ' . $record['slug']);
    }

    $snapshot_json = wp_json_encode(
        $expected,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS
    );
    if (!is_string($snapshot_json)) {
        throw new RuntimeException('Could not save destination import snapshot: ' . $record['slug']);
    }
    ts_migration_destination_save_meta($post_id, '_ts_source_destination_id', (int) $record['source_record_id']);
    ts_migration_destination_save_meta($post_id, '_ts_source_destination_slug', $record['slug']);
    ts_migration_destination_save_meta($post_id, '_ts_destination_import_snapshot', $snapshot_json);
    ts_migration_destination_save_meta($post_id, '_ts_destination_import_hash', $expected_hash);
    ts_migration_destination_save_meta($post_id, '_ts_destination_import_state', 'publishing');

    $published_id = wp_update_post(wp_slash(['ID' => $post_id, 'post_status' => 'publish']), true);
    if (is_wp_error($published_id) || (int) $published_id !== $post_id) {
        throw new RuntimeException('Could not publish staging destination: ' . $record['slug']);
    }

    $actual = ts_migration_destination_current_state($post_id);
    if (ts_migration_destination_state_hash($actual) !== $expected_hash) {
        ts_migration_destination_return_to_draft($post_id, $record['slug']);
        throw new RuntimeException('Staging destination failed post-write verification: ' . $record['slug']);
    }

    ts_migration_destination_save_meta($post_id, '_ts_destination_import_state', 'ready');

    return ['action' => 'create' === $action ? 'created' : ('update' === $action ? 'updated' : 'resumed'), 'slug' => $record['slug'], 'post_id' => $post_id];
}

function ts_migration_import_destinations(array $manifest, bool $dry_run = true): array
{
    foreach (['get_posts', 'get_post', 'get_post_meta', 'update_post_meta', 'get_field', 'update_field', 'acf_get_field', 'wp_insert_post', 'wp_update_post', 'wp_slash', 'wp_json_encode', 'wp_parse_url', 'is_wp_error', 'home_url', 'get_option', 'clean_post_cache'] as $required_function) {
        if (!function_exists($required_function)) {
            throw new RuntimeException('WordPress or ACF importer dependency is unavailable: ' . $required_function);
        }
    }

    $site_host = strtolower((string) wp_parse_url(home_url(), PHP_URL_HOST));
    if ('test.tanzaniasensational.com' !== $site_host) {
        throw new RuntimeException('Destination importer is locked to test.tanzaniasensational.com.');
    }
    if (!in_array(get_option('blog_public'), [0, '0', false], true)) {
        throw new RuntimeException('Destination import requires staging search visibility to remain disabled.');
    }
    if (!$dry_run && (!function_exists('current_user_can') || !current_user_can('manage_options'))) {
        throw new RuntimeException('Applying destination imports requires a staging administrator.');
    }

    foreach (ts_migration_destination_field_names() as $field_name) {
        $field = acf_get_field('field_' . $field_name);
        if (!is_array($field) || $field_name !== (string) ($field['name'] ?? '')) {
            throw new RuntimeException('Required destination field is not registered in ACF: ' . $field_name);
        }
    }

    ts_migration_validate_destination_manifest($manifest);
    if (!$dry_run) {
        ts_migration_destination_assert_transactional_storage();
    }
    $plan = ts_migration_destination_build_plan($manifest);
    if ($dry_run) {
        return array_map(static function (array $item): array {
            return ['action' => $item['action'], 'slug' => $item['record']['slug'], 'post_id' => (int) $item['post_id']];
        }, $plan);
    }

    $results = [];
    foreach ($plan as $item) {
        if ('unchanged' === $item['action']) {
            $results[] = ['action' => 'unchanged', 'slug' => $item['record']['slug'], 'post_id' => (int) $item['post_id']];
            continue;
        }
        $results[] = ts_migration_destination_apply_record($item);
    }
    return $results;
}
