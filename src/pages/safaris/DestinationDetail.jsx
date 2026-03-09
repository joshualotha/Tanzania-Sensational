import React, { useEffect, useRef } from 'react';
import { useParams, Navigate, Link } from 'react-router-dom';
import { motion, useScroll, useTransform } from 'framer-motion';
import { destinationsData } from '../../data/destinationsData';
import '../../styles/destination-premium.css';

export const DestinationDetail = () => {
    const { id } = useParams();
    const destination = destinationsData.find(d => d.id === id);

    const heroRef = useRef(null);
    const { scrollYProgress } = useScroll({ target: heroRef, offset: ["start start", "end start"] });
    const heroY = useTransform(scrollYProgress, [0, 1], [0, 250]);
    const heroOpacity = useTransform(scrollYProgress, [0, 0.8], [1, 0]);

    useEffect(() => {
        window.scrollTo(0, 0);
    }, [id]);

    if (!destination) {
        return <Navigate to="/safaris" replace />;
    }

    const fadeInUp = {
        hidden: { opacity: 0, y: 40 },
        visible: { opacity: 1, y: 0, transition: { duration: 1, ease: [0.22, 1, 0.36, 1] } }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.15, delayChildren: 0.2 } }
    };

    return (
        <div className="dest-detail-root">
            {/* HERO SECTION */}
            <section ref={heroRef} className="dest-hero">
                <motion.div style={{ y: heroY }} className="dest-hero-bg">
                    <img src={destination.heroImg} alt={destination.name} />
                </motion.div>
                <div className="dest-hero-overlay"></div>
                <motion.div
                    className="dest-hero-content"
                    style={{ opacity: heroOpacity }}
                    initial="hidden"
                    animate="visible"
                    variants={staggerContainer}
                >
                    <motion.span className="dest-hero-tag" variants={fadeInUp}>{destination.tag}</motion.span>
                    <motion.h1 className="dest-hero-title" variants={fadeInUp}>{destination.name}</motion.h1>
                    <motion.p className="dest-hero-subtitle" variants={fadeInUp}>{destination.subtitle}</motion.p>
                </motion.div>
            </section>

            {/* OVERVIEW SECTION */}
            <section className="dest-overview-section">
                <motion.div
                    className="dest-overview-text"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: "-100px" }}
                    variants={fadeInUp}
                >
                    <p>{destination.overview}</p>
                    {/* Add an extra paragraph simulating more editorial content */}
                    <p>Every journey into {destination.name} is a uniquely unscripted encounter with the raw forces of nature. From the golden hours at dawn when the predators are most active, to the serene, dusty sunsets that wash the landscape in impossible shades of orange, this is where the romance of the African safari truly lives.</p>
                </motion.div>

                <motion.div
                    className="dest-facts-panel"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: "-100px" }}
                    variants={fadeInUp}
                >
                    <div className="dest-fact-group">
                        <span className="dest-fact-label">Optimal Duration</span>
                        <div className="dest-fact-value">{destination.duration}</div>
                    </div>
                    <div className="dest-fact-group">
                        <span className="dest-fact-label">Best Time To Visit</span>
                        <div className="dest-fact-value">{destination.bestTime}</div>
                    </div>
                    <div className="dest-fact-group">
                        <span className="dest-fact-label">Resident Wildlife</span>
                        <div className="dest-wildlife-tags">
                            {destination.wildlifeList.map((animal, i) => (
                                <span key={i} className="dest-wildlife-tag">{animal}</span>
                            ))}
                        </div>
                    </div>

                    <div style={{ marginTop: '50px' }}>
                        <Link to="/contact" className="premium-btn-outline" style={{ display: 'block', textAlign: 'center', borderColor: 'var(--gold)', color: 'var(--gold)' }}>Include in Custom Safari</Link>
                    </div>
                </motion.div>
            </section>

            {/* GALLERY SECTION */}
            <section className="dest-gallery-section">
                <motion.div
                    className="dest-gallery-head"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true }}
                    variants={fadeInUp}
                >
                    <h2 className="dest-gallery-title">Visual <em>Anthology</em>.</h2>
                    <span style={{ color: 'var(--gold)', letterSpacing: '0.2em', textTransform: 'uppercase', fontSize: '0.75rem', marginTop: '15px', display: 'block' }}>Glimpses of {destination.name}</span>
                </motion.div>

                <div className="dest-gallery-grid">
                    {destination.gallery.map((imgUrl, i) => {
                        // Make every 3rd image a landscape span
                        const isLandscape = i % 3 === 0;
                        return (
                            <motion.div
                                key={i}
                                className={`dest-gallery-item ${isLandscape ? 'landscape' : ''}`}
                                initial={{ opacity: 0, scale: 0.95 }}
                                whileInView={{ opacity: 1, scale: 1 }}
                                viewport={{ once: true, margin: "-50px" }}
                                transition={{ duration: 0.8, delay: (i % 3) * 0.1 }}
                            >
                                <img src={imgUrl} alt={`${destination.name} Gallery ${i + 1}`} />
                            </motion.div>
                        );
                    })}
                </div>
            </section>

        </div>
    );
};
