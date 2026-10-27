<?php
/**
 * Custom Post Types and taxonomies for Tanzania Sensational.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

add_action( 'init', function() {
    /**
     * Tours / Safaris
     */
    register_post_type( 'ts_tour', [
        'labels'              => [
            'name'                  => __( 'Tours', 'tanzania-sensational' ),
            'singular_name'         => __( 'Tour', 'tanzania-sensational' ),
            'add_new'               => __( 'Add New Tour', 'tanzania-sensational' ),
            'add_new_item'          => __( 'Add New Tour', 'tanzania-sensational' ),
            'edit_item'             => __( 'Edit Tour', 'tanzania-sensational' ),
            'new_item'              => __( 'New Tour', 'tanzania-sensational' ),
            'view_item'             => __( 'View Tour', 'tanzania-sensational' ),
            'search_items'          => __( 'Search Tours', 'tanzania-sensational' ),
            'not_found'             => __( 'No tours found', 'tanzania-sensational' ),
            'not_found_in_trash'    => __( 'No tours found in Trash', 'tanzania-sensational' ),
            'all_items'             => __( 'All Tours', 'tanzania-sensational' ),
            'menu_name'             => __( 'Tours', 'tanzania-sensational' ),
        ],
        'public'              => true,
        'has_archive'         => true,
        'rewrite'             => [ 'slug' => 'safaris/packages', 'with_front' => false ],
        'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ],
        'menu_icon'           => 'dashicons-palmtree',
        'menu_position'       => 21,
        'show_in_rest'        => true,
        'taxonomies'          => [ 'ts_tour_category' ],
    ] );

    /**
     * Destinations
     */
    register_post_type( 'ts_destination', [
        'labels'              => [
            'name'                  => __( 'Destinations', 'tanzania-sensational' ),
            'singular_name'         => __( 'Destination', 'tanzania-sensational' ),
            'add_new'               => __( 'Add New Destination', 'tanzania-sensational' ),
            'add_new_item'          => __( 'Add New Destination', 'tanzania-sensational' ),
            'edit_item'             => __( 'Edit Destination', 'tanzania-sensational' ),
            'new_item'              => __( 'New Destination', 'tanzania-sensational' ),
            'view_item'             => __( 'View Destination', 'tanzania-sensational' ),
            'search_items'          => __( 'Search Destinations', 'tanzania-sensational' ),
            'not_found'             => __( 'No destinations found', 'tanzania-sensational' ),
            'not_found_in_trash'    => __( 'No destinations found in Trash', 'tanzania-sensational' ),
            'all_items'             => __( 'All Destinations', 'tanzania-sensational' ),
            'menu_name'             => __( 'Destinations', 'tanzania-sensational' ),
        ],
        'public'              => true,
        'has_archive'         => true,
        'rewrite'             => [ 'slug' => 'safaris/destinations', 'with_front' => false ],
        'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions', 'page-attributes' ],
        'menu_icon'           => 'dashicons-location-alt',
        'menu_position'       => 22,
        'show_in_rest'        => true,
        'taxonomies'          => [ 'ts_destination_region' ],
    ] );

    /**
     * Tour category taxonomy
     */
    register_taxonomy( 'ts_tour_category', [ 'ts_tour' ], [
        'labels'            => [
            'name'          => __( 'Tour Categories', 'tanzania-sensational' ),
            'singular_name' => __( 'Tour Category', 'tanzania-sensational' ),
        ],
        'hierarchical'      => true,
        'public'            => true,
        'rewrite'           => [ 'slug' => 'safaris/category' ],
        'show_in_rest'      => true,
    ] );

    /**
     * Trekking route details use the exact source path family. The archive is
     * disabled so the existing /trekking/kilimanjaro landing page keeps its URL.
     */
    register_post_type( 'ts_trek_route', [
        'labels'              => [
            'name'                  => __( 'Trekking Routes', 'tanzania-sensational' ),
            'singular_name'         => __( 'Trekking Route', 'tanzania-sensational' ),
            'add_new_item'          => __( 'Add New Trekking Route', 'tanzania-sensational' ),
            'edit_item'             => __( 'Edit Trekking Route', 'tanzania-sensational' ),
            'all_items'             => __( 'All Trekking Routes', 'tanzania-sensational' ),
            'menu_name'             => __( 'Trekking Routes', 'tanzania-sensational' ),
        ],
        'public'              => true,
        'has_archive'         => false,
        'rewrite'             => [ 'slug' => 'trekking/kilimanjaro', 'with_front' => false ],
        'supports'            => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
        'menu_icon'           => 'dashicons-location',
        'menu_position'       => 23,
        'show_in_rest'        => true,
    ] );

    /**
     * Site Settings (global options replacement)
     */
    register_post_type( 'ts_site_setting', [
        'labels'              => [
            'name'                  => __( 'Site Settings', 'tanzania-sensational' ),
            'singular_name'         => __( 'Site Setting', 'tanzania-sensational' ),
            'edit_item'             => __( 'Edit Site Settings', 'tanzania-sensational' ),
        ],
        'public'              => false,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_icon'           => 'dashicons-admin-generic',
        'menu_position'       => 20,
        'supports'            => [ 'title' ],
        'has_archive'         => false,
        'rewrite'             => false,
        'show_in_rest'        => false,
    ] );

    /**
     * Destination region taxonomy
     */
    register_taxonomy( 'ts_destination_region', [ 'ts_destination' ], [
        'labels'            => [
            'name'          => __( 'Destination Regions', 'tanzania-sensational' ),
            'singular_name' => __( 'Destination Region', 'tanzania-sensational' ),
        ],
        'hierarchical'      => true,
        'public'            => true,
        'rewrite'           => [ 'slug' => 'safaris/region' ],
        'show_in_rest'      => true,
    ] );
}, 10 );

/**
 * Flush rewrite rules once after CPT registration on plugin activation.
 */
register_activation_hook( __FILE__, 'flush_rewrite_rules' );
