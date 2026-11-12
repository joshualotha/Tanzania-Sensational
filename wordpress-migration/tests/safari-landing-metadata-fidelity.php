<?php
define('ABSPATH', dirname(__DIR__, 2) . DIRECTORY_SEPARATOR);
define('ARRAY_A', 'ARRAY_A');

function wp_json_encode($value, $flags = 0) { return json_encode($value, $flags); }
function wp_slash($value) { if (is_string($value)) return addslashes($value); if (is_array($value)) return array_map('wp_slash', $value); return $value; }
function unslash($value) { if (is_string($value)) return stripslashes($value); if (is_array($value)) return array_map('unslash', $value); return $value; }
function is_wp_error($value) { return false; }
function wp_generate_password() { return 'abc123'; }
function wp_parse_url($url) { return parse_url($url); }
function clean_post_cache($id) {}
function get_post($id) { return isset($GLOBALS['pages'][$id]) ? (object) $GLOBALS['pages'][$id]['post'] : null; }
function get_post_status($id) { return $GLOBALS['pages'][$id]['post']['post_status'] ?? false; }
function get_post_meta($id, $key = '', $single = true) {
    $meta = $GLOBALS['pages'][$id]['meta'] ?? [];
    if ($key === '') { foreach ($meta as $name => $values) if (!is_array($values)) $meta[$name] = [$values]; return $meta; }
    $values = $meta[$key] ?? []; if (!is_array($values)) $values = [$values];
    return $single ? ($values[0] ?? '') : $values;
}
function update_post_meta($id, $key, $value) {
    $value = unslash($value); $GLOBALS['pages'][$id]['meta'][$key] = [$value];
    $found = false; foreach ($GLOBALS['raw_meta_rows'][$id] ?? [] as $index => $row) if ($row['meta_key'] === $key) { if (!$found) { $GLOBALS['raw_meta_rows'][$id][$index]['meta_value'] = $value; $found = true; } else unset($GLOBALS['raw_meta_rows'][$id][$index]); }
    if (!$found) $GLOBALS['raw_meta_rows'][$id][] = ['meta_key' => $key, 'meta_value' => $value];
    $GLOBALS['raw_meta_rows'][$id] = array_values($GLOBALS['raw_meta_rows'][$id]);
    return true;
}
function add_post_meta($id, $key, $value, $unique = false) {
    if ($unique && isset($GLOBALS['pages'][$id]['meta'][$key])) return false;
    $value = unslash($value);
    // Model the observed WP metadata API behavior for serialized-looking strings.
    if (is_string($value) && str_starts_with($value, 'a:')) $value = 's:' . strlen($value) . ':"' . addslashes($value) . '";';
    $GLOBALS['pages'][$id]['meta'][$key][] = $value;
    $GLOBALS['raw_meta_rows'][$id][] = ['meta_key' => $key, 'meta_value' => $value];
    return true;
}
function delete_post_meta($id, $key) {
    unset($GLOBALS['pages'][$id]['meta'][$key]);
    $GLOBALS['raw_meta_rows'][$id] = array_values(array_filter($GLOBALS['raw_meta_rows'][$id] ?? [], static fn($row) => $row['meta_key'] !== $key));
    return true;
}
function wp_insert_post($post, $error = false) {
    $post = unslash($post); $id = ++$GLOBALS['next'];
    $GLOBALS['pages'][$id] = ['post' => ['ID' => $id] + $post, 'meta' => []]; $GLOBALS['raw_meta_rows'][$id] = [];
    if (($post['post_type'] ?? '') === 'page' && str_starts_with($post['post_name'] ?? '', 'safaris-preserved-backup-')) {
        $GLOBALS['pages'][$id]['meta']['rank_math_internal_links_processed'] = ['1'];
        $GLOBALS['raw_meta_rows'][$id][] = ['meta_key' => 'rank_math_internal_links_processed', 'meta_value' => '1'];
    }
    return $id;
}
function wp_update_post($post, $error = false) {
    $post = unslash($post); $id = $post['ID'];
    foreach ($post as $key => $value) if ($key !== 'ID') $GLOBALS['pages'][$id]['post'][$key] = $value;
    if (!array_key_exists('post_modified', $post)) $GLOBALS['pages'][$id]['post']['post_modified'] = '2026-11-12 16:00:00';
    if (!array_key_exists('post_modified_gmt', $post)) $GLOBALS['pages'][$id]['post']['post_modified_gmt'] = '2026-11-12 13:00:00';
    return $id;
}

class LandingMetadataDB {
    public $posts = 'wp_posts'; public $postmeta = 'wp_postmeta'; public $last_error = ''; public $engine = 'InnoDB'; public $transaction = false; public $queries = []; private $snapshot = null;
    function prepare($query, ...$args) { foreach ($args as $value) { $replacement = is_int($value) ? (string) $value : "'" . addslashes((string) $value) . "'"; $query = preg_replace('/%[ds]/', $replacement, $query, 1); } return $query; }
    function query($query) {
        $this->queries[] = $query;
        if ($query === 'START TRANSACTION') { $this->snapshot = [$GLOBALS['pages'], $GLOBALS['raw_meta_rows']]; $this->transaction = true; }
        elseif ($query === 'ROLLBACK' && $this->snapshot !== null) { [$GLOBALS['pages'], $GLOBALS['raw_meta_rows']] = $this->snapshot; $this->snapshot = null; $this->transaction = false; }
        elseif ($query === 'COMMIT') { $this->snapshot = null; $this->transaction = false; }
        return 1;
    }
    function get_var($query) { $this->queries[] = $query; if (str_contains($query, 'information_schema.TABLES')) return $this->engine; if (preg_match('/SELECT ID FROM wp_posts WHERE ID=(\d+)/', $query, $m)) return isset($GLOBALS['pages'][(int) $m[1]]) ? (int) $m[1] : null; return null; }
    function get_row($query, $output = null) { $this->queries[] = $query; if (!$this->transaction || !str_contains($query, 'FOR UPDATE')) throw new RuntimeException('Landing page row lock was not held in a transaction.'); return (object) ['ID' => 27]; }
    function get_results($query, $output = null) {
        $this->queries[] = $query;
        if (str_contains($query, 'SELECT meta_key, meta_value')) { preg_match('/post_id=(\d+)/', $query, $m); return $GLOBALS['raw_meta_rows'][(int) ($m[1] ?? 0)] ?? []; }
        if (!$this->transaction || !str_contains($query, 'FOR UPDATE')) throw new RuntimeException('Landing metadata range lock was not held in a transaction.');
        return [];
    }
    function delete($table, $where, $format = null) {
        if ($table !== $this->postmeta) return false; $id = (int) $where['post_id']; $count = count($GLOBALS['raw_meta_rows'][$id] ?? []); $GLOBALS['raw_meta_rows'][$id] = []; $GLOBALS['pages'][$id]['meta'] = []; return $count;
    }
    function insert($table, $data, $format = null) {
        if ($table !== $this->postmeta) return false; $id = (int) $data['post_id']; $row = ['meta_key' => (string) $data['meta_key'], 'meta_value' => (string) $data['meta_value']]; $GLOBALS['raw_meta_rows'][$id][] = $row; $GLOBALS['pages'][$id]['meta'][$row['meta_key']][] = $row['meta_value']; return 1;
    }
    function update($table, $data, $where, $format = null, $where_format = null) {
        if ($table !== $this->posts) return false; $id = (int) $where['ID']; foreach ($data as $key => $value) $GLOBALS['pages'][$id]['post'][$key] = $value; return 1;
    }
}

$GLOBALS['next'] = 27;
$GLOBALS['pages'] = [27 => ['post' => ['ID' => 27, 'post_type' => 'page', 'post_status' => 'publish', 'post_name' => 'safaris', 'post_title' => 'Safaris', 'post_content' => '', 'post_excerpt' => '', 'post_author' => '7', 'post_date' => '2026-01-02 03:04:05', 'post_date_gmt' => '2026-01-02 00:04:05', 'post_modified' => '2026-01-03 03:04:05', 'post_modified_gmt' => '2026-01-03 00:04:05', 'menu_order' => 3, 'comment_status' => 'closed', 'ping_status' => 'closed', 'post_parent' => 0, 'post_password' => '', 'post_mime_type' => '', 'guid' => 'https://test.tanzaniasensational.com/?page_id=27'], 'meta' => ['_elementor_data' => ['[{"widgetType":"ts_tour_archive","settings":{"count":-1,"show_cta":"yes"}}]'], '_elementor_edit_mode' => ['builder'], '_elementor_controls_usage' => ['a:3:{s:15:"ts_tour_archive";a:1:{s:5:"count";i:1;}}'], 'rank_math_internal_links_processed' => ['1']]]];
$GLOBALS['raw_meta_rows'] = [];
foreach ($GLOBALS['pages'][27]['meta'] as $key => $values) foreach ($values as $value) $GLOBALS['raw_meta_rows'][27][] = ['meta_key' => $key, 'meta_value' => $value];
$GLOBALS['wpdb'] = new LandingMetadataDB();
require_once dirname(__DIR__) . '/migration/safari-package-importer.php';

$source = ts_safari_read_landing_page(27); $snapshot = ts_safari_landing_snapshot($source); $source_rows_before = $GLOBALS['raw_meta_rows'][27];
foreach (['_ts_safari_landing_backup_snapshot', '_ts_safari_landing_backup_hash'] as $reserved_key) {
    $reserved_source = $source;
    $reserved_source['meta'][$reserved_key] = ['editor-owned-value'];
    $reserved_payload = json_decode($snapshot['json'], true);
    $reserved_payload['meta'] = $reserved_source['meta']; ksort($reserved_payload['meta']);
    $reserved_payload['meta_rows'][] = ['meta_key' => $reserved_key, 'meta_value' => 'editor-owned-value'];
    $reserved_json = wp_json_encode($reserved_payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_LINE_TERMINATORS);
    $reserved_hash = hash('sha256', $reserved_json);
    $next_before = $GLOBALS['next']; $queries_before = count($GLOBALS['wpdb']->queries); $pages_before = array_keys($GLOBALS['pages']);
    try { ts_safari_clone_landing(27, $reserved_source, $reserved_json, $reserved_hash); throw new RuntimeException('Clone accepted source metadata using a reserved backup key: ' . $reserved_key); }
    catch (RuntimeException $error) { if (!str_contains($error->getMessage(), 'reserved safari landing backup metadata key')) throw $error; }
    if ($GLOBALS['next'] !== $next_before || array_keys($GLOBALS['pages']) !== $pages_before || $GLOBALS['wpdb']->transaction || in_array('START TRANSACTION', array_slice($GLOBALS['wpdb']->queries, $queries_before), true)) throw new RuntimeException('Reserved-key rejection wrote a clone or opened a transaction.');
    if ($GLOBALS['raw_meta_rows'][27] !== $source_rows_before) throw new RuntimeException('Reserved-key rejection changed source postmeta.');
}
$backup_id = ts_safari_clone_landing(27, $source, $snapshot['json'], $snapshot['hash']);
$source_rows = $GLOBALS['raw_meta_rows'][27]; $backup_rows = $GLOBALS['raw_meta_rows'][$backup_id];
foreach ($backup_rows as $index => $row) if (in_array($row['meta_key'], ['_ts_safari_landing_backup_snapshot', '_ts_safari_landing_backup_hash'], true)) unset($backup_rows[$index]);
if (array_values($backup_rows) !== $source_rows) throw new RuntimeException('Landing backup did not preserve exact raw postmeta rows.');
if (get_post_meta($backup_id, 'rank_math_internal_links_processed', false) !== ['1']) throw new RuntimeException('Clone hook metadata was duplicated instead of replaced by exact source rows.');
if (($GLOBALS['pages'][$backup_id]['post']['post_modified'] ?? '') !== '2026-01-03 03:04:05' || ($GLOBALS['pages'][$backup_id]['post']['post_modified_gmt'] ?? '') !== '2026-01-03 00:04:05') throw new RuntimeException('Landing backup clone did not preserve exact modified timestamps.');
ts_safari_verify_landing_backup($backup_id, $snapshot['hash']);

$original_rows = $GLOBALS['raw_meta_rows'][27]; $original_post = $GLOBALS['pages'][27]['post'];
$GLOBALS['pages'][27]['post']['post_title'] = 'Into the Untamed.'; $GLOBALS['pages'][27]['post']['post_content'] = '<section>source landing</section>'; $GLOBALS['pages'][27]['post']['post_modified'] = '2026-11-12 15:30:00'; $GLOBALS['pages'][27]['post']['post_modified_gmt'] = '2026-11-12 12:30:00';
$GLOBALS['pages'][27]['meta'] = []; $GLOBALS['raw_meta_rows'][27] = [];
update_post_meta(27, '_ts_safari_landing_owner', 'approved-safari-landing-import-v1');
update_post_meta(27, '_ts_safari_landing_snapshot_hash', $snapshot['hash']);
update_post_meta(27, '_ts_safari_landing_backup_id', (string) $backup_id);
$managed_hash = ts_safari_landing_managed_hash(ts_safari_read_landing_page(27));
update_post_meta(27, '_ts_safari_landing_managed_hash', $managed_hash);
$rollback = ts_safari_rollback_landing(27, $backup_id, $snapshot['hash']);
if (($rollback['action'] ?? '') !== 'rolled-back') throw new RuntimeException('Landing rollback did not complete.');
if (!hash_equals($snapshot['hash'], ts_safari_landing_snapshot(ts_safari_read_landing_page(27))['hash'])) throw new RuntimeException('Landing rollback did not restore the full snapshot hash.');
if ($GLOBALS['raw_meta_rows'][27] !== $original_rows) throw new RuntimeException('Landing rollback did not restore exact raw postmeta rows.');
if (($GLOBALS['pages'][27]['post']['post_modified'] ?? '') !== $original_post['post_modified'] || ($GLOBALS['pages'][27]['post']['post_modified_gmt'] ?? '') !== $original_post['post_modified_gmt']) throw new RuntimeException('Landing rollback did not restore exact modified timestamps.');
echo "PASS: safari landing clone and rollback preserve exact raw postmeta and post timestamps.\n";
