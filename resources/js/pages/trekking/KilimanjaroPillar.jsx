import React from 'react';
import { motion } from 'framer-motion';
import { Link } from '@inertiajs/react';
import { usePage } from '@inertiajs/react';
import {
    Mountain, Clock, Activity, Shield, Map,
    Compass, BookOpen, ArrowRight, Sun,
    Heart, Luggage, Users, ChevronRight
} from 'lucide-react';
import { visualsData } from '../../data/visualsData';
import OptimizedImage from '../../components/ui/OptimizedImage';
import '../../styles/ultra-premium.css';

const KilimanjaroPillar = () => {
    const { props } = usePage();
    const visuals = props.visuals;

    const getVisual = (section, fallback) => {
        if (visuals?.[section]?.[0]) return visuals[section][0];
        return fallback;
    };

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const stagger = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.1 } }
    };

    const routes = [
        { slug: 'lemosho', name: 'Lemosho Route', tagline: 'The Western Approach', days: '7-8 days', difficulty: 'Moderate', scenery: '★★★★★', success: 'Very High', desc: 'Our most recommended route. The Lemosho offers superb scenery, excellent acclimatization, and high summit success rates.' },
        { slug: 'machame', name: 'Machame Route', tagline: 'The Whiskey Route', days: '6-7 days', difficulty: 'Moderate-Challenging', scenery: '★★★★★', success: 'High', desc: 'The most popular route on Kilimanjaro. Known for stunning scenery and a challenging but rewarding climb.' },
        { slug: 'northern-circuit', name: 'Northern Circuit', tagline: 'The Long & Scenic', days: '9 days', difficulty: 'Moderate', scenery: '★★★★★', success: 'Very High', desc: 'The newest route on Kilimanjaro. Nine days on the mountain with exceptional acclimatization and remote wilderness.' },
        { slug: 'marangu', name: 'Marangu Route', tagline: 'The Coca-Cola Route', days: '5-6 days', difficulty: 'Moderate', scenery: '★★★☆☆', success: 'Moderate', desc: 'The only route with hut accommodation. A classic climb with a shorter duration but lower success rate.' },
        { slug: 'rongai', name: 'Rongai Route', tagline: 'The Northern Approach', days: '6-7 days', difficulty: 'Moderate', scenery: '★★★★☆', success: 'High', desc: 'The only route approaching from the north. Offers a unique perspective and drier conditions during rainy seasons.' },
        { slug: 'umbwe', name: 'Umbwe Route', tagline: 'The Challenger', days: '5-6 days', difficulty: 'Challenging', scenery: '★★★★☆', success: 'Low-Moderate', desc: 'The steepest and most technical route. For experienced trekkers seeking a physical challenge.' },
    ];

    const prepTopics = [
        { slug: 'best-routes', label: 'How to Choose the Best Route', icon: Compass, desc: 'Compare all 6 routes side-by-side to find your perfect match.' },
        { slug: 'best-time', label: 'Best Time to Climb Kilimanjaro', icon: Sun, desc: 'Understand seasonal weather patterns and choose your ideal climbing window.' },
        { slug: 'why-us', label: 'Why Choose Tanzania Sensational', icon: Heart, desc: 'Our safety record, guide expertise, and commitment to responsible tourism.' },
        { slug: 'tipping-guide', label: 'Tipping Guide', icon: Users, desc: 'Fair tipping guidelines for your mountain support team.' },
        { slug: 'park-fees', label: 'Kilimanjaro Park Fees', icon: BookOpen, desc: 'Breakdown of KINAPA park fees and what they cover.' },
        { slug: 'toilets', label: 'Toilets on Kilimanjaro', icon: Map, desc: 'What to expect and how to prepare for bathroom facilities on the mountain.' },
    ];

    const healthTopics = [
        { slug: 'vaccinations', label: 'Vaccinations & Health Prep', icon: Shield, desc: 'Required and recommended vaccinations before your climb.' },
        { slug: 'altitude-sickness', label: 'Altitude Sickness Guide', icon: Activity, desc: 'Recognize, prevent, and manage Acute Mountain Sickness (AMS).' },
        { slug: 'diamox', label: 'Diamox for Altitude', icon: Heart, desc: 'Everything you need to know about acetazolamide for altitude acclimatization.' },
        { slug: 'oxygen', label: 'Oxygen on Kilimanjaro', icon: Mountain, desc: 'When and how supplemental oxygen is used on the mountain.' },
    ];

    const afterTopics = [
        { slug: 'training', label: 'Training for Kilimanjaro', icon: Activity, desc: 'A 12-week training program to prepare your body for summit day.' },
        { slug: 'gear-list', label: 'Gear List & Packing', icon: Luggage, desc: 'Complete packing checklist for your Kilimanjaro expedition.' },
        { slug: 'getting-there', label: 'Getting to Kilimanjaro', icon: Map, desc: 'Flights, visas, and arrival logistics for Kilimanjaro International Airport.' },
        { slug: 'visa', label: 'Visa Information', icon: BookOpen, desc: 'Tanzania visa requirements and application process.' },
    ];

    const duringTopics = [
        { slug: 'daily-routine', label: 'Daily Routine on the Mountain', icon: Clock, desc: 'What a typical day looks like during your Kilimanjaro climb.' },
        { slug: 'food-and-drinks', label: 'Food & Drinks', icon: Heart, desc: 'Nutrition and hydration strategies for high-altitude trekking.' },
        { slug: 'pack-your-daypack', label: 'Pack Your Daypack', icon: Luggage, desc: 'What to carry each day and how to organize your daypack.' },
        { slug: 'connectivity', label: 'Connectivity on the Mountain', icon: Sun, desc: 'Phone signal, Wi-Fi, and staying connected during your climb.' },
    ];

    return (
        <div className="lux-root">
            {/* ─── HERO ─── */}
            <section className="lux-hero">
                <OptimizedImage
                    src={getVisual('trekking.pillar.hero', visualsData.trekking?.routes?.lemosho || 'https://images.unsplash.com/photo-1585409677983-0f6c41ca9c3b?w=1600')}
                    alt="Kilimanjaro Trekking — The Ultimate Guide"
                    priority={true}
                    aspectRatio="16/9"
                />
                <div className="lux-hero-overlay"></div>
                <div className="lux-hero-content">
                    <motion.span className="lux-hero-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>The Complete Guide</motion.span>
                    <motion.h1 className="lux-hero-title" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.1 }}>
                        Kilimanjaro <em>Trekking.</em>
                    </motion.h1>
                    <motion.p className="lux-hero-sub" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.2 }}>
                        Everything you need to plan, prepare, and conquer Africa's highest peak.
                    </motion.p>
                </div>
            </section>

            {/* ─── INTRO ─── */}
            <section className="lux-section lux-section-light">
                <div className="lux-container lux-container-narrow">
                    <motion.div
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: '-100px' }}
                        variants={fadeInUp}
                    >
                        <span className="lux-eyebrow">Mount Kilimanjaro</span>
                        <h2 className="lux-heading">Africa's Roof, Your Summit</h2>
                        <p className="lux-body">
                            At 5,895 metres (19,341 feet), Mount Kilimanjaro is the highest free-standing mountain in the world and 
                            the tallest peak in Africa. Located in northeastern Tanzania near the town of Moshi, this dormant volcano 
                            attracts over 35,000 trekkers each year from around the globe.
                        </p>
                        <p className="lux-body">
                            Climbing Kilimanjaro does not require technical mountaineering skills — no ropes, crampons, or ice axes 
                            are needed on the standard routes. What it does require is proper preparation, the right gear, a positive 
                            mindset, and a reputable operator who prioritises your safety and success. This guide covers everything 
                            you need to know to make your Kilimanjaro dream a reality.
                        </p>
                    </motion.div>
                </div>
            </section>

            {/* ─── ROUTE COMPARISON ─── */}
            <section className="lux-section">
                <div className="lux-container">
                    <motion.div
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: '-100px' }}
                        variants={fadeInUp}
                    >
                        <span className="lux-eyebrow">Choose Your Path</span>
                        <h2 className="lux-heading">Kilimanjaro Climbing Routes</h2>
                        <p className="lux-body lux-body-center">
                            Each route offers a unique experience. Compare them below to find the one that matches your 
                            fitness level, schedule, and adventure style.
                        </p>
                    </motion.div>

                    <motion.div 
                        className="lux-grid lux-grid-3"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: '-100px' }}
                        variants={stagger}
                    >
                        {routes.map((route) => (
                            <motion.div key={route.slug} className="lux-card lux-card-hover" variants={fadeInUp}>
                                <div className="lux-card-body">
                                    <div className="lux-card-eyebrow">{route.tagline}</div>
                                    <h3 className="lux-card-title">{route.name}</h3>
                                    <div className="lux-card-stats">
                                        <span><Clock size={14} /> {route.days}</span>
                                        <span><Activity size={14} /> {route.difficulty}</span>
                                    </div>
                                    <p className="lux-card-desc">{route.desc}</p>
                                    <div className="lux-card-meta">
                                        <span>Scenery: {route.scenery}</span>
                                        <span>Success: {route.success}</span>
                                    </div>
                                </div>
                                <Link href={`/trekking/kilimanjaro/${route.slug}`} className="lux-card-link">
                                    View Route Details <ArrowRight size={14} />
                                </Link>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* ─── PREPARATION ─── */}
            <section className="lux-section lux-section-alt">
                <div className="lux-container">
                    <motion.div
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: '-100px' }}
                        variants={fadeInUp}
                    >
                        <span className="lux-eyebrow">Plan Your Expedition</span>
                        <h2 className="lux-heading">Preparation Guides</h2>
                        <p className="lux-body lux-body-center">
                            Proper preparation is the difference between a successful summit and a disappointing turn-around. 
                            These guides cover everything from choosing your route to understanding the costs.
                        </p>
                    </motion.div>

                    <motion.div 
                        className="lux-grid lux-grid-3"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: '-100px' }}
                        variants={stagger}
                    >
                        {prepTopics.map((topic) => (
                            <motion.div key={topic.slug} className="lux-card lux-card-hover" variants={fadeInUp}>
                                <div className="lux-card-body">
                                    <topic.icon size={24} className="lux-card-icon" />
                                    <h3 className="lux-card-title">{topic.label}</h3>
                                    <p className="lux-card-desc">{topic.desc}</p>
                                </div>
                                <Link href={`/trekking/prep/${topic.slug}`} className="lux-card-link">
                                    Read Guide <ArrowRight size={14} />
                                </Link>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* ─── HEALTH & SAFETY ─── */}
            <section className="lux-section">
                <div className="lux-container">
                    <motion.div
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: '-100px' }}
                        variants={fadeInUp}
                    >
                        <span className="lux-eyebrow">Stay Safe at Altitude</span>
                        <h2 className="lux-heading">Health & Safety</h2>
                        <p className="lux-body lux-body-center">
                            Altitude sickness is the most common reason for unsuccessful summits. Understanding the risks 
                            and how to mitigate them is essential for a safe and enjoyable climb.
                        </p>
                    </motion.div>

                    <motion.div 
                        className="lux-grid lux-grid-4"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: '-100px' }}
                        variants={stagger}
                    >
                        {healthTopics.map((topic) => (
                            <motion.div key={topic.slug} className="lux-card lux-card-hover" variants={fadeInUp}>
                                <div className="lux-card-body">
                                    <topic.icon size={24} className="lux-card-icon" />
                                    <h3 className="lux-card-title">{topic.label}</h3>
                                    <p className="lux-card-desc">{topic.desc}</p>
                                </div>
                                <Link href={`/trekking/health/${topic.slug}`} className="lux-card-link">
                                    Read Guide <ArrowRight size={14} />
                                </Link>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* ─── AFTER BOOKING ─── */}
            <section className="lux-section lux-section-alt">
                <div className="lux-container">
                    <motion.div
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: '-100px' }}
                        variants={fadeInUp}
                    >
                        <span className="lux-eyebrow">After You Book</span>
                        <h2 className="lux-heading">Post-Booking Essentials</h2>
                        <p className="lux-body lux-body-center">
                            Once you have booked your Kilimanjaro climb, use these guides to prepare physically, pack correctly, 
                            and plan your travel logistics.
                        </p>
                    </motion.div>

                    <motion.div 
                        className="lux-grid lux-grid-4"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: '-100px' }}
                        variants={stagger}
                    >
                        {afterTopics.map((topic) => (
                            <motion.div key={topic.slug} className="lux-card lux-card-hover" variants={fadeInUp}>
                                <div className="lux-card-body">
                                    <topic.icon size={24} className="lux-card-icon" />
                                    <h3 className="lux-card-title">{topic.label}</h3>
                                    <p className="lux-card-desc">{topic.desc}</p>
                                </div>
                                <Link href={`/trekking/after/${topic.slug}`} className="lux-card-link">
                                    Read Guide <ArrowRight size={14} />
                                </Link>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* ─── ON THE MOUNTAIN ─── */}
            <section className="lux-section">
                <div className="lux-container">
                    <motion.div
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: '-100px' }}
                        variants={fadeInUp}
                    >
                        <span className="lux-eyebrow">Life on the Mountain</span>
                        <h2 className="lux-heading">What to Expect During Your Climb</h2>
                        <p className="lux-body lux-body-center">
                            Understanding the daily rhythm of a Kilimanjaro expedition helps you prepare mentally and physically 
                            for the adventure ahead.
                        </p>
                    </motion.div>

                    <motion.div 
                        className="lux-grid lux-grid-4"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: '-100px' }}
                        variants={stagger}
                    >
                        {duringTopics.map((topic) => (
                            <motion.div key={topic.slug} className="lux-card lux-card-hover" variants={fadeInUp}>
                                <div className="lux-card-body">
                                    <topic.icon size={24} className="lux-card-icon" />
                                    <h3 className="lux-card-title">{topic.label}</h3>
                                    <p className="lux-card-desc">{topic.desc}</p>
                                </div>
                                <Link href={`/trekking/during/${topic.slug}`} className="lux-card-link">
                                    Read Guide <ArrowRight size={14} />
                                </Link>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* ─── GROUP DEPARTURES CTA ─── */}
            <section className="lux-section lux-section-dark">
                <div className="lux-container lux-container-narrow">
                    <motion.div
                        className="lux-cta"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: '-100px' }}
                        variants={fadeInUp}
                    >
                        <span className="lux-eyebrow lux-eyebrow-light">Ready to Climb?</span>
                        <h2 className="lux-heading lux-heading-light">Join a Group Departure</h2>
                        <p className="lux-body lux-body-light">
                            Our scheduled group departures offer fixed dates, shared costs, and the camaraderie of climbing 
                            with fellow adventurers from around the world. Browse upcoming departures and secure your spot.
                        </p>
                        <div className="lux-cta-actions">
                            <Link href="/group-departures" className="lux-btn lux-btn-primary">
                                View Group Departures <ArrowRight size={16} />
                            </Link>
                            <Link href="/booking" className="lux-btn lux-btn-outline">
                                Book Your Climb
                            </Link>
                        </div>
                    </motion.div>
                </div>
            </section>

            {/* ─── FAQ SNIPPET ─── */}
            <section className="lux-section lux-section-light">
                <div className="lux-container lux-container-narrow">
                    <motion.div
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: '-100px' }}
                        variants={fadeInUp}
                    >
                        <span className="lux-eyebrow">Quick Answers</span>
                        <h2 className="lux-heading">Frequently Asked Questions</h2>
                        
                        <div className="lux-faq-list">
                            <div className="lux-faq-item">
                                <h3>Do I need climbing experience to summit Kilimanjaro?</h3>
                                <p>No. Kilimanjaro is a trek, not a technical climb. The standard routes require no ropes, crampons, or prior mountaineering experience. However, you need good physical fitness, proper preparation, and mental determination.</p>
                            </div>
                            <div className="lux-faq-item">
                                <h3>What is the success rate for summiting Kilimanjaro?</h3>
                                <p>Overall success rates average 65-85%, but vary significantly by route. Longer routes with better acclimatization (Lemosho, Northern Circuit) achieve 90%+ success rates, while shorter routes (Marangu, Umbwe) have lower rates around 50-70%.</p>
                            </div>
                            <div className="lux-faq-item">
                                <h3>How much does it cost to climb Kilimanjaro?</h3>
                                <p>Prices range from $2,000-$6,000 depending on route duration, group size, and included services. Our group departures offer the best value. See our <Link href="/trekking/prep/park-fees">park fees guide</Link> for a detailed cost breakdown.</p>
                            </div>
                            <div className="lux-faq-item">
                                <h3>When is the best time to climb Kilimanjaro?</h3>
                                <p>The best climbing windows are January-March and June-October. These months offer the most stable weather and highest summit success rates. See our <Link href="/trekking/prep/best-time">best time to climb guide</Link> for detailed seasonal analysis.</p>
                            </div>
                        </div>

                        <div className="lux-cta-actions lux-cta-centered">
                            <Link href="/faq" className="lux-btn lux-btn-secondary">
                                View All FAQs <ChevronRight size={16} />
                            </Link>
                        </div>
                    </motion.div>
                </div>
            </section>
        </div>
    );
};

export default KilimanjaroPillar;
