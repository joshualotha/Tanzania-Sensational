<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index()
    {
        return response()->json(Destination::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|string|unique:destinations,slug',
            'name' => 'required|string|max:255',
            'meta_subtitle' => 'nullable|string',
            'meta_tag' => 'nullable|string',
            'overview' => 'nullable|string',
            'meta_quote' => 'nullable|string',
            'hero_image' => 'nullable|string',
            'meta_coordinates' => 'nullable|string',
            'meta_elevation' => 'nullable|string',
            'best_time' => 'nullable|string',
            'meta_encounter_rate' => 'nullable|string',
            'meta_tier' => 'nullable|string',
            'meta_tracking' => 'nullable|string',
            'highlights' => 'nullable|array',
            'gallery' => 'nullable|array',
            'atmosphere_vitals' => 'nullable|array',
            'atmosphere_footer' => 'nullable|string',
            'wildlife_vitals' => 'nullable|array',
            'wildlife_footer' => 'nullable|string',
        ]);

        $destination = Destination::create($validated);
        return response()->json($destination, 201);
    }

    public function show($identifier)
    {
        $destination = Destination::where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();

        return response()->json($destination);
    }

    public function update(Request $request, $id)
    {
        $destination = Destination::findOrFail($id);
        
        $validated = $request->validate([
            'slug' => 'string|unique:destinations,slug,' . $id,
            'name' => 'string|max:255',
            'meta_subtitle' => 'nullable|string',
            'meta_tag' => 'nullable|string',
            'overview' => 'nullable|string',
            'meta_quote' => 'nullable|string',
            'hero_image' => 'nullable|string',
            'meta_coordinates' => 'nullable|string',
            'meta_elevation' => 'nullable|string',
            'best_time' => 'nullable|string',
            'meta_encounter_rate' => 'nullable|string',
            'meta_tier' => 'nullable|string',
            'meta_tracking' => 'nullable|string',
            'highlights' => 'nullable|array',
            'gallery' => 'nullable|array',
            'atmosphere_vitals' => 'nullable|array',
            'atmosphere_footer' => 'nullable|string',
            'wildlife_vitals' => 'nullable|array',
            'wildlife_footer' => 'nullable|string',
        ]);

        $destination->update($validated);
        return response()->json($destination);
    }

    public function destroy($id)
    {
        $destination = Destination::findOrFail($id);
        $destination->delete();
        return response()->json(null, 204);
    }
}
