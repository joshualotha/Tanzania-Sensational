<?php
/**
 * Global site settings (contact, social, header, footer).
 *
 * Uses a hidden CPT because ACF Options pages require ACF Pro.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get the global site settings post ID.
 * Creates it if it does not exist.
 */
function ts_get_site_settings_post_id() {
    $transient_key = 'ts_site_settings_post_id';
    $post_id       = get_transient( $transient_key );

    if ( $post_id ) {
        $post = get_post( $post_id );
        if ( $post && $post->post_status === 'publish' ) {
            return (int) $post_id;
        }
    }

    $posts = get_posts( [
        'post_type'      => 'ts_site_setting',
        'posts_per_page' => 1,
        'fields'         => 'ids',
        'post_status'    => 'publish',
    ] );

    if ( ! empty( $posts ) ) {
        $post_id = (int) $posts[0];
        set_transient( $transient_key, $post_id, DAY_IN_SECONDS );
        return $post_id;
    }

    $post_id = wp_insert_post( [
        'post_type'   => 'ts_site_setting',
        'post_title'  => __( 'Global Site Settings', 'tanzania-sensational' ),
        'post_name'   => 'global',
        'post_status' => 'publish',
    ], true );

    if ( is_wp_error( $post_id ) ) {
        return 0;
    }

    set_transient( $transient_key, $post_id, DAY_IN_SECONDS );
    return (int) $post_id;
}

/**
 * Get a global site setting value.
 */
function ts_get_site_field( $key, $default = '' ) {
    if ( ! function_exists( 'get_field' ) ) {
        return $default;
    }
    $post_id = ts_get_site_settings_post_id();
    if ( ! $post_id ) {
        return $default;
    }
    $value = get_field( $key, $post_id );
    return $value ?: $default;
}

/**
 * Register the ACF field group for site settings.
 */
add_action( 'acf/include_fields', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( [
        'key'                   => 'group_ts_site_settings',
        'title'                 => __( 'Global Site Settings', 'tanzania-sensational' ),
        'fields'                => [
            [
                'key'   => 'tab_ts_contact',
                'label' => __( 'Contact Details', 'tanzania-sensational' ),
                'name'  => '',
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_ts_phone',
                'label'         => __( 'Phone Number', 'tanzania-sensational' ),
                'name'          => 'ts_phone',
                'type'          => 'text',
                'default_value' => '+255-621220912',
            ],
            [
                'key'           => 'field_ts_email',
                'label'         => __( 'Email Address', 'tanzania-sensational' ),
                'name'          => 'ts_email',
                'type'          => 'text',
                'default_value' => 'info@tanzaniasensational.co.tz',
            ],
            [
                'key'           => 'field_ts_address',
                'label'         => __( 'Address', 'tanzania-sensational' ),
                'name'          => 'ts_address',
                'type'          => 'text',
                'default_value' => 'Moshi, Kilimanjaro Region',
            ],
            [
                'key'   => 'tab_ts_social',
                'label' => __( 'Social Links', 'tanzania-sensational' ),
                'name'  => '',
                'type'  => 'tab',
            ],
            [
                'key'   => 'field_ts_social_instagram',
                'label' => __( 'Instagram', 'tanzania-sensational' ),
                'name'  => 'ts_social_instagram',
                'type'  => 'url',
            ],
            [
                'key'   => 'field_ts_social_facebook',
                'label' => __( 'Facebook', 'tanzania-sensational' ),
                'name'  => 'ts_social_facebook',
                'type'  => 'url',
            ],
            [
                'key'   => 'field_ts_social_linkedin',
                'label' => __( 'LinkedIn', 'tanzania-sensational' ),
                'name'  => 'ts_social_linkedin',
                'type'  => 'url',
            ],
            [
                'key'   => 'field_ts_social_twitter',
                'label' => __( 'Twitter / X', 'tanzania-sensational' ),
                'name'  => 'ts_social_twitter',
                'type'  => 'url',
            ],
            [
                'key'   => 'field_ts_social_youtube',
                'label' => __( 'YouTube', 'tanzania-sensational' ),
                'name'  => 'ts_social_youtube',
                'type'  => 'url',
            ],
            [
                'key'   => 'tab_ts_header',
                'label' => __( 'Header', 'tanzania-sensational' ),
                'name'  => '',
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_ts_header_cta_label',
                'label'         => __( 'Topbar CTA Label', 'tanzania-sensational' ),
                'name'          => 'ts_header_cta_label',
                'type'          => 'text',
                'default_value' => 'Book Now',
            ],
            [
                'key'           => 'field_ts_header_cta_url',
                'label'         => __( 'Topbar CTA URL', 'tanzania-sensational' ),
                'name'          => 'ts_header_cta_url',
                'type'          => 'text',
                'default_value' => '/booking',
            ],
            [
                'key'   => 'tab_ts_footer',
                'label' => __( 'Footer', 'tanzania-sensational' ),
                'name'  => '',
                'type'  => 'tab',
            ],
            [
                'key'           => 'field_ts_footer_tagline',
                'label'         => __( 'Footer Tagline', 'tanzania-sensational' ),
                'name'          => 'ts_footer_tagline',
                'type'          => 'textarea',
                'default_value' => "East Africa's premier safari outfitter. Guiding adventurers across the Serengeti, Ngorongoro, and Kilimanjaro since 2009.",
                'rows'          => 3,
            ],
            [
                'key'           => 'field_ts_footer_newsletter_eyebrow',
                'label'         => __( 'Newsletter Eyebrow', 'tanzania-sensational' ),
                'name'          => 'ts_footer_newsletter_eyebrow',
                'type'          => 'text',
                'default_value' => 'Stay Connected',
            ],
            [
                'key'           => 'field_ts_footer_newsletter_title',
                'label'         => __( 'Newsletter Title', 'tanzania-sensational' ),
                'name'          => 'ts_footer_newsletter_title',
                'type'          => 'text',
                'default_value' => 'Stories from <em>the wild</em>',
            ],
            [
                'key'           => 'field_ts_footer_newsletter_subtitle',
                'label'         => __( 'Newsletter Subtitle', 'tanzania-sensational' ),
                'name'          => 'ts_footer_newsletter_subtitle',
                'type'          => 'textarea',
                'default_value' => 'Safari dispatches, wildlife stories & exclusive departure alerts, delivered to your inbox.',
                'rows'          => 2,
            ],
            [
                'key'           => 'field_ts_footer_copyright',
                'label'         => __( 'Copyright Text', 'tanzania-sensational' ),
                'name'          => 'ts_footer_copyright',
                'type'          => 'text',
                'default_value' => '© ' . date( 'Y' ) . ' Tanzania Sensational',
            ],
            [
                'key'           => 'field_ts_footer_crafted',
                'label'         => __( 'Crafted Byline', 'tanzania-sensational' ),
                'name'          => 'ts_footer_crafted',
                'type'          => 'text',
                'default_value' => 'Crafted with purpose in Tanzania',
            ],
        ],
        'location'              => [
            [
                [
                    'param'    => 'post_type',
                    'operator' => '==',
                    'value'    => 'ts_site_setting',
                ],
            ],
        ],
        'menu_order'            => 0,
        'position'              => 'normal',
        'style'                 => 'default',
        'label_placement'       => 'top',
        'instruction_placement' => 'label',
        'active'                => true,
    ] );
} );
