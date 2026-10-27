<?php
/**
 * Custom Elementor widgets for Tanzania Sensational.
 *
 * @package Tanzania_Sensational
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register a custom widget category.
 */
add_action( 'elementor/elements/categories_registered', function( $elements_manager ) {
    $elements_manager->add_category(
        'ts-widgets',
        [
            'title' => __( 'Tanzania Sensational', 'tanzania-sensational' ),
            'icon'  => 'fa fa-mountain',
        ]
    );
} );

/**
 * Register widgets once Elementor is ready.
 */
add_action( 'elementor/widgets/register', function( $widgets_manager ) {
    require_once __DIR__ . '/elementor/widgets/class-ts-hero-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-header-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-tour-archive-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-single-tour-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-destination-archive-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-single-destination-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-about-page-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-zanzibar-page-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-contact-page-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-faq-page-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-static-pages-widgets.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-footer-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-stats-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-packages-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-destinations-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-experience-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-departures-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-testimonials-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-extensions-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-cta-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-blog-archive-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-single-blog-widget.php';
    require_once __DIR__ . '/elementor/widgets/class-ts-single-trek-route-widget.php';

    $widgets_manager->register( new TS_Hero_Widget() );
    $widgets_manager->register( new TS_Header_Widget() );
    $widgets_manager->register( new TS_Tour_Archive_Widget() );
    $widgets_manager->register( new TS_Single_Tour_Widget() );
    $widgets_manager->register( new TS_Destination_Archive_Widget() );
    $widgets_manager->register( new TS_Single_Destination_Widget() );
    $widgets_manager->register( new TS_About_Page_Widget() );
    $widgets_manager->register( new TS_Zanzibar_Page_Widget() );
    $widgets_manager->register( new TS_Contact_Page_Widget() );
    $widgets_manager->register( new TS_FAQ_Page_Widget() );
    $widgets_manager->register( new TS_Safari_Guide_Page_Widget() );
    $widgets_manager->register( new TS_Kilimanjaro_Pillar_Page_Widget() );
    $widgets_manager->register( new TS_Gear_Checklist_Page_Widget() );
    $widgets_manager->register( new TS_Training_Guide_Page_Widget() );
    $widgets_manager->register( new TS_Safari_Addons_Page_Widget() );
    $widgets_manager->register( new TS_Footer_Widget() );
    $widgets_manager->register( new TS_Stats_Widget() );
    $widgets_manager->register( new TS_Packages_Widget() );
    $widgets_manager->register( new TS_Destinations_Widget() );
    $widgets_manager->register( new TS_Experience_Widget() );
    $widgets_manager->register( new TS_Departures_Widget() );
    $widgets_manager->register( new TS_Testimonials_Widget() );
    $widgets_manager->register( new TS_Extensions_Widget() );
    $widgets_manager->register( new TS_CTA_Widget() );
    $widgets_manager->register( new TS_Blog_Archive_Widget() );
    $widgets_manager->register( new TS_Single_Blog_Widget() );
    $widgets_manager->register( new TS_Single_Trek_Route_Widget() );
} );
