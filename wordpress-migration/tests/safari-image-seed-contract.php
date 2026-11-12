<?php
define('ABSPATH', dirname(__DIR__, 2) . DIRECTORY_SEPARATOR);
function wp_parse_url($url) { return parse_url($url); }
function wp_json_encode($value, $flags = 0) { return json_encode($value, $flags); }
require_once dirname(__DIR__) . '/migration/safari-package-importer.php';

$assert = static function (bool $condition, string $message): void {
    if (!$condition) throw new RuntimeException($message);
};
$throws = static function (callable $fn, string $message) use ($assert): void {
    try { $fn(); } catch (RuntimeException $e) { return; }
    $assert(false, $message);
};

$landing = json_decode(file_get_contents(dirname(__DIR__) . '/migration/safari-landing-manifest.json'), true, 512, JSON_THROW_ON_ERROR);
$imagePath = dirname(__DIR__) . '/migration/safari-image-seed-manifest.json';
$assert(is_file($imagePath), 'image-seed manifest exists');
$manifest = json_decode(file_get_contents($imagePath), true, 512, JSON_THROW_ON_ERROR);
$assert(function_exists('ts_safari_validate_image_seed_manifest'), 'image-seed manifest validator is available');
$cli = file_get_contents(dirname(__DIR__) . '/migration/safari-image-seed-import-cli.php');
$assert(is_string($cli) && str_contains($cli, "add_command('ts safari-images seed'") && str_contains($cli, "add_command('ts safari-images rollback'") && str_contains($cli, 'confirm-staging-write') && str_contains($cli, 'managed-hash') && str_contains($cli, 'backup-id') && str_contains($cli, 'if($apply&&'), 'separate image-seed CLI exposes dry-run/apply plus separately confirmed rollback with backup and managed hashes');
$assert(function_exists('ts_safari_image_seed_apply'), 'image-seed apply coordinator is available');
ts_safari_validate_image_seed_manifest($manifest, $landing);
$assert(count($manifest['assets']) === 11, 'seed exactly the eleven images used on the live safari page');
$assert(array_column($manifest['landing']['destinations'], 'slug') === ['serengeti','ngorongoro','tarangire','kilimanjaro','lake-manyara','zanzibar','ruaha','nyerere','mahale'], 'map all nine destination posts in source order');
$assert($manifest['legacy_tours'] === [], 'leave legacy tours untouched when no exact live-source image exists');
$assert(ts_safari_image_seed_asset_map($manifest)['landing.hero']['source_url'] === $landing['hero_image'], 'landing hero source remains exact');
$assert(ts_safari_image_seed_asset_map($manifest)['landing.difference']['source_url'] === $landing['difference_image'], 'difference source remains exact');
foreach ($landing['destinations'] as $card) {
    $key = 'destination.' . $card['slug'];
    $assert(ts_safari_image_seed_asset_map($manifest)[$key]['source_url'] === $card['image'], 'destination image remains source-matched: ' . $card['slug']);
}
$bad = $manifest; $bad['landing']['destinations'][0]['post_id'] = 16;
$throws(static fn() => ts_safari_validate_image_seed_manifest($bad, $landing), 'reject destination ID/slug mismatch');
$bad = $manifest; $bad['legacy_tours'] = [['post_id'=>12,'slug'=>'great-migration-edition','asset_key'=>'landing.hero']];
$throws(static fn() => ts_safari_validate_image_seed_manifest($bad, $landing), 'reject image seeding outside the exact live-source page set');
$assert(ts_safari_image_seed_asset_map($manifest)['destination.mahale']['source_url'] === $landing['destinations'][8]['image'], 'Mahale uses the exact live source image rather than a substitute');
$bad = $manifest; $bad['assets'][0]['source_url'] = 'https://images.example.invalid/unreviewed.jpg';
$throws(static fn() => ts_safari_validate_image_seed_manifest($bad, $landing), 'reject unapproved image source URL');
$bad = $manifest; $bad['assets'][0]['alt'] = 'A plausible but non-source alt';
$throws(static fn() => ts_safari_validate_image_seed_manifest($bad, $landing), 'reject hero alt text that differs from the exact live source');
$bad = $manifest; $bad['assets'][10]['alt'] = 'Mahale mountain landscape';
$throws(static fn() => ts_safari_validate_image_seed_manifest($bad, $landing), 'reject Mahale alt text that differs from the exact live source');

echo "PASS: safari image seed source and target contract\n";
