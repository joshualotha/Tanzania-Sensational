import { visualsData } from './visualsData';

export const safarisData = [
    {
        id: "great-migration-edition",
        title: "The Great Migration Edition",
        duration: "10 Days",
        parks: "Serengeti • Ngorongoro • Manyara",
        price: "$8,400",
        badge: "SIGNATURE",
        paceLevel: "Signature Heritage",
        heroImg: visualsData.safaris.pkgMigration,
        overview: "A definitive 10-day expedition tracking the Great Wildebeest Migration across the Serengeti plains. This signature safari offers front-row seats to nature's most dramatic spectacle, complemented by luxury tented camps and exclusive wilderness access.",
        inclusions: [
            "Private Custom 4x4 Safari Cruiser with pop-up roof",
            "Elite Multi-lingual Driver-Guide",
            "Ultra-Luxury Tented Camps inside the National Parks",
            "All Park Entry, Concession, and Crater Fees",
            "Exclusive Serengeti Bush Dinner Experience",
            "Internal Bush Flights (if applicable to itinerary)",
            "All Chef-Prepared Meals on Safari (B, L, D)",
            "Unlimited Bottled Water, Coffee, and Tea",
            "Flying Doctors Emergency Evacuation Cover"
        ],
        exclusions: [
            "International Flights and Visas",
            "Premium Alcoholic Beverages",
            "Gratuities for Guide and Camp Staff",
            "Optional Hot Air Balloon Safari ($599 pp)",
            "Travel Insurance"
        ],
        highlights: [
            "Witness the Great Migration river crossings or calving season",
            "Experience the incredible predator density of the Central Serengeti",
            "Descend into the ancient Ngorongoro Crater for a self-contained ecosystem safari",
            "Stay in authentic, high-end canvas camps under the African stars"
        ],
        itinerary: [
            {
                day: 1,
                title: "Arrival in Arusha",
                desc: "Touch down at Kilimanjaro International Airport. Your private chauffeur will transfer you to a serene coffee lodge on the outskirts of Arusha for rest and briefing.",
                accommodation: "Legendary Lodge",
                meals: "Dinner"
            },
            {
                day: 2,
                title: "Lake Manyara National Park",
                desc: "Descend into the Great Rift Valley for a game drive amidst the groundwater forests of Lake Manyara, seeking tree-climbing lions and vast flocks of flamingos.",
                accommodation: "Lake Manyara Tree Lodge",
                meals: "Breakfast, Lunch, Dinner"
            },
            {
                day: 3,
                title: "Ngorongoro Highlands",
                desc: "Ascend to the rim of the Ngorongoro Crater. Enjoy an afternoon guided walk along the crater rim or visit a traditional Maasai Boma in the afternoon light.",
                accommodation: "Ngorongoro Crater Lodge",
                meals: "Breakfast, Lunch, Dinner"
            },
            {
                day: 4,
                title: "Ngorongoro Crater Descent",
                desc: "A dawn descent into the caldera. This UNESCO World Heritage site is a haven for the Big Five, including the critically endangered black rhino. Enjoy a picnic lunch by the hippo pool.",
                accommodation: "Ngorongoro Crater Lodge",
                meals: "Breakfast, Lunch, Dinner"
            },
            {
                day: 5,
                title: "Enter the Serengeti",
                desc: "Depart the highlands and traverse the rolling plains into the Serengeti. The afternoon is dedicated to following the migrating herds and observing predator activity.",
                accommodation: "Singita Sasakwa Lodge",
                meals: "Breakfast, Lunch, Dinner"
            },
            {
                day: 6,
                title: "Northern Serengeti - The Mara River",
                desc: "Drive to the extreme north of the park. Position yourself along the Mara River, waiting for the dramatic, chaotic spectacle of wildebeest crossing crocodile-infested waters.",
                accommodation: "Sayari Camp",
                meals: "Breakfast, Lunch, Dinner"
            },
            {
                day: 7,
                title: "Full Day River Crossings",
                desc: "A full day dedicated to the river. Nature dictates the schedule here, demanding patience that is often rewarded with unparalleled wildlife theater.",
                accommodation: "Sayari Camp",
                meals: "Breakfast, Lunch, Dinner"
            },
            {
                day: 8,
                title: "Central Serengeti - Seronera",
                desc: "Head south to the Seronera valley, famous for its resident leopards lounging in sausage trees and vast lion prides surveying the golden grasses.",
                accommodation: "Four Seasons Safari Lodge",
                meals: "Breakfast, Lunch, Dinner"
            },
            {
                day: 9,
                title: "The Plains at Dawn",
                desc: "Optional dawn hot air balloon safari over the plains, concluding with a champagne breakfast. Spend your final afternoon tracking cheetahs on the open savanna.",
                accommodation: "Four Seasons Safari Lodge",
                meals: "Breakfast, Lunch, Dinner"
            },
            {
                day: 10,
                title: "Serengeti to Arusha",
                desc: "A final morning game drive en route to the Seronera airstrip. Fly back to Arusha over the crater highlands for an evening departure flight.",
                accommodation: "Day Room in Arusha",
                meals: "Breakfast, Lunch"
            }
        ]
    },
    {
        id: "pioneers-route",
        title: "The Pioneer's Route",
        duration: "7 Days",
        parks: "Tarangire • Manyara • Ngorongoro",
        price: "$5,200",
        badge: "CLASSIC",
        paceLevel: "Classic Expedition",
        heroImg: visualsData.safaris.pkgPioneer,
        overview: "A profound 7-day immersion into the lesser-traveled paths of the Northern Circuit. Focused on massive elephant herds, ancient baobabs, and the geological wonder of the Rift Valley.",
        inclusions: [
            "Private Custom 4x4 Safari Cruiser",
            "Elite Head Guide & Tracker",
            "Premium Lodge Accommodation throughout",
            "Guided Walking Safaris in Tarangire",
            "All Park, Concession, and Crater Fees",
            "All Chef-Prepared Meals (B, L, D)",
            "Sundowner experiences"
        ],
        exclusions: [
            "International Flights",
            "Gratuities",
            "Visas",
            "Travel Insurance"
        ],
        highlights: [
            "Walk amidst the giant baobabs of Tarangire National Park",
            "Encounter immense elephant herds moving along the river systems",
            "Night game drive at Lake Manyara to spot nocturnal predators",
            "Comprehensive descent into the Ngorongoro Crater"
        ],
        itinerary: [
            {
                day: 1,
                title: "Arrival in Tanzania",
                desc: "Arrive at Kilimanjaro Airport where our guide will meet you. Transfer to your boutique hotel in Arusha to unwind.",
                accommodation: "Arusha Coffee Lodge",
                meals: "Dinner"
            },
            {
                day: 2,
                title: "Tarangire National Park",
                desc: "Drive to Tarangire, a landscape dominated by ancient baobab trees and the twisting Tarangire River. Spend the afternoon observing the massive elephant herds.",
                accommodation: "Oliver's Camp",
                meals: "Breakfast, Lunch, Dinner"
            },
            {
                day: 3,
                title: "Walking Safari in Tarangire",
                desc: "A morning walking safari with an armed ranger. Experience the bush intimately—tracking footprints, identifying flora, and feeling the wild pulse of the land.",
                accommodation: "Oliver's Camp",
                meals: "Breakfast, Lunch, Dinner"
            },
            {
                day: 4,
                title: "Lake Manyara Night Drive",
                desc: "A short drive to the escarpment of the Great Rift Valley. After a standard afternoon game drive, embark on a rare night safari to seek out leopards, genets, and porcupines.",
                accommodation: "Escarpment Luxury Lodge",
                meals: "Breakfast, Lunch, Dinner"
            },
            {
                day: 5,
                title: "Journey to the Crater",
                desc: "Climb through the rich agricultural lands of Karatu up to the Ngorongoro Highlands. The afternoon is spent relaxing by the fire as the mountain air cools.",
                accommodation: "Gibb's Farm",
                meals: "Breakfast, Lunch, Dinner"
            },
            {
                day: 6,
                title: "The Caldera Ecosystem",
                desc: "An extended, full-day game drive on the crater floor. This enclosed microcosm is the best place in East Africa to spot the Big Five in a single day.",
                accommodation: "Gibb's Farm",
                meals: "Breakfast, Lunch, Dinner"
            },
            {
                day: 7,
                title: "Return to Arusha",
                desc: "Enjoy a final, leisurely farm-to-table breakfast before returning to Arusha. Browse the Cultural Heritage Center before your onward flight.",
                accommodation: "None",
                meals: "Breakfast, Lunch"
            }
        ]
    },
    {
        id: "grand-canvas",
        title: "The Grand Canvas",
        duration: "14 Days",
        parks: "Northern Parks • Zanzibar",
        price: "$14,500",
        badge: "EXCLUSIVE",
        paceLevel: "Grand Exclusive",
        heroImg: visualsData.safaris.pkgCanvas,
        overview: "The ultimate bush-to-beach odyssey. Two weeks combining the raw, visceral thrill of the deep Serengeti with the languid, spice-scented luxury of a secluded Zanzibar retreat.",
        inclusions: [
            "Internal Bush Flights (Serengeti, Zanzibar, Arusha)",
            "Private Custom 4x4 Safari Cruiser with pop-up roof",
            "Private Chef & Butler in select camps",
            "Ultra-Luxury Accommodation",
            "All Park and Concession Fees",
            "All Meals and Premium Beverages on Safari",
            "Zanzibar Recovery Retreat (Half Board or All-Inclusive)",
            "Private Dhow Sunset Cruise in Zanzibar"
        ],
        exclusions: [
            "International Flights",
            "Vintage Wines and Champagnes",
            "Spa Treatments",
            "Gratuities for Guides and Staff"
        ],
        highlights: [
            "Complete traverse of the Serengeti from South to North",
            "Intimate, exclusive-use wilderness camps",
            "Fly from the deep bush directly to the white sands of the Indian Ocean",
            "Five days of barefoot luxury on a private Zanzibar beach"
        ],
        itinerary: [
            { day: 1, title: "Arrival in Arusha", desc: "Private VIP transfer from Kilimanjaro Airport to a secluded estate.", accommodation: "Legendary Lodge", meals: "Dinner" },
            { day: 2, title: "Tarangire Wilderness", desc: "Drive to Tarangire. Afternoon game drive focusing on elephant encounters.", accommodation: "Kuro Tarangire", meals: "Breakfast, Lunch, Dinner" },
            { day: 3, title: "Ngorongoro Highlands", desc: "Traverse the Rift Valley to the highlands. Afternoon at leisure.", accommodation: "The Highlands", meals: "Breakfast, Lunch, Dinner" },
            { day: 4, title: "Crater Floor", desc: "Dawn descent into the Ngorongoro Crater for premier big game viewing.", accommodation: "The Highlands", meals: "Breakfast, Lunch, Dinner" },
            { day: 5, title: "Central Serengeti", desc: "Fly or drive into the Serengeti. Encounter the vast lion prides of the Seronera valley.", accommodation: "Namiri Plains", meals: "Breakfast, Lunch, Dinner" },
            { day: 6, title: "Predator Tracking", desc: "A full day exploring the eastern Serengeti, a territory renowned for cheetah and leopard.", accommodation: "Namiri Plains", meals: "Breakfast, Lunch, Dinner" },
            { day: 7, title: "Northern Serengeti", desc: "Game drive north towards the Mara River. The landscape changes from plains to rolling hills.", accommodation: "Singita Mara River Tented Camp", meals: "Breakfast, Lunch, Dinner" },
            { day: 8, title: "The Mara River", desc: "A day spent along the riverbanks, seeking the elusive and dramatic river crossings.", accommodation: "Singita Mara River Tented Camp", meals: "Breakfast, Lunch, Dinner" },
            { day: 9, title: "Bush to Beach", desc: "Board a light aircraft from the Serengeti bush directly to the spice island of Zanzibar.", accommodation: "Zuri Zanzibar", meals: "Breakfast, Dinner" },
            { day: 10, title: "Zanzibar Coast", desc: "A day of absolute recovery. White sands, turquoise waters, and ocean breezes.", accommodation: "Zuri Zanzibar", meals: "Breakfast, Dinner" },
            { day: 11, title: "Stone Town & Spice Tour", desc: "Explore the labyrinthine alleys of historic Stone Town and visit a local spice farm.", accommodation: "Zuri Zanzibar", meals: "Breakfast, Dinner" },
            { day: 12, title: "Indian Ocean Excursion", desc: "Sail on a traditional wooden dhow, snorkeling the vibrant coral reefs.", accommodation: "Zuri Zanzibar", meals: "Breakfast, Dinner" },
            { day: 13, title: "Barefoot Luxury", desc: "Your final full day to bask in the sun or indulge in world-class spa treatments.", accommodation: "Zuri Zanzibar", meals: "Breakfast, Dinner" },
            { day: 14, title: "Departure", desc: "Private transfer to Zanzibar Airport for your international flight home.", accommodation: "None", meals: "Breakfast" }
        ]
    }
];
