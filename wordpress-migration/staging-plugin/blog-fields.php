<?php
/** Editable metadata for source-matched blog articles. */
if (!defined('ABSPATH')) {
    // Unit tests may load the field schema without booting WordPress.
}

add_action('acf/init', static function (): void {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group([
        'key' => 'group_ts_blog_article',
        'title' => __('Tanzania Sensational Blog Article', 'tanzania-sensational'),
        'fields' => [
            [
                'key' => 'field_ts_blog_author_display',
                'label' => __('Displayed Author', 'tanzania-sensational'),
                'name' => 'ts_blog_author_display',
                'type' => 'text',
                'default_value' => 'Tanzania Sensational',
                'instructions' => __('Displayed in the article and archive metadata.', 'tanzania-sensational'),
                'required' => 0,
            ],
            [
                'key' => 'field_ts_blog_featured',
                'label' => __('Featured Journal Story', 'tanzania-sensational'),
                'name' => 'ts_blog_featured',
                'type' => 'true_false',
                'ui' => 1,
                'default_value' => 0,
                'instructions' => __('Use for the single lead story on the /blog index.', 'tanzania-sensational'),
            ],
            [
                'key' => 'field_ts_blog_hero_image_url',
                'label' => __('Hero / Card Image URL', 'tanzania-sensational'),
                'name' => 'ts_blog_hero_image_url',
                'type' => 'url',
                'instructions' => __('Use the verified source URL. Leave empty when the source image is unavailable; do not substitute another image.', 'tanzania-sensational'),
                'required' => 0,
            ],
            [
                'key' => 'field_ts_blog_hero_image_alt',
                'label' => __('Hero / Card Image Alt Text', 'tanzania-sensational'),
                'name' => 'ts_blog_hero_image_alt',
                'type' => 'text',
                'instructions' => __('Describe the source image; decorative images may use an empty value.', 'tanzania-sensational'),
                'required' => 0,
            ],
            [
                'key' => 'field_ts_blog_source_url',
                'label' => __('Source Article URL', 'tanzania-sensational'),
                'name' => 'ts_blog_source_url',
                'type' => 'url',
                'instructions' => __('Reference URL used for the migration audit.', 'tanzania-sensational'),
                'required' => 0,
            ],
        ],
        'location' => [[
            [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'post',
            ],
        ]],
        'menu_order' => 5,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'show_in_rest' => 1,
        'description' => __('Source-managed metadata for the public blog archive and single-post layout.', 'tanzania-sensational'),
    ]);
});
