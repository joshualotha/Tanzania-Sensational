<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Seeder;

class DestinationsSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(storage_path('app/data_export/destinations.json'));
        $destinations = json_decode($json, true);

        foreach ($destinations as $dest) {
            Destination::create([
                'slug' => $dest['id'],
                'name' => $dest['name'],
                'meta_subtitle' => $dest['subtitle'] ?? null,
                'meta_tag' => $dest['tag'] ?? null,
                'overview' => $dest['overview'],
                'meta_quote' => $dest['overviewQuote'] ?? null,
                'hero_image' => $dest['heroImg'],
                'meta_coordinates' => $dest['coordinates'] ?? null,
                'meta_elevation' => $dest['elevation'] ?? null,
                'best_time' => $dest['bestTime'] ?? null,
                'meta_encounter_rate' => $dest['encounterRate'] ?? null,
                'meta_tier' => $dest['expeditionTier'] ?? null,
                'meta_tracking' => $dest['trackingMethod'] ?? null,
                'highlights' => $dest['highlights'] ?? [],
                'gallery' => $dest['gallery'] ?? [],
                'atmosphere_vitals' => $dest['atmosphereVitals'] ?? [],
                'atmosphere_footer' => $dest['atmosphereFooter'] ?? null,
                'wildlife_vitals' => $dest['wildlifeVitals'] ?? [],
                'wildlife_footer' => $dest['wildlifeFooter'] ?? null,
            ]);
        }
    }
}
