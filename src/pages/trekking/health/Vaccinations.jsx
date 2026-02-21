import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Shield, Syringe, ClipboardCheck, AlertCircle } from 'lucide-react';
import '../../../styles/trek-health-premium.css';

const Vaccinations = () => {
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
                        src="https://images.unsplash.com/photo-1518173335487-347a0e39129d?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80"
                        alt="Serengeti Dawn"
                    />
                    <div className="trek-health-overlay"></div>
                </div>
                <div className="trek-health-hero-content">
                    <motion.span className="trek-health-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Expedition Safety</motion.span>
                    <motion.h1 className="trek-health-title" initial="hidden" animate="visible" variants={fadeInUp}>Vaccinations & <em>Health.</em></motion.h1>
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
                            src="https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80"
                            alt="Medical Consultation"
                        />
                    </div>
                    <div className="trek-health-content">
                        <span className="trek-health-eyebrow">Preparation</span>
                        <h2 className="trek-health-section-title">The Foundation of <em>Wellness.</em></h2>
                        <p className="trek-health-body">
                            Preparing for a high-altitude expedition requires meticulous attention to your medical readiness. Ensuring you have the correct vaccinations is the first step in protecting your journey.
                        </p>
                        <p className="trek-health-body">
                            We recommend consulting with a travel clinic at least 8 weeks before your departure to allow sufficient time for multi-dose schedules and immunity development.
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
                        <Syringe className="icon" size={40} />
                        <h3 className="trek-health-dark-title">Yellow Fever</h3>
                        <p className="trek-health-dark-text">
                            Mandatory for travelers arriving from countries with risk of Yellow Fever transmission. Even a short transit through such countries requires a valid certificate for entry into Tanzania.
                        </p>
                    </motion.div>
                    <motion.div
                        className="trek-health-dark-card"
                        initial={{ opacity: 0, x: 30 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                    >
                        <AlertCircle className="icon" size={40} />
                        <h3 className="trek-health-dark-title">Malaria Caution</h3>
                        <p className="trek-health-dark-text">
                            While mosquitos don't survive above 3,000m, the lowland regions where you'll begin and end your journey are significant risk areas. Prophylactics are strongly recommended.
                        </p>
                    </motion.div>
                </div>
            </section>

            {/* ─── 4. PRINCIPLES GRID ─── */}
            <section className="trek-health-principles-section">
                <div className="trek-health-principles-container">
                    <div className="trek-health-principles-grid">
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><Shield size={24} /></div>
                            <h4 className="trek-health-principle-title">Hepatitis A/B</h4>
                            <p className="trek-health-principle-desc">Critical protection against food and water-borne transmission throughout East Africa.</p>
                        </div>
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><ClipboardCheck size={24} /></div>
                            <h4 className="trek-health-principle-title">Typhoid</h4>
                            <p className="trek-health-principle-desc">Recommended for all travelers visiting rural areas or spending significant time outdoors.</p>
                        </div>
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><Shield size={24} /></div>
                            <h4 className="trek-health-principle-title">Tetanus</h4>
                            <p className="trek-health-principle-desc">Ensure your booster is current within the last 10 years for trail safety.</p>
                        </div>
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><AlertCircle size={24} /></div>
                            <h4 className="trek-health-principle-title">Rabies</h4>
                            <p className="trek-health-principle-desc">A precautionary measure for those spending extended time in remote wilderness areas.</p>
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

export default Vaccinations;
