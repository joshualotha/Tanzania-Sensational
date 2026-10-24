<?php
/**
 * Static page content shortcodes.
 */

add_shortcode( 'ts_about_page', function() {
    $hero = 'https://images.unsplash.com/photo-1621414050946-1b936a78490b?q=80&w=2000&auto=format&fit=crop';
    $legacy = 'https://images.unsplash.com/photo-1631646109206-4919df38eb68?q=80&w=800&auto=format&fit=crop';
    $band = 'https://images.unsplash.com/photo-1650668302197-7f556c34cb91?q=80&w=2000&auto=format&fit=crop';
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
} );

add_shortcode( 'ts_contact_page', function() {
    $hero = 'https://images.unsplash.com/photo-1547970810-dc1eac37d174?q=80&w=2000&auto=format&fit=crop';
    ob_start();
    ?>
    <div class="contact-premium-root">
        <section class="premium-hero">
            <div class="premium-hero-bg">
                <img src="<?php echo esc_url( $hero ); ?>" alt="Tanzania safari landscape at sunset" />
                <div class="premium-hero-overlay"></div>
            </div>
            <div class="container">
                <div class="premium-hero-content">
                    <span class="premium-hero-eyebrow">Basecamp Communications</span>
                    <h1 class="premium-hero-title">Connect with <em>Excellence</em></h1>
                </div>
            </div>
        </section>

        <section class="premium-desk-section">
            <div class="premium-desk-card">
                <div class="premium-concierge">
                    <div class="premium-concierge-inner">
                        <div class="premium-crest"><div class="premium-crest-text">TS.</div></div>
                        <h2 class="premium-concierge-title">Your <em>Expedition</em> Awaits.</h2>
                        <p class="premium-concierge-desc">Whether you seek the summit of Africa or the profound silence of the Serengeti, our senior architects are ready to forge your legacy.</p>

                        <div class="premium-contact-list">
                            <div class="premium-contact-card">
                                <div class="premium-icon-wrap"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
                                <div class="premium-contact-info">
                                    <span class="premium-contact-label">Direct Line (Arusha HQ)</span>
                                    <a href="tel:+255-621220912" class="premium-contact-val">+255-621220912</a>
                                </div>
                            </div>
                            <div class="premium-contact-card">
                                <div class="premium-icon-wrap"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg></div>
                                <div class="premium-contact-info">
                                    <span class="premium-contact-label">Priority WhatsApp</span>
                                    <a href="https://wa.me/255621220912" class="premium-contact-val" style="color:#25D366;">Message an Expert</a>
                                </div>
                            </div>
                            <div class="premium-contact-card">
                                <div class="premium-icon-wrap"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
                                <div class="premium-contact-info">
                                    <span class="premium-contact-label">Official Inquiries</span>
                                    <a href="mailto:info@tanzaniasensational.co.tz" class="premium-contact-val">info@tanzaniasensational.co.tz</a>
                                </div>
                            </div>
                        </div>

                        <div class="premium-socials">
                            <a href="#" target="_blank" rel="noreferrer" class="premium-social-link" aria-label="Instagram"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg></a>
                            <a href="#" target="_blank" rel="noreferrer" class="premium-social-link" aria-label="Facebook"><svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg></a>
                        </div>
                    </div>
                </div>

                <div class="premium-planner">
                    <div class="premium-form-heading">
                        <h2 class="premium-form-title">Plan your journey</h2>
                        <p class="premium-form-subtitle">Provide your details, and an expert will respond within 24 hours.</p>
                    </div>

                    <form class="premium-form" action="/contact" method="post">
                        <div class="premium-form-row">
                            <div class="premium-input-group">
                                <label>Your First Name</label>
                                <input name="first_name" type="text" required class="premium-input" placeholder="e.g. John" />
                            </div>
                            <div class="premium-input-group">
                                <label>Your Last Name</label>
                                <input name="last_name" type="text" required class="premium-input" placeholder="e.g. Smith" />
                            </div>
                        </div>
                        <div class="premium-form-row">
                            <div class="premium-input-group">
                                <label>Email Address</label>
                                <input name="email" type="email" required class="premium-input" placeholder="name@domain.com" />
                            </div>
                            <div class="premium-input-group">
                                <label>Phone (Optional)</label>
                                <input name="phone" type="tel" class="premium-input" placeholder="+1 (555) 000-0000" />
                            </div>
                        </div>
                        <div class="premium-input-group">
                            <label>The Objective</label>
                            <select name="objective" class="premium-select">
                                <option value="Kilimanjaro Summit Expedition">Kilimanjaro Summit Expedition</option>
                                <option value="Kilimanjaro Route Advice (Help me choose)">Kilimanjaro Route Advice (Help me choose)</option>
                                <option value="Group Departure (Join a scheduled date)">Group Departure (Join a scheduled date)</option>
                                <option value="Ultimate Wildlife Safari">Ultimate Wildlife Safari</option>
                                <option value="Safari Packages (Help me choose)">Safari Packages (Help me choose)</option>
                                <option value="Mount Meru Acclimatization">Mount Meru Acclimatization</option>
                                <option value="Zanzibar Recovery Retreat">Zanzibar Recovery Retreat</option>
                                <option value="Gear Rental Request">Gear Rental Request</option>
                                <option value="Booking Follow-up">Booking Follow-up (I already submitted a request)</option>
                                <option value="Partnership / Agent Inquiry">Partnership / Agent Inquiry</option>
                                <option value="Media / Press">Media / Press</option>
                                <option value="Custom Hybrid Adventure">Custom Hybrid Adventure</option>
                            </select>
                        </div>
                        <div class="premium-input-group">
                            <label>The Vision</label>
                            <textarea name="vision" class="premium-textarea" placeholder="Share the dream. Are you celebrating a milestone? Do you have specific terrain or wildlife encounters in mind?"></textarea>
                        </div>
                        <div class="premium-action-area">
                            <button type="submit" class="premium-submit-btn"><span>Send inquiry</span><svg class="premium-submit-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></button>
                            <div class="premium-trust-mark"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 12 15 17 10"/></svg><span>We'll reply by email within 24 hours. Your details stay private.</span></div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <section class="premium-map-section">
            <div class="premium-map-header">
                <span class="premium-map-eyebrow">Our Presence</span>
                <h2 class="premium-map-title">Based in the Heart of <em>Tanzania</em></h2>
                <div class="premium-address-row">
                    <div class="premium-addr-item">
                        <svg class="premium-addr-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        <div class="premium-addr-info">
                            <span class="premium-addr-label">Our Location</span>
                            <span class="premium-addr-value">Moshi-Arusha Road</span>
                        </div>
                    </div>
                    <div class="premium-addr-item">
                        <svg class="premium-addr-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="3 11 22 2 13 21 11 13 3 11"/></svg>
                        <div class="premium-addr-info">
                            <span class="premium-addr-label">Coordinates</span>
                            <span class="premium-addr-value">3.3869° S, 36.6830° E</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="premium-map-frame">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15941.348633!2d37.3340!3d-3.3440!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x18370f2f00000001%3A0x0!2zTW9zaGksIFRhbnphbmlh!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus" title="Tanzania Base Map" loading="lazy"></iframe>
            </div>
        </section>
    </div>
    <?php
    return ob_get_clean();
} );

add_shortcode( 'ts_zanzibar_page', function() {
    $hero = 'https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?ixlib=rb-4.0.3&auto=format&fit=crop&w=2400&q=80';
    $stoneTown = 'https://images.unsplash.com/photo-1580979878201-9b5a5a3fad64?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80';
    $nungwi = 'https://images.unsplash.com/photo-1621845184551-bb5e7141ecf4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80';
    $paje = 'https://images.unsplash.com/photo-1579471923053-ec4f6762edbc?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80';
    $safariBlue = 'https://images.unsplash.com/photo-1533221375330-84c6af70ce9b?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80';
    $spice = 'https://images.unsplash.com/photo-1606041008023-472dfb5e530f?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80';
    $prison = 'https://images.unsplash.com/photo-1437622368342-7a3d73a40cfa?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80';
    ob_start();
    ?>
    <div class="zan-root">
        <section class="zan-hero">
            <div class="zan-hero-bg">
                <img src="<?php echo esc_url( $hero ); ?>" alt="Zanzibar coastline" />
                <div class="zan-hero-overlay"></div>
            </div>
            <div class="zan-hero-content">
                <span class="zan-eyebrow">The Spice Archipelago</span>
                <h1 class="zan-hero-title">Zanzibar<em>.</em></h1>
                <p class="zan-hero-subtitle">Where ancient stone meets endless turquoise. An island woven from coral, clove, and centuries of untold stories.</p>
            </div>
            <div class="zan-stats-strip">
                <div class="zan-stats-grid">
                    <div class="zan-stat-item"><span class="zan-stat-num">26<span>+</span></span><span class="zan-stat-label">Pristine Beaches</span></div>
                    <div class="zan-stat-item"><span class="zan-stat-num">4</span><span class="zan-stat-label">Distinct Regions</span></div>
                    <div class="zan-stat-item"><span class="zan-stat-num">600<span>+</span></span><span class="zan-stat-label">Years of History</span></div>
                    <div class="zan-stat-item"><span class="zan-stat-num">28<span>°</span></span><span class="zan-stat-label">Year-Round Warmth</span></div>
                </div>
            </div>
        </section>

        <section class="zan-editorial">
            <div class="zan-editorial-grid">
                <div class="zan-editorial-text">
                    <span class="zan-eyebrow">The Ancient Heart</span>
                    <h2 class="zan-section-title">Where History <em>Breathes.</em></h2>
                    <p class="zan-body">In the labyrinth of Stone Town, time is not a line, it is a scent of cloves and aging coral rag. Every carved doorway tells a dynasty's story. Every narrow alley opens to a courtyard where Swahili, Arabic, Indian, and European influences have fused into something entirely its own.</p>
                    <p class="zan-body">UNESCO recognized this living museum as a World Heritage Site, but no designation can capture the feeling of watching a crimson sunset from the Forodhani Gardens while the aroma of grilled octopus and urojo rises from the night market below.</p>
                </div>
                <div class="zan-editorial-img"><img src="<?php echo esc_url( $stoneTown ); ?>" alt="Stone Town alleyway" /></div>
            </div>
        </section>

        <section class="zan-regions">
            <div class="zan-regions-header">
                <span class="zan-eyebrow" style="color:var(--gold);">Explore the Island</span>
                <h2 class="zan-section-title" style="margin-top:20px;">Three Worlds, One <em>Island.</em></h2>
            </div>
            <div class="zan-regions-grid">
                <div class="zan-region-card">
                    <div class="zan-region-img"><img src="<?php echo esc_url( $stoneTown ); ?>" alt="Stone Town" loading="lazy" /></div>
                    <span class="zan-region-tag">UNESCO Heritage</span>
                    <h3 class="zan-region-name">Stone Town</h3>
                    <p class="zan-region-desc">A labyrinth of coral-rag alleys, carved wooden doors, and a history layered with sultans, spice traders, and Swahili poets.</p>
                    <a href="/contact" class="zan-region-link"><span>Detailed Dossier</span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                </div>
                <div class="zan-region-card">
                    <div class="zan-region-img"><img src="<?php echo esc_url( $nungwi ); ?>" alt="Nungwi Beach" loading="lazy" /></div>
                    <span class="zan-region-tag">Northern Coast</span>
                    <h3 class="zan-region-name">Nungwi & Kendwa</h3>
                    <p class="zan-region-desc">Powder-white sand meeting the Indian Ocean in shades of impossible turquoise. Legendary sunsets and dhow-building villages.</p>
                    <a href="/contact" class="zan-region-link"><span>Detailed Dossier</span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                </div>
                <div class="zan-region-card">
                    <div class="zan-region-img"><img src="<?php echo esc_url( $paje ); ?>" alt="Paje Beach" loading="lazy" /></div>
                    <span class="zan-region-tag">Eastern Shore</span>
                    <h3 class="zan-region-name">Paje & Jambiani</h3>
                    <p class="zan-region-desc">Kite-surfing paradise by day, bioluminescent shores by night. Seaweed farms paint the low-tide flats in geometric beauty.</p>
                    <a href="/contact" class="zan-region-link"><span>Detailed Dossier</span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                </div>
            </div>
        </section>

        <section class="zan-parallax">
            <img src="<?php echo esc_url( $nungwi ); ?>" alt="Nungwi Beach" />
            <div class="zan-parallax-overlay"></div>
            <div class="zan-parallax-label">PRISTINE SILENCE</div>
        </section>

        <section class="zan-experiences">
            <div class="zan-experiences-header">
                <span class="zan-eyebrow" style="color:var(--gold);">Curated Moments</span>
                <h2 class="zan-section-title" style="margin-top:20px;">The Island <em>Experience.</em></h2>
            </div>
            <div class="zan-exp-grid">
                <div class="zan-exp-card">
                    <div class="zan-exp-img"><img src="<?php echo esc_url( $safariBlue ); ?>" alt="Safari Blue Voyage" loading="lazy" /></div>
                    <div class="zan-exp-content">
                        <span class="zan-eyebrow">Signature Dispatch</span>
                        <h3 class="zan-exp-title">Safari Blue Voyage</h3>
                        <p class="zan-exp-desc">A bespoke mahogany dhow to the Menai Bay area. Snorkel pristine reefs, dine on a sandbank seafood BBQ, and relax in absolute seclusion.</p>
                        <a href="/contact" class="zan-exp-cta"><span>Inquire</span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                    </div>
                </div>
                <div class="zan-exp-card">
                    <div class="zan-exp-img"><img src="<?php echo esc_url( $spice ); ?>" alt="Spice Plantation Tour" loading="lazy" /></div>
                    <div class="zan-exp-content">
                        <span class="zan-eyebrow">Cultural Immersion</span>
                        <h3 class="zan-exp-title">Spice Plantation Tour</h3>
                        <p class="zan-exp-desc">Walk through the aromatic groves that gave Zanzibar its name. Clove, cinnamon, vanilla, and cardamom, harvested and tasted fresh from the source.</p>
                        <a href="/contact" class="zan-exp-cta"><span>Inquire</span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                    </div>
                </div>
                <div class="zan-exp-card">
                    <div class="zan-exp-img"><img src="<?php echo esc_url( $prison ); ?>" alt="Prison Island" loading="lazy" /></div>
                    <div class="zan-exp-content">
                        <span class="zan-eyebrow">Historical Excursion</span>
                        <h3 class="zan-exp-title">Prison Island</h3>
                        <p class="zan-exp-desc">A short boat ride reveals giant Aldabra tortoises, coral gardens, and the haunting remains of a 19th-century detention chamber turned sanctuary.</p>
                        <a href="/contact" class="zan-exp-cta"><span>Inquire</span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                    </div>
                </div>
            </div>
        </section>

        <section class="zan-testimonial">
            <span class="zan-eyebrow">The Legacy</span>
            <p class="zan-testimonial-quote">"We came for the beaches. We stayed for the culture. And we left knowing that Zanzibar had fundamentally changed the way we see the world."</p>
            <div class="zan-testimonial-author">Maria & David R. • Milan, Italy</div>
        </section>

        <section class="zan-cta-band">
            <div class="zan-cta-bg">
                <img src="<?php echo esc_url( $paje ); ?>" alt="Paje Beach" />
                <div class="zan-cta-overlay"></div>
            </div>
            <div class="zan-cta-content">
                <span class="zan-eyebrow" style="color:rgba(255,255,255,0.7);">Your Island Awaits</span>
                <h2 class="zan-cta-title">Begin Your Island <em>Chapter.</em></h2>
                <p class="zan-cta-subtitle">Whether as the perfect finale to a Kilimanjaro summit or a standalone retreat, our Zanzibar extensions are crafted around your rhythm.</p>
                <div class="zan-btn-group">
                    <a href="/contact" class="zan-btn-primary"><span>Commission Your Stay</span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                    <a href="/safaris" class="zan-btn-outline"><span>Explore Safari Pairings</span><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
                </div>
            </div>
        </section>
    </div>
    <?php
    return ob_get_clean();
} );


// ─── UTILITY PAGES: FAQ, GEAR, TRAINING, ADDONS ───

add_shortcode( 'ts_faq_page', function() {
    $hero = 'https://images.unsplash.com/photo-1621414050946-1b936a78490b?q=80&w=2000&auto=format&fit=crop';
    $category_images = array(
        'The Climb'         => 'https://images.unsplash.com/photo-1621414050946-1b936a78490b?auto=format&fit=crop&q=80',
        'Health & Safety'   => 'https://images.unsplash.com/photo-1516820208784-270b250306e3?auto=format&fit=crop&q=80',
        'Booking & Logistics' => 'https://images.unsplash.com/photo-1547970810-dc1eac37d174?auto=format&fit=crop&q=80',
        'Gear & Preparation' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&q=80',
    );
    $faqs = array(
        array(
            'category' => 'The Climb',
            'items' => array(
                array( 'q' => 'How difficult is climbing Kilimanjaro?', 'a' => 'Kilimanjaro is a non-technical mountain, meaning no ropes or ice axes are needed for the standard routes. However, it is an extreme altitude trek. The physical exertion combined with lower oxygen levels makes it a strenuous challenge requiring mental fortitude and physical preparation.' ),
                array( 'q' => 'Which route has the highest success rate?', 'a' => 'The longer routes—Lemosho (8 days) and Northern Circuit (9 days)—have the highest success rates, often exceeding 90%. They allow for the necessary \'climb high, sleep low\' acclimatization profile.' ),
                array( 'q' => 'Do I need to be a professional athlete?', 'a' => 'No. Age and fitness levels vary wildly on the mountain. Mental determination and pacing (\'Pole Pole\' - slowly slowly) are often more important than raw physical strength.' ),
                array( 'q' => 'What is the best time of year to climb?', 'a' => 'The best climbing seasons are January–March (dry and clear) and June–October (cooler and drier). December and April/May are possible but experience more rainfall.' ),
                array( 'q' => 'How many hours do we hike each day?', 'a' => 'Typically 4–7 hours of hiking per day, with summit day being 12–16 hours. We follow a \'Pole Pole\' (slowly slowly) philosophy to maximize acclimatization.' ),
            ),
        ),
        array(
            'category' => 'Health & Safety',
            'items' => array(
                array( 'q' => 'What is Altitude Sickness (AMS)?', 'a' => 'Acute Mountain Sickness occurs when ascending to high altitudes too quickly. Symptoms include headache, nausea, and fatigue. Our guides monitor heart rate and oxygen saturation twice daily to catch early signs.' ),
                array( 'q' => 'What happens if I cannot continue?', 'a' => 'Safety is paramount. If you must descend, an assistant guide will escort you down safely. Depending on your location and the severity of your condition, we will coordinate an evacuation to the nearest gate or organize medical helicopter air-lift.' ),
                array( 'q' => 'Is the water safe to drink?', 'a' => 'Our porters gather fresh mountain stream water daily, which is then boiled and purified at camp before being served to you. You will need to bring iodine or purification tablets only as an emergency backup.' ),
                array( 'q' => 'What vaccinations are required?', 'a' => 'Yellow fever vaccination is mandatory for entry into Tanzania. We also recommend Hepatitis A & B, Typhoid, and routine vaccinations. Consult your travel clinic 6–8 weeks before departure.' ),
                array( 'q' => 'Do you carry oxygen on the climb?', 'a' => 'Yes. All our climbs carry portable oxygen cylinders and comprehensive first-aid kits. Our guides are trained in wilderness first response and altitude medicine.' ),
            ),
        ),
        array(
            'category' => 'Booking & Logistics',
            'items' => array(
                array( 'q' => 'How far in advance should I book?', 'a' => 'We recommend booking 6–12 months in advance for the best departure dates and route selection. Last-minute bookings (within 3 months) are sometimes possible but subject to availability.' ),
                array( 'q' => 'What is included in the package price?', 'a' => 'All packages include: park fees, certified guides & porters, meals on the mountain, accommodation (tents/huts), airport transfers, pre-climb hotel, and safety equipment. Not included: flights, visas, travel insurance, tips, and personal gear.' ),
                array( 'q' => 'What is your cancellation policy?', 'a' => 'Cancellations 90+ days before departure receive a 75% refund. 60–89 days: 50% refund. 30–59 days: 25% refund. Less than 30 days: no refund. We strongly recommend trip cancellation insurance.' ),
                array( 'q' => 'Do you offer group discounts?', 'a' => 'Yes. Groups of 4+ receive a 10% discount. Groups of 8+ receive 15% off. Private group departures can be arranged with custom dates and itineraries.' ),
                array( 'q' => 'Can I extend my trip with a safari?', 'a' => 'Absolutely! Most climbers add a 3–7 day safari in Serengeti, Ngorongoro, or Tarangire. We offer seamless safari extensions with the same premium service standard.' ),
            ),
        ),
        array(
            'category' => 'Gear & Preparation',
            'items' => array(
                array( 'q' => 'What gear do I need to bring?', 'a' => 'We provide a detailed packing list upon booking. Essential items include: waterproof hiking boots, layered clothing (base/mid/outer), sleeping bag (-10°C rating), headlamp, trekking poles, and personal medications.' ),
                array( 'q' => 'Do you rent gear?', 'a' => 'Yes. We offer high-quality rental gear including sleeping bags, trekking poles, down jackets, and duffel bags. Rental must be reserved at least 30 days before departure.' ),
                array( 'q' => 'How should I train for the climb?', 'a' => 'Focus on cardiovascular endurance (hiking, running, cycling) and leg strength (squats, lunges). We recommend hiking with a loaded backpack 2–3 times per week for 3–6 months before your climb.' ),
                array( 'q' => 'What is the temperature range on the mountain?', 'a' => 'Temperatures vary dramatically: rainforest zone (15–25°C), moorland (5–15°C), alpine desert (-5 to 10°C), summit (-10 to -20°C with wind chill). Proper layering is essential.' ),
                array( 'q' => 'How much should my backpack weigh?', 'a' => 'Your daypack should be 5–8 kg (11–18 lbs) carrying water, snacks, extra layers, camera, and personal items. Porters carry the main duffel (max 15 kg / 33 lbs).' ),
            ),
        ),
    );
    $spans = array( 'span-8', 'span-4', 'span-4', 'span-8' );
    ob_start();
    ?>
    <div class="utility-root faq-organic-root">
        <section class="utility-hero">
            <div class="utility-hero-bg">
                <img src="<?php echo esc_url( $hero ); ?>" alt="Kilimanjaro summit with clear blue sky" />
            </div>
            <div class="utility-hero-overlay"></div>
            <div class="utility-hero-content">
                <span class="utility-hero-eyebrow">Your Questions Answered</span>
                <h1 class="utility-hero-title" style="font-size: clamp(3rem, 5vw, 6.5rem); font-family: 'Playfair Display', serif; font-weight: 400; letter-spacing: -0.02em;">Frequently Asked Questions</h1>
                <p class="utility-hero-subtitle">Everything you need to know about climbing Kilimanjaro, preparation, safety, and booking. Can't find your answer? Contact our team directly.</p>
            </div>
        </section>

        <section class="faq-controls-section">
            <div class="faq-controls-container">
                <div class="faq-search-wrapper">
                    <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    <input type="text" id="faq-search" class="faq-search-input" placeholder="Search questions..." />
                    <button type="button" class="clear-search" id="faq-clear" style="display:none;">Clear</button>
                </div>
                <div class="faq-category-filter">
                    <span class="filter-label">Filter by:</span>
                    <div class="category-buttons">
                        <button type="button" class="category-btn active" data-cat="all">All Questions</button>
                        <?php foreach ( $faqs as $section ) : ?>
                            <button type="button" class="category-btn" data-cat="<?php echo esc_attr( $section['category'] ); ?>"><?php echo esc_html( $section['category'] ); ?></button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>

        <div class="bento-hero-curtain"></div>

        <section class="utility-content bento-theme">
            <div class="bento-grid" id="faq-bento">
                <?php
                $global_idx = 0;
                foreach ( $faqs as $sIdx => $section ) :
                    $span = $spans[ $sIdx % count( $spans ) ];
                    $img  = isset( $category_images[ $section['category'] ] ) ? $category_images[ $section['category'] ] : '';
                    $words = explode( ' ', $section['category'] );
                    $first = $words[0];
                    $rest  = implode( ' ', array_slice( $words, 1 ) );
                ?>
                <div class="bento-card <?php echo esc_attr( $span ); ?>" data-category="<?php echo esc_attr( $section['category'] ); ?>">
                    <div class="bento-card-bg-img">
                        <img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $section['category'] ); ?>" loading="lazy" />
                    </div>
                    <div class="bento-card-gradient"></div>
                    <div class="bento-card-content">
                        <div class="bento-accent-pill">Subject <?php echo esc_html( $sIdx + 1 ); ?></div>
                        <h2 class="bento-card-title"><?php echo esc_html( $first ); ?> <em><?php echo esc_html( $rest ); ?></em></h2>
                        <div class="bento-qa-list">
                            <?php foreach ( array_slice( $section['items'], 0, 3 ) as $item ) : ?>
                            <details class="bento-qa-item" data-index="<?php echo esc_attr( $global_idx ); ?>">
                                <summary class="bento-q">
                                    <span><?php echo esc_html( $item['q'] ); ?></span>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </summary>
                                <div class="bento-a"><?php echo esc_html( $item['a'] ); ?></div>
                            </details>
                            <?php $global_idx++; endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="no-results-bento" id="faq-no-results" style="display:none;">
                <h3>No Records Found</h3>
                <p>Your query remains unanswered in our current architecture.</p>
                <button type="button" id="faq-reset">Reset Architecture</button>
            </div>

            <div class="faq-contact-cta">
                <div class="cta-icon">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                </div>
                <h3>Still have questions?</h3>
                <p>Our expert team is here to help you plan your perfect adventure.</p>
                <div class="cta-buttons">
                    <a href="/contact" class="cta-btn primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        Contact Us
                    </a>
                    <a href="tel:+255787654321" class="cta-btn secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        Call +255 787 654 321
                    </a>
                </div>
            </div>
        </section>
    </div>
    <script>
    (function(){
        const searchInput = document.getElementById('faq-search');
        const clearBtn = document.getElementById('faq-clear');
        const catBtns = document.querySelectorAll('.category-btn');
        const cards = document.querySelectorAll('.bento-card');
        const noResults = document.getElementById('faq-no-results');
        const resetBtn = document.getElementById('faq-reset');
        let activeCat = 'all';
        function filter(){
            const q = (searchInput.value || '').toLowerCase();
            let visibleCards = 0;
            cards.forEach(function(card){
                const cat = card.dataset.category;
                const catMatch = activeCat === 'all' || cat === activeCat;
                let textMatch = false;
                if (catMatch) {
                    card.querySelectorAll('.bento-qa-item').forEach(function(item){
                        const qText = item.querySelector('.bento-q span').textContent.toLowerCase();
                        const aText = item.querySelector('.bento-a').textContent.toLowerCase();
                        const match = !q || qText.indexOf(q) !== -1 || aText.indexOf(q) !== -1;
                        item.style.display = match ? '' : 'none';
                        if (match) textMatch = true;
                    });
                }
                const show = catMatch && textMatch;
                card.style.display = show ? '' : 'none';
                if (show) visibleCards++;
            });
            noResults.style.display = visibleCards ? 'none' : 'block';
            clearBtn.style.display = q ? 'inline-block' : 'none';
        }
        searchInput.addEventListener('input', filter);
        clearBtn.addEventListener('click', function(){ searchInput.value = ''; filter(); });
        catBtns.forEach(function(btn){
            btn.addEventListener('click', function(){
                activeCat = btn.dataset.cat;
                catBtns.forEach(function(b){ b.classList.toggle('active', b === btn); });
                filter();
            });
        });
        resetBtn.addEventListener('click', function(){
            searchInput.value = '';
            activeCat = 'all';
            catBtns.forEach(function(b){ b.classList.toggle('active', b.dataset.cat === 'all'); });
            filter();
        });
    })();
    </script>
    <?php
    return ob_get_clean();
} );

add_shortcode( 'ts_safari_guide_page', function() {
    $hero = 'https://images.unsplash.com/photo-1516422213484-2af298bf06ad?q=80&w=2000&auto=format&fit=crop';

    $icons = array(
        'luggage'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h12a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/><path d="M12 2v20"/><path d="M8 22v-2a2 2 0 0 1 4 0v2"/><path d="M12 22v-2a2 2 0 0 1 4 0v2"/></svg>',
        'book'     => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
        'shield'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        'heart'    => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
        'map'      => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>',
        'globe'    => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
        'compass'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>',
        'users'    => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'camera'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>',
        'star'     => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
        'arrow'    => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>',
        'chevron'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>',
    );

    $guide_topics = array(
        array( 'slug' => 'what-to-wear',        'label' => 'What to Wear on Safari',      'icon' => 'luggage', 'desc' => 'Essential safari clothing guide — from lightweight khakis to evening layers for bush dinners.' ),
        array( 'slug' => 'packing-guide',       'label' => 'Safari Packing List',         'icon' => 'book',    'desc' => 'Complete packing checklist for your East African safari adventure.' ),
        array( 'slug' => 'health-and-safety',   'label' => 'Health & Safety',             'icon' => 'shield',  'desc' => 'Vaccinations, malaria prevention, and wildlife safety protocols.' ),
        array( 'slug' => 'local-customs',       'label' => 'Local Customs & Etiquette',   'icon' => 'heart',   'desc' => 'Cultural norms, photography etiquette, and respectful travel practices.' ),
        array( 'slug' => 'accommodation-style', 'label' => 'Accommodation Styles',        'icon' => 'map',     'desc' => 'From luxury lodges to mobile tented camps — find your safari style.' ),
        array( 'slug' => 'visa-guide',          'label' => 'Tanzania Visa Guide',         'icon' => 'globe',   'desc' => 'Visa requirements, application process, and entry requirements for Tanzania.' ),
    );

    $planning_topics = array(
        array( 'slug' => '/faq',                'label' => 'Frequently Asked Questions',  'icon' => 'compass', 'desc' => 'Quick answers to the most common safari questions.' ),
        array( 'slug' => '/group-departures',   'label' => 'Group Joining Safaris',       'icon' => 'users',   'desc' => 'Fixed-departure group safaris for solo travelers and small groups.' ),
        array( 'slug' => '/safari-addons',      'label' => 'Safari Add-ons & Extensions', 'icon' => 'camera',  'desc' => 'Zanzibar beach extensions, gorilla trekking, and cultural experiences.' ),
        array( 'slug' => '/safaris/packages',   'label' => 'Browse All Packages',         'icon' => 'star',    'desc' => 'View our complete collection of curated safari expeditions.' ),
    );

    $destinations = array(
        array( 'slug' => 'serengeti',    'name' => 'Serengeti National Park', 'tagline' => 'The Endless Plains',     'desc' => 'The world\'s most iconic wildlife destination — home to the Great Migration and the Big Five.' ),
        array( 'slug' => 'ngorongoro',   'name' => 'Ngorongoro Crater',       'tagline' => 'Africa\'s Eden',          'desc' => 'A UNESCO World Heritage Site and the world\'s largest intact volcanic caldera.' ),
        array( 'slug' => 'tarangire',    'name' => 'Tarangire National Park', 'tagline' => 'Land of Giants',         'desc' => 'Famous for its massive elephant herds and ancient baobab trees.' ),
        array( 'slug' => 'manyara',      'name' => 'Lake Manyara National Park','tagline' => 'The Rift Valley Gem',   'desc' => 'Known for tree-climbing lions, flamingos, and stunning groundwater forests.' ),
        array( 'slug' => 'arusha',       'name' => 'Arusha National Park',    'tagline' => 'The Miniature Gem',      'desc' => 'A compact park with diverse landscapes — from Mount Meru to crater lakes.' ),
        array( 'slug' => 'ruaha',        'name' => 'Ruaha National Park',     'tagline' => 'The Wild Frontier',      'desc' => 'Tanzania\'s largest national park — remote, rugged, and teeming with wildlife.' ),
        array( 'slug' => 'selous',       'name' => 'Nyerere (Selous) Reserve','tagline' => 'Untamed Wilderness',     'desc' => 'One of Africa\'s largest protected areas — known for boat safaris on the Rufiji River.' ),
        array( 'slug' => 'katavi',       'name' => 'Katavi National Park',    'tagline' => 'The Last Wilderness',    'desc' => 'Remote and untouched — for the adventurous traveler seeking true solitude.' ),
    );

    $style_topics = array(
        array( 'slug' => '/safaris/family',       'label' => 'Family Safaris',       'icon' => 'heart',  'desc' => 'Kid-friendly itineraries with educational activities.' ),
        array( 'slug' => '/safaris/honeymoon',    'label' => 'Honeymoon Safaris',    'icon' => 'heart',  'desc' => 'Romantic escapes with luxury bush dining and sundowners.' ),
        array( 'slug' => '/safaris/luxury',       'label' => 'Luxury Safaris',       'icon' => 'star',   'desc' => 'Premium lodges, private guides, and exclusive experiences.' ),
        array( 'slug' => '/safaris/photographic', 'label' => 'Photographic Safaris', 'icon' => 'camera', 'desc' => 'Specialist-led trips for wildlife photography enthusiasts.' ),
        array( 'slug' => '/safaris/group-joining','label' => 'Group Joining',        'icon' => 'users',  'desc' => 'Join scheduled departures with shared costs and new friends.' ),
    );

    ob_start();
    ?>
    <div class="field-root">
        <section class="field-hero">
            <div class="field-hero-img">
                <img src="<?php echo esc_url( $hero ); ?>" alt="African Safari — The Ultimate Guide to Tanzania Wildlife Expeditions" />
            </div>
            <div class="field-hero-gradient"></div>
            <div class="field-hero-content">
                <span class="field-hero-eyebrow">The Complete Guide</span>
                <h1 class="field-hero-title">Tanzania <em>Safari.</em></h1>
                <p class="field-hero-subtitle">Everything you need to plan the ultimate East African safari — from choosing your destination to packing for the bush.</p>
            </div>
        </section>

        <section class="field-chapter">
            <span class="field-chapter-eyebrow">Your Safari Journey</span>
            <h2 class="field-chapter-title">Africa's Greatest Wildlife <em>Experience</em></h2>
            <p class="field-chapter-body">Tanzania is home to some of the most spectacular wildlife viewing on Earth. From the endless plains of the Serengeti — where the Great Migration sees over 1.5 million wildebeest thunder across the savannah — to the Ngorongoro Crater, a natural amphitheatre teeming with predators and prey, Tanzania offers safari experiences that are simply unmatched anywhere else on the continent.</p>
            <p class="field-chapter-body">Whether you are a first-time safari-goer or a seasoned wildlife enthusiast, this guide covers everything you need to plan your perfect Tanzania safari. Explore our destinations, compare packages, and prepare for the adventure of a lifetime.</p>
        </section>

        <section class="field-chapter field-section-alt">
            <span class="field-chapter-eyebrow">Choose Your Wilderness</span>
            <h2 class="field-chapter-title">Safari <em>Destinations</em></h2>
            <p class="field-chapter-body">Tanzania's national parks and game reserves each offer a unique character and wildlife experience. Explore them below to find your perfect safari destination.</p>
            <div class="field-pillar-grid field-pillar-grid-4">
                <?php foreach ( $destinations as $dest ) : ?>
                <div class="field-pillar-card">
                    <div class="field-pillar-card-body">
                        <div class="field-pillar-card-eyebrow"><?php echo esc_html( $dest['tagline'] ); ?></div>
                        <h3 class="field-pillar-card-title"><?php echo esc_html( $dest['name'] ); ?></h3>
                        <p class="field-pillar-card-desc"><?php echo esc_html( $dest['desc'] ); ?></p>
                    </div>
                    <a href="/safaris/destinations/<?php echo esc_attr( $dest['slug'] ); ?>" class="field-pillar-card-link">Explore Destination <?php echo $icons['arrow']; ?></a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="field-chapter">
            <span class="field-chapter-eyebrow">Curated Expeditions</span>
            <h2 class="field-chapter-title">Safari <em>Packages</em></h2>
            <p class="field-chapter-body">From intimate 3-day getaways to comprehensive 14-day expeditions, our safari packages are designed to match every travel style and budget.</p>
            <div class="field-pillar-grid field-pillar-grid-3">
                <a href="/safaris/packages" class="field-pillar-card">
                    <div class="field-pillar-card-body">
                        <h3 class="field-pillar-card-title">Browse All Packages</h3>
                        <p class="field-pillar-card-desc">View our complete collection of curated safari expeditions.</p>
                    </div>
                    <span class="field-pillar-card-link">View All Packages <?php echo $icons['arrow']; ?></span>
                </a>
            </div>
            <div style="text-align: center; margin-top: 60px;">
                <a href="/safaris/packages" class="field-btn">View All Safari Packages <?php echo $icons['arrow']; ?></a>
            </div>
        </section>

        <section class="field-chapter field-section-alt">
            <span class="field-chapter-eyebrow">Prepare for the Bush</span>
            <h2 class="field-chapter-title">Safari Preparation <em>Guides</em></h2>
            <p class="field-chapter-body">Proper preparation transforms a good safari into an extraordinary one. These guides cover everything from what to pack to understanding local customs.</p>
            <div class="field-pillar-grid field-pillar-grid-3">
                <?php foreach ( $guide_topics as $topic ) : ?>
                <div class="field-pillar-card">
                    <div class="field-pillar-card-body">
                        <span class="field-pillar-card-icon"><?php echo $icons[ $topic['icon'] ]; ?></span>
                        <h3 class="field-pillar-card-title"><?php echo esc_html( $topic['label'] ); ?></h3>
                        <p class="field-pillar-card-desc"><?php echo esc_html( $topic['desc'] ); ?></p>
                    </div>
                    <a href="/safari-guide/<?php echo esc_attr( $topic['slug'] ); ?>" class="field-pillar-card-link">Read Guide <?php echo $icons['arrow']; ?></a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="field-chapter">
            <span class="field-chapter-eyebrow">Plan Your Adventure</span>
            <h2 class="field-chapter-title">Planning <em>Resources</em></h2>
            <p class="field-chapter-body">From frequently asked questions to group joining options, these resources will help you plan every aspect of your safari.</p>
            <div class="field-pillar-grid field-pillar-grid-4">
                <?php foreach ( $planning_topics as $topic ) : ?>
                <div class="field-pillar-card">
                    <div class="field-pillar-card-body">
                        <span class="field-pillar-card-icon"><?php echo $icons[ $topic['icon'] ]; ?></span>
                        <h3 class="field-pillar-card-title"><?php echo esc_html( $topic['label'] ); ?></h3>
                        <p class="field-pillar-card-desc"><?php echo esc_html( $topic['desc'] ); ?></p>
                    </div>
                    <a href="<?php echo esc_url( $topic['slug'] ); ?>" class="field-pillar-card-link">Learn More <?php echo $icons['arrow']; ?></a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="field-chapter field-section-alt">
            <span class="field-chapter-eyebrow">Find Your Style</span>
            <h2 class="field-chapter-title">Safari by Travel <em>Style</em></h2>
            <p class="field-chapter-body">Whether you are travelling with family, celebrating a honeymoon, or seeking luxury — we have a safari designed for your needs.</p>
            <div class="field-pillar-grid field-pillar-grid-5">
                <?php foreach ( $style_topics as $style ) : ?>
                <div class="field-pillar-card">
                    <div class="field-pillar-card-body">
                        <span class="field-pillar-card-icon"><?php echo $icons[ $style['icon'] ]; ?></span>
                        <h3 class="field-pillar-card-title"><?php echo esc_html( $style['label'] ); ?></h3>
                        <p class="field-pillar-card-desc"><?php echo esc_html( $style['desc'] ); ?></p>
                    </div>
                    <a href="<?php echo esc_url( $style['slug'] ); ?>" class="field-pillar-card-link">Explore <?php echo $icons['arrow']; ?></a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="field-chapter">
            <span class="field-chapter-eyebrow">Quick Answers</span>
            <h2 class="field-chapter-title">Frequently Asked <em>Questions</em></h2>
            <div class="field-pillar-faq">
                <div class="field-pillar-faq-item">
                    <h3>When is the best time to go on safari in Tanzania?</h3>
                    <p>The dry season (June to October) offers the best wildlife viewing, as animals congregate around water sources. The wildebeest migration peaks in the Serengeti from July to September. The green season (November to May) offers lush landscapes, fewer crowds, and lower rates.</p>
                </div>
                <div class="field-pillar-faq-item">
                    <h3>What is the Big Five and will I see them?</h3>
                    <p>The Big Five — lion, leopard, elephant, buffalo, and rhino — are all present in Tanzania. You are highly likely to see lions, elephants, and buffalo in most parks. Leopards require a keen eye, and rhinos are most reliably seen at Ngorongoro Crater.</p>
                </div>
                <div class="field-pillar-faq-item">
                    <h3>Is a safari safe for children?</h3>
                    <p>Yes, many of our family-friendly safaris are designed specifically for children. We recommend private vehicles, shorter game drives, and lodges with family facilities. Children aged 6+ generally enjoy the experience most. See our <a href="/safaris/family">family safaris</a> for more details.</p>
                </div>
                <div class="field-pillar-faq-item">
                    <h3>What should I pack for a Tanzania safari?</h3>
                    <p>Lightweight, neutral-coloured clothing, a warm layer for morning game drives, comfortable walking shoes, sunscreen, insect repellent, a hat, binoculars, and a camera with a zoom lens. See our <a href="/safari-guide/packing-guide">complete packing list</a> for details.</p>
                </div>
            </div>
            <div style="text-align: center; margin-top: 60px;">
                <a href="/faq" class="field-btn">View All FAQs <?php echo $icons['chevron']; ?></a>
            </div>
        </section>

        <section class="field-cta">
            <h2 class="field-cta-title">Ready for the <em>Adventure?</em></h2>
            <p class="field-cta-body">Whether you have a specific itinerary in mind or need help designing the perfect safari from scratch, our expert team is here to help.</p>
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="/safaris/packages" class="field-btn">Browse Safari Packages <?php echo $icons['arrow']; ?></a>
                <a href="/contact" class="field-btn" style="border-color: var(--field-gold); color: var(--field-gold);">Contact Our Team</a>
            </div>
        </section>
    </div>
    <?php
    return ob_get_clean();
} );

add_shortcode( 'ts_kilimanjaro_pillar_page', function() {
    $hero = 'https://images.unsplash.com/photo-1585409677983-0f6c41ca9c3b?q=80&w=2000&auto=format&fit=crop';

    $route_images = array(
        'lemosho'        => 'https://images.unsplash.com/photo-1621414050946-1b936a78490b?auto=format&fit=crop&q=80',
        'machame'        => 'https://images.unsplash.com/photo-1579471923053-ec4f6762edbc?auto=format&fit=crop&q=80',
        'northern-circuit'=> 'https://images.unsplash.com/photo-1585409677983-0f6c41ca9c3b?auto=format&fit=crop&q=80',
        'marangu'        => 'https://images.unsplash.com/photo-1621845184551-bb5e7141ecf4?auto=format&fit=crop&q=80',
        'rongai'         => 'https://images.unsplash.com/photo-1533221375330-84c6af70ce9b?auto=format&fit=crop&q=80',
        'umbwe'          => 'https://images.unsplash.com/photo-1516422213484-2af298bf06ad?auto=format&fit=crop&q=80',
    );

    $icons = array(
        'mountain' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M8 3l4 8 5-5 5 15H2L8 3z"/></svg>',
        'trending' => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>',
        'users'    => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
        'award'    => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>',
        'compass'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>',
        'sun'      => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>',
        'heart'    => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>',
        'book'     => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
        'shield'   => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
        'activity' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>',
        'map'      => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"/><line x1="8" y1="2" x2="8" y2="18"/><line x1="16" y1="6" x2="16" y2="22"/></svg>',
        'clock'    => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>',
        'luggage'  => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2h12a2 2 0 0 1 2 2v16a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z"/><path d="M12 2v20"/><path d="M8 22v-2a2 2 0 0 1 4 0v2"/><path d="M12 22v-2a2 2 0 0 1 4 0v2"/></svg>',
        'arrow'    => '<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>',
        'chevron'  => '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>',
    );

    $routes = array(
        array( 'slug' => 'lemosho',        'name' => 'Lemosho Route',      'tagline' => 'The Western Approach',      'days' => '7–8 days', 'difficulty' => 'Moderate',             'scenery' => '★★★★★', 'success' => 'Very High',     'desc' => 'Our most recommended route. The Lemosho offers superb scenery, excellent acclimatization, and high summit success rates.' ),
        array( 'slug' => 'machame',        'name' => 'Machame Route',      'tagline' => 'The Whiskey Route',         'days' => '6–7 days', 'difficulty' => 'Moderate–Challenging', 'scenery' => '★★★★★', 'success' => 'High',          'desc' => 'The most popular route on Kilimanjaro. Known for stunning scenery and a challenging but rewarding climb.' ),
        array( 'slug' => 'northern-circuit','name' => 'Northern Circuit',  'tagline' => 'The Long & Scenic',         'days' => '9 days',   'difficulty' => 'Moderate',             'scenery' => '★★★★★', 'success' => 'Very High',     'desc' => 'The newest route on Kilimanjaro. Nine days on the mountain with exceptional acclimatization and remote wilderness.' ),
        array( 'slug' => 'marangu',        'name' => 'Marangu Route',      'tagline' => 'The Coca-Cola Route',       'days' => '5–6 days', 'difficulty' => 'Moderate',             'scenery' => '★★★☆☆', 'success' => 'Moderate',      'desc' => 'The only route with hut accommodation. A classic climb with a shorter duration but lower success rate.' ),
        array( 'slug' => 'rongai',         'name' => 'Rongai Route',       'tagline' => 'The Northern Approach',     'days' => '6–7 days', 'difficulty' => 'Moderate',             'scenery' => '★★★★☆', 'success' => 'High',          'desc' => 'The only route approaching from the north. Offers a unique perspective and drier conditions during rainy seasons.' ),
        array( 'slug' => 'umbwe',          'name' => 'Umbwe Route',        'tagline' => 'The Challenger',            'days' => '5–6 days', 'difficulty' => 'Challenging',          'scenery' => '★★★★☆', 'success' => 'Low–Moderate',  'desc' => 'The steepest and most technical route. For experienced trekkers seeking a physical challenge.' ),
    );

    $prep_topics = array(
        array( 'slug' => 'best-routes',   'label' => 'How to Choose the Best Route', 'icon' => 'compass',  'desc' => 'Compare all 6 routes side-by-side to find your perfect match.' ),
        array( 'slug' => 'best-time',     'label' => 'Best Time to Climb Kilimanjaro','icon' => 'sun',     'desc' => 'Understand seasonal weather patterns and choose your ideal climbing window.' ),
        array( 'slug' => 'why-us',        'label' => 'Why Choose Tanzania Sensational','icon' => 'heart',  'desc' => 'Our safety record, guide expertise, and commitment to responsible tourism.' ),
        array( 'slug' => 'tipping-guide', 'label' => 'Tipping Guide',                'icon' => 'users',    'desc' => 'Fair tipping guidelines for your mountain support team.' ),
        array( 'slug' => 'park-fees',     'label' => 'Kilimanjaro Park Fees',        'icon' => 'book',     'desc' => 'Breakdown of KINAPA park fees and what they cover.' ),
        array( 'slug' => 'toilets',       'label' => 'Toilets on Kilimanjaro',       'icon' => 'map',      'desc' => 'What to expect and how to prepare for bathroom facilities on the mountain.' ),
    );

    $health_topics = array(
        array( 'slug' => 'vaccinations',     'label' => 'Vaccinations & Health Prep', 'icon' => 'shield',   'desc' => 'Required and recommended vaccinations before your climb.' ),
        array( 'slug' => 'altitude-sickness','label' => 'Altitude Sickness Guide',    'icon' => 'activity', 'desc' => 'Recognize, prevent, and manage Acute Mountain Sickness (AMS).' ),
        array( 'slug' => 'diamox',           'label' => 'Diamox for Altitude',        'icon' => 'heart',    'desc' => 'Everything you need to know about acetazolamide for altitude acclimatization.' ),
        array( 'slug' => 'oxygen',           'label' => 'Oxygen on Kilimanjaro',      'icon' => 'mountain', 'desc' => 'When and how supplemental oxygen is used on the mountain.' ),
    );

    $after_topics = array(
        array( 'slug' => 'training',       'label' => 'Training for Kilimanjaro', 'icon' => 'activity', 'desc' => 'A 12-week training program to prepare your body for summit day.' ),
        array( 'slug' => 'gear-list',      'label' => 'Gear List & Packing',      'icon' => 'luggage',  'desc' => 'Complete packing checklist for your Kilimanjaro expedition.' ),
        array( 'slug' => 'getting-there',  'label' => 'Getting to Kilimanjaro',   'icon' => 'map',      'desc' => 'Flights, visas, and arrival logistics for Kilimanjaro International Airport.' ),
        array( 'slug' => 'visa',           'label' => 'Visa Information',         'icon' => 'book',     'desc' => 'Tanzania visa requirements and application process.' ),
    );

    $during_topics = array(
        array( 'slug' => 'daily-routine',     'label' => 'Daily Routine on the Mountain', 'icon' => 'clock',    'desc' => 'What a typical day looks like during your Kilimanjaro climb.' ),
        array( 'slug' => 'food-and-drinks',   'label' => 'Food & Drinks',                 'icon' => 'heart',    'desc' => 'Nutrition and hydration strategies for high-altitude trekking.' ),
        array( 'slug' => 'pack-your-daypack', 'label' => 'Pack Your Daypack',             'icon' => 'luggage',  'desc' => 'What to carry each day and how to organize your daypack.' ),
        array( 'slug' => 'connectivity',      'label' => 'Connectivity on the Mountain',  'icon' => 'sun',      'desc' => 'Phone signal, Wi-Fi, and staying connected during your climb.' ),
    );

    $stats = array(
        array( 'value' => '5,895m', 'label' => 'Summit Elevation', 'icon' => 'mountain' ),
        array( 'value' => '95%',    'label' => 'Summit Success Rate', 'icon' => 'trending' ),
        array( 'value' => '35,000+','label' => 'Trekkers Per Year', 'icon' => 'users' ),
        array( 'value' => '15+',    'label' => 'Years Experience', 'icon' => 'award' ),
    );

    ob_start();
    ?>
    <div class="field-root">
        <section class="field-hero">
            <div class="field-hero-img">
                <img src="<?php echo esc_url( $hero ); ?>" alt="Kilimanjaro Trekking — The Ultimate Guide to Africa's Highest Peak" />
            </div>
            <div class="field-hero-gradient"></div>
            <div class="field-hero-content">
                <span class="field-hero-eyebrow">The Complete Guide</span>
                <h1 class="field-hero-title">Kilimanjaro <em>Trekking.</em></h1>
                <p class="field-hero-subtitle">Everything you need to plan, prepare, and conquer Africa's highest peak — from choosing your route to summit day.</p>
            </div>
        </section>

        <section class="field-chapter">
            <span class="field-chapter-eyebrow">Mount Kilimanjaro</span>
            <h2 class="field-chapter-title">Africa's Roof, Your <em>Summit</em></h2>
            <p class="field-chapter-body">At 5,895 metres (19,341 feet), Mount Kilimanjaro is the highest free-standing mountain in the world and the tallest peak in Africa. Located in northeastern Tanzania near the town of Moshi, this dormant volcano attracts over 35,000 trekkers each year from around the globe.</p>
            <p class="field-chapter-body">Climbing Kilimanjaro does not require technical mountaineering skills — no ropes, crampons, or ice axes are needed on the standard routes. What it does require is proper preparation, the right gear, a positive mindset, and a reputable operator who prioritises your safety and success.</p>
        </section>

        <section class="field-stats-strip">
            <div class="field-stats-grid">
                <?php foreach ( $stats as $i => $stat ) : ?>
                <div class="field-stat" style="<?php echo $i < 3 ? 'border-right: 1px solid var(--field-border);' : ''; ?>">
                    <div class="field-stat-icon"><?php echo $icons[ $stat['icon'] ]; ?></div>
                    <div class="field-stat-value"><?php echo esc_html( $stat['value'] ); ?></div>
                    <div class="field-stat-label"><?php echo esc_html( $stat['label'] ); ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="field-chapter" style="padding-top: 120px;">
            <span class="field-chapter-eyebrow">Choose Your Path</span>
            <h2 class="field-chapter-title">Kilimanjaro Climbing <em>Routes</em></h2>
            <p class="field-chapter-body">Each route offers a unique experience — different landscapes, difficulty levels, and summit success rates. Compare them below to find the one that matches your fitness level, schedule, and adventure style.</p>
            <div class="field-pillar-grid field-pillar-grid-3">
                <?php foreach ( $routes as $route ) : ?>
                <div class="field-pillar-card">
                    <?php if ( isset( $route_images[ $route['slug'] ] ) ) : ?>
                    <div class="field-route-img">
                        <img src="<?php echo esc_url( $route_images[ $route['slug'] ] ); ?>" alt="<?php echo esc_attr( $route['name'] ); ?>" loading="lazy" />
                    </div>
                    <?php endif; ?>
                    <div class="field-pillar-card-body">
                        <div class="field-pillar-card-eyebrow"><?php echo esc_html( $route['tagline'] ); ?></div>
                        <h3 class="field-pillar-card-title"><?php echo esc_html( $route['name'] ); ?></h3>
                        <div class="field-route-meta">
                            <span><?php echo $icons['clock']; ?> <?php echo esc_html( $route['days'] ); ?></span>
                            <span><?php echo $icons['activity']; ?> <?php echo esc_html( $route['difficulty'] ); ?></span>
                        </div>
                        <p class="field-pillar-card-desc"><?php echo esc_html( $route['desc'] ); ?></p>
                        <div class="field-route-footer">
                            <span>Scenery: <?php echo esc_html( $route['scenery'] ); ?></span>
                            <span style="font-weight: 600; color: var(--field-earth);">Success: <?php echo esc_html( $route['success'] ); ?></span>
                        </div>
                    </div>
                    <a href="/trekking/kilimanjaro/<?php echo esc_attr( $route['slug'] ); ?>" class="field-pillar-card-link">View Route Details <?php echo $icons['arrow']; ?></a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="field-pullquote">
            <p class="field-pullquote-text">"Standing on the roof of Africa at dawn, watching the shadow of Kilimanjaro stretch across the plains below — that is a moment that changes you forever."</p>
            <span class="field-pullquote-attr">Tanzania Sensational Guides</span>
        </section>

        <section class="field-chapter field-section-alt">
            <span class="field-chapter-eyebrow">Plan Your Expedition</span>
            <h2 class="field-chapter-title">Preparation <em>Guides</em></h2>
            <p class="field-chapter-body">Proper preparation is the difference between a successful summit and a disappointing turn-around. These guides cover everything from choosing your route to understanding the costs.</p>
            <div class="field-pillar-grid field-pillar-grid-3">
                <?php foreach ( $prep_topics as $topic ) : ?>
                <div class="field-pillar-card">
                    <div class="field-pillar-card-body">
                        <span class="field-pillar-card-icon"><?php echo $icons[ $topic['icon'] ]; ?></span>
                        <h3 class="field-pillar-card-title"><?php echo esc_html( $topic['label'] ); ?></h3>
                        <p class="field-pillar-card-desc"><?php echo esc_html( $topic['desc'] ); ?></p>
                    </div>
                    <a href="/trekking/prep/<?php echo esc_attr( $topic['slug'] ); ?>" class="field-pillar-card-link">Read Guide <?php echo $icons['arrow']; ?></a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="field-chapter">
            <span class="field-chapter-eyebrow">Stay Safe at Altitude</span>
            <h2 class="field-chapter-title">Health & <em>Safety</em></h2>
            <p class="field-chapter-body">Altitude sickness is the most common reason for unsuccessful summits. Understanding the risks and how to mitigate them is essential for a safe and enjoyable climb.</p>
            <div class="field-pillar-grid field-pillar-grid-4">
                <?php foreach ( $health_topics as $topic ) : ?>
                <div class="field-pillar-card">
                    <div class="field-pillar-card-body">
                        <span class="field-pillar-card-icon"><?php echo $icons[ $topic['icon'] ]; ?></span>
                        <h3 class="field-pillar-card-title"><?php echo esc_html( $topic['label'] ); ?></h3>
                        <p class="field-pillar-card-desc"><?php echo esc_html( $topic['desc'] ); ?></p>
                    </div>
                    <a href="/trekking/health/<?php echo esc_attr( $topic['slug'] ); ?>" class="field-pillar-card-link">Read Guide <?php echo $icons['arrow']; ?></a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="field-chapter field-section-alt">
            <span class="field-chapter-eyebrow">After You Book</span>
            <h2 class="field-chapter-title">Post-Booking <em>Essentials</em></h2>
            <p class="field-chapter-body">Once you have booked your Kilimanjaro climb, use these guides to prepare physically, pack correctly, and plan your travel logistics.</p>
            <div class="field-pillar-grid field-pillar-grid-4">
                <?php foreach ( $after_topics as $topic ) : ?>
                <div class="field-pillar-card">
                    <div class="field-pillar-card-body">
                        <span class="field-pillar-card-icon"><?php echo $icons[ $topic['icon'] ]; ?></span>
                        <h3 class="field-pillar-card-title"><?php echo esc_html( $topic['label'] ); ?></h3>
                        <p class="field-pillar-card-desc"><?php echo esc_html( $topic['desc'] ); ?></p>
                    </div>
                    <a href="/trekking/after/<?php echo esc_attr( $topic['slug'] ); ?>" class="field-pillar-card-link">Read Guide <?php echo $icons['arrow']; ?></a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="field-chapter">
            <span class="field-chapter-eyebrow">Life on the Mountain</span>
            <h2 class="field-chapter-title">What to Expect <em>During</em> Your Climb</h2>
            <p class="field-chapter-body">Understanding the daily rhythm of a Kilimanjaro expedition helps you prepare mentally and physically for the adventure ahead.</p>
            <div class="field-pillar-grid field-pillar-grid-4">
                <?php foreach ( $during_topics as $topic ) : ?>
                <div class="field-pillar-card">
                    <div class="field-pillar-card-body">
                        <span class="field-pillar-card-icon"><?php echo $icons[ $topic['icon'] ]; ?></span>
                        <h3 class="field-pillar-card-title"><?php echo esc_html( $topic['label'] ); ?></h3>
                        <p class="field-pillar-card-desc"><?php echo esc_html( $topic['desc'] ); ?></p>
                    </div>
                    <a href="/trekking/during/<?php echo esc_attr( $topic['slug'] ); ?>" class="field-pillar-card-link">Read Guide <?php echo $icons['arrow']; ?></a>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="field-chapter field-section-alt">
            <span class="field-chapter-eyebrow">Quick Answers</span>
            <h2 class="field-chapter-title">Frequently Asked <em>Questions</em></h2>
            <div class="field-pillar-faq">
                <div class="field-pillar-faq-item">
                    <h3>Do I need climbing experience to summit Kilimanjaro?</h3>
                    <p>No. Kilimanjaro is a trek, not a technical climb. The standard routes require no ropes, crampons, or prior mountaineering experience. However, you need good physical fitness, proper preparation, and mental determination.</p>
                </div>
                <div class="field-pillar-faq-item">
                    <h3>What is the success rate for summiting Kilimanjaro?</h3>
                    <p>Overall success rates average 65–85%, but vary significantly by route. Longer routes with better acclimatization (Lemosho, Northern Circuit) achieve 90%+ success rates, while shorter routes (Marangu, Umbwe) have lower rates around 50–70%.</p>
                </div>
                <div class="field-pillar-faq-item">
                    <h3>How much does it cost to climb Kilimanjaro?</h3>
                    <p>Prices range from $2,000–$6,000 depending on route duration, group size, and included services. Our group departures offer the best value. See our <a href="/trekking/prep/park-fees">park fees guide</a> for a detailed cost breakdown.</p>
                </div>
                <div class="field-pillar-faq-item">
                    <h3>When is the best time to climb Kilimanjaro?</h3>
                    <p>The best climbing windows are January–March and June–October. These months offer the most stable weather and highest summit success rates. See our <a href="/trekking/prep/best-time">best time to climb guide</a> for detailed seasonal analysis.</p>
                </div>
            </div>
            <div style="text-align: center; margin-top: 60px;">
                <a href="/faq" class="field-btn">View All FAQs <?php echo $icons['chevron']; ?></a>
            </div>
        </section>

        <section class="field-cta">
            <h2 class="field-cta-title">Ready for the <em>Adventure?</em></h2>
            <p class="field-cta-body">Whether you have a specific route in mind or need help choosing the perfect Kilimanjaro climb, our expert team is here to help make your summit dream a reality.</p>
            <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
                <a href="/group-departures" class="field-btn">View Group Departures <?php echo $icons['arrow']; ?></a>
                <a href="/contact" class="field-btn" style="border-color: var(--field-gold); color: var(--field-gold);">Contact Our Team</a>
            </div>
        </section>
    </div>
    <?php
    return ob_get_clean();
} );

add_shortcode( 'ts_gear_checklist_page', function() {
    $hero = 'https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=2000&auto=format&fit=crop';

    $gear = array(
        'Clothing' => array(
            'Moisture-wicking base layers (top & bottom)',
            'Insulating mid-layer fleece',
            'Down or synthetic jacket',
            'Waterproof / windproof jacket and pants',
            'Trekking trousers',
            'Thermal underwear for summit night',
            'Sun hat and warm beanie',
            'Buff / neck gaiter',
            'Warm gloves and waterproof shell mittens',
        ),
        'Footwear' => array(
            'Waterproof hiking boots (broken in)',
            'Camp shoes / trainers',
            'Wool or synthetic trekking socks (multiple pairs)',
            'Gaiters',
        ),
        'Equipment' => array(
            'Sleeping bag rated to -10°C or lower',
            'Sleeping pad / mat',
            'Trekking poles',
            'Headlamp with extra batteries',
            'Sunglasses (UV400) and ski goggles',
            'Daypack (25–35 L)',
            'Duffel bag (max 15 kg)',
            'Water bottles / hydration system',
        ),
        'Accessories' => array(
            'Camera and extra batteries',
            'Binoculars',
            'Snacks / energy bars',
            'Power bank and charging cables',
            'Dry bags / waterproof stuff sacks',
            'Personal first-aid kit',
        ),
        'Toiletries / Medical' => array(
            'Sunscreen (SPF 50+)',
            'Lip balm with SPF',
            'Insect repellent',
            'Toilet paper and wet wipes',
            'Hand sanitizer',
            'Personal medications',
            'Diamox (if prescribed)',
            'Water purification tablets',
        ),
    );

    ob_start();
    ?>
    <div class="utility-root">
        <section class="utility-hero">
            <div class="utility-hero-bg">
                <img src="<?php echo esc_url( $hero ); ?>" alt="Kilimanjaro mountain gear — trekking equipment and clothing checklist" />
            </div>
            <div class="utility-hero-overlay"></div>
            <div class="utility-hero-content">
                <span class="utility-hero-eyebrow">Preparation</span>
                <h1 class="utility-hero-title">Gear Checklist</h1>
                <p class="utility-hero-subtitle">From the tropical rainforest to the arctic summit, climbing Kilimanjaro requires a highly adaptable layering system. Make sure you don't compromise on the essentials.</p>
            </div>
        </section>

        <section class="utility-content">
            <div style="text-align: center; margin-bottom: 40px;">
                <div id="gear-progress" style="display: inline-flex; align-items: center; gap: 16px; padding: 16px 24px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); border-radius: 99px;">
                    <span style="font-size: 0.85rem; color: rgba(255,255,255,0.6);">Packed: <strong id="gear-count" style="color: var(--gold);">0 / 0</strong></span>
                    <div style="width: 160px; height: 4px; background: rgba(255,255,255,0.1); border-radius: 2px; overflow: hidden;">
                        <div id="gear-bar" style="width: 0%; height: 100%; background: var(--gold); transition: width 0.3s ease;"></div>
                    </div>
                </div>
            </div>

            <div class="utility-grid" id="gear-grid">
                <?php foreach ( $gear as $category => $items ) : ?>
                <div class="util-card" data-category="<?php echo esc_attr( $category ); ?>">
                    <h3 class="util-card-title"><?php echo esc_html( $category ); ?></h3>
                    <div class="gear-list">
                        <?php foreach ( $items as $idx => $item ) :
                            $id = 'gear-' . sanitize_title( $category ) . '-' . $idx;
                        ?>
                        <div class="gear-item">
                            <input type="checkbox" id="<?php echo esc_attr( $id ); ?>" data-item="<?php echo esc_attr( $item ); ?>" />
                            <label for="<?php echo esc_attr( $id ); ?>"><?php echo esc_html( $item ); ?></label>
                            <input type="number" min="0" max="20" value="0" aria-label="Rental quantity for <?php echo esc_attr( $item ); ?>" />
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="util-card" style="margin-top: 40px;">
                <h3 class="util-card-title">Request gear rental</h3>
                <p style="color: rgba(255,255,255,0.65); line-height: 1.7; margin-bottom: 20px;">Select quantities above (0 means you do not need to rent that item), then submit your request. We'll confirm availability and pricing by email. No online payment.</p>
                <form class="gear-form" id="gear-rental-form" action="/contact" method="post">
                    <div class="gear-form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <label><span>Full name *</span><input type="text" name="customer_name" required /></label>
                        <label><span>Email *</span><input type="email" name="email" required /></label>
                    </div>
                    <label style="display: grid; gap: 6px; margin-top: 16px;"><span>Booking reference (optional)</span><input type="text" name="booking_ref" placeholder="TS-XXXXXXXX" /></label>
                    <div id="gear-request-message" style="margin-top: 16px; color: rgba(255,255,255,0.8);"></div>
                    <button type="submit" id="gear-submit" style="margin-top: 20px;">Submit rental request</button>
                </form>
            </div>
        </section>
    </div>
    <script>
    (function(){
        const STORAGE_KEY = 'tsGearPacked_v1';
        const checkboxes = document.querySelectorAll('#gear-grid input[type="checkbox"]');
        const countEl = document.getElementById('gear-count');
        const barEl = document.getElementById('gear-bar');
        const form = document.getElementById('gear-rental-form');
        const msgEl = document.getElementById('gear-request-message');
        const submitBtn = document.getElementById('gear-submit');
        const total = checkboxes.length;
        let packed = {};
        try { packed = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}'); } catch(e){}

        function updateProgress(){
            let checked = 0;
            checkboxes.forEach(function(cb){ if(cb.checked) checked++; });
            countEl.textContent = checked + ' / ' + total;
            barEl.style.width = Math.round((checked / total) * 100) + '%';
        }

        checkboxes.forEach(function(cb){
            cb.checked = !!packed[cb.id];
            cb.addEventListener('change', function(){
                packed[cb.id] = cb.checked;
                localStorage.setItem(STORAGE_KEY, JSON.stringify(packed));
                updateProgress();
            });
        });
        updateProgress();

        form.addEventListener('submit', function(e){
            e.preventDefault();
            const quantities = [];
            document.querySelectorAll('#gear-grid input[type="number"]').forEach(function(input){
                const val = parseInt(input.value, 10);
                if (val > 0) {
                    const item = input.previousElementSibling.previousElementSibling.dataset.item;
                    quantities.push(item + ' × ' + val);
                }
            });
            if (quantities.length === 0) {
                msgEl.textContent = 'Please select at least one rental item and quantity.';
                return;
            }
            submitBtn.disabled = true;
            submitBtn.textContent = 'Submitting…';
            setTimeout(function(){
                msgEl.innerHTML = 'Thank you. Your rental request has been received. Our team will confirm availability and pricing by email within 24 hours.';
                submitBtn.textContent = 'Request sent';
            }, 800);
        });
    })();
    </script>
    <?php
    return ob_get_clean();
} );

add_shortcode( 'ts_training_guide_page', function() {
    $hero = 'https://images.unsplash.com/photo-1526772662000-3f88f10405ff?q=80&w=2000&auto=format&fit=crop';

    $steps = array(
        array(
            'num'   => '1',
            'title' => 'Cardio Base (12-8 Weeks Out)',
            'body'  => 'Focus on building raw cardiovascular endurance.',
            'items' => array(
                'Running, cycling, or swimming 3-4 times a week for 45-60 minutes.',
                'Maintain a moderate, conversational heart rate.',
            ),
        ),
        array(
            'num'   => '2',
            'title' => 'Hill Training (8-4 Weeks Out)',
            'body'  => 'Simulate the mountain terrain by adding elevation.',
            'items' => array(
                'Find the longest, steepest local hills or hit the stair-master.',
                'Begin carrying a daypack with 5kg-8kg (10-15 lbs) of weight.',
                'Do at least one long hike (4+ hours) per week.',
            ),
        ),
        array(
            'num'   => '3',
            'title' => 'The Taper (Last 3 Weeks)',
            'body'  => 'Rest and recovery are just as important as the training.',
            'items' => array(
                'Week 3: Reduce training volume by 25%.',
                'Week 2: Reduce volume by 50%. Focus on stretching.',
                'Week 1: Active rest. Light walking only. Arrive fresh.',
            ),
        ),
    );

    ob_start();
    ?>
    <div class="utility-root">
        <section class="utility-hero">
            <div class="utility-hero-bg">
                <img src="<?php echo esc_url( $hero ); ?>" alt="Kilimanjaro training preparation — hiker on a trail building endurance" />
            </div>
            <div class="utility-hero-overlay"></div>
            <div class="utility-hero-content">
                <span class="utility-hero-eyebrow">Preparation</span>
                <h1 class="utility-hero-title">Training Guide</h1>
                <p class="utility-hero-subtitle">Kilimanjaro is a non-technical hike, but you are trekking at extreme altitude for multiple days. Cardiovascular endurance and leg strength are paramount.</p>
            </div>
        </section>

        <section class="utility-content">
            <div class="utility-grid">
                <?php foreach ( $steps as $step ) : ?>
                <div class="util-card">
                    <div class="util-card-icon"><span style="font-size: 1.5rem; font-weight: bold;"><?php echo esc_html( $step['num'] ); ?></span></div>
                    <h3 class="util-card-title"><?php echo esc_html( $step['title'] ); ?></h3>
                    <p class="util-card-p"><?php echo esc_html( $step['body'] ); ?></p>
                    <ul class="util-card-list">
                        <?php foreach ( $step['items'] as $item ) : ?>
                        <li><?php echo esc_html( $item ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>
    <?php
    return ob_get_clean();
} );

add_shortcode( 'ts_safari_addons_page', function() {
    $hero    = 'https://images.unsplash.com/photo-1547970810-dc1eac37d174?q=80&w=2000&auto=format&fit=crop';
    $crater  = 'https://images.unsplash.com/photo-1516422213484-2af298bf06ad?auto=format&fit=crop&q=80';
    $zanzibar = 'https://images.unsplash.com/photo-1621845184551-bb5e7141ecf4?auto=format&fit=crop&q=80';

    ob_start();
    ?>
    <div class="utility-root">
        <section class="utility-hero">
            <div class="utility-hero-bg">
                <img src="<?php echo esc_url( $hero ); ?>" alt="Tanzania safari add-on — wildlife viewing on the Serengeti plains" />
            </div>
            <div class="utility-hero-overlay"></div>
            <div class="utility-hero-content">
                <span class="utility-hero-eyebrow">The Reward</span>
                <h1 class="utility-hero-title">Post-Trek Safari Add-ons</h1>
                <p class="utility-hero-subtitle">You conquered the Roof of Africa. Now rest your legs in the back of a luxury 4x4 and witness the greatest wildlife spectacle on earth.</p>
            </div>
        </section>

        <section class="utility-content">
            <div class="utility-grid utility-grid-2">
                <div class="util-card" style="padding: 0; overflow: hidden;">
                    <img src="<?php echo esc_url( $crater ); ?>" alt="Ngorongoro Crater in Tanzania" style="width: 100%; height: 300px; object-fit: cover;" loading="lazy" />
                    <div style="padding: 40px;">
                        <h3 class="util-card-title">2-Day Tarangire & Ngorongoro</h3>
                        <p class="util-card-p" style="margin-bottom: 20px;">The perfect taste of the wild for those short on time. Witness the massive elephant herds of Tarangire before descending into the legendary Ngorongoro Crater in search of the Big Five.</p>
                        <a href="/safaris/packages" class="dep-btn" style="border: none; padding: 0; text-decoration: underline; text-underline-offset: 6px;">View Safari Packages</a>
                    </div>
                </div>
                <div class="util-card" style="padding: 0; overflow: hidden;">
                    <img src="<?php echo esc_url( $zanzibar ); ?>" alt="Zanzibar beaches" style="width: 100%; height: 300px; object-fit: cover;" loading="lazy" />
                    <div style="padding: 40px;">
                        <h3 class="util-card-title">Zanzibar Beach Recovery</h3>
                        <p class="util-card-p" style="margin-bottom: 20px;">Trade your hiking boots for bare feet. A direct flight from Arusha lands you on the pristine white sands of the Spice Island. The ultimate relaxation after the rigors of the mountain.</p>
                        <a href="/zanzibar" class="dep-btn" style="border: none; padding: 0; text-decoration: underline; text-underline-offset: 6px;">Explore Zanzibar</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php
    return ob_get_clean();
} );
