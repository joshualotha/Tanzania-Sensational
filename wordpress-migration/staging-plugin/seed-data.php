<?php
/**
 * One-time seed importer for Tours and Destinations.
 *
 * Run via WP-CLI:
 *   wp eval "ts_seed_all();"
 * Or include once and call ts_seed_all() directly.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Sideload an image from a URL and return the attachment ID.
 */
function ts_seed_sideload_image( $url, $post_id = 0 ) {
    if ( empty( $url ) ) {
        return 0;
    }

    // Check if this URL was already sideloaded.
    global $wpdb;
    $existing = $wpdb->get_var( $wpdb->prepare(
        "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_ts_seed_source_url' AND meta_value = %s LIMIT 1",
        $url
    ) );
    if ( $existing ) {
        return (int) $existing;
    }

    if ( ! function_exists( 'media_sideload_image' ) ) {
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';
    }

    $attachment_id = media_sideload_image( $url, $post_id, null, 'id' );

    if ( is_wp_error( $attachment_id ) ) {
        return 0;
    }

    update_post_meta( $attachment_id, '_ts_seed_source_url', $url );
    return (int) $attachment_id;
}

/**
 * Insert or update a Tour post.
 */
function ts_seed_tour( $data ) {
    $existing = get_posts( [
        'post_type'      => 'ts_tour',
        'name'           => $data['slug'],
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ] );

    $postarr = [
        'post_type'   => 'ts_tour',
        'post_name'   => $data['slug'],
        'post_title'  => $data['title'],
        'post_status' => 'publish',
    ];

    if ( ! empty( $existing ) ) {
        $postarr['ID'] = $existing[0];
    }

    $post_id = wp_insert_post( $postarr, true );
    if ( is_wp_error( $post_id ) ) {
        return $post_id;
    }

    $hero_id = ts_seed_sideload_image( $data['hero_image'], $post_id );
    $gallery_ids = [];
    foreach ( $data['gallery'] as $img_url ) {
        $aid = ts_seed_sideload_image( $img_url, $post_id );
        if ( $aid ) {
            $gallery_ids[] = $aid;
        }
    }

    update_field( 'ts_tour_duration', $data['duration'], $post_id );
    update_field( 'ts_tour_parks', $data['parks'], $post_id );
    update_field( 'ts_tour_price', $data['price'], $post_id );
    update_field( 'ts_tour_price_note', $data['price_note'] ?? __( 'per person', 'tanzania-sensational' ), $post_id );
    update_field( 'ts_tour_badge', $data['badge'], $post_id );
    update_field( 'ts_tour_pace_level', $data['pace_level'], $post_id );
    update_field( 'ts_tour_featured', $data['featured'] ?? true, $post_id );
    update_field( 'ts_tour_display_order', $data['display_order'] ?? 0, $post_id );
    update_field( 'ts_tour_hero_image', $hero_id, $post_id );
    update_field( 'ts_tour_gallery', $gallery_ids, $post_id );
    update_field( 'ts_tour_overview', $data['overview'], $post_id );
    update_field( 'ts_tour_highlights', array_map( fn( $t ) => [ 'text' => $t ], $data['highlights'] ), $post_id );
    update_field( 'ts_tour_inclusions', array_map( fn( $t ) => [ 'text' => $t ], $data['inclusions'] ), $post_id );
    update_field( 'ts_tour_exclusions', array_map( fn( $t ) => [ 'text' => $t ], $data['exclusions'] ), $post_id );
    update_field( 'ts_tour_itinerary', array_map( function( $day ) {
        return [
            'day'           => $day['day'],
            'title'         => $day['title'],
            'description'   => $day['desc'],
            'accommodation' => $day['accommodation'] ?? '',
            'meals'         => $day['meals'] ?? '',
            'elevation'     => $day['elevation'] ?? '',
            'distance'      => $day['distance'] ?? '',
            'habitat'       => $day['habitat'] ?? '',
        ];
    }, $data['itinerary'] ), $post_id );

    return $post_id;
}

/**
 * Insert or update a Destination post.
 */
function ts_seed_destination( $data ) {
    $existing = get_posts( [
        'post_type'      => 'ts_destination',
        'name'           => $data['slug'],
        'posts_per_page' => 1,
        'fields'         => 'ids',
    ] );

    $postarr = [
        'post_type'   => 'ts_destination',
        'post_name'   => $data['slug'],
        'post_title'  => $data['name'],
        'post_status' => 'publish',
    ];

    if ( ! empty( $existing ) ) {
        $postarr['ID'] = $existing[0];
    }

    $post_id = wp_insert_post( $postarr, true );
    if ( is_wp_error( $post_id ) ) {
        return $post_id;
    }

    $hero_id = ts_seed_sideload_image( $data['hero_image'], $post_id );
    $gallery_ids = [];
    foreach ( $data['gallery'] as $img_url ) {
        $aid = ts_seed_sideload_image( $img_url, $post_id );
        if ( $aid ) {
            $gallery_ids[] = $aid;
        }
    }

    update_field( 'ts_dest_subtitle', $data['subtitle'], $post_id );
    update_field( 'ts_dest_tag', $data['tag'], $post_id );
    update_field( 'ts_dest_featured', $data['featured'] ?? true, $post_id );
    update_field( 'ts_dest_display_order', $data['display_order'] ?? 0, $post_id );
    update_field( 'ts_dest_hero_image', $hero_id, $post_id );
    update_field( 'ts_dest_gallery', $gallery_ids, $post_id );
    update_field( 'ts_dest_short_description', $data['short_desc'], $post_id );
    update_field( 'ts_dest_overview_quote', $data['overview_quote'], $post_id );
    update_field( 'ts_dest_coordinates', $data['coordinates'], $post_id );
    update_field( 'ts_dest_elevation', $data['elevation'], $post_id );
    update_field( 'ts_dest_duration', $data['duration'], $post_id );
    update_field( 'ts_dest_best_time', $data['best_time'], $post_id );
    update_field( 'ts_dest_encounter_rate', $data['encounter_rate'], $post_id );
    update_field( 'ts_dest_expedition_tier', $data['expedition_tier'], $post_id );
    update_field( 'ts_dest_tracking_method', $data['tracking_method'], $post_id );
    update_field( 'ts_dest_highlights', array_map( fn( $t ) => [ 'text' => $t ], $data['highlights'] ), $post_id );
    update_field( 'ts_dest_wildlife_list', array_map( fn( $t ) => [ 'text' => $t ], $data['wildlife_list'] ), $post_id );
    update_field( 'ts_dest_experience', [
        'atmosphere' => $data['experience']['atmosphere'],
        'wildlife'   => $data['experience']['wildlife'],
        'impact'     => $data['experience']['impact'],
    ], $post_id );
    update_field( 'ts_dest_atmosphere_vitals', array_map( fn( $v ) => [ 'label' => $v['label'], 'text' => $v['text'] ], $data['atmosphere_vitals'] ), $post_id );
    update_field( 'ts_dest_wildlife_vitals', array_map( fn( $v ) => [ 'label' => $v['label'], 'text' => $v['text'] ], $data['wildlife_vitals'] ), $post_id );

    return $post_id;
}

/**
 * Return the seed dataset for tours.
 */
function ts_seed_tours_data() {
    return [
        [
            'slug'        => 'great-migration-edition',
            'title'       => 'The Great Migration Edition',
            'duration'    => '10 Days',
            'parks'       => 'Serengeti • Ngorongoro • Manyara',
            'price'       => '$8,400',
            'badge'       => 'SIGNATURE',
            'pace_level'  => 'Signature Heritage',
            'featured'    => true,
            'display_order' => 1,
            'hero_image'  => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=2000&auto=format&fit=crop',
            'gallery'     => [
                'https://images.unsplash.com/photo-1534759846116-5799c33ce22a?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1589820296156-2454bbe6a8a0?q=80&w=1200&auto=format&fit=crop',
            ],
            'overview'    => "A definitive 10-day expedition tracking the Great Wildebeest Migration across the Serengeti plains. This signature safari offers front-row seats to nature's most dramatic spectacle, complemented by luxury tented camps and exclusive wilderness access.",
            'inclusions'  => [
                'Private Custom 4x4 Safari Cruiser with pop-up roof',
                'Elite Multi-lingual Driver-Guide',
                'Ultra-Luxury Tented Camps inside the National Parks',
                'All Park Entry, Concession, and Crater Fees',
                'Exclusive Serengeti Bush Dinner Experience',
                'Internal Bush Flights (if applicable to itinerary)',
                'All Chef-Prepared Meals on Safari (B, L, D)',
                'Unlimited Bottled Water, Coffee, and Tea',
                'Flying Doctors Emergency Evacuation Cover',
            ],
            'exclusions'  => [
                'International Flights and Visas',
                'Premium Alcoholic Beverages',
                'Gratuities for Guide and Camp Staff',
                'Optional Hot Air Balloon Safari ($599 pp)',
                'Travel Insurance',
            ],
            'highlights'  => [
                'Witness the Great Migration river crossings or calving season',
                'Experience the incredible predator density of the Central Serengeti',
                'Descend into the ancient Ngorongoro Crater for a self-contained ecosystem safari',
                'Stay in authentic, high-end canvas camps under the African stars',
            ],
            'itinerary'   => [
                [ 'day' => 1, 'title' => 'Arrival in Arusha', 'desc' => 'Touch down at Kilimanjaro International Airport. Your private chauffeur will transfer you to a serene coffee lodge on the outskirts of Arusha for rest and briefing.', 'accommodation' => 'Legendary Lodge', 'meals' => 'Dinner' ],
                [ 'day' => 2, 'title' => 'Lake Manyara National Park', 'desc' => 'Descend into the Great Rift Valley for a game drive amidst the groundwater forests of Lake Manyara, seeking tree-climbing lions and vast flocks of flamingos.', 'accommodation' => 'Lake Manyara Tree Lodge', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 3, 'title' => 'Ngorongoro Highlands', 'desc' => 'Ascend to the rim of the Ngorongoro Crater. Enjoy an afternoon guided walk along the crater rim or visit a traditional Maasai Boma.', 'accommodation' => 'Ngorongoro Crater Lodge', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 4, 'title' => 'Ngorongoro Crater Descent', 'desc' => 'A dawn descent into the caldera. This UNESCO World Heritage site is a haven for the Big Five, including the critically endangered black rhino.', 'accommodation' => 'Ngorongoro Crater Lodge', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 5, 'title' => 'Enter the Serengeti', 'desc' => 'Depart the highlands and traverse the rolling plains into the Serengeti. The afternoon is dedicated to following the migrating herds.', 'accommodation' => 'Singita Sasakwa Lodge', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 6, 'title' => 'Northern Serengeti - The Mara River', 'desc' => 'Drive to the extreme north of the park. Position yourself along the Mara River, waiting for the dramatic spectacle of wildebeest crossings.', 'accommodation' => 'Sayari Camp', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 7, 'title' => 'Full Day River Crossings', 'desc' => 'A full day dedicated to the river. Nature dictates the schedule here, demanding patience that is often rewarded with unparalleled wildlife theater.', 'accommodation' => 'Sayari Camp', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 8, 'title' => 'Central Serengeti - Seronera', 'desc' => 'Head south to the Seronera valley, famous for its resident leopards lounging in sausage trees and vast lion prides.', 'accommodation' => 'Four Seasons Safari Lodge', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 9, 'title' => 'The Plains at Dawn', 'desc' => 'Optional dawn hot air balloon safari over the plains, concluding with a champagne breakfast. Spend your final afternoon tracking cheetahs.', 'accommodation' => 'Four Seasons Safari Lodge', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 10, 'title' => 'Serengeti to Arusha', 'desc' => 'A final morning game drive en route to the Seronera airstrip. Fly back to Arusha over the crater highlands for an evening departure flight.', 'accommodation' => 'Day Room in Arusha', 'meals' => 'Breakfast, Lunch' ],
            ],
        ],
        [
            'slug'        => 'pioneers-route',
            'title'       => "The Pioneer's Route",
            'duration'    => '7 Days',
            'parks'       => 'Tarangire • Manyara • Ngorongoro',
            'price'       => '$5,200',
            'badge'       => 'CLASSIC',
            'pace_level'  => 'Classic Expedition',
            'featured'    => true,
            'display_order' => 2,
            'hero_image'  => 'https://images.unsplash.com/photo-1579159278799-8add1e53e9a0?q=80&w=2000&auto=format&fit=crop',
            'gallery'     => [
                'https://images.unsplash.com/photo-1551009175-8a68da93d5f9?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1549366021-9f761d450615?q=80&w=1200&auto=format&fit=crop',
            ],
            'overview'    => "A profound 7-day immersion into the lesser-traveled paths of the Northern Circuit. Focused on massive elephant herds, ancient baobabs, and the geological wonder of the Rift Valley.",
            'inclusions'  => [
                'Private Custom 4x4 Safari Cruiser',
                'Elite Head Guide & Tracker',
                'Premium Lodge Accommodation throughout',
                'Guided Walking Safaris in Tarangire',
                'All Park, Concession, and Crater Fees',
                'All Chef-Prepared Meals (B, L, D)',
                'Sundowner experiences',
            ],
            'exclusions'  => [
                'International Flights',
                'Gratuities',
                'Visas',
                'Travel Insurance',
            ],
            'highlights'  => [
                'Walk amidst the giant baobabs of Tarangire National Park',
                'Encounter immense elephant herds moving along the river systems',
                'Night game drive at Lake Manyara to spot nocturnal predators',
                'Comprehensive descent into the Ngorongoro Crater',
            ],
            'itinerary'   => [
                [ 'day' => 1, 'title' => 'Arrival in Tanzania', 'desc' => 'Arrive at Kilimanjaro Airport where our guide will meet you. Transfer to your boutique hotel in Arusha to unwind.', 'accommodation' => 'Arusha Coffee Lodge', 'meals' => 'Dinner' ],
                [ 'day' => 2, 'title' => 'Tarangire National Park', 'desc' => 'Drive to Tarangire, a landscape dominated by ancient baobab trees and the twisting Tarangire River. Spend the afternoon observing massive elephant herds.', 'accommodation' => "Oliver's Camp", 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 3, 'title' => 'Walking Safari in Tarangire', 'desc' => 'A morning walking safari with an armed ranger. Experience the bush intimately—tracking footprints, identifying flora, and feeling the wild pulse of the land.', 'accommodation' => "Oliver's Camp", 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 4, 'title' => 'Lake Manyara Night Drive', 'desc' => 'A short drive to the escarpment of the Great Rift Valley. After an afternoon game drive, embark on a rare night safari.', 'accommodation' => 'Escarpment Luxury Lodge', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 5, 'title' => 'Journey to the Crater', 'desc' => 'Climb through the rich agricultural lands of Karatu up to the Ngorongoro Highlands. The afternoon is spent relaxing by the fire.', 'accommodation' => "Gibb's Farm", 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 6, 'title' => 'The Caldera Ecosystem', 'desc' => 'An extended, full-day game drive on the crater floor. This enclosed microcosm is the best place in East Africa to spot the Big Five in a single day.', 'accommodation' => "Gibb's Farm", 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 7, 'title' => 'Return to Arusha', 'desc' => 'Enjoy a final, leisurely farm-to-table breakfast before returning to Arusha. Browse the Cultural Heritage Center before your onward flight.', 'accommodation' => 'None', 'meals' => 'Breakfast, Lunch' ],
            ],
        ],
        [
            'slug'        => 'grand-canvas',
            'title'       => 'The Grand Canvas',
            'duration'    => '14 Days',
            'parks'       => 'Northern Parks • Zanzibar',
            'price'       => '$14,500',
            'badge'       => 'EXCLUSIVE',
            'pace_level'  => 'Ultra-Luxury Journey',
            'featured'    => true,
            'display_order' => 3,
            'hero_image'  => 'https://images.unsplash.com/photo-1549366021-9f761d450615?q=80&w=2000&auto=format&fit=crop',
            'gallery'     => [
                'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?q=80&w=1200&auto=format&fit=crop',
            ],
            'overview'    => "Our most comprehensive Tanzania journey. Two weeks traversing the legendary Northern Circuit before unwinding on the white-sand beaches of Zanzibar. Designed for travelers who refuse to compromise.",
            'inclusions'  => [
                'All Domestic Flights and Transfers',
                'Private Guide and Vehicle throughout',
                'Ultra-Luxury Lodges and Tented Camps',
                'All Park and Concession Fees',
                'Zanzibar Beach Extension in a Premium Resort',
                'All Meals and Premium Beverages',
                'Hot Air Balloon Safari over the Serengeti',
                '24/7 Concierge Support',
            ],
            'exclusions'  => [
                'International Flights',
                'Visas',
                'Personal Travel Insurance',
                'Spa treatments and personal purchases',
            ],
            'highlights'  => [
                'Comprehensive Northern Circuit safari',
                'Private Serengeti balloon safari with champagne breakfast',
                'Ngorongoro Crater private descent',
                'Zanzibar spice tour and beach relaxation',
            ],
            'itinerary'   => [
                [ 'day' => 1, 'title' => 'Arusha Arrival', 'desc' => 'Arrive at Kilimanjaro International Airport and transfer to your luxury lodge in Arusha.', 'accommodation' => 'Arusha Coffee Lodge', 'meals' => 'Dinner' ],
                [ 'day' => 2, 'title' => 'Tarangire', 'desc' => 'Game drive among ancient baobabs and elephant herds.', 'accommodation' => 'Oliver\'s Camp', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 3, 'title' => 'Tarangire to Ngorongoro', 'desc' => 'Morning walking safari, then transfer to the crater highlands.', 'accommodation' => 'Ngorongoro Crater Lodge', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 4, 'title' => 'Ngorongoro Crater', 'desc' => 'Full-day crater floor safari seeking the Big Five.', 'accommodation' => 'Ngorongoro Crater Lodge', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 5, 'title' => 'Serengeti', 'desc' => 'Fly to the Serengeti and settle into your luxury tented camp.', 'accommodation' => 'Singita Sasakwa', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 6, 'title' => 'Serengeti Migration', 'desc' => 'Full day tracking the Great Migration with expert guides.', 'accommodation' => 'Singita Sasakwa', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 7, 'title' => 'Serengeti Balloon Safari', 'desc' => 'Optional dawn hot air balloon safari followed by a champagne breakfast.', 'accommodation' => 'Sayari Camp', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 8, 'title' => 'Northern Serengeti', 'desc' => 'Position for Mara River crossings in the far north.', 'accommodation' => 'Sayari Camp', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 9, 'title' => 'Serengeti to Arusha', 'desc' => 'Final morning game drive and flight back to Arusha.', 'accommodation' => 'Arusha Coffee Lodge', 'meals' => 'Breakfast, Lunch, Dinner' ],
                [ 'day' => 10, 'title' => 'Zanzibar', 'desc' => 'Fly to Zanzibar and transfer to your beach resort.', 'accommodation' => 'Zuri Zanzibar', 'meals' => 'Breakfast, Dinner' ],
                [ 'day' => 11, 'title' => 'Zanzibar Beach', 'desc' => 'Relax on the white sands of the Spice Island.', 'accommodation' => 'Zuri Zanzibar', 'meals' => 'Breakfast, Dinner' ],
                [ 'day' => 12, 'title' => 'Stone Town & Spice Tour', 'desc' => 'Explore the historic alleys of Stone Town and a working spice plantation.', 'accommodation' => 'Park Hyatt Zanzibar', 'meals' => 'Breakfast, Lunch' ],
                [ 'day' => 13, 'title' => 'Zanzibar Leisure', 'desc' => 'A final day to swim, sail, or simply unwind.', 'accommodation' => 'Park Hyatt Zanzibar', 'meals' => 'Breakfast, Dinner' ],
                [ 'day' => 14, 'title' => 'Departure', 'desc' => 'Transfer to Zanzibar Airport for your international departure.', 'accommodation' => 'None', 'meals' => 'Breakfast' ],
            ],
        ],
    ];
}

/**
 * Return the seed dataset for destinations.
 */
function ts_seed_destinations_data() {
    return [
        [
            'slug'              => 'serengeti',
            'name'              => 'Serengeti',
            'subtitle'          => 'The Infinite Plains',
            'tag'               => 'THE GREAT MIGRATION',
            'short_desc'        => 'Witness the greatest wildlife spectacle on Earth—two million wildebeest thundering across golden savannahs under an endless sky.',
            'featured'          => true,
            'display_order'     => 1,
            'hero_image'        => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=2000&auto=format&fit=crop',
            'gallery'           => [
                'https://images.unsplash.com/photo-1534759846116-5799c33ce22a?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1589820296156-2454bbe6a8a0?q=80&w=1200&auto=format&fit=crop',
            ],
            'coordinates'       => '2.3333° S, 34.8333° E',
            'elevation'         => '920m – 1,850m',
            'duration'          => '3–5 Days',
            'best_time'         => 'June to October (River Crossings) / Jan to March (Calving)',
            'encounter_rate'    => '95.8%',
            'expedition_tier'   => 'Prestige Tier 01',
            'tracking_method'   => 'Satellite GPS Tracking',
            'highlights'        => [ 'The Great Migration', 'River Crossings', 'Big Five Territory', 'Endless Horizons', 'Hot Air Ballooning' ],
            'wildlife_list'     => [ 'Wildebeest', 'Lion', 'Leopard', 'Cheetah', 'Elephant', 'Giraffe' ],
            'overview_quote'    => "Walking through this landscape is like reading a forgotten manuscript of the earth—every shadow tells a secret, and every sunrise is a revelation.",
            'experience'        => [
                'atmosphere' => "The air in the Serengeti is charged with a raw, ancient energy. In the early morning, a golden mist clings to the plains, and the only sound is the distant roar of a pride or the rhythmic thrum of millions of hooves.",
                'wildlife'   => "Beyond the legendary migration, the Serengeti is a sanctuary for the Big Five. Apex predators—lions, leopards, and cheetahs—patrol the vast horizons with an intensity that is palpable.",
                'impact'     => "A journey here is more than a safari; it is a pilgrimage to the soul of the wild. The scale of the landscape and the sheer volume of life instill a sense of awe that remains long after the dust has settled.",
            ],
            'atmosphere_vitals' => [
                [ 'label' => 'Sensory Vibe', 'text' => 'Charged with raw, ancient energy.' ],
                [ 'label' => 'Audio Profile', 'text' => 'Distant predator calls & thrum of millions of hooves.' ],
                [ 'label' => 'Visibility', 'text' => 'Endless horizons with golden morning mist.' ],
                [ 'label' => 'Ambient Temp', 'text' => 'Crisp 14°C at dawn to 28°C at meridian.' ],
            ],
            'wildlife_vitals'   => [
                [ 'label' => 'Predator Stat', 'text' => 'Highest density of lions and cheetahs in Africa.' ],
                [ 'label' => 'Key Species', 'text' => 'The Big Five + 2 Million migrating ungulates.' ],
                [ 'label' => 'Bio Profile', 'text' => 'Primal theatre of masterclass survival.' ],
                [ 'label' => 'Encounter Prob', 'text' => '95.8% (Historical Data Archive)' ],
            ],
        ],
        [
            'slug'              => 'ngorongoro',
            'name'              => 'Ngorongoro Crater',
            'subtitle'          => 'The Lost World',
            'tag'               => 'UNESCO CALDERA',
            'short_desc'        => 'Descend into an ancient, unbroken volcanic caldera. This self-contained ecosystem is a sanctuary where endangered black rhinos, apex predators, and flamingos coexist.',
            'featured'          => true,
            'display_order'     => 2,
            'hero_image'        => 'https://images.unsplash.com/photo-1549366021-9f761d450615?q=80&w=2000&auto=format&fit=crop',
            'gallery'           => [
                'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1579159278799-8add1e53e9a0?q=80&w=1200&auto=format&fit=crop',
            ],
            'coordinates'       => '3.2000° S, 35.5000° E',
            'elevation'         => '2,286m (Rim)',
            'duration'          => '1–2 Days',
            'best_time'         => 'Year-Round (Wildlife does not migrate out)',
            'encounter_rate'    => '98.2%',
            'expedition_tier'   => 'Prestige Tier 01',
            'tracking_method'   => 'Crater Floor GPS Grid',
            'highlights'        => [ 'Endangered Black Rhino', 'Crater Floor Drives', 'Maasai Coexistence', 'Dense Lion Population', 'Lake Magadi Flamingos' ],
            'wildlife_list'     => [ 'Black Rhino', 'Lion', 'Elephant', 'Buffalo', 'Hyena', 'Flamingo' ],
            'overview_quote'    => "To stand on the rim and gaze into the depths is to witness nature's most perfect amphitheater—a world enclosed, eternal, and utterly alive.",
            'experience'        => [
                'atmosphere' => "Descending into the crater floor feels like stepping back into a prehistoric era. The high walls create a literal world apart, where the morning fog dissolves to reveal a shimmering floor of salt pans, lush forests, and teeming grasslands.",
                'wildlife'   => "The concentration of wildlife is unparalleled. Within a single day, you can encounter the rare black rhino, witness lions stalking buffalo in the tall grass, and watch thousands of flamingos paint Lake Magadi in shades of pink.",
                'impact'     => "Standing on the rim and looking into the depths of the caldera is a humbling experience. It serves as a powerful reminder of nature's architectural genius and its resilience when protected.",
            ],
            'atmosphere_vitals' => [
                [ 'label' => 'Sensory Vibe', 'text' => 'Prehistoric calm within volcanic walls.' ],
                [ 'label' => 'Audio Profile', 'text' => 'Sacred silence broken by flamingo calls.' ],
                [ 'label' => 'Visibility', 'text' => '600m deep caldera with panoramic rim views.' ],
                [ 'label' => 'Ambient Temp', 'text' => 'Cool 10°C at rim to 24°C on crater floor.' ],
            ],
            'wildlife_vitals'   => [
                [ 'label' => 'Predator Stat', 'text' => 'Highest lion density per square km in Africa.' ],
                [ 'label' => 'Key Species', 'text' => 'Big Five including critically endangered black rhino.' ],
                [ 'label' => 'Bio Profile', 'text' => 'Self-contained Eden, a microcosm of East Africa.' ],
                [ 'label' => 'Encounter Prob', 'text' => '98.2% (Enclosed ecosystem)' ],
            ],
        ],
        [
            'slug'              => 'tarangire',
            'name'              => 'Tarangire',
            'subtitle'          => 'Land of Giants',
            'tag'               => 'ELEPHANT REALM',
            'short_desc'        => 'Walk in the shadow of ancient baobab trees and encounter the largest elephant herds in Tanzania.',
            'featured'          => true,
            'display_order'     => 3,
            'hero_image'        => 'https://images.unsplash.com/photo-1579159278799-8add1e53e9a0?q=80&w=2000&auto=format&fit=crop',
            'gallery'           => [
                'https://images.unsplash.com/photo-1551009175-8a68da93d5f9?q=80&w=1200&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1589820296156-2454bbe6a8a0?q=80&w=1200&auto=format&fit=crop',
            ],
            'coordinates'       => '3.8500° S, 36.0000° E',
            'elevation'         => '1,100m',
            'duration'          => '2–3 Days',
            'best_time'         => 'July to October (Dry Season Congregation)',
            'encounter_rate'    => '94.5%',
            'expedition_tier'   => 'Heritage Tier 02',
            'tracking_method'   => 'River System GPS Tracking',
            'highlights'        => [ 'Massive Elephant Herds', 'Ancient Baobabs', 'Silvery Landscapes', 'Tree-Climbing Pythons', 'Incredible Birding' ],
            'wildlife_list'     => [ 'Elephant', 'Lion', 'Leopard', 'Zebra', 'Giraffe', 'Ostrich' ],
            'overview_quote'    => "In the shade of a thousand-year baobab, with the river whispering below and elephants drifting like grey clouds—this is Africa at its most honest.",
            'experience'        => [
                'atmosphere' => "Tarangire possesses a rugged, silvery beauty unlike any other park. The massive baobab trees look like ancient upside-down guardians of the savanna. The atmosphere is one of profound tranquility and untamed space.",
                'wildlife'   => "Famous for its enormous elephant families, Tarangire offers intimate encounters with these intelligent giants. You'll see them gathered at the riverbanks or seeking shade under the great trees.",
                'impact'     => "Tarangire is the perfect destination for the traveler seeking depth over spectacle. It rewards the patient observer with moments of quiet beauty and a deep sense of peace.",
            ],
            'atmosphere_vitals' => [
                [ 'label' => 'Sensory Vibe', 'text' => 'Rugged tranquility beneath ancient baobabs.' ],
                [ 'label' => 'Audio Profile', 'text' => 'Elephant rumbles and 550+ bird species.' ],
                [ 'label' => 'Visibility', 'text' => 'Silvery landscapes cut by the winding river.' ],
                [ 'label' => 'Ambient Temp', 'text' => 'Warm 18°C mornings to 32°C at midday.' ],
            ],
            'wildlife_vitals'   => [
                [ 'label' => 'Predator Stat', 'text' => 'Tree-climbing lions and leopards in residence.' ],
                [ 'label' => 'Key Species', 'text' => 'Largest elephant herds in Tanzania (3,000+).' ],
                [ 'label' => 'Bio Profile', 'text' => 'Dry season refuge, extraordinary animal concentration.' ],
                [ 'label' => 'Encounter Prob', 'text' => '94.5% (Dry Season Peak)' ],
            ],
        ],
    ];
}

/**
 * Seed all content.
 */
function ts_seed_all() {
    if ( ! function_exists( 'update_field' ) ) {
        $msg = __( 'ACF is not active. Cannot seed data.', 'tanzania-sensational' );
        if ( defined( 'WP_CLI' ) && WP_CLI ) {
            WP_CLI::error( $msg );
        }
        return new WP_Error( 'acf_missing', $msg );
    }

    $results = [];

    foreach ( ts_seed_tours_data() as $tour ) {
        $result = ts_seed_tour( $tour );
        if ( is_wp_error( $result ) ) {
            if ( defined( 'WP_CLI' ) && WP_CLI ) {
                WP_CLI::warning( $result->get_error_message() );
            }
            $results[] = [ 'type' => 'tour', 'title' => $tour['title'], 'error' => $result->get_error_message() ];
        } else {
            if ( defined( 'WP_CLI' ) && WP_CLI ) {
                WP_CLI::success( 'Seeded tour: ' . $tour['title'] . ' (ID ' . $result . ')' );
            }
            $results[] = [ 'type' => 'tour', 'title' => $tour['title'], 'id' => $result ];
        }
    }

    foreach ( ts_seed_destinations_data() as $dest ) {
        $result = ts_seed_destination( $dest );
        if ( is_wp_error( $result ) ) {
            if ( defined( 'WP_CLI' ) && WP_CLI ) {
                WP_CLI::warning( $result->get_error_message() );
            }
            $results[] = [ 'type' => 'destination', 'title' => $dest['name'], 'error' => $result->get_error_message() ];
        } else {
            if ( defined( 'WP_CLI' ) && WP_CLI ) {
                WP_CLI::success( 'Seeded destination: ' . $dest['name'] . ' (ID ' . $result . ')' );
            }
            $results[] = [ 'type' => 'destination', 'title' => $dest['name'], 'id' => $result ];
        }
    }

    return $results;
}
