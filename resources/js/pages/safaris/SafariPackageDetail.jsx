import React, { useEffect, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Clock, MapPin, DollarSign, Home, Coffee, Shield, Check, X, ArrowRight, Loader2 } from 'lucide-react';
import { safariService } from '../../services/api';
import { visualsData } from '../../data/visualsData';
import '../../styles/safari-packages.css';

export const SafariPackageDetail = () => {
    const { packageId } = useParams();
    const [pkg, setPkg] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        window.scrollTo(0, 0);
        const fetchPackage = async () => {
            try {
                const response = await safariService.getById(packageId);
                setPkg(response.data);
            } catch (error) {
                console.error("Failed to fetch safari package", error);
            } finally {
                setLoading(false);
            }
        };
        fetchPackage();
    }, [packageId]);

    if (loading) return (
        <div style={{ padding: '150px 20px', textAlign: 'center', background: 'var(--bg-parchment)', color: 'var(--dark)', minHeight: '100vh', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center' }}>
            <Loader2 className="animate-spin" size={48} color="var(--gold)" />
            <p style={{ marginTop: '20px', fontFamily: 'var(--font-heading)', color: 'var(--gold)', letterSpacing: '3px' }}>RETRIEVING DOSSIER...</p>
        </div>
    );

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
                    <img src={pkg.hero_image || visualsData.safaris.listHero} alt={pkg.name} />
                </div>
                <div className="safari-det-overlay"></div>
                <motion.div
                    className="safari-det-hero-content"
                    initial="hidden" animate="visible" variants={staggerContainer}
                >
                    <motion.div className="safari-det-badge" variants={fadeInUp}>{pkg.category || 'SIGNATURE'}</motion.div>
                    <motion.h1 className="safari-det-title" variants={fadeInUp}>{pkg.name}</motion.h1>
                    <motion.p className="safari-det-overview" variants={fadeInUp}>{pkg.description}</motion.p>
                </motion.div>
            </section>

            {/* TECHNICAL METRICS BAR */}
            <section className="safari-det-metrics">
                <div className="safari-metric">
                    <span className="safari-m-label">Expedition Length</span>
                    <span className="safari-m-val">{pkg.duration} Days</span>
                </div>
                <div className="safari-metric">
                    <span className="safari-m-label">Operational Area</span>
                    <span className="safari-m-val">{pkg.meta_tag || 'Various'}</span>
                </div>
                <div className="safari-metric">
                    <span className="safari-m-label">Pace Level</span>
                    <span className="safari-m-val">Signature Heritage</span>
                </div>
                <div className="safari-metric">
                    <span className="safari-m-label">Investment</span>
                    <span className="safari-m-val">${Math.round(pkg.base_price)} <span style={{ fontSize: '0.8rem', opacity: 0.6 }}>pp</span></span>
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
                        <p className="safari-det-brief">{pkg.description}</p>
                    </motion.div>

                    <h2 className="safari-itin-head" style={{ marginTop: '60px' }}>The Journey</h2>
                    <motion.div
                        initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-100px" }}
                        variants={staggerContainer}
                    >
                        {pkg.itinerary && pkg.itinerary.map((day, idx) => (
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
                        {/* Booking Card */}
                        <div className="safari-sb-card safari-book-card">
                            <h3 className="safari-sb-title">Expedition Reservation</h3>
                            <div style={{ textAlign: 'center', marginBottom: '30px' }}>
                                <div style={{ fontSize: '0.7rem', color: 'var(--gold)', letterSpacing: '0.2em', marginBottom: '10px', textTransform: 'uppercase' }}>Current Rate</div>
                                <div style={{ fontSize: '2.5rem', fontWeight: 600 }}>${Math.round(pkg.base_price).toLocaleString()}</div>
                                <div style={{ fontSize: '0.8rem', opacity: 0.5 }}>Net Per Participant</div>
                            </div>
                            <Link
                                to={`/booking/safari/${pkg.id}`}
                                className="safari-btn-gold"
                                style={{ cursor: 'pointer', border: 'none', width: '100%', textAlign: 'center', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '10px' }}
                            >
                                <span>Book This Expedition</span>
                                <ArrowRight size={16} />
                            </Link>
                            <Link to="/safaris/packages" className="safari-btn-outline">Return to Collection</Link>
                        </div>

                        {/* Inclusions */}
                        <div className="safari-sb-card">
                            <h3 className="safari-sb-title">Inclusions</h3>
                            <ul className="safari-sb-list">
                                {pkg.inclusions && pkg.inclusions.map((inc, i) => <li key={i}>{inc}</li>)}
                            </ul>
                        </div>

                        {/* Exclusions */}
                        <div className="safari-sb-card">
                            <h3 className="safari-sb-title">Exclusions</h3>
                            <ul className="safari-sb-list">
                                {pkg.exclusions && pkg.exclusions.map((exc, i) => <li key={i}>{exc}</li>)}
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
};
