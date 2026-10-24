<?php
/** Dedicated Elementor widgets for the remaining structured static pages. */
if ( ! defined( 'ABSPATH' ) ) { exit; }

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

abstract class TS_Structured_Page_Widget extends Widget_Base {
    abstract protected function shortcode_tag();
    public function get_icon() { return 'eicon-document-file'; }
    public function get_categories() { return [ 'ts-widgets' ]; }

    protected function register_controls() {
        $this->start_controls_section( 'page_settings', [ 'label' => __( 'Page Sections', 'tanzania-sensational' ) ] );
        $this->add_control( 'editor_note', [
            'type' => Controls_Manager::RAW_HTML,
            'raw' => __( 'This widget preserves the complete Tanzania Sensational page design. Use these controls to manage the major sections.', 'tanzania-sensational' ),
            'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
        ] );
        $this->add_control( 'hide_first_section', [
            'label' => __( 'Hide Hero / First Section', 'tanzania-sensational' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '',
        ] );
        $this->add_control( 'hide_last_section', [
            'label' => __( 'Hide Final CTA / Last Section', 'tanzania-sensational' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '',
        ] );
        $this->end_controls_section();
    }

    protected function render() {
        $html = do_shortcode( '[' . $this->shortcode_tag() . ']' );
        echo $this->apply_visibility( $html, $this->get_settings_for_display() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    protected function apply_visibility( $html, $settings ) {
        $classes = [];
        if ( 'yes' === ( $settings['hide_first_section'] ?? '' ) ) { $classes[] = 'ts-hide-first-section'; }
        if ( 'yes' === ( $settings['hide_last_section'] ?? '' ) ) { $classes[] = 'ts-hide-last-section'; }
        if ( $classes ) {
            $html = preg_replace( '/class="([^"]*(?:utility-root|field-root|field-guide-root|safari-pillar-root)[^"]*)"/', 'class="$1 ' . implode( ' ', $classes ) . '"', $html, 1 );
        }
        return $html;
    }

    protected function register_hero_controls( $eyebrow, $title, $subtitle, $image = '' ) {
        $this->start_controls_section( 'hero_copy', [ 'label' => __( 'Hero Content', 'tanzania-sensational' ) ] );
        $this->add_control( 'hero_eyebrow', [ 'label' => __( 'Eyebrow', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => $eyebrow ] );
        $this->add_control( 'hero_title', [ 'label' => __( 'Heading', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => $title ] );
        $this->add_control( 'hero_subtitle', [ 'label' => __( 'Introduction', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => $subtitle ] );
        if ( $image ) {
            $this->add_control( 'hero_image', [ 'label' => __( 'Background Image', 'tanzania-sensational' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => $image ] ] );
        }
        $this->end_controls_section();
    }

    protected function apply_hero_copy( $html, $settings, $eyebrow, $title, $subtitle, $prefix = 'utility' ) {
        $rendered_title = esc_html( $settings['hero_title'] );
        if ( 'field' === $prefix ) {
            $rendered_title = $this->accent_last_word( $settings['hero_title'] );
        }
        $html = strtr( $html, [
            '<span class="' . $prefix . '-hero-eyebrow">' . $eyebrow . '</span>' => '<span class="' . $prefix . '-hero-eyebrow">' . esc_html( $settings['hero_eyebrow'] ) . '</span>',
            '<h1 class="' . $prefix . '-hero-title">' . $title . '</h1>' => '<h1 class="' . $prefix . '-hero-title">' . $rendered_title . '</h1>',
            '<p class="' . $prefix . '-hero-subtitle">' . $subtitle . '</p>' => '<p class="' . $prefix . '-hero-subtitle">' . esc_html( $settings['hero_subtitle'] ) . '</p>',
        ] );
        $image = $settings['hero_image']['url'] ?? '';
        if ( $image ) {
            $html = preg_replace( '/(<div class="' . preg_quote( $prefix, '/' ) . '-hero-(?:bg|img)">\s*<img src=")[^"]+/', '$1' . esc_url( $image ), $html, 1 );
        }
        return $html;
    }

    protected function accent_last_word( $text ) {
        $words = preg_split( '/\s+/', trim( (string) $text ) );
        if ( count( $words ) < 2 ) { return '<em>' . esc_html( $text ) . '</em>'; }
        $last = array_pop( $words );
        return esc_html( implode( ' ', $words ) ) . ' <em>' . esc_html( $last ) . '</em>';
    }

    protected function apply_named_visibility( $html, $settings, $keys, $prefix ) {
        $classes = [];
        foreach ( $keys as $key ) {
            if ( 'yes' === ( $settings[ 'hide_' . $key ] ?? '' ) ) {
                $classes[] = 'ts-hide-' . sanitize_html_class( $prefix . '-' . $key );
            }
        }
        if ( $classes ) {
            $html = preg_replace( '/class="([^"]*(?:field-root|field-guide-root|safari-pillar-root)[^"]*)"/', 'class="$1 ' . implode( ' ', $classes ) . '"', $html, 1 );
        }
        return $html;
    }
}

class TS_Safari_Guide_Page_Widget extends TS_Structured_Page_Widget {
    public function get_name() { return 'ts_safari_guide_page'; }
    public function get_title() { return __( 'TS Safari Guide Page', 'tanzania-sensational' ); }
    protected function shortcode_tag() { return 'ts_safari_guide_page'; }

    protected function register_controls() {
        parent::register_controls();
        $this->start_controls_section( 'guide_copy', [ 'label' => __( 'Hero & Final CTA', 'tanzania-sensational' ) ] );
        $this->add_control( 'hero_eyebrow', [ 'label' => __( 'Hero Eyebrow', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'The Complete Guide', 'tanzania-sensational' ) ] );
        $this->add_control( 'hero_title', [ 'label' => __( 'Hero Title', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Tanzania Safari.', 'tanzania-sensational' ) ] );
        $this->add_control( 'hero_subtitle', [ 'label' => __( 'Hero Introduction', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => __( 'Everything you need to plan the ultimate East African safari — from choosing your destination to packing for the bush.', 'tanzania-sensational' ) ] );
        $this->add_control( 'hero_image', [ 'label' => __( 'Hero Background Image', 'tanzania-sensational' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => 'https://images.unsplash.com/photo-1516422213484-2af298bf06ad?q=80&w=2000&auto=format&fit=crop' ] ] );
        $this->add_control( 'cta_title', [ 'label' => __( 'CTA Heading', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Ready for the Adventure?', 'tanzania-sensational' ) ] );
        $this->add_control( 'packages_label', [ 'label' => __( 'Packages Button', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Browse Safari Packages', 'tanzania-sensational' ) ] );
        $this->add_control( 'packages_url', [ 'label' => __( 'Packages Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/safaris/packages' ] ] );
        $this->add_control( 'contact_label', [ 'label' => __( 'Contact Button', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => __( 'Contact Our Team', 'tanzania-sensational' ) ] );
        $this->add_control( 'contact_url', [ 'label' => __( 'Contact Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/contact' ] ] );
        $this->end_controls_section();
        $chapters = [
            [ 'journey', 'Your Safari Journey', "Africa's Greatest Wildlife Experience", 'Tanzania is home to some of the most spectacular wildlife viewing on Earth. From the endless plains of the Serengeti — where the Great Migration sees over 1.5 million wildebeest thunder across the savannah — to the Ngorongoro Crater, a natural amphitheatre teeming with predators and prey, Tanzania offers safari experiences that are simply unmatched anywhere else on the continent.' ],
            [ 'destinations', 'Choose Your Wilderness', 'Safari Destinations', "Tanzania's national parks and game reserves each offer a unique character and wildlife experience. Explore them below to find your perfect safari destination." ],
            [ 'packages', 'Curated Expeditions', 'Safari Packages', 'From intimate 3-day getaways to comprehensive 14-day expeditions, our safari packages are designed to match every travel style and budget.' ],
            [ 'preparation', 'Prepare for the Bush', 'Safari Preparation Guides', 'Proper preparation transforms a good safari into an extraordinary one. These guides cover everything from what to pack to understanding local customs.' ],
            [ 'planning', 'Plan Your Adventure', 'Planning Resources', 'From frequently asked questions to group joining options, these resources will help you plan every aspect of your safari.' ],
            [ 'style', 'Find Your Style', 'Safari by Travel Style', 'Whether you are travelling with family, celebrating a honeymoon, or seeking luxury — we have a safari designed for your needs.' ],
            [ 'faq', 'Quick Answers', 'Frequently Asked Questions', '' ],
        ];
        foreach ( $chapters as $chapter ) {
            $this->start_controls_section( 'chapter_' . $chapter[0], [ 'label' => sprintf( __( '%s Section', 'tanzania-sensational' ), $chapter[2] ) ] );
            $this->add_control( $chapter[0] . '_eyebrow', [ 'label' => __( 'Eyebrow', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => $chapter[1] ] );
            $this->add_control( $chapter[0] . '_title', [ 'label' => __( 'Heading', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => $chapter[2] ] );
            if ( '' !== $chapter[3] ) {
                $this->add_control( $chapter[0] . '_body', [ 'label' => __( 'Introduction', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => $chapter[3] ] );
            }
            $this->add_control( 'hide_' . $chapter[0], [ 'label' => __( 'Hide This Section', 'tanzania-sensational' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '' ] );
            $this->end_controls_section();
        }
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $html = do_shortcode( '[ts_safari_guide_page]' );
        if ( ! empty( $s['hero_image']['url'] ) ) {
            $html = preg_replace( '/(<div class="field-hero-img">\s*<img src=")[^"]+/', '$1' . esc_url( $s['hero_image']['url'] ), $html, 1 );
        }
        $hero_title = esc_html( rtrim( $s['hero_title'], '.' ) ) . '<em>.</em>';
        $cta_title = esc_html( rtrim( $s['cta_title'], '?' ) ) . '<em>?</em>';
        $replace = [
            '<span class="field-hero-eyebrow">The Complete Guide</span>' => '<span class="field-hero-eyebrow">' . esc_html( $s['hero_eyebrow'] ) . '</span>',
            '<h1 class="field-hero-title">Tanzania <em>Safari.</em></h1>' => '<h1 class="field-hero-title">' . $hero_title . '</h1>',
            '<p class="field-hero-subtitle">Everything you need to plan the ultimate East African safari — from choosing your destination to packing for the bush.</p>' => '<p class="field-hero-subtitle">' . esc_html( $s['hero_subtitle'] ) . '</p>',
            '<h2 class="field-cta-title">Ready for the <em>Adventure?</em></h2>' => '<h2 class="field-cta-title">' . $cta_title . '</h2>',
            'href="/safaris/packages" class="field-btn">Browse Safari Packages ' => 'href="' . esc_url( $s['packages_url']['url'] ?: '/safaris/packages' ) . '" class="field-btn">' . esc_html( $s['packages_label'] ) . ' ',
            'href="/contact" class="field-btn" style="border-color: var(--field-gold); color: var(--field-gold);">Contact Our Team<' => 'href="' . esc_url( $s['contact_url']['url'] ?: '/contact' ) . '" class="field-btn" style="border-color: var(--field-gold); color: var(--field-gold);">' . esc_html( $s['contact_label'] ) . '<',
        ];
        $chapter_copy = [
            'journey' => [ 'Your Safari Journey', "Africa's Greatest Wildlife <em>Experience</em>", 'Tanzania is home to some of the most spectacular wildlife viewing on Earth. From the endless plains of the Serengeti — where the Great Migration sees over 1.5 million wildebeest thunder across the savannah — to the Ngorongoro Crater, a natural amphitheatre teeming with predators and prey, Tanzania offers safari experiences that are simply unmatched anywhere else on the continent.' ],
            'destinations' => [ 'Choose Your Wilderness', 'Safari <em>Destinations</em>', "Tanzania's national parks and game reserves each offer a unique character and wildlife experience. Explore them below to find your perfect safari destination." ],
            'packages' => [ 'Curated Expeditions', 'Safari <em>Packages</em>', 'From intimate 3-day getaways to comprehensive 14-day expeditions, our safari packages are designed to match every travel style and budget.' ],
            'preparation' => [ 'Prepare for the Bush', 'Safari Preparation <em>Guides</em>', 'Proper preparation transforms a good safari into an extraordinary one. These guides cover everything from what to pack to understanding local customs.' ],
            'planning' => [ 'Plan Your Adventure', 'Planning <em>Resources</em>', 'From frequently asked questions to group joining options, these resources will help you plan every aspect of your safari.' ],
            'style' => [ 'Find Your Style', 'Safari by Travel <em>Style</em>', 'Whether you are travelling with family, celebrating a honeymoon, or seeking luxury — we have a safari designed for your needs.' ],
            'faq' => [ 'Quick Answers', 'Frequently Asked <em>Questions</em>', '' ],
        ];
        foreach ( $chapter_copy as $key => $original ) {
            $replace['<span class="field-chapter-eyebrow">' . $original[0] . '</span>'] = '<span class="field-chapter-eyebrow">' . esc_html( $s[ $key . '_eyebrow' ] ) . '</span>';
            $replace['<h2 class="field-chapter-title">' . $original[1] . '</h2>'] = '<h2 class="field-chapter-title">' . $this->accent_last_word( $s[ $key . '_title' ] ) . '</h2>';
            if ( '' !== $original[2] ) {
                $replace['<p class="field-chapter-body">' . $original[2] . '</p>'] = '<p class="field-chapter-body">' . esc_html( $s[ $key . '_body' ] ) . '</p>';
            }
        }
        $html = $this->apply_named_visibility( strtr( $html, $replace ), $s, [ 'journey', 'destinations', 'packages', 'preparation', 'planning', 'style', 'faq' ], 'safari' );
        echo $this->apply_visibility( $html, $s ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
class TS_Kilimanjaro_Pillar_Page_Widget extends TS_Structured_Page_Widget {
    public function get_name() { return 'ts_kilimanjaro_pillar_page'; }
    public function get_title() { return __( 'TS Kilimanjaro Pillar Page', 'tanzania-sensational' ); }
    protected function shortcode_tag() { return 'ts_kilimanjaro_pillar_page'; }
    protected function register_controls() {
        parent::register_controls();
        $this->register_hero_controls( 'The Complete Guide', 'Kilimanjaro Trekking.', "Everything you need to plan, prepare, and conquer Africa's highest peak — from choosing your route to summit day.", 'https://images.unsplash.com/photo-1585409677983-0f6c41ca9c3b?q=80&w=2000&auto=format&fit=crop' );
        $this->start_controls_section( 'cta_copy', [ 'label' => __( 'Final CTA', 'tanzania-sensational' ) ] );
        $this->add_control( 'cta_title', [ 'label' => __( 'Heading', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'Ready for the Adventure?' ] );
        $this->add_control( 'cta_body', [ 'label' => __( 'Description', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 3, 'default' => 'Whether you have a specific route in mind or need help choosing the perfect Kilimanjaro climb, our expert team is here to help make your summit dream a reality.' ] );
        $this->add_control( 'primary_label', [ 'label' => __( 'Primary Button', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'View Group Departures' ] );
        $this->add_control( 'primary_url', [ 'label' => __( 'Primary Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/group-departures' ] ] );
        $this->add_control( 'contact_label', [ 'label' => __( 'Contact Button', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'Contact Our Team' ] );
        $this->add_control( 'contact_url', [ 'label' => __( 'Contact Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/contact' ] ] );
        $this->end_controls_section();
        $chapters = [
            [ 'mountain', 'Mount Kilimanjaro', "Africa's Roof, Your Summit", 'At 5,895 metres (19,341 feet), Mount Kilimanjaro is the highest free-standing mountain in the world and the tallest peak in Africa. Located in northeastern Tanzania near the town of Moshi, this dormant volcano attracts over 35,000 trekkers each year from around the globe.' ],
            [ 'routes', 'Choose Your Path', 'Kilimanjaro Climbing Routes', 'Each route offers a unique experience — different landscapes, difficulty levels, and summit success rates. Compare them below to find the one that matches your fitness level, schedule, and adventure style.' ],
            [ 'prep', 'Plan Your Expedition', 'Preparation Guides', 'Proper preparation is the difference between a successful summit and a disappointing turn-around. These guides cover everything from choosing your route to understanding the costs.' ],
            [ 'safety', 'Stay Safe at Altitude', 'Health & Safety', 'Altitude sickness is the most common reason for unsuccessful summits. Understanding the risks and how to mitigate them is essential for a safe and enjoyable climb.' ],
            [ 'booking', 'After You Book', 'Post-Booking Essentials', 'Once you have booked your Kilimanjaro climb, use these guides to prepare physically, pack correctly, and plan your travel logistics.' ],
            [ 'during', 'Life on the Mountain', 'What to Expect During Your Climb', 'Understanding the daily rhythm of a Kilimanjaro expedition helps you prepare mentally and physically for the adventure ahead.' ],
            [ 'kili_faq', 'Quick Answers', 'Frequently Asked Questions', '' ],
        ];
        foreach ( $chapters as $chapter ) {
            $this->start_controls_section( 'kili_chapter_' . $chapter[0], [ 'label' => sprintf( __( '%s Section', 'tanzania-sensational' ), $chapter[2] ) ] );
            $this->add_control( $chapter[0] . '_eyebrow', [ 'label' => __( 'Eyebrow', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => $chapter[1] ] );
            $this->add_control( $chapter[0] . '_title', [ 'label' => __( 'Heading', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => $chapter[2] ] );
            if ( '' !== $chapter[3] ) {
                $this->add_control( $chapter[0] . '_body', [ 'label' => __( 'Introduction', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => $chapter[3] ] );
            }
            $this->add_control( 'hide_' . $chapter[0], [ 'label' => __( 'Hide This Section', 'tanzania-sensational' ), 'type' => Controls_Manager::SWITCHER, 'return_value' => 'yes', 'default' => '' ] );
            $this->end_controls_section();
        }
    }
    protected function render() {
        $s = $this->get_settings_for_display();
        $html = $this->apply_hero_copy( do_shortcode( '[ts_kilimanjaro_pillar_page]' ), $s, 'The Complete Guide', 'Kilimanjaro <em>Trekking.</em>', "Everything you need to plan, prepare, and conquer Africa's highest peak — from choosing your route to summit day.", 'field' );
        $html = strtr( $html, [
            '<h2 class="field-cta-title">Ready for the <em>Adventure?</em></h2>' => '<h2 class="field-cta-title">' . $this->accent_last_word( $s['cta_title'] ) . '</h2>',
            '<p class="field-cta-body">Whether you have a specific route in mind or need help choosing the perfect Kilimanjaro climb, our expert team is here to help make your summit dream a reality.</p>' => '<p class="field-cta-body">' . esc_html( $s['cta_body'] ) . '</p>',
            'href="/group-departures" class="field-btn">View Group Departures ' => 'href="' . esc_url( $s['primary_url']['url'] ?: '/group-departures' ) . '" class="field-btn">' . esc_html( $s['primary_label'] ) . ' ',
            'href="/contact" class="field-btn" style="border-color: var(--field-gold); color: var(--field-gold);">Contact Our Team<' => 'href="' . esc_url( $s['contact_url']['url'] ?: '/contact' ) . '" class="field-btn" style="border-color: var(--field-gold); color: var(--field-gold);">' . esc_html( $s['contact_label'] ) . '<',
        ] );
        $chapter_copy = [
            'mountain' => [ 'Mount Kilimanjaro', "Africa's Roof, Your <em>Summit</em>", 'At 5,895 metres (19,341 feet), Mount Kilimanjaro is the highest free-standing mountain in the world and the tallest peak in Africa. Located in northeastern Tanzania near the town of Moshi, this dormant volcano attracts over 35,000 trekkers each year from around the globe.' ],
            'routes' => [ 'Choose Your Path', 'Kilimanjaro Climbing <em>Routes</em>', 'Each route offers a unique experience — different landscapes, difficulty levels, and summit success rates. Compare them below to find the one that matches your fitness level, schedule, and adventure style.' ],
            'prep' => [ 'Plan Your Expedition', 'Preparation <em>Guides</em>', 'Proper preparation is the difference between a successful summit and a disappointing turn-around. These guides cover everything from choosing your route to understanding the costs.' ],
            'safety' => [ 'Stay Safe at Altitude', 'Health & <em>Safety</em>', 'Altitude sickness is the most common reason for unsuccessful summits. Understanding the risks and how to mitigate them is essential for a safe and enjoyable climb.' ],
            'booking' => [ 'After You Book', 'Post-Booking <em>Essentials</em>', 'Once you have booked your Kilimanjaro climb, use these guides to prepare physically, pack correctly, and plan your travel logistics.' ],
            'during' => [ 'Life on the Mountain', 'What to Expect <em>During</em> Your Climb', 'Understanding the daily rhythm of a Kilimanjaro expedition helps you prepare mentally and physically for the adventure ahead.' ],
            'kili_faq' => [ 'Quick Answers', 'Frequently Asked <em>Questions</em>', '' ],
        ];
        foreach ( $chapter_copy as $key => $original ) {
            $html = str_replace( '<span class="field-chapter-eyebrow">' . $original[0] . '</span>', '<span class="field-chapter-eyebrow">' . esc_html( $s[ $key . '_eyebrow' ] ) . '</span>', $html );
            $title = ( 'during' === $key && 'What to Expect During Your Climb' === $s[ $key . '_title' ] ) ? 'What to Expect <em>During</em> Your Climb' : $this->accent_last_word( $s[ $key . '_title' ] );
            $html = str_replace( '<h2 class="field-chapter-title">' . $original[1] . '</h2>', '<h2 class="field-chapter-title">' . $title . '</h2>', $html );
            if ( '' !== $original[2] ) {
                $html = str_replace( '<p class="field-chapter-body">' . $original[2] . '</p>', '<p class="field-chapter-body">' . esc_html( $s[ $key . '_body' ] ) . '</p>', $html );
            }
        }
        $html = $this->apply_named_visibility( $html, $s, [ 'mountain', 'routes', 'prep', 'safety', 'booking', 'during', 'kili_faq' ], 'kili' );
        echo $this->apply_visibility( $html, $s ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
class TS_Gear_Checklist_Page_Widget extends TS_Structured_Page_Widget {
    public function get_name() { return 'ts_gear_checklist_page'; }
    public function get_title() { return __( 'TS Gear Checklist Page', 'tanzania-sensational' ); }
    protected function shortcode_tag() { return 'ts_gear_checklist_page'; }
    protected function register_controls() {
        parent::register_controls();
        $this->register_hero_controls( 'Preparation', 'Gear Checklist', "From the tropical rainforest to the arctic summit, climbing Kilimanjaro requires a highly adaptable layering system. Make sure you don't compromise on the essentials.", 'https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=2000&auto=format&fit=crop' );
        $repeater = new Repeater();
        $repeater->add_control( 'category', [ 'label' => __( 'Category', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT ] );
        $repeater->add_control( 'items', [ 'label' => __( 'Items (one per line)', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 10 ] );
        $this->start_controls_section( 'gear_content', [ 'label' => __( 'Gear Categories', 'tanzania-sensational' ) ] );
        $this->add_control( 'gear_categories', [
            'label' => __( 'Checklist Categories', 'tanzania-sensational' ),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ category }}}',
            'default' => [
                [ 'category' => 'Clothing', 'items' => "Moisture-wicking base layers (top & bottom)\nInsulating mid-layer fleece\nDown or synthetic jacket\nWaterproof / windproof jacket and pants\nTrekking trousers\nThermal underwear for summit night\nSun hat and warm beanie\nBuff / neck gaiter\nWarm gloves and waterproof shell mittens" ],
                [ 'category' => 'Footwear', 'items' => "Waterproof hiking boots (broken in)\nCamp shoes / trainers\nWool or synthetic trekking socks (multiple pairs)\nGaiters" ],
                [ 'category' => 'Equipment', 'items' => "Sleeping bag rated to -10°C or lower\nSleeping pad / mat\nTrekking poles\nHeadlamp with extra batteries\nSunglasses (UV400) and ski goggles\nDaypack (25–35 L)\nDuffel bag (max 15 kg)\nWater bottles / hydration system" ],
                [ 'category' => 'Accessories', 'items' => "Camera and extra batteries\nBinoculars\nSnacks / energy bars\nPower bank and charging cables\nDry bags / waterproof stuff sacks\nPersonal first-aid kit" ],
                [ 'category' => 'Toiletries / Medical', 'items' => "Sunscreen (SPF 50+)\nLip balm with SPF\nInsect repellent\nToilet paper and wet wipes\nHand sanitizer\nPersonal medications\nDiamox (if prescribed)\nWater purification tablets" ],
            ],
        ] );
        $this->end_controls_section();
        $this->start_controls_section( 'rental_copy', [ 'label' => __( 'Rental Request', 'tanzania-sensational' ) ] );
        $this->add_control( 'rental_title', [ 'label' => __( 'Heading', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'Request gear rental' ] );
        $this->add_control( 'rental_body', [ 'label' => __( 'Instructions', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => "Select quantities above (0 means you do not need to rent that item), then submit your request. We'll confirm availability and pricing by email. No online payment." ] );
        $this->add_control( 'submit_label', [ 'label' => __( 'Submit Button', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => 'Submit rental request' ] );
        $this->add_control( 'form_action', [ 'label' => __( 'Form Destination', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => '/contact' ] ] );
        $this->end_controls_section();
    }
    protected function render() {
        $s = $this->get_settings_for_display();
        $html = $this->apply_hero_copy( do_shortcode( '[ts_gear_checklist_page]' ), $s, 'Preparation', 'Gear Checklist', "From the tropical rainforest to the arctic summit, climbing Kilimanjaro requires a highly adaptable layering system. Make sure you don't compromise on the essentials." );
        $grid = '<div class="utility-grid" id="gear-grid">';
        foreach ( $s['gear_categories'] as $category_index => $category ) {
            $category_name = trim( $category['category'] ?? '' );
            if ( '' === $category_name ) { continue; }
            $grid .= '<div class="util-card" data-category="' . esc_attr( $category_name ) . '"><h3 class="util-card-title">' . esc_html( $category_name ) . '</h3><div class="gear-list">';
            $items = preg_split( '/\r\n|\r|\n/', $category['items'] ?? '' );
            foreach ( array_values( array_filter( array_map( 'trim', $items ) ) ) as $item_index => $item ) {
                $id = 'gear-' . sanitize_title( $category_name ) . '-' . $category_index . '-' . $item_index;
                $grid .= '<div class="gear-item"><input type="checkbox" id="' . esc_attr( $id ) . '" data-item="' . esc_attr( $item ) . '" /><label for="' . esc_attr( $id ) . '">' . esc_html( $item ) . '</label><input type="number" min="0" max="20" value="0" aria-label="' . esc_attr( 'Rental quantity for ' . $item ) . '" /></div>';
            }
            $grid .= '</div></div>';
        }
        $grid .= '</div>';
        $html = preg_replace( '/<div class="utility-grid" id="gear-grid">.*?<div class="util-card" style="margin-top: 40px;">/s', $grid . '<div class="util-card" style="margin-top: 40px;">', $html, 1 );
        $html = strtr( $html, [
            '<h3 class="util-card-title">Request gear rental</h3>' => '<h3 class="util-card-title">' . esc_html( $s['rental_title'] ) . '</h3>',
            '<p style="color: rgba(255,255,255,0.65); line-height: 1.7; margin-bottom: 20px;">Select quantities above (0 means you do not need to rent that item), then submit your request. We\'ll confirm availability and pricing by email. No online payment.</p>' => '<p style="color: rgba(255,255,255,0.65); line-height: 1.7; margin-bottom: 20px;">' . esc_html( $s['rental_body'] ) . '</p>',
            'action="/contact" method="post"' => 'action="' . esc_url( $s['form_action']['url'] ?: '/contact' ) . '" method="post"',
            '<button type="submit" id="gear-submit" style="margin-top: 20px;">Submit rental request</button>' => '<button type="submit" id="gear-submit" style="margin-top: 20px;">' . esc_html( $s['submit_label'] ) . '</button>',
        ] );
        echo $this->apply_visibility( $html, $s ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
class TS_Training_Guide_Page_Widget extends TS_Structured_Page_Widget {
    public function get_name() { return 'ts_training_guide_page'; }
    public function get_title() { return __( 'TS Training Guide Page', 'tanzania-sensational' ); }
    protected function shortcode_tag() { return 'ts_training_guide_page'; }
    protected function register_controls() {
        parent::register_controls();
        $this->register_hero_controls( 'Preparation', 'Training Guide', 'Kilimanjaro is a non-technical hike, but you are trekking at extreme altitude for multiple days. Cardiovascular endurance and leg strength are paramount.', 'https://images.unsplash.com/photo-1526772662000-3f88f10405ff?q=80&w=2000&auto=format&fit=crop' );
        $repeater = new Repeater();
        $repeater->add_control( 'number', [ 'label' => __( 'Step Number', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT ] );
        $repeater->add_control( 'title', [ 'label' => __( 'Heading', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT ] );
        $repeater->add_control( 'body', [ 'label' => __( 'Summary', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 2 ] );
        $repeater->add_control( 'items', [ 'label' => __( 'Checklist (one item per line)', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 5 ] );
        $this->start_controls_section( 'training_steps', [ 'label' => __( 'Training Steps', 'tanzania-sensational' ) ] );
        $this->add_control( 'steps', [
            'label' => __( 'Steps', 'tanzania-sensational' ), 'type' => Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(), 'title_field' => '{{{ number }}} — {{{ title }}}',
            'default' => [
                [ 'number' => '1', 'title' => 'Cardio Base (12-8 Weeks Out)', 'body' => 'Focus on building raw cardiovascular endurance.', 'items' => "Running, cycling, or swimming 3-4 times a week for 45-60 minutes.\nMaintain a moderate, conversational heart rate." ],
                [ 'number' => '2', 'title' => 'Hill Training (8-4 Weeks Out)', 'body' => 'Simulate the mountain terrain by adding elevation.', 'items' => "Find the longest, steepest local hills or hit the stair-master.\nBegin carrying a daypack with 5kg-8kg (10-15 lbs) of weight.\nDo at least one long hike (4+ hours) per week." ],
                [ 'number' => '3', 'title' => 'The Taper (Last 3 Weeks)', 'body' => 'Rest and recovery are just as important as the training.', 'items' => "Week 3: Reduce training volume by 25%.\nWeek 2: Reduce volume by 50%. Focus on stretching.\nWeek 1: Active rest. Light walking only. Arrive fresh." ],
            ],
        ] );
        $this->end_controls_section();
    }
    protected function render() {
        $s = $this->get_settings_for_display();
        $html = $this->apply_hero_copy( do_shortcode( '[ts_training_guide_page]' ), $s, 'Preparation', 'Training Guide', 'Kilimanjaro is a non-technical hike, but you are trekking at extreme altitude for multiple days. Cardiovascular endurance and leg strength are paramount.' );
        $cards = '';
        foreach ( $s['steps'] as $step ) {
            $items = preg_split( '/\r\n|\r|\n/', $step['items'] ?? '' );
            $list = '';
            foreach ( array_filter( array_map( 'trim', $items ) ) as $item ) { $list .= '<li>' . esc_html( $item ) . '</li>'; }
            $cards .= '<div class="util-card"><div class="util-card-icon"><span style="font-size: 1.5rem; font-weight: bold;">' . esc_html( $step['number'] ) . '</span></div><h3 class="util-card-title">' . esc_html( $step['title'] ) . '</h3><p class="util-card-p">' . esc_html( $step['body'] ) . '</p><ul class="util-card-list">' . $list . '</ul></div>';
        }
        $html = preg_replace( '/(<div class="utility-grid">).*?(<\/div>\s*<\/section>)/s', '$1' . $cards . '$2', $html, 1 );
        echo $this->apply_visibility( $html, $s ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
class TS_Safari_Addons_Page_Widget extends TS_Structured_Page_Widget {
    public function get_name() { return 'ts_safari_addons_page'; }
    public function get_title() { return __( 'TS Safari Add-ons Page', 'tanzania-sensational' ); }
    protected function shortcode_tag() { return 'ts_safari_addons_page'; }
    protected function register_controls() {
        parent::register_controls();
        $this->register_hero_controls( 'The Reward', 'Post-Trek Safari Add-ons', 'You conquered the Roof of Africa. Now rest your legs in the back of a luxury 4x4 and witness the greatest wildlife spectacle on earth.', 'https://images.unsplash.com/photo-1547970810-dc1eac37d174?q=80&w=2000&auto=format&fit=crop' );
        foreach ( [
            'safari' => [ 'Safari Card', '2-Day Tarangire & Ngorongoro', 'The perfect taste of the wild for those short on time. Witness the massive elephant herds of Tarangire before descending into the legendary Ngorongoro Crater in search of the Big Five.', 'View Safari Packages', '/safaris/packages', 'https://images.unsplash.com/photo-1516422213484-2af298bf06ad?auto=format&fit=crop&q=80' ],
            'island' => [ 'Zanzibar Card', 'Zanzibar Beach Recovery', 'Trade your hiking boots for bare feet. A direct flight from Arusha lands you on the pristine white sands of the Spice Island. The ultimate relaxation after the rigors of the mountain.', 'Explore Zanzibar', '/zanzibar', 'https://images.unsplash.com/photo-1621845184551-bb5e7141ecf4?auto=format&fit=crop&q=80' ],
        ] as $key => $card ) {
            $this->start_controls_section( $key . '_card', [ 'label' => __( $card[0], 'tanzania-sensational' ) ] );
            $this->add_control( $key . '_image', [ 'label' => __( 'Image', 'tanzania-sensational' ), 'type' => Controls_Manager::MEDIA, 'default' => [ 'url' => $card[5] ] ] );
            $this->add_control( $key . '_title', [ 'label' => __( 'Heading', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => $card[1] ] );
            $this->add_control( $key . '_body', [ 'label' => __( 'Description', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXTAREA, 'rows' => 4, 'default' => $card[2] ] );
            $this->add_control( $key . '_label', [ 'label' => __( 'Button Label', 'tanzania-sensational' ), 'type' => Controls_Manager::TEXT, 'default' => $card[3] ] );
            $this->add_control( $key . '_url', [ 'label' => __( 'Button Link', 'tanzania-sensational' ), 'type' => Controls_Manager::URL, 'default' => [ 'url' => $card[4] ] ] );
            $this->end_controls_section();
        }
    }
    protected function render() {
        $s = $this->get_settings_for_display();
        $html = $this->apply_hero_copy( do_shortcode( '[ts_safari_addons_page]' ), $s, 'The Reward', 'Post-Trek Safari Add-ons', 'You conquered the Roof of Africa. Now rest your legs in the back of a luxury 4x4 and witness the greatest wildlife spectacle on earth.' );
        $html = strtr( $html, [
            'https://images.unsplash.com/photo-1516422213484-2af298bf06ad?auto=format&amp;fit=crop&amp;q=80' => esc_url( $s['safari_image']['url'] ),
            '<h3 class="util-card-title">2-Day Tarangire & Ngorongoro</h3>' => '<h3 class="util-card-title">' . esc_html( $s['safari_title'] ) . '</h3>',
            '<p class="util-card-p" style="margin-bottom: 20px;">The perfect taste of the wild for those short on time. Witness the massive elephant herds of Tarangire before descending into the legendary Ngorongoro Crater in search of the Big Five.</p>' => '<p class="util-card-p" style="margin-bottom: 20px;">' . esc_html( $s['safari_body'] ) . '</p>',
            'href="/safaris/packages" class="dep-btn" style="border: none; padding: 0; text-decoration: underline; text-underline-offset: 6px;">View Safari Packages<' => 'href="' . esc_url( $s['safari_url']['url'] ?: '/safaris/packages' ) . '" class="dep-btn" style="border: none; padding: 0; text-decoration: underline; text-underline-offset: 6px;">' . esc_html( $s['safari_label'] ) . '<',
            'https://images.unsplash.com/photo-1621845184551-bb5e7141ecf4?auto=format&amp;fit=crop&amp;q=80' => esc_url( $s['island_image']['url'] ),
            '<h3 class="util-card-title">Zanzibar Beach Recovery</h3>' => '<h3 class="util-card-title">' . esc_html( $s['island_title'] ) . '</h3>',
            '<p class="util-card-p" style="margin-bottom: 20px;">Trade your hiking boots for bare feet. A direct flight from Arusha lands you on the pristine white sands of the Spice Island. The ultimate relaxation after the rigors of the mountain.</p>' => '<p class="util-card-p" style="margin-bottom: 20px;">' . esc_html( $s['island_body'] ) . '</p>',
            'href="/zanzibar" class="dep-btn" style="border: none; padding: 0; text-decoration: underline; text-underline-offset: 6px;">Explore Zanzibar<' => 'href="' . esc_url( $s['island_url']['url'] ?: '/zanzibar' ) . '" class="dep-btn" style="border: none; padding: 0; text-decoration: underline; text-underline-offset: 6px;">' . esc_html( $s['island_label'] ) . '<',
        ] );
        echo $this->apply_visibility( $html, $s ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }
}
