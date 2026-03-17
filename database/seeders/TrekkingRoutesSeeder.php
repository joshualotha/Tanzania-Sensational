<?php

namespace Database\Seeders;

use App\Models\RouteItineraryDay;
use App\Models\TrekkingRoute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TrekkingRoutesSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(storage_path('app/data_export/packages.json'));
        $packages = json_decode($json, true);

        foreach ($packages as $pkg) {
            $slug = $pkg['routeId'] . '-' . $pkg['id'];
            
            $route = TrekkingRoute::create([
                'name' => $pkg['title'],
                'slug' => Str::slug($slug),
                'meta_badge' => $pkg['badge'] ?? null,
                'description' => $pkg['overview'],
                'difficulty' => $pkg['difficulty'] ?? 'Moderate',
                'duration' => (int) filter_var($pkg['duration'], FILTER_SANITIZE_NUMBER_INT),
                'distance' => null,
                'elevation_gain' => null,
                'base_price' => isset($pkg['price']) ? (float) filter_var($pkg['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 0,
                'max_group_size' => 12,
                'hero_image' => $pkg['heroImg'],
                'success_rate' => $pkg['successRate'] ?? null,
                'highlights' => $pkg['highlights'] ?? []
            ]);

            foreach ($pkg['itinerary'] as $day) {
                RouteItineraryDay::create([
                    'trekking_route_id' => $route->id,
                    'day_number' => $day['day'],
                    'title' => $day['title'],
                    'description' => $day['desc'],
                    'elevation' => $day['elevation'] ?? null,
                    'distance' => $day['distance'] ?? null,
                    'hiking_time' => $day['hikingTime'] ?? null,
                    'habitat' => $day['habitat'] ?? null,
                    'accommodation' => $day['accommodation'] ?? null,
                    'meals' => $day['meals'] ?? null,
                ]);
            }
        }
    }
}
