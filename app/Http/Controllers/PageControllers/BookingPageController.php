<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\Departure;
use App\Models\SafariPackage;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookingPageController extends Controller
{
    /**
     * Display the booking page.
     *
     * Routes:
     *   /booking                          -> no type/id (show choices)
     *   /booking/departure/{departureId}  -> type=departure
     *   /booking/safari/{packageId}       -> type=safari
     */
    public function show(Request $request, $departureId = null, $packageId = null)
    {
        $type = null;
        $id = null;
        $pkg = null;
        $pageMeta = [
            'hero_image' => null,
            'title' => 'Book Your Expedition',
            'subtitle' => 'Choose a departure or safari package, then submit your booking request. No payment is collected online, our team confirms details by email.',
        ];

        $appUrl = rtrim((string)config('app.url', url('/')), '/');
        $metaTitle = 'Book Your Tanzania Safari & Kilimanjaro Trek | Tanzania Sensational';
        $metaDescription = 'Book your Kilimanjaro trekking expedition, Tanzania safari, or Zanzibar beach holiday. Submit your booking request and our team will confirm availability.';

        if ($departureId) {
            $type = 'departure';
            $id = $departureId;
            $dep = Departure::with('trekkingRoute')->findOrFail($id);
            $routeName = $dep->trekkingRoute?->name ?? 'Group Departure';
            $pkg = [
                'departure_id' => $dep->id,
                'name' => $routeName . ' Route',
                'departure_date' => $dep->departure_date?->toDateString(),
                'duration' => $dep->trekkingRoute?->duration_days ?? $dep->trekkingRoute?->duration ?? null,
                'meta_tag' => $dep->status ?? null,
                'hero_image' => $dep->trekkingRoute?->hero_image ?? null,
            ];
            $pageMeta = [
                'hero_image' => $dep->trekkingRoute?->hero_image ?? null,
                'title' => $routeName . ' Route',
                'subtitle' => 'Submit your booking request and we\'ll confirm availability, details, and payment instructions by email.',
            ];
            $metaTitle = 'Book ' . $routeName . ' | Kilimanjaro Trek Booking | Tanzania Sensational';
            $metaDescription = 'Book your ' . $routeName . ' on Kilimanjaro. Submit your trekking booking request and our team will confirm availability and details.';
        } elseif ($packageId) {
            $type = 'safari';
            $id = $packageId;
            $safari = SafariPackage::where('slug', $id)->firstOrFail();
            $pkg = $safari;
            $pageMeta = [
                'hero_image' => $safari->hero_image ?? null,
                'title' => $safari->name ?? 'Safari Booking',
                'subtitle' => 'Submit your booking request and we\'ll confirm details and payment instructions by email.',
            ];
            $metaTitle = 'Book ' . ($safari->name ?? 'Safari') . ' | Tanzania Safari Booking | Tanzania Sensational';
            $metaDescription = 'Book your ' . ($safari->name ?? 'Tanzania safari') . '. Submit your safari booking request and our team will confirm availability and details.';
        }

        // Build breadcrumbs
        $crumbs = [['label' => 'Home', 'url' => '/']];
        if ($type === 'departure') {
            $crumbs[] = ['label' => 'Group Departures', 'url' => '/group-departures'];
            $crumbs[] = ['label' => 'Book: ' . ($pkg['name'] ?? 'Departure'), 'url' => $request->getPathInfo()];
        } elseif ($type === 'safari') {
            $crumbs[] = ['label' => 'Safaris', 'url' => '/safaris'];
            $crumbs[] = ['label' => 'Book: ' . ($pkg->name ?? 'Safari'), 'url' => $request->getPathInfo()];
        } else {
            $crumbs[] = ['label' => 'Book Your Trip', 'url' => '/booking'];
        }
        $breadcrumbs = $this->buildBreadcrumbs($crumbs);

        return Inertia::render('BookingPage', [
            'type' => $type,
            'id' => $id,
            'pkg' => $pkg,
            'pageMeta' => $pageMeta,
            'meta' => [
                'title' => $metaTitle,
                'description' => $metaDescription,
                'og_title' => $metaTitle,
                'og_description' => $metaDescription,
                'og_image' => $pageMeta['hero_image'] ? $appUrl . $pageMeta['hero_image'] : null,
                'canonical' => $appUrl . ($request->getPathInfo()),
                'schema' => [$breadcrumbs],
            ],
        ]);
    }
}
