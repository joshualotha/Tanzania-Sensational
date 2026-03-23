<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisualAsset;

class StaticAssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = [
            // Branding
            ['section' => 'branding', 'key' => 'logo', 'url' => '/logo.png'],
            ['section' => 'branding', 'key' => 'favicon', 'url' => '/favicon.ico'],

            // Common
            ['section' => 'common', 'key' => 'bentoPattern', 'url' => 'https://www.transparenttextures.com/patterns/stardust.png'],
            ['section' => 'common', 'key' => 'placeholderHero', 'url' => 'https://images.unsplash.com/photo-1547970810-dc1eac37d174?q=80&w=2000&auto=format&fit=crop'],

            // Home
            ['section' => 'home', 'key' => 'hero', 'url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-1.2.1&auto=format&fit=crop&w=2400&q=90'],
            ['section' => 'home', 'key' => 'experienceMain', 'url' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=800&q=85&auto=format&fit=crop'],
            ['section' => 'home', 'key' => 'experienceSecondary', 'url' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=600&q=85&auto=format&fit=crop'],
            ['section' => 'home', 'key' => 'extensionSerengeti', 'url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'],
            ['section' => 'home', 'key' => 'extensionZanzibar', 'url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'],
            ['section' => 'home', 'key' => 'ctaBg', 'url' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?q=80&w=2000&auto=format&fit=crop'],

            // About
            ['section' => 'about', 'key' => 'hero', 'url' => 'https://images.unsplash.com/photo-1621414050946-1b936a78490b?q=80&w=2000&auto=format&fit=crop'],
            ['section' => 'about', 'key' => 'legacy', 'url' => 'https://images.unsplash.com/photo-1631646109206-4919df38eb68?q=80&w=800&auto=format&fit=crop'],
            ['section' => 'about', 'key' => 'experienceBand', 'url' => 'https://images.unsplash.com/photo-1650668302197-7f556c34cb91?q=80&w=2000&auto=format&fit=crop'],

            // Zanzibar
            ['section' => 'zanzibar', 'key' => 'hero', 'url' => 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?ixlib=rb-4.0.3&auto=format&fit=crop&w=2400&q=80'],
            ['section' => 'zanzibar', 'key' => 'regionStoneTown', 'url' => 'https://images.unsplash.com/photo-1580979878201-1e9d1a3eb64f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80'],
            ['section' => 'zanzibar', 'key' => 'regionNungwi', 'url' => 'https://images.unsplash.com/photo-1621845184551-bb5e7141ecf4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80'],
            ['section' => 'zanzibar', 'key' => 'regionPaje', 'url' => 'https://images.unsplash.com/photo-1579471923053-ec4f6762edbc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80'],
            ['section' => 'zanzibar', 'key' => 'expSpice', 'url' => 'https://images.unsplash.com/photo-1606041008023-472dfb5e530f?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80'],
            ['section' => 'zanzibar', 'key' => 'expSafariBlue', 'url' => 'https://images.unsplash.com/photo-1533221375330-84c6af70ce9b?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80'],
            ['section' => 'zanzibar', 'key' => 'expPrisonIsland', 'url' => 'https://images.unsplash.com/photo-1437622368342-7a3d73a40cfa?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80'],

            // Planning
            ['section' => 'planning', 'key' => 'meruHero', 'url' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'],
            ['section' => 'planning', 'key' => 'gearHero', 'url' => 'https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'],
            ['section' => 'planning', 'key' => 'trainingHero', 'url' => 'https://images.unsplash.com/photo-1551698618-1dfe5d97d256?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'],
            ['section' => 'planning', 'key' => 'faqHero', 'url' => 'https://images.unsplash.com/photo-1589308454676-e1af9491a670?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'],
            ['section' => 'planning', 'key' => 'addonsHero', 'url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'],

            // Trekking Sections
            ['section' => 'trekking.routes', 'key' => 'lemoshoEditorial', 'url' => 'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80'],
            ['section' => 'trekking.routes', 'key' => 'machameEditorial', 'url' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80'],
            ['section' => 'trekking.routes', 'key' => 'maranguEditorial', 'url' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80'],
            ['section' => 'trekking.routes', 'key' => 'northernEditorial', 'url' => 'https://images.unsplash.com/photo-1542332213-9b5a5a3fad35?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80'],

            // Trekking Prep
            ['section' => 'trekking.prep', 'key' => 'bestTime', 'url' => 'https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'],
            ['section' => 'trekking.prep', 'key' => 'bestRoutes', 'url' => 'https://images.unsplash.com/photo-1589182397057-b82b16867e7c?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'],
            ['section' => 'trekking.prep', 'key' => 'whyUs', 'url' => 'https://images.unsplash.com/photo-1650668302197-7f556c34cb91?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'],
            ['section' => 'trekking.prep', 'key' => 'tippingHero', 'url' => 'https://images.unsplash.com/photo-1579471923053-ec4f6762edbc?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'],

            // Safaris
            ['section' => 'safaris', 'key' => 'listHero', 'url' => 'https://images.unsplash.com/photo-1516422213484-2af298bf06ad?auto=format&fit=crop&q=80'],
            ['section' => 'safaris', 'key' => 'migrationHero', 'url' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=2000&q=85&auto=format&fit=crop'],

            // Destinations
            ['section' => 'destinations', 'key' => 'serengetiHero', 'url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=2000&q=85&auto=format&fit=crop'],
            ['section' => 'destinations', 'key' => 'ngorongoroHero', 'url' => 'https://images.unsplash.com/photo-1518173335487-347a0e39129d?w=2000&q=85&auto=format&fit=crop'],
            ['section' => 'destinations', 'key' => 'tarangireHero', 'url' => 'https://images.unsplash.com/photo-1581852015102-142a2c317022?w=2000&q=85&auto=format&fit=crop'],

            // Gallery items from Serengeti
            ['section' => 'destinations.gallery', 'key' => 'serengeti-1', 'url' => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&q=80'],
            ['section' => 'destinations.gallery', 'key' => 'serengeti-2', 'url' => 'https://images.unsplash.com/photo-1534177616072-ef7dc120449d?w=800&q=80'],
            ['section' => 'destinations.gallery', 'key' => 'serengeti-3', 'url' => 'https://images.unsplash.com/photo-1581852015102-142a2c317022?w=800&q=80'],

            // Booking
            ['section' => 'booking', 'key' => 'hero', 'url' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=2000&q=80'],

            // Contact
            ['section' => 'contact', 'key' => 'luxuryBg', 'url' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=2000&auto=format&fit=crop'],
        ];

        foreach ($assets as $asset) {
            VisualAsset::updateOrCreate(
                ['key' => $asset['key']],
                [
                    'section' => $asset['section'],
                    'url' => $asset['url'],
                    'type' => 'image',
                    'metadata' => ['is_static' => true]
                ]
            );
        }
    }
}
