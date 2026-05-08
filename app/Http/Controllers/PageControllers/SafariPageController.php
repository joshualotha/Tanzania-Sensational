<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\SafariPackage;
use App\Models\Destination;
use Inertia\Inertia;

class SafariPageController extends Controller
{
    /**
     * Build page-specific meta array for a safari package.
     */
    private function buildPackageMeta(SafariPackage $pkg): array
    {
        $appUrl = rtrim((string)config('app.url', url('/')), '/');
        $path = '/safaris/packages/' . $pkg->slug;

        $touristTrip = [
            '@context' => 'https://schema.org',
            '@type' => 'TouristTrip',
            'name' => $pkg->name,
            'description' => $pkg->meta_description ?? $pkg->name . ' safari experience',
            'url' => $appUrl . $path,
            'image' => $pkg->hero_image ? $appUrl . $pkg->hero_image : null,
        ];

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Safaris', 'url' => '/safaris'],
            ['label' => 'Packages', 'url' => '/safaris/packages'],
            ['label' => $pkg->name, 'url' => $path],
        ]);

        return [
            'title' => $pkg->meta_title ?? $pkg->name . ' | Tanzania Safari | Tanzania Sensational',
            'description' => $pkg->meta_description ?? 'Explore ' . $pkg->name . ' — a premium Tanzania safari experience. Book your adventure with expert guides.',
            'og_title' => $pkg->meta_title ?? $pkg->name . ' | Tanzania Safari',
            'og_description' => $pkg->meta_description ?? 'Explore ' . $pkg->name . ' on safari with Tanzania Sensational.',
            'og_image' => $pkg->hero_image ? $appUrl . $pkg->hero_image : null,
            'canonical' => $appUrl . $path,
            'schema' => [$touristTrip, $breadcrumbs],
        ];
    }

    /**
     * Build page-specific meta array for a destination.
     */
    private function buildDestinationMeta(Destination $dest): array
    {
        $appUrl = rtrim((string)config('app.url', url('/')), '/');
        $path = '/safaris/destinations/' . $dest->slug;

        $touristAttraction = [
            '@context' => 'https://schema.org',
            '@type' => 'TouristAttraction',
            'name' => $dest->name,
            'description' => $dest->meta_description ?? $dest->name . ' — Tanzania safari destination',
            'url' => $appUrl . $path,
            'image' => $dest->hero_image ? $appUrl . $dest->hero_image : null,
        ];

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Safaris', 'url' => '/safaris'],
            ['label' => 'Destinations', 'url' => '/safaris/destinations'],
            ['label' => $dest->name, 'url' => $path],
        ]);

        return [
            'title' => $dest->meta_title ?? $dest->name . ' | Tanzania Safari Destinations',
            'description' => $dest->meta_description ?? 'Explore ' . $dest->name . ' — a premier Tanzania safari destination. Book your adventure.',
            'og_title' => $dest->meta_title ?? $dest->name . ' | Tanzania Safari Destinations',
            'og_description' => $dest->meta_description ?? 'Discover ' . $dest->name . ' on safari with Tanzania Sensational.',
            'og_image' => $dest->hero_image ? $appUrl . $dest->hero_image : null,
            'canonical' => $appUrl . $path,
            'schema' => [$touristAttraction, $breadcrumbs],
        ];
    }

    /**
     * Display a safari package detail page.
     */
    public function showPackage($packageId)
    {
        $pkg = SafariPackage::findOrFail($packageId);

        return Inertia::render('safaris/SafariPackageDetail', [
            'pkg' => $pkg,
            'meta' => $this->buildPackageMeta($pkg),
        ]);
    }

    /**
     * Display a destination detail page.
     */
    public function showDestination($id)
    {
        $destination = Destination::findOrFail($id);

        return Inertia::render('safaris/DestinationDetail', [
            'destination' => $destination,
            'meta' => $this->buildDestinationMeta($destination),
        ]);
    }
}
