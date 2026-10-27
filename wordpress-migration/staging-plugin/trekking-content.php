<?php
/** Source-backed renderer for single trekking route content. */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render structured route fields without publishing unverified prices.
 *
 * @param array<string, mixed> $route Normalized route fields.
 */
function ts_render_trek_route_sections(array $route, string $title, array $labels = []): string
{
    $default_labels = [
        'overview_title' => __('Route Overview', 'tanzania-sensational'),
        'highlights_title' => __('Route Highlights', 'tanzania-sensational'),
        'itinerary_title' => __('Day-by-Day Itinerary', 'tanzania-sensational'),
        'included_title' => __('Included', 'tanzania-sensational'),
        'excluded_title' => __('Not Included', 'tanzania-sensational'),
        'inclusions_section_title' => '',
        'cta_title' => __('Plan this route with our team', 'tanzania-sensational'),
    ];
    foreach ($default_labels as $key => $default_label) {
        $label = trim((string) ($labels[$key] ?? ''));
        $labels[$key] = $label !== '' ? $label : $default_label;
    }

    $duration = trim((string) ($route['duration'] ?? ''));
    $difficulty = trim((string) ($route['difficulty'] ?? ''));
    $distance = trim((string) ($route['distance'] ?? ''));
    $elevation = trim((string) ($route['elevation_gain'] ?? ''));
    $hero_url = trim((string) ($route['hero_image_url'] ?? ''));
    $hero_alt = trim((string) ($route['hero_image_alt'] ?? ''));
    $overview = trim((string) ($route['overview'] ?? ''));
    $highlights = is_array($route['highlights'] ?? null) ? $route['highlights'] : [];
    $itinerary = is_array($route['itinerary'] ?? null) ? $route['itinerary'] : [];
    $inclusions = is_array($route['inclusions'] ?? null) ? $route['inclusions'] : [];
    $exclusions = is_array($route['exclusions'] ?? null) ? $route['exclusions'] : [];
    $gallery = is_array($route['gallery_urls'] ?? null) ? $route['gallery_urls'] : [];
    $has_inclusions = $inclusions !== [];
    $has_exclusions = $exclusions !== [];
    $show_inclusion_group_headings = $has_inclusions && $has_exclusions;
    $inclusions_section_title = $labels['inclusions_section_title'] !== ''
        ? $labels['inclusions_section_title']
        : ($show_inclusion_group_headings
            ? __('What’s Included', 'tanzania-sensational')
            : ($has_inclusions ? $labels['included_title'] : $labels['excluded_title']));

    ob_start();
    ?>
    <article class="ts-trek-route">
        <header class="ts-trek-route-hero">
            <?php if ($hero_url !== '') : ?>
                <img class="ts-trek-route-hero-image" src="<?php echo esc_url($hero_url); ?>" alt="<?php echo esc_attr($hero_alt); ?>" fetchpriority="high" />
            <?php endif; ?>
            <div class="ts-trek-route-hero-content">
                <h1><?php echo esc_html($title); ?></h1>
                <?php if ($duration !== '' || $difficulty !== '' || $distance !== '' || $elevation !== '') : ?>
                    <ul class="ts-trek-route-facts" aria-label="<?php esc_attr_e('Route facts', 'tanzania-sensational'); ?>">
                        <?php foreach ([__('Duration', 'tanzania-sensational') => $duration, __('Difficulty', 'tanzania-sensational') => $difficulty, __('Distance', 'tanzania-sensational') => $distance, __('Elevation gain', 'tanzania-sensational') => $elevation] as $label => $value) : ?>
                            <?php if ($value !== '') : ?><li><span><?php echo esc_html($label); ?></span><strong><?php echo esc_html($value); ?></strong></li><?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </header>

        <div class="ts-trek-route-content">
            <?php if ($overview !== '') : ?>
                <section class="ts-trek-route-overview" aria-labelledby="ts-trek-route-overview-title">
                    <h2 id="ts-trek-route-overview-title"><?php echo esc_html($labels['overview_title']); ?></h2>
                    <div class="ts-trek-route-rich-text"><?php echo wp_kses_post($overview); ?></div>
                </section>
            <?php endif; ?>

            <?php if ($highlights !== []) : ?>
                <section class="ts-trek-route-highlights" aria-labelledby="ts-trek-route-highlights-title">
                    <h2 id="ts-trek-route-highlights-title"><?php echo esc_html($labels['highlights_title']); ?></h2>
                    <ul><?php foreach ($highlights as $item) : $text = is_array($item) ? ($item['text'] ?? '') : $item; if (trim((string) $text) !== '') : ?><li><?php echo esc_html($text); ?></li><?php endif; endforeach; ?></ul>
                </section>
            <?php endif; ?>

            <?php if ($itinerary !== []) : ?>
                <section class="ts-trek-route-itinerary" aria-labelledby="ts-trek-route-itinerary-title">
                    <h2 id="ts-trek-route-itinerary-title"><?php echo esc_html($labels['itinerary_title']); ?></h2>
                    <ol class="ts-trek-route-days">
                        <?php foreach ($itinerary as $day) :
                            if (!is_array($day)) {
                                continue;
                            }
                            $day_number = trim((string) ($day['day'] ?? ''));
                            $day_title = trim((string) ($day['title'] ?? ''));
                            $day_description = trim((string) ($day['description'] ?? ''));
                            $day_facts = [
                                __('Elevation', 'tanzania-sensational') => trim((string) ($day['elevation'] ?? '')),
                                __('Distance', 'tanzania-sensational') => trim((string) ($day['distance'] ?? '')),
                                __('Zone', 'tanzania-sensational') => trim((string) ($day['habitat'] ?? '')),
                                __('Meals', 'tanzania-sensational') => trim((string) ($day['meals'] ?? '')),
                                __('Camp', 'tanzania-sensational') => trim((string) ($day['camp'] ?? '')),
                            ];
                            if ($day_number === '' && $day_title === '' && $day_description === '' && count(array_filter($day_facts)) === 0) {
                                continue;
                            }
                        ?>
                            <li class="ts-trek-route-day">
                                <?php if ($day_number !== '') : ?><p class="ts-trek-route-day-number"><?php echo esc_html(sprintf(__('Day %s', 'tanzania-sensational'), $day_number)); ?></p><?php endif; ?>
                                <?php if ($day_title !== '') : ?><h3><?php echo esc_html($day_title); ?></h3><?php endif; ?>
                                <?php if ($day_description !== '') : ?><p><?php echo esc_html($day_description); ?></p><?php endif; ?>
                                <?php if (count(array_filter($day_facts)) > 0) : ?><dl><?php foreach ($day_facts as $label => $value) : if ($value !== '') : ?><div><dt><?php echo esc_html($label); ?></dt><dd><?php echo esc_html($value); ?></dd></div><?php endif; endforeach; ?></dl><?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </section>
            <?php endif; ?>

            <?php if ($inclusions !== [] || $exclusions !== []) : ?>
                <section class="ts-trek-route-inclusions" aria-labelledby="ts-trek-route-inclusions-title">
                    <h2 id="ts-trek-route-inclusions-title"><?php echo esc_html($inclusions_section_title); ?></h2>
                    <div class="ts-trek-route-inclusion-columns">
                        <?php foreach ([
                            ['heading' => $labels['included_title'], 'items' => $inclusions],
                            ['heading' => $labels['excluded_title'], 'items' => $exclusions],
                        ] as $group) : $heading = $group['heading']; $items = $group['items']; if ($items === []) { continue; } ?>
                            <div><?php if ($show_inclusion_group_headings) : ?><h3><?php echo esc_html($heading); ?></h3><?php endif; ?><ul><?php foreach ($items as $item) : $text = is_array($item) ? ($item['text'] ?? '') : $item; if (trim((string) $text) !== '') : ?><li><?php echo esc_html($text); ?></li><?php endif; endforeach; ?></ul></div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php $valid_gallery = array_values(array_filter($gallery, static fn($image): bool => is_array($image) && !empty($image['url']))); ?>
            <?php if ($valid_gallery !== []) : ?>
                <section class="ts-trek-route-gallery" aria-label="<?php esc_attr_e('Route gallery', 'tanzania-sensational'); ?>">
                    <?php foreach ($valid_gallery as $image) : ?><figure><img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ?? ''); ?>" loading="lazy" decoding="async" /></figure><?php endforeach; ?>
                </section>
            <?php endif; ?>

            <section class="ts-trek-route-cta">
                <h2><?php echo esc_html($labels['cta_title']); ?></h2>
                <a class="ts-btn-primary" href="<?php echo esc_url(home_url('/contact')); ?>"><?php esc_html_e('Ask about this route', 'tanzania-sensational'); ?></a>
                <p><?php esc_html_e('Availability and current pricing are confirmed by our team. No payment is taken online.', 'tanzania-sensational'); ?></p>
            </section>
        </div>
    </article>
    <?php
    return (string) ob_get_clean();
}

/** Render one trekking route post from its structured ACF fields. */
function ts_render_trek_route_post(int $post_id, array $labels = []): string
{
    if ($post_id < 1 || !function_exists('get_field')) {
        return '';
    }

    $fields = [
        'duration' => 'ts_trek_duration',
        'difficulty' => 'ts_trek_difficulty',
        'distance' => 'ts_trek_distance',
        'elevation_gain' => 'ts_trek_elevation_gain',
        'hero_image_url' => 'ts_trek_hero_image_url',
        'hero_image_alt' => 'ts_trek_hero_image_alt',
        'overview' => 'ts_trek_overview',
        'highlights' => 'ts_trek_highlights',
        'itinerary' => 'ts_trek_itinerary',
        'inclusions' => 'ts_trek_inclusions',
        'exclusions' => 'ts_trek_exclusions',
        'gallery_urls' => 'ts_trek_gallery_urls',
    ];
    $route = [];
    foreach ($fields as $key => $field_name) {
        $route[$key] = get_field($field_name, $post_id);
    }

    return ts_render_trek_route_sections($route, (string) get_the_title($post_id), $labels);
}

/** Render the current trekking route from its shortcode. */
function ts_trek_route_shortcode(): string
{
    if (!function_exists('is_singular') || !is_singular('ts_trek_route')) {
        return '';
    }

    return ts_render_trek_route_post((int) get_the_ID());
}

add_shortcode('ts_trek_route', 'ts_trek_route_shortcode');
