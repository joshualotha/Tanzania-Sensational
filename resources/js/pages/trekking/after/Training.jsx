import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Mountain, Activity, Target, Zap } from 'lucide-react';
import { visualsData } from '../../../data/visualsData';
import '../../../styles/trekking-prep.css';

const Training = () => {
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
                        src={visualsData.trekking.after.training}
                        alt="Peak Training"
                    />
                    <div className="prep-hero-overlay"></div>
                </div>
                <div className="prep-hero-content">
                    <motion.span className="prep-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Physical Mastery</motion.span>
                    <motion.h1 className="prep-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>Training for the <em>Summit.</em></motion.h1>
                </div>
            </section>

            {/* ─── EDITORIAL SECTION ─── */}
            <section className="prep-grid-section">
                <div className="prep-editorial-grid">
                    <div className="prep-editorial-text">
                        <motion.span className="prep-eyebrow" initial="hidden" whileInView="visible" variants={fadeInUp}>The Foundation</motion.span>
                        <h2 className="prep-section-title">Prepare Your <em>Body.</em></h2>
                        <p className="prep-body-text">
                            Success on Kilimanjaro is determined months before you set foot on the mountain. While acclimatization is a physiological process, your physical endurance is a variable you can control entirely.
                        </p>
                        <p className="prep-body-text">
                            Conquering the Roof of Africa requires a training regimen that mirrors the mountain's unique demands. Moving beyond general fitness, you must focus on weight-bearing endurance and the specific muscle groups required for days of sustained vertical gain and loss.
                        </p>
                    </div>
                    <motion.div
                        className="prep-editorial-img-wrap"
                        initial={{ opacity: 0, scale: 0.95 }}
                        whileInView={{ opacity: 1, scale: 1 }}
                        transition={{ duration: 1.2, ease: [0.16, 1, 0.3, 1] }}
                    >
                        <img
                            src={visualsData.trekking.after.trainingEditorial}
                            className="prep-editorial-img"
                            alt="Mountain Trek"
                        />
                        <span className="prep-img-caption">Endurance is developed through consistency.</span>
                    </motion.div>
                </div>
            </section>

            {/* ─── INFO GRID ─── */}
            <section className="prep-info-grid">
                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <Mountain size={45} color="var(--savanna-gold)" strokeWidth={1.5} />
                        <h3 className="prep-info-card-title">Mountain Specifics</h3>
                    </div>
                    <ul className="prep-info-list">
                        <li>
                            <strong>Weight-Bearing Hikes</strong>
                            <p>Train as you will climb. 70% of your conditioning should involve hiking with a weighted pack (10-15kg) to build the necessary core and stabilizing muscle strength.</p>
                        </li>
                        <li>
                            <strong>Descending Mastery</strong>
                            <p>Summit night involves an immense descent. Train your legs for downhill movements to condition your joints and build the eccentric strength required for the long walk down.</p>
                        </li>
                    </ul>
                </motion.div>

                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <Activity size={45} color="var(--savanna-gold)" strokeWidth={1.5} />
                        <h3 className="prep-info-card-title">Regimen & Load</h3>
                    </div>
                    <ul className="prep-info-list">
                        <li>
                            <strong>Frequency & Duration</strong>
                            <p>Aim for 5-6 training sessions per week. Focus on sustained effort over bursts; long duration endurance is more valuable than speed.</p>
                        </li>
                        <li>
                            <strong>The Benchmark</strong>
                            <p>Strive to be able to comfortably gain 500m of elevation in 90 minutes while carrying a full expedition pack. This level of conditioning ensures you can handle the rigors of the mountain with reserve energy.</p>
                        </li>
                    </ul>
                </motion.div>
            </section>

            {/* ─── HIGHLIGHT ─── */}
            <section className="prep-highlight-box">
                <motion.h3 className="prep-highlight-title" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }}>Mental Readiness</motion.h3>
                <motion.p className="prep-highlight-text" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} transition={{ delay: 0.2 }}>
                    The mountain is as much a mental challenge as a physical one. Training in adverse conditions—cold, rain, and fatigue—builds the mental fortitude required for the final push at midnight. Maintain a positive, unshakeable attitude; your mind will carry you where your body falters.
                </motion.p>
            </section>

            {/* ─── CTA ─── */}
            <section className="prep-cta-band">
                <h2 className="prep-cta-title">Prepare for <em>Discovery.</em></h2>
                <div className="prep-btn-group">
                    <Link to="/trekking/after/gear-list" className="prep-btn-sand">View Equipment List</Link>
                    <Link to="/contact" className="prep-btn-outline">Speak with a Specialist</Link>
                </div>
            </section>
        </div>
    );
};

export default Training;
