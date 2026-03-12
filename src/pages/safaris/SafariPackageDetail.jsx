import React, { useEffect, useMemo } from 'react';
import { useParams, Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Clock, MapPin, DollarSign, Home, Coffee, Shield, Check, X, ArrowRight } from 'lucide-react';
import { safarisData } from '../../data/safarisData';
import '../../styles/safari-packages.css';

export const SafariPackageDetail = () => {
    const { packageId } = useParams();

    useEffect(() => {
        window.scrollTo(0, 0);
    }, [packageId]);

    const pkg = useMemo(() => safarisData.find(p => p.id === packageId), [packageId]);

    if (!pkg) return (
        <div style={{ padding: '150px 20px', textAlign: 'center', background: 'var(--bg-parchment)', color: 'var(--dark)', minHeight: '100vh' }}>
            <h1 style={{ fontFamily: 'Playfair Display', fontSize: '3rem' }}>Expedition Not Found</h1>
            <Link to="/safaris" style={{ color: 'var(--gold)', letterSpacing: '0.1em', textTransform: 'uppercase', fontSize: '0.8rem', fontWeight: 700 }}>Return to Archive</Link>
        </div>
    );

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.15, delayChildren: 0.1 } }
    };

    return (
        <div className="safari-pkgs-root">
            {/* EXPEDITION HERO */}
            <section className="safari-det-hero">
                <div className="safari-det-bg">
                    <img src={pkg.heroImg} alt={pkg.title} />
                </div>
                <div className="safari-det-overlay"></div>
                <motion.div
                    className="safari-det-hero-content"
                    initial="hidden" animate="visible" variants={staggerContainer}
                >
                    <motion.div className="safari-det-badge" variants={fadeInUp}>{pkg.badge}</motion.div>
                    <motion.h1 className="safari-det-title" variants={fadeInUp}>{pkg.title}</motion.h1>
                    <motion.p className="safari-det-overview" variants={fadeInUp}>{pkg.overview}</motion.p>
                </motion.div>
            </section>

            {/* TECHNICAL METRICS BAR */}
            <section className="safari-det-metrics">
                <div className="safari-metric">
                    <span className="safari-m-label">Expedition Length</span>
                    <span className="safari-m-val">{pkg.duration}</span>
                </div>
                <div className="safari-metric">
                    <span className="safari-m-label">Operational Area</span>
                    <span className="safari-m-val">{pkg.parks}</span>
                </div>
                <div className="safari-metric">
                    <span className="safari-m-label">Pace Level</span>
                    <span className="safari-m-val">{pkg.paceLevel || "Signature Heritage"}</span>
                </div>
                <div className="safari-metric">
                    <span className="safari-m-label">Investment</span>
                    <span className="safari-m-val">{pkg.price} <span style={{ fontSize: '0.8rem', opacity: 0.6 }}>pp</span></span>
                </div>
            </section>

            {/* EXPEDITION JOURNAL CONTENT */}
            <section className="safari-det-body">
                {/* FIELD JOURNAL ITINERARY */}
                <div className="safari-itin-col">
                    <motion.div 
                        className="safari-det-intro"
                        initial="hidden" whileInView="visible" viewport={{ once: true }}
                        variants={fadeInUp}
                    >
                        <h2 className="safari-itin-head">The Essence</h2>
                        <p className="safari-det-brief">{pkg.overview}</p>
                    </motion.div>

                    <h2 className="safari-itin-head" style={{ marginTop: '60px' }}>The Journey</h2>
                    <motion.div
                        initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-100px" }}
                        variants={staggerContainer}
                    >
                        {pkg.itinerary.map((day, idx) => (
                            <motion.div key={idx} className="safari-day-card" variants={fadeInUp}>
                                <span className="safari-day-num">Day {day.day}</span>
                                <h3 className="safari-day-title">{day.title}</h3>
                                <p className="safari-day-desc">{day.desc}</p>

                                <div className="safari-day-meta">
                                    <div className="safari-day-meta-item">
                                        <Home size={18} />
                                        <span>Estate: {day.accommodation}</span>
                                    </div>
                                    <div className="safari-day-meta-item">
                                        <Coffee size={18} />
                                        <span>Provisions: {day.meals}</span>
                                    </div>
                                </div>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>

                {/* PRESTIGE LEDGER SIDEBAR */}
                <div className="safari-sidebar-col">
                    <div className="safari-sidebar">
                        {/* Enquiry Ledger */}
                        <div className="safari-sb-card safari-book-card">
                            <h3 className="safari-sb-title">Enquiry Ledger</h3>
                            <div style={{ textAlign: 'center', marginBottom: '40px' }}>
                                <div style={{ fontSize: '0.7rem', color: 'var(--gold)', letterSpacing: '0.2em', marginBottom: '10px', textTransform: 'uppercase' }}>Current Rate</div>
                                <div style={{ fontSize: '2.5rem', fontWeight: 600 }}>{pkg.price}</div>
                                <div style={{ fontSize: '0.8rem', opacity: 0.5 }}>Net Per Participant</div>
                            </div>
                            <Link to="/contact" className="safari-btn-gold">Initiate Expedition</Link>
                            <Link to="/safaris" className="safari-btn-outline">Customise Itinerary</Link>
                        </div>

                        {/* Inclusions Ledger */}
                        <div className="safari-sb-card">
                            <h3 className="safari-sb-title">Inclusions</h3>
                            <ul className="safari-sb-list">
                                {pkg.inclusions.map((inc, i) => <li key={i}>{inc}</li>)}
                            </ul>
                        </div>

                        {/* Exclusions Ledger */}
                        <div className="safari-sb-card">
                            <h3 className="safari-sb-title">Exclusions</h3>
                            <ul className="safari-sb-list">
                                {pkg.exclusions.map((exc, i) => <li key={i}>{exc}</li>)}
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
};
