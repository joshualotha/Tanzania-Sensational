<?php

namespace App\Http\Controllers;

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
}
