<?php
/**
 * One-time helper to create core Oxygen templates.
 * Run via: wp eval-file wp-content/plugins/tanzania-sensational-design/create-templates.php
 */

// Main template: wraps header, inner content, footer, WhatsApp.
$main_json = json_encode( [
    'name'     => 'root',
    'children' => [
        [
            'id'      => 1,
            'name'    => 'ct_shortcode',
            'options' => [
                'ct_id'     => 1,
                'ct_parent' => 0,
                'original'  => [
                    'full_shortcode' => '[ts_header]',
                    'tag'            => 'header',
                ],
            ],
        ],
        [
            'id'      => 2,
            'name'    => 'ct_inner_content',
            'options' => [
                'ct_id'     => 2,
                'ct_parent' => 0,
                'original'  => [
                    'tag' => 'main',
                ],
            ],
        ],
        [
            'id'      => 3,
            'name'    => 'ct_shortcode',
            'options' => [
                'ct_id'     => 3,
                'ct_parent' => 0,
                'original'  => [
                    'full_shortcode' => '[ts_footer]',
                    'tag'            => 'footer',
                ],
            ],
        ],
        [
            'id'      => 4,
            'name'    => 'ct_shortcode',
            'options' => [
                'ct_id'     => 4,
                'ct_parent' => 0,
                'original'  => [
                    'full_shortcode' => '[ts_whatsapp]',
                    'tag'            => 'div',
                ],
            ],
        ],
    ],
] );

$main_id = wp_insert_post( [
    'post_title'  => 'Main',
    'post_name'   => 'main',
    'post_type'   => 'ct_template',
    'post_status' => 'publish',
    'post_author' => 1,
] );

if ( $main_id && ! is_wp_error( $main_id ) ) {
    update_post_meta( $main_id, 'ct_template_type', 'other_template' );
    update_post_meta( $main_id, 'ct_template_single_all', 'true' );
    update_post_meta( $main_id, 'ct_template_index', 'true' );
    update_post_meta( $main_id, 'ct_template_front_page', 'true' );
    update_post_meta( $main_id, 'ct_template_all_archives', 'true' );
    update_post_meta( $main_id, 'ct_template_search_page', 'true' );
    update_post_meta( $main_id, 'ct_builder_json', $main_json );
    update_post_meta( $main_id, 'ct_builder_shortcodes', '' );
    echo "Main template created: {$main_id}\n";
} else {
    echo "Failed to create Main template.\n";
}

// 404 template.
$four_oh_four_json = json_encode( [
    'name'     => 'root',
    'children' => [
        [
            'id'      => 1,
            'name'    => 'ct_shortcode',
            'options' => [
                'ct_id'     => 1,
                'ct_parent' => 0,
                'original'  => [
                    'full_shortcode' => '[ts_404]',
                    'tag'            => 'section',
                ],
            ],
        ],
    ],
] );

$four_id = wp_insert_post( [
    'post_title'  => '404',
    'post_name'   => '404',
    'post_type'   => 'ct_template',
    'post_status' => 'publish',
    'post_author' => 1,
] );

if ( $four_id && ! is_wp_error( $four_id ) ) {
    update_post_meta( $four_id, 'ct_template_type', 'other_template' );
    update_post_meta( $four_id, 'ct_template_404_page', 'true' );
    update_post_meta( $four_id, 'ct_builder_json', $four_oh_four_json );
    update_post_meta( $four_id, 'ct_builder_shortcodes', '' );
    echo "404 template created: {$four_id}\n";
} else {
    echo "Failed to create 404 template.\n";
}
