<?php

namespace App\Services;

use App\Models\PricingRule;
use App\Models\TrekkingRoute;
use Carbon\Carbon;

class PricingService
{
    /**
     * Calculate price for a private trek based on route, date and group size.
     */
    public function calculatePrivatePrice(TrekkingRoute $route, $dateStr, int $groupSize)
    {
        $date = Carbon::parse($dateStr);
        $month = $date->month;

        // Determine Peak or Low Season
        $season = 'low';
        // Peak seasons: July, August, September, December, January, February
        if (in_array($month, [7, 8, 9, 12, 1, 2])) {
            $season = 'peak';
        } elseif (in_array($month, [6, 10])) {
            $season = 'shoulder';
        }

        // Fetch rule
        $rule = PricingRule::where('trekking_route_id', $route->id)
            ->where('season', $season)
            ->where('min_group_size', '<=', $groupSize)
            ->where('max_group_size', '>=', $groupSize)
            ->first();

        // If no exact match for group size or season, fallback logic
        if (!$rule) {
            $rule = PricingRule::where('trekking_route_id', $route->id)
                ->orderBy('price_per_person_cents', 'desc')
                ->first();
        }

        if (!$rule) {
            // Default flat rate assumption if no pricing rules defined
            return 250000; // $2500
        }

        return $rule->price_per_person_cents;
    }
}
