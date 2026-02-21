import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { ShieldCheck, Compass, Users, Star, Award, HeartHandshake } from 'lucide-react';
import '../../../styles/trekking-prep.css';

const WhyUs = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.16, 1, 0.3, 1] } }
    };

    return (
        <div className="prep-savanna-root">
            {/* ─── HERO ─── */}
            <section className="prep-hero">
                <div className="prep-hero-bg">
                    <img
                        src="https://images.unsplash.com/photo-1650668302197-7f556c34cb91?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80"
                        alt="Elite guides on the mountain"
                    />
                    <div className="prep-hero-overlay"></div>
                </div>
                <div className="prep-hero-content">
                    <motion.span className="prep-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>The Gold Standard</motion.span>
                    <motion.h1 className="prep-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>The <em>Elite</em> Standard.</motion.h1>
                </div>
            </section>

            {/* ─── EDITORIAL SECTION ─── */}
            <section className="prep-grid-section">
                <div className="prep-editorial-grid">
                    <motion.div
                        className="prep-editorial-img-wrap"
                        initial={{ opacity: 0, scale: 0.95 }}
                        whileInView={{ opacity: 1, scale: 1 }}
                        transition={{ duration: 1.2, ease: [0.16, 1, 0.3, 1] }}
                    >
                        <img
                            src="https://images.unsplash.com/photo-1631646109206-4919df38eb68?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80"
                            className="prep-editorial-img"
                            alt="Expedition Team"
                        />
                        <span className="prep-img-caption">Local Heritage, Global Excellence.</span>
                    </motion.div>
                    <div className="prep-editorial-text">
                        <motion.span className="prep-eyebrow" initial="hidden" whileInView="visible" variants={fadeInUp}>Our Legacy</motion.span>
                        <h2 className="prep-section-title">Born from the <em>Shadows.</em></h2>
                        <p className="prep-body-text">
                            We don't just guide on Kilimanjaro; we are its children. Tanzania Sensational was founded by those who grew up in the mountain's shadow, turning a deep-rooted respect into the world's most elite expedition company.
                        </p>
                        <p className="prep-body-text">
                            Our success rate—an unparalleled 98%—is not accidental. It is the result of precision planning, superior high-altitude nutrition, and a refusal to compromise on safety equipment or guide training. We handle every detail, so you can focus on the extraordinary.
                        </p>
                    </div>
                </div>
            </section>

            {/* ─── INFO GRID: STANDARDS ─── */}
            <section className="prep-info-grid">
                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <Award size={45} color="var(--savanna-gold)" strokeWidth={1.5} />
                        <h3 className="prep-info-card-title">Lead Guide Standards</h3>
                    </div>
                    <ul className="prep-info-list">
                        <li>
                            <strong>Summit Experience</strong>
                            <p>Minimum 100+ successful summits. Our leads are the most seasoned professionals on the mountain.</p>
                        </li>
                        <li>
                            <strong>WFR Certification</strong>
                            <p>Every lead guide is a certified Wilderness First Responder, trained in advanced high-altitude pathology.</p>
                        </li>
                        <li>
                            <strong>Decision Autonomy</strong>
                            <p>Guides are empowered to prioritize safety unconditionally, with direct satellite links to our medical directors.</p>
                        </li>
                    </ul>
                </motion.div>

                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <ShieldCheck size={45} color="var(--savanna-gold)" strokeWidth={1.5} />
                        <h3 className="prep-info-card-title">Safety Protocol</h3>
                    </div>
                    <ul className="prep-info-list">
                        <li>
                            <strong>Emergency Oxygen</strong>
                            <p>Medical-grade oxygen systems are carried on every expedition, regardless of group size or route difficulty.</p>
                        </li>
                        <li>
                            <strong>Daily Health Metrics</strong>
                            <p>Twice-daily diagnostics including pulse-oximetry and Lake Louise symptom tracking to identify AMS before it matures.</p>
                        </li>
                        <li>
                            <strong>Hyperbaric Readiness</strong>
                            <p>Access to Gamow bags on all major routes to provide immediate descent simulation in critical scenarios.</p>
                        </li>
                    </ul>
                </motion.div>
            </section>

            {/* ─── HIGHLIGHT ─── */}
            <section className="prep-highlight-box">
                <motion.h3 className="prep-highlight-title" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }}>Ethical Heart</motion.h3>
                <motion.p className="prep-highlight-text" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} transition={{ delay: 0.2 }}>
                    We are proud members of the Kilimanjaro Porters Assistance Project (KPAP). We believe in the dignity of our crew, ensuring fair living wages, professional-grade equipment, and strictly enforced load limits. When our team is cared for, your expedition flourishes.
                </motion.p>
                <div style={{ marginTop: '60px', borderTop: '1px solid rgba(255,255,255,0.2)', paddingTop: '40px' }}>
                    <motion.h3 className="prep-highlight-title" style={{ fontSize: '2.5rem' }} initial={{ opacity: 0 }} whileInView={{ opacity: 1 }}>Precision Nutrition</motion.h3>
                    <motion.p className="prep-highlight-text" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} transition={{ delay: 0.2 }}>
                        Appetite suppression is the greatest enemy of the summit. Our specialized mountain chefs curate menus designed to be highly palatable and carb-dense to fuel your metabolic furnace at altitude.
                    </motion.p>
                </div>
            </section>

            {/* ─── CTA BAND ─── */}
            <section className="prep-cta-band">
                <h2 className="prep-cta-title">Experience the <em>Extraordinary.</em></h2>
                <div className="prep-btn-group">
                    <Link to="/contact" className="prep-btn-sand">Start Your Legacy</Link>
                    <Link to="/trekking/prep/best-time" className="prep-btn-outline">Plan Your Window</Link>
                </div>
            </section>
        </div>
    );
};

export default WhyUs;
