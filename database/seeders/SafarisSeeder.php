<?php

namespace Database\Seeders;

use App\Models\SafariPackage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SafarisSeeder extends Seeder
{
    public function run(): void
    {
        $json = file_get_contents(storage_path('app/data_export/safaris.json'));
        $safaris = json_decode($json, true);

        foreach ($safaris as $safari) {
            SafariPackage::create([
                'name' => $safari['title'],
                'slug' => $safari['id'] ?? Str::slug($safari['title']),
                'category' => $safari['badge'] ?? 'SIGNATURE',
                'meta_tag' => isset($safari['parks']) ? ($safari['duration'] . ' · ' . $safari['parks']) : null,
                'duration' => (int) filter_var($safari['duration'], FILTER_SANITIZE_NUMBER_INT),
                'description' => $safari['overview'],
                'hero_image' => $safari['heroImg'],
                'base_price' => isset($safari['price']) ? (float) filter_var($safari['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 0,
                'inclusions' => $safari['inclusions'] ?? [],
                'exclusions' => $safari['exclusions'] ?? [],
                'itinerary' => $safari['itinerary'] ?? []
            ]);
        }
    }
}
