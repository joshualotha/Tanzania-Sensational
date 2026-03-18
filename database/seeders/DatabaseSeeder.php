<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            TrekkingRoutesSeeder::class,
            PricingRulesSeeder::class,
            DeparturesSeeder::class,
            SafarisSeeder::class,
            DestinationsSeeder::class,
            PagesSeeder::class,
            BlogPostsSeeder::class,
            VisualAssetsSeeder::class,
        ]);
    }
}
