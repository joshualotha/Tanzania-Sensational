import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { packagesData } from '../../../data/packagesData';
import '../../../styles/ultra-premium.css';

const NorthernCircuit = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const packages = packagesData.filter(p => p.routeId === 'northern-circuit');

    return (
        <div className="lux-root">
            {/* ─── HERO ─── */}
            <section className="lux-hero">
                <img
                    src="https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80"
                    alt="Northern Circuit Landscape"
                />
                <div className="lux-hero-overlay"></div>
                <div className="lux-hero-content">
                    <motion.span className="lux-hero-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>The Grand Traverse</motion.span>
                    <motion.h1 className="lux-hero-title" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.1 }}>
                        Northern <em>Circuit.</em>
                    </motion.h1>
                </div>
            </section>

            {/* ─── QUICK STATS ─── */}
            <div className="lux-stats-container">
                <motion.div
                    className="lux-stats-grid"
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ delay: 0.4, duration: 1 }}
                >
                    <div className="lux-stat-item">
                        <span className="lux-stat-label">Duration</span>
                        <div className="lux-stat-value">8-9 Days</div>
                    </div>
                    <div className="lux-stat-item">
                        <span className="lux-stat-label">Difficulty</span>
                        <div className="lux-stat-value">High</div>
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
                        <h2 className="lux-heading">The Ultimate <em>Expedition.</em></h2>
                        <p className="lux-body">
                            The Northern Circuit is the newest, longest, and undeniably the most majestic route on Kilimanjaro. It circles the entire mountain, offering an unparalleled 360-degree perspective of Africa's tallest peak.
                        </p>
                        <p className="lux-body">
                            Because it demands a commanding nine-day commitment, it provides the most superior acclimatization profile of any route. It operates nearly free of other trekkers on the remote northern slopes, immersing you in a profound, silent wilderness.
                        </p>
                        <p className="lux-body">
                            For the discerning adventurer seeking maximum success rates combined with absolute exclusivity and solitude, there is simply no equal to the Grand Traverse.
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
                            src="https://images.unsplash.com/photo-1542332213-9b5a5a3fad35?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80"
                            alt="Northern Slopes"
                        />
                        <div className="lux-image-caption">The isolated, breathtaking expanse of the northern slopes.</div>
                    </motion.div>
                </div>
            </section>

            {/* ─── FULL BLEED PARALLAX ─── */}
            <section className="lux-full-bleed">
                <img
                    src="https://images.unsplash.com/photo-1510100768407-3ce94de8d5c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80"
                    alt="Starry sky over Kili"
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
                                    <Link to={`/trekking/kilimanjaro/northern-circuit/${pkg.id}`} className="lux-link-arrow">
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
                    Inquire About The Circuit
                </Link>
            </section>
        </div>
    );
};

export default NorthernCircuit;
