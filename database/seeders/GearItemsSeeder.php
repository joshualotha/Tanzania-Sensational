<?php

namespace Database\Seeders;

use App\Models\GearItem;
use Illuminate\Database\Seeder;

class GearItemsSeeder extends Seeder
{
    public function run(): void
    {
        $gearItems = [
            // Clothing
            [
                'name' => 'Moisture-wicking base layers (top & bottom)',
                'category' => 'clothing',
                'is_required' => true,
                'description' => 'Synthetic or merino wool. Avoid cotton.',
                'sort_order' => 10,
            ],
            [
                'name' => 'Insulating mid-layer (fleece or down jacket)',
                'category' => 'clothing',
                'is_required' => true,
                'description' => 'For cold conditions at higher altitudes.',
                'sort_order' => 20,
            ],
            [
                'name' => 'Waterproof & windproof shell jacket',
                'category' => 'clothing',
                'is_required' => true,
                'description' => 'Gore-Tex or equivalent with hood.',
                'sort_order' => 30,
            ],
            [
                'name' => 'Waterproof pants',
                'category' => 'clothing',
                'is_required' => true,
                'description' => 'Full side zips recommended for easy layering.',
                'sort_order' => 40,
            ],
            [
                'name' => 'Trekking pants (convertible or softshell)',
                'category' => 'clothing',
                'is_required' => true,
                'description' => '2-3 pairs for rotation.',
                'sort_order' => 50,
            ],
            [
                'name' => 'Warm hat (beanie)',
                'category' => 'clothing',
                'is_required' => true,
                'description' => 'For cold mornings and summit night.',
                'sort_order' => 60,
            ],
            [
                'name' => 'Sun hat or cap with neck cover',
                'category' => 'clothing',
                'is_required' => true,
                'description' => 'Essential for sun protection at lower altitudes.',
                'sort_order' => 70,
            ],
            [
                'name' => 'Gloves (liner + insulated waterproof)',
                'category' => 'clothing',
                'is_required' => true,
                'description' => 'Two-pair system for varying conditions.',
                'sort_order' => 80,
            ],
            [
                'name' => 'Warm socks (wool or synthetic)',
                'category' => 'clothing',
                'is_required' => true,
                'description' => '4-5 pairs, plus one dedicated summit pair.',
                'sort_order' => 90,
            ],

            // Footwear
            [
                'name' => 'Waterproof hiking boots (broken in)',
                'category' => 'footwear',
                'is_required' => true,
                'description' => 'Mid-weight, ankle support, worn-in before trip.',
                'sort_order' => 100,
            ],
            [
                'name' => 'Camp shoes or sandals',
                'category' => 'footwear',
                'is_required' => false,
                'description' => 'For relaxing at camp after hiking.',
                'sort_order' => 110,
            ],
            [
                'name' => 'Gaiters',
                'category' => 'footwear',
                'is_required' => false,
                'description' => 'Useful for dusty or muddy trails.',
                'sort_order' => 120,
            ],

            // Equipment
            [
                'name' => 'Backpack (30-40L for day hikes)',
                'category' => 'equipment',
                'is_required' => true,
                'description' => 'With rain cover. Porters carry main duffel.',
                'sort_order' => 130,
            ],
            [
                'name' => 'Duffel bag (90-120L, waterproof)',
                'category' => 'equipment',
                'is_required' => true,
                'description' => 'For porter carry, max 15kg including sleeping bag.',
                'sort_order' => 140,
            ],
            [
                'name' => 'Sleeping bag (rated -10°C / 14°F or lower)',
                'category' => 'equipment',
                'is_required' => true,
                'description' => 'Down or synthetic. Can be rented.',
                'sort_order' => 150,
            ],
            [
                'name' => 'Sleeping pad (inflatable or foam)',
                'category' => 'equipment',
                'is_required' => true,
                'description' => 'Provided by us, but you may bring your own.',
                'sort_order' => 160,
            ],
            [
                'name' => 'Trekking poles (collapsible)',
                'category' => 'equipment',
                'is_required' => false,
                'description' => 'Highly recommended for descent.',
                'sort_order' => 170,
            ],
            [
                'name' => 'Headlamp with extra batteries',
                'category' => 'equipment',
                'is_required' => true,
                'description' => 'Essential for summit night and camp.',
                'sort_order' => 180,
            ],
            [
                'name' => 'Water bottles or hydration bladder (3L total)',
                'category' => 'equipment',
                'is_required' => true,
                'description' => 'Nalgene or similar, no single-use plastic.',
                'sort_order' => 190,
            ],

            // Personal & Health
            [
                'name' => 'Sunglasses (UV400, category 3-4)',
                'category' => 'personal',
                'is_required' => true,
                'description' => 'Essential for glacier/snow glare.',
                'sort_order' => 200,
            ],
            [
                'name' => 'Sunscreen (SPF 50+) and lip balm',
                'category' => 'personal',
                'is_required' => true,
                'description' => 'High altitude = intense UV exposure.',
                'sort_order' => 210,
            ],
            [
                'name' => 'Personal first aid kit',
                'category' => 'personal',
                'is_required' => true,
                'description' => 'Blister care, pain relievers, personal meds.',
                'sort_order' => 220,
            ],
            [
                'name' => 'Toiletries & wet wipes',
                'category' => 'personal',
                'is_required' => true,
                'description' => 'Biodegradable soap, toothbrush, etc.',
                'sort_order' => 230,
            ],
            [
                'name' => 'Quick-dry towel',
                'category' => 'personal',
                'is_required' => false,
                'description' => 'Small pack towel for washing.',
                'sort_order' => 240,
            ],
            [
                'name' => 'Camera / phone & power bank',
                'category' => 'personal',
                'is_required' => false,
                'description' => 'With waterproof case or bag.',
                'sort_order' => 250,
            ],
        ];

        foreach ($gearItems as $item) {
            GearItem::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}