import React, { useEffect } from 'react';
import { Link } from 'react-router-dom';
import { Map, Zap, Coffee, Tent, Info } from 'lucide-react';
import { visualsData } from '../../../data/visualsData';
import '../../../styles/trekking-prep.css';

const BestRoutes = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    return (
        <div className="prep-savanna-root">
            {/* ─── HERO ─── */}
            <section className="prep-hero">
                <div className="prep-hero-bg">
                    <img
                        src={visualsData.trekking.prep.bestRoutes}
                        alt="Kilimanjaro Landscape"
                    />
                    <div className="prep-hero-overlay"></div>
                </div>
                <div className="prep-hero-content">
                    <motion.span className="prep-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>The Ascent Strategy</motion.span>
                    <motion.h1 className="prep-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>Choosing Your <em>Route.</em></motion.h1>
                </div>
            </section>

            {/* ─── EDITORIAL CONTENT ─── */}
            <section className="prep-grid-section">
                <div className="prep-editorial-grid">
                    <motion.div
                        className="prep-editorial-img-wrap"
                        initial={{ opacity: 0, x: -50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 1 }}
                    >
                        <img
                            src={visualsData.trekking.prep.bestRoutesEditorial}
                            className="prep-editorial-img"
                            alt="The Lemosho Trail"
                        />
                        <span className="prep-img-caption">The Lemosho Trail - Wilderness & Majesty</span>
                    </motion.div>
                    <div className="prep-editorial-text">
                        <motion.span className="prep-eyebrow" initial="hidden" whileInView="visible" variants={fadeInUp}>A Critical Choice</motion.span>
                        <h2 className="prep-section-title">Success is Built on <em>Geography.</em></h2>
                        <p className="prep-body-text">
                            There are six main Mount Kilimanjaro climbing routes. These routes vary not only in length, cost, and scenery; they also have different difficulty levels and success rates. Selecting a Kilimanjaro climb route is one of the most important decisions you have to make.
                        </p>
                        <p className="prep-body-text">
                            There is no single "best" route. Which path up Kilimanjaro is best for you depends on several factors: the time and money you have available, previous experience and fitness, the time of the year, and personal preference. Let's break down the primary routes.
                        </p>
                    </div>
                </div>
            </section>

            {/* ─── ROUTE DETAILS ─── */}
            <section className="prep-info-grid">
                {/* Lemosho */}
                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <Map size={32} color="var(--savanna-gold)" />
                        <h3 className="prep-info-card-title">Lemosho Route</h3>
                    </div>
                    <ul className="prep-info-list" style={{ marginBottom: '20px' }}>
                        <li><span>Duration</span> <span>8 Days recommended</span></li>
                        <li><span>Difficulty</span> <span>Moderate to High</span></li>
                        <li><span>Success Rate</span> <span>High (98%)</span></li>
                    </ul>
                    <p className="prep-body-text" style={{ fontSize: '1rem' }}>
                        Considered the most beautiful route, the eight-day itinerary allows for maximum time for acclimatization. It traverses various ecosystems including rainforest, heath, and alpine desert, providing a higher chance of encountering wildlife. It joins the Machame route on the Shira Plateau.
                    </p>
                </motion.div>

                {/* Machame */}
                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true, delay: 0.1 }}>
                    <div className="prep-info-card-header">
                        <Zap size={32} color="var(--savanna-gold)" />
                        <h3 className="prep-info-card-title">Machame Route</h3>
                    </div>
                    <ul className="prep-info-list" style={{ marginBottom: '20px' }}>
                        <li><span>Duration</span> <span>6-7 Days</span></li>
                        <li><span>Difficulty</span> <span>High (Steep ascents)</span></li>
                        <li><span>Success Rate</span> <span>High</span></li>
                    </ul>
                    <p className="prep-body-text" style={{ fontSize: '1rem' }}>
                        The "Whiskey Route" is the most popular climbing route. It has the richest forested area on the mountain and offers diverse landscapes. It provides ample time for acclimatization, increasing your chances, but gets very muddy during the wet season.
                    </p>
                </motion.div>

                {/* Marangu */}
                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <Coffee size={32} color="var(--savanna-gold)" />
                        <h3 className="prep-info-card-title">Marangu Route</h3>
                    </div>
                    <ul className="prep-info-list" style={{ marginBottom: '20px' }}>
                        <li><span>Duration</span> <span>5-6 Days</span></li>
                        <li><span>Difficulty</span> <span>Moderate</span></li>
                        <li><span>Success Rate</span> <span>Lower (due to fast ascent)</span></li>
                    </ul>
                    <p className="prep-body-text" style={{ fontSize: '1rem' }}>
                        The "Coca-Cola" route. It is the only route that offers hut accommodation rather than camping. Popular for its comfort, it has a gentle slope initially prior to the tough summit attempt from Kibo Hut. Regarded as the least difficult profile, but suffers from low acclimatization profiles.
                    </p>
                </motion.div>

                {/* Rongai */}
                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true, delay: 0.1 }}>
                    <div className="prep-info-card-header">
                        <Info size={32} color="var(--savanna-gold)" />
                        <h3 className="prep-info-card-title">Rongai Route</h3>
                    </div>
                    <ul className="prep-info-list" style={{ marginBottom: '20px' }}>
                        <li><span>Duration</span> <span>6-7 Days</span></li>
                        <li><span>Difficulty</span> <span>Moderate</span></li>
                        <li><span>Success Rate</span> <span>Good</span></li>
                    </ul>
                    <p className="prep-body-text" style={{ fontSize: '1rem' }}>
                        A more gradual ascent preferred by those with little backpacking experience. Less traffic and more remote, starting from the northern side providing different perspectives. Highly recommended during the rainy season as it receives the least amount of rain.
                    </p>
                </motion.div>

                {/* Northern Circuit */}
                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <Tent size={32} color="var(--savanna-gold)" />
                        <h3 className="prep-info-card-title">Northern Circuit</h3>
                    </div>
                    <ul className="prep-info-list" style={{ marginBottom: '20px' }}>
                        <li><span>Duration</span> <span>9 Days</span></li>
                        <li><span>Difficulty</span> <span>Moderate to High</span></li>
                        <li><span>Success Rate</span> <span>Highest (Near 100%)</span></li>
                    </ul>
                    <p className="prep-body-text" style={{ fontSize: '1rem' }}>
                        The longest, newest, and most spectacular route. It follows Lemosho before deviating to traverse the quiet northern slopes. It offers unparalleled acclimatization time and completely avoids the crowds of the southern circuits.
                    </p>
                </motion.div>

                {/* Umbwe */}
                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true, delay: 0.1 }}>
                    <div className="prep-info-card-header">
                        <Zap size={32} color="#666" />
                        <h3 className="prep-info-card-title">Umbwe Route</h3>
                    </div>
                    <ul className="prep-info-list" style={{ marginBottom: '20px' }}>
                        <li><span>Duration</span> <span>6-7 Days</span></li>
                        <li><span>Difficulty</span> <span>Very High</span></li>
                        <li><span>Success Rate</span> <span>Lower</span></li>
                    </ul>
                    <p className="prep-body-text" style={{ fontSize: '1rem' }}>
                        Known as the most challenging and steepest route, recommended exclusively for experienced climbers. It offers a direct, secluded ascent starting with a steep climb through dense rainforest, eventually joining the Machame route at Barranco Camp.
                    </p>
                </motion.div>
            </section>

            {/* ─── CTA BAND ─── */}
            <section className="prep-cta-band">
                <motion.h2 className="prep-cta-title" initial="hidden" whileInView="visible" variants={fadeInUp}>Which trail will be <em>Yours?</em></motion.h2>
                <div className="prep-btn-group">
                    <Link to="/contact" className="prep-btn-sand">Commission Custom Trip</Link>
                    <Link to="/safaris" className="prep-btn-outline">Explore Safari Add-ons</Link>
                </div>
            </section>
        </div>
    );
};

export default BestRoutes;
