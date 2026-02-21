import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Sun, CloudRain, Snowflake, ThermometerSun } from 'lucide-react';
import '../../../styles/trekking-prep.css';

const BestTime = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    return (
        <div className="prep-savanna-root">
            {/* ─── HERO ─── */}
            <section className="prep-hero">
                <div className="prep-hero-bg">
                    <img
                        src="https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80"
                        alt="Sun hitting the peak"
                    />
                    <div className="prep-hero-overlay"></div>
                </div>
                <div className="prep-hero-content">
                    <motion.span className="prep-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Expedition Timing</motion.span>
                    <motion.h1 className="prep-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>Which Month is <em>Best?</em></motion.h1>
                </div>
            </section>

            {/* ─── EDITORIAL CONTENT ─── */}
            <section className="prep-grid-section">
                <div className="prep-editorial-grid">
                    <div className="prep-editorial-text">
                        <motion.span className="prep-eyebrow" initial="hidden" whileInView="visible" variants={fadeInUp}>The Climate Windows</motion.span>
                        <h2 className="prep-section-title">Timing the <em>Elements.</em></h2>
                        <p className="prep-body-text">
                            Kilimanjaro is a mountain of microclimates. Due to its proximity to the equator, the mountain doesn't experience extreme winter and summer changes, but rather dry and wet seasons.
                        </p>
                        <p className="prep-body-text">
                            While trekking is possible year-round, there are two distinct "dry seasons" that offer the most stable conditions: <strong>January to March</strong>, and <strong>June to October</strong>. Trekking during the dry seasons dramatically increases your comfort, visibility, and overall summit success rate.
                        </p>
                    </div>
                    <motion.div
                        className="prep-editorial-img-wrap"
                        initial={{ opacity: 0, x: 50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 1 }}
                    >
                        <img
                            src="https://images.unsplash.com/photo-1621414050946-1b936a78490b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80"
                            className="prep-editorial-img"
                            alt="The Summit Dawn"
                        />
                        <span className="prep-img-caption">The Summit Ridge at Sunrise</span>
                    </motion.div>
                </div>
            </section>

            {/* ─── SEASONS FEATURE GRID ─── */}
            <section className="prep-feature-grid">
                <motion.div className="prep-feature-item" variants={fadeInUp} initial="hidden" whileInView="visible" viewport={{ once: true }}>
                    <Sun className="prep-feature-icon" size={32} />
                    <h3 className="prep-feature-title">Jan - March (Dry & Warm)</h3>
                    <p className="prep-feature-desc">Generally dry and clear, though clouds can build up in the afternoons. These are the warmest months, making the night-time summit assault slightly more comfortable.</p>
                </motion.div>
                <motion.div className="prep-feature-item" variants={fadeInUp} initial="hidden" whileInView="visible" viewport={{ once: true }}>
                    <Snowflake className="prep-feature-icon" size={32} />
                    <h3 className="prep-feature-title">June - October (Dry & Cold)</h3>
                    <p className="prep-feature-desc">The longest dry season and the busiest time on the mountain. Expect clear, cloudless skies all day, but be prepared for extremely cold nighttime temperatures.</p>
                </motion.div>
                <motion.div className="prep-feature-item" variants={fadeInUp} initial="hidden" whileInView="visible" viewport={{ once: true }}>
                    <CloudRain className="prep-feature-icon" size={32} />
                    <h3 className="prep-feature-title">April, May & Nov (Wet)</h3>
                    <p className="prep-feature-desc">April and May are the "long rains" (heavy downpours, muddy trails). November brings the "short rains." Only recommended for very experienced trekkers (e.g. Rongai route).</p>
                </motion.div>
            </section>

            {/* ─── MONTH BY MONTH GRID ─── */}
            <section className="prep-month-grid">
                <motion.div className="prep-month-item" initial={{ opacity: 0, scale: 0.9 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} style={{ borderColor: 'var(--savanna-gold)' }}>
                    <h4 className="prep-month-name">January</h4>
                    <span className="prep-month-stat"><ThermometerSun size={14} /> Excellent</span>
                    <span className="prep-month-stat"><CloudRain size={14} /> Low Rain</span>
                </motion.div>
                <motion.div className="prep-month-item" initial={{ opacity: 0, scale: 0.9 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} style={{ borderColor: 'var(--savanna-gold)' }}>
                    <h4 className="prep-month-name">February</h4>
                    <span className="prep-month-stat"><ThermometerSun size={14} /> Excellent</span>
                    <span className="prep-month-stat"><CloudRain size={14} /> Low Rain</span>
                </motion.div>
                <motion.div className="prep-month-item" initial={{ opacity: 0, scale: 0.9 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }}>
                    <h4 className="prep-month-name">March</h4>
                    <span className="prep-month-stat"><ThermometerSun size={14} /> Good</span>
                    <span className="prep-month-stat"><CloudRain size={14} /> Rains Begin</span>
                </motion.div>
                <motion.div className="prep-month-item" initial={{ opacity: 0, scale: 0.9 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} style={{ borderColor: 'rgba(255,0,0,0.3)', opacity: 0.7 }}>
                    <h4 className="prep-month-name">April</h4>
                    <span className="prep-month-stat"><ThermometerSun size={14} /> Poor</span>
                    <span className="prep-month-stat"><CloudRain size={14} /> Heavy Rain</span>
                </motion.div>
                <motion.div className="prep-month-item" initial={{ opacity: 0, scale: 0.9 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} style={{ borderColor: 'rgba(255,0,0,0.3)', opacity: 0.7 }}>
                    <h4 className="prep-month-name">May</h4>
                    <span className="prep-month-stat"><ThermometerSun size={14} /> Poor</span>
                    <span className="prep-month-stat"><CloudRain size={14} /> Heavy Rain</span>
                </motion.div>
                <motion.div className="prep-month-item" initial={{ opacity: 0, scale: 0.9 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} style={{ borderColor: 'var(--savanna-gold)' }}>
                    <h4 className="prep-month-name">June</h4>
                    <span className="prep-month-stat"><Snowflake size={14} /> Good (Cold)</span>
                    <span className="prep-month-stat"><CloudRain size={14} /> Very Dry</span>
                </motion.div>
                <motion.div className="prep-month-item" initial={{ opacity: 0, scale: 0.9 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} style={{ borderColor: 'var(--savanna-gold)' }}>
                    <h4 className="prep-month-name">July</h4>
                    <span className="prep-month-stat"><Snowflake size={14} /> Excellent</span>
                    <span className="prep-month-stat"><CloudRain size={14} /> Very Dry</span>
                </motion.div>
                <motion.div className="prep-month-item" initial={{ opacity: 0, scale: 0.9 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} style={{ borderColor: 'var(--savanna-gold)' }}>
                    <h4 className="prep-month-name">August</h4>
                    <span className="prep-month-stat"><Snowflake size={14} /> Excellent</span>
                    <span className="prep-month-stat"><CloudRain size={14} /> Very Dry</span>
                </motion.div>
                <motion.div className="prep-month-item" initial={{ opacity: 0, scale: 0.9 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} style={{ borderColor: 'var(--savanna-gold)' }}>
                    <h4 className="prep-month-name">September</h4>
                    <span className="prep-month-stat"><ThermometerSun size={14} /> Excellent</span>
                    <span className="prep-month-stat"><CloudRain size={14} /> Very Dry</span>
                </motion.div>
                <motion.div className="prep-month-item" initial={{ opacity: 0, scale: 0.9 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} style={{ borderColor: 'var(--savanna-gold)' }}>
                    <h4 className="prep-month-name">October</h4>
                    <span className="prep-month-stat"><ThermometerSun size={14} /> Excellent</span>
                    <span className="prep-month-stat"><CloudRain size={14} /> Very Dry</span>
                </motion.div>
                <motion.div className="prep-month-item" initial={{ opacity: 0, scale: 0.9 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} style={{ borderColor: 'rgba(255,0,0,0.3)', opacity: 0.7 }}>
                    <h4 className="prep-month-name">November</h4>
                    <span className="prep-month-stat"><ThermometerSun size={14} /> Fair</span>
                    <span className="prep-month-stat"><CloudRain size={14} /> Short Rains</span>
                </motion.div>
                <motion.div className="prep-month-item" initial={{ opacity: 0, scale: 0.9 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }}>
                    <h4 className="prep-month-name">December</h4>
                    <span className="prep-month-stat"><ThermometerSun size={14} /> Good</span>
                    <span className="prep-month-stat"><CloudRain size={14} /> Occasional Rain</span>
                </motion.div>
            </section>

            {/* ─── CTA BAND ─── */}
            <section className="prep-cta-band">
                <motion.h2 className="prep-cta-title" initial="hidden" whileInView="visible" variants={fadeInUp}>When will you <em>Witness?</em></motion.h2>
                <div className="prep-btn-group">
                    <Link to="/contact" className="prep-btn-sand">Check Availability</Link>
                    <Link to="/safaris" className="prep-btn-outline">View Seasonal Safaris</Link>
                </div>
            </section>
        </div>
    );
};

export default BestTime;
