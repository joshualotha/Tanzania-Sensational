<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\Departure;
use Inertia\Inertia;

class PlanPageController extends Controller
{
    /**
     * Build meta array for a departure detail page.
     */
    private function buildDepartureMeta(Departure $departure): array
    {
        $routeName = $departure->trekkingRoute?->name ?? 'Kilimanjaro';
        $date = $departure->departure_date?->format('F j, Y');
        $slots = $departure->remaining_seats;
        $price = '$' . number_format($departure->price, 0);

        $title = "{$routeName} Departure {$date} | Tanzania Sensational";
        if (strlen($title) > 60) {
            $title = "{$routeName} {$date} | Tanzania Sensational";
        }

        $description = "Join our {$routeName} group departure on {$date}. {$slots} spots available from {$price}. Book your Kilimanjaro trekking date with Tanzania Sensational.";

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Group Departures', 'url' => '/group-departures'],
            ['label' => "{$routeName} - {$date}", 'url' => '/group-departures/' . $departure->id],
        ]);

        return [
            'title' => $title,
            'description' => $description,
            'og_image' => $departure->trekkingRoute?->hero_image ?? config('app.url') . '/logo.png',
            'canonical' => url('/group-departures/' . $departure->id),
            'schema' => [$breadcrumbs],
        ];
    }

    /**
     * Display the group departures listing page.
     */
    public function groupDepartures()
    {
        $departures = Departure::with('trekkingRoute')
            ->orderBy('departure_date')
            ->get();

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Group Departures', 'url' => '/group-departures'],
        ]);

        $meta = [
            'title' => 'Tanzania Group Departures | Kilimanjaro Trekking Dates & Prices',
            'description' => 'Browse confirmed Kilimanjaro group departure dates. Join a shared trek on Lemosho, Machame, Marangu & more. Fixed prices, guaranteed departures, expert guides.',
            'og_image' => config('app.url') . '/logo.png',
            'canonical' => url('/group-departures'),
            'schema' => [$breadcrumbs],
        ];

        return Inertia::render('plan/GroupDepartures', [
            'departures' => $departures,
            'meta' => $meta,
        ]);
    }

    /**
     * Display a single departure detail page.
     */
    public function departureDetail($departureId)
    {
        $departure = Departure::with('trekkingRoute')->findOrFail($departureId);

        $meta = $this->buildDepartureMeta($departure);

        return Inertia::render('plan/DepartureDetail', [
            'departure' => $departure,
            'meta' => $meta,
        ]);
    }
}
