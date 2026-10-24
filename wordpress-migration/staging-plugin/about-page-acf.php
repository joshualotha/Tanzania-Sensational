<?php
/**
 * About Us page fields and renderer (ACF Free compatible).
 *
 * Uses standard ACF fields (text, textarea, image, select, WYSIWYG)
 * instead of Flexible Content / Repeater, which require ACF Pro.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$ts_about_icon_choices = [
    'shield'   => __( 'Shield', 'tanzania-sensational' ),
    'heart'    => __( 'Heart', 'tanzania-sensational' ),
    'globe'    => __( 'Globe', 'tanzania-sensational' ),
    'mountain' => __( 'Mountain', 'tanzania-sensational' ),
    'compass'  => __( 'Compass', 'tanzania-sensational' ),
    'star'     => __( 'Star', 'tanzania-sensational' ),
    'send'     => __( 'Send', 'tanzania-sensational' ),
    'map-pin'  => __( 'Map Pin', 'tanzania-sensational' ),
];

/**
 * Icon SVG helper.
 */
function ts_icon_svg( $name ) {
    $icons = [
        'shield'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        'heart'    => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
        'globe'    => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
        'mountain' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3l4 8 5-5 5 15H2L8 3z"/></svg>',
        'compass'  => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>',
        'star'     => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
        'send'     => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>',
        'map-pin'  => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
    ];
    return $icons[ $name ] ?? '';
}

/**
 * Register About page ACF fields.
 */
add_action( 'acf/include_fields', function() use ( $ts_about_icon_choices ) {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    $fields = [];

    // Hero
    $fields[] = [ 'key' => 'field_ts_about_tab_hero', 'label' => __( 'Hero', 'tanzania-sensational' ), 'name' => '', 'type' => 'tab' ];
    $fields[] = [ 'key' => 'field_ts_about_hero_eyebrow',  'label' => __( 'Eyebrow', 'tanzania-sensational' ), 'name' => 'ts_about_hero_eyebrow',  'type' => 'text', 'default_value' => 'Our Origins' ];
    $fields[] = [ 'key' => 'field_ts_about_hero_title',    'label' => __( 'Title', 'tanzania-sensational' ),   'name' => 'ts_about_hero_title',    'type' => 'text', 'default_value' => 'Born from the <em>Mountain.</em>', 'instructions' => __( 'Use <em>...</em> for italic words.', 'tanzania-sensational' ) ];
    $fields[] = [ 'key' => 'field_ts_about_hero_subtitle', 'label' => __( 'Subtitle', 'tanzania-sensational' ), 'name' => 'ts_about_hero_subtitle', 'type' => 'textarea', 'rows' => 2 ];
    $fields[] = [ 'key' => 'field_ts_about_hero_image',    'label' => __( 'Background Image', 'tanzania-sensational' ), 'name' => 'ts_about_hero_image', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium' ];

    // Stats
    $fields[] = [ 'key' => 'field_ts_about_tab_stats', 'label' => __( 'Stats Strip', 'tanzania-sensational' ), 'name' => '', 'type' => 'tab' ];
    for ( $i = 1; $i <= 4; $i++ ) {
        $fields[] = [ 'key' => "field_ts_about_stat_{$i}_number", 'label' => __( "Stat {$i} Number", 'tanzania-sensational' ), 'name' => "ts_about_stat_{$i}_number", 'type' => 'text', 'wrapper' => [ 'width' => '50' ] ];
        $fields[] = [ 'key' => "field_ts_about_stat_{$i}_label",  'label' => __( "Stat {$i} Label", 'tanzania-sensational' ),  'name' => "ts_about_stat_{$i}_label",  'type' => 'text', 'wrapper' => [ 'width' => '50' ] ];
    }

    // Story
    $fields[] = [ 'key' => 'field_ts_about_tab_story', 'label' => __( 'Story Card', 'tanzania-sensational' ), 'name' => '', 'type' => 'tab' ];
    $fields[] = [ 'key' => 'field_ts_about_story_image',      'label' => __( 'Image', 'tanzania-sensational' ),      'name' => 'ts_about_story_image',      'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium' ];
    $fields[] = [ 'key' => 'field_ts_about_story_badge_icon', 'label' => __( 'Badge Icon', 'tanzania-sensational' ), 'name' => 'ts_about_story_badge_icon', 'type' => 'select', 'choices' => $ts_about_icon_choices, 'default_value' => 'mountain' ];
    $fields[] = [ 'key' => 'field_ts_about_story_badge_text', 'label' => __( 'Badge Text', 'tanzania-sensational' ), 'name' => 'ts_about_story_badge_text', 'type' => 'text' ];
    $fields[] = [ 'key' => 'field_ts_about_story_eyebrow',    'label' => __( 'Eyebrow', 'tanzania-sensational' ),    'name' => 'ts_about_story_eyebrow',    'type' => 'text' ];
    $fields[] = [ 'key' => 'field_ts_about_story_title',      'label' => __( 'Title', 'tanzania-sensational' ),      'name' => 'ts_about_story_title',      'type' => 'text' ];
    $fields[] = [ 'key' => 'field_ts_about_story_body',       'label' => __( 'Body', 'tanzania-sensational' ),       'name' => 'ts_about_story_body',       'type' => 'wysiwyg', 'tabs' => 'all', 'toolbar' => 'basic', 'media_upload' => 0 ];

    // Mission / Vision
    $fields[] = [ 'key' => 'field_ts_about_tab_mv', 'label' => __( 'Mission / Vision', 'tanzania-sensational' ), 'name' => '', 'type' => 'tab' ];
    $fields[] = [ 'key' => 'field_ts_about_mission_icon',  'label' => __( 'Mission Icon', 'tanzania-sensational' ),  'name' => 'ts_about_mission_icon',  'type' => 'select', 'choices' => $ts_about_icon_choices, 'default_value' => 'compass', 'wrapper' => [ 'width' => '33' ] ];
    $fields[] = [ 'key' => 'field_ts_about_mission_title', 'label' => __( 'Mission Title', 'tanzania-sensational' ), 'name' => 'ts_about_mission_title', 'type' => 'text', 'wrapper' => [ 'width' => '33' ] ];
    $fields[] = [ 'key' => 'field_ts_about_mission_text',  'label' => __( 'Mission Text', 'tanzania-sensational' ),  'name' => 'ts_about_mission_text',  'type' => 'textarea', 'rows' => 3, 'wrapper' => [ 'width' => '34' ] ];
    $fields[] = [ 'key' => 'field_ts_about_vision_icon',   'label' => __( 'Vision Icon', 'tanzania-sensational' ),   'name' => 'ts_about_vision_icon',   'type' => 'select', 'choices' => $ts_about_icon_choices, 'default_value' => 'star', 'wrapper' => [ 'width' => '33' ] ];
    $fields[] = [ 'key' => 'field_ts_about_vision_title',  'label' => __( 'Vision Title', 'tanzania-sensational' ),  'name' => 'ts_about_vision_title',  'type' => 'text', 'wrapper' => [ 'width' => '33' ] ];
    $fields[] = [ 'key' => 'field_ts_about_vision_text',   'label' => __( 'Vision Text', 'tanzania-sensational' ),   'name' => 'ts_about_vision_text',   'type' => 'textarea', 'rows' => 3, 'wrapper' => [ 'width' => '34' ] ];

    // Values
    $fields[] = [ 'key' => 'field_ts_about_tab_values', 'label' => __( 'Values Grid', 'tanzania-sensational' ), 'name' => '', 'type' => 'tab' ];
    $fields[] = [ 'key' => 'field_ts_about_values_eyebrow', 'label' => __( 'Eyebrow', 'tanzania-sensational' ), 'name' => 'ts_about_values_eyebrow', 'type' => 'text' ];
    $fields[] = [ 'key' => 'field_ts_about_values_title',   'label' => __( 'Title', 'tanzania-sensational' ),   'name' => 'ts_about_values_title',   'type' => 'text', 'instructions' => __( 'Use <em>...</em> for italic words.', 'tanzania-sensational' ) ];
    for ( $i = 1; $i <= 4; $i++ ) {
        $fields[] = [ 'key' => "field_ts_about_value_{$i}_icon",        'label' => __( "Value {$i} Icon", 'tanzania-sensational' ),        'name' => "ts_about_value_{$i}_icon",        'type' => 'select', 'choices' => $ts_about_icon_choices, 'wrapper' => [ 'width' => '33' ] ];
        $fields[] = [ 'key' => "field_ts_about_value_{$i}_title",       'label' => __( "Value {$i} Title", 'tanzania-sensational' ),       'name' => "ts_about_value_{$i}_title",       'type' => 'text', 'wrapper' => [ 'width' => '33' ] ];
        $fields[] = [ 'key' => "field_ts_about_value_{$i}_description", 'label' => __( "Value {$i} Description", 'tanzania-sensational' ), 'name' => "ts_about_value_{$i}_description", 'type' => 'textarea', 'rows' => 3, 'wrapper' => [ 'width' => '34' ] ];
    }

    // Experience Band
    $fields[] = [ 'key' => 'field_ts_about_tab_exp', 'label' => __( 'Experience Band', 'tanzania-sensational' ), 'name' => '', 'type' => 'tab' ];
    $fields[] = [ 'key' => 'field_ts_about_exp_image',     'label' => __( 'Background Image', 'tanzania-sensational' ), 'name' => 'ts_about_exp_image',     'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium' ];
    $fields[] = [ 'key' => 'field_ts_about_exp_eyebrow',   'label' => __( 'Eyebrow', 'tanzania-sensational' ),          'name' => 'ts_about_exp_eyebrow',   'type' => 'text' ];
    $fields[] = [ 'key' => 'field_ts_about_exp_title',     'label' => __( 'Title', 'tanzania-sensational' ),            'name' => 'ts_about_exp_title',     'type' => 'text', 'instructions' => __( 'Use <em>...</em> for italic words.', 'tanzania-sensational' ) ];
    $fields[] = [ 'key' => 'field_ts_about_exp_cta_label', 'label' => __( 'CTA Label', 'tanzania-sensational' ),        'name' => 'ts_about_exp_cta_label', 'type' => 'text' ];
    $fields[] = [ 'key' => 'field_ts_about_exp_cta_url',   'label' => __( 'CTA URL', 'tanzania-sensational' ),          'name' => 'ts_about_exp_cta_url',   'type' => 'text' ];
    for ( $i = 1; $i <= 3; $i++ ) {
        $fields[] = [ 'key' => "field_ts_about_exp_item_{$i}_number", 'label' => __( "Experience {$i} Number", 'tanzania-sensational' ), 'name' => "ts_about_exp_item_{$i}_number", 'type' => 'text', 'wrapper' => [ 'width' => '33' ] ];
        $fields[] = [ 'key' => "field_ts_about_exp_item_{$i}_title",  'label' => __( "Experience {$i} Title", 'tanzania-sensational' ),  'name' => "ts_about_exp_item_{$i}_title",  'type' => 'text', 'wrapper' => [ 'width' => '33' ] ];
        $fields[] = [ 'key' => "field_ts_about_exp_item_{$i}_text",   'label' => __( "Experience {$i} Text", 'tanzania-sensational' ),   'name' => "ts_about_exp_item_{$i}_text",   'type' => 'textarea', 'rows' => 3, 'wrapper' => [ 'width' => '34' ] ];
    }

    $about_page    = get_page_by_path( 'about-us' );
    $about_page_id = $about_page ? (string) $about_page->ID : '18';

    acf_add_local_field_group( [
        'key'                   => 'group_ts_about_page_free',
        'title'                 => __( 'About Page Content', 'tanzania-sensational' ),
        'fields'                => $fields,
        'location'              => [
            [
                [
                    'param'    => 'page',
                    'operator' => '==',
                    'value'    => $about_page_id,
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

/**
 * Helper to safely fetch an About page field.
 */
function ts_about_field( $key, $post_id = 0, $default = '' ) {
    if ( ! function_exists( 'get_field' ) ) {
        return $default;
    }
    $post_id = $post_id ?: get_the_ID();
    $value   = get_field( $key, $post_id );
    return $value ?: $default;
}

/**
 * Render the About page from standard ACF fields.
 */
function ts_render_about_page_acf( $post_id = 0 ) {
    $post_id = $post_id ?: get_the_ID();

    $hero_image = ts_about_field( 'ts_about_hero_image', $post_id );
    $hero_image = $hero_image ?: 'https://images.unsplash.com/photo-1621414050946-1b936a78490b?q=80&w=2000&auto=format&fit=crop';

    $story_image = ts_about_field( 'ts_about_story_image', $post_id );
    $story_image = $story_image ?: 'https://images.unsplash.com/photo-1631646109206-4919df38eb68?q=80&w=800&auto=format&fit=crop';

    $exp_image = ts_about_field( 'ts_about_exp_image', $post_id );
    $exp_image = $exp_image ?: 'https://images.unsplash.com/photo-1650668302197-7f556c34cb91?q=80&w=2000&auto=format&fit=crop';

    ob_start();
    ?>
    <div class="about-premium-root">
        <section class="premium-about-hero">
            <div class="premium-about-bg">
                <img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( strip_tags( ts_about_field( 'ts_about_hero_title', $post_id ) ) ); ?>" />
                <div class="premium-about-overlay"></div>
            </div>
            <div class="container">
                <div class="premium-about-content">
                    <?php if ( $eyebrow = ts_about_field( 'ts_about_hero_eyebrow', $post_id ) ) : ?>
                        <span class="premium-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                    <?php endif; ?>
                    <?php if ( $title = ts_about_field( 'ts_about_hero_title', $post_id ) ) : ?>
                        <h1 class="premium-hero-title"><?php echo wp_kses_post( $title ); ?></h1>
                    <?php endif; ?>
                    <?php if ( $subtitle = ts_about_field( 'ts_about_hero_subtitle', $post_id ) ) : ?>
                        <p class="premium-hero-subtitle"><?php echo esc_html( $subtitle ); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="premium-stats-strip">
                <div class="premium-stats-grid">
                    <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
                        <?php
                        $number = ts_about_field( "ts_about_stat_{$i}_number", $post_id );
                        $label  = ts_about_field( "ts_about_stat_{$i}_label", $post_id );
                        if ( $number || $label ) :
                        ?>
                            <div class="premium-stat-item">
                                <span class="premium-stat-num"><?php echo esc_html( $number ); ?></span>
                                <span class="premium-stat-label"><?php echo esc_html( $label ); ?></span>
                            </div>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
        </section>

        <section class="premium-story-section">
            <div class="premium-story-card">
                <div class="premium-story-image">
                    <img src="<?php echo esc_url( $story_image ); ?>" alt="<?php echo esc_attr( strip_tags( ts_about_field( 'ts_about_story_title', $post_id ) ) ); ?>" />
                    <?php if ( $badge_text = ts_about_field( 'ts_about_story_badge_text', $post_id ) ) : ?>
                        <div class="premium-story-badge">
                            <?php echo ts_icon_svg( ts_about_field( 'ts_about_story_badge_icon', $post_id, 'mountain' ) ); ?>
                            <span><?php echo esc_html( $badge_text ); ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="premium-story-content">
                    <?php if ( $eyebrow = ts_about_field( 'ts_about_story_eyebrow', $post_id ) ) : ?>
                        <span class="premium-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                    <?php endif; ?>
                    <?php if ( $title = ts_about_field( 'ts_about_story_title', $post_id ) ) : ?>
                        <h2 class="premium-story-title"><?php echo wp_kses_post( $title ); ?></h2>
                    <?php endif; ?>
                    <?php if ( $body = ts_about_field( 'ts_about_story_body', $post_id ) ) : ?>
                        <div class="premium-story-body-wrap"><?php echo wp_kses_post( $body ); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <section class="premium-mv-section">
            <div class="premium-mv-grid">
                <?php
                $mv = [
                    [ 'icon' => ts_about_field( 'ts_about_mission_icon', $post_id, 'compass' ), 'title' => ts_about_field( 'ts_about_mission_title', $post_id ), 'text' => ts_about_field( 'ts_about_mission_text', $post_id ) ],
                    [ 'icon' => ts_about_field( 'ts_about_vision_icon', $post_id, 'star' ),    'title' => ts_about_field( 'ts_about_vision_title', $post_id ),  'text' => ts_about_field( 'ts_about_vision_text', $post_id ) ],
                ];
                foreach ( $mv as $item ) :
                    if ( ! $item['title'] && ! $item['text'] ) continue;
                ?>
                    <div class="premium-mv-card">
                        <div class="premium-mv-inner">
                            <svg class="premium-mv-icon" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <?php echo ts_icon_svg( $item['icon'] ); ?>
                            </svg>
                            <h3 class="premium-mv-title"><?php echo esc_html( $item['title'] ); ?></h3>
                            <p class="premium-mv-text"><?php echo esc_html( $item['text'] ); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="premium-values-section">
            <div class="premium-values-container">
                <div class="premium-values-head">
                    <?php if ( $eyebrow = ts_about_field( 'ts_about_values_eyebrow', $post_id ) ) : ?>
                        <span class="premium-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                    <?php endif; ?>
                    <?php if ( $title = ts_about_field( 'ts_about_values_title', $post_id ) ) : ?>
                        <h2 class="premium-values-title"><?php echo wp_kses_post( $title ); ?></h2>
                    <?php endif; ?>
                </div>
                <div class="premium-values-grid">
                    <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
                        <?php
                        $icon = ts_about_field( "ts_about_value_{$i}_icon", $post_id );
                        $title = ts_about_field( "ts_about_value_{$i}_title", $post_id );
                        $desc  = ts_about_field( "ts_about_value_{$i}_description", $post_id );
                        if ( ! $title && ! $desc ) continue;
                        ?>
                        <div class="premium-value-card">
                            <div class="premium-value-icon"><?php echo ts_icon_svg( $icon ); ?></div>
                            <h4 class="premium-value-title"><?php echo esc_html( $title ); ?></h4>
                            <p class="premium-value-desc"><?php echo esc_html( $desc ); ?></p>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </section>

        <section class="premium-exp-section">
            <div class="premium-exp-bg">
                <img src="<?php echo esc_url( $exp_image ); ?>" alt="<?php echo esc_attr( strip_tags( ts_about_field( 'ts_about_exp_title', $post_id ) ) ); ?>" />
                <div class="premium-exp-overlay"></div>
            </div>
            <div class="premium-exp-container">
                <div class="premium-exp-left">
                    <?php if ( $eyebrow = ts_about_field( 'ts_about_exp_eyebrow', $post_id ) ) : ?>
                        <span class="premium-eyebrow" style="color:white;"><?php echo esc_html( $eyebrow ); ?></span>
                    <?php endif; ?>
                    <?php if ( $title = ts_about_field( 'ts_about_exp_title', $post_id ) ) : ?>
                        <h2 class="premium-exp-title"><?php echo wp_kses_post( $title ); ?></h2>
                    <?php endif; ?>
                    <?php
                    $cta_label = ts_about_field( 'ts_about_exp_cta_label', $post_id );
                    $cta_url   = ts_about_field( 'ts_about_exp_cta_url', $post_id );
                    if ( $cta_label && $cta_url ) :
                    ?>
                        <a href="<?php echo esc_url( $cta_url ); ?>" class="premium-exp-cta">
                            <span><?php echo esc_html( $cta_label ); ?></span>
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="premium-exp-list">
                    <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                        <?php
                        $number = ts_about_field( "ts_about_exp_item_{$i}_number", $post_id );
                        $title  = ts_about_field( "ts_about_exp_item_{$i}_title", $post_id );
                        $text   = ts_about_field( "ts_about_exp_item_{$i}_text", $post_id );
                        if ( ! $title && ! $text ) continue;
                        ?>
                        <div class="premium-exp-item">
                            <span class="premium-exp-num"><?php echo esc_html( $number ); ?></span>
                            <div>
                                <h4 class="premium-exp-item-title"><?php echo esc_html( $title ); ?></h4>
                                <p class="premium-exp-item-text"><?php echo esc_html( $text ); ?></p>
                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </section>
    </div>
    <?php
    return ob_get_clean();
}

/**
 * Override the About page shortcode to use ACF fields.
 */
add_shortcode( 'ts_about_page', function() {
    $post_id = get_the_ID();
    if ( function_exists( 'get_field' ) && get_field( 'ts_about_hero_title', $post_id ) ) {
        return ts_render_about_page_acf( $post_id );
    }
    return ts_about_page_legacy();
} );

/**
 * Legacy About page markup.
 * Used as a fallback when ACF is unavailable or no fields are populated.
 */
function ts_about_page_legacy() {
    $hero    = 'https://images.unsplash.com/photo-1621414050946-1b936a78490b?q=80&w=2000&auto=format&fit=crop';
    $legacy  = 'https://images.unsplash.com/photo-1631646109206-4919df38eb68?q=80&w=800&auto=format&fit=crop';
    $band    = 'https://images.unsplash.com/photo-1650668302197-7f556c34cb91?q=80&w=2000&auto=format&fit=crop';
    ob_start();
    ?>
    <div class="about-premium-root">
        <section class="premium-about-hero">
            <div class="premium-about-bg">
                <img src="<?php echo esc_url( $hero ); ?>" alt="Mount Kilimanjaro summit at dawn" />
                <div class="premium-about-overlay"></div>
            </div>
            <div class="container">
                <div class="premium-about-content">
                    <span class="premium-eyebrow">Our Origins</span>
                    <h1 class="premium-hero-title">Born from the <em>Mountain.</em></h1>
                    <p class="premium-hero-subtitle">We didn't just start an expedition company. We inherited a calling—to share the incredible majesty of East Africa with the world.</p>
                </div>
            </div>
            <div class="premium-stats-strip">
                <div class="premium-stats-grid">
                    <div class="premium-stat-item"><span class="premium-stat-num">15+</span><span class="premium-stat-label">Years of Mastery</span></div>
                    <div class="premium-stat-item"><span class="premium-stat-num">5,000+</span><span class="premium-stat-label">Summits Achieved</span></div>
                    <div class="premium-stat-item"><span class="premium-stat-num">98%</span><span class="premium-stat-label">Success Rate</span></div>
                    <div class="premium-stat-item"><span class="premium-stat-num">50+</span><span class="premium-stat-label">Elite Guides</span></div>
                </div>
            </div>
        </section>

        <section class="premium-story-section">
            <div class="premium-story-card">
                <div class="premium-story-image">
                    <img src="<?php echo esc_url( $legacy ); ?>" alt="Trekking trail on Kilimanjaro" />
                    <div class="premium-story-badge">
                        <?php echo ts_icon_svg( 'mountain' ); ?>
                        <span>Established 2010</span>
                    </div>
                </div>
                <div class="premium-story-content">
                    <span class="premium-eyebrow">The Beginning</span>
                    <h2 class="premium-story-title">From a single trail to a <em>Legacy.</em></h2>
                    <p class="premium-story-body">Tanzania Sensational was born from a simple belief: that the mountains and savannas of East Africa deserve to be experienced at the absolute highest standard of excellence.</p>
                    <p class="premium-story-body">Our founder grew up in the shadow of Kilimanjaro. That deep, inherent respect for the mountain became the foundation of our entire operation. Today, we architect luxury expeditions across Kilimanjaro, Mount Meru, the Serengeti, and Zanzibar—always with one principle: excellence without compromise.</p>
                </div>
            </div>
        </section>

        <section class="premium-mv-section">
            <div class="premium-mv-grid">
                <div class="premium-mv-card">
                    <div class="premium-mv-inner">
                        <svg class="premium-mv-icon" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
                        <h3 class="premium-mv-title">The Mission</h3>
                        <p class="premium-mv-text">To engineer transformative travel experiences that connect the world's most discerning adventurers with East Africa's greatest natural wonders—safely, sustainably, and unforgettably.</p>
                    </div>
                </div>
                <div class="premium-mv-card">
                    <div class="premium-mv-inner">
                        <svg class="premium-mv-icon" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <h3 class="premium-mv-title">The Vision</h3>
                        <p class="premium-mv-text">To be universally recognized as the gold standard in bespoke expedition travel, continually setting incredible new benchmarks for uncompromising safety, service, and environmental stewardship.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="premium-values-section">
            <div class="premium-values-container">
                <div class="premium-values-head">
                    <span class="premium-eyebrow">What Guides Us</span>
                    <h2 class="premium-values-title">The Principles Behind Every <em>Expedition.</em></h2>
                </div>
                <div class="premium-values-grid">
                    <div class="premium-value-card">
                        <div class="premium-value-icon"><?php echo ts_icon_svg( 'shield' ); ?></div>
                        <h4 class="premium-value-title">Safety Ascendant</h4>
                        <p class="premium-value-desc">Every expedition is meticulously engineered with certified elite guides, cutting-edge equipment, and rapid-response protocols that exceed international standards.</p>
                    </div>
                    <div class="premium-value-card">
                        <div class="premium-value-icon"><?php echo ts_icon_svg( 'heart' ); ?></div>
                        <h4 class="premium-value-title">Authentic Immersion</h4>
                        <p class="premium-value-desc">We go beyond the traditional tourist veil. Each journey is carefully crafted to create genuine, profound connections with Tanzania's landscapes and people.</p>
                    </div>
                    <div class="premium-value-card">
                        <div class="premium-value-icon"><?php echo ts_icon_svg( 'globe' ); ?></div>
                        <h4 class="premium-value-title">Responsible Travel</h4>
                        <p class="premium-value-desc">We mandate strict group sizes, actively drive local economies, and respect carrying capacities to ensure Tanzania's pristine wilderness thrives.</p>
                    </div>
                    <div class="premium-value-card">
                        <div class="premium-value-icon"><?php echo ts_icon_svg( 'mountain' ); ?></div>
                        <h4 class="premium-value-title">Conservation Legacy</h4>
                        <p class="premium-value-desc">A portion of every expedition directly funds proactive reforestation, critical wildlife corridors, and vital community education programs.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="premium-exp-section">
            <div class="premium-exp-bg">
                <img src="<?php echo esc_url( $band ); ?>" alt="Tanzania Sensational trekking group" />
                <div class="premium-exp-overlay"></div>
            </div>
            <div class="premium-exp-container">
                <div class="premium-exp-left">
                    <span class="premium-eyebrow" style="color:white;">The Difference</span>
                    <h2 class="premium-exp-title">Experience That <em>Speaks.</em></h2>
                    <a href="/contact" class="premium-exp-cta"><span>Initialize Your Expedition</span><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                </div>
                <div class="premium-exp-list">
                    <div class="premium-exp-item"><span class="premium-exp-num">01</span><div><h4 class="premium-exp-item-title">Locally Born, Globally Trusted</h4><p class="premium-exp-item-text">Our architects were raised in the Kilimanjaro region. We don't just guide on the mountain—we live it, breathe it, and protect it.</p></div></div>
                    <div class="premium-exp-item"><span class="premium-exp-num">02</span><div><h4 class="premium-exp-item-title">Precision-Planned Itineraries</h4><p class="premium-exp-item-text">Every detail is painstakingly considered—from specialized acclimatization schedules to high-altitude luxury cuisine. Nothing is left to chance.</p></div></div>
                    <div class="premium-exp-item"><span class="premium-exp-num">03</span><div><h4 class="premium-exp-item-title">Summit Success, Not Attempts</h4><p class="premium-exp-item-text">Our unparalleled 98% success rate isn't luck—it's the direct result of expert route selection, superior guide training, and an absolute obsession with client wellbeing.</p></div></div>
                </div>
            </div>
        </section>
    </div>
    <?php
    return ob_get_clean();
}
