<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\TrekkingRoute;
use Inertia\Inertia;

class TrekkingPageController extends Controller
{
    /**
     * Build page-specific meta array from a trekking route model.
     */
    private function buildMeta(TrekkingRoute $route): array
    {
        $appUrl = rtrim((string)config('app.url', url('/')), '/');
        $path = '/trekking/kilimanjaro/' . $route->slug;

        $touristTrip = [
            '@context' => 'https://schema.org',
            '@type' => 'TouristTrip',
            'name' => $route->name . ' Route',
            'description' => $route->meta_description ?? $route->name . ' on Kilimanjaro',
            'url' => $appUrl . $path,
            'image' => $route->hero_image ? $appUrl . $route->hero_image : null,
            'duration' => 'P' . ($route->duration_days ?? $route->duration ?? 7) . 'D',
        ];

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Kilimanjaro Routes', 'url' => '/trekking/kilimanjaro/lemosho'],
            ['label' => $route->name, 'url' => $path],
        ]);

        return [
            'title' => $route->meta_title ?? $route->name . ' | Kilimanjaro Trekking | Tanzania Sensational',
            'description' => $route->meta_description ?? 'Trek the ' . $route->name . ' on Kilimanjaro. Expert guides, quality equipment, and high success rates. Book your ' . $route->name . ' adventure.',
            'og_title' => $route->meta_title ?? $route->name . ' | Kilimanjaro Trekking',
            'og_description' => $route->meta_description ?? 'Trek the ' . $route->name . ' on Kilimanjaro with Tanzania Sensational.',
            'og_image' => $route->hero_image ? $appUrl . $route->hero_image : null,
            'canonical' => $appUrl . $path,
            'schema' => [$touristTrip, $breadcrumbs],
        ];
    }

    /**
     * Display a trekking route detail page by slug.
     * Maps route slugs to their page component names.
     */
    public function showRoute($slug)
    {
        // The database stores slugs with duration suffixes (e.g. "lemosho-7-days", "marangu-5-days")
        // but the Navbar links use base slugs (e.g. "lemosho", "marangu").
        // Try exact match first, then fall back to LIKE search for the first matching variant.
        $route = TrekkingRoute::where('slug', $slug)->first();

        if (!$route) {
            $route = TrekkingRoute::where('slug', 'LIKE', $slug . '-%')->orderBy('id')->first();
        }

        if (!$route) {
            abort(404);
        }

        // Map slug to page component name (using the base slug from the URL)
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
            'meta' => $this->buildMeta($route),
        ]);
    }

    /**
     * Display a package detail page for a trekking route.
     */
    public function showPackage($routeId, $packageId)
    {
        // Try exact slug match first, then LIKE search for duration-suffixed variants
        $route = TrekkingRoute::where('slug', $routeId)->first();

        if (!$route) {
            $route = TrekkingRoute::where('slug', 'LIKE', $routeId . '-%')->orderBy('id')->first();
        }

        if (!$route) {
            abort(404);
        }

        $package = $route->pricingRules()->where('id', $packageId)->firstOrFail();

        return Inertia::render('trekking/kilimanjaro/PackageDetail', [
            'route' => $route,
            'package' => $package,
            'meta' => $this->buildMeta($route),
        ]);
    }

    /**
     * Display a Meru trekking route detail page by slug.
     * The Navbar generates links like /trekking/meru/{slug} where slug
     * is the trekking route slug (e.g. mt-meru-4-days, mt-meru-3-days).
     */
    public function showMeruPackage($slug)
    {
        // Try exact slug match first, then LIKE search for duration-suffixed variants
        $route = TrekkingRoute::where('slug', $slug)->first();

        if (!$route) {
            $route = TrekkingRoute::where('slug', 'LIKE', $slug . '-%')->orderBy('id')->first();
        }

        if (!$route) {
            abort(404);
        }

        return Inertia::render('trekking/kilimanjaro/PackageDetail', [
            'route' => $route,
            'pkg' => $route,
            'meta' => $this->buildMeta($route),
        ]);
    }
}
