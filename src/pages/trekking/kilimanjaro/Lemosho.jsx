import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { packagesData } from '../../../data/packagesData';
import { visualsData } from '../../../data/visualsData';
import '../../../styles/ultra-premium.css';

const Lemosho = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const packages = packagesData.filter(p => p.routeId === 'lemosho');

    return (
        <div className="lux-root">
            {/* ─── HERO ─── */}
            <section className="lux-hero">
                <img
                    src={visualsData.trekking.routes.lemosho}
                    alt="Lemosho Route Landscape"
                />
                <div className="lux-hero-overlay"></div>
                <div className="lux-hero-content">
                    <motion.span className="lux-hero-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>The Western Approach</motion.span>
                    <motion.h1 className="lux-hero-title" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.1 }}>
                        Lemosho <em>Route.</em>
                    </motion.h1>
                </div>
            </section>

            {/* ─── QUICK STATS (No Boxes, Just Typography) ─── */}
            <div className="lux-stats-container">
                <motion.div
                    className="lux-stats-grid"
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ delay: 0.4, duration: 1 }}
                >
                    <div className="lux-stat-item">
                        <span className="lux-stat-label">Duration</span>
                        <div className="lux-stat-value">8 Days</div>
                    </div>
                    <div className="lux-stat-item">
                        <span className="lux-stat-label">Difficulty</span>
                        <div className="lux-stat-value">Advanced</div>
                    </div>
                    <div className="lux-stat-item">
                        <span className="lux-stat-label">Scenery</span>
                        <div className="lux-stat-value">Spectacular</div>
                    </div>
                    <div className="lux-stat-item">
                        <span className="lux-stat-label">Success Rate</span>
                        <div className="lux-stat-value">95%+</div>
                    </div>
                </motion.div>
            </div>

            {/* ─── EDITORIAL NARRATIVE ─── */}
            <section className="lux-section">
                <div className="lux-editorial-grid">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-100px" }} variants={fadeInUp}>
                        <h2 className="lux-heading">Wilderness & <em>Acclimatization.</em></h2>
                        <p className="lux-body">
                            The Lemosho Route is widely considered the most beautiful path up Kilimanjaro. Approaching the mountain from the remote west, it offers a true sense of untamed wilderness before joining the more traveled Machame route.
                        </p>
                        <p className="lux-body">
                            Beyond its staggering beauty—crossing the Shira Plateau and navigating the Barranco Wall—Lemosho's true luxury lies in its pacing. The eight-day itinerary provides your body the critical time it needs to adapt to the altitude, resulting in one of the highest summit success rates on the mountain.
                        </p>
                        <p className="lux-body">
                            This is not just a climb; it is an immersion into five distinct ecological zones, crafted for the discerning trekker who values both the journey and the summit.
                        </p>
                    </motion.div>
                    <motion.div
                        initial={{ opacity: 0, scale: 0.95 }}
                        whileInView={{ opacity: 1, scale: 1 }}
                        viewport={{ once: true }}
                        transition={{ duration: 1.5, ease: "easeOut" }}
                        className="lux-image-wrapper"
                    >
                        <img
                            src={visualsData.trekking.during.routine}
                            alt="Shira Plateau"
                        />
                        <div className="lux-image-caption">Crossing the vast expanse of the Shira Plateau.</div>
                    </motion.div>
                </div>
            </section>

            {/* ─── FULL BLEED PARALLAX ─── */}
            <section className="lux-full-bleed">
                <img
                    src={visualsData.planning.meruHero}
                    alt="Kilimanjaro Summit"
                />
            </section>

            {/* ─── EXPEDITION PACKAGES ─── */}
            <section className="lux-packages-section">
                <h2 className="lux-heading" style={{ textAlign: 'center', fontSize: '2.5rem', marginBottom: '10px' }}>Available <em>Expeditions.</em></h2>
                <div className="lux-packages-grid">
                    {packages.map((pkg, index) => (
                        <motion.div
                            key={index}
                            className="lux-package-card"
                            initial={{ opacity: 0, y: 30 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true, margin: "-50px" }}
                            transition={{ duration: 0.8, delay: index * 0.1 }}
                        >
                            <div className="lux-package-image">
                                <img src={pkg.heroImg} alt={pkg.title} />
                            </div>
                            <div className="lux-package-content">
                                <div>
                                    <span className="lux-package-duration">{pkg.duration}</span>
                                    <h3 className="lux-package-title">{pkg.title.replace(/^[0-9]+ Days /, '')}</h3>
                                    <p className="lux-package-desc">{pkg.overview}</p>
                                </div>
                                <div className="lux-package-footer">
                                    <Link to={`/trekking/kilimanjaro/lemosho/${pkg.id}`} className="lux-link-arrow">
                                        View Details
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"><path d="M5 12h14M12 5l7 7-7 7" /></svg>
                                    </Link>
                                </div>
                            </div>
                        </motion.div>
                    ))}
                </div>
            </section>

            {/* ─── CTA ─── */}
            <section className="lux-cta">
                <h2 className="lux-heading" style={{ marginBottom: '40px' }}>Begin Your <em>Ascent.</em></h2>
                <Link to="/contact" className="lux-btn">
                    Inquire About Lemosho
                </Link>
            </section>
        </div>
    );
};

export default Lemosho;
