<?php

namespace App\Http\Controllers;

use App\Models\VisualAsset;

abstract class Controller
{
    /**
     * Build a BreadcrumbList JSON-LD schema array.
     *
     * @param array $crumbs Array of ['label' => string, 'url' => string] from root to current page.
     *                      The first item should be the homepage (label: 'Home', url: '/').
     * @return array The BreadcrumbList schema array ready for json_encode.
     */
    protected function buildBreadcrumbs(array $crumbs): array
    {
        $itemList = [];
        $position = 1;

        foreach ($crumbs as $crumb) {
            $itemList[] = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $crumb['label'],
                'item' => url($crumb['url']),
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $itemList,
        ];
    }

    /**
     * Resolve a hero image URL from the VisualAsset DB table with an Unsplash fallback.
     * Used to emit <link rel="preload" as="image" fetchpriority="high"> for LCP optimization.
     *
     * @param string $section  The visual asset section key (e.g., 'home.hero', 'about.hero').
     * @param string $fallback Unsplash URL to use if no DB asset exists.
     * @return string|null The resolved image URL or null if nothing is available.
     */
    protected function heroImageFromVisuals(string $section, string $fallback): ?string
    {
        $asset = VisualAsset::where('section', $section)->first();
        if ($asset && !empty($asset->url)) {
            return $asset->url;
        }
        return $fallback ?: null;
    }
}
