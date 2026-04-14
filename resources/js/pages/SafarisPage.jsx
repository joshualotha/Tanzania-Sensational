import React, { useState, useEffect, useRef } from 'react';
import { Link } from 'react-router-dom';
import { motion, useInView, useScroll, useTransform } from 'framer-motion';
import { ArrowRight, Mountain, Trees, Waves, Map, Star, Shield, Sun, Loader2 } from 'lucide-react';
import { visualsData } from '../data/visualsData';
import { destinationService } from '../services/api';
import { useVisuals } from '../context/VisualsContext';
import '../styles/safari-premium.css';

const PremiumCountUp = ({ to, prefix = "", suffix = "", duration = 2 }) => {
    const ref = useRef(null);
    const isInView = useInView(ref, { once: true, margin: "-50px" });
    const [count, setCount] = useState(0);

    useEffect(() => {
        if (isInView) {
            let start = 0;
            const targetVal = to ? parseInt(to.replace(/,/g, '')) : 0;
            if (isNaN(targetVal)) return;

            const increment = targetVal / (duration * 60); // 60fps
            const timer = setInterval(() => {
                start += increment;
                if (start >= targetVal) {
                    setCount(targetVal);
                    clearInterval(timer);
                } else {
                    setCount(Math.floor(start));
                }
            }, 1000 / 60);

            return () => clearInterval(timer);
        }
    }, [isInView, to, duration]);

    const formatNumber = (num) => {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };

    return (
        <span ref={ref}>
            {prefix}{formatNumber(count)}<span>{suffix}</span>
        </span>
    );
};

export const SafarisPage = () => {
    const [destinations, setDestinations] = useState([]);
    const [loading, setLoading] = useState(true);
    const visuals = useVisuals();
    const containerRef = useRef(null);

    useEffect(() => {
        window.scrollTo(0, 0);
        const fetchDestinations = async () => {
            try {
                const response = await destinationService.getAll();
                setDestinations(response.data || []);
            } catch (error) {
                console.error("Failed to fetch destinations", error);
            } finally {
                setLoading(false);
            }
        };
        fetchDestinations();
    }, []);

    // Safer useScroll usage
    const { scrollYProgress } = useScroll({
        target: containerRef,
        offset: ["start start", "end start"]
    });
    
    const heroY = useTransform(scrollYProgress, [0, 1], [0, 200]);

    const fadeInUp = {
        hidden: { opacity: 0, y: 40 },
        visible: {
            opacity: 1,
            y: 0,
            transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] }
        }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: {
            opacity: 1,
            transition: { staggerChildren: 0.15, delayChildren: 0.1 }
        }
    };

    return (
        <div ref={containerRef} className="safari-premium-root">
            {/* ─── 1. CINEMATIC HERO ─── */}
            <section className="premium-safari-hero">
                <motion.div className="premium-safari-bg" style={{ y: heroY }}>
                    <img
                        src={visuals.getSingle('safaris.listHero', visualsData.safaris.listHero || "https://images.unsplash.com/photo-1516422213484-2af298bf06ad?auto=format&fit=crop&q=80")}
                        alt="African Wilderness"
                    />
                    <div className="premium-safari-overlay"></div>
                </motion.div>

                <div className="container">
                    <motion.div
                        className="premium-safari-hero-content"
                        initial="hidden"
                        animate="visible"
                        variants={staggerContainer}
                    >
                        <motion.span className="premium-eyebrow" variants={fadeInUp}>The Expedition Collective</motion.span>
                        <motion.h1 className="premium-hero-title" variants={fadeInUp}>Into the <em>Untamed.</em></motion.h1>
                        <motion.p className="premium-hero-subtitle" variants={fadeInUp}>
                            Architecting bespoke, uncompromising wilderness journeys across East Africa's most legendary landscapes.
                        </motion.p>
                    </motion.div>
                </div>

                <motion.div
                    className="premium-stats-strip"
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ delay: 0.6, duration: 0.8 }}
                >
                    <div className="premium-stats-grid">
                        <div className="premium-stat-item">
                            <span className="premium-stat-num"><PremiumCountUp to="8" /></span>
                            <span className="premium-stat-label">National Parks</span>
                        </div>
                        <div className="premium-stat-item">
                            <span className="premium-stat-num"><PremiumCountUp to="120" suffix="+" /></span>
                            <span className="premium-stat-label">Guided Expeditions</span>
                        </div>
                        <div className="premium-stat-item">
                            <span className="premium-stat-num"><PremiumCountUp to="12" /></span>
                            <span className="premium-stat-label">Boutique Camps</span>
                        </div>
                        <div className="premium-stat-item">
                            <span className="premium-stat-num"><PremiumCountUp to="450" suffix="+" /></span>
                            <span className="premium-stat-label">Species Cataloged</span>
                        </div>
                    </div>
                </motion.div>
            </section>

            {/* ─── 2. DESTINATIONS MODULAR GRID ─── */}
            <section id="expeditions" className="premium-destinations-section">
                <div className="container">
                    {loading ? (
                        <div style={{ display: 'flex', justifyContent: 'center', padding: '100px' }}>
                            <Loader2 className="animate-spin" size={48} color="var(--gold)" />
                        </div>
                    ) : (
                        <motion.div 
                            className="premium-dest-grid"
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true, margin: "-100px" }}
                            variants={staggerContainer}
                        >
                            {destinations.length > 0 ? destinations.map((dest) => (
                                <motion.div key={dest.id} variants={fadeInUp}>
                                    <Link to={`/safaris/destinations/${dest.id}`} className="premium-dest-card">
                                        <div className="premium-dest-img-wrap">
                                            <img src={dest.hero_image || visualsData.safaris.listHero} alt={dest.name} />
                                            <div className="premium-dest-img-overlay"></div>
                                        </div>
                                        <div className="premium-dest-content">
                                            <span className="premium-dest-tag">{dest.meta_tag || 'Wilderness'}</span>
                                            <h3 className="premium-dest-name">{dest.name}</h3>
                                            <p className="premium-dest-desc">{dest.overview ? dest.overview.substring(0, 100) + '...' : ''}</p>
                                            <div className="premium-dest-link">
                                                <span>Detailed Dossier</span>
                                                <ArrowRight size={16} color="currentColor" />
                                            </div>
                                        </div>
                                    </Link>
                                </motion.div>
                            )) : (
                                <p style={{ color: 'white', opacity: 0.5, textAlign: 'center', width: '100%' }}>No destinations found in local archives.</p>
                            )}
                        </motion.div>
                    )}
                </div>
            </section>

            {/* ─── 4. REVIEWS ─── */}
            <section className="premium-reviews-band">
                <motion.div
                    className="container"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true }}
                    variants={fadeInUp}
                >
                    <span className="premium-eyebrow">The Legacy</span>
                    <p className="premium-review-quote">
                      "Watching the Serengeti sunrise from our balloon, followed by a champagne breakfast seamlessly prepared in the bush, felt like a dream."
                    </p>
                    <div className="premium-dest-tag">Sarah & James W. • London, UK</div>
                </motion.div>
            </section>

            {/* ─── 5. FINAL EXPERIENCE BAND ─── */}
            <section className="premium-exp-band">
                <div className="premium-exp-bg">
                    <img
                        src={visualsData.trekking.prep.whyUs || "https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&q=80"}
                        alt="Tanzania"
                    />
                    <div className="premium-exp-overlay"></div>
                </div>
                <div className="container premium-exp-container">
                    <motion.div
                        className="premium-exp-left"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={staggerContainer}
                    >
                        <span className="premium-eyebrow" style={{ color: 'white' }}>The Difference</span>
                        <h2 className="premium-exp-title">Experience That <em>Speaks.</em></h2>
                        <motion.div variants={fadeInUp}>
                            <Link to="/contact" className="premium-exp-cta">
                                <span>Initialize Your Journey</span>
                                <ArrowRight size={18} />
                            </Link>
                        </motion.div>
                    </motion.div>

                    <motion.div
                        className="premium-exp-list"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={staggerContainer}
                    >
                        <motion.div className="premium-exp-item" variants={fadeInUp}>
                            <span className="premium-exp-num">01</span>
                            <div>
                                <h4 className="premium-exp-item-title">Architected Itineraries</h4>
                                <p className="premium-exp-item-text">Every detail is painstakingly considered—from specialized wildlife mapping to custom cuisine.</p>
                            </div>
                        </motion.div>
                        <motion.div className="premium-exp-item" variants={fadeInUp}>
                            <span className="premium-exp-num">02</span>
                            <div>
                                <h4 className="premium-exp-item-title">Locally Born Mastery</h4>
                                <p className="premium-exp-item-text">Our architects were raised here. We don't just guide—we live it.</p>
                            </div>
                        </motion.div>
                    </motion.div>
                </div>
            </section>
        </div>
    );
};
