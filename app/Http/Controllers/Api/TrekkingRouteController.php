<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrekkingRoute;
use Illuminate\Http\Request;

class TrekkingRouteController extends Controller
{
    public function index()
    {
        return response()->json(TrekkingRoute::with('itineraryDays')->orderBy('id', 'desc')->get());
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
            'editorial_image' => 'nullable|string',
            'editorial_image_2' => 'nullable|string',
            'editorial_content' => 'nullable|string',
            'success_rate' => 'nullable|string',
            'highlights' => 'nullable|array',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
        ]);

        $route = TrekkingRoute::create($validated);

        if ($request->has('itinerary')) {
            $days = $request->input('itinerary');
            foreach ($days as $index => $dayData) {
                $route->itineraryDays()->create([
                    'day_number' => $index + 1,
                    'title' => $dayData['title'] ?? '',
                    'description' => $dayData['description'] ?? null,
                    'elevation' => $dayData['elevation_m'] ?? $dayData['elevation'] ?? null,
                    'distance' => $dayData['distance_km'] ?? $dayData['distance'] ?? null,
                    'hiking_time' => $dayData['hiking_time'] ?? null,
                    'habitat' => $dayData['habitat'] ?? null,
                    'accommodation' => $dayData['camp_name'] ?? $dayData['accommodation'] ?? null,
                    'meals' => $dayData['meals'] ?? null,
                ]);
            }
        }

        return response()->json($route->load('itineraryDays'), 201);
    }

    public function show($identifier)
    {
        // Find by slug or ID
        $route = TrekkingRoute::with(['itineraryDays', 'departures' => function($query) {
            $query->where('departure_date', '>=', now())
                  ->where('status', '!=', 'Full')
                  ->orderBy('departure_date');
        }])->where('slug', $identifier)->orWhere('id', $identifier)->first();

        if (!$route) {
            // Backward compatibility: allow short slugs like "machame" to match "machame-7-days"
            $route = TrekkingRoute::with(['itineraryDays', 'departures' => function($query) {
                $query->where('departure_date', '>=', now())
                      ->where('status', '!=', 'Full')
                      ->orderBy('departure_date');
            }])->where('slug', 'like', (string)$identifier . '-%')->orderBy('id')->first();
        }

        if (!$route) {
            abort(404);
        }

        // Attach all sibling variations (packages) for this base route
        // Extract the base slug by removing the trailing "-N-days" or "-N-days-crater" portion
        // e.g. "lemosho-7-days" -> "lemosho", "northern-circuit-8-days" -> "northern-circuit", "mt-meru-3-days" -> "mt-meru"
        $baseSlug = preg_replace('/-\d+-days(-crater)?$/', '', $route->slug);
        $variations = TrekkingRoute::where('slug', 'like', $baseSlug . '-%')
            ->orderBy('duration')
            ->get(['id', 'name', 'slug', 'duration', 'difficulty', 'base_price', 'success_rate', 'hero_image', 'editorial_image', 'editorial_image_2', 'editorial_content', 'meta_badge', 'description', 'highlights']);

        $routeData = $route->toArray();
        $routeData['variations'] = $variations;

        return response()->json($routeData);
    }

    public function update(Request $request, $id)
    {
        \Log::info('Updating trekking route', ['id' => $id, 'data' => $request->all()]);
        
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
            'editorial_image' => 'nullable|string',
            'editorial_image_2' => 'nullable|string',
            'editorial_content' => 'nullable|string',
            'success_rate' => 'nullable|string',
            'highlights' => 'nullable|array',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
        ]);

        \Log::info('Validated data', $validated);
        \Log::info('Before update', [
            'editorial_image' => $route->editorial_image,
            'editorial_image_2' => $route->editorial_image_2
        ]);

        $route->update($validated);
        
        \Log::info('After update', [
            'editorial_image' => $route->editorial_image,
            'editorial_image_2' => $route->editorial_image_2
        ]);

        if ($request->has('itinerary')) {
            $route->itineraryDays()->delete();
            $days = $request->input('itinerary');
            foreach ($days as $index => $dayData) {
                $route->itineraryDays()->create([
                    'day_number' => $index + 1,
                    'title' => $dayData['title'] ?? '',
                    'description' => $dayData['description'] ?? null,
                    'elevation' => $dayData['elevation_m'] ?? $dayData['elevation'] ?? null,
                    'distance' => $dayData['distance_km'] ?? $dayData['distance'] ?? null,
                    'hiking_time' => $dayData['hiking_time'] ?? null,
                    'habitat' => $dayData['habitat'] ?? null,
                    'accommodation' => $dayData['camp_name'] ?? $dayData['accommodation'] ?? null,
                    'meals' => $dayData['meals'] ?? null,
                ]);
            }
        }

        return response()->json($route->load('itineraryDays'));
    }

    public function destroy($id)
    {
        $route = TrekkingRoute::findOrFail($id);
        $route->delete();
        return response()->json(null, 204);
    }
}
