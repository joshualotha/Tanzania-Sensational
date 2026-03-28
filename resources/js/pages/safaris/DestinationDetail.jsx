import React, { useEffect, useState } from 'react';
import { useParams, Navigate, Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { ArrowRight, Mountain, Wind, Shield, Navigation, Sun, PawPrint, Loader2 } from 'lucide-react';
import { destinationService } from '../../services/api';
import '../../styles/destination-premium.css';

export const DestinationDetail = () => {
    const { id } = useParams();
    const [destination, setDestination] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        window.scrollTo(0, 0);
        const fetchDestination = async () => {
            try {
                const response = await destinationService.getById(id);
                setDestination(response.data);
            } catch (error) {
                console.error("Failed to fetch destination", error);
            } finally {
                setLoading(false);
            }
        };
        fetchDestination();
    }, [id]);

    if (loading) return (
        <div style={{ padding: '150px 20px', textAlign: 'center', background: 'var(--bg-parchment)', color: 'var(--dark)', minHeight: '100vh', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center' }}>
            <Loader2 className="animate-spin" size={48} color="var(--gold)" />
            <p style={{ marginTop: '20px', fontFamily: 'var(--font-heading)', color: 'var(--gold)', letterSpacing: '3px' }}>OPENING ARCHIVES...</p>
        </div>
    );

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
                <img src={(destination.gallery && destination.gallery[4]) || destination.hero_image} alt="Environment Substrate" />
            </div>
            
            <div className="dest-content-veil">
            
            {/* ─── 1. CINEMATIC HERO ─── */}
            <header className="dest-hero-cinematic">
                <div className="dest-hero-visual">
                    <img src={destination.hero_image} alt={destination.name} />
                    <div className="dest-hero-gradient"></div>
                </div>

                <motion.div
                    className="dest-hero-center"
                    initial="hidden"
                    animate="visible"
                    variants={{
                        visible: { transition: { staggerChildren: 0.12 } }
                    }}
                >
                    <motion.span className="dest-hero-eyebrow" variants={fadeInUp}>
                        Expertly Curated Destination
                    </motion.span>
                    <motion.h1 className="dest-hero-heading" variants={fadeInUp}>
                        {destination.name}
                        <em>{destination.meta_subtitle ? `. ${destination.meta_subtitle.split(' ').pop()}` : '. Wilderness'}.</em>
                    </motion.h1>
                    <motion.p className="dest-hero-lead" variants={fadeInUp}>
                        {destination.overview ? destination.overview.substring(0, 160) + '…' : 'An untouched sanctuary where nature reveals its most extraordinary chapter.'}
                    </motion.p>
                    <motion.div className="dest-hero-actions" variants={fadeInUp}>
                        <Link to="/contact" className="dest-btn-primary">
                            Begin Your Journey <ArrowRight size={16} />
                        </Link>
                        <a href="#overview" className="dest-btn-ghost">Explore Details</a>
                    </motion.div>
                </motion.div>

                {/* Floating Expedition Strip */}
                <div className="dest-expedition-strip">
                    <div className="dest-strip-item">
                        <span className="dest-strip-label">Coordinates</span>
                        <span className="dest-strip-value">{destination.meta_coordinates || "-2.3333, 34.8333"}</span>
                    </div>
                    <div className="dest-strip-item">
                        <span className="dest-strip-label">Elevation</span>
                        <span className="dest-strip-value">{destination.meta_elevation || "920"}m ASL</span>
                    </div>
                    <div className="dest-strip-item">
                        <span className="dest-strip-label">Best Season</span>
                        <span className="dest-strip-value">{destination.best_time || "Jun – Oct"}</span>
                    </div>
                    <div className="dest-strip-item">
                        <span className="dest-strip-label">Encounter Rate</span>
                        <span className="dest-strip-value">{destination.meta_encounter_rate || "95.8%"}</span>
                    </div>
                </div>
            </header>

            {/* ─── 2. METADATA PILLAR & NARRATIVE ─── */}
            <section id="overview" className="bespoke-overview-grid">
                <aside className="metadata-pillar">
                    <h3 className="metadata-ledger-title">Expedition Ledger</h3>
                    
                    <div className="ledger-item">
                        <span className="ledger-label">Primary Success</span>
                        <div className="ledger-val" style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                            <Shield size={16} color="var(--gold)" />
                            {destination.meta_encounter_rate || "95.8%"} Encounter Rate
                        </div>
                    </div>

                    <div className="ledger-item">
                        <span className="ledger-label">Optimal Cycle</span>
                        <div className="ledger-val" style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                            <Wind size={16} color="var(--gold)" />
                            {destination.best_time}
                        </div>
                    </div>

                    <div className="ledger-item">
                        <span className="ledger-label">Expedition Level</span>
                        <div className="ledger-val" style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                            <Mountain size={16} color="var(--gold)" />
                            {destination.meta_tier || "Prestige Tier 01"}
                        </div>
                    </div>

                    <div className="ledger-item">
                        <span className="ledger-label">Tracking Protocol</span>
                        <div className="ledger-val" style={{ display: 'flex', alignItems: 'center', gap: '8px' }}>
                            <Navigation size={16} color="var(--gold)" />
                            {destination.meta_tracking || "Satellite GPS Tracking"}
                        </div>
                    </div>
                </aside>

                <div className="narrative-content">
                    <span className="bespoke-eyebrow">A Legacy of Discovery</span>
                    <h2 className="bespoke-section-title">Where Nature Writes <em>Its Own Story.</em></h2>
                    <div className="bespoke-text">
                        <p>{destination.overview}</p>
                        <p style={{ marginTop: '30px', borderLeft: '2px solid var(--gold)', paddingLeft: '30px', fontStyle: 'italic', background: 'rgba(201, 168, 76, 0.05)', padding: '30px' }}>
                            "{destination.meta_quote || 'Walking through this landscape is like reading a forgotten manuscript of the earth.'}"
                        </p>
                    </div>
                </div>
            </section>

            {/* ─── 3. SIDE-BY-SIDE NARRATIVE LEDGERS ─── */}
            <section className="narrative-ledger-grid">
                {(destination.atmosphere_vitals || destination.wildlife_vitals) && (
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
                                {(destination.atmosphere_vitals || []).map((vital, i) => (
                                    <div className="vital-item" key={i}>
                                        <span className="vital-label">{vital.label}</span>
                                        <span className="vital-text">{vital.text}</span>
                                    </div>
                                ))}
                            </div>
                            
                            <footer className="card-footer-note">
                                {destination.atmosphere_footer || "A place that makes you feel both small and connected."}
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
                                {(destination.wildlife_vitals || []).map((vital, i) => (
                                    <div className="vital-item" key={i}>
                                        <span className="vital-label">{vital.label}</span>
                                        <span className="vital-text">{vital.text}</span>
                                    </div>
                                ))}
                            </div>
                            
                            <footer className="card-footer-note">
                                {destination.wildlife_footer || "Satellite GPS integration for active pride tracking."}
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
                    {destination.gallery && destination.gallery.slice(0, 6).map((img, i) => (
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
