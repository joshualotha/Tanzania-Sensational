<?php
/** Temporary exact-path fallbacks for routes not yet built in WordPress. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

add_action( 'template_redirect', function() {
    if ( ! is_404() ) { return; }

    $path = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH ), '/' );
    $fallbacks = [
        'booking' => 'contact',
        'blog' => '',
        'company/our-guides' => 'about-us',
        'company/safety-protocols' => 'about-us',
        'group-departures' => 'safaris/packages',
        'safaris/guide' => 'safari-guide',
        'safaris/destinations/ngorongoro-crater' => 'safaris/destinations/ngorongoro',
        'safari-guide/what-to-wear' => 'gear-checklist',
        'safari-guide/packing-guide' => 'gear-checklist',
        'safari-guide/health-and-safety' => 'safari-guide',
        'safari-guide/local-custom' => 'safari-guide',
        'safari-guide/local-customs' => 'safari-guide',
        'safari-guide/accommodation-style' => 'safari-guide',
        'safari-guide/visa-guide' => 'safari-guide',
        'safaris/tanzania' => 'safaris',
        'safaris/kenya' => 'safaris',
        'safaris/uganda' => 'safaris',
        'safaris/rwanda' => 'safaris',
        'safaris/family' => 'safaris/packages',
        'safaris/honeymoon' => 'safaris/packages',
        'safaris/luxury' => 'safaris/packages',
        'safaris/photographic' => 'safaris/packages',
        'safaris/group-joining' => 'safaris/packages',
        'safaris/destinations/arusha' => 'safaris/destinations',
        'safaris/destinations/katavi' => 'safaris/destinations',
        'safaris/destinations/manyara' => 'safaris/destinations',
        'safaris/destinations/ruaha' => 'safaris/destinations',
        'safaris/destinations/selous' => 'safaris/destinations',
        'trekking/meru/mt-meru-4-days' => 'trekking/kilimanjaro',
        'trekking/after/training' => 'training-guide',
        'trekking/after/gear-list' => 'gear-checklist',
    ];

    foreach ( [ 'prep', 'health', 'during', 'after' ] as $section ) {
        if ( str_starts_with( $path, 'trekking/' . $section . '/' ) && ! isset( $fallbacks[ $path ] ) ) {
            $fallbacks[ $path ] = 'trekking/kilimanjaro';
        }
    }
    if ( str_starts_with( $path, 'trekking/kilimanjaro/' ) ) {
        $fallbacks[ $path ] = 'trekking/kilimanjaro';
    }

    if ( array_key_exists( $path, $fallbacks ) ) {
        wp_safe_redirect( home_url( '/' . trim( $fallbacks[ $path ], '/' ) . '/' ), 302, 'Tanzania Sensational route fallback' );
        exit;
    }
}, 1 );
