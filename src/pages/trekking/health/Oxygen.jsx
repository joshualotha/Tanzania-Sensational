import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Wind, ShieldCheck, Heart, AlertCircle } from 'lucide-react';
import { visualsData } from '../../../data/visualsData';
import '../../../styles/trek-health-premium.css';

const Oxygen = () => {
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
                        src={visualsData.trekking.health.oxygen}
                        alt="Mist rolling over high peaks"
                    />
                    <div className="trek-health-overlay"></div>
                </div>
                <div className="trek-health-hero-content">
                    <motion.span className="trek-health-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Safety Protocol</motion.span>
                    <motion.h1 className="trek-health-title" initial="hidden" animate="visible" variants={fadeInUp}>Oxygen <em>Supplements.</em></motion.h1>
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
                            src={visualsData.trekking.health.oxygenEditorial}
                            alt="Expedition base camp"
                        />
                    </div>
                    <div className="trek-health-content">
                        <span className="trek-health-eyebrow">The Asset</span>
                        <h2 className="trek-health-section-title">A Lifeline on the <em>Skyline.</em></h2>
                        <p className="trek-health-body">
                            At Tanzania Sensational, we carry specialized AL-CAN medical oxygen systems on every trek. However, our protocol for its use is strictly medical, never performance-based.
                        </p>
                        <p className="trek-health-body">
                            We do not use oxygen to help climbers reach the summit. We use it solely as a life-saving tool during emergency descents if a climber shows signs of severe AMS.
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
                        <AlertCircle className="icon" size={40} />
                        <h3 className="trek-health-dark-title">Emergency Descent</h3>
                        <p className="trek-health-dark-text">
                            Supply is reserved for cases of HAPE or HACE. If oxygen is administered, the climb ends immediately, and our priority shifts to getting the client to lower altitude as fast as safely possible.
                        </p>
                    </motion.div>
                    <motion.div
                        className="trek-health-dark-card"
                        initial={{ opacity: 0, x: 30 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                    >
                        <ShieldCheck className="icon" size={40} />
                        <h3 className="trek-health-dark-title">Elite Maintenance</h3>
                        <p className="trek-health-dark-text">
                            Our medical systems are inspected after every trek and fully recharged every 6 months. We utilize sub-zero tested regulators specifically designed for the Kilimanjaro climate.
                        </p>
                    </motion.div>
                </div>
            </section>

            {/* ─── 4. PRINCIPLES GRID ─── */}
            <section className="trek-health-principles-section">
                <div className="trek-health-principles-container">
                    <div className="trek-health-principles-grid">
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><Wind size={24} /></div>
                            <h4 className="trek-health-principle-title">AL-CAN Systems</h4>
                            <p className="trek-health-principle-desc">The industry standard for lightweight, high-reliability high-altitude medical oxygen.</p>
                        </div>
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><Heart size={24} /></div>
                            <h4 className="trek-health-principle-title">Daily O2 Checks</h4>
                            <p className="trek-health-principle-desc">Twice-daily saturation monitoring via pulse oximeter is standard on all our expeditions.</p>
                        </div>
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><ShieldCheck size={24} /></div>
                            <h4 className="trek-health-principle-title">Guide Training</h4>
                            <p className="trek-health-principle-desc">All our lead guides are certified Wilderness First Responders (WFR) with extensive oxygen protocol training.</p>
                        </div>
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><AlertCircle size={24} /></div>
                            <h4 className="trek-health-principle-title">Safety First</h4>
                            <p className="trek-health-principle-desc">We never compromise the long-term health of our clients for a summit photo. Descent is the only cure.</p>
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

export default Oxygen;
