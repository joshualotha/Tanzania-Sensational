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
            DestinationsSeeder::class,
            TrekkingRoutesSeeder::class,
            PricingRulesSeeder::class,
            DeparturesSeeder::class,
            SafarisSeeder::class,
            PagesSeeder::class,
            BlogPostsSeeder::class,
            StaticAssetsSeeder::class,
        ]);
    }
}
