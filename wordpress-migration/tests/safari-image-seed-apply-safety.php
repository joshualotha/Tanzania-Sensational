<?php
require_once __DIR__ . '/safari-image-seed-runtime.php';
require_once __DIR__ . '/safari-image-seed-apply-fixture.inc';

// Restore the first destination to the empty source state for a clean apply probe.
$GLOBALS['safari_fields'][15]['ts_dest_hero_image'] = '0';
$beforeCalls = count($GLOBALS['safari_http_calls']);
$beforeFields = $GLOBALS['safari_fields'];
$beforeMeta = $GLOBALS['safari_meta'];
$failed = false;
try {
    ts_safari_image_seed_apply($manifest, $landing, $actualLandingHash);
} catch (RuntimeException $e) {
    $failed = true;
}
$assert($failed, 'image apply refuses a landing page without verified source ownership and preservation clone');
$assert(count($GLOBALS['safari_http_calls']) === $beforeCalls, 'unsafe page preflight refuses before downloading or creating media');
foreach ($destinationIds as $id) {
    $assert(($GLOBALS['safari_fields'][$id]['ts_dest_hero_image'] ?? null) === ($beforeFields[$id]['ts_dest_hero_image'] ?? null), 'unsafe page preflight leaves destination image fields unchanged');
    $assert(($GLOBALS['safari_fields'][$id]['ts_dest_hero_image_url'] ?? null) === ($beforeFields[$id]['ts_dest_hero_image_url'] ?? null), 'unsafe page preflight leaves source URL fields unchanged');
    $assert(($GLOBALS['safari_meta'][$id]['_ts_safari_content_image_owner'] ?? null) === ($beforeMeta[$id]['_ts_safari_content_image_owner'] ?? null), 'unsafe page preflight leaves destination ownership metadata unchanged');
}

// A failure after the private backup clone must roll the clone and destination writes back together.
$expectedManagedHash = safari_image_seed_prepare_owned_landing();
$landingBefore = ts_safari_image_seed_snapshot(ts_safari_read_landing_page(27));
$destinationsBefore = [];
foreach ($destinationIds as $id) $destinationsBefore[$id] = ts_safari_image_seed_capture_target($id);
$startsBefore = count(array_filter($GLOBALS['wpdb']->queries, static fn($query) => $query === 'START TRANSACTION'));
$GLOBALS['safari_fail_field_post'] = 15;
$applyError = '';
try {
    ts_safari_image_seed_apply($manifest, $landing, $expectedManagedHash);
} catch (RuntimeException $e) {
    $applyError = $e->getMessage();
}
unset($GLOBALS['safari_fail_field_post']);
$assert(str_contains($applyError, 'Safari destination image attachment write failed: serengeti') && str_contains($applyError, 'database writes rolled back and verified'), 'injected destination failure occurs after the shared-transaction landing clone and is safely rolled back');
$startsAfter = count(array_filter($GLOBALS['wpdb']->queries, static fn($query) => $query === 'START TRANSACTION'));
$assert($startsAfter - $startsBefore === 1 && !$GLOBALS['wpdb']->transactionActive, 'image seed and preservation clone use one transaction that closes on rollback');
$assert(hash_equals($landingBefore['hash'], ts_safari_image_seed_snapshot(ts_safari_read_landing_page(27))['hash']), 'failed seed preserves the exact landing post and raw metadata snapshot');
foreach ($destinationIds as $id) {
    $assert(hash_equals(ts_safari_image_seed_state_hash($destinationsBefore[$id]), ts_safari_image_seed_state_hash(ts_safari_image_seed_capture_target($id))), 'failed seed restores destination post, raw metadata, and ACF fields');
}
$pageIds = [];
foreach ($GLOBALS['safari_posts'] as $id => $post) if (($post->post_type ?? '') === 'page') $pageIds[] = (int)$id;
sort($pageIds);
$assert($pageIds === [27, 162], 'failed seed rolls back its temporary private preservation clone');
$ownedAttachments = get_posts(['post_type'=>'attachment','post_status'=>'any','numberposts'=>-1,'meta_key'=>'_ts_safari_seed_owner','meta_value'=>$manifest['owner']]);
$assert(count($ownedAttachments) === 11, 'verified owned media attachments remain available for an idempotent safe resume');
echo "PASS: safari image seed apply preflight and transactional failure rollback\n";
