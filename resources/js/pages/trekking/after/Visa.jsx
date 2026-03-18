import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Globe, FileBadge, ShieldAlert, BadgeCheck } from 'lucide-react';
import { visualsData } from '../../../data/visualsData';
import { useVisuals } from '../../../context/VisualsContext';
import '../../../styles/trekking-prep.css';

const Visa = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);
    const visuals = useVisuals();

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
                        src={visuals.getSingle('trekking.after.visa', visualsData.trekking.after.visa)}
                        alt="Border Clearance"
                    />
                    <div className="prep-hero-overlay"></div>
                </div>
                <div className="prep-hero-content">
                    <motion.span className="prep-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Entry Authorization</motion.span>
                    <motion.h1 className="prep-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>Clearance for <em>Entry.</em></motion.h1>
                </div>
            </section>

            {/* ─── EDITORIAL SECTION ─── */}
            <section className="prep-grid-section">
                <div className="prep-editorial-grid">
                    <motion.div
                        className="prep-editorial-img-wrap"
                        initial={{ opacity: 0, x: -50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 1.2, ease: [0.16, 1, 0.3, 1] }}
                    >
                        <img
                            src={visuals.getSingle('trekking.after.visaEditorial', visualsData.trekking.after.visaEditorial)}
                            className="prep-editorial-img"
                            alt="Passport"
                        />
                        <span className="prep-img-caption">Global Mobility Protocols.</span>
                    </motion.div>
                    <div className="prep-editorial-text">
                        <motion.span className="prep-eyebrow" initial="hidden" whileInView="visible" variants={fadeInUp}>Bureaucracy Simplified</motion.span>
                        <h2 className="prep-section-title">The Tourist <em>Visa.</em></h2>
                        <p className="prep-body-text">
                            Most international travelers, including those from Europe, the UK, Australia, New Zealand, Canada, and the US, require a tourist visa to enter the United Republic of Tanzania.
                        </p>
                        <p className="prep-body-text">
                            While the process is straightforward, choosing the right method—either an e-Visa online or a Visa on Arrival—impacts your transition through the airport terminal. We advocate for the e-Visa to ensure a swift insertion into the country.
                        </p>
                    </div>
                </div>
            </section>

            {/* ─── INFO GRID ─── */}
            <section className="prep-info-grid">
                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <Globe size={45} color="var(--savanna-gold)" strokeWidth={1.5} />
                        <h3 className="prep-info-card-title">The e-Visa Protocol</h3>
                    </div>
                    <ul className="prep-info-list">
                        <li>
                            <strong>Digital Authorization</strong>
                            <p>We strongly recommend applying for an e-Visa through the <a href="https://immigration.go.tz" target="_blank" rel="noreferrer" style={{ color: 'var(--savanna-earth)' }}>official portal</a> at least 4 weeks prior to deployment. This bypasses the potentially long queues at terminal banks on arrival.</p>
                        </li>
                        <li>
                            <strong>Required Intelligence</strong>
                            <p>You will need a digital headshot, a scan of your passport bio-page, and proof of onward transit (return flights).</p>
                        </li>
                    </ul>
                </motion.div>

                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <FileBadge size={45} color="var(--savanna-gold)" strokeWidth={1.5} />
                        <h3 className="prep-info-card-title">Visa On Arrival</h3>
                    </div>
                    <ul className="prep-info-list">
                        <li>
                            <strong>The Contingency Plan</strong>
                            <p>Authorized at Kilimanjaro International Airport (JRO) and major land borders. Note that this involves a multi-queue process (Control Number, Payment at Bank, Immigration Stamping) which can take up to 2 hours.</p>
                        </li>
                        <li>
                            <strong>Financial Liquidity</strong>
                            <p>Ensure you have crisp USD notes printed unconditionally after 2009 for payment. Credit card terminals are available but frequently experience network outages.</p>
                        </li>
                    </ul>
                </motion.div>
            </section>

            {/* ─── HIGHLIGHT ─── */}
            <section className="prep-highlight-box" style={{ background: 'var(--savanna-earth)' }}>
                <motion.h3 className="prep-highlight-title" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }}>The United States Mandate</motion.h3>
                <motion.p className="prep-highlight-text" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} transition={{ delay: 0.2 }}>
                    By law, citizens of the United States of America are strictly prohibited from utilizing the standard $50 single-entry visa. **US Citizens must purchase a $100 Multiple-Entry Visa.** This document is valid for 12 months and allows for stays of up to 90 days per visit.
                </motion.p>
                <div style={{ marginTop: '60px', borderTop: '1px solid rgba(255,255,255,0.2)', paddingTop: '40px' }}>
                    <motion.h3 className="prep-highlight-title" style={{ fontSize: '2.5rem' }} initial={{ opacity: 0 }} whileInView={{ opacity: 1 }}>Health Surveillance</motion.h3>
                    <motion.p className="prep-highlight-text" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} transition={{ delay: 0.2 }}>
                        A Yellow Fever Certificate is exclusively required if you have transited through or spent &gt;12 hours in a country where the pathogen is endemic (e.g., Kenya). Direct flights from Europe or North America do not require this certificate.
                    </motion.p>
                </div>
            </section>

            {/* ─── CTA SECTION ─── */}
            <section className="prep-cta-band">
                <h2 className="prep-cta-title">Finalize Your <em>Expedition.</em></h2>
                <div className="prep-btn-group">
                    <Link to="/trekking/health/vaccinations" className="prep-btn-sand">Health Requirements</Link>
                    <Link to="/contact" className="prep-btn-outline">Speak with a Specialist</Link>
                </div>
            </section>
        </div>
    );
};

export default Visa;
