<?php
/**
 * Flexible content pages (proof-of-concept: About Us).
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Icon SVG helper for flexible sections.
 */
function ts_icon_svg( $name ) {
    $icons = [
        'shield' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        'heart'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
        'globe'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
        'mountain' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3l4 8 5-5 5 15H2L8 3z"/></svg>',
        'compass' => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>',
        'star'    => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
        'send'    => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>',
        'map-pin' => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
    ];
    return $icons[ $name ] ?? '';
}

/**
 * Register ACF field group for the About page.
 */
add_action( 'acf/include_fields', function() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    $icon_choices = [
        'shield'   => __( 'Shield', 'tanzania-sensational' ),
        'heart'    => __( 'Heart', 'tanzania-sensational' ),
        'globe'    => __( 'Globe', 'tanzania-sensational' ),
        'mountain' => __( 'Mountain', 'tanzania-sensational' ),
        'compass'  => __( 'Compass', 'tanzania-sensational' ),
        'star'     => __( 'Star', 'tanzania-sensational' ),
        'send'     => __( 'Send', 'tanzania-sensational' ),
        'map-pin'  => __( 'Map Pin', 'tanzania-sensational' ),
    ];

    acf_add_local_field_group( [
        'key'                   => 'group_ts_about_page',
        'title'                 => __( 'About Page Sections', 'tanzania-sensational' ),
        'fields'                => [
            [
                'key'          => 'field_ts_about_sections',
                'label'        => __( 'Page Sections', 'tanzania-sensational' ),
                'name'         => 'ts_about_sections',
                'type'         => 'flexible_content',
                'button_label' => __( 'Add Section', 'tanzania-sensational' ),
                'layouts'      => [
                    'layout_hero' => [
                        'key'        => 'layout_hero',
                        'name'       => 'hero',
                        'label'      => __( 'Hero', 'tanzania-sensational' ),
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'           => 'field_about_hero_eyebrow',
                                'label'         => __( 'Eyebrow', 'tanzania-sensational' ),
                                'name'          => 'eyebrow',
                                'type'          => 'text',
                            ],
                            [
                                'key'           => 'field_about_hero_title',
                                'label'         => __( 'Title', 'tanzania-sensational' ),
                                'name'          => 'title',
                                'type'          => 'text',
                                'instructions'  => __( 'Use <em> tags around words you want italic.', 'tanzania-sensational' ),
                            ],
                            [
                                'key'           => 'field_about_hero_subtitle',
                                'label'         => __( 'Subtitle', 'tanzania-sensational' ),
                                'name'          => 'subtitle',
                                'type'          => 'textarea',
                                'rows'          => 2,
                            ],
                            [
                                'key'           => 'field_about_hero_image',
                                'label'         => __( 'Background Image', 'tanzania-sensational' ),
                                'name'          => 'background_image',
                                'type'          => 'image',
                                'return_format' => 'url',
                                'preview_size'  => 'medium',
                            ],
                        ],
                    ],
                    'layout_stats' => [
                        'key'        => 'layout_stats',
                        'name'       => 'stats_strip',
                        'label'      => __( 'Stats Strip', 'tanzania-sensational' ),
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'        => 'field_about_stats',
                                'label'      => __( 'Stats', 'tanzania-sensational' ),
                                'name'       => 'stats',
                                'type'       => 'repeater',
                                'min'        => 1,
                                'max'        => 6,
                                'sub_fields' => [
                                    [
                                        'key'   => 'field_about_stats_number',
                                        'label' => __( 'Number', 'tanzania-sensational' ),
                                        'name'  => 'number',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_about_stats_label',
                                        'label' => __( 'Label', 'tanzania-sensational' ),
                                        'name'  => 'label',
                                        'type'  => 'text',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'layout_story' => [
                        'key'        => 'layout_story',
                        'name'       => 'story_card',
                        'label'      => __( 'Story Card', 'tanzania-sensational' ),
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'           => 'field_about_story_image',
                                'label'         => __( 'Image', 'tanzania-sensational' ),
                                'name'          => 'image',
                                'type'          => 'image',
                                'return_format' => 'url',
                                'preview_size'  => 'medium',
                            ],
                            [
                                'key'   => 'field_about_story_badge_icon',
                                'label' => __( 'Badge Icon', 'tanzania-sensational' ),
                                'name'  => 'badge_icon',
                                'type'  => 'select',
                                'choices' => $icon_choices,
                                'default_value' => 'mountain',
                            ],
                            [
                                'key'   => 'field_about_story_badge_text',
                                'label' => __( 'Badge Text', 'tanzania-sensational' ),
                                'name'  => 'badge_text',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_about_story_eyebrow',
                                'label' => __( 'Eyebrow', 'tanzania-sensational' ),
                                'name'  => 'eyebrow',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_about_story_title',
                                'label' => __( 'Title', 'tanzania-sensational' ),
                                'name'  => 'title',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_about_story_body',
                                'label' => __( 'Body', 'tanzania-sensational' ),
                                'name'  => 'body',
                                'type'  => 'wysiwyg',
                                'tabs'  => 'all',
                                'toolbar' => 'basic',
                                'media_upload' => 0,
                            ],
                        ],
                    ],
                    'layout_mission_vision' => [
                        'key'        => 'layout_mission_vision',
                        'name'       => 'mission_vision',
                        'label'      => __( 'Mission / Vision', 'tanzania-sensational' ),
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'        => 'field_about_mv_items',
                                'label'      => __( 'Items', 'tanzania-sensational' ),
                                'name'       => 'items',
                                'type'       => 'repeater',
                                'min'        => 1,
                                'max'        => 2,
                                'sub_fields' => [
                                    [
                                        'key'     => 'field_about_mv_icon',
                                        'label'   => __( 'Icon', 'tanzania-sensational' ),
                                        'name'    => 'icon',
                                        'type'    => 'select',
                                        'choices' => $icon_choices,
                                    ],
                                    [
                                        'key'   => 'field_about_mv_title',
                                        'label' => __( 'Title', 'tanzania-sensational' ),
                                        'name'  => 'title',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_about_mv_text',
                                        'label' => __( 'Text', 'tanzania-sensational' ),
                                        'name'  => 'text',
                                        'type'  => 'textarea',
                                        'rows'  => 3,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'layout_values' => [
                        'key'        => 'layout_values',
                        'name'       => 'values',
                        'label'      => __( 'Values Grid', 'tanzania-sensational' ),
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'   => 'field_about_values_eyebrow',
                                'label' => __( 'Eyebrow', 'tanzania-sensational' ),
                                'name'  => 'eyebrow',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_about_values_title',
                                'label' => __( 'Title', 'tanzania-sensational' ),
                                'name'  => 'title',
                                'type'  => 'text',
                            ],
                            [
                                'key'        => 'field_about_values_cards',
                                'label'      => __( 'Value Cards', 'tanzania-sensational' ),
                                'name'       => 'cards',
                                'type'       => 'repeater',
                                'min'        => 1,
                                'max'        => 6,
                                'sub_fields' => [
                                    [
                                        'key'     => 'field_about_values_card_icon',
                                        'label'   => __( 'Icon', 'tanzania-sensational' ),
                                        'name'    => 'icon',
                                        'type'    => 'select',
                                        'choices' => $icon_choices,
                                    ],
                                    [
                                        'key'   => 'field_about_values_card_title',
                                        'label' => __( 'Title', 'tanzania-sensational' ),
                                        'name'  => 'title',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_about_values_card_desc',
                                        'label' => __( 'Description', 'tanzania-sensational' ),
                                        'name'  => 'description',
                                        'type'  => 'textarea',
                                        'rows'  => 3,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'layout_experience' => [
                        'key'        => 'layout_experience',
                        'name'       => 'experience_band',
                        'label'      => __( 'Experience Band', 'tanzania-sensational' ),
                        'display'    => 'block',
                        'sub_fields' => [
                            [
                                'key'           => 'field_about_exp_image',
                                'label'         => __( 'Background Image', 'tanzania-sensational' ),
                                'name'          => 'background_image',
                                'type'          => 'image',
                                'return_format' => 'url',
                                'preview_size'  => 'medium',
                            ],
                            [
                                'key'   => 'field_about_exp_eyebrow',
                                'label' => __( 'Eyebrow', 'tanzania-sensational' ),
                                'name'  => 'eyebrow',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_about_exp_title',
                                'label' => __( 'Title', 'tanzania-sensational' ),
                                'name'  => 'title',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_about_exp_cta_label',
                                'label' => __( 'CTA Label', 'tanzania-sensational' ),
                                'name'  => 'cta_label',
                                'type'  => 'text',
                            ],
                            [
                                'key'   => 'field_about_exp_cta_url',
                                'label' => __( 'CTA URL', 'tanzania-sensational' ),
                                'name'  => 'cta_url',
                                'type'  => 'text',
                            ],
                            [
                                'key'        => 'field_about_exp_items',
                                'label'      => __( 'Items', 'tanzania-sensational' ),
                                'name'       => 'items',
                                'type'       => 'repeater',
                                'min'        => 1,
                                'max'        => 6,
                                'sub_fields' => [
                                    [
                                        'key'   => 'field_about_exp_item_number',
                                        'label' => __( 'Number', 'tanzania-sensational' ),
                                        'name'  => 'number',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_about_exp_item_title',
                                        'label' => __( 'Title', 'tanzania-sensational' ),
                                        'name'  => 'title',
                                        'type'  => 'text',
                                    ],
                                    [
                                        'key'   => 'field_about_exp_item_text',
                                        'label' => __( 'Text', 'tanzania-sensational' ),
                                        'name'  => 'text',
                                        'type'  => 'textarea',
                                        'rows'  => 3,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'location'              => [
            [
                [
                    'param'    => 'page',
                    'operator' => '==',
                    'value'    => '8',
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
 * Render the About page.
 */
function ts_render_about_page() {
    $post_id = get_the_ID();

    if ( function_exists( 'have_rows' ) && have_rows( 'ts_about_sections', $post_id ) ) {
        ob_start();
        while ( have_rows( 'ts_about_sections', $post_id ) ) {
            the_row();
            $layout = get_row_layout();
            switch ( $layout ) {
                case 'hero':
                    ts_about_render_hero();
                    break;
                case 'stats_strip':
                    ts_about_render_stats_strip();
                    break;
                case 'story_card':
                    ts_about_render_story_card();
                    break;
                case 'mission_vision':
                    ts_about_render_mission_vision();
                    break;
                case 'values':
                    ts_about_render_values();
                    break;
                case 'experience_band':
                    ts_about_render_experience_band();
                    break;
            }
        }
        return ob_get_clean();
    }

    // Fallback: legacy static markup.
    return ts_about_page_legacy();
}

/**
 * Legacy About page markup.
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
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3l4 8 5-5 5 15H2L8 3z"/></svg>
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
                        <div class="premium-value-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
                        <h4 class="premium-value-title">Safety Ascendant</h4>
                        <p class="premium-value-desc">Every expedition is meticulously engineered with certified elite guides, cutting-edge equipment, and rapid-response protocols that exceed international standards.</p>
                    </div>
                    <div class="premium-value-card">
                        <div class="premium-value-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg></div>
                        <h4 class="premium-value-title">Authentic Immersion</h4>
                        <p class="premium-value-desc">We go beyond the traditional tourist veil. Each journey is carefully crafted to create genuine, profound connections with Tanzania's landscapes and people.</p>
                    </div>
                    <div class="premium-value-card">
                        <div class="premium-value-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg></div>
                        <h4 class="premium-value-title">Responsible Travel</h4>
                        <p class="premium-value-desc">We mandate strict group sizes, actively drive local economies, and respect carrying capacities to ensure Tanzania's pristine wilderness thrives.</p>
                    </div>
                    <div class="premium-value-card">
                        <div class="premium-value-icon"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3l4 8 5-5 5 15H2L8 3z"/></svg></div>
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

/**
 * Renderers for each About layout.
 */
function ts_about_render_hero() {
    $row      = get_row( true );
    $eyebrow  = $row['eyebrow'] ?? '';
    $title    = $row['title'] ?? '';
    $subtitle = $row['subtitle'] ?? '';
    $image    = $row['background_image'] ?? '';
    $image    = $image ?: 'https://images.unsplash.com/photo-1621414050946-1b936a78490b?q=80&w=2000&auto=format&fit=crop';
    ?>
    <section class="premium-about-hero">
        <div class="premium-about-bg">
            <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( strip_tags( $title ) ); ?>" />
            <div class="premium-about-overlay"></div>
        </div>
        <div class="container">
            <div class="premium-about-content">
                <?php if ( $eyebrow ) : ?><span class="premium-eyebrow"><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?>
                <?php if ( $title ) : ?><h1 class="premium-hero-title"><?php echo wp_kses_post( $title ); ?></h1><?php endif; ?>
                <?php if ( $subtitle ) : ?><p class="premium-hero-subtitle"><?php echo esc_html( $subtitle ); ?></p><?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}

function ts_about_render_stats_strip() {
    $row   = get_row( true );
    $stats = $row['stats'] ?? [];
    if ( empty( $stats ) ) {
        return;
    }
    ?>
    <div class="premium-stats-strip">
        <div class="premium-stats-grid">
            <?php foreach ( $stats as $stat ) : ?>
                <div class="premium-stat-item">
                    <span class="premium-stat-num"><?php echo esc_html( $stat['number'] ?? '' ); ?></span>
                    <span class="premium-stat-label"><?php echo esc_html( $stat['label'] ?? '' ); ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

function ts_about_render_story_card() {
    $row        = get_row( true );
    $image      = $row['image'] ?? '';
    $image      = $image ?: 'https://images.unsplash.com/photo-1631646109206-4919df38eb68?q=80&w=800&auto=format&fit=crop';
    $badge_icon = $row['badge_icon'] ?? 'mountain';
    $badge_text = $row['badge_text'] ?? '';
    $eyebrow    = $row['eyebrow'] ?? '';
    $title      = $row['title'] ?? '';
    $body       = $row['body'] ?? '';
    ?>
    <section class="premium-story-section">
        <div class="premium-story-card">
            <div class="premium-story-image">
                <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( strip_tags( $title ) ); ?>" />
                <?php if ( $badge_text ) : ?>
                <div class="premium-story-badge">
                    <?php echo ts_icon_svg( $badge_icon ); ?>
                    <span><?php echo esc_html( $badge_text ); ?></span>
                </div>
                <?php endif; ?>
            </div>
            <div class="premium-story-content">
                <?php if ( $eyebrow ) : ?><span class="premium-eyebrow"><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?>
                <?php if ( $title ) : ?><h2 class="premium-story-title"><?php echo wp_kses_post( $title ); ?></h2><?php endif; ?>
                <?php if ( $body ) : ?><div class="premium-story-body-wrap"><?php echo wp_kses_post( $body ); ?></div><?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}

function ts_about_render_mission_vision() {
    $row   = get_row( true );
    $items = $row['items'] ?? [];
    if ( empty( $items ) ) {
        return;
    }
    ?>
    <section class="premium-mv-section">
        <div class="premium-mv-grid">
            <?php foreach ( $items as $item ) : ?>
                <div class="premium-mv-card">
                    <div class="premium-mv-inner">
                        <svg class="premium-mv-icon" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <?php echo ts_icon_svg( $item['icon'] ?? '' ); ?>
                        </svg>
                        <h3 class="premium-mv-title"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
                        <p class="premium-mv-text"><?php echo esc_html( $item['text'] ?? '' ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
}

function ts_about_render_values() {
    $row   = get_row( true );
    $eyebrow = $row['eyebrow'] ?? '';
    $title   = $row['title'] ?? '';
    $cards   = $row['cards'] ?? [];
    if ( empty( $cards ) ) {
        return;
    }
    ?>
    <section class="premium-values-section">
        <div class="premium-values-container">
            <div class="premium-values-head">
                <?php if ( $eyebrow ) : ?><span class="premium-eyebrow"><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?>
                <?php if ( $title ) : ?><h2 class="premium-values-title"><?php echo wp_kses_post( $title ); ?></h2><?php endif; ?>
            </div>
            <div class="premium-values-grid">
                <?php foreach ( $cards as $card ) : ?>
                    <div class="premium-value-card">
                        <div class="premium-value-icon"><?php echo ts_icon_svg( $card['icon'] ?? '' ); ?></div>
                        <h4 class="premium-value-title"><?php echo esc_html( $card['title'] ?? '' ); ?></h4>
                        <p class="premium-value-desc"><?php echo esc_html( $card['description'] ?? '' ); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php
}

function ts_about_render_experience_band() {
    $row       = get_row( true );
    $image     = $row['background_image'] ?? '';
    $image     = $image ?: 'https://images.unsplash.com/photo-1650668302197-7f556c34cb91?q=80&w=2000&auto=format&fit=crop';
    $eyebrow   = $row['eyebrow'] ?? '';
    $title     = $row['title'] ?? '';
    $cta_label = $row['cta_label'] ?? '';
    $cta_url   = $row['cta_url'] ?? '';
    $items     = $row['items'] ?? [];
    ?>
    <section class="premium-exp-section">
        <div class="premium-exp-bg">
            <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( strip_tags( $title ) ); ?>" />
            <div class="premium-exp-overlay"></div>
        </div>
        <div class="premium-exp-container">
            <div class="premium-exp-left">
                <?php if ( $eyebrow ) : ?><span class="premium-eyebrow" style="color:white;"><?php echo esc_html( $eyebrow ); ?></span><?php endif; ?>
                <?php if ( $title ) : ?><h2 class="premium-exp-title"><?php echo wp_kses_post( $title ); ?></h2><?php endif; ?>
                <?php if ( $cta_label && $cta_url ) : ?>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="premium-exp-cta">
                    <span><?php echo esc_html( $cta_label ); ?></span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
                <?php endif; ?>
            </div>
            <?php if ( ! empty( $items ) ) : ?>
            <div class="premium-exp-list">
                <?php foreach ( $items as $item ) : ?>
                    <div class="premium-exp-item">
                        <span class="premium-exp-num"><?php echo esc_html( $item['number'] ?? '' ); ?></span>
                        <div>
                            <h4 class="premium-exp-item-title"><?php echo esc_html( $item['title'] ?? '' ); ?></h4>
                            <p class="premium-exp-item-text"><?php echo esc_html( $item['text'] ?? '' ); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
}

/**
 * Replace the About page shortcode to use flexible content when available.
 */
add_shortcode( 'ts_about_page', function() {
    return ts_render_about_page();
} );
