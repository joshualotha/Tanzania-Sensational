<?php

declare(strict_types=1);

if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

function add_action(string $hook, callable $callback, int $priority = 10): void
{
}

require __DIR__ . '/../staging-plugin/route-fallbacks.php';

$target = ts_route_fallback_target('trekking/kilimanjaro');
if ($target !== 'kilimanjaro-pillar') {
    throw new RuntimeException('The legacy Kilimanjaro landing URL must route to the Kilimanjaro pillar page.');
}

if (ts_route_fallback_target('/trekking/kilimanjaro/') !== 'kilimanjaro-pillar') {
    throw new RuntimeException('The Kilimanjaro landing fallback must normalize slashes.');
}

if (ts_route_fallback_target('not-a-known-route') !== null) {
    throw new RuntimeException('Unknown routes must not be redirected by the fallback map.');
}

fwrite(STDOUT, "PASS: Kilimanjaro legacy route falls back to the matching pillar, with unknown paths unchanged.\n");
