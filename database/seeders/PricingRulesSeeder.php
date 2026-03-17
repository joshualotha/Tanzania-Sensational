<?php

namespace Database\Seeders;

use App\Models\PricingRule;
use App\Models\TrekkingRoute;
use Illuminate\Database\Seeder;

class PricingRulesSeeder extends Seeder
{
    public function run(): void
    {
        $tiers = [
            ['min' => 1, 'max' => 2, 'group_multiplier' => 1.20],
            ['min' => 3, 'max' => 5, 'group_multiplier' => 1.00],
            ['min' => 6, 'max' => 20, 'group_multiplier' => 0.90],
        ];

        $seasons = [
            'peak' => 1.15,
            'shoulder' => 1.05,
            'low' => 1.00,
        ];

        foreach (TrekkingRoute::query()->get(['id', 'base_price']) as $route) {
            $baseDollars = (float)($route->base_price ?: 2500);
            $baseCents = (int)round($baseDollars * 100);

            foreach ($seasons as $season => $seasonMultiplier) {
                foreach ($tiers as $tier) {
                    $cents = (int)round($baseCents * $seasonMultiplier * $tier['group_multiplier']);

                    PricingRule::updateOrCreate(
                        [
                            'trekking_route_id' => $route->id,
                            'season' => $season,
                            'min_group_size' => $tier['min'],
                            'max_group_size' => $tier['max'],
                        ],
                        [
                            'price_per_person_cents' => $cents,
                        ]
                    );
                }
            }
        }
    }
}

