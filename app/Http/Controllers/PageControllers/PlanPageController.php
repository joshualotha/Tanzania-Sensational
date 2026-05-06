<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\Departure;
use Inertia\Inertia;

class PlanPageController extends Controller
{
    /**
     * Display the group departures listing page.
     */
    public function groupDepartures()
    {
        $departures = Departure::with('trekkingRoute')
            ->orderBy('departure_date')
            ->get();

        return Inertia::render('plan/GroupDepartures', [
            'departures' => $departures,
        ]);
    }

    /**
     * Display a single departure detail page.
     */
    public function departureDetail($departureId)
    {
        $departure = Departure::with('trekkingRoute')->findOrFail($departureId);

        return Inertia::render('plan/DepartureDetail', [
            'departure' => $departure,
        ]);
    }
}
