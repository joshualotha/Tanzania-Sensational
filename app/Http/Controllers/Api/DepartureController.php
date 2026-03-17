<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departure;
use Illuminate\Http\Request;

class DepartureController extends Controller
{
    public function index(Request $request)
    {
        $query = Departure::with('trekkingRoute')
            ->orderBy('departure_date');

        if ($request->has('route_slug')) {
            $query->whereHas('trekkingRoute', function ($q) use ($request) {
                $q->where('slug', $request->route_slug);
            });
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trekking_route_id' => 'required|exists:trekking_routes,id',
            'departure_date' => 'required|date',
            'return_date' => 'nullable|date',
            'price_cents' => 'required|integer',
            'available_seats' => 'required|integer',
            'booked_seats' => 'integer',
            'status' => 'required|string',
            'summit_night' => 'nullable|string',
            'meeting_point' => 'nullable|string',
            'briefing_date' => 'nullable|string',
            'description' => 'nullable|string',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
        ]);

        $departure = Departure::create($validated);
        return response()->json($departure->load('trekkingRoute'), 201);
    }

    public function show($id)
    {
        $departure = Departure::with('trekkingRoute.itineraryDays')->findOrFail($id);
        return response()->json($departure);
    }

    public function update(Request $request, $id)
    {
        $departure = Departure::findOrFail($id);
        
        $validated = $request->validate([
            'trekking_route_id' => 'exists:trekking_routes,id',
            'departure_date' => 'date',
            'return_date' => 'nullable|date',
            'price_cents' => 'integer',
            'available_seats' => 'integer',
            'booked_seats' => 'integer',
            'status' => 'string',
            'summit_night' => 'nullable|string',
            'meeting_point' => 'nullable|string',
            'briefing_date' => 'nullable|string',
            'description' => 'nullable|string',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
        ]);

        $departure->update($validated);
        return response()->json($departure->load('trekkingRoute'));
    }

    public function destroy($id)
    {
        $departure = Departure::findOrFail($id);
        $departure->delete();
        return response()->json(null, 204);
    }
}
