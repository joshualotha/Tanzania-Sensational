import React, { useEffect } from 'react';
import { useParams, Navigate, Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { ArrowRight, Mountain, Wind, Shield, Navigation, Sun, PawPrint } from 'lucide-react';
import { destinationsData } from '../../data/destinationsData';
import '../../styles/destination-premium.css';

export const DestinationDetail = () => {
    const { id } = useParams();
    const destination = destinationsData.find(d => d.id === id);

    useEffect(() => {
        window.scrollTo(0, 0);
    }, [id]);

    if (!destination) {
        return <Navigate to="/safaris" replace />;
    }

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { 
            opacity: 1, 
            y: 0, 
            transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } 
        }
    };

    return (
        <div className="dest-detail-root">
            <div className="dest-fixed-bg">
                <img src={destination.gallery[4] || destination.heroImg} alt="Environment Substrate" />
            </div>
            
            <div className="dest-content-veil">
            
            {/* ─── 1. FULL HERITAGE HERO (BESPOKE) ─── */}
            <header className="dest-hero-bespoke">
                <div className="hero-visual-area">
                    <img src={destination.heroImg} alt={destination.name} />
                    <div className="hero-visual-overlay"></div>
                </div>

                <div className="hero-content-bespoke">
                    <div className="hero-pillar-badge" style={{ right: '60px' }}>
                        <span className="pillar-badge-num">{destination.elevation ? destination.elevation.split('m')[0] : "920"}</span>
                        <span className="pillar-badge-label">Meters ASL</span>
                    </div>

                    <motion.div
                        initial="hidden"
                        animate="visible"
                        variants={{
                            visible: { transition: { staggerChildren: 0.1 } }
                        }}
                    >
                        <motion.span className="pillar-eyebrow" variants={fadeInUp}>
                            Expertly Curated Destination
                        </motion.span>
                        <motion.h1 className="pillar-title" variants={fadeInUp}>
                            {destination.name}
                            <em>The {destination.subtitle.split(' ').pop()}.</em>
                        </motion.h1>
                        <motion.div variants={fadeInUp} style={{ display: 'flex', gap: '20px', marginTop: '40px' }}>
                            <Link to="/contact" className="btn-primary">
                                <span>Begin Your Journey</span>
                            </Link>
                            <a href="#overview" className="btn-secondary">Explore Details</a>
                        </motion.div>
                    </motion.div>
                </div>

                <div className="expedition-strip">
                    <div className="expedition-datum">
                        <span className="datum-label">Coordinates</span>
                        <span className="datum-val">{destination.coordinates || "-2.3333, 34.8333"}</span>
                    </div>
                    <div className="expedition-datum">
                        <span className="datum-label">Expedition Code</span>
                        <span className="datum-val">NDW-{destination.id.toUpperCase()}</span>
                    </div>
                    <div className="expedition-datum">
                        <span className="datum-label">Tracking Protocol</span>
                        <span className="datum-val">NDW.EXPLORE.BETA</span>
                    </div>
                </div>
            </header>

            {/* ─── 2. METADATA PILLAR & NARRATIVE ─── */}
            <section className="bespoke-overview-grid">
                <aside className="metadata-pillar">
                    <h3 className="metadata-ledger-title">Expedition Ledger</h3>
                    
                    <div className="ledger-item">
                        <span className="ledger-label">Primary Success</span>
                        <div className="ledger-val" style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                            <Shield size={16} color="var(--gold)" />
                            {destination.encounterRate || "95.8%"} Encounter Rate
                        </div>
                    </div>

                    <div className="ledger-item">
                        <span className="ledger-label">Optimal Cycle</span>
                        <div className="ledger-val" style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                            <Wind size={16} color="var(--gold)" />
                            {destination.bestTime}
                        </div>
                    </div>

                    <div className="ledger-item">
                        <span className="ledger-label">Expedition Level</span>
                        <div className="ledger-val" style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                            <Mountain size={16} color="var(--gold)" />
                            {destination.expeditionTier || "Prestige Tier 01"}
                        </div>
                    </div>

                    <div className="ledger-item">
                        <span className="ledger-label">Tracking Protocol</span>
                        <div className="ledger-val" style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                            <Navigation size={16} color="var(--gold)" />
                            {destination.trackingMethod || "Satellite GPS Tracking"}
                        </div>
                    </div>
                </aside>

                <div className="narrative-content">
                    <span className="bespoke-eyebrow">A Legacy of Discovery</span>
                    <h2 className="bespoke-section-title">Where Nature Writes <em>Its Own Story.</em></h2>
                    <div className="bespoke-text">
                        <p>{destination.overview}</p>
                        <p style={{ marginTop: '30px', borderLeft: '2px solid var(--gold)', paddingLeft: '30px', fontStyle: 'italic', background: 'rgba(201, 168, 76, 0.05)', padding: '30px' }}>
                            "{destination.overviewQuote || 'Walking through this landscape is like reading a forgotten manuscript of the earth.'}"
                        </p>
                    </div>
                </div>
            </section>

            {/* ─── 3. SIDE-BY-SIDE NARRATIVE LEDGERS ─── */}
            <section className="narrative-ledger-grid">
                {destination.experience && (
                    <>
                        <motion.div 
                            className="narrative-card-ledger"
                            initial={{ opacity: 0, x: -30 }}
                            whileInView={{ opacity: 1, x: 0 }}
                            viewport={{ once: true }}
                        >
                            <header className="card-header-mini">
                                <Sun size={24} className="card-icon-mini" strokeWidth={1.5} />
                                <h3 className="card-title-mini">The Atmosphere</h3>
                            </header>
                            
                            <div className="ledger-vitals">
                                {(destination.atmosphereVitals || []).map((vital, i) => (
                                    <div className="vital-item" key={i}>
                                        <span className="vital-label">{vital.label}</span>
                                        <span className="vital-text">{vital.text}</span>
                                    </div>
                                ))}
                            </div>
                            
                            <footer className="card-footer-note">
                                {destination.atmosphereFooter || "A place that makes you feel both small and connected."}
                            </footer>
                        </motion.div>

                        <motion.div 
                            className="narrative-card-ledger"
                            initial={{ opacity: 0, x: 30 }}
                            whileInView={{ opacity: 1, x: 0 }}
                            viewport={{ once: true }}
                        >
                            <header className="card-header-mini">
                                <PawPrint size={24} className="card-icon-mini" strokeWidth={1.5} />
                                <h3 className="card-title-mini">Wildlife Ledger</h3>
                            </header>
                            
                            <div className="ledger-vitals">
                                {(destination.wildlifeVitals || []).map((vital, i) => (
                                    <div className="vital-item" key={i}>
                                        <span className="vital-label">{vital.label}</span>
                                        <span className="vital-text">{vital.text}</span>
                                    </div>
                                ))}
                            </div>
                            
                            <footer className="card-footer-note">
                                {destination.wildlifeFooter || "Satellite GPS integration for active pride tracking."}
                            </footer>
                        </motion.div>
                    </>
                )}
            </section>

            {/* ─── 4. MINIMALIST GALLERY ─── */}
            <section className="mosaic-gallery">
                <span className="bespoke-eyebrow" style={{ textAlign: 'center', marginBottom: '10px' }}>Visual Archive</span>
                <h2 className="bespoke-section-title" style={{ textAlign: 'center', marginBottom: '80px' }}>Curated Moments <em>of Awe.</em></h2>
                
                <div className="minimalist-gallery-grid">
                    {destination.gallery.slice(0, 6).map((img, i) => (
                        <motion.div 
                            key={i} 
                            className="minimal-gallery-item"
                            initial={{ opacity: 0, y: 30 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true }}
                            transition={{ delay: i * 0.1 }}
                        >
                            <img src={img} alt={`Gallery ${i}`} />
                        </motion.div>
                    ))}
                </div>
            </section>

            {/* CTA */}
            <section className="smart-cta-section" style={{ background: 'var(--dark)', color: 'white', padding: '140px 60px', textAlign: 'center' }}>
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true }}
                    variants={fadeInUp}
                >
                    <span className="pillar-eyebrow" style={{ color: 'var(--gold)', marginBottom: '20px' }}>Exclusive Access</span>
                    <h2 className="bespoke-section-title" style={{ color: 'white', marginBottom: '50px' }}>
                        Architect Your <em>Personal Journey.</em>
                    </h2>
                    <Link to="/contact" className="btn-primary" style={{ display: 'inline-flex', alignItems: 'center', gap: '15px' }}>
                        <span>Request Custom Itinerary</span>
                        <ArrowRight size={18} />
                    </Link>
                </motion.div>
            </section>

            </div>
        </div>
    );
};
