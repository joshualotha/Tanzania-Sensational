<?php
/**
 * Homepage sections shortcode.
 */

add_shortcode( 'ts_homepage', function( $atts ) {
    $atts = shortcode_atts( [ 'skip' => '' ], $atts, 'ts_homepage' );
    $skip = array_map( 'trim', explode( ',', strtolower( $atts['skip'] ) ) );
    $home = [
        'hero' => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?ixlib=rb-1.2.1&auto=format&fit=crop&w=2400&q=90',
        'experienceMain' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?w=800&q=85&auto=format&fit=crop',
        'experienceSecondary' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=600&q=85&auto=format&fit=crop',
        'extensionKilimanjaro' => 'https://images.unsplash.com/photo-1522814300958-f584e27fdf00?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80',
        'extensionZanzibar' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80',
        'testimonial1' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80&auto=format&fit=crop',
        'testimonial2' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?q=80&w=800&auto=format&fit=crop',
        'testimonial3' => 'https://images.unsplash.com/photo-1549366021-9f761d450615?q=80&w=800&auto=format&fit=crop',
        'ctaBg' => 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?q=80&w=2000&auto=format&fit=crop',
    ];

    $packages = ts_get_tours( [
        'posts_per_page' => 6,
        'meta_query'     => [
            [
                'key'   => 'ts_tour_featured',
                'value' => '1',
            ],
        ],
    ] );

    if ( empty( $packages ) ) {
        $packages = ts_get_tours( [ 'posts_per_page' => 6 ] );
    }

    $destinations = ts_get_destinations( [
        'posts_per_page' => 4,
        'meta_query'     => [
            [
                'key'   => 'ts_dest_featured',
                'value' => '1',
            ],
        ],
    ] );

    if ( empty( $destinations ) ) {
        $destinations = ts_get_destinations( [ 'posts_per_page' => 4 ] );
    }

    $departures = [
        ['route_name' => 'Lemosho Route', 'slug' => 'lemosho', 'date' => 'Oct 15', 'seats' => 5, 'price' => 2890],
        ['route_name' => 'Machame Route', 'slug' => 'machame', 'date' => 'Oct 22', 'seats' => 3, 'price' => 2450],
        ['route_name' => 'Northern Circuit', 'slug' => 'northern-circuit', 'date' => 'Nov 5', 'seats' => 6, 'price' => 3200],
        ['route_name' => 'Rongai Route', 'slug' => 'rongai', 'date' => 'Nov 12', 'seats' => 2, 'price' => 2600],
    ];

    ob_start();
    ?>

    <?php if ( ! in_array( 'hero', $skip ) ) : ?>
    <!-- HERO -->
    <section class="hero-v2">
        <div class="hero-v2-bg">
            <img src="<?php echo esc_url( $home['hero'] ); ?>" alt="Tanzania safari experience" class="hero-v2-bg-img" fetchpriority="high" loading="eager" />
        </div>
        <div class="hero-v2-overlay"></div>
        <div class="hero-v2-vignette"></div>
        <div class="hero-v2-content">
            <h1 class="hero-v2-title">Into the Wild.<br /><em>Beyond the Ordinary.</em></h1>
            <p class="hero-v2-subtitle">East Africa's premier safari outfitter. From the Serengeti to the Crater, every expedition is a story worth telling.</p>
            <div class="hero-v2-actions">
                <a href="/safaris" class="hero-v2-btn-primary"><span>Explore Safaris</span><svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg></a>
                <a href="/trekking/kilimanjaro" class="hero-v2-btn-ghost">Climb Kilimanjaro</a>
            </div>
        </div>
        <div class="hero-v2-scroll"><div class="hero-v2-scroll-line"></div><span>Scroll</span></div>
    </section>
    <?php endif; ?>

    <?php if ( ! in_array( 'stats', $skip ) ) : ?>
    <!-- STATS -->
    <div class="stats">
        <?php foreach ( [['num' => '98%', 'label' => 'Guest Satisfaction'], ['num' => '15+', 'label' => 'Years of Expertise'], ['num' => '1,500+', 'label' => 'Safaris Operated'], ['num' => '24/7', 'label' => 'In-Country Support']] as $stat ) : ?>
        <div class="stat-item">
            <div class="stat-num"><?php echo esc_html( $stat['num'] ); ?></div>
            <div class="stat-label"><?php echo esc_html( $stat['label'] ); ?></div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ( ! in_array( 'packages', $skip, true ) ) : ?>
    <!-- SAFARI PACKAGES -->
    <section class="safari-home">
        <div class="safari-home-inner">
            <div class="safari-home-header">
                <div>
                    <span class="safari-home-eyebrow">Curated Expeditions</span>
                    <h2 class="safari-home-title">Safari <em>Packages</em></h2>
                    <p class="safari-home-sub">From intimate 3-day getaways to comprehensive 14-day expeditions — each safari is designed to immerse you in the raw beauty of East Africa's wildlife.</p>
                </div>
                <a href="/safaris/packages" class="safari-home-viewall">View All Packages <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
            </div>
            <div class="safari-home-grid">
                <?php foreach ( $packages as $pkg ) :
                    $pkg_duration   = ts_get_field( 'ts_tour_duration', $pkg->ID ) ?: '';
                    $pkg_parks      = ts_get_field( 'ts_tour_parks', $pkg->ID ) ?: 'Tanzania';
                    $pkg_price      = ts_get_field( 'ts_tour_price', $pkg->ID ) ?: '';
                    $pkg_price_note = ts_get_field( 'ts_tour_price_note', $pkg->ID ) ?: __( 'per person', 'tanzania-sensational' );
                    $pkg_badge      = ts_get_field( 'ts_tour_badge', $pkg->ID ) ?: '';
                    $pkg_overview   = ts_get_field( 'ts_tour_overview', $pkg->ID );
                    $pkg_desc       = $pkg_overview ? wp_trim_words( strip_tags( $pkg_overview ), 18 ) : '';
                    $pkg_hero       = ts_get_field( 'ts_tour_hero_image', $pkg->ID );
                    $pkg_hero_url   = is_array( $pkg_hero ) ? ( $pkg_hero['url'] ?? '' ) : ( is_numeric( $pkg_hero ) ? wp_get_attachment_url( $pkg_hero ) : $pkg_hero );
                    $pkg_hero_url   = $pkg_hero_url ?: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=800&auto=format&fit=crop';
                    $pkg_duration_num = (int) preg_replace( '/\D/', '', $pkg_duration );
                ?>
                <a href="<?php echo esc_url( get_permalink( $pkg->ID ) ); ?>" class="safari-home-card">
                    <div class="safari-home-card-img">
                        <img src="<?php echo esc_url( $pkg_hero_url ); ?>" alt="<?php echo esc_attr( get_the_title( $pkg->ID ) ); ?>" loading="lazy" />
                        <div class="safari-home-card-overlay"></div>
                        <?php if ( $pkg_badge ) : ?><span class="safari-home-card-badge"><?php echo esc_html( $pkg_badge ); ?></span><?php endif; ?>
                    </div>
                    <div class="safari-home-card-body">
                        <div class="safari-home-card-meta">
                            <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> <?php echo intval( $pkg_duration_num ); ?> Days</span>
                            <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> <?php echo esc_html( $pkg_parks ); ?></span>
                        </div>
                        <h3 class="safari-home-card-title"><?php echo esc_html( get_the_title( $pkg->ID ) ); ?></h3>
                        <p class="safari-home-card-desc"><?php echo esc_html( $pkg_desc ); ?></p>
                        <?php if ( $pkg_price ) : ?>
                            <div class="safari-home-card-price"><?php echo esc_html( $pkg_price ); ?> <span><?php echo esc_html( $pkg_price_note ); ?></span></div>
                        <?php endif; ?>
                        <div class="safari-home-card-cta">Explore Safari <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></div>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php if ( ! in_array( 'destinations', $skip, true ) ) : ?>
    <!-- DESTINATIONS -->
    <section class="dest-home">
        <div class="dest-home-inner">
            <div class="dest-home-header">
                <div>
                    <span class="dest-home-eyebrow">Explore the Wild</span>
                    <h2 class="dest-home-title">Safari <em>Destinations</em></h2>
                </div>
                <a href="/safaris/destinations" class="dest-home-viewall">All Destinations <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
            </div>
            <div class="dest-home-layout">
                <?php $featured = array_shift( $destinations );
                if ( $featured ) :
                    $feat_tag     = ts_get_field( 'ts_dest_tag', $featured->ID ) ?: '';
                    $feat_sub     = ts_get_field( 'ts_dest_subtitle', $featured->ID ) ?: '';
                    $feat_hero    = ts_get_field( 'ts_dest_hero_image', $featured->ID );
                    $feat_hero_url = is_array( $feat_hero ) ? ( $feat_hero['url'] ?? '' ) : ( is_numeric( $feat_hero ) ? wp_get_attachment_url( $feat_hero ) : $feat_hero );
                    $feat_hero_url = $feat_hero_url ?: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=1200&auto=format&fit=crop';
                ?>
                <div class="dest-home-featured">
                    <a href="<?php echo esc_url( get_permalink( $featured->ID ) ); ?>" class="dest-home-card dest-home-card-lg">
                        <div class="dest-home-card-img"><img src="<?php echo esc_url( $feat_hero_url ); ?>" alt="<?php echo esc_attr( get_the_title( $featured->ID ) ); ?>" loading="lazy" /><div class="dest-home-card-gradient"></div></div>
                        <div class="dest-home-card-content">
                            <span class="dest-home-card-region"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> <?php echo esc_html( $feat_tag ); ?></span>
                            <h3 class="dest-home-card-name"><?php echo esc_html( get_the_title( $featured->ID ) ); ?></h3>
                            <p class="dest-home-card-tagline"><?php echo esc_html( $feat_sub ); ?></p>
                            <span class="dest-home-card-link">Explore <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
                        </div>
                    </a>
                </div>
                <?php endif; ?>
                <div class="dest-home-small-grid">
                    <?php foreach ( $destinations as $dest ) :
                        $dest_tag     = ts_get_field( 'ts_dest_tag', $dest->ID ) ?: '';
                        $dest_sub     = ts_get_field( 'ts_dest_subtitle', $dest->ID ) ?: '';
                        $dest_hero    = ts_get_field( 'ts_dest_hero_image', $dest->ID );
                        $dest_hero_url = is_array( $dest_hero ) ? ( $dest_hero['url'] ?? '' ) : ( is_numeric( $dest_hero ) ? wp_get_attachment_url( $dest_hero ) : $dest_hero );
                        $dest_hero_url = $dest_hero_url ?: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=800&auto=format&fit=crop';
                    ?>
                    <a href="<?php echo esc_url( get_permalink( $dest->ID ) ); ?>" class="dest-home-card dest-home-card-sm">
                        <div class="dest-home-card-img"><img src="<?php echo esc_url( $dest_hero_url ); ?>" alt="<?php echo esc_attr( get_the_title( $dest->ID ) ); ?>" loading="lazy" /><div class="dest-home-card-gradient"></div></div>
                        <div class="dest-home-card-content">
                            <span class="dest-home-card-region"><svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> <?php echo esc_html( $dest_tag ); ?></span>
                            <h3 class="dest-home-card-name"><?php echo esc_html( get_the_title( $dest->ID ) ); ?></h3>
                            <p class="dest-home-card-tagline"><?php echo esc_html( $dest_sub ); ?></p>
                            <span class="dest-home-card-link">Explore <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <?php endif; ?>

    <?php if ( ! in_array( 'experience', $skip, true ) ) : ?>
    <!-- EXPERIENCE -->
    <section class="experience">
        <div class="experience-visual">
            <div class="exp-img-main" style="background-image:url('<?php echo esc_url( $home['experienceMain'] ); ?>')"></div>
            <div class="exp-img-secondary" style="background-image:url('<?php echo esc_url( $home['experienceSecondary'] ); ?>')"></div>
            <div class="exp-badge-float shadow-premium">
                <div class="exp-badge-num">15+</div>
                <div class="exp-badge-text">Years guiding<br />across Africa</div>
            </div>
        </div>
        <div class="experience-content">
            <div class="section-eyebrow"><div class="section-eyebrow-line"></div><span class="section-eyebrow-text">The Difference</span></div>
            <h2 class="section-title">Wild. <em>Authentic.</em><br />Unforgettable.</h2>
            <p class="experience-body">A true safari demands more than a vehicle and a checklist — it demands local knowledge, seasoned naturalists, and a team that's guided thousands of guests across the Serengeti, Ngorongoro, and beyond. That's us.</p>
            <div class="pillars">
                <div class="pillar"><span class="pillar-num">01</span><div><div class="pillar-title">Expert Naturalist Guides</div><p class="pillar-desc">Every guide is a certified naturalist with deep knowledge of East African ecosystems, wildlife behavior, and photography positioning.</p></div></div>
                <div class="pillar"><span class="pillar-num">02</span><div><div class="pillar-title">Handcrafted Itineraries</div><p class="pillar-desc">We design each route around seasonal wildlife movements, optimal light for photography, and secluded camps far from the crowds.</p></div></div>
                <div class="pillar"><span class="pillar-num">03</span><div><div class="pillar-title">Transparent Pricing & Flexibility</div><p class="pillar-desc">Solo traveler or a private party of 12, our pricing is clear and competitive. Join a group departure or charter a bespoke expedition.</p></div></div>
            </div>
        </div>
    </section>

    <?php endif; ?>

    <?php if ( ! in_array( 'departures', $skip, true ) ) : ?>
    <!-- DEPARTURES -->
    <section class="departures-v3">
        <div class="departures-inner-asymmetric">
            <div class="departures-content-side">
                <div class="section-eyebrow"><div class="section-eyebrow-line"></div><span class="section-eyebrow-text">Join a Team</span></div>
                <h2 class="section-title-light">Group<br /><em>Departures</em></h2>
                <p class="departures-desc-v3">Traveling solo? Split the cost. Share the adventure. Our group departures place solo travelers into small, curated teams of like-minded explorers.</p>
                <a href="/group-departures" class="btn-secondary-light">View All 2026 Dates</a>
            </div>
            <div class="departures-list-v3">
                <?php foreach ( $departures as $dep ) : ?>
                <a href="/trekking/kilimanjaro/<?php echo esc_attr( $dep['slug'] ); ?>" class="departure-card-v3">
                    <div class="dep-info-v3">
                        <span class="dep-route-v3"><?php echo esc_html( $dep['route_name'] ); ?> Route</span>
                        <span class="dep-date-v3"><?php echo esc_html( $dep['date'] ); ?></span>
                    </div>
                    <div class="dep-meta-v3">
                        <span class="dep-seats-pill-v3 <?php echo $dep['seats'] <= 3 ? 'low' : ''; ?>"><?php echo intval( $dep['seats'] ); ?> spots left</span>
                        <span class="dep-price-v3">From $<?php echo number_format( $dep['price'] ); ?></span>
                    </div>
                    <div class="dep-arrow-v3"><svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" /></svg></div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php endif; ?>

    <?php if ( ! in_array( 'testimonials', $skip, true ) ) : ?>
    <!-- TESTIMONIALS -->
    <section class="testimonials-v3">
        <div class="testimonials-header-v3">
            <div class="section-eyebrow"><div class="section-eyebrow-line"></div><span class="section-eyebrow-text">The Human Connection</span></div>
            <h2 class="section-title-v3">From the <em>Summit Diary</em></h2>
        </div>
        <div class="testi-grid-v3">
            <?php
            $testimonials = [
                ['text' => 'The guides were extraordinary, they knew exactly when to push and when to rest. Reaching Uhuru Peak at sunrise was the most profound moment of my life.', 'author' => 'James Hartwell', 'origin' => 'London, United Kingdom', 'img' => $home['testimonial1']],
                ['text' => 'I joined a group departure as a solo traveler and couldn\'t have been more impressed. The safety protocols, the food, the team\'s energy, truly world-class.', 'author' => 'Sarah Chen', 'origin' => 'San Francisco, USA', 'img' => $home['testimonial2']],
                ['text' => '8 Tage Lemosho Route, absolut unvergesslich. Professionell, sicher, und die persönliche Betreuung war unübertroffen. Nächstes Ziel: Mt. Meru.', 'author' => 'Klaus Müller', 'origin' => 'Munich, Germany', 'img' => $home['testimonial3']],
            ];
            foreach ( $testimonials as $t ) :
            ?>
            <div class="testi-card-v3">
                <div class="testi-quote-mark">“</div>
                <p class="testi-text-v3"><?php echo esc_html( $t['text'] ); ?></p>
                <div class="testi-author-v3">
                    <div class="testi-avatar-v3" style="background-image:url('<?php echo esc_url( $t['img'] ); ?>')"></div>
                    <div class="testi-meta-v3">
                        <div class="testi-name-v3"><?php echo esc_html( $t['author'] ); ?></div>
                        <div class="testi-origin-v3"><?php echo esc_html( $t['origin'] ); ?></div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php endif; ?>

    <?php if ( ! in_array( 'extensions', $skip, true ) ) : ?>
    <!-- EXTENSIONS -->
    <section class="extensions" id="extensions">
        <div class="section-eyebrow reveal"><div class="section-eyebrow-line"></div><span class="section-eyebrow-text">Signature Experiences</span></div>
        <h2 class="section-title reveal">Discover Our<br /><em>African Odyssey</em></h2>
        <div class="extensions-grid">
            <div class="extension-card reveal">
                <div class="extension-img" style="background-image:url('<?php echo esc_url( $home['extensionKilimanjaro'] ); ?>')"></div>
                <div class="extension-overlay"></div>
                <div class="extension-content">
                    <h3 class="extension-name">Kilimanjaro Trekking</h3>
                    <p class="extension-desc">Stand on the roof of Africa. Seven distinct routes, expert-certified guides, and a summit success rate that leads the industry.</p>
                    <a href="/trekking/kilimanjaro" class="extension-link">Explore Trekking</a>
                </div>
            </div>
            <div class="extension-card reveal reveal-delay-2">
                <div class="extension-img" style="background-image:url('<?php echo esc_url( $home['extensionZanzibar'] ); ?>')"></div>
                <div class="extension-overlay"></div>
                <div class="extension-content">
                    <h3 class="extension-name">Zanzibar Escapes</h3>
                    <p class="extension-desc">Trade the mountain air for the Indian Ocean breeze. Pristine white sands, turquoise waters, and ancient Stone Town history.</p>
                    <a href="/zanzibar" class="extension-link">Island Extensions</a>
                </div>
            </div>
        </div>
    </section>

    <?php endif; ?>

    <?php if ( ! in_array( 'cta', $skip, true ) ) : ?>
    <!-- CTA -->
    <section class="cta-banner-v3">
        <div class="cta-bg-v3" style="background-image:url('<?php echo esc_url( $home['ctaBg'] ); ?>')"></div>
        <div class="cta-overlay-v3"></div>
        <div class="cta-content-v3">
            <h2 class="cta-title-v3">The Summit<br />is <em>Waiting For You</em></h2>
            <div class="cta-btns-v3">
                <a href="/contact" class="nav-cta" style="position:relative;">Plan My Journey</a>
                <a href="https://wa.me/255743262822" target="_blank" rel="noopener noreferrer" class="btn-secondary-light">WhatsApp Us</a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <?php
    return ob_get_clean();
} );
