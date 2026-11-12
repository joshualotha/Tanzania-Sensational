<?php
define('ABSPATH', dirname(__DIR__, 2) . DIRECTORY_SEPARATOR);
function get_posts($args) {
    $posts = array_values(array_filter($GLOBALS['safari_sequence_tours'], static function ($post) use ($args) {
        if (($post->post_type ?? '') !== ($args['post_type'] ?? '')) return false;
        $status = $args['post_status'] ?? 'any';
        return $status === 'any' || in_array($post->post_status ?? '', (array)$status, true);
    }));
    if (isset($args['numberposts']) && $args['numberposts'] > 0) $posts = array_slice($posts, 0, $args['numberposts']);
    return $posts;
}
function get_post($id) { return $GLOBALS['safari_sequence_by_id'][$id] ?? null; }
function get_post_meta($id, $key = '', $single = true) {
    $meta = $GLOBALS['safari_sequence_meta'][$id] ?? [];
    if ($key === '') return $meta;
    $values = $meta[$key] ?? [];
    if (!is_array($values)) $values = [$values];
    return $single ? ($values[0] ?? '') : $values;
}
function get_field($name, $id, $format = false) { return $GLOBALS['safari_sequence_fields'][$id][$name] ?? null; }
function wp_json_encode($value, $flags = 0) { return json_encode($value, $flags); }
require_once dirname(__DIR__) . '/migration/safari-package-importer.php';
$manifest = json_decode(file_get_contents(dirname(__DIR__) . '/migration/safari-package-import-manifest.json'), true, 512, JSON_THROW_ON_ERROR);
$GLOBALS['safari_sequence_tours'] = [];
$GLOBALS['safari_sequence_by_id'] = [];
$GLOBALS['safari_sequence_meta'] = [];
$GLOBALS['safari_sequence_fields'] = [];
$addTour = static function (int $id, string $slug, int $order) {
    $post = (object)['ID'=>$id,'post_type'=>'ts_tour','post_status'=>'publish','post_name'=>$slug,'post_title'=>$slug];
    $GLOBALS['safari_sequence_tours'][] = $post;
    $GLOBALS['safari_sequence_by_id'][$id] = $post;
    $GLOBALS['safari_sequence_fields'][$id]['ts_tour_display_order'] = (string)$order;
};
$addTour(12, 'great-migration-edition', 1);
$addTour(13, 'pioneers-route', 2);
$addTour(14, 'grand-canvas', 3);
$legacyBefore = ts_safari_legacy_snapshot();
foreach ($manifest['packages'] as $i => $package) $addTour(15 + $i, $package['slug'], ts_safari_expected_fields($package)['ts_tour_display_order']);
if (!function_exists('ts_safari_apply_landing_after_archive_verification')) throw new RuntimeException('Landing apply must expose an archive-verified sequencing gate.');
$landingCalled = false;
$result = ts_safari_apply_landing_after_archive_verification($manifest, $legacyBefore, static function () use (&$landingCalled) { $landingCalled = true; return ['action'=>'applied']; });
if (!$landingCalled || ($result['archive']['count'] ?? 0) !== 5 || ($result['landing']['action'] ?? '') !== 'applied') throw new RuntimeException('Landing apply did not follow a successful exact archive readback.');
$GLOBALS['safari_sequence_tours'][] = (object)['ID'=>16,'post_type'=>'ts_tour','post_status'=>'publish','post_name'=>'unexpected-tour','post_title'=>'Unexpected tour'];
$GLOBALS['safari_sequence_by_id'][16] = $GLOBALS['safari_sequence_tours'][count($GLOBALS['safari_sequence_tours']) - 1];
$landingCalled = false;
try {
    ts_safari_apply_landing_after_archive_verification($manifest, $legacyBefore, static function () use (&$landingCalled) { $landingCalled = true; return ['action'=>'applied']; });
    throw new RuntimeException('Landing was applied despite an unexpected published archive record.');
} catch (RuntimeException $error) {
    if ($error->getMessage() === 'Landing was applied despite an unexpected published archive record.' || !str_contains($error->getMessage(), 'exactly five')) throw $error;
}
if ($landingCalled) throw new RuntimeException('Landing callback ran before the archive exact-set/order gate passed.');
echo "PASS: landing replacement waits for exact five-tour archive readback.\n";
