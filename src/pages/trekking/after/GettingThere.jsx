import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Plane, Bus, Compass } from 'lucide-react';
import '../../../styles/trekking-prep.css';

const GettingThere = () => {
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
                        src="https://images.unsplash.com/photo-1516496636080-14fb876e029d?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80"
                        alt="Logistics View"
                    />
                    <div className="prep-hero-overlay"></div>
                </div>
                <div className="prep-hero-content">
                    <motion.span className="prep-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Logistical Deployment</motion.span>
                    <motion.h1 className="prep-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>The Path to <em>Moshi.</em></motion.h1>
                </div>
            </section>

            {/* ─── EDITORIAL SECTION ─── */}
            <section className="prep-grid-section">
                <div className="prep-editorial-grid">
                    <div className="prep-editorial-text">
                        <motion.span className="prep-eyebrow" initial="hidden" whileInView="visible" variants={fadeInUp}>Deployment Logistics</motion.span>
                        <h2 className="prep-section-title">Gateway to <em>Adventure.</em></h2>
                        <p className="prep-body-text">
                            Kilimanjaro International Airport (JRO) is the central logistical hub for all our expeditions. Situated at the base of the mountain, it serves as the primary port of entry for mountaineers worldwide.
                        </p>
                        <p className="prep-body-text">
                            Whether you fly direct or transit through regional hubs like Nairobi, Dar es Salaam, or Zanzibar, our dedicated ground team handles the final mile. Your transition from international arrival to expedition staging in Moshi is orchestrated with professional precision.
                        </p>
                    </div>
                    <motion.div
                        className="prep-editorial-img-wrap"
                        initial={{ opacity: 0, x: 50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 1.2, ease: [0.16, 1, 0.3, 1] }}
                    >
                        <img
                            src="https://images.unsplash.com/photo-1569154941061-e231b47cb8f0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80"
                            className="prep-editorial-img"
                            alt="JRO Airport"
                        />
                        <span className="prep-img-caption">The roof of Africa awaits.</span>
                    </motion.div>
                </div>
            </section>

            {/* ─── INFO GRID ─── */}
            <section className="prep-info-grid">
                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <Bus size={45} color="var(--savanna-gold)" strokeWidth={1.5} />
                        <h3 className="prep-info-card-title">From Nairobi (NBO)</h3>
                    </div>
                    <ul className="prep-info-list">
                        <li>
                            <strong>Aviation Links</strong>
                            <p>Kenya Airways and Precision Air operate frequent 60-minute flights connecting Nairobi to Kilimanjaro International Airport (JRO).</p>
                        </li>
                        <li>
                            <strong>Overland Shuttle</strong>
                            <p>For those seeking the scenic route, daily multi-national shuttles depart Nairobi at 08:00 AM, arriving in Moshi after a 6-hour transit across the Tanzanian border.</p>
                        </li>
                    </ul>
                </motion.div>

                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <Plane size={45} color="var(--savanna-gold)" strokeWidth={1.5} />
                        <h3 className="prep-info-card-title">Domestic Arrivials</h3>
                    </div>
                    <ul className="prep-info-list">
                        <li>
                            <strong>Dar es Salaam & Zanzibar</strong>
                            <p>Daily domestic hops from Dar (DAR) or Zanzibar (ZNZ) take approximately one hour to bridge the distance to Kilimanjaro.</p>
                        </li>
                        <li>
                            <strong>Luxury Coach</strong>
                            <p>Cost-effective, air-conditioned bus services run daily between Dar es Salaam and Moshi, offerring a roughly 8-hour perspective of the Tanzanian heartland.</p>
                        </li>
                    </ul>
                </motion.div>
            </section>

            {/* ─── HIGHLIGHT ─── */}
            <section className="prep-highlight-box">
                <motion.h3 className="prep-highlight-title" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }}>VIP Ground Concierge</motion.h3>
                <motion.p className="prep-highlight-text" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} transition={{ delay: 0.2 }}>
                    The second you exit customs, the expedition begins. A professional driver holding a bespoke placard will meet you and transfer you directly to our staging hotel in Moshi. We handle all logistics, meaning you can focus entirely on the physical and mental climb ahead.
                </motion.p>
            </section>

            {/* ─── CTA SECTION ─── */}
            <section className="prep-cta-band">
                <h2 className="prep-cta-title">Finalize the <em>Paperwork.</em></h2>
                <div className="prep-btn-group">
                    <Link to="/trekking/after/visa" className="prep-btn-sand">Visa Requirements</Link>
                    <Link to="/contact" className="prep-btn-outline">Arrange My Pickup</Link>
                </div>
            </section>
        </div>
    );
};

export default GettingThere;
