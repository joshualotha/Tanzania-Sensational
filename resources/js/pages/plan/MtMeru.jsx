import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import '../../styles/utility-pages-premium.css';
import '../../styles/meru-premium.css';

export const MtMeru = () => {
    const visuals = useVisuals();
    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.15, delayChildren: 0.1 } }
    };

    return (
        <div className="utility-root meru-root">
            <section className="utility-hero">
                <div className="utility-hero-bg">
                    <img src={visuals.getSingle('planning.meruHero', visualsData.planning.meruHero)} alt="Mount Meru Landscape" style={{ filter: 'brightness(0.5)' }} />
                </div>
                <div className="utility-hero-overlay"></div>
                <motion.div className="utility-hero-content" initial="hidden" animate="visible" variants={staggerContainer}>
                    <motion.span className="utility-hero-eyebrow" variants={fadeInUp}>The Perfect Acclimatization</motion.span>
                    <motion.h1 className="utility-hero-title" variants={fadeInUp}>Mount Meru Trek</motion.h1>
                    <motion.p className="utility-hero-subtitle" variants={fadeInUp}>
                        Often overlooked, Tanzania's second-highest peak is a breathtaking, uncrowded alternative and the ultimate preparation for a Kilimanjaro summit.
                    </motion.p>
                </motion.div>
            </section>

            <section className="utility-content">
                <div style={{ maxWidth: 1100, margin: '0 auto' }}>
                    <motion.h2
                        initial={{ opacity: 0, y: 20 }}
                        whileInView={{ opacity: 1, y: 0 }}
                        viewport={{ once: true, margin: "-50px" }}
                        transition={{ duration: 0.7 }}
                        style={{ fontFamily: 'Playfair Display, serif', fontSize: '2.2rem', fontWeight: 300, textAlign: 'center', marginTop: 10 }}
                    >
                        Choose your <em style={{ color: 'var(--gold)' }}>itinerary</em>
                    </motion.h2>
                    <p style={{ textAlign: 'center', maxWidth: 760, margin: '14px auto 0', color: 'rgba(17,17,17,0.68)', lineHeight: 1.7 }}>
                        Both options include a ranger on the lower slopes. The 4‑day trek is the most comfortable pace; the 3‑day trek is best for very fit hikers.
                    </p>

                    <div className="utility-grid" style={{ marginTop: 34 }}>
                        <motion.div className="util-card" variants={fadeInUp} initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-50px" }}>
                            <div className="util-card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M12 6v6l3 3"></path></svg>
                            </div>
                            <h3 className="util-card-title">3‑Day Fast Trek</h3>
                            <p className="util-card-p">A shorter itinerary designed for strong hikers who want altitude exposure before Kilimanjaro.</p>
                            <ul className="util-card-list">
                                <li>Best for: acclimatization + tight schedules</li>
                                <li>More demanding pace</li>
                                <li>Great add‑on before a group departure</li>
                            </ul>
                            <div style={{ marginTop: 18 }}>
                                <Link to="/contact" className="dep-btn" style={{ padding: '12px 18px', fontSize: '0.95rem' }}>Ask about 3‑day Meru</Link>
                            </div>
                        </motion.div>

                        <motion.div className="util-card" variants={fadeInUp} initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-50px" }}>
                            <div className="util-card-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M3 22h18"></path><path d="M6 22V9l6-5 6 5v13"></path></svg>
                            </div>
                            <h3 className="util-card-title">4‑Day Classic Trek</h3>
                            <p className="util-card-p">A balanced itinerary with better recovery time—ideal for comfort and smoother summit day.</p>
                            <ul className="util-card-list">
                                <li>Best for: most travelers</li>
                                <li>More comfortable summit schedule</li>
                                <li>Excellent preparation for Kilimanjaro</li>
                            </ul>
                            <div style={{ marginTop: 18 }}>
                                <Link to="/contact" className="dep-btn" style={{ padding: '12px 18px', fontSize: '0.95rem' }}>Ask about 4‑day Meru</Link>
                            </div>
                        </motion.div>
                    </div>
                </div>

                <motion.div className="utility-grid" initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-50px" }} variants={staggerContainer}>
                    <motion.div className="util-card" variants={fadeInUp}>
                        <div className="util-card-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polygon points="12 2 2 22 22 22"></polygon></svg>
                        </div>
                        <h3 className="util-card-title">The Ash Cone</h3>
                        <p className="util-card-p">Summiting Meru (4,562m) involves trekking along a spectacular crater rim with peerless views of the ash cone deep within the caldera, all while gazing across the plains at Kilimanjaro.</p>
                    </motion.div>

                    <motion.div className="util-card" variants={fadeInUp}>
                        <div className="util-card-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                        <h3 className="util-card-title">A Walking Safari</h3>
                        <p className="util-card-p">Because Meru is located within Arusha National Park, the lower slopes require an armed ranger. You will likely walk past giraffes, elephants, and buffalo on your first day.</p>
                    </motion.div>

                    <motion.div className="util-card" variants={fadeInUp}>
                        <div className="util-card-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <h3 className="util-card-title">Itineraries</h3>
                        <ul className="util-card-list">
                            <li><strong>3-Day Fast Trek:</strong> For extremely fit climbers acclimatizing for Kili.</li>
                            <li><strong>4-Day Classic Trek:</strong> The sensible pace, offering excellent acclimatization.</li>
                        </ul>
                    </motion.div>
                </motion.div>

                <div style={{ textAlign: 'center', marginTop: '80px' }}>
                    <Link to="/contact" className="dep-btn" style={{ padding: '15px 40px', fontSize: '1rem' }}>Enquire About Mt. Meru</Link>
                </div>
            </section>
        </div>
    );
};
