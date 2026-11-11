<?php
/**
 * Return a cache version for a plugin asset without warning if it is unavailable.
 */
function ts_design_asset_version(string $path, string $fallback): string
{
    if (!is_file($path) || !is_readable($path)) {
        return $fallback;
    }

    $modified = @filemtime($path);
    return false === $modified ? $fallback : (string) $modified;
}
