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
        // Clean up first
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Departure::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $json = file_get_contents(storage_path('app/data_export/departures.json'));
        $departures = json_decode($json, true);

        // Track which routes have departures already
        $routesWithDepartures = [];

        foreach ($departures as $dep) {
            // Find route by name (e.g. "8-Day Lemosho Route" -> "8 Days Lemosho Route")
            $searchTitle = str_replace('-Day', ' Days', $dep['route']);
            
            $route = TrekkingRoute::where('name', 'like', "%{$searchTitle}%")
                                 ->orWhere('name', 'like', '%' . explode(' ', $dep['route'])[0] . '%')
                                 ->first();

            if (!$route) {
                continue; // Skip if no match found for this JSON entry
            }

            $routesWithDepartures[$route->id] = true;

            // Parse date "July 12 - July 20, 2026" or "August 04 - August 12, 2026"
            $dateString = explode(' - ', $dep['date'])[0] . ', ' . substr($dep['date'], -4);
            try {
                $departureDate = Carbon::parse($dateString);
            } catch (\Exception $e) {
                $departureDate = Carbon::now()->addMonths(rand(2, 6));
            }

            // Price cleanup (e.g., "$2,850" to 285000)
            $price = (int) filter_var($dep['price'], FILTER_SANITIZE_NUMBER_INT) * 100;

            Departure::create([
                'trekking_route_id' => $route->id,
                'departure_date' => $departureDate,
                'return_date' => $departureDate->copy()->addDays($route->duration),
                'price_cents' => $price,
                'total_seats' => 12,
                'booked_seats' => 12 - (int)$dep['spotsLeft'],
                'held_seats' => 0,
                'available_seats' => (int)$dep['spotsLeft'],
                'status' => $dep['status'] ?? 'Available',
                'summit_night' => $dep['summitNight'] ?? $departureDate->copy()->addDays($route->duration - 1)->format('F j, Y'),
                'meeting_point' => $dep['meetingPoint'] ?? 'Kilimanjaro International Airport (JRO)',
                'briefing_date' => $dep['briefingDate'] ?? $departureDate->copy()->subDay()->format('F j, Y, 6:00 PM'),
                'description' => $dep['description'] ?? "Join our expert-led expedition on the spectacular {$route->name}.",
                'inclusions' => $dep['inclusions'] ?? null,
                'exclusions' => $dep['exclusions'] ?? null
            ]);
        }

        // Now generate sample departures for ANY route that doesn't have one
        $allRoutes = TrekkingRoute::all();
        foreach ($allRoutes as $route) {
            if (!isset($routesWithDepartures[$route->id])) {
                // Create 2 future departures
                for ($i = 1; $i <= 2; $i++) {
                    $departureDate = Carbon::now()->addMonths($i * 2)->addDays(rand(1, 28));
                    $booked = rand(2, 8);
                    
                    Departure::create([
                        'trekking_route_id' => $route->id,
                        'departure_date' => $departureDate,
                        'return_date' => $departureDate->copy()->addDays($route->duration),
                        'price_cents' => (int)($route->base_price * 100),
                        'total_seats' => 12,
                        'booked_seats' => $booked,
                        'held_seats' => 0,
                        'available_seats' => 12 - $booked,
                        'status' => 'Available',
                        'summit_night' => $departureDate->copy()->addDays($route->duration - 1)->format('F j, Y'),
                        'meeting_point' => 'Kilimanjaro International Airport (JRO)',
                        'briefing_date' => $departureDate->copy()->subDay()->format('F j, Y, 6:00 PM'),
                        'description' => "An exclusive group departure for the {$route->name}. Experience premium service on the roof of Africa.",
                        'inclusions' => [
                            "All park entry and camping fees",
                            "Professional mountain guides & porters",
                            "3 meals per day on mountain + snacks",
                            "Private portable toilet",
                            "Emergency oxygen and first aid kit",
                            "Airport transfers (JRO)",
                            "Pre-climb hotel night in Moshi"
                        ],
                        'exclusions' => [
                            "International flights",
                            "Travel insurance",
                            "Personal trekking gear",
                            "Gratuities (~$200-300 pp)"
                        ]
                    ]);
                }
            }
        }
    }
}
