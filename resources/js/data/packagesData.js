import { visualsData } from './visualsData.js';

export const packagesData = [
    // ─── LEMOSHO ROUTE PACKAGES ───
    {
        id: "6-days",
        routeId: "lemosho",
        title: "6 Days Lemosho Route",
        duration: "6 Days",
        difficulty: "High",
        successRate: "75%",
        heroImg: visualsData.trekking.routes.lemosho,
        overview: "A rapid, direct ascent crafted for the experienced or pre-acclimatized climber. This itinerary skips the Shira 1 camp and combines days to reach the summit faster.",
        inclusions: [
            "Private transport to & from Kilimanjaro International Airport to Moshi",
            "2 nights of accommodation in Moshi (Bed & Breakfast)",
            "Transportation to & from the Kilimanjaro gate",
            "All Park entry fees, Camping fees, and Rescue fees",
            "18% VAT on tour fees & services",
            "Premium 4-Season mountain tents",
            "Double layered Sleeping Mats",
            "Professional mountain guides, cook and porters",
            "3 hot, chef-prepared meals daily on the mountain",
            "Treated & filtered drinking water",
            "Hot water for washing daily",
            "Fair wages for mountain crew (KINAPA/KIATO approved)",
            "Portable oxygen tanks & pulse oximeter",
            "Comprehensive emergency medical kit"
        ],
        exclusions: [
            "Lunches and dinners at your hotel in Moshi",
            "International Flights and Visas",
            "Travel and medical evacuation insurance",
            "Personal mountain gear (available for rent)",
            "Gratuities for the mountain crew",
            "Personal items and toiletries"
        ],
        itinerary: [
            { day: 1, title: "Londorossi Gate to Shira 1 Camp", desc: "A long trek beginning in the rainforest and punching through to the Shira Plateau.", elevation: 3500, accommodation: "Shira 1 Camp (3,500m)", meals: "L, D" },
            { day: 2, title: "Shira 1 Camp to Moir Hut", desc: "Trek eastward across the caldera, arriving at the isolated Moir Hut nestled beneath the striking Lent Hills.", elevation: 4200, accommodation: "Moir Hut (4,200m)", meals: "B, L, D" },
            { day: 3, title: "Moir Hut to Barranco Camp via Lava Tower", desc: "Crucial acclimatization day. Ascend to Lava Tower (4,600m) before descending to the spectacular Barranco Valley.", elevation: 3900, accommodation: "Barranco Camp (3,900m)", meals: "B, L, D" },
            { day: 4, title: "Barranco Camp to Barafu Camp", desc: "Conquer the Barranco Wall and traverse the ridges, pushing straight past Karanga to Barafu base camp.", elevation: 4680, accommodation: "Barafu Camp (4,680m)", meals: "B, L, D" },
            { day: 5, title: "Barafu Camp to Uhuru Peak to Mweka Camp", desc: "Summit night. A grueling midnight ascent to the roof of Africa, followed by a massive descent.", elevation: 5895, accommodation: "Mweka Camp (3,100m)", meals: "B, L, D" },
            { day: 6, title: "Mweka Camp to Gate", desc: "A final descent through the montane forest. Collect your certificates at the gate.", elevation: 1640, accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },
    {
        id: "7-days",
        routeId: "lemosho",
        title: "7 Days Lemosho Route",
        duration: "7 Days",
        difficulty: "Moderate-High",
        successRate: "85%",
        heroImg: visualsData.trekking.routes.lemoshoEditorial,
        overview: "A highly popular itinerary that introduces a critical acclimatization stop in the Karanga Valley before the final summit push.",
        inclusions: [
            "Private transport to & from Kilimanjaro International Airport to Moshi",
            "2 nights of accommodation in Moshi (Bed & Breakfast)",
            "Transportation to & from the Kilimanjaro gate",
            "All Park entry fees, Camping fees, and Rescue fees",
            "18% VAT on tour fees & services",
            "Premium 4-Season mountain tents",
            "Double layered Sleeping Mats",
            "Professional mountain guides, cook and porters",
            "3 hot, chef-prepared meals daily on the mountain",
            "Treated & filtered drinking water",
            "Hot water for washing daily",
            "Fair wages for mountain crew (KINAPA/KIATO approved)",
            "Portable oxygen tanks & pulse oximeter",
            "Comprehensive emergency medical kit"
        ],
        exclusions: [
            "Lunches and dinners at your hotel in Moshi",
            "International Flights and Visas",
            "Travel and medical evacuation insurance",
            "Personal mountain gear (available for rent)",
            "Gratuities for the mountain crew",
            "Personal items and toiletries"
        ],
        itinerary: [
            { day: 1, title: "Londorossi Gate to Mti Mkubwa", desc: "Begin the expedition in the dense, silent beauty of the western montane forest.", elevation: 2810, accommodation: "Mti Mkubwa Camp (2,810m)", meals: "L, D" },
            { day: 2, title: "Mti Mkubwa to Shira 1 Camp", desc: "Break out of the forest canopy and onto the vast, windswept expanse of the Shira Plateau.", elevation: 3500, accommodation: "Shira 1 Camp (3,500m)", meals: "B, L, D" },
            { day: 3, title: "Shira 1 Camp to Shira 2 Camp", desc: "A gentle trek across the caldera to the higher Shira 2 camp, offering stunning views of Kibo.", elevation: 3850, accommodation: "Shira 2 Camp (3,850m)", meals: "B, L, D" },
            { day: 4, title: "Shira 2 Camp to Barranco Camp", desc: "A critical acclimatization day. Ascend to the imposing Lava Tower at 4,600m before descending into the Barranco Valley.", elevation: 3900, accommodation: "Barranco Camp (3,900m)", meals: "B, L, D" },
            { day: 5, title: "Barranco Camp to Karanga Camp", desc: "Conquer the vertical scramble of the famous Barranco Wall, followed by a short traverse to Karanga Valley.", elevation: 3995, accommodation: "Karanga Camp (3,995m)", meals: "B, L, D" },
            { day: 6, title: "Karanga Camp to Barafu Camp", desc: "Leave the final water source behind as you ascend into the stark alpine desert to base camp.", elevation: 4680, accommodation: "Barafu Camp (4,680m)", meals: "B, L, D" },
            { day: 7, title: "Ascent to Uhuru Peak to Mweka Camp", desc: "Summit Night. A frigid, majestic climb to the roof of Africa. Descend all the way to Mweka Camp.", elevation: 5895, accommodation: "Mweka Camp (3,100m)", meals: "B, L, D" },
            { day: 8, title: "Mweka Camp to Gate", desc: "A final, triumphant descent through the montane forest to collect your summit certificates.", elevation: 1640, accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },
    {
        id: "8-days",
        routeId: "lemosho",
        title: "8 Days Lemosho Route",
        duration: "8 Days",
        difficulty: "Moderate",
        successRate: "95%+",
        heroImg: visualsData.trekking.routes.lemosho,
        overview: "The gold standard for Kilimanjaro. This extended itinerary provides the absolute optimal acclimatization profile, maximizing both summit success and enjoyment.",
        inclusions: [
            "Private transport to & from Kilimanjaro International Airport to Moshi",
            "2 nights of accommodation in Moshi (Bed & Breakfast)",
            "Transportation to & from the Kilimanjaro gate",
            "All Park entry fees, Camping fees, and Rescue fees",
            "18% VAT on tour fees & services",
            "Premium 4-Season mountain tents",
            "Double layered Sleeping Mats",
            "Professional mountain guides, cook and porters",
            "3 hot, chef-prepared meals daily on the mountain",
            "Treated & filtered drinking water",
            "Hot water for washing daily",
            "Fair wages for mountain crew (KINAPA/KIATO approved)",
            "Portable oxygen tanks & pulse oximeter",
            "Comprehensive emergency medical kit",
            "Private chemical toilet (optional add-on standard for VIP)"
        ],
        exclusions: [
            "Lunches and dinners at your hotel in Moshi",
            "International Flights and Visas",
            "Travel and medical evacuation insurance",
            "Personal mountain gear (available for rent)",
            "Gratuities for the mountain crew",
            "Personal items and toiletries"
        ],
        highlights: [
            "Optimum Acclimatization: Features the absolute ideal ascent profile to minimize altitude sickness.",
            "High Success Rate: Enjoy a 95%+ success rate due to the gentle pace.",
            "Scenic Variety: Trek through every ecological zone, from montane forest to the arctic summit.",
            "Crowd Avoidance: Approaches from the remote west, avoiding the heavy traffic of the Machame route until day 4."
        ],
        itinerary: [
            { day: 1, title: "Londorossi Gate to Mti Mkubwa", desc: "Begin the expedition in the dense, silent beauty of the western montane forest.", elevation: 2810, distance: "6 km", hikingTime: "3-4 hours", habitat: "Rain Forest", accommodation: "Mti Mkubwa Camp (2,810m)", meals: "L, D" },
            { day: 2, title: "Mti Mkubwa to Shira 1 Camp", desc: "Break out of the forest canopy and onto the vast, windswept expanse of the Shira Plateau.", elevation: 3500, distance: "8 km", hikingTime: "5-6 hours", habitat: "Moorland", accommodation: "Shira 1 Camp (3,500m)", meals: "B, L, D" },
            { day: 3, title: "Shira 1 to Shira 2 Camp", desc: "A relaxed day crossing the plateau, allowing absolute adaptation to the altitude.", elevation: 3850, distance: "7 km", hikingTime: "3-4 hours", habitat: "Moorland", accommodation: "Shira 2 Camp (3,850m)", meals: "B, L, D" },
            { day: 4, title: "Shira 2 Camp to Barranco Camp", desc: "A critical acclimatization day. Ascend to Lava Tower at 4,600m before descending into the surreal Barranco Valley.", elevation: 3900, distance: "10 km", hikingTime: "6-7 hours", habitat: "Semi-Desert", accommodation: "Barranco Camp (3,900m)", meals: "B, L, D" },
            { day: 5, title: "Barranco Camp to Karanga Camp", desc: "Conquer the vertical scramble of the famous Barranco Wall, followed by an acclimatization hike above Karanga.", elevation: 3995, distance: "5 km", hikingTime: "4-5 hours", habitat: "Alpine Desert", accommodation: "Karanga Camp (3,995m)", meals: "B, L, D" },
            { day: 6, title: "Karanga Camp to Barafu Camp", desc: "A short, steep trek through the stark alpine desert. Arrive early at base camp to rest for the summit.", elevation: 4680, distance: "4 km", hikingTime: "4-5 hours", habitat: "Alpine Desert", accommodation: "Barafu Camp (4,680m)", meals: "B, L, D" },
            { day: 7, title: "Ascent to Uhuru Peak to Mweka Camp", desc: "Summit Night. A frigid, majestic climb to the roof of Africa. Descend all the way to Mweka Camp.", elevation: 5895, distance: "5 km ascent / 12 km descent", hikingTime: "7-8 hours ascent / 4-6 hours descent", habitat: "Arctic", accommodation: "Mweka Camp (3,100m)", meals: "B, L, D" },
            { day: 8, title: "Mweka Camp to Gate", desc: "A final, triumphant descent through the montane forest to collect your summit certificates.", elevation: 1640, distance: "10 km", hikingTime: "3-4 hours", habitat: "Rain Forest", accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },
    {
        id: "8-days-crater",
        routeId: "lemosho",
        title: "8 Days Lemosho with Crater Camp",
        duration: "8 Days",
        difficulty: "Extreme",
        successRate: "80%",
        heroImg: visualsData.trekking.routes.lemoshoEditorial,
        overview: "An elite expedition for the deeply adventurous. Sleep within the ancient volcanic caldera of Kilimanjaro at Crater Camp, surrounded by sheer ice glaciers.",
        inclusions: [
            "Private transport to & from Kilimanjaro International Airport to Moshi",
            "2 nights of accommodation in Moshi (Bed & Breakfast)",
            "Transportation to & from the Kilimanjaro gate",
            "All Park entry fees, Crater Camping fees, and Rescue fees",
            "18% VAT on tour fees & services",
            "Premium 4-Season mountain tents",
            "Double layered Sleeping Mats",
            "Professional mountain guides, cook and porters",
            "3 hot, chef-prepared meals daily on the mountain",
            "Treated & filtered drinking water",
            "Fair wages for mountain crew (KINAPA/KIATO approved)",
            "Portable oxygen tanks & pulse oximeter",
            "Comprehensive emergency medical kit"
        ],
        exclusions: [
            "Lunches and dinners at your hotel in Moshi",
            "International Flights and Visas",
            "Travel and medical evacuation insurance",
            "Personal mountain gear",
            "Gratuities for the mountain crew"
        ],
        itinerary: [
            { day: 1, title: "Londorossi Gate to Mti Mkubwa", desc: "Begin the expedition in the dense, silent beauty of the western montane forest.", accommodation: "Mti Mkubwa Camp (2,810m)", meals: "L, D" },
            { day: 2, title: "Mti Mkubwa to Shira 2 Camp", desc: "A rapid push across the Shira Plateau directly to camp 2.", accommodation: "Shira 2 Camp (3,850m)", meals: "B, L, D" },
            { day: 3, title: "Shira 2 Camp to Barranco Camp", desc: "Climb high to Lava Tower (4,600m), sleep low in the Barranco Valley.", accommodation: "Barranco Camp (3,900m)", meals: "B, L, D" },
            { day: 4, title: "Barranco Camp to Karanga Camp", desc: "Conquer the Barranco Wall before settling in the Karanga Valley.", accommodation: "Karanga Camp (3,995m)", meals: "B, L, D" },
            { day: 5, title: "Karanga Camp to Barafu Camp", desc: "Trek into the stark alpine desert to the primary base camp.", accommodation: "Barafu Camp (4,680m)", meals: "B, L, D" },
            { day: 6, title: "Barafu Camp to Crater Camp", desc: "A unique daytime ascent to Stella Point, continuing past glaciers to sleep inside the ancient crater itself.", accommodation: "Crater Camp (5,730m)", meals: "B, L, D" },
            { day: 7, title: "Crater to Uhuru Peak to Mweka Camp", desc: "A brief one-hour sunrise hike to the absolute summit, followed by a massive, grueling descent.", accommodation: "Mweka Camp (3,100m)", meals: "B, L, D" },
            { day: 8, title: "Mweka Camp to Gate", desc: "A heroic descent through the forest to the exit gate.", accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },
    {
        id: "9-days-crater",
        routeId: "lemosho",
        title: "9 Days Lemosho with Crater Camp",
        duration: "9 Days",
        difficulty: "High",
        successRate: "90%",
        heroImg: visualsData.trekking.routes.lemosho,
        overview: "The most luxurious and comprehensively acclimatized Crater Camp itinerary available. Experience the wonders of the caldera with minimized risk of severe altitude sickness.",
        inclusions: [
            "Private transport to & from Kilimanjaro International Airport to Moshi",
            "2 nights of accommodation in Moshi (Bed & Breakfast)",
            "Transportation to & from the Kilimanjaro gate",
            "All Park entry fees, Crater Camping fees, and Rescue fees",
            "18% VAT on tour fees",
            "Premium 4-Season mountain tents",
            "Professional guides, cook and porters",
            "3 hot, chef-prepared meals daily",
            "Personal portable oxygen"
        ],
        exclusions: ["International Flights", "Medical insurance", "Gratuities", "Dinner in Moshi"],
        itinerary: [
            { day: 1, title: "Londorossi Gate to Mti Mkubwa", desc: "Forest trek.", elevation: 2810, accommodation: "Mti Mkubwa Camp (2,810m)", meals: "L, D" },
            { day: 2, title: "Mti Mkubwa to Shira 1 Camp", desc: "Emerging onto the plateau.", elevation: 3500, accommodation: "Shira 1 Camp (3,500m)", meals: "B, L, D" },
            { day: 3, title: "Shira 1 to Shira 2 Camp", desc: "Plateau crossing.", elevation: 3850, accommodation: "Shira 2 Camp (3,850m)", meals: "B, L, D" },
            { day: 4, title: "Shira 2 to Barranco Camp", desc: "Acclimatization via Lava Tower.", elevation: 3900, accommodation: "Barranco Camp (3,900m)", meals: "B, L, D" },
            { day: 5, title: "Barranco to Karanga Camp", desc: "Wall scramble and valley traverse.", elevation: 3995, accommodation: "Karanga Camp (3,995m)", meals: "B, L, D" },
            { day: 6, title: "Karanga Camp to Barafu Camp", desc: "Arrive at base camp.", elevation: 4680, accommodation: "Barafu Camp (4,680m)", meals: "B, L, D" },
            { day: 7, title: "Barafu Camp to Crater Camp", desc: "Daytime ascent to sleep next to Furtwängler Glacier.", elevation: 5730, accommodation: "Crater Camp (5,730m)", meals: "B, L, D" },
            { day: 8, title: "Crater to Uhuru Peak to Mweka Camp", desc: "Sunrise at the peak, then the long descent.", elevation: 5895, accommodation: "Mweka Camp (3,100m)", meals: "B, L, D" },
            { day: 9, title: "Mweka Camp to Gate", desc: "Final exit.", elevation: 1640, accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },

    // ─── MACHAME ROUTE PACKAGES ───
    {
        id: "6-days",
        routeId: "machame",
        title: "6 Days Machame Route",
        duration: "6 Days",
        difficulty: "High",
        successRate: "70%",
        heroImg: visualsData.trekking.routes.machame,
        overview: "A rigorous, fast-paced ascent along the 'Whiskey Route' for the exceptionally fit. An aggressive acclimatization profile that rewards determined climbers.",
        inclusions: ["Transport to gate", "All park/camping fees", "Guides & Porters", "Tents & Meals", "Oxygen & First Aid"],
        exclusions: ["Flights", "Insurance", "Tips", "Personal clothing"],
        highlights: [
            "The Whiskey Route: Kilimanjaro's most legendary and scenically diverse path.",
            "Visual Spectacle: Offers breathtaking views of the Shira Plateau and the southern glaciers.",
            "Technical Challenge: Features the thrilling scramble up the Great Barranco Wall.",
            "High Elevation Profile: Rapid ascent that rewards the physically prepared trekker."
        ],
        itinerary: [
            { day: 1, title: "Machame Gate to Machame Camp", desc: "Begin your adventure on the lush southern slopes, winding through dense rainforest.", elevation: 2835, distance: "11 km", hikingTime: "5-7 hours", habitat: "Rain Forest", accommodation: "Machame Camp (2,835m)", meals: "L, D" },
            { day: 2, title: "Machame Camp to Shira Cave Camp", desc: "Leave the forest canopy behind as you ascend onto the rugged moorland.", elevation: 3750, distance: "5 km", hikingTime: "4-6 hours", habitat: "Moorland", accommodation: "Shira Cave Camp (3,750m)", meals: "B, L, D" },
            { day: 3, title: "Shira Cave to Barranco Camp", desc: "Ascend to the Lava Tower (4,600m) before descending into the surreal Barranco Valley.", elevation: 3900, distance: "10 km", hikingTime: "6-8 hours", habitat: "Semi-Desert", accommodation: "Barranco Camp (3,900m)", meals: "B, L, D" },
            { day: 4, title: "Barranco Camp to Barafu Camp", desc: "A relentless push climbing the Barranco Wall and bypassing Karanga to reach base camp directly.", elevation: 4680, distance: "9 km", hikingTime: "8-10 hours", habitat: "Alpine Desert", accommodation: "Barafu Camp (4,680m)", meals: "B, L, D" },
            { day: 5, title: "Barafu to Uhuru Peak to Mweka", desc: "Midnight summit assault, followed by a dramatic descent down the mountain.", elevation: 5895, distance: "5 km ascent / 12 km descent", hikingTime: "7-8 hours ascent / 4-6 hours descent", habitat: "Arctic", accommodation: "Mweka Camp (3,100m)", meals: "B, L, D" },
            { day: 6, title: "Mweka Camp to Gate", desc: "Final hike out through the rainforest.", elevation: 1640, distance: "10 km", hikingTime: "3-4 hours", habitat: "Rain Forest", accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },
    {
        id: "7-days",
        routeId: "machame",
        title: "7 Days Machame Route",
        duration: "7 Days",
        difficulty: "Moderate-High",
        successRate: "85%",
        heroImg: visualsData.trekking.routes.machameEditorial,
        overview: "The recommended Machame expedition. An essential extra day is added in the Karanga Valley to vastly improve acclimatization and summit success.",
        inclusions: ["Transport to gate", "All park/camping fees", "Guides & Porters", "Tents & Meals", "Oxygen & First Aid"],
        exclusions: ["Flights", "Insurance", "Tips", "Personal clothing"],
        highlights: [
            "Optimal Acclimatization: Includes an extra day at Karanga Valley to maximize summit success.",
            "The Great Barranco Wall: An unforgettable scramble offering the best views on the mountain.",
            "Lava Tower: Spend high-altitude time at 4,600m to trigger physiological adaptation.",
            "Five Ecological Zones: Experience everything from tropical jungle to glacial moonscapes."
        ],
        itinerary: [
            { day: 1, title: "Machame Gate to Machame Camp", desc: "Trek through the dense rainforest.", elevation: 2835, distance: "11 km", hikingTime: "5-7 hours", habitat: "Rain Forest", accommodation: "Machame Camp (2,835m)", meals: "L, D" },
            { day: 2, title: "Machame Camp to Shira Cave", desc: "Ascend into the moorland zones.", elevation: 3750, distance: "5 km", hikingTime: "4-6 hours", habitat: "Moorland", accommodation: "Shira Cave Camp (3,750m)", meals: "B, L, D" },
            { day: 3, title: "Shira Cave to Barranco Camp", desc: "Crucial climb high, sleep low day via Lava Tower.", elevation: 3900, distance: "10 km", hikingTime: "6-8 hours", habitat: "Semi-Desert", accommodation: "Barranco Camp (3,900m)", meals: "B, L, D" },
            { day: 4, title: "Barranco Camp to Karanga Camp", desc: "Scale the Barranco Wall, resting in the Karanga Valley.", elevation: 3995, distance: "5 km", hikingTime: "4-5 hours", habitat: "Alpine Desert", accommodation: "Karanga Camp (3,995m)", meals: "B, L, D" },
            { day: 5, title: "Karanga Camp to Barafu Camp", desc: "A short, steep hike to base camp.", elevation: 4680, distance: "4 km", hikingTime: "4-5 hours", habitat: "Alpine Desert", accommodation: "Barafu Camp (4,680m)", meals: "B, L, D" },
            { day: 6, title: "Barafu to Uhuru Peak to Mweka", desc: "Summit night. Push to the peak and descend.", elevation: 5895, distance: "5 km ascent / 12 km descent", hikingTime: "7-8 hours ascent / 4-6 hours descent", habitat: "Arctic", accommodation: "Mweka Camp (3,100m)", meals: "B, L, D" },
            { day: 7, title: "Mweka Camp to Gate", desc: "Final descent to the exit.", elevation: 1640, distance: "10 km", hikingTime: "3-4 hours", habitat: "Rain Forest", accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },

    // ─── RONGAI ROUTE PACKAGES ───
    {
        id: "6-days",
        routeId: "rongai",
        title: "6 Days Rongai Route",
        duration: "6 Days",
        difficulty: "Moderate",
        successRate: "80%",
        heroImg: visualsData.trekking.routes.rongai,
        overview: "A direct ascent via the less-traveled, drier northern slopes. Offers a steady incline and unique wilderness before descending via Marangu.",
        inclusions: ["Transport to gate", "All park/camping fees", "Guides & Porters", "Tents & Meals", "Oxygen"],
        exclusions: ["Flights", "Insurance", "Tips"],
        itinerary: [
            { day: 1, title: "Rongai Gate to Simba Camp", desc: "Trek through pine forests on the northern slopes.", elevation: 2600, accommodation: "Simba Camp (2,600m)", meals: "L, D" },
            { day: 2, title: "Simba Camp to Second Cave", desc: "Ascend into moorland with views over Kenya.", elevation: 3450, accommodation: "Second Cave (3,450m)", meals: "B, L, D" },
            { day: 3, title: "Second Cave to Third Cave", desc: "A steady trek across the northern flank.", elevation: 3870, accommodation: "Third Cave (3,870m)", meals: "B, L, D" },
            { day: 4, title: "Third Cave to Kibo Hut", desc: "Cross the lunar saddle desert to base camp.", elevation: 4720, accommodation: "Kibo Hut (4,720m)", meals: "B, L, D" },
            { day: 5, title: "Kibo Hut to Uhuru Peak to Horombo", desc: "Midnight summit assault, descending to Horombo.", elevation: 5895, accommodation: "Horombo Hut (3,720m)", meals: "B, L, D" },
            { day: 6, title: "Horombo Hut to Marangu Gate", desc: "Exit via the southern Marangu trail.", elevation: 1860, accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },
    {
        id: "7-days",
        routeId: "rongai",
        title: "7 Days Rongai Route",
        duration: "7 Days",
        difficulty: "Moderate",
        successRate: "90%",
        heroImg: visualsData.trekking.routes.rongaiEditorial,
        overview: "Our recommended Rongai expedition. An extra acclimatization day at the spectacular Mawenzi Tarn ensures a vastly stronger summit bid.",
        inclusions: ["Transport to gate", "All park/camping fees", "Guides & Porters", "Tents & Meals", "Oxygen"],
        exclusions: ["Flights", "Insurance", "Tips"],
        itinerary: [
            { day: 1, title: "Rongai Gate to Simba Camp", desc: "Trek through pine forests on the northern slopes.", accommodation: "Simba Camp (2,600m)", meals: "L, D" },
            { day: 2, title: "Simba Camp to Second Cave", desc: "Ascend into moorland.", accommodation: "Second Cave (3,450m)", meals: "B, L, D" },
            { day: 3, title: "Second Cave to Kikelewa Cave", desc: "Trek towards the jagged peaks of Mawenzi.", accommodation: "Kikelewa Cave (3,600m)", meals: "B, L, D" },
            { day: 4, title: "Kikelewa Cave to Mawenzi Tarn", desc: "A steep, rewarding climb into the striking Mawenzi cirque.", accommodation: "Mawenzi Tarn (4,315m)", meals: "B, L, D" },
            { day: 5, title: "Mawenzi Tarn to Kibo Hut", desc: "Cross the Alpine desert saddle connecting Mawenzi to Kibo.", accommodation: "Kibo Hut (4,720m)", meals: "B, L, D" },
            { day: 6, title: "Kibo Hut to Uhuru Peak to Horombo", desc: "Summit Night.", accommodation: "Horombo Hut (3,720m)", meals: "B, L, D" },
            { day: 7, title: "Horombo Hut to Marangu Gate", desc: "Descent through the rainforest.", accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },

    // ─── MARANGU ROUTE PACKAGES ───
    {
        id: "5-days",
        routeId: "marangu",
        title: "5 Days Marangu Route",
        duration: "5 Days",
        difficulty: "High",
        successRate: "60%",
        heroImg: visualsData.trekking.routes.marangu,
        overview: "A fast, direct ascent along the historic original route, utilizing comfortable A-frame huts instead of tents. For the highly experienced trekker only due to brutal acclimatization.",
        inclusions: ["Transport", "Park/Hut fees", "Guides & Porters", "Hut accommodation & Meals", "Oxygen"],
        exclusions: ["Flights", "Insurance", "Tips"],
        itinerary: [
            { day: 1, title: "Marangu Gate to Mandara Hut", desc: "A steady climb through the lower rainforest.", accommodation: "Mandara Hut (2,700m)", meals: "L, D" },
            { day: 2, title: "Mandara Hut to Horombo Hut", desc: "Emerge into the heath and moorland zones.", accommodation: "Horombo Hut (3,720m)", meals: "B, L, D" },
            { day: 3, title: "Horombo Hut to Kibo Hut", desc: "Trek across the saddle directly to base camp.", accommodation: "Kibo Hut (4,700m)", meals: "B, L, D" },
            { day: 4, title: "Kibo Hut to Uhuru Peak to Horombo", desc: "Midnight ascent to the peak and descend.", accommodation: "Horombo Hut (3,720m)", meals: "B, L, D" },
            { day: 5, title: "Horombo Hut to Gate", desc: "Final exit.", accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },
    {
        id: "6-days",
        routeId: "marangu",
        title: "6 Days Marangu Route",
        duration: "6 Days",
        difficulty: "Moderate",
        successRate: "80%",
        heroImg: visualsData.trekking.routes.maranguEditorial,
        overview: "Our recommended Marangu itinerary. An essential extra acclimatization day safely spent at Horombo Hut maximizes your summit success while enjoying the comforts of the huts.",
        inclusions: ["Transport", "Park/Hut fees", "Guides & Porters", "Hut accommodation & Meals", "Oxygen"],
        exclusions: ["Flights", "Insurance", "Tips"],
        itinerary: [
            { day: 1, title: "Marangu Gate to Mandara Hut", desc: "A steady climb through the lower rainforest.", accommodation: "Mandara Hut (2,700m)", meals: "L, D" },
            { day: 2, title: "Mandara Hut to Horombo Hut", desc: "Emerge into the heath and moorland zones.", accommodation: "Horombo Hut (3,720m)", meals: "B, L, D" },
            { day: 3, title: "Horombo Hut (Acclimatization)", desc: "A hike to Zebra Rocks to acclimatize before returning to the same hut.", accommodation: "Horombo Hut (3,720m)", meals: "B, L, D" },
            { day: 4, title: "Horombo Hut to Kibo Hut", desc: "Trek across the saddle directly to base camp.", accommodation: "Kibo Hut (4,700m)", meals: "B, L, D" },
            { day: 5, title: "Kibo Hut to Uhuru Peak to Horombo", desc: "Midnight ascent to the peak and descend.", accommodation: "Horombo Hut (3,720m)", meals: "B, L, D" },
            { day: 6, title: "Horombo Hut to Gate", desc: "Final exit.", accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },

    // ─── NORTHERN CIRCUIT PACKAGES ───
    {
        id: "9-days",
        routeId: "northern-circuit",
        title: "9 Days Northern Circuit",
        duration: "9 Days",
        difficulty: "High",
        successRate: "95%+",
        heroImg: visualsData.trekking.routes.northern,
        overview: "The magnificent grand traverse. Our longest and most exclusive expedition, offering unparalleled acclimatization and breathtaking absolute solitude via the remote northern slopes.",
        inclusions: ["Transport", "Park/Camping fees", "Guides & Porters", "Premium Tents & Meals", "Oxygen"],
        exclusions: ["Flights", "Insurance", "Tips"],
        itinerary: [
            { day: 1, title: "Londorossi Gate to Mti Mkubwa", desc: "Forest trek.", accommodation: "Mti Mkubwa Camp (2,810m)", meals: "L, D" },
            { day: 2, title: "Mti Mkubwa to Shira 1 Camp", desc: "Emerging onto the plateau.", accommodation: "Shira 1 Camp (3,500m)", meals: "B, L, D" },
            { day: 3, title: "Shira 1 to Shira 2 Camp", desc: "Trek eastward across the caldera.", accommodation: "Shira 2 Camp (3,850m)", meals: "B, L, D" },
            { day: 4, title: "Shira 2 to Moir Hut", desc: "Hike to the isolated Moir Hut beneath the Lent Hills.", accommodation: "Moir Hut (4,200m)", meals: "B, L, D" },
            { day: 5, title: "Moir Hut to Buffalo Camp", desc: "Begin the true northern traverse through the high-altitude desert.", accommodation: "Buffalo Camp (4,020m)", meals: "B, L, D" },
            { day: 6, title: "Buffalo Camp to Third Cave", desc: "Sweep across the northern flank with views of Kenya.", accommodation: "Third Cave (3,870m)", meals: "B, L, D" },
            { day: 7, title: "Third Cave to School Hut", desc: "Ascend to the Saddle and prepare for the summit.", accommodation: "School Hut (4,750m)", meals: "B, L, D" },
            { day: 8, title: "School Hut to Uhuru Peak to Mweka", desc: "Extremely long summit night, arriving at dawn, descending south.", accommodation: "Mweka Camp (3,100m)", meals: "B, L, D" },
            { day: 9, title: "Mweka Camp to Gate", desc: "Final exit through the forest.", accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },
    {
        id: "10-days-crater",
        routeId: "northern-circuit",
        title: "10 Days Northern Circuit with Crater",
        duration: "10 Days",
        difficulty: "Extreme",
        successRate: "90%",
        heroImg: visualsData.trekking.routes.northernEditorial,
        overview: "The absolute pinnacle of Kilimanjaro expeditions. A slow, majestic 360-degree traverse concluding with a rare and exclusive overnight stay within the ancient volcanic caldera.",
        inclusions: ["Transport", "Park/Crater Camping fees", "Guides & Porters", "Premium Tents & Meals", "Oxygen"],
        exclusions: ["Flights", "Insurance", "Tips"],
        itinerary: [
            { day: 1, title: "Londorossi Gate to Mti Mkubwa", desc: "Forest trek.", accommodation: "Mti Mkubwa Camp (2,810m)", meals: "L, D" },
            { day: 2, title: "Mti Mkubwa to Shira 1", desc: "Onto the plateau.", accommodation: "Shira 1 Camp (3,500m)", meals: "B, L, D" },
            { day: 3, title: "Shira 1 to Shira 2", desc: "Plateau crossing.", accommodation: "Shira 2 Camp (3,850m)", meals: "B, L, D" },
            { day: 4, title: "Shira 2 to Moir Hut", desc: "Lent Hills.", accommodation: "Moir Hut (4,200m)", meals: "B, L, D" },
            { day: 5, title: "Moir Hut to Buffalo Camp", desc: "Northern traverse begins.", accommodation: "Buffalo Camp (4,020m)", meals: "B, L, D" },
            { day: 6, title: "Buffalo Camp to Third Cave", desc: "Northern slopes.", accommodation: "Third Cave (3,870m)", meals: "B, L, D" },
            { day: 7, title: "Third Cave to School Hut", desc: "Base camp.", accommodation: "School Hut (4,750m)", meals: "B, L, D" },
            { day: 8, title: "School Hut to Crater Camp", desc: "Daytime ascent to the caldera. Sleep next to glaciers.", accommodation: "Crater Camp (5,730m)", meals: "B, L, D" },
            { day: 9, title: "Crater to Uhuru Peak to Mweka", desc: "Short walk to summit, massive descent.", accommodation: "Mweka Camp (3,100m)", meals: "B, L, D" },
            { day: 10, title: "Mweka Camp to Gate", desc: "Exit.", accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },

    // ─── UMBWE ROUTE PACKAGES ───
    {
        id: "6-days",
        routeId: "umbwe",
        title: "6 Days Umbwe Route",
        duration: "6 Days",
        difficulty: "Extreme",
        successRate: "60%",
        heroImg: visualsData.trekking.routes.umbwe,
        overview: "A steep, uncompromising vertical climb straight to the roof of Africa. Reserved exclusively for highly experienced, pre-acclimatized mountaineers.",
        inclusions: ["Transport", "Park fees", "Guides & Porters", "Tents & Meals", "Oxygen"],
        exclusions: ["Flights", "Insurance", "Tips"],
        itinerary: [
            { day: 1, title: "Umbwe Gate to Umbwe Cave", desc: "Severe vertical ascent through rainforest.", accommodation: "Umbwe Cave Camp (2,850m)", meals: "L, D" },
            { day: 2, title: "Umbwe Cave to Barranco Camp", desc: "Ridge scrambling to beneath the Barranco Wall.", accommodation: "Barranco Camp (3,900m)", meals: "B, L, D" },
            { day: 3, title: "Barranco Camp to Lava Tower to Barranco", desc: "Acclimatize high at Lava Tower, sleep back at Barranco.", accommodation: "Barranco Camp (3,900m)", meals: "B, L, D" },
            { day: 4, title: "Barranco to Barafu Camp", desc: "Climb the wall and bypass Karanga directly to base camp.", accommodation: "Barafu Camp (4,680m)", meals: "B, L, D" },
            { day: 5, title: "Barafu to Uhuru Peak to Mweka", desc: "Summit night.", accommodation: "Mweka Camp (3,100m)", meals: "B, L, D" },
            { day: 6, title: "Mweka Camp to Gate", desc: "Exit.", accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },
    {
        id: "7-days",
        routeId: "umbwe",
        title: "7 Days Umbwe Route",
        duration: "7 Days",
        difficulty: "High",
        successRate: "75%",
        heroImg: visualsData.trekking.routes.umbweEditorial,
        overview: "Our recommended Umbwe itinerary. Incorporates a vital acclimatization day in the Karanga Valley to temper the route's extreme verticality.",
        inclusions: ["Transport", "Park fees", "Guides & Porters", "Tents & Meals", "Oxygen"],
        exclusions: ["Flights", "Insurance", "Tips"],
        itinerary: [
            { day: 1, title: "Umbwe Gate to Umbwe Cave", desc: "Severe vertical ascent through rainforest.", accommodation: "Umbwe Cave Camp (2,850m)", meals: "L, D" },
            { day: 2, title: "Umbwe Cave to Barranco Camp", desc: "Ridge scrambling to beneath the Barranco Wall.", accommodation: "Barranco Camp (3,900m)", meals: "B, L, D" },
            { day: 3, title: "Barranco Camp to Karanga Camp", desc: "Scale the Great Barranco Wall.", accommodation: "Karanga Camp (3,995m)", meals: "B, L, D" },
            { day: 4, title: "Karanga Camp to Barafu Camp", desc: "Hike through alpine desert to base camp.", accommodation: "Barafu Camp (4,680m)", meals: "B, L, D" },
            { day: 5, title: "Barafu to Uhuru Peak to Mweka", desc: "Summit night.", accommodation: "Mweka Camp (3,100m)", meals: "B, L, D" },
            { day: 6, title: "Mweka Camp to Gate", desc: "Exit.", accommodation: "Hotel in Moshi", meals: "B" }
        ]
    },

    // ─── MT. MERU TREKKING PACKAGES ───
    {
        id: "3-days",
        routeId: "mt-meru",
        title: "3 Days Mount Meru Trek",
        duration: "3 Days",
        difficulty: "Moderate-High",
        successRate: "90%",
        heroImg: visualsData.planning.meruHero,
        overview: "A focused, high-paced ascent of Tanzania's second highest peak. Ideal for fit climbers using Meru as a final acclimatization push before Kilimanjaro.",
        inclusions: [
            "Transport to Arusha National Park",
            "Professional guide and armed ranger",
            "Porter support",
            "Mountain hut fees",
            "All park entry and rescue fees",
            "3 meals daily on the mountain"
        ],
        exclusions: ["Tips", "Personal gear", "Insurance"],
        itinerary: [
            { 
                day: 1, 
                title: "Momella Gate to Miriakamba Hut", 
                desc: "A beautiful walking safari start through the lower slopes of Arusha National Park.", 
                elevation: 2514, 
                distance: "10 km", 
                hikingTime: "4-5 hours", 
                habitat: "Montane Forest", 
                accommodation: "Miriakamba Hut (2,514m)", 
                meals: "L, D" 
            },
            { 
                day: 2, 
                title: "Miriakamba Hut to Saddle Hut", 
                desc: "A steep climb through the forest and heather zone with views of the Ash Cone.", 
                elevation: 3570, 
                distance: "4 km", 
                hikingTime: "3-5 hours", 
                habitat: "Heather/Moorland", 
                accommodation: "Saddle Hut (3,570m)", 
                meals: "B, L, D" 
            },
            { 
                day: 3, 
                title: "Saddle Hut to Socialist Peak to Gate", 
                desc: "Midnight summit push along the crater rim, followed by a long descent to the gate.", 
                elevation: 4562, 
                distance: "5 km up / 14 km down", 
                hikingTime: "4-6 hours up / 5-7 hours down", 
                habitat: "Alpine Desert/Arctic", 
                accommodation: "Hotel in Arusha", 
                meals: "B, L" 
            }
        ]
    },
    {
        id: "4-days",
        routeId: "mt-meru",
        title: "4 Days Mount Meru Trek",
        duration: "4 Days",
        difficulty: "Moderate",
        successRate: "95%",
        heroImg: visualsData.planning.meruHero,
        overview: "The classic Meru experience. This extra day allows for optimal acclimatization and a side trip to Little Meru, significantly enhancing the enjoyment of the summit rim walk.",
        inclusions: [
            "Arusha National Park transfers",
            "Licensed guide and armed ranger",
            "Cook and porters",
            "Hut accommodation",
            "Park and Rescue fees",
            "Filtered drinking water"
        ],
        exclusions: ["Gratuities", "Alcoholic drinks", "Gear rental"],
        itinerary: [
            { day: 1, title: "Momella Gate to Miriakamba Hut", desc: "Spot wildlife on the way to the first hut.", elevation: 2514, accommodation: "Miriakamba Hut", meals: "L, D" },
            { day: 2, title: "Miriakamba Hut to Saddle Hut", desc: "Climb through the lush forest zone.", elevation: 3570, accommodation: "Saddle Hut", meals: "B, L, D" },
            { day: 3, title: "Saddle Hut (Acclimatization) & Little Meru", desc: "Hike to Little Meru for stunning views and better adaptation.", elevation: 3820, accommodation: "Saddle Hut", meals: "B, L, D" },
            { day: 4, title: "Socialist Peak to Gate", desc: "The final push and descent.", elevation: 4562, accommodation: "Hotel in Arusha", meals: "B, L" }
        ]
    }
];
