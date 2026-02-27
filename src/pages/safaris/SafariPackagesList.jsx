import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { safarisData } from '../../data/safarisData';
import '../../styles/safari-packages.css';

export const SafariPackagesList = () => {
    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 40 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.15, delayChildren: 0.1 } }
    };

    return (
        <div className="safari-pkgs-root">
            {/* HERO */}
            <section className="safari-pkgs-hero">
                <div className="safari-pkgs-bg">
                    <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?w=2000&q=85&auto=format&fit=crop" alt="Safari Packages Hero" />
                </div>
                <div className="safari-pkgs-overlay"></div>
                <motion.div
                    className="safari-pkgs-content"
                    initial="hidden" animate="visible" variants={staggerContainer}
                >
                    <motion.h1 className="safari-pkgs-title" variants={fadeInUp}>
                        The <em>Collection</em>
                    </motion.h1>
                    <motion.p className="safari-pkgs-subtitle" variants={fadeInUp}>
                        Uncompromising wilderness expeditions curated for the discerning traveler.
                    </motion.p>
                </motion.div>
            </section>

            {/* PACKAGE GRID */}
            <section className="safari-pkgs-grid-sec">
                <motion.div
                    className="safari-pkg-grid"
                    initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-50px" }}
                    variants={staggerContainer}
                >
                    {safarisData.map((pkg) => (
                        <motion.div key={pkg.id} variants={fadeInUp}>
                            <Link to={`/safaris/packages/${pkg.id}`} className="safari-pkg-card">
                                <div className="safari-pkg-img">
                                    <img src={pkg.heroImg} alt={pkg.title} />
                                    <div className="safari-pkg-badge">{pkg.badge}</div>
                                </div>
                                <div className="safari-pkg-info">
                                    <div className="safari-pkg-meta">{pkg.duration} • {pkg.parks}</div>
                                    <h2 className="safari-pkg-name">{pkg.title}</h2>
                                    <p className="safari-pkg-desc">{pkg.overview.substring(0, 120)}...</p>

                                    <div className="safari-pkg-foot">
                                        <div className="safari-pkg-price">
                                            <span>From </span>{pkg.price}
                                        </div>
                                        <div className="safari-pkg-arr">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round">
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                                <polyline points="12 5 19 12 12 19"></polyline>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </Link>
                        </motion.div>
                    ))}
                </motion.div>
            </section>
        </div>
    );
};
