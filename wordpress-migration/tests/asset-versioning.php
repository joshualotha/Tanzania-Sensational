<?php

declare(strict_types=1);

require __DIR__ . '/../staging-plugin/asset-versioning.php';

function asset_version_assert(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$existing_file = __FILE__;
$expected_mtime = (string) filemtime($existing_file);
asset_version_assert(
    ts_design_asset_version($existing_file, 'fallback') === $expected_mtime,
    'Existing readable assets should use their modification time for cache busting.'
);
asset_version_assert(
    ts_design_asset_version(__DIR__ . '/missing-asset.css', '1.3.5') === '1.3.5',
    'Missing assets should use the stable fallback without emitting a warning.'
);

fwrite(STDOUT, "PASS: asset versioning handles existing and missing files safely.\n");
