<?php

namespace Database\Seeders;

use App\Models\Destination;
use App\Models\SafariPackage;
use App\Models\TrekkingRoute;
use Illuminate\Database\Seeder;

class MetaDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedTrekkingRoutes();
        $this->seedSafariPackages();
        $this->seedDestinations();

        $this->command->info('Meta titles and descriptions seeded successfully.');
    }

    private function seedTrekkingRoutes(): void
    {
        $meta = [
            'lemosho-7-days' => [
                'meta_title' => 'Lemosho Route 7 Days | Kilimanjaro Trekking | Tanzania Sensational',
                'meta_description' => 'Trek the scenic Lemosho Route on Kilimanjaro in 7 days. High success rate, stunning Shira Plateau views. Book your 7-day Lemosho trek with expert guides.',
            ],
            'lemosho-8-days' => [
                'meta_title' => 'Lemosho Route 8 Days | Kilimanjaro Trekking | Tanzania Sensational',
                'meta_description' => 'Experience the Lemosho Route on Kilimanjaro in 8 days with extra acclimatization. Highest success rate route via the scenic Shira Plateau. Book your 8-day trek.',
            ],
            'machame-6-days' => [
                'meta_title' => 'Machame Route 6 Days | Kilimanjaro Whiskey Route | Tanzania Sensational',
                'meta_description' => 'Conquer Kilimanjaro via the Machame Route in 6 days. The scenic Whiskey Route with stunning views and great acclimatization. Book your 6-day Machame trek.',
            ],
            'machame-7-days' => [
                'meta_title' => 'Machame Route 7 Days | Kilimanjaro Whiskey Route | Tanzania Sensational',
                'meta_description' => 'Trek the Machame Route on Kilimanjaro in 7 days with optimal acclimatization. Stunning scenery via the Whiskey Route. Book your 7-day Machame adventure.',
            ],
            'marangu-5-days' => [
                'meta_title' => 'Marangu Route 5 Days | Kilimanjaro Coca-Cola Route | Tanzania Sensational',
                'meta_description' => 'Climb Kilimanjaro via the Marangu Route in 5 days. The only route with hut accommodation — the classic Coca-Cola Route. Book your 5-day Marangu trek.',
            ],
            'marangu-6-days' => [
                'meta_title' => 'Marangu Route 6 Days | Kilimanjaro Coca-Cola Route | Tanzania Sensational',
                'meta_description' => 'Trek the Marangu Route on Kilimanjaro in 6 days with extra acclimatization. Hut accommodation, stunning views. Book your 6-day Coca-Cola Route trek.',
            ],
            'rongai-6-days' => [
                'meta_title' => 'Rongai Route 6 Days | Kilimanjaro Northern Route | Tanzania Sensational',
                'meta_description' => 'Climb Kilimanjaro via the remote Rongai Route in 6 days. The only northern approach with wilderness solitude. Book your 6-day Rongai trekking adventure.',
            ],
            'rongai-7-days' => [
                'meta_title' => 'Rongai Route 7 Days | Kilimanjaro Northern Route | Tanzania Sensational',
                'meta_description' => 'Trek the Rongai Route on Kilimanjaro in 7 days with excellent acclimatization. Remote northern approach, fewer crowds. Book your 7-day Rongai climb.',
            ],
            'northern-circuit-8-days' => [
                'meta_title' => 'Northern Circuit 8 Days | Kilimanjaro Trekking | Tanzania Sensational',
                'meta_description' => 'Experience the Northern Circuit on Kilimanjaro in 8 days. The longest route with 360° views and highest success rate. Book your 8-day Northern Circuit trek.',
            ],
            'northern-circuit-9-days' => [
                'meta_title' => 'Northern Circuit 9 Days | Kilimanjaro Trekking | Tanzania Sensational',
                'meta_description' => 'Trek the Northern Circuit on Kilimanjaro in 9 days — our best acclimatization route. 360° views, highest summit success. Book your 9-day Northern Circuit.',
            ],
            'umbwe-6-days' => [
                'meta_title' => 'Umbwe Route 6 Days | Kilimanjaro Challenging Route | Tanzania Sensational',
                'meta_description' => 'Conquer Kilimanjaro via the challenging Umbwe Route in 6 days. The steepest, most direct path for experienced trekkers. Book your Umbwe adventure.',
            ],
            'umbwe-7-days' => [
                'meta_title' => 'Umbwe Route 7 Days | Kilimanjaro Challenging Route | Tanzania Sensational',
                'meta_description' => 'Trek the Umbwe Route on Kilimanjaro in 7 days with better acclimatization. Steep, direct, and rewarding. Book your 7-day Umbwe climb with expert guides.',
            ],
            'lemosho-8-days-crater' => [
                'meta_title' => 'Lemosho Route 8 Days with Crater Camp | Kilimanjaro | Tanzania Sensational',
                'meta_description' => 'Ultimate Lemosho Route with Crater Camp overnight on Kilimanjaro. 8 days of trekking plus summit crater stay. Book this exclusive Kilimanjaro experience.',
            ],
            'northern-circuit-9-days-crater' => [
                'meta_title' => 'Northern Circuit 9 Days with Crater Camp | Kilimanjaro | Tanzania Sensational',
                'meta_description' => 'Premium Northern Circuit with Crater Camp overnight on Kilimanjaro. 9 days, 360° views, summit crater stay. Book this once-in-a-lifetime trek.',
            ],
            'mt-meru-3-days' => [
                'meta_title' => 'Mount Meru Climb 3 Days | Arusha Trekking | Tanzania Sensational',
                'meta_description' => 'Climb Mount Meru in 3 days — Tanzania\'s second-highest peak. Stunning views of Kilimanjaro, wildlife in Arusha National Park. Book your Meru trek.',
            ],
            'mt-meru-4-days' => [
                'meta_title' => 'Mount Meru Climb 4 Days | Arusha Trekking | Tanzania Sensational',
                'meta_description' => 'Trek Mount Meru in 4 days with optimal acclimatization. Tanzania\'s second-highest peak with incredible Kilimanjaro views. Book your 4-day Meru climb.',
            ],
        ];

        foreach ($meta as $slug => $data) {
            TrekkingRoute::where('slug', $slug)->update($data);
        }

        $count = TrekkingRoute::whereNotNull('meta_title')->count();
        $this->command->info("Updated {$count} trekking routes with meta data.");
    }

    private function seedSafariPackages(): void
    {
        $meta = [
            'great-migration-edition' => [
                'meta_title' => 'Great Migration Safari 10 Days | Serengeti & Ngorongoro | Tanzania Sensational',
                'meta_description' => 'Witness the Great Migration in Serengeti on this 10-day safari. Visit Serengeti, Ngorongoro Crater & Lake Manyara. Book your Tanzania migration safari package.',
            ],
            'pioneers-route' => [
                'meta_title' => 'Pioneer\'s Route Safari 7 Days | Tanzania Budget Safari | Tanzania Sensational',
                'meta_description' => 'Explore Tanzania\'s top parks on this 7-day Pioneer\'s Route safari. Serengeti, Ngorongoro, Tarangire & Lake Manyara. Book your affordable Tanzania safari.',
            ],
            'grand-canvas' => [
                'meta_title' => 'Grand Canvas Safari 14 Days | Ultimate Tanzania Safari | Tanzania Sensational',
                'meta_description' => 'The ultimate 14-day Tanzania safari covering Serengeti, Ngorongoro, Tarangire, Lake Manyara, Ruaha & Zanzibar. Book your comprehensive Grand Canvas safari.',
            ],
        ];

        foreach ($meta as $slug => $data) {
            SafariPackage::where('slug', $slug)->update($data);
        }

        $count = SafariPackage::whereNotNull('meta_title')->count();
        $this->command->info("Updated {$count} safari packages with meta data.");
    }

    private function seedDestinations(): void
    {
        $meta = [
            'serengeti' => [
                'meta_title' => 'Serengeti National Park Safari | Tanzania Safari Destinations',
                'meta_description' => 'Explore Serengeti National Park — home of the Great Migration. Book Serengeti safari packages with expert guides. Tanzania\'s most iconic wildlife destination.',
            ],
            'ngorongoro' => [
                'meta_title' => 'Ngorongoro Crater Safari | Tanzania Safari Destinations',
                'meta_description' => 'Visit the Ngorongoro Crater — a UNESCO World Heritage Site and Africa\'s Garden of Eden. Book Ngorongoro safari packages with expert Tanzania guides.',
            ],
            'tarangire' => [
                'meta_title' => 'Tarangire National Park Safari | Tanzania Safari Destinations',
                'meta_description' => 'Discover Tarangire National Park — famous for giant baobabs and large elephant herds. Book Tarangire safari packages. Tanzania\'s hidden gem destination.',
            ],
            'kilimanjaro' => [
                'meta_title' => 'Mount Kilimanjaro National Park | Climb Kili | Tanzania Destinations',
                'meta_description' => 'Explore Mount Kilimanjaro National Park — home of Africa\'s highest peak. Trek Kilimanjaro via multiple routes. Book your Kilimanjaro climbing adventure.',
            ],
            'lake-manyara' => [
                'meta_title' => 'Lake Manyara National Park Safari | Tanzania Safari Destinations',
                'meta_description' => 'Visit Lake Manyara National Park — famous for tree-climbing lions and vast flamingo flocks. Book Lake Manyara safari packages. Perfect day trip destination.',
            ],
            'zanzibar' => [
                'meta_title' => 'Zanzibar Beach Holiday | Tanzania Island Destinations | Tanzania Sensational',
                'meta_description' => 'Escape to Zanzibar — pristine beaches, turquoise waters, and rich Swahili culture. Book Zanzibar beach holidays and island extensions. Tanzania\'s paradise island.',
            ],
            'ruaha' => [
                'meta_title' => 'Ruaha National Park Safari | Tanzania Safari Destinations',
                'meta_description' => 'Explore Ruaha National Park — Tanzania\'s largest park with wild landscapes and abundant predators. Book Ruaha safari packages for an off-the-beaten-path adventure.',
            ],
            'nyerere' => [
                'meta_title' => 'Nyerere National Park Safari | Selous Game Reserve | Tanzania Destinations',
                'meta_description' => 'Discover Nyerere National Park (formerly Selous Game Reserve) — one of Africa\'s largest protected areas. Book Nyerere safari packages for wilderness exploration.',
            ],
            'mahale' => [
                'meta_title' => 'Mahale Mountains National Park | Chimpanzee Trekking | Tanzania Destinations',
                'meta_description' => 'Track chimpanzees in Mahale Mountains National Park on the shores of Lake Tanganyika. Book Mahale chimpanzee trekking safaris. Tanzania\'s primate paradise.',
            ],
        ];

        foreach ($meta as $slug => $data) {
            Destination::where('slug', $slug)->update($data);
        }

        $count = Destination::whereNotNull('meta_title')->count();
        $this->command->info("Updated {$count} destinations with meta data.");
    }
}
