import React, { useEffect, useMemo } from 'react';
import { useParams, Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { safarisData } from '../../data/safarisData';
import '../../styles/safari-packages.css';

export const SafariPackageDetail = () => {
    const { packageId } = useParams();

    useEffect(() => {
        window.scrollTo(0, 0);
    }, [packageId]);

    const pkg = useMemo(() => safarisData.find(p => p.id === packageId), [packageId]);

    if (!pkg) return (
        <div style={{ padding: '150px 20px', textAlign: 'center', background: 'var(--dark)', color: 'white', minHeight: '100vh' }}>
            <h1>Itinerary Not Found</h1>
            <Link to="/safaris" style={{ color: 'var(--gold)' }}>Return to Safaris</Link>
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
            {/* HERO */}
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

            {/* METRICS BAR */}
            <section className="safari-det-metrics">
                <div className="safari-metric">
                    <span className="safari-m-label">Duration</span>
                    <span className="safari-m-val">{pkg.duration}</span>
                </div>
                <div className="safari-metric">
                    <span className="safari-m-label">Destinations</span>
                    <span className="safari-m-val">{pkg.parks}</span>
                </div>
                <div className="safari-metric" style={{ marginLeft: 'auto' }}>
                    <span className="safari-m-label">Starting Price</span>
                    <span className="safari-m-val" style={{ color: 'var(--gold)' }}>{pkg.price} <span style={{ fontSize: '0.8rem', color: 'rgba(255,255,255,0.5)' }}>pp</span></span>
                </div>
            </section>

            {/* MAIN CONTENT */}
            <section className="safari-det-body">
                {/* ITINERARY LIST */}
                <div className="safari-itin-col">
                    <h2 className="safari-itin-head">The Journey</h2>
                    <motion.div
                        initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-50px" }}
                        variants={staggerContainer}
                    >
                        {pkg.itinerary.map((day, idx) => (
                            <motion.div key={idx} className="safari-day-card" variants={fadeInUp}>
                                <div className="safari-day-dot"></div>
                                <span className="safari-day-num">Day {day.day}</span>
                                <h3 className="safari-day-title">{day.title}</h3>
                                <p className="safari-day-desc">{day.desc}</p>

                                <div className="safari-day-meta">
                                    <div className="safari-day-meta-item">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                        <span>{day.accommodation}</span>
                                    </div>
                                    <div className="safari-day-meta-item">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                                        <span>{day.meals}</span>
                                    </div>
                                </div>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>

                {/* SIDEBAR */}
                <div className="safari-sidebar-col">
                    <div className="safari-sidebar">
                        {/* Book Card */}
                        <div className="safari-sb-card safari-book-card">
                            <h3 className="safari-sb-title" style={{ border: 'none', marginBottom: '10px' }}>Reserve Your Safari</h3>
                            <div className="safari-pkg-price" style={{ color: 'var(--gold)' }}>
                                {pkg.price} <span style={{ fontSize: '1rem', color: 'rgba(255,255,255,0.5)' }}>per person</span>
                            </div>
                            <Link to="/contact" className="safari-btn-gold">Enquire Now</Link>
                            <Link to="/safaris" className="safari-btn-outline" style={{ display: 'block', textAlign: 'center', marginTop: '15px' }}>Customise This Trip</Link>
                        </div>

                        {/* Inclusions */}
                        <div className="safari-sb-card">
                            <h3 className="safari-sb-title">What's Included</h3>
                            <ul className="safari-sb-list inc">
                                {pkg.inclusions.map((inc, i) => <li key={i}>{inc}</li>)}
                            </ul>
                        </div>

                        {/* Exclusions */}
                        <div className="safari-sb-card">
                            <h3 className="safari-sb-title">Not Included</h3>
                            <ul className="safari-sb-list exc">
                                {pkg.exclusions.map((exc, i) => <li key={i}>{exc}</li>)}
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
};
