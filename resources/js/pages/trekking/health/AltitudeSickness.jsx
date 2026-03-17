import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Activity, Clock, HeartPulse, ShieldAlert } from 'lucide-react';
import { visualsData } from '../../../data/visualsData';
import '../../../styles/trek-health-premium.css';

const AltitudeSickness = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    return (
        <div className="trek-health-root">
            {/* ─── 1. HERO ─── */}
            <section className="trek-health-hero">
                <div className="trek-health-hero-bg">
                    <img
                        src={visualsData.trekking.health.altitudeSickness}
                        alt="Kilimanjaro Trail"
                    />
                    <div className="trek-health-overlay"></div>
                </div>
                <div className="trek-health-hero-content">
                    <motion.span className="trek-health-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>High Altitude Safety</motion.span>
                    <motion.h1 className="trek-health-title" initial="hidden" animate="visible" variants={fadeInUp}>Altitude <em>Sickness.</em></motion.h1>
                </div>
            </section>

            {/* ─── 2. THE STORY CARD ─── */}
            <section className="trek-health-story-section">
                <motion.div
                    className="trek-health-card"
                    initial={{ opacity: 0, y: 40 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                    transition={{ duration: 1 }}
                >
                    <div className="trek-health-image">
                        <img
                            src={visualsData.trekking.health.altitudeEditorial}
                            alt="Mountaineer at high altitude"
                        />
                    </div>
                    <div className="trek-health-content">
                        <span className="trek-health-eyebrow">The Challenge</span>
                        <h2 className="trek-health-section-title">Mastering the <em>Thin Air.</em></h2>
                        <p className="trek-health-body">
                            Altitude sickness is an undeniable factor on Kilimanjaro. It is not a sign of poor fitness, but a biological response to decreasing oxygen levels.
                        </p>
                        <p className="trek-health-body">
                            Our philosophy centers on respect for the mountain. We design our itineraries to optimize your body's natural ability to acclimatize, giving you the best possible chance of a safe summit.
                        </p>
                    </div>
                </motion.div>
            </section>

            {/* ─── 3. MISSION BLOCKS ─── */}
            <section className="trek-health-mission-section">
                <div className="trek-health-mission-grid">
                    <motion.div
                        className="trek-health-dark-card"
                        initial={{ opacity: 0, x: -30 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                    >
                        <Clock className="icon" size={40} />
                        <h3 className="trek-health-dark-title">Pole Pole</h3>
                        <p className="trek-health-dark-text">
                            The Swahili mantra "Slowly, Slowly" is your most vital tool. A measured pace lowers your heart rate and allows your metabolic processes to catch up with the altitude change.
                        </p>
                    </motion.div>
                    <motion.div
                        className="trek-health-dark-card"
                        initial={{ opacity: 0, x: 30 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                    >
                        <HeartPulse className="icon" size={40} />
                        <h3 className="trek-health-dark-title">Vigilance</h3>
                        <p className="trek-health-dark-text">
                            We monitor your oxygen saturation levels and heart rate twice daily using high-altitude oximeters. Early detection of symptoms is the gold standard of care.
                        </p>
                    </motion.div>
                </div>
            </section>

            {/* ─── 4. PRINCIPLES GRID ─── */}
            <section className="trek-health-principles-section">
                <div className="trek-health-principles-container">
                    <div className="trek-health-principles-grid">
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><Activity size={24} /></div>
                            <h4 className="trek-health-principle-title">Headache</h4>
                            <p className="trek-health-principle-desc">Often the first sign of AMS. We treat all headaches at altitude with immediate concern and hydration.</p>
                        </div>
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><Activity size={24} /></div>
                            <h4 className="trek-health-principle-title">Nausea</h4>
                            <p className="trek-health-principle-desc">Loss of appetite or mild nausea are common on the higher slopes and require careful monitoring.</p>
                        </div>
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><ShieldAlert size={24} /></div>
                            <h4 className="trek-health-principle-title">Dizziness</h4>
                            <p className="trek-health-principle-desc">Any loss of coordination is a critical warning sign that requires immediate evaluation by our elite guides.</p>
                        </div>
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><ShieldAlert size={24} /></div>
                            <h4 className="trek-health-principle-title">Sleep Loss</h4>
                            <p className="trek-health-principle-desc">Cheyne-Stokes breathing can disrupt sleep; our guides are trained to help you manage this transition.</p>
                        </div>
                    </div>
                </div>
            </section>

            {/* ─── 5. FOOTER BAND ─── */}
            <section className="trek-health-footer-band">
                <h2 className="trek-health-footer-title">Ready for the <em>Ascent?</em></h2>
                <div className="trek-health-cta-group">
                    <Link to="/contact" className="trek-health-btn-solid">Commission Custom Trip</Link>
                    <Link to="/safaris" className="trek-health-btn-outline">View Safari Pairings</Link>
                </div>
            </section>
        </div>
    );
};

export default AltitudeSickness;
