<?php
require_once __DIR__ . '/safari-image-seed-runtime.php';
require_once __DIR__ . '/safari-image-seed-apply-fixture.inc';
$GLOBALS['safari_fields'][15]['ts_dest_hero_image'] = '0';
$expectedHash = safari_image_seed_prepare_owned_landing();
$GLOBALS['safari_fail_field_post'] = 57;
$GLOBALS['safari_corrupt_rollback_fields'] = true;
$failure = null;
try {
    ts_safari_image_seed_apply($manifest, $landing, $expectedHash);
} catch (RuntimeException $e) {
    $failure = $e;
}
$assert($failure instanceof RuntimeException, 'injected ACF write failure aborts image seed: '.($failure?->getMessage()??'no exception'));
$assert(($GLOBALS['safari_posts'][27]->post_status ?? '') === 'draft', 'rollback readback detects destination ACF drift and quarantines the landing');
$assert(str_contains($failure->getMessage(), 'manual recovery required'), 'unverified rollback reports manual recovery');
echo "PASS: safari image seed quarantines when destination rollback read-back is incomplete\n";
