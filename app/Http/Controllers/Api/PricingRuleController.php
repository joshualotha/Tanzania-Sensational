<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PricingRule;
use App\Models\TrekkingRoute;
use Illuminate\Http\Request;

class PricingRuleController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'trekking_route_id' => 'nullable|integer|exists:trekking_routes,id',
        ]);

        $routes = TrekkingRoute::query()
            ->when(!empty($validated['trekking_route_id'] ?? null), function ($q) use ($validated) {
                $q->where('id', (int)$validated['trekking_route_id']);
            })
            ->with(['pricingRules' => function ($q) {
                $q->orderByRaw("CASE season WHEN 'peak' THEN 1 WHEN 'shoulder' THEN 2 WHEN 'low' THEN 3 ELSE 4 END")
                    ->orderBy('min_group_size')
                    ->orderBy('max_group_size');
            }])
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'base_price']);

        return response()->json([
            'routes' => $routes,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'trekking_route_id' => 'required|integer|exists:trekking_routes,id',
            'season' => 'required|in:peak,shoulder,low',
            'min_group_size' => 'required|integer|min:1|max:20',
            'max_group_size' => 'required|integer|min:1|max:20|gte:min_group_size',
            'price_per_person_cents' => 'required|integer|min:0',
        ]);

        $rule = new PricingRule();
        $rule->fill($validated);
        $rule->save();

        return response()->json($rule, 201);
    }

    public function update(Request $request, $id)
    {
        $rule = PricingRule::findOrFail($id);

        $validated = $request->validate([
            'season' => 'sometimes|required|in:peak,shoulder,low',
            'min_group_size' => 'sometimes|required|integer|min:1|max:20',
            'max_group_size' => 'sometimes|required|integer|min:1|max:20',
            'price_per_person_cents' => 'sometimes|required|integer|min:0',
        ]);

        if (isset($validated['min_group_size']) && isset($validated['max_group_size']) && $validated['max_group_size'] < $validated['min_group_size']) {
            return response()->json(['message' => 'max_group_size must be >= min_group_size'], 422);
        }

        $rule->fill($validated);
        $rule->save();

        return response()->json($rule);
    }

    public function destroy($id)
    {
        $rule = PricingRule::findOrFail($id);
        $rule->delete();
        return response()->json(['ok' => true]);
    }
}

