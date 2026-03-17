<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrekkingRoute;
use Illuminate\Http\Request;

class TrekkingRouteController extends Controller
{
    public function index()
    {
        return response()->json(TrekkingRoute::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:trekking_routes,slug',
            'meta_badge' => 'nullable|string',
            'description' => 'nullable|string',
            'difficulty' => 'nullable|string',
            'duration' => 'nullable|integer',
            'distance' => 'nullable|string',
            'elevation_gain' => 'nullable|string',
            'base_price' => 'nullable|numeric',
            'max_group_size' => 'nullable|integer',
            'hero_image' => 'nullable|string',
            'success_rate' => 'nullable|string',
            'highlights' => 'nullable|array',
        ]);

        $route = TrekkingRoute::create($validated);
        return response()->json($route, 201);
    }

    public function show($identifier)
    {
        // Find by slug or ID
        $q = TrekkingRoute::with(['itineraryDays', 'departures' => function($query) {
            $query->where('departure_date', '>=', now())
                  ->where('status', '!=', 'Full')
                  ->orderBy('departure_date');
        }]);

        $route = $q->where('slug', $identifier)->orWhere('id', $identifier)->first();

        if (!$route) {
            // Backward compatibility: allow short slugs like "machame" to match "machame-<id>" seeded routes.
            $route = $q->where('slug', 'like', (string)$identifier . '-%')->orderBy('id')->first();
        }

        if (!$route) {
            abort(404);
        }

        return response()->json($route);
    }

    public function update(Request $request, $id)
    {
        $route = TrekkingRoute::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'string|max:255',
            'slug' => 'string|unique:trekking_routes,slug,' . $id,
            'meta_badge' => 'nullable|string',
            'description' => 'nullable|string',
            'difficulty' => 'nullable|string',
            'duration' => 'nullable|integer',
            'distance' => 'nullable|string',
            'elevation_gain' => 'nullable|string',
            'base_price' => 'nullable|numeric',
            'max_group_size' => 'nullable|integer',
            'hero_image' => 'nullable|string',
            'success_rate' => 'nullable|string',
            'highlights' => 'nullable|array',
        ]);

        $route->update($validated);
        return response()->json($route);
    }

    public function destroy($id)
    {
        $route = TrekkingRoute::findOrFail($id);
        $route->delete();
        return response()->json(null, 204);
    }
}
