import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Pill, Zap, AlertTriangle, FileText, Activity } from 'lucide-react';
import { visualsData } from '../../../data/visualsData';
import '../../../styles/trek-health-premium.css';

const Diamox = () => {
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
                        src={visualsData.trekking.health.diamox}
                        alt="Climbers silhouette"
                    />
                    <div className="trek-health-overlay"></div>
                </div>
                <div className="trek-health-hero-content">
                    <motion.span className="trek-health-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Medical Support</motion.span>
                    <motion.h1 className="trek-health-title" initial="hidden" animate="visible" variants={fadeInUp}>Diamox <em>Acclimatization.</em></motion.h1>
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
                            src={visualsData.trekking.health.diamoxEditorial}
                            alt="Detailed planning"
                        />
                    </div>
                    <div className="trek-health-content">
                        <span className="trek-health-eyebrow">The Science</span>
                        <h2 className="trek-health-section-title">Engineering your <em>Adaptation.</em></h2>
                        <p className="trek-health-body">
                            Acetazolamide, known as Diamox, is a powerful prophylactic. It works by acidifying your blood, which signals your brain to breathe faster and deeper, thereby increasing oxygen levels.
                        </p>
                        <p className="trek-health-body">
                            While we focus on natural acclimatization, Diamox can be a strategic asset in your medical kit, particularly for the final push to the Uhuru summit.
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
                        <Zap className="icon" size={40} />
                        <h3 className="trek-health-dark-title">Trial Protocol</h3>
                        <p className="trek-health-dark-text">
                            We mandate a "home trial" dose 2 weeks before departure. Identifying any sensitivity to the drug while in a standard environment is a key safety requirement of our expeditions.
                        </p>
                    </motion.div>
                    <motion.div
                        className="trek-health-dark-card"
                        initial={{ opacity: 0, x: 30 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                    >
                        <AlertTriangle className="icon" size={40} />
                        <h3 className="trek-health-dark-title">Sulfa Allergy</h3>
                        <p className="trek-health-dark-text">
                            Diamox is a sulfonamide. Travelers with a sulfa-based allergy must avoid this medication. Always discuss alternative protocols with your specialized expedition consultant.
                        </p>
                    </motion.div>
                </div>
            </section>

            {/* ─── 4. PRINCIPLES GRID ─── */}
            <section className="trek-health-principles-section">
                <div className="trek-health-principles-container">
                    <div className="trek-health-principles-grid">
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><Pill size={24} /></div>
                            <h4 className="trek-health-principle-title">Typical Dosage</h4>
                            <p className="trek-health-principle-desc">Commonly 125mg administered twice daily, starting 24 hours prior to reaching 3,000m.</p>
                        </div>
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><Activity size={24} /></div>
                            <h4 className="trek-health-principle-title">Tingling</h4>
                            <p className="trek-health-principle-desc">Paresthesia (tingling in extremities) is a common, harmless side effect of the medication.</p>
                        </div>
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><FileText size={24} /></div>
                            <h4 className="trek-health-principle-title">Prescription</h4>
                            <p className="trek-health-principle-desc">This is a regulated drug. We do not provide Diamox; it must be prescribed by your physician.</p>
                        </div>
                        <div className="trek-health-principle-item">
                            <div className="trek-health-principle-icon"><Activity size={24} /></div>
                            <h4 className="trek-health-principle-title">Hydration</h4>
                            <p className="trek-health-principle-desc">Diamox is a diuretic. You must proactively increase water intake when utilizing this medication.</p>
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

export default Diamox;
