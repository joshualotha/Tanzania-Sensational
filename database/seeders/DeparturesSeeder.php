<?php

namespace Database\Seeders;

use App\Models\Departure;
use App\Models\TrekkingRoute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DeparturesSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(storage_path('app/data_export/departures.json'));
        $departures = json_decode($json, true);

        foreach ($departures as $dep) {
            // Find route by name (e.g. "8-Day Lemosho Route" -> "8 Days Lemosho Route")
            $searchTitle = str_replace('-Day', ' Days', $dep['route']);
            
            $route = TrekkingRoute::where('name', 'like', "%{$searchTitle}%")
                                 ->orWhere('name', 'like', '%' . explode(' ', $dep['route'])[0] . '%')
                                 ->first();

            if (!$route) {
                $route = TrekkingRoute::first(); // Fallback
            }

            // Parse date "July 12 - July 20, 2026" or "August 04 - August 12, 2026"
            $dateString = explode(' - ', $dep['date'])[0] . ', ' . substr($dep['date'], -4);
            try {
                $departureDate = Carbon::parse($dateString);
            } catch (\Exception $e) {
                $departureDate = Carbon::now()->addMonths(3);
            }

            // Price cleanup (e.g., "$2,850" to 285000)
            $price = (int) filter_var($dep['price'], FILTER_SANITIZE_NUMBER_INT) * 100;

            Departure::create([
                'trekking_route_id' => $route->id,
                'departure_date' => $departureDate,
                'return_date' => null,
                'price_cents' => $price,
                'available_seats' => 12,
                'booked_seats' => 12 - (int) $dep['spotsLeft'],
                'status' => $dep['status'],
                'summit_night' => $dep['summitNight'],
                'meeting_point' => $dep['meetingPoint'],
                'briefing_date' => $dep['briefingDate'],
                'description' => $dep['description'],
                'inclusions' => $dep['inclusions'],
                'exclusions' => $dep['exclusions']
            ]);
        }
    }
}
