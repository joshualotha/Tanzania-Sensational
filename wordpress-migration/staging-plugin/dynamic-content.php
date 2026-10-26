<?php
/**
 * Dynamic content helpers and shortcodes for Tours and Destinations.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get tours.
 */
function ts_get_tours( $args = [] ) {
    $defaults = [
        'post_type'      => 'ts_tour',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'ts_tour_display_order',
        'order'          => 'ASC',
    ];
    $args = wp_parse_args( $args, $defaults );
    return get_posts( $args );
}

/**
 * Get destinations.
 */
function ts_get_destinations( $args = [] ) {
    $defaults = [
        'post_type'      => 'ts_destination',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'ts_dest_display_order',
        'order'          => 'ASC',
    ];
    $args = wp_parse_args( $args, $defaults );
    return get_posts( $args );
}

/**
 * Safely get an ACF field.
 */
function ts_get_field( $key, $post_id = false ) {
    if ( ! function_exists( 'get_field' ) ) {
        return null;
    }
    return get_field( $key, $post_id );
}

/**
 * Use destination-specific SEO values through Rank Math's documented filters.
 * Source: https://rankmath.com/docs/filters-and-hooks/frontend/meta-data/
 */
function ts_destination_rank_math_title( $title ) {
    if ( ! is_singular( 'ts_destination' ) ) {
        return $title;
    }

    $value = ts_get_field( 'ts_dest_meta_title', get_queried_object_id() );
    return is_string( $value ) && '' !== trim( $value ) ? trim( $value ) : $title;
}
add_filter( 'rank_math/frontend/title', 'ts_destination_rank_math_title' );

function ts_destination_rank_math_description( $description ) {
    if ( ! is_singular( 'ts_destination' ) ) {
        return $description;
    }

    $value = ts_get_field( 'ts_dest_meta_description', get_queried_object_id() );
    return is_string( $value ) && '' !== trim( $value ) ? trim( $value ) : $description;
}
add_filter( 'rank_math/frontend/description', 'ts_destination_rank_math_description' );

function ts_destination_rank_math_canonical( $canonical ) {
    if ( ! is_singular( 'ts_destination' ) ) {
        return $canonical;
    }

    $permalink = get_permalink( get_queried_object_id() );
    return is_string( $permalink ) && '' !== $permalink ? $permalink : $canonical;
}
add_filter( 'rank_math/frontend/canonical', 'ts_destination_rank_math_canonical' );

/**
 * Hello Elementor also outputs the post excerpt as a description meta tag.
 * Keep that fallback on other content, but use only Rank Math's field value
 * for destination pages to avoid duplicate description tags.
 */
function ts_destination_hello_elementor_description_meta_tag( $enabled ) {
    return is_singular( 'ts_destination' ) ? false : $enabled;
}
add_filter( 'hello_elementor_description_meta_tag', 'ts_destination_hello_elementor_description_meta_tag' );

/**
 * Image URL fallback helper.
 */
function ts_image_url( $url, $fallback ) {
    return $url ?: $fallback;
}

/**
 * Render a tour card.
 */
function ts_render_tour_card( $post_id, $layout = 'grid' ) {
    $post = get_post( $post_id );
    if ( ! $post ) {
        return '';
    }

    $duration    = ts_get_field( 'ts_tour_duration', $post_id ) ?: '';
    $parks       = ts_get_field( 'ts_tour_parks', $post_id ) ?: 'Tanzania';
    $price       = ts_get_field( 'ts_tour_price', $post_id ) ?: '';
    $price_note  = ts_get_field( 'ts_tour_price_note', $post_id ) ?: __( 'per person', 'tanzania-sensational' );
    $badge       = ts_get_field( 'ts_tour_badge', $post_id ) ?: '';
    $description = get_the_excerpt( $post_id ) ?: wp_trim_words( get_post_field( 'post_content', $post_id ), 20 );
    if ( ! $description ) {
        $description = ts_get_field( 'ts_tour_overview', $post_id );
        $description = $description ? wp_trim_words( strip_tags( $description ), 18 ) : '';
    }

    $hero = ts_get_field( 'ts_tour_hero_image', $post_id );
    $hero_url = is_array( $hero ) ? ( $hero['url'] ?? '' ) : ( is_numeric( $hero ) ? wp_get_attachment_url( $hero ) : $hero );
    $hero_url = $hero_url ?: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=800&auto=format&fit=crop';

    $permalink = get_permalink( $post_id );
    $title = get_the_title( $post_id );

    ob_start();
    ?>
    <a href="<?php echo esc_url( $permalink ); ?>" class="ts-tour-card">
        <div class="ts-tour-card-img">
            <img src="<?php echo esc_url( $hero_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" />
            <div class="ts-tour-card-overlay"></div>
            <?php if ( $badge ) : ?>
                <span class="ts-tour-card-badge"><?php echo esc_html( $badge ); ?></span>
            <?php endif; ?>
        </div>
        <div class="ts-tour-card-body">
            <div class="ts-tour-card-meta">
                <span>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <?php echo esc_html( $duration ); ?>
                </span>
                <span>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <?php echo esc_html( $parks ); ?>
                </span>
            </div>
            <h3 class="ts-tour-card-title"><?php echo esc_html( $title ); ?></h3>
            <p class="ts-tour-card-desc"><?php echo esc_html( $description ); ?></p>
            <?php if ( $price ) : ?>
                <div class="ts-tour-card-price">
                    <?php echo esc_html( $price ); ?> <span><?php echo esc_html( $price_note ); ?></span>
                </div>
            <?php endif; ?>
            <div class="ts-tour-card-cta">
                Explore Safari
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </div>
        </div>
    </a>
    <?php
    return ob_get_clean();
}

/**
 * Render a destination card.
 */
function ts_render_dest_card( $post_id, $size = 'small' ) {
    $post = get_post( $post_id );
    if ( ! $post ) {
        return '';
    }

    $tag      = ts_get_field( 'ts_dest_tag', $post_id ) ?: '';
    $subtitle = ts_get_field( 'ts_dest_subtitle', $post_id ) ?: '';
    $hero     = ts_get_field( 'ts_dest_hero_image', $post_id );
    $hero_url = ts_get_field( 'ts_dest_hero_image_url', $post_id ) ?: ( is_array( $hero ) ? ( $hero['url'] ?? '' ) : ( is_numeric( $hero ) ? wp_get_attachment_url( $hero ) : $hero ) );
    $hero_url = $hero_url ?: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=800&auto=format&fit=crop';

    $permalink = get_permalink( $post_id );
    $title = get_the_title( $post_id );
    $class = 'ts-dest-card ts-dest-card-' . $size;

    ob_start();
    ?>
    <a href="<?php echo esc_url( $permalink ); ?>" class="<?php echo esc_attr( $class ); ?>">
        <div class="ts-dest-card-img">
            <img src="<?php echo esc_url( $hero_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" />
            <div class="ts-dest-card-gradient"></div>
        </div>
        <div class="ts-dest-card-content">
            <?php if ( $tag ) : ?>
                <span class="ts-dest-card-region">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <?php echo esc_html( $tag ); ?>
                </span>
            <?php endif; ?>
            <h3 class="ts-dest-card-name"><?php echo esc_html( $title ); ?></h3>
            <?php if ( $subtitle ) : ?>
                <p class="ts-dest-card-tagline"><?php echo esc_html( $subtitle ); ?></p>
            <?php endif; ?>
            <span class="ts-dest-card-link">
                Explore
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </span>
        </div>
    </a>
    <?php
    return ob_get_clean();
}

/**
 * Shortcode: Tour card.
 * [ts_tour_card id="18"]
 */
add_shortcode( 'ts_tour_card', function( $atts ) {
    $atts = shortcode_atts( [ 'id' => 0 ], $atts, 'ts_tour_card' );
    return ts_render_tour_card( (int) $atts['id'] );
} );

/**
 * Shortcode: Destination card.
 * [ts_dest_card id="21" size="large"]
 */
add_shortcode( 'ts_dest_card', function( $atts ) {
    $atts = shortcode_atts( [ 'id' => 0, 'size' => 'small' ], $atts, 'ts_dest_card' );
    return ts_render_dest_card( (int) $atts['id'], $atts['size'] );
} );

/**
 * Shortcode: Tours grid.
 * [ts_tours_grid count="6" featured="1"]
 */
add_shortcode( 'ts_tours_grid', function( $atts ) {
    $atts = shortcode_atts( [
        'count'    => 6,
        'featured' => '0',
    ], $atts, 'ts_tours_grid' );

    $args = [
        'posts_per_page' => (int) $atts['count'],
    ];

    if ( $atts['featured'] === '1' ) {
        $args['meta_query'] = [
            [
                'key'   => 'ts_tour_featured',
                'value' => '1',
            ],
        ];
    }

    $tours = ts_get_tours( $args );
    if ( empty( $tours ) ) {
        return '';
    }

    ob_start();
    ?>
    <section class="ts-tours-grid-section">
        <div class="ts-tours-grid-header">
            <div>
                <span class="ts-tours-grid-eyebrow">Curated Expeditions</span>
                <h2 class="ts-tours-grid-title">Safari <em>Packages</em></h2>
                <p class="ts-tours-grid-sub">
                    From intimate 3-day getaways to comprehensive 14-day expeditions — each safari is designed
                    to immerse you in the raw beauty of East Africa's wildlife.
                </p>
            </div>
            <a href="/safaris/packages" class="ts-tours-grid-viewall">
                View All Packages
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>
        <div class="ts-tours-grid">
            <?php foreach ( $tours as $tour ) : ?>
                <?php echo ts_render_tour_card( $tour->ID ); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
    return ob_get_clean();
} );

/**
 * Shortcode: Destinations grid.
 * [ts_dests_grid count="4" featured="1"]
 */
add_shortcode( 'ts_dests_grid', function( $atts ) {
    $atts = shortcode_atts( [
        'count'    => 4,
        'featured' => '0',
    ], $atts, 'ts_dests_grid' );

    $args = [
        'posts_per_page' => (int) $atts['count'],
    ];

    if ( $atts['featured'] === '1' ) {
        $args['meta_query'] = [
            [
                'key'   => 'ts_dest_featured',
                'value' => '1',
            ],
        ];
    }

    $destinations = ts_get_destinations( $args );
    if ( empty( $destinations ) ) {
        return '';
    }

    $featured = array_shift( $destinations );
    $rest     = $destinations;

    ob_start();
    ?>
    <section class="ts-dests-grid-section">
        <div class="ts-dests-grid-header">
            <div>
                <span class="ts-dests-grid-eyebrow">Explore the Wild</span>
                <h2 class="ts-dests-grid-title">Safari <em>Destinations</em></h2>
            </div>
            <a href="/safaris/destinations" class="ts-dests-grid-viewall">
                All Destinations
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </a>
        </div>
        <div class="ts-dests-grid-layout">
            <?php if ( $featured ) : ?>
                <div class="ts-dests-grid-featured">
                    <?php echo ts_render_dest_card( $featured->ID, 'large' ); ?>
                </div>
            <?php endif; ?>
            <?php if ( ! empty( $rest ) ) : ?>
                <div class="ts-dests-grid-small">
                    <?php foreach ( $rest as $dest ) : ?>
                        <?php echo ts_render_dest_card( $dest->ID, 'small' ); ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php
    return ob_get_clean();
} );

/**
 * Shortcode: Single tour page content.
 * [ts_single_tour]
 */
add_shortcode( 'ts_single_tour', function() {
    if ( ! is_singular( 'ts_tour' ) ) {
        return '';
    }
    $post_id = get_the_ID();

    $duration    = ts_get_field( 'ts_tour_duration', $post_id ) ?: '';
    $parks       = ts_get_field( 'ts_tour_parks', $post_id ) ?: '';
    $price       = ts_get_field( 'ts_tour_price', $post_id ) ?: '';
    $price_note  = ts_get_field( 'ts_tour_price_note', $post_id ) ?: __( 'per person', 'tanzania-sensational' );
    $badge       = ts_get_field( 'ts_tour_badge', $post_id ) ?: '';
    $pace_level  = ts_get_field( 'ts_tour_pace_level', $post_id ) ?: '';
    $overview    = ts_get_field( 'ts_tour_overview', $post_id ) ?: apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
    $highlights  = ts_get_field( 'ts_tour_highlights', $post_id ) ?: [];
    $inclusions  = ts_get_field( 'ts_tour_inclusions', $post_id ) ?: [];
    $exclusions  = ts_get_field( 'ts_tour_exclusions', $post_id ) ?: [];
    $itinerary   = ts_get_field( 'ts_tour_itinerary', $post_id ) ?: [];

    $hero = ts_get_field( 'ts_tour_hero_image', $post_id );
    $hero_url = is_array( $hero ) ? ( $hero['url'] ?? '' ) : ( is_numeric( $hero ) ? wp_get_attachment_url( $hero ) : $hero );
    $hero_url = $hero_url ?: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=2000&auto=format&fit=crop';

    $title = get_the_title( $post_id );

    ob_start();
    ?>
    <div class="ts-single-tour">
        <section class="ts-single-tour-hero">
            <div class="ts-single-tour-hero-bg">
                <img src="<?php echo esc_url( $hero_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
                <div class="ts-single-tour-hero-overlay"></div>
            </div>
            <div class="ts-single-tour-hero-content">
                <?php if ( $badge ) : ?><span class="ts-single-tour-badge"><?php echo esc_html( $badge ); ?></span><?php endif; ?>
                <h1><?php echo esc_html( $title ); ?></h1>
                <?php if ( $pace_level ) : ?><p class="ts-single-tour-tagline"><?php echo esc_html( $pace_level ); ?></p><?php endif; ?>
                <div class="ts-single-tour-meta">
                    <?php if ( $duration ) : ?><span><?php echo esc_html( $duration ); ?></span><?php endif; ?>
                    <?php if ( $parks ) : ?><span><?php echo esc_html( $parks ); ?></span><?php endif; ?>
                    <?php if ( $price ) : ?><span><?php echo esc_html( $price ); ?> <?php echo esc_html( $price_note ); ?></span><?php endif; ?>
                </div>
            </div>
        </section>

        <div class="ts-single-tour-body">
            <section class="ts-single-tour-overview">
                <h2>Tour Overview</h2>
                <?php echo wp_kses_post( $overview ); ?>
            </section>

            <?php if ( ! empty( $highlights ) ) : ?>
                <section class="ts-single-tour-highlights">
                    <h2>Highlights</h2>
                    <ul>
                        <?php foreach ( $highlights as $h ) : ?>
                            <li><?php echo esc_html( is_array( $h ) ? ( $h['text'] ?? '' ) : $h ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ( ! empty( $inclusions ) || ! empty( $exclusions ) ) : ?>
                <section class="ts-single-tour-inex">
                    <?php if ( ! empty( $inclusions ) ) : ?>
                        <div class="ts-single-tour-inclusions">
                            <h3>Included</h3>
                            <ul>
                                <?php foreach ( $inclusions as $item ) : ?>
                                    <li><?php echo esc_html( is_array( $item ) ? ( $item['text'] ?? '' ) : $item ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php if ( ! empty( $exclusions ) ) : ?>
                        <div class="ts-single-tour-exclusions">
                            <h3>Not Included</h3>
                            <ul>
                                <?php foreach ( $exclusions as $item ) : ?>
                                    <li><?php echo esc_html( is_array( $item ) ? ( $item['text'] ?? '' ) : $item ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </section>
            <?php endif; ?>

            <?php if ( ! empty( $itinerary ) ) : ?>
                <section class="ts-single-tour-itinerary">
                    <h2>Itinerary</h2>
                    <div class="ts-itinerary">
                        <?php foreach ( $itinerary as $day ) :
                            $day_num = is_array( $day ) ? ( $day['day'] ?? '' ) : ( $day->day ?? '' );
                            $day_title = is_array( $day ) ? ( $day['title'] ?? '' ) : ( $day->title ?? '' );
                            $day_desc = is_array( $day ) ? ( $day['description'] ?? '' ) : ( $day->description ?? '' );
                            $day_accommodation = is_array( $day ) ? ( $day['accommodation'] ?? '' ) : ( $day->accommodation ?? '' );
                            $day_meals = is_array( $day ) ? ( $day['meals'] ?? '' ) : ( $day->meals ?? '' );
                            $day_elevation = is_array( $day ) ? ( $day['elevation'] ?? '' ) : ( $day->elevation ?? '' );
                        ?>
                            <div class="ts-itinerary-day">
                                <div class="ts-itinerary-day-num"><?php echo esc_html( $day_num ); ?></div>
                                <div class="ts-itinerary-day-body">
                                    <h3><?php echo esc_html( $day_title ); ?></h3>
                                    <p><?php echo esc_html( $day_desc ); ?></p>
                                    <div class="ts-itinerary-day-meta">
                                        <?php if ( $day_accommodation ) : ?><span>Stay: <?php echo esc_html( $day_accommodation ); ?></span><?php endif; ?>
                                        <?php if ( $day_meals ) : ?><span>Meals: <?php echo esc_html( $day_meals ); ?></span><?php endif; ?>
                                        <?php if ( $day_elevation ) : ?><span>Elevation: <?php echo esc_html( $day_elevation ); ?></span><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <section class="ts-single-tour-cta">
                <a href="#ts-safari-booking" class="ts-btn-primary">Plan This Safari</a>
            </section>

			<section class="ts-booking-panel" id="ts-safari-booking" aria-labelledby="ts-booking-title">
				<div class="ts-booking-panel-copy">
					<span class="ts-booking-eyebrow"><?php esc_html_e( 'Request This Journey', 'tanzania-sensational' ); ?></span>
					<h2 id="ts-booking-title"><?php echo esc_html( sprintf( __( 'Plan %s', 'tanzania-sensational' ), $title ) ); ?></h2>
					<p><?php esc_html_e( 'Tell us your preferred travel date and group size. Our Tanzania team will confirm availability, refine the itinerary, and arrange payment with you directly.', 'tanzania-sensational' ); ?></p>
				</div>
				<form class="ts-booking-form" data-ts-booking-form data-endpoint="<?php echo esc_url( rest_url( 'ts/v1/bookings/safari' ) ); ?>">
					<input type="hidden" name="tour_post_id" value="<?php echo esc_attr( $post_id ); ?>">
					<div class="ts-booking-honeypot" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
					<div class="ts-booking-fields">
						<label><span><?php esc_html_e( 'Full name', 'tanzania-sensational' ); ?> *</span><input type="text" name="customer_name" autocomplete="name" maxlength="255" required></label>
						<label><span><?php esc_html_e( 'Email', 'tanzania-sensational' ); ?> *</span><input type="email" name="email" autocomplete="email" maxlength="255" required></label>
						<label><span><?php esc_html_e( 'Phone / WhatsApp', 'tanzania-sensational' ); ?></span><input type="tel" name="phone" autocomplete="tel" maxlength="50"></label>
						<label><span><?php esc_html_e( 'Country', 'tanzania-sensational' ); ?></span><input type="text" name="country" autocomplete="country-name" maxlength="100"></label>
						<label><span><?php esc_html_e( 'Preferred travel date', 'tanzania-sensational' ); ?> *</span><input type="date" name="preferred_date" required></label>
						<label><span><?php esc_html_e( 'Group size', 'tanzania-sensational' ); ?> *</span><input type="number" name="group_size" min="1" max="20" value="2" required></label>
					</div>
					<label class="ts-booking-wide"><span><?php esc_html_e( 'Anything else we should know?', 'tanzania-sensational' ); ?></span><textarea name="special_requests" rows="4" maxlength="5000"></textarea></label>
					<div class="ts-booking-actions"><button type="submit" class="ts-btn-primary"><?php esc_html_e( 'Send Booking Request', 'tanzania-sensational' ); ?></button><span><?php esc_html_e( 'No payment is taken online.', 'tanzania-sensational' ); ?></span></div>
					<div class="ts-booking-message" data-ts-booking-message role="status" aria-live="polite"></div>
				</form>
			</section>
        </div>
    </div>
    <?php
    return ob_get_clean();
} );

/**
 * Shortcode: Single destination page content.
 * [ts_single_destination]
 */
add_shortcode( 'ts_single_destination', function() {
    if ( ! is_singular( 'ts_destination' ) ) {
        return '';
    }
    $post_id = get_the_ID();

    $subtitle      = ts_get_field( 'ts_dest_subtitle', $post_id ) ?: '';
    $tag           = ts_get_field( 'ts_dest_tag', $post_id ) ?: '';
    $short_desc    = ts_get_field( 'ts_dest_short_description', $post_id ) ?: '';
    $overview      = apply_filters( 'the_content', get_post_field( 'post_content', $post_id ) );
    $overview_quote= ts_get_field( 'ts_dest_overview_quote', $post_id ) ?: '';
    $coordinates   = ts_get_field( 'ts_dest_coordinates', $post_id ) ?: '';
    $elevation     = ts_get_field( 'ts_dest_elevation', $post_id ) ?: '';
    $duration      = ts_get_field( 'ts_dest_duration', $post_id ) ?: '';
    $best_time     = ts_get_field( 'ts_dest_best_time', $post_id ) ?: '';
    $encounter     = ts_get_field( 'ts_dest_encounter_rate', $post_id ) ?: '';
    $tier          = ts_get_field( 'ts_dest_expedition_tier', $post_id ) ?: '';
    $tracking      = ts_get_field( 'ts_dest_tracking_method', $post_id ) ?: '';
    $highlights    = ts_get_field( 'ts_dest_highlights', $post_id ) ?: [];
    $wildlife      = ts_get_field( 'ts_dest_wildlife_list', $post_id ) ?: [];
    $experience    = ts_get_field( 'ts_dest_experience', $post_id ) ?: [];
    $atmosphere_vitals = ts_get_field( 'ts_dest_atmosphere_vitals', $post_id ) ?: [];
    $wildlife_vitals   = ts_get_field( 'ts_dest_wildlife_vitals', $post_id ) ?: [];
    $atmosphere_footer = ts_get_field( 'ts_dest_atmosphere_footer', $post_id ) ?: '';
    $wildlife_footer   = ts_get_field( 'ts_dest_wildlife_footer', $post_id ) ?: '';
    $gallery_urls      = ts_get_field( 'ts_dest_gallery_urls', $post_id ) ?: [];
    $gallery           = $gallery_urls ?: ( ts_get_field( 'ts_dest_gallery', $post_id ) ?: [] );

    $hero = ts_get_field( 'ts_dest_hero_image', $post_id );
    $hero_url = ts_get_field( 'ts_dest_hero_image_url', $post_id ) ?: ( is_array( $hero ) ? ( $hero['url'] ?? '' ) : ( is_numeric( $hero ) ? wp_get_attachment_url( $hero ) : $hero ) );
    $hero_url = $hero_url ?: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=2000&auto=format&fit=crop';

    $title = get_the_title( $post_id );

    ob_start();
    ?>
    <div class="ts-single-destination">
        <section class="ts-single-dest-hero">
            <div class="ts-single-dest-hero-bg">
                <img src="<?php echo esc_url( $hero_url ); ?>" alt="<?php echo esc_attr( $title ); ?>" />
                <div class="ts-single-dest-hero-overlay"></div>
            </div>
            <div class="ts-single-dest-hero-content">
                <?php if ( $tag ) : ?><span class="ts-single-dest-tag"><?php echo esc_html( $tag ); ?></span><?php endif; ?>
                <h1><?php echo esc_html( $title ); ?><?php if ( $subtitle ) : ?><em><?php echo esc_html( $subtitle ); ?></em><?php endif; ?></h1>
                <?php if ( $short_desc ) : ?><p class="ts-single-dest-shortdesc"><?php echo esc_html( $short_desc ); ?></p><?php endif; ?>
            </div>
        </section>

        <div class="ts-single-dest-body">
            <section class="ts-single-dest-overview">
                <?php if ( $overview_quote ) : ?>
                    <blockquote class="ts-single-dest-quote"><?php echo esc_html( $overview_quote ); ?></blockquote>
                <?php endif; ?>
                <?php echo wp_kses_post( $overview ); ?>
            </section>

            <section class="ts-single-dest-vitals">
                <?php if ( $coordinates ) : ?><div><span>Coordinates</span><strong><?php echo esc_html( $coordinates ); ?></strong></div><?php endif; ?>
                <?php if ( $elevation ) : ?><div><span>Elevation</span><strong><?php echo esc_html( $elevation ); ?></strong></div><?php endif; ?>
                <?php if ( $duration ) : ?><div><span>Duration</span><strong><?php echo esc_html( $duration ); ?></strong></div><?php endif; ?>
                <?php if ( $best_time ) : ?><div><span>Best Season</span><strong><?php echo esc_html( $best_time ); ?></strong></div><?php endif; ?>
                <?php if ( $encounter ) : ?><div><span>Encounter Rate</span><strong><?php echo esc_html( $encounter ); ?></strong></div><?php endif; ?>
            </section>

            <?php if ( $encounter || $best_time || $tier || $tracking ) : ?>
                <section class="ts-single-dest-ledger ts-dest-ledger-panel">
                    <h2>Expedition Ledger</h2>
                    <dl class="ts-dest-ledger-list">
                        <?php if ( $encounter ) : ?><div><dt>Primary Success</dt><dd><?php echo esc_html( $encounter ); ?></dd></div><?php endif; ?>
                        <?php if ( $best_time ) : ?><div><dt>Optimal Cycle</dt><dd><?php echo esc_html( $best_time ); ?></dd></div><?php endif; ?>
                        <?php if ( $tier ) : ?><div><dt>Expedition Level</dt><dd><?php echo esc_html( $tier ); ?></dd></div><?php endif; ?>
                        <?php if ( $tracking ) : ?><div><dt>Tracking Protocol</dt><dd><?php echo esc_html( $tracking ); ?></dd></div><?php endif; ?>
                    </dl>
                </section>
            <?php endif; ?>

            <?php if ( ! empty( $experience ) || ! empty( $atmosphere_vitals ) ) : ?>
                <section class="ts-single-dest-experience">
                    <h2>The Experience</h2>
                    <div class="ts-dest-experience-grid">
                        <?php if ( ! empty( $atmosphere_vitals ) ) : ?>
                            <div class="ts-dest-ledger-panel">
                                <h3>Atmosphere</h3>
                                <dl class="ts-dest-ledger-list">
                                    <?php foreach ( $atmosphere_vitals as $vital ) :
                                        $label = is_array( $vital ) ? ( $vital['label'] ?? '' ) : '';
                                        $text  = is_array( $vital ) ? ( $vital['text'] ?? '' ) : '';
                                        if ( '' === trim( (string) $label ) || '' === trim( (string) $text ) ) continue;
                                    ?>
                                        <div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $text ); ?></dd></div>
                                    <?php endforeach; ?>
                                </dl>
                                <?php if ( $atmosphere_footer ) : ?><p class="ts-dest-ledger-footer"><?php echo esc_html( $atmosphere_footer ); ?></p><?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ( ! empty( $experience['atmosphere'] ) ) : ?>
                            <div><h3>Atmosphere</h3><p><?php echo esc_html( $experience['atmosphere'] ); ?></p></div>
                        <?php endif; ?>
                        <?php if ( ! empty( $experience['wildlife'] ) ) : ?>
                            <div><h3>Wildlife</h3><p><?php echo esc_html( $experience['wildlife'] ); ?></p></div>
                        <?php endif; ?>
                        <?php if ( ! empty( $experience['impact'] ) ) : ?>
                            <div><h3>Impact</h3><p><?php echo esc_html( $experience['impact'] ); ?></p></div>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ( ! empty( $highlights ) ) : ?>
                <section class="ts-single-dest-highlights">
                    <h2>Highlights</h2>
                    <ul>
                        <?php foreach ( $highlights as $h ) : ?>
                            <li><?php echo esc_html( is_array( $h ) ? ( $h['text'] ?? '' ) : $h ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>

            <?php if ( ! empty( $wildlife ) || ! empty( $wildlife_vitals ) ) : ?>
                <section class="ts-single-dest-wildlife">
                    <h2>Wildlife</h2>
                    <?php if ( ! empty( $wildlife ) ) : ?>
                        <div class="ts-wildlife-list">
                            <?php foreach ( $wildlife as $w ) : ?>
                                <span><?php echo esc_html( is_array( $w ) ? ( $w['text'] ?? '' ) : $w ); ?></span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <?php if ( ! empty( $wildlife_vitals ) ) : ?>
                        <div class="ts-dest-ledger-panel ts-dest-wildlife-ledger">
                            <h3>Wildlife Ledger</h3>
                            <dl class="ts-dest-ledger-list">
                                <?php foreach ( $wildlife_vitals as $vital ) :
                                    $label = is_array( $vital ) ? ( $vital['label'] ?? '' ) : '';
                                    $text  = is_array( $vital ) ? ( $vital['text'] ?? '' ) : '';
                                    if ( '' === trim( (string) $label ) || '' === trim( (string) $text ) ) continue;
                                ?>
                                    <div><dt><?php echo esc_html( $label ); ?></dt><dd><?php echo esc_html( $text ); ?></dd></div>
                                <?php endforeach; ?>
                            </dl>
                            <?php if ( $wildlife_footer ) : ?><p class="ts-dest-ledger-footer"><?php echo esc_html( $wildlife_footer ); ?></p><?php endif; ?>
                        </div>
                    <?php endif; ?>
                </section>
            <?php endif; ?>

            <?php if ( ! empty( $gallery ) ) : ?>
                <section class="ts-single-dest-gallery">
                    <h2>Gallery</h2>
                    <div class="ts-gallery-grid">
                        <?php foreach ( $gallery as $img ) :
                            $img_url = is_array( $img ) ? ( $img['url'] ?? '' ) : ( is_numeric( $img ) ? wp_get_attachment_url( $img ) : $img );
                            $img_alt = is_array( $img ) ? ( $img['alt'] ?? '' ) : '';
                            if ( ! $img_url ) continue;
                        ?>
                            <div class="ts-gallery-item">
                                <img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $img_alt ?: $title . ' gallery' ); ?>" loading="lazy" />
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <section class="ts-single-dest-cta">
                <a href="/contact" class="ts-btn-primary">Plan a Safari Here</a>
            </section>
        </div>
    </div>
    <?php
    return ob_get_clean();
} );

/**
 * Shortcode: Tour archive.
 * [ts_tour_archive]
 */
add_shortcode( 'ts_tour_archive', function() {
    return do_shortcode( '[ts_tours_grid count="-1"]' );
} );

/**
 * Shortcode: Destination archive.
 * [ts_destination_archive]
 */
add_shortcode( 'ts_destination_archive', function() {
    $destinations = ts_get_destinations( [ 'posts_per_page' => -1 ] );
    if ( empty( $destinations ) ) {
        return '';
    }

    ob_start();
    ?>
    <section class="ts-dest-archive-section">
        <div class="ts-dest-archive-header">
            <span class="ts-dest-archive-eyebrow">Choose Your Wilderness</span>
            <h1 class="ts-dest-archive-title">Safari <em>Destinations</em></h1>
        </div>
        <div class="ts-dest-archive-grid">
            <?php foreach ( $destinations as $dest ) : ?>
                <?php echo ts_render_dest_card( $dest->ID, 'medium' ); ?>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
    return ob_get_clean();
} );
