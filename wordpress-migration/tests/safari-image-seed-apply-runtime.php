<?php
require_once __DIR__ . '/safari-image-seed-runtime.php';
require_once __DIR__ . '/safari-image-seed-apply-fixture.inc';
$GLOBALS['safari_fields'][15]['ts_dest_hero_image'] = '0';
$originalDestinationFields = $GLOBALS['safari_fields'];
$expectedHash = safari_image_seed_prepare_owned_landing();
$result = ts_safari_image_seed_apply($manifest, $landing, $expectedHash);
$initialApplyTransactions = count(array_filter($GLOBALS['wpdb']->queries, static fn($query) => $query === 'START TRANSACTION'));
$assert($initialApplyTransactions === 1, 'landing preservation clone joins the outer seed transaction instead of opening a nested transaction');
$assert(($result['action'] ?? '') === 'seeded' && ($result['assets'] ?? 0) === 11 && ($result['destination_fields'] ?? 0) === 9, 'image apply seeds exactly eleven source assets and nine destination fields');
$assert(($result['idempotent_readback'] ?? '') === 'unchanged' && ($result['route_readback'] ?? '') === 'unchanged', 'image apply validates idempotent importer and landing route readback before returning');
$assert(($result['image_seed_backup_hash'] ?? '') === get_post_meta(27, '_ts_safari_image_seed_backup_hash', true), 'apply returns the exact full-page backup hash required for operator rollback');
$acquiredLocks = count(array_filter($GLOBALS['wpdb']->queries, static fn($query) => str_contains($query, 'GET_LOCK')));
$releasedLocks = count(array_filter($GLOBALS['wpdb']->queries, static fn($query) => str_contains($query, 'RELEASE_LOCK')));
$assert($acquiredLocks > 0 && $acquiredLocks === $releasedLocks, 'apply serializes media preparation and transactional writes under a released per-site writer lock');
$assert(get_post_meta(27, '_ts_safari_landing_owner', true) === 'approved-safari-landing-import-v1' && (int)get_post_meta(27, '_ts_safari_landing_backup_id', true) === 162, 'image apply preserves original landing ownership and private clone link');
$assert((int)get_post_meta(27, '_ts_safari_image_seed_backup_id', true) === (int)$result['image_seed_backup_id'], 'image apply links a separate full-page preservation clone');
$assert(ts_safari_landing_plan($landing)['action'] === 'unchanged', 'package landing plan accepts only verified owned local media after image seed');
foreach ($manifest['landing']['destinations'] as $target) {
    $id = (int)$target['post_id'];
    $asset = ts_safari_image_seed_asset_map($manifest)[$target['asset_key']];
    $attachment = ts_safari_image_seed_find_attachment($asset, $manifest['owner']);
    $assert((int)get_field('ts_dest_hero_image', $id, false) === (int)$attachment['id'], 'destination stores the owned attachment ID: '.$target['slug']);
    $url = get_field('ts_dest_hero_image_url', $id, false);
    $assert($url === null || $url === false || $url === '', 'destination source URL override is cleared: '.$target['slug']);
    $assert(get_post_meta($id, '_ts_safari_content_image_owner', true) === $manifest['owner'] && get_post_meta($id, '_ts_safari_content_image_key', true) === $target['asset_key'], 'destination image ownership readback matches manifest: '.$target['slug']);
}
$page = get_post(27);
$assert(str_contains($page->post_content, 'wp-content/uploads/') && !str_contains($page->post_content, 'images.unsplash.com'), 'landing renders from local seeded media URLs');
$assert(get_post_meta(27, '_ts_safari_landing_managed_hash', true) === ts_safari_landing_managed_hash(ts_safari_read_landing_page(27)), 'landing managed hash is recomputed and persisted');
$landingOwnership = [
    'owner' => get_post_meta(27, '_ts_safari_landing_owner', true),
    'backup_id' => get_post_meta(27, '_ts_safari_landing_backup_id', true),
    'snapshot_hash' => get_post_meta(27, '_ts_safari_landing_snapshot_hash', true),
    'managed_hash' => get_post_meta(27, '_ts_safari_landing_managed_hash', true),
];
$GLOBALS['safari_meta'][27]['_ts_safari_landing_owner'] = '';
$unownedManagedHash = ts_safari_landing_managed_hash(ts_safari_read_landing_page(27));
update_post_meta(27, '_ts_safari_landing_managed_hash', $unownedManagedHash);
$unownedPlan = ts_safari_image_seed_plan($manifest, $landing, $unownedManagedHash);
$assert(($unownedPlan['action'] ?? '') === 'unchanged', 'fixture retains a fully seeded page while its original landing ownership marker is missing');
$unownedApplyRejected = false;
try {
    ts_safari_image_seed_apply($manifest, $landing, $unownedManagedHash);
} catch (RuntimeException $e) {
    $unownedApplyRejected = str_contains($e->getMessage(), 'requires the owned source landing');
}
$assert($unownedApplyRejected, 'idempotent apply still requires verified original landing ownership and preservation backup');
$GLOBALS['safari_meta'][27]['_ts_safari_landing_owner'] = $landingOwnership['owner'];
$GLOBALS['safari_meta'][27]['_ts_safari_landing_backup_id'] = $landingOwnership['backup_id'];
$GLOBALS['safari_meta'][27]['_ts_safari_landing_snapshot_hash'] = $landingOwnership['snapshot_hash'];
$GLOBALS['safari_meta'][27]['_ts_safari_landing_managed_hash'] = $landingOwnership['managed_hash'];
$beforeCalls = count($GLOBALS['safari_http_calls']);
$rerun = ts_safari_image_seed_apply($manifest, $landing, get_post_meta(27, '_ts_safari_landing_managed_hash', true));
$assert(($rerun['action'] ?? '') === 'unchanged' && count($GLOBALS['safari_http_calls']) === $beforeCalls, 'subsequent image apply is idempotent and performs no downloads');
$backupId = (int)get_post_meta(27, '_ts_safari_image_seed_backup_id', true);
$backupHash = (string)get_post_meta(27, '_ts_safari_image_seed_backup_hash', true);
$transactionCount = count(array_filter($GLOBALS['wpdb']->queries, static fn($query) => $query === 'START TRANSACTION'));
$rejected = false;
try {
    ts_safari_image_seed_rollback($manifest, $landing, $backupId, $backupHash, str_repeat('0', 64));
} catch (RuntimeException $e) {
    $rejected = str_contains($e->getMessage(), 'managed hash');
}
$assert($rejected && count(array_filter($GLOBALS['wpdb']->queries, static fn($query) => $query === 'START TRANSACTION')) === $transactionCount, 'rollback rejects a stale managed hash before opening a write transaction');
$rollback = ts_safari_image_seed_rollback($manifest, $landing, $backupId, $backupHash, (string)get_post_meta(27, '_ts_safari_landing_managed_hash', true));
$assert(($rollback['action'] ?? '') === 'rolled-back', 'explicit image rollback restores the preserved pre-seed state');
$assert(($GLOBALS['safari_posts'][27]->post_content ?? '') === ts_safari_render_landing($landing) && get_post_meta(27, '_ts_safari_landing_managed_hash', true) === $expectedHash, 'explicit image rollback restores landing HTML and managed hash');
foreach ($manifest['landing']['destinations'] as $target) {
    $id = (int)$target['post_id'];
    $assert(($GLOBALS['safari_fields'][$id]['ts_dest_hero_image'] ?? null) === ($originalDestinationFields[$id]['ts_dest_hero_image'] ?? null), 'explicit rollback restores destination image field: '.$target['slug']);
    $assert(($GLOBALS['safari_fields'][$id]['ts_dest_hero_image_url'] ?? null) === ($originalDestinationFields[$id]['ts_dest_hero_image_url'] ?? null), 'explicit rollback restores source URL field: '.$target['slug']);
}
echo "PASS: safari image seed transaction, readback, owned media, idempotent rerun, and explicit rollback\n";
