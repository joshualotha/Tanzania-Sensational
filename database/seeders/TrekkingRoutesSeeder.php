<?php

namespace Database\Seeders;

use App\Models\RouteItineraryDay;
use App\Models\TrekkingRoute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class TrekkingRoutesSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing data to avoid duplicates
        Schema::disableForeignKeyConstraints();
        TrekkingRoute::truncate();
        RouteItineraryDay::truncate();
        Schema::enableForeignKeyConstraints();

        $jsonFile = storage_path('app/data_export/topclimbers_packages.json');
        
        if (!file_exists($jsonFile)) {
            $this->command->error("Seeder file not found: {$jsonFile}");
            return;
        }

        $json = file_get_contents($jsonFile);
        $packages = json_decode($json, true);

        foreach ($packages as $pkg) {
            // Slug is routeId-id (e.g. lemosho-7-days)
            $slugString = $pkg['routeId'] . '-' . $pkg['id'];
            
            $route = TrekkingRoute::create([
                'name' => $pkg['title'],
                'slug' => Str::slug($slugString),
                'meta_badge' => $pkg['badge'] ?? null,
                'description' => $pkg['overview'],
                'difficulty' => $pkg['difficulty'] ?? 'Moderate',
                'duration' => (int) filter_var($pkg['duration'], FILTER_SANITIZE_NUMBER_INT),
                'distance' => $pkg['totalDistance'] ?? null,
                'elevation_gain' => $pkg['totalElevation'] ?? null,
                'base_price' => isset($pkg['price']) ? (float) filter_var($pkg['price'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : 0,
                'max_group_size' => 12,
                'hero_image' => $pkg['heroImg'],
                'success_rate' => $pkg['successRate'] ?? null,
                'highlights' => $pkg['highlights'] ?? [],
                'inclusions' => [
                    '2 Nights Hotel Accommodation (Moshi/Arusha)',
                    'All Kilimanjaro National Park Fees',
                    'Professional Certified Mountain Guides',
                    'Personalized Mountain Cook & Assistant',
                    'Traceable Oxygen & Pulse Oximeters',
                    'All Meals on Mountain (B, L, D)',
                    'High-Quality Mountain Tents & Mats',
                    'Fair Crew Wages & Comprehensive Insurance'
                ],
                'exclusions' => [
                    'International & Domestic Flights',
                    'Tanzania Entry Visa Fees',
                    'Tips for Mountain Crew (Recommended)',
                    'Personal Trekking Gear & Sleeping Bags',
                    'Travel & Medical Insurance',
                    'Items of a Personal Nature'
                ]
            ]);
            foreach ($pkg['itinerary'] as $day) {
                $description = $day['desc'];

                // Hero Route Detailed Paragraphs (Lemosho, Rongai, Machame, Marangu, Northern Circuit, Umbwe, Meru)
                $richContent = [
                    'lemosho-7-days' => [
                        1 => "Welcome to Tanzania! Your expedition begins with a private transfer from Kilimanjaro International Airport (JRO) to your hotel in Moshi. In the afternoon, your head guide will perform a gear check and conduct a thorough pre-trek briefing, ensuring you are prepared for the days ahead. Enjoy a relaxing evening and a final night in a comfortable bed.",
                        2 => "We drive to the Londorossi Gate to begin our ascent through the pristine Lemosho forest. The trail is alive with the sounds of colobus monkeys and exotic birds. We'll hike steadily through the lush, shaded canopy to reach Mti Mkubwa (Big Tree) Camp, our first night under the stars in the heart of the rainforest.",
                        3 => "We leave the forest behind and enter the moorland zone, trekking across the vast Shira Plateau. The views of Kibo Peak are spectacular as we navigate volcanic rock formations and cross several small streams. This plateau traversal is essential for our body's acclimatization to the thinning air.",
                        4 => "A steady climb eastward across the Shira Plateau offers unique views of the Northern Ice fields. We gain altitude gradually but significantly today as we move toward Shira 2 Camp. The panorama of the mountain's western breach is truly awe-inspiring, and we'll take an afternoon acclimatization walk after arriving at camp.",
                        5 => "Crucial Acclimatization Day. We ascend to the distinctive Lava Tower (4,640m) for lunch—our high point today. This 'climb high, sleep low' strategy is the best way to prepare your body for the summit. Afterward, we descend into the Great Barranco Valley, passing through the surreal 'Garden of the Senecios'.",
                        6 => "We begin by tackling the Great Barranco Wall, an exciting but non-technical scramble that rewards us with incredible views. From the top, we traverse ridges and valleys to reach Karanga Camp. We'll have a shorter day here, allowing our bodies to recover and prepare for the final push to base camp.",
                        7 => "The trail continues through the alpine desert toward Barafu Camp. The air is very thin, and the landscape is a stark moonscape of rock and ice. We arrive at base camp early, giving us time to eat, hydrate, and get a few hours of sleep before our midnight summit attempt begins.",
                        8 => "Summit Night. Shortly after midnight, we begin our push to the roof of Africa. The steep, zigzagging trail to Stella Point is the ultimate test of endurance. Reaching Uhuru Peak at sunrise is an experience that defies words. After celebrating our victory, we descend to Mweka Gate (or Millennium Camp) where the thick air and deep rest await.",
                        9 => "Our final descent takes us back through the rainforest to Mweka Gate. The rich oxygen and vibrant greenery are a welcome change. After collecting certificates and saying goodbye to our crew, we meet our vehicles for the return drive to Moshi for a hot shower and celebratory feast."
                    ],
                    'rongai-7-days' => [
                        1 => "Your journey starts with airport arrival and a transfer to your hotel in Moshi. Your guide will meet you for a briefing and gear check. The northern approach is remote and beautiful, offering a quieter experience of the mountain.",
                        2 => "We drive to the Nale Moru village to begin our trek through pine weight and farmlands. This northern side is drier and offers a distinct perspective of the mountain. We reach Simba Camp at the edge of the moorland for our first night, with views of the Kenyan plains below.",
                        3 => "A steady ascent through the moorland brings us toward Second Cave Camp. This section is known for its incredible views of Kibo and the eastern ice fields. The gradient is gentle, allowing for excellent early-stage acclimatization.",
                        4 => "We continue our climb through the high-altitude wilderness toward Mawenzi Tarn camp. This camp is spectacularly situated beneath the towering, jagged spires of Mawenzi Peak. Spend the afternoon exploring the area and acclimating to the 4,300m elevation.",
                        5 => "We head west across the vast saddle that joins Mawenzi and Kibo. The terrain is stark alpine desert, a landscape of rock and silence. We reach Kibo Hut at 4,730m by early afternoon, resting and hydrating in preparation for our midnight summit push.",
                        6 => "Summit Night. We rise before midnight for tea and biscuits before beginning the steep climb to Gillman's Point on the crater rim. From there, we push toward Uhuru Peak (5,895m). After a victorious moment at the summit, we descend to Horombo Hut for a well-earned rest.",
                        7 => "Our final day on the mountain is a steady 6-hour descent through the forest to Marangu Gate. After signing out and receiving your certificates, we meet our driver for the return trip to Moshi for celebrations.",
                        8 => "Final departure from Tanzania. Depending on your flight time, you may explore Moshi for souvenirs or transfer directly to JRO airport."
                    ],
                    'machame-7-days' => [
                        1 => "Arrival and transfer to Moshi for briefing and gear check. The Machame Route, known as the 'Whiskey Route', offers incredible scenic variety and a high success rate due to its acclimatization profile.",
                        2 => "We drive to Machame Gate and begin our ascent through the lush, emerald cloud forest. The trail can be muddy, but the vibrant biodiversity is stunning. We reach Machame Camp in the late afternoon for dinner.",
                        3 => "We leave the forest and climb a rocky ridge onto the Shira Plateau. The heather and moorland zones offer spectacular views of the mountain's southern glaciers. We camp at Shira Cave, enjoying one of the best sunsets on the mountain.",
                        4 => "We trek eastward through the alpine desert toward Lava Tower (4,640m). After an acclimatization lunch at the tower, we descend into the Barranco Valley. This 'walk high, sleep low' day is the key to our high success rate.",
                        5 => "The day begins with a scramble up the Great Barranco Wall. At the top, we're rewarded with views of the Heim Glacier. We traverse to Karanga Valley camp, a shorter day that helps conserve energy for the final push.",
                        6 => "We ascend to Barafu Camp, our high-altitude base. The air is thin, and the terrain is volcanic desert. We arrive early, hydrate well, and have an early dinner before attempting to sleep ahead of our midnight summit attempt.",
                        7 => "Summit Day. We depart at midnight, pushing through the cold and altitude toward Uhuru Peak. Reaching the summit at dawn is the highlight of a lifetime. We then begin the long descent to Mweka Gate for rest.",
                        8 => "Final descent through the forest leads to the park gate. After collecting certificates, we return to Moshi for celebrations and a hot shower."
                    ],
                    'marangu-6-days' => [
                        1 => "Arrival and transfer to Moshi for briefing. The Marangu Route, or 'Coca-Cola Route', is the oldest and most established path, offering hut accommodation instead of camping.",
                        2 => "We drive to Marangu Gate and begin our trek through the dense montane forest. The trail is well-maintained and leads steadily to Mandara Hut. A short walk to Maundi Crater nearby offers beautiful views of Northern Tanzania.",
                        3 => "We leave the forest and enter the moorland zone. The trail opens up to vast views as we head toward Horombo Hut. On a clear day, both Mawenzi and Kibo peaks are visible. This night in the A-frame huts is cozy and social.",
                        4 => "Acclimatization Day. We take a hike toward Zebra Rocks (4,020m), named for their distinctive black and white patterns. This extra day of activity followed by rest at Horombo is essential for your body's adjustment.",
                        5 => "Today is a long, steady walk across the alpine desert of 'the saddle'. We cross the barren landscape between the peaks of Mawenzi and Kibo to reach Kibo Hut, our last stop before the summit.",
                        6 => "Summit Night. Around midnight, we begin the steep ascent to Gillman's Point and then Uhuru Peak. After celebrating our victory, we descend all the way back to Horombo Hut for a night of deep sleep.",
                        7 => "Final descent through the forest to Marangu Gate. After collecting certificates, we meet our driver and return to Moshi for a celebratory dinner.",
                        8 => "Departure from Tanzania or extension to safari/Zanzibar."
                    ],
                    'northern-circuit-9-days' => [
                        1 => "Arrival and transfer to Moshi. The Northern Circuit is the longest and most remote route on Kilimanjaro, offering nearly 360 degrees of incredible views and the highest success rate.",
                        2 => "We drive to Londorossi Gate and begin our trek through the western rainforest to Mti Mkubwa Camp. The peaceful atmosphere sets the tone for our long journey around the mountain.",
                        3 => "We ascend onto the Shira Plateau, crossing the volcanic caldera toward Shira 1 Camp. The air begins to thin, and the landscape transitions into unique moorland with giant heathers.",
                        4 => "We trek across the plateau toward Moir Hut, a remote and quiet camp tucked away in the volcanic ridges. This northern diversion away from the crowds provides a tranquil wilderness experience.",
                        5 => "A steady climb takes us along the northern slopes of Kilimanjaro. This part of the mountain is rarely visited, offering pristine views and incredible solitude as we acclimate at altitude.",
                        6 => "We continue our journey around the north of the mountain, moving toward Buffalo Camp. The views of the Kenyan plains below are expansive and breathtaking as we navigate the high-desert terrain.",
                        7 => "The trail leads us across the northern ridges toward Third Cave Camp. The acclimatization on this route is world-class, making the later stages of the trek much more manageable for most climbers.",
                        8 => "We climb toward School Hut, our high base camp. The terrain is stark and volcanic, emphasizing the power of the mountain. We have an early dinner and rest before the midnight push.",
                        9 => "Summit Night. We ascend to the crater rim at Gilman's Point and continue to Uhuru Peak. After celebrating, we begin the long descent to Mweka Gate, having completed nearly a full circle around the peak.",
                        10 => "Final descent through the forest and return to Moshi for celebrations."
                    ],
                    'mt-meru-4-days' => [
                        1 => "Your Mount Meru expedition starts with a transfer to Arusha National Park. After registration at Momella Gate, we begin our climb through typical African savanna where giraffes and buffalo are often seen. We ascend through the forest to Miriakamba Hut.",
                        2 => "The trail steepens as we climb toward Saddle Hut. We'll pass through the 'Elephant Ridge' and enjoy views of the Meru Crater. After lunch at the hut, we take a short acclimatization hike to Little Meru for stunning views of Kilimanjaro.",
                        3 => "Summit Day. We rise at midnight for the steep, rocky climb to Socialist Peak (4,562m). The sunrise over Kilimanjaro from the summit of Meru is legendary. After celebrating, we descend all the way back to Miriakamba Hut.",
                        4 => "Our final descent takes us back to Momella Gate through the park's lush forests. We'll meet our vehicle and return to Arusha for much-needed rest and celebrations."
                    ],
                    'mt-meru-3-days' => [
                        1 => "Arrival at Momella Gate and ascent through the Arusha National Park savanna and forest to Miriakamba Hut. This route is challenging but offers some of the best wildlife viewing in Tanzania.",
                        2 => "A steeper climb through the forest and moorland to Saddle Hut. We'll take an afternoon hike to Little Meru to help with acclimatization before tomorrow's summit push.",
                        3 => "Summit Peak. We climb to Socialist Peak (4,562m) at midnight. After watching the sunrise over the African plains, we begin a long descent back to Momella Gate to meet our transport."
                    ]
                ];

                // Global logic to handle variants (e.g. 7-day text for 8-day route)
                $cleanSlug = str_replace(['-variation', '-private'], '', $route->slug);
                
                // If we don't have a direct slug match, try finding a base match
                if (!isset($richContent[$cleanSlug])) {
                    if (strpos($cleanSlug, 'lemosho') !== false) $cleanSlug = 'lemosho-7-days';
                    if (strpos($cleanSlug, 'machame') !== false) $cleanSlug = 'machame-7-days';
                    if (strpos($cleanSlug, 'marangu') !== false) $cleanSlug = 'marangu-6-days';
                    if (strpos($cleanSlug, 'meru') !== false) $cleanSlug = 'mt-meru-4-days';
                    if (strpos($cleanSlug, 'northern') !== false) $cleanSlug = 'northern-circuit-9-days';
                }

                $isDetailed = isset($richContent[$cleanSlug][$day['day']]);
                if ($isDetailed) {
                    $description = $richContent[$cleanSlug][$day['day']];
                } else {
                    // Fallback for non-hero routes
                    if (strlen($description) < 70) {
                        $description = $day['title'] . ": " . $description . ". Our professional expedition team ensures your safety and comfort as we navigate the diverse climatic zones of the mountain toward our next camp.";
                    }
                }

                RouteItineraryDay::create([
                    'trekking_route_id' => $route->id,
                    'day_number' => $day['day'],
                    'title' => $day['title'],
                    'description' => $description,
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
