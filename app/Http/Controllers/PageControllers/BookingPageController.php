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

        if ($departureId) {
            $type = 'departure';
            $id = $departureId;
            $dep = Departure::with('trekkingRoute')->findOrFail($id);
            $pkg = [
                'departure_id' => $dep->id,
                'name' => $dep->trekkingRoute?->name ? $dep->trekkingRoute->name . ' Route' : 'Group Departure',
                'departure_date' => $dep->departure_date?->toDateString(),
                'duration' => $dep->trekkingRoute?->duration_days ?? $dep->trekkingRoute?->duration ?? null,
                'meta_tag' => $dep->status ?? null,
                'hero_image' => $dep->trekkingRoute?->hero_image ?? null,
            ];
            $pageMeta = [
                'hero_image' => $dep->trekkingRoute?->hero_image ?? null,
                'title' => $dep->trekkingRoute?->name ? $dep->trekkingRoute->name . ' Route' : 'Group Departure',
                'subtitle' => 'Submit your booking request and we\'ll confirm availability, details, and payment instructions by email.',
            ];
        } elseif ($packageId) {
            $type = 'safari';
            $id = $packageId;
            $safari = SafariPackage::findOrFail($id);
            $pkg = $safari;
            $pageMeta = [
                'hero_image' => $safari->hero_image ?? null,
                'title' => $safari->name ?? 'Safari Booking',
                'subtitle' => 'Submit your booking request and we\'ll confirm details and payment instructions by email.',
            ];
        }

        return Inertia::render('BookingPage', [
            'type' => $type,
            'id' => $id,
            'pkg' => $pkg,
            'pageMeta' => $pageMeta,
        ]);
    }
}
