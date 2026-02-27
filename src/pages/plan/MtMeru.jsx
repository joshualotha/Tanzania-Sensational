import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import '../../styles/utility-pages-premium.css';

export const MtMeru = () => {
    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.15, delayChildren: 0.1 } }
    };

    return (
        <div className="utility-root">
            <section className="utility-hero">
                <div className="utility-hero-bg">
                    <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80" alt="Mount Meru Landscape" style={{ filter: 'brightness(0.5)' }} />
                </div>
                <div className="utility-hero-overlay"></div>
                <motion.div className="utility-hero-content" initial="hidden" animate="visible" variants={staggerContainer}>
                    <motion.span className="utility-hero-eyebrow" variants={fadeInUp}>The Perfect Acclimatization</motion.span>
                    <motion.h1 className="utility-hero-title" variants={fadeInUp}>Mount Meru Trek</motion.h1>
                    <motion.p className="utility-hero-subtitle" variants={fadeInUp}>
                        Often overlooked, Tanzania's second-highest peak is a breathtaking, uncrowded alternative and the ultimate preparation for a Kilimanjaro summit.
                    </motion.p>
                </motion.div>
            </section>

            <section className="utility-content">
                <motion.div className="utility-grid" initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-50px" }} variants={staggerContainer}>
                    <motion.div className="util-card" variants={fadeInUp}>
                        <div className="util-card-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polygon points="12 2 2 22 22 22"></polygon></svg>
                        </div>
                        <h3 className="util-card-title">The Ash Cone</h3>
                        <p className="util-card-p">Summiting Meru (4,562m) involves trekking along a spectacular crater rim with peerless views of the ash cone deep within the caldera, all while gazing across the plains at Kilimanjaro.</p>
                    </motion.div>

                    <motion.div className="util-card" variants={fadeInUp}>
                        <div className="util-card-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="M12 22s-8-4.5-8-11.8A8 8 0 0 1 12 2a8 8 0 0 1 8 8.2c0 7.3-8 11.8-8 11.8z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        </div>
                        <h3 className="util-card-title">A Walking Safari</h3>
                        <p className="util-card-p">Because Meru is located within Arusha National Park, the lower slopes require an armed ranger. You will likely walk past giraffes, elephants, and buffalo on your first day.</p>
                    </motion.div>

                    <motion.div className="util-card" variants={fadeInUp}>
                        <div className="util-card-icon">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        </div>
                        <h3 className="util-card-title">Itineraries</h3>
                        <ul className="util-card-list">
                            <li><strong>3-Day Fast Trek:</strong> For extremely fit climbers acclimatizing for Kili.</li>
                            <li><strong>4-Day Classic Trek:</strong> The sensible pace, offering excellent acclimatization.</li>
                        </ul>
                    </motion.div>
                </motion.div>

                <div style={{ textAlign: 'center', marginTop: '80px' }}>
                    <Link to="/contact" className="dep-btn" style={{ padding: '15px 40px', fontSize: '1rem' }}>Enquire About Mt. Meru</Link>
                </div>
            </section>
        </div>
    );
};
