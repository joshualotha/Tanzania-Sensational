<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\TrekkingRoute;
use Inertia\Inertia;

class TrekkingPageController extends Controller
{
    /**
     * Display a trekking route detail page by slug.
     * Maps route slugs to their page component names.
     */
    public function showRoute($slug)
    {
        $route = TrekkingRoute::where('slug', $slug)->firstOrFail();

        // Map slug to page component name
        $componentMap = [
            'lemosho' => 'trekking/kilimanjaro/Lemosho',
            'machame' => 'trekking/kilimanjaro/Machame',
            'rongai' => 'trekking/kilimanjaro/Rongai',
            'marangu' => 'trekking/kilimanjaro/Marangu',
            'northern-circuit' => 'trekking/kilimanjaro/NorthernCircuit',
            'umbwe' => 'trekking/kilimanjaro/Umbwe',
        ];

        $component = $componentMap[$slug] ?? 'trekking/kilimanjaro/Lemosho';

        return Inertia::render($component, [
            'route' => $route,
        ]);
    }

    /**
     * Display a package detail page for a trekking route.
     */
    public function showPackage($routeId, $packageId)
    {
        $route = TrekkingRoute::where('slug', $routeId)->firstOrFail();
        $package = $route->pricingRules()->where('id', $packageId)->firstOrFail();

        return Inertia::render('trekking/kilimanjaro/PackageDetail', [
            'route' => $route,
            'package' => $package,
        ]);
    }

    /**
     * Display a Meru trekking route detail page by slug.
     * The Navbar generates links like /trekking/meru/{slug} where slug
     * is the trekking route slug (e.g. mt-meru-4-days, mt-meru-3-days).
     */
    public function showMeruPackage($slug)
    {
        $route = TrekkingRoute::where('slug', $slug)->firstOrFail();

        return Inertia::render('trekking/kilimanjaro/PackageDetail', [
            'route' => $route,
            'pkg' => $route,
        ]);
    }
}
