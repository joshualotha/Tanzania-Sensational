import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link, usePage } from '@inertiajs/react';
import {
    Mountain, Clock, Activity, Shield, Map,
    Compass, BookOpen, ArrowRight, Sun,
    Heart, Luggage, Users, ChevronRight, TrendingUp, Award, Star
} from 'lucide-react';
import { visualsData } from '../../data/visualsData';
import OptimizedImage from '../../components/ui/OptimizedImage';
import '../../styles/safari-field-guide.css';

const KilimanjaroPillar = () => {
    const { props } = usePage();
    const visuals = props.visuals;

    useEffect(() => { window.scrollTo(0, 0); }, []);

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
        { slug: 'lemosho', name: 'Lemosho Route', tagline: 'The Western Approach', days: '7–8 days', difficulty: 'Moderate', scenery: '★★★★★', success: 'Very High', desc: 'Our most recommended route. The Lemosho offers superb scenery, excellent acclimatization, and high summit success rates.', image: visualsData.trekking?.routes?.lemoshoEditorial },
        { slug: 'machame', name: 'Machame Route', tagline: 'The Whiskey Route', days: '6–7 days', difficulty: 'Moderate–Challenging', scenery: '★★★★★', success: 'High', desc: 'The most popular route on Kilimanjaro. Known for stunning scenery and a challenging but rewarding climb.', image: visualsData.trekking?.routes?.machameEditorial },
        { slug: 'northern-circuit', name: 'Northern Circuit', tagline: 'The Long & Scenic', days: '9 days', difficulty: 'Moderate', scenery: '★★★★★', success: 'Very High', desc: 'The newest route on Kilimanjaro. Nine days on the mountain with exceptional acclimatization and remote wilderness.', image: visualsData.trekking?.routes?.northernEditorial },
        { slug: 'marangu', name: 'Marangu Route', tagline: 'The Coca-Cola Route', days: '5–6 days', difficulty: 'Moderate', scenery: '★★★☆☆', success: 'Moderate', desc: 'The only route with hut accommodation. A classic climb with a shorter duration but lower success rate.', image: visualsData.trekking?.routes?.maranguEditorial },
        { slug: 'rongai', name: 'Rongai Route', tagline: 'The Northern Approach', days: '6–7 days', difficulty: 'Moderate', scenery: '★★★★☆', success: 'High', desc: 'The only route approaching from the north. Offers a unique perspective and drier conditions during rainy seasons.', image: null },
        { slug: 'umbwe', name: 'Umbwe Route', tagline: 'The Challenger', days: '5–6 days', difficulty: 'Challenging', scenery: '★★★★☆', success: 'Low–Moderate', desc: 'The steepest and most technical route. For experienced trekkers seeking a physical challenge.', image: null },
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
        <div className="field-root">
            {/* ─── CINEMATIC HERO ─── */}
            <section className="field-hero">
                <div className="field-hero-img">
                    <OptimizedImage
                        src={getVisual('trekking.pillar.hero', visualsData.trekking?.routes?.lemosho || 'https://images.unsplash.com/photo-1585409677983-0f6c41ca9c3b?w=1600')}
                        alt="Kilimanjaro Trekking — The Ultimate Guide to Africa's Highest Peak"
                        priority={true}
                        aspectRatio="16/9"
                    />
                </div>
                <div className="field-hero-gradient"></div>
                <div className="field-hero-content">
                    <motion.div
                        initial="hidden"
                        animate="visible"
                        variants={stagger}
                    >
                        <motion.span className="field-hero-eyebrow" variants={fadeInUp}>The Complete Guide</motion.span>
                        <motion.h1 className="field-hero-title" variants={fadeInUp}>
                            Kilimanjaro <em>Trekking.</em>
                        </motion.h1>
                        <motion.p className="field-hero-subtitle" variants={fadeInUp}>
                            Everything you need to plan, prepare, and conquer Africa's highest peak — from choosing your route to summit day.
                        </motion.p>
                    </motion.div>
                </div>
            </section>

            {/* ─── INTRO CHAPTER ─── */}
            <section className="field-chapter">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">Mount Kilimanjaro</span>
                    <h2 className="field-chapter-title">Africa's Roof, Your <em>Summit</em></h2>
                    <p className="field-chapter-body">
                        At 5,895 metres (19,341 feet), Mount Kilimanjaro is the highest free-standing mountain in the world and
                        the tallest peak in Africa. Located in northeastern Tanzania near the town of Moshi, this dormant volcano
                        attracts over 35,000 trekkers each year from around the globe.
                    </p>
                    <p className="field-chapter-body">
                        Climbing Kilimanjaro does not require technical mountaineering skills — no ropes, crampons, or ice axes
                        are needed on the standard routes. What it does require is proper preparation, the right gear, a positive
                        mindset, and a reputable operator who prioritises your safety and success.
                    </p>
                </motion.div>
            </section>

            {/* ─── STATS STRIP ─── */}
            <section style={{ padding: '0 8vw', marginTop: '-40px', position: 'relative', zIndex: 10 }}>
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-50px' }}
                    variants={fadeInUp}
                    style={{
                        background: '#fff',
                        display: 'grid',
                        gridTemplateColumns: 'repeat(4, 1fr)',
                        border: '1px solid var(--field-border)',
                        padding: '48px 40px',
                        gap: '0',
                    }}
                >
                    {[
                        { value: '5,895m', label: 'Summit Elevation', icon: Mountain },
                        { value: '95%', label: 'Summit Success Rate', icon: TrendingUp },
                        { value: '35,000+', label: 'Trekkers Per Year', icon: Users },
                        { value: '15+', label: 'Years Experience', icon: Award },
                    ].map((stat, i) => (
                        <div key={i} style={{
                            textAlign: 'center',
                            borderRight: i < 3 ? '1px solid var(--field-border)' : 'none',
                            padding: '0 20px',
                        }}>
                            <stat.icon size={20} style={{ color: 'var(--field-gold)', marginBottom: '12px' }} />
                            <div style={{
                                fontFamily: 'var(--field-serif)',
                                fontSize: '2rem',
                                color: 'var(--field-dark)',
                                fontWeight: 400,
                                marginBottom: '8px',
                            }}>{stat.value}</div>
                            <div style={{
                                fontSize: '0.7rem',
                                fontWeight: 700,
                                textTransform: 'uppercase',
                                letterSpacing: '0.2em',
                                color: 'var(--field-mid)',
                            }}>{stat.label}</div>
                        </div>
                    ))}
                </motion.div>
            </section>

            {/* ─── ROUTE COMPARISON ─── */}
            <section className="field-chapter" style={{ paddingTop: '120px' }}>
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">Choose Your Path</span>
                    <h2 className="field-chapter-title">Kilimanjaro Climbing <em>Routes</em></h2>
                    <p className="field-chapter-body">
                        Each route offers a unique experience — different landscapes, difficulty levels, and summit success rates.
                        Compare them below to find the one that matches your fitness level, schedule, and adventure style.
                    </p>
                </motion.div>

                <motion.div
                    className="field-pillar-grid field-pillar-grid-3"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={stagger}
                >
                    {routes.map((route) => (
                        <motion.div key={route.slug} className="field-pillar-card" variants={fadeInUp}>
                            {route.image && (
                                <div style={{ margin: '-32px -28px 20px', overflow: 'hidden', height: '160px' }}>
                                    <img
                                        src={route.image}
                                        alt={`${route.name} — ${route.tagline}`}
                                        style={{ width: '100%', height: '100%', objectFit: 'cover' }}
                                        loading="lazy"
                                    />
                                </div>
                            )}
                            <div className="field-pillar-card-body">
                                <div className="field-pillar-card-eyebrow">{route.tagline}</div>
                                <h3 className="field-pillar-card-title">{route.name}</h3>
                                <div style={{
                                    display: 'flex',
                                    gap: '16px',
                                    margin: '12px 0',
                                    fontSize: '0.78rem',
                                    color: 'var(--field-mid)',
                                }}>
                                    <span style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                                        <Clock size={13} /> {route.days}
                                    </span>
                                    <span style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                                        <Activity size={13} /> {route.difficulty}
                                    </span>
                                </div>
                                <p className="field-pillar-card-desc">{route.desc}</p>
                                <div style={{
                                    display: 'flex',
                                    justifyContent: 'space-between',
                                    marginTop: '16px',
                                    paddingTop: '16px',
                                    borderTop: '1px solid var(--field-border)',
                                    fontSize: '0.78rem',
                                    color: 'var(--field-mid)',
                                }}>
                                    <span>Scenery: {route.scenery}</span>
                                    <span style={{ fontWeight: 600, color: 'var(--field-earth)' }}>Success: {route.success}</span>
                                </div>
                            </div>
                            <Link href={`/trekking/kilimanjaro/${route.slug}`} className="field-pillar-card-link">
                                View Route Details <ArrowRight size={14} />
                            </Link>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ─── PULL QUOTE ─── */}
            <section className="field-pullquote">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <p className="field-pullquote-text">
                        "Standing on the roof of Africa at dawn, watching the shadow of Kilimanjaro stretch across the plains below — that is a moment that changes you forever."
                    </p>
                    <span className="field-pullquote-attr">Tanzania Sensational Guides</span>
                </motion.div>
            </section>

            {/* ─── PREPARATION GUIDES ─── */}
            <section className="field-chapter field-section-alt">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">Plan Your Expedition</span>
                    <h2 className="field-chapter-title">Preparation <em>Guides</em></h2>
                    <p className="field-chapter-body">
                        Proper preparation is the difference between a successful summit and a disappointing turn-around.
                        These guides cover everything from choosing your route to understanding the costs.
                    </p>
                </motion.div>

                <motion.div
                    className="field-pillar-grid field-pillar-grid-3"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={stagger}
                >
                    {prepTopics.map((topic) => (
                        <motion.div key={topic.slug} className="field-pillar-card" variants={fadeInUp}>
                            <div className="field-pillar-card-body">
                                <topic.icon size={24} className="field-pillar-card-icon" />
                                <h3 className="field-pillar-card-title">{topic.label}</h3>
                                <p className="field-pillar-card-desc">{topic.desc}</p>
                            </div>
                            <Link href={`/trekking/prep/${topic.slug}`} className="field-pillar-card-link">
                                Read Guide <ArrowRight size={14} />
                            </Link>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ─── HEALTH & SAFETY ─── */}
            <section className="field-chapter">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">Stay Safe at Altitude</span>
                    <h2 className="field-chapter-title">Health & <em>Safety</em></h2>
                    <p className="field-chapter-body">
                        Altitude sickness is the most common reason for unsuccessful summits. Understanding the risks
                        and how to mitigate them is essential for a safe and enjoyable climb.
                    </p>
                </motion.div>

                <motion.div
                    className="field-pillar-grid field-pillar-grid-4"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={stagger}
                >
                    {healthTopics.map((topic) => (
                        <motion.div key={topic.slug} className="field-pillar-card" variants={fadeInUp}>
                            <div className="field-pillar-card-body">
                                <topic.icon size={24} className="field-pillar-card-icon" />
                                <h3 className="field-pillar-card-title">{topic.label}</h3>
                                <p className="field-pillar-card-desc">{topic.desc}</p>
                            </div>
                            <Link href={`/trekking/health/${topic.slug}`} className="field-pillar-card-link">
                                Read Guide <ArrowRight size={14} />
                            </Link>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ─── AFTER BOOKING ─── */}
            <section className="field-chapter field-section-alt">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">After You Book</span>
                    <h2 className="field-chapter-title">Post-Booking <em>Essentials</em></h2>
                    <p className="field-chapter-body">
                        Once you have booked your Kilimanjaro climb, use these guides to prepare physically, pack correctly,
                        and plan your travel logistics.
                    </p>
                </motion.div>

                <motion.div
                    className="field-pillar-grid field-pillar-grid-4"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={stagger}
                >
                    {afterTopics.map((topic) => (
                        <motion.div key={topic.slug} className="field-pillar-card" variants={fadeInUp}>
                            <div className="field-pillar-card-body">
                                <topic.icon size={24} className="field-pillar-card-icon" />
                                <h3 className="field-pillar-card-title">{topic.label}</h3>
                                <p className="field-pillar-card-desc">{topic.desc}</p>
                            </div>
                            <Link href={`/trekking/after/${topic.slug}`} className="field-pillar-card-link">
                                Read Guide <ArrowRight size={14} />
                            </Link>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ─── ON THE MOUNTAIN ─── */}
            <section className="field-chapter">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">Life on the Mountain</span>
                    <h2 className="field-chapter-title">What to Expect <em>During</em> Your Climb</h2>
                    <p className="field-chapter-body">
                        Understanding the daily rhythm of a Kilimanjaro expedition helps you prepare mentally and physically
                        for the adventure ahead.
                    </p>
                </motion.div>

                <motion.div
                    className="field-pillar-grid field-pillar-grid-4"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={stagger}
                >
                    {duringTopics.map((topic) => (
                        <motion.div key={topic.slug} className="field-pillar-card" variants={fadeInUp}>
                            <div className="field-pillar-card-body">
                                <topic.icon size={24} className="field-pillar-card-icon" />
                                <h3 className="field-pillar-card-title">{topic.label}</h3>
                                <p className="field-pillar-card-desc">{topic.desc}</p>
                            </div>
                            <Link href={`/trekking/during/${topic.slug}`} className="field-pillar-card-link">
                                Read Guide <ArrowRight size={14} />
                            </Link>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ─── FAQ SNIPPET ─── */}
            <section className="field-chapter field-section-alt">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">Quick Answers</span>
                    <h2 className="field-chapter-title">Frequently Asked <em>Questions</em></h2>

                    <div className="field-pillar-faq">
                        <div className="field-pillar-faq-item">
                            <h3>Do I need climbing experience to summit Kilimanjaro?</h3>
                            <p>No. Kilimanjaro is a trek, not a technical climb. The standard routes require no ropes, crampons, or prior mountaineering experience. However, you need good physical fitness, proper preparation, and mental determination.</p>
                        </div>
                        <div className="field-pillar-faq-item">
                            <h3>What is the success rate for summiting Kilimanjaro?</h3>
                            <p>Overall success rates average 65–85%, but vary significantly by route. Longer routes with better acclimatization (Lemosho, Northern Circuit) achieve 90%+ success rates, while shorter routes (Marangu, Umbwe) have lower rates around 50–70%.</p>
                        </div>
                        <div className="field-pillar-faq-item">
                            <h3>How much does it cost to climb Kilimanjaro?</h3>
                            <p>Prices range from $2,000–$6,000 depending on route duration, group size, and included services. Our group departures offer the best value. See our <Link href="/trekking/prep/park-fees">park fees guide</Link> for a detailed cost breakdown.</p>
                        </div>
                        <div className="field-pillar-faq-item">
                            <h3>When is the best time to climb Kilimanjaro?</h3>
                            <p>The best climbing windows are January–March and June–October. These months offer the most stable weather and highest summit success rates. See our <Link href="/trekking/prep/best-time">best time to climb guide</Link> for detailed seasonal analysis.</p>
                        </div>
                    </div>

                    <div style={{ textAlign: 'center', marginTop: '60px' }}>
                        <Link href="/faq" className="field-btn">
                            View All FAQs <ChevronRight size={16} />
                        </Link>
                    </div>
                </motion.div>
            </section>

            {/* ─── FINAL CTA ─── */}
            <section className="field-cta">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <h2 className="field-cta-title">Ready for the <em>Adventure?</em></h2>
                    <p className="field-cta-body">
                        Whether you have a specific route in mind or need help choosing the perfect Kilimanjaro climb,
                        our expert team is here to help make your summit dream a reality.
                    </p>
                    <div style={{ display: 'flex', gap: '20px', justifyContent: 'center', flexWrap: 'wrap' }}>
                        <Link href="/group-departures" className="field-btn">
                            View Group Departures <ArrowRight size={16} />
                        </Link>
                        <Link href="/contact" className="field-btn" style={{ borderColor: 'var(--field-gold)', color: 'var(--field-gold)' }}>
                            Contact Our Team
                        </Link>
                    </div>
                </motion.div>
            </section>
        </div>
    );
};

export default KilimanjaroPillar;
