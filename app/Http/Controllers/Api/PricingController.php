<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrekkingRoute;
use App\Services\PricingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PricingController extends Controller
{
    public function trekking(Request $request, PricingService $pricingService)
    {
        $validated = $request->validate([
            'route_id' => 'nullable|integer|exists:trekking_routes,id',
            'route_slug' => 'nullable|string|exists:trekking_routes,slug',
            'date' => 'required|date',
            'group_size' => 'required|integer|min:1|max:20',
        ]);

        $route = null;
        if (!empty($validated['route_id'])) {
            $route = TrekkingRoute::findOrFail($validated['route_id']);
        } else {
            $route = TrekkingRoute::where('slug', $validated['route_slug'])->firstOrFail();
        }

        $cacheKey = "pricing:trekking:{$route->id}:" . $validated['date'] . ":" . $validated['group_size'];

        $pricePerPersonCents = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($pricingService, $route, $validated) {
            return (int)$pricingService->calculatePrivatePrice($route, $validated['date'], (int)$validated['group_size']);
        });

        return response()->json([
            'route_id' => $route->id,
            'route_slug' => $route->slug,
            'date' => $validated['date'],
            'group_size' => (int)$validated['group_size'],
            'price_per_person_cents' => $pricePerPersonCents,
            'price_per_person' => round($pricePerPersonCents / 100, 2),
        ]);
    }
}

