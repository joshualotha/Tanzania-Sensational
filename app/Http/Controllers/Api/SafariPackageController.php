<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SafariPackage;
use Illuminate\Http\Request;

class SafariPackageController extends Controller
{
    public function index()
    {
        return response()->json(SafariPackage::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:safari_packages,slug',
            'duration' => 'required|integer',
            'description' => 'required|string',
            'base_price' => 'required|numeric',
            'category' => 'nullable|string',
            'meta_tag' => 'nullable|string',
            'hero_image' => 'nullable|string',
            'itinerary' => 'nullable|array',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
        ]);

        $safari = SafariPackage::create($validated);
        return response()->json($safari, 201);
    }

    public function show($identifier)
    {
        $safari = SafariPackage::where('slug', $identifier)
            ->orWhere('id', $identifier)
            ->firstOrFail();

        return response()->json($safari);
    }

    public function update(Request $request, $id)
    {
        $safari = SafariPackage::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'string|max:255',
            'slug' => 'string|unique:safari_packages,slug,' . $id,
            'duration' => 'integer',
            'description' => 'string',
            'base_price' => 'numeric',
            'category' => 'nullable|string',
            'meta_tag' => 'nullable|string',
            'hero_image' => 'nullable|string',
            'itinerary' => 'nullable|array',
            'inclusions' => 'nullable|array',
            'exclusions' => 'nullable|array',
        ]);

        $safari->update($validated);
        return response()->json($safari);
    }

    public function destroy($id)
    {
        $safari = SafariPackage::findOrFail($id);
        $safari->delete();
        return response()->json(null, 204);
    }
}
