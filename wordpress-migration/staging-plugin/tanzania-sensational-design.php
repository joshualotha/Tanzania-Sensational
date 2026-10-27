<?php
/**
 * Plugin Name: Tanzania Sensational — Design System
 * Description: Global design tokens, fonts, layouts, and interactions for the Elementor migration.
 * Version: 1.3.0
 * Author: Migration Team
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue Google Fonts used by the React design.
 */
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'ts-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600&family=Source+Serif+4:ital,opsz,wght@0,8..60,400;0,8..60,500;0,8..60,600;0,8..60,700;1,8..60,400&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'ts-public-layout',
        plugin_dir_url( __FILE__ ) . 'public-layout.css',
        [],
        filemtime( __DIR__ . '/public-layout.css' )
    );

    if ( is_front_page() ) {
        wp_enqueue_style(
            'ts-homepage',
            plugin_dir_url( __FILE__ ) . 'homepage.css',
            [],
            '1.2.1'
        );
    }

    if ( is_page( [ 'about-us', 'contact', 'zanzibar', 'faq', 'safari-guide', 'kilimanjaro-pillar', 'gear-checklist', 'training-guide', 'safari-addons' ] ) ) {
        wp_enqueue_style(
            'ts-pages',
            plugin_dir_url( __FILE__ ) . 'pages.css',
            [],
            '1.0.1'
        );
    }

    if ( is_front_page() || is_singular( [ 'ts_tour', 'ts_destination' ] ) || is_post_type_archive( [ 'ts_tour', 'ts_destination' ] ) ) {
        wp_enqueue_style(
            'ts-dynamic-content',
            plugin_dir_url( __FILE__ ) . 'dynamic-content.css',
            [],
            '1.0.3'
        );
    }

    if ( is_page( 'blog' ) || is_singular( 'post' ) ) {
        wp_enqueue_style(
            'ts-blog',
            plugin_dir_url( __FILE__ ) . 'blog.css',
            [ 'ts-public-layout' ],
            filemtime( __DIR__ . '/blog.css' )
        );
    }

    if ( is_singular( 'ts_trek_route' ) ) {
        wp_enqueue_style(
            'ts-trekking-content',
            plugin_dir_url( __FILE__ ) . 'trekking-content.css',
            [ 'ts-public-layout' ],
            filemtime( __DIR__ . '/trekking-content.css' )
        );
    }
} );

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_script(
        'ts-frontend',
        plugin_dir_url( __FILE__ ) . 'frontend.js',
        [],
        '1.2.2',
        true
    );
}, 20 );

/**
 * Homepage sections.
 */
require_once __DIR__ . '/homepage-sections.php';

/**
 * Static page shortcodes.
 */
require_once __DIR__ . '/static-pages.php';

/**
 * Custom post types and taxonomies.
 */
require_once __DIR__ . '/cpt.php';

/**
 * ACF field groups.
 */
require_once __DIR__ . '/acf-fields.php';
require_once __DIR__ . '/trekking-fields.php';
require_once __DIR__ . '/blog-fields.php';

/**
 * Global site settings (contact, social, header, footer).
 */
require_once __DIR__ . '/site-settings.php';

/**
 * About Us page (ACF Free compatible standard fields).
 */
require_once __DIR__ . '/about-page-acf.php';

/**
 * Seed data importer.
 */
require_once __DIR__ . '/seed-data.php';

/**
 * Dynamic content shortcodes and helpers.
 */
require_once __DIR__ . '/dynamic-content.php';
require_once __DIR__ . '/trekking-content.php';
require_once __DIR__ . '/blog-render-helpers.php';

/**
 * Elementor custom widgets.
 */
require_once __DIR__ . '/elementor-widgets.php';

/**
 * Temporary fallbacks for Laravel routes not yet represented by WordPress
 * content. Exact redirects run only when WordPress has already resolved 404.
 */
require_once __DIR__ . '/blog-routing.php';
require_once __DIR__ . '/route-fallbacks.php';

/**
 * Inject global design tokens and base styles.
 */
add_action( 'wp_head', function() {
    ?>
    <style>
        :root {
            /* COASTAL STONE PALETTE */
            --ts-primary: #5B7B7A;    /* Sea-washed teal */
            --ts-secondary: #8C6D52;  /* Driftwood */
            --ts-neutral: #F7F4EF;    /* Sea foam / Warm Linen */
            --ts-dark: #1F2926;       /* Deep Water (Rich dark green-charcoal) */
            --ts-accent: #C9B99A;     /* Bleached Sand */
            --ts-bg: var(--ts-neutral);
            --ts-text: var(--ts-dark);
            --ts-text-muted: #535C58;
            --ts-gold: #C9A84C;       /* Brand gold */

            /* Legacy aliases (used by imported React CSS) */
            --primary: var(--ts-primary);
            --secondary: var(--ts-secondary);
            --neutral: var(--ts-neutral);
            --dark: var(--ts-dark);
            --accent: var(--ts-accent);
            --bg: var(--ts-neutral);
            --text: var(--ts-dark);
            --text-muted: var(--ts-text-muted);
            --gold: var(--ts-gold);
            --white: #ffffff;

            /* Typography Stacks */
            --ts-font-heading: 'Playfair Display', serif;
            --ts-font-body: 'Source Serif 4', serif;
            --ts-font-label: 'DM Sans', sans-serif;
            --ts-font-alt: 'Cormorant Garamond', serif;
            --ts-font-ui: 'Outfit', sans-serif;

            /* Legacy font aliases */
            --font-heading: var(--ts-font-heading);
            --font-body: var(--ts-font-body);
            --font-label: var(--ts-font-label);
            --font-alt: var(--ts-font-alt);
            --font-ui: var(--ts-font-ui);

            /* Spacing scale */
            --ts-space-xs: 0.5rem;
            --ts-space-sm: 1rem;
            --ts-space-md: 1.5rem;
            --ts-space-lg: 3rem;
            --ts-space-xl: 5rem;
            --ts-space-2xl: 8rem;

            /* Container */
            --ts-max-width: 1400px;
            --ts-radius-pill: 999px;
        }

        html {
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        body {
            background: var(--ts-bg);
            color: var(--ts-text);
            font-family: var(--ts-font-body);
            font-size: 1.1rem;
            line-height: 1.8;
            font-weight: 400;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Organic noise texture overlay */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.65' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.05'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 9999;
            opacity: 0.5;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: var(--ts-font-heading);
            color: var(--ts-dark);
            line-height: 1.2;
            font-weight: 600;
        }

        h1 { font-size: clamp(2.5rem, 6vw, 5rem); }
        h2 { font-size: clamp(2rem, 4vw, 3.5rem); }
        h3 { font-size: clamp(1.5rem, 3vw, 2.25rem); }

        p {
            margin-bottom: 1.5rem;
        }

        a {
            color: inherit;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        /* Primary pill button */
        .ts-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: var(--ts-font-label);
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #fff;
            background: var(--ts-dark);
            padding: 14px 32px;
            border-radius: var(--ts-radius-pill);
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .ts-btn-primary:hover {
            background: #111;
            transform: translateY(-2px);
        }

        /* Gold hero button */
        .ts-btn-gold {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: var(--ts-font-label);
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--ts-dark);
            background: var(--ts-gold);
            padding: 14px 32px;
            border-radius: var(--ts-radius-pill);
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .ts-btn-gold:hover {
            background: #b8983f;
            transform: translateY(-2px);
        }

        /* Ghost button */
        .ts-btn-ghost {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-family: var(--ts-font-label);
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #fff;
            background: transparent;
            padding: 14px 0;
            border: none;
            border-bottom: 1px solid rgba(255,255,255,0.4);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .ts-btn-ghost:hover {
            border-bottom-color: #fff;
        }

        /* Label / eyebrow text */
        .ts-label {
            font-family: var(--ts-font-label);
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.25em;
            text-transform: uppercase;
            color: var(--ts-primary);
        }

        /* Section wrapper defaults */
        .ts-section {
            position: relative;
            padding: var(--ts-space-xl) var(--ts-space-md);
        }

        .ts-container {
            width: 100%;
            max-width: var(--ts-max-width);
            margin: 0 auto;
            padding: 0 var(--ts-space-md);
        }

        /* WhatsApp float button */
        .ts-whatsapp-float {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9998;
            width: 56px;
            height: 56px;
            background: #25D366;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }

        .ts-whatsapp-float:hover {
            transform: scale(1.1);
        }

        /* Glassmorphism nav island */
        .ts-nav-island {
            background: rgba(247, 244, 239, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: var(--ts-radius-pill);
            box-shadow: 0 8px 32px rgba(31, 41, 38, 0.08);
        }

        /* Top bar */
        .ts-topbar {
            background: var(--ts-gold);
            color: var(--ts-dark);
            font-family: var(--ts-font-ui);
            font-size: 0.68rem;
            letter-spacing: 0.06em;
        }

        /* Lazy image fade-in */
        .ts-img-lazy {
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .ts-img-lazy.loaded {
            opacity: 1;
        }
    </style>
    <?php
}, 1 );

/**
 * Force <title> tag output. Oxygen sometimes suppresses the default
 * title-tag rendering, so we emit it explicitly at priority 0 and
 * remove WordPress' default renderer to avoid duplicates.
 */
add_action( 'wp_head', function() {
    remove_action( 'wp_head', '_wp_render_title_tag', 1 );
    echo '<title>' . esc_html( wp_get_document_title() ) . '</title>' . "\n";
}, 0 );

/**
 * Header shortcode: TopBar + Navbar.
 */
add_shortcode( 'ts_header', function() {
    $logo_url    = plugin_dir_url( __FILE__ ) . 'assets/logo.png';
    $phone       = ts_get_site_field( 'ts_phone', '+255-621220912' );
    $phone_digits = preg_replace( '/\D/', '', $phone );
    $email       = ts_get_site_field( 'ts_email', 'info@tanzaniasensational.co.tz' );
    $cta_label   = ts_get_site_field( 'ts_header_cta_label', 'Book Now' );
    $cta_url     = ts_get_site_field( 'ts_header_cta_url', '/booking' );
    ob_start();
    ?>
    <div class="topbar">
        <div class="topbar-left">
            <div class="gtranslate_wrapper"></div>
            <a href="tel:<?php echo esc_attr( $phone_digits ); ?>" class="topbar-item phone-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
                </svg>
                <?php echo esc_html( $phone ); ?>
            </a>
            <span class="topbar-divider">|</span>
            <a href="mailto:<?php echo esc_attr( $email ); ?>" class="topbar-item email-item">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                    <polyline points="22,6 12,13 2,6" />
                </svg>
                <?php echo esc_html( $email ); ?>
            </a>
        </div>
        <div class="topbar-right">
            <a href="<?php echo esc_url( $cta_url ); ?>" class="topbar-cta"><?php echo esc_html( $cta_label ); ?></a>
        </div>
    </div>

    <nav id="navbar">
        <div class="nav-island-inner">
            <a href="/" class="nav-logo">
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="Tanzania Sensational" />
            </a>

            <ul class="nav-links">
                <li class="dropdown mega-dropdown">
                    <a href="/safaris" class="dropdown-toggle">
                        Safaris
                        <svg viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                    </a>
                    <div class="mega-menu">
                        <div class="mega-menu-inner" style="grid-template-columns: 1fr 1fr 1fr;">
                            <div class="mega-col">
                                <h3 class="mega-heading">Destinations</h3>
                                <ul class="mega-sub-links">
                                    <li><a href="/safaris/tanzania">Tanzania Safaris</a></li>
                                    <li><a href="/safaris/kenya">Kenya Safaris</a></li>
                                    <li><a href="/safaris/uganda">Uganda Safaris</a></li>
                                    <li><a href="/safaris/rwanda">Rwanda Safaris</a></li>
                                </ul>
                            </div>
                            <div class="mega-col">
                                <h3 class="mega-heading">Packages</h3>
                                <ul class="mega-sub-links">
                                    <li><a href="/safaris">Safari Overview</a></li>
                                    <li><a href="/safaris/packages">Featured Packages</a></li>
                                    <li><a href="/safaris/group-joining">Group Joining</a></li>
                                </ul>
                            </div>
                            <div class="mega-col">
                                <h3 class="mega-heading">Safari Guide</h3>
                                <ul class="mega-sub-links">
                                    <li><a href="/safaris/guide">Safari Guide Overview</a></li>
                                    <li><a href="/safari-guide/what-to-wear">What to Wear</a></li>
                                    <li><a href="/safari-guide/packing-guide">Packing List</a></li>
                                    <li><a href="/safari-guide/health-and-safety">Health & Safety</a></li>
                                    <li><a href="/safari-guide/local-custom">Safari Etiquette</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li class="dropdown mega-dropdown">
                    <a href="/trekking/kilimanjaro" class="dropdown-toggle">
                        Trekking
                        <svg viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg>
                    </a>
                    <div class="mega-menu">
                        <div class="mega-menu-inner">
                            <div class="mega-col">
                                <h3 class="mega-heading">Destinations</h3>
                                <div class="mega-links-group">
                                    <h4 class="mega-subheading">Kilimanjaro</h4>
                                    <ul class="mega-sub-links">
                                        <li><a href="/trekking/kilimanjaro/lemosho">Lemosho Route</a></li>
                                        <li><a href="/trekking/kilimanjaro/machame">Machame Route</a></li>
                                        <li><a href="/trekking/kilimanjaro/marangu">Marangu Route</a></li>
                                        <li><a href="/trekking/kilimanjaro/rongai">Rongai Route</a></li>
                                        <li><a href="/trekking/kilimanjaro/northern-circuit">Northern Circuit</a></li>
                                        <li><a href="/trekking/kilimanjaro/umbwe">Umbwe Route</a></li>
                                    </ul>
                                </div>
                                <div class="mega-links-group" style="margin-top:25px;">
                                    <h4 class="mega-subheading">Mount Meru</h4>
                                    <ul class="mega-sub-links">
                                        <li><a href="/trekking/meru/mt-meru-4-days">Mount Meru Trek (4 Days)</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="mega-col">
                                <h3 class="mega-heading">Preparation</h3>
                                <ul class="mega-sub-links">
                                    <li><a href="/trekking/prep/best-time">Best Time to Climb</a></li>
                                    <li><a href="/trekking/prep/best-routes">Best Routes</a></li>
                                    <li><a href="/trekking/prep/why-us">Why Choose us</a></li>
                                    <li><a href="/trekking/prep/tipping-guide">Tipping Guide</a></li>
                                    <li><a href="/trekking/prep/park-fees">Park Fees</a></li>
                                    <li><a href="/trekking/prep/toilets">Toilets on Kili</a></li>
                                </ul>
                            </div>
                            <div class="mega-col">
                                <h3 class="mega-heading">Health & Safety</h3>
                                <ul class="mega-sub-links">
                                    <li><a href="/trekking/health/vaccinations">Vaccinations</a></li>
                                    <li><a href="/trekking/health/altitude-sickness">Altitude Sickness</a></li>
                                    <li><a href="/trekking/health/diamox">Diamox</a></li>
                                    <li><a href="/trekking/health/oxygen">Oxygen & Safety</a></li>
                                </ul>
                            </div>
                            <div class="mega-col">
                                <h3 class="mega-heading">During the Trek</h3>
                                <ul class="mega-sub-links">
                                    <li><a href="/trekking/during/daily-routine">Daily Routine</a></li>
                                    <li><a href="/trekking/during/food-and-drinks">Food & Drinks</a></li>
                                    <li><a href="/trekking/during/pack-your-daypack">Daypack Essentials</a></li>
                                    <li><a href="/trekking/during/connectivity">Connectivity</a></li>
                                </ul>
                            </div>
                            <div class="mega-col">
                                <h3 class="mega-heading">Before You Go</h3>
                                <ul class="mega-sub-links">
                                    <li><a href="/trekking/after/training">Training Guide</a></li>
                                    <li><a href="/trekking/after/gear-list">Gear List</a></li>
                                    <li><a href="/trekking/after/getting-there">Getting There</a></li>
                                    <li><a href="/trekking/after/visa">Visa Info</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>

                <li><a href="/zanzibar">Zanzibar</a></li>
                <li><a href="/group-departures">Departures</a></li>
                <li><a href="/about-us">About Us</a></li>
                <li><a href="/contact">Contact</a></li>
            </ul>

            <a href="/contact" class="nav-cta">Plan Your Journey</a>
            <button class="mobile-hamburger" aria-label="Toggle navigation"><span></span><span></span><span></span></button>
        </div>
    </nav>
    <?php
    return ob_get_clean();
} );

/**
 * Footer shortcode.
 */
add_shortcode( 'ts_footer', function() {
    $logo_url      = plugin_dir_url( __FILE__ ) . 'assets/logo.png';
    $phone         = ts_get_site_field( 'ts_phone', '+255-621220912' );
    $phone_digits  = preg_replace( '/\D/', '', $phone );
    $email         = ts_get_site_field( 'ts_email', 'info@tanzaniasensational.co.tz' );
    $address       = ts_get_site_field( 'ts_address', 'Moshi, Kilimanjaro Region' );
    $tagline       = ts_get_site_field( 'ts_footer_tagline', "East Africa's premier safari outfitter. Guiding adventurers across the Serengeti, Ngorongoro, and Kilimanjaro since 2009." );
    $nl_eyebrow    = ts_get_site_field( 'ts_footer_newsletter_eyebrow', 'Stay Connected' );
    $nl_title      = ts_get_site_field( 'ts_footer_newsletter_title', 'Stories from <em>the wild</em>' );
    $nl_subtitle   = ts_get_site_field( 'ts_footer_newsletter_subtitle', 'Safari dispatches, wildlife stories & exclusive departure alerts, delivered to your inbox.' );
    $copyright     = ts_get_site_field( 'ts_footer_copyright', '&copy; ' . date( 'Y' ) . ' Tanzania Sensational' );
    $crafted       = ts_get_site_field( 'ts_footer_crafted', 'Crafted with purpose in Tanzania' );

    $social = [
        'instagram' => ts_get_site_field( 'ts_social_instagram', '' ),
        'facebook'  => ts_get_site_field( 'ts_social_facebook', '' ),
        'linkedin'  => ts_get_site_field( 'ts_social_linkedin', '' ),
        'twitter'   => ts_get_site_field( 'ts_social_twitter', '' ),
        'youtube'   => ts_get_site_field( 'ts_social_youtube', '' ),
    ];

    ob_start();
    ?>
    <div class="footer-organic">
        <div class="footer-grain"></div>
        <div class="footer-watermark" aria-hidden="true">Karibu</div>
        <svg class="footer-topo" viewBox="0 0 1440 600" preserveAspectRatio="none" aria-hidden="true">
            <path d="M-20,200 Q200,120 400,200 T800,180 T1200,220 T1460,180" fill="none" stroke="rgba(140,109,82,0.06)" stroke-width="1.5" />
            <path d="M-20,260 Q240,180 480,260 T880,240 T1240,280 T1460,240" fill="none" stroke="rgba(140,109,82,0.05)" stroke-width="1.2" />
            <path d="M-20,320 Q180,260 420,320 T840,300 T1280,340 T1460,310" fill="none" stroke="rgba(140,109,82,0.04)" stroke-width="1" />
            <path d="M-20,400 Q260,340 500,400 T900,380 T1300,420 T1460,390" fill="none" stroke="rgba(140,109,82,0.035)" stroke-width="0.8" />
            <path d="M-20,480 Q220,420 460,480 T860,460 T1260,500 T1460,470" fill="none" stroke="rgba(140,109,82,0.03)" stroke-width="0.6" />
        </svg>

        <div class="footer-wave-divider">
            <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,48 C180,80 360,16 540,48 C720,80 900,16 1080,48 C1260,80 1350,32 1440,48 L1440,80 L0,80 Z" fill="var(--footer-bg)" />
            </svg>
        </div>

        <div class="footer-inner">
            <div class="footer-cta-strip">
                <div class="footer-cta-content">
                    <span class="footer-cta-eyebrow"><?php echo esc_html( $nl_eyebrow ); ?></span>
                    <h3 class="footer-cta-title"><?php echo wp_kses_post( $nl_title ); ?></h3>
                    <p class="footer-cta-sub"><?php echo esc_html( $nl_subtitle ); ?></p>
                </div>
                <form class="footer-cta-form" action="/contact" method="get">
                    <div class="footer-input-wrap">
                        <input type="email" name="email" placeholder="your@email.com" class="footer-email-input" required />
                        <button type="submit" class="footer-submit-btn" aria-label="Subscribe">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        </button>
                    </div>
                </form>
            </div>

            <div class="footer-upper">
                <div class="footer-brand-col">
                    <div class="footer-logo-wrap">
                        <img src="<?php echo esc_url( $logo_url ); ?>" alt="Tanzania Sensational" loading="lazy" />
                    </div>
                    <p class="footer-tagline"><?php echo esc_html( $tagline ); ?></p>

                    <div class="footer-contact-stack">
                        <a href="mailto:<?php echo esc_attr( $email ); ?>" class="footer-contact-link">
                            <span class="footer-contact-icon">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2 4.5l6 4.5 6-4.5M2 3.5h12a1.5 1.5 0 011.5 1.5v7a1.5 1.5 0 01-1.5 1.5H2A1.5 1.5 0 01.5 12V5A1.5 1.5 0 012 3.5z" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" /></svg>
                            </span>
                            <?php echo esc_html( $email ); ?>
                        </a>
                        <a href="tel:<?php echo esc_attr( $phone_digits ); ?>" class="footer-contact-link">
                            <span class="footer-contact-icon">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2.5 2.5c0-.3.2-.5.5-.5h2.6c.2 0 .4.2.5.4l1 2.5c.1.2 0 .4-.1.6L6 7c.8 1.5 2.4 3.1 4 4l1-1c.2-.1.4-.2.6-.1l2.5 1c.2.1.4.3.4.5v2.6c0 .3-.2.5-.5.5C5.5 14 1 9.5 1 4c0-.3 0-.5.5-.5z" stroke="currentColor" stroke-width="1.2" /></svg>
                            </span>
                            <?php echo esc_html( $phone ); ?>
                        </a>
                    </div>

                    <div class="footer-location-badge">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <span><?php echo esc_html( $address ); ?></span>
                    </div>
                </div>

                <div class="footer-nav-columns">
                    <div class="footer-nav-col">
                        <div class="footer-nav-label"><span class="footer-label-line"></span>Safaris & Destinations</div>
                        <ul class="footer-links">
                            <li><a href="/safaris">All Safaris</a></li>
                            <li><a href="/safaris/guide">Safari Guide</a></li>
                            <li><a href="/safaris/packages">Featured Packages</a></li>
                            <li><a href="/safaris/destinations/serengeti">Serengeti</a></li>
                            <li><a href="/safaris/destinations/ngorongoro-crater">Ngorongoro Crater</a></li>
                            <li><a href="/safaris/destinations/tarangire">Tarangire</a></li>
                            <li><a href="/zanzibar">Zanzibar</a></li>
                        </ul>
                    </div>

                    <div class="footer-nav-col">
                        <div class="footer-nav-label"><span class="footer-label-line"></span>Kilimanjaro</div>
                        <ul class="footer-links">
                            <li><a href="/trekking/kilimanjaro">Overview & Routes</a></li>
                            <li><a href="/trekking/kilimanjaro/lemosho">Lemosho Route</a></li>
                            <li><a href="/trekking/kilimanjaro/machame">Machame Route</a></li>
                            <li><a href="/trekking/kilimanjaro/northern-circuit">Northern Circuit</a></li>
                            <li><a href="/trekking/kilimanjaro/marangu">Marangu Route</a></li>
                            <li><a href="/trekking/kilimanjaro/rongai">Rongai Route</a></li>
                            <li><a href="/trekking/kilimanjaro/umbwe">Umbwe Route</a></li>
                        </ul>
                    </div>

                    <div class="footer-nav-col">
                        <div class="footer-nav-label"><span class="footer-label-line"></span>Company</div>
                        <ul class="footer-links">
                            <li><a href="/about-us">About Us</a></li>
                            <li><a href="/company/our-guides">Our Guides</a></li>
                            <li><a href="/company/safety-protocols">Safety Protocols</a></li>
                            <li><a href="/blog">Adventurer's Blog</a></li>
                            <li><a href="/contact">Contact</a></li>
                            <li><a href="/group-departures">Group Departures</a></li>
                            <li><a href="/faq">FAQ</a></li>
                        </ul>

                        <?php if ( array_filter( $social ) ) : ?>
                        <div class="footer-social-group">
                            <span class="footer-social-label">Follow Along</span>
                            <div class="footer-socials">
                                <?php if ( $social['instagram'] ) : ?>
                                <a href="<?php echo esc_url( $social['instagram'] ); ?>" target="_blank" rel="noreferrer" class="social-link" aria-label="Instagram"><svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
                                <?php endif; ?>
                                <?php if ( $social['facebook'] ) : ?>
                                <a href="<?php echo esc_url( $social['facebook'] ); ?>" target="_blank" rel="noreferrer" class="social-link" aria-label="Facebook"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
                                <?php endif; ?>
                                <?php if ( $social['linkedin'] ) : ?>
                                <a href="<?php echo esc_url( $social['linkedin'] ); ?>" target="_blank" rel="noreferrer" class="social-link" aria-label="LinkedIn"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg></a>
                                <?php endif; ?>
                                <?php if ( $social['twitter'] ) : ?>
                                <a href="<?php echo esc_url( $social['twitter'] ); ?>" target="_blank" rel="noreferrer" class="social-link" aria-label="Twitter / X"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                                <?php endif; ?>
                                <?php if ( $social['youtube'] ) : ?>
                                <a href="<?php echo esc_url( $social['youtube'] ); ?>" target="_blank" rel="noreferrer" class="social-link" aria-label="YouTube"><svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M23.5 6.19a3.02 3.02 0 0 0-2.12-2.14C19.5 3.55 12 3.55 12 3.55s-7.5 0-9.38.5A3.02 3.02 0 0 0 .5 6.19 31.5 31.5 0 0 0 0 12a31.5 31.5 0 0 0 .5 5.81 3.02 3.02 0 0 0 2.12 2.14c1.88.5 9.38.5 9.38.5s7.5 0 9.38-.5a3.02 3.02 0 0 0 2.12-2.14A31.5 31.5 0 0 0 24 12a31.5 31.5 0 0 0-.5-5.81zM9.55 15.5V8.5l6.27 3.5-6.27 3.5z"/></svg></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="footer-lower">
                <div class="footer-lower-left">
                    <span class="footer-copy"><?php echo wp_kses_post( $copyright ); ?></span>
                    <span class="footer-dot">·</span>
                    <span class="footer-copy">All rights reserved</span>
                </div>
                <div class="footer-lower-right">
                    <span class="footer-craft"><?php echo esc_html( $crafted ); ?></span>
                </div>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
} );

/**
 * 404 page content shortcode.
 */
add_shortcode( 'ts_404', function() {
    ob_start();
    ?>
    <section style="min-height:70vh; display:flex; align-items:center; justify-content:center; text-align:center; padding:var(--ts-space-xl) var(--ts-space-md);">
        <div class="ts-container">
            <span class="ts-label" style="display:block; margin-bottom:var(--ts-space-sm);">Page Not Found</span>
            <h1 style="margin-bottom:var(--ts-space-md);">Lost in the Wilderness</h1>
            <p style="max-width:600px; margin:0 auto var(--ts-space-md); color:var(--ts-text-muted);">The page you're looking for seems to have wandered off the trail. Let us guide you back.</p>
            <a href="/" class="ts-btn-primary">Return Home</a>
        </div>
    </section>
    <?php
    return ob_get_clean();
} );

/**
 * Page content shortcode.
 * Outputs the current post content. Used inside the Oxygen Main template
 * so WordPress page content (including our section shortcodes) is rendered.
 */
add_shortcode( 'ts_page_content', function() {
    $queried = get_queried_object();
    if ( $queried && isset( $queried->post_content ) ) {
        return apply_filters( 'the_content', $queried->post_content );
    }
    global $post;
    if ( $post ) {
        return apply_filters( 'the_content', $post->post_content );
    }
    ob_start();
    the_content();
    return ob_get_clean();
} );

/**
 * Static page content shortcode.
 * Renders the current page's post_content; if empty, falls back to the
 * legacy [ts_{slug}_page] shortcode so pages never render blank.
 */
add_shortcode( 'ts_static_page_content', function() {
    $post = get_queried_object();
    if ( ! $post || ! isset( $post->post_content ) ) {
        global $post;
    }
    if ( ! $post || ! isset( $post->post_content ) ) {
        return '';
    }

    $content = trim( $post->post_content );
    if ( $content ) {
        return apply_filters( 'the_content', $content );
    }

    $slug = $post->post_name;
    $map  = [
        'about-us'            => 'ts_about_page',
        'contact'             => 'ts_contact_page',
        'zanzibar'            => 'ts_zanzibar_page',
        'faq'                 => 'ts_faq_page',
        'safari-guide'        => 'ts_safari_guide_page',
        'kilimanjaro-pillar'  => 'ts_kilimanjaro_pillar_page',
        'gear-checklist'      => 'ts_gear_checklist_page',
        'training-guide'      => 'ts_training_guide_page',
        'safari-addons'       => 'ts_safari_addons_page',
    ];

    if ( isset( $map[ $slug ] ) && shortcode_exists( $map[ $slug ] ) ) {
        return do_shortcode( '[' . $map[ $slug ] . ']' );
    }

    return '';
} );

/**
 * WhatsApp floating button shortcode.
 */
add_shortcode( 'ts_whatsapp', function() {
    $phone = '+255743262822';
    $digits = preg_replace( '/\D/', '', $phone );
    $link  = 'https://wa.me/' . $digits;
    return '<a href="' . esc_url( $link ) . '" target="_blank" rel="noopener noreferrer" class="ts-whatsapp-float" aria-label="Chat on WhatsApp">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M19.077 4.928C17.191 3.041 14.683 2 12.006 2 6.798 2 2.548 6.25 2.548 11.458c0 1.999.521 3.958 1.511 5.682L2 22l5.042-1.323c1.656.904 3.52 1.38 5.422 1.38h.005c5.207 0 9.457-4.25 9.457-9.458 0-2.676-1.041-5.184-2.928-7.071zM12.006 20.276c-1.694 0-3.357-.455-4.8-1.313l-.344-.204-2.992.785.8-2.918-.224-.357a8.06 8.06 0 01-1.29-4.311c0-4.463 3.631-8.094 8.094-8.094 2.161 0 4.193.842 5.722 2.371a8.06 8.06 0 012.371 5.722c0 4.463-3.631 8.094-8.094 8.094z"/></svg>
    </a>';
} );
