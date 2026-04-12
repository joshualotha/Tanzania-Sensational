import React, { useEffect, useMemo, useState } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Clock, Activity, Camera, TrendingUp } from 'lucide-react';
import { visualsData } from '../../../data/visualsData';
import { useVisuals } from '../../../context/VisualsContext';
import { trekkingService } from '../../../services/api';
import { PrivateTrekPricing } from '../../../components/pricing/PrivateTrekPricing';
import '../../../styles/ultra-premium.css';

const Marangu = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);
    const visuals = useVisuals();

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const [route, setRoute] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        let mounted = true;
        const run = async () => {
            setLoading(true);
            try {
                const res = await trekkingService.getBySlug('marangu');
                if (!mounted) return;
                setRoute(res.data || null);
            } finally {
                if (!mounted) return;
                setLoading(false);
            }
        };
        run();
        return () => { mounted = false; };
    }, []);

    const departures = useMemo(() => {
        return Array.isArray(route?.departures) ? route.departures : [];
    }, [route?.departures]);

    return (
        <div className="lux-root">
            {/* ─── HERO ─── */}
            <section className="lux-hero">
                <img
                    src={route?.hero_image || visuals.getSingle('trekking.routes.marangu', visualsData.trekking.routes.marangu)}
                    alt="Marangu Route Landscape"
                />
                <div className="lux-hero-overlay"></div>
                <div className="lux-hero-content">
                    <motion.span className="lux-hero-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>The Classic Trail</motion.span>
                    <motion.h1 className="lux-hero-title" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.1 }}>
                        Marangu <em>Route.</em>
                    </motion.h1>
                </div>
            </section>

            {/* ─── QUICK STATS ─── */}
            <div className="lux-stats-container">
                <motion.div
                    className="lux-stats-grid"
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ delay: 0.4, duration: 1 }}
                >
                    <div className="lux-stat-item">
                        <Clock size={16} className="lux-stat-icon" />
                        <span className="lux-stat-label">Duration</span>
                        <div className="lux-stat-value">6 Days</div>
                    </div>
                    <div className="lux-stat-item">
                        <Activity size={16} className="lux-stat-icon" />
                        <span className="lux-stat-label">Difficulty</span>
                        <div className="lux-stat-value">Moderate</div>
                    </div>
                    <div className="lux-stat-item">
                        <Camera size={16} className="lux-stat-icon" />
                        <span className="lux-stat-label">Accommodation</span>
                        <div className="lux-stat-value">A-Frame Huts</div>
                    </div>
                    <div className="lux-stat-item">
                        <TrendingUp size={16} className="lux-stat-icon" />
                        <span className="lux-stat-label">Success Rate</span>
                        <div className="lux-stat-value">80%+</div>
                    </div>
                </motion.div>
            </div>

            {/* ─── EDITORIAL NARRATIVE ─── */}
            <section className="lux-section">
                <div className="lux-editorial-grid">
                    <motion.div
                        initial={{ opacity: 0, scale: 0.95 }}
                        whileInView={{ opacity: 1, scale: 1 }}
                        viewport={{ once: true }}
                        transition={{ duration: 1.5, ease: "easeOut" }}
                        className="lux-image-wrapper"
                    >
                        <img
                            src={route?.editorial_image || visuals.getSingle('trekking.routes.maranguEditorial', visualsData.trekking.routes.maranguEditorial)}
                            alt="Marangu Huts"
                        />
                        <div className="lux-image-caption">The iconic A-frame dormitories unique to the Marangu Route.</div>
                    </motion.div>
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-100px" }} variants={fadeInUp}>
                        <h2 className="lux-heading">Tradition & <em>Comfort.</em></h2>
                        <p className="lux-body">
                            The Marangu Route, affectionately known as the "Coca-Cola" route, is the oldest and most established path to the summit of Kilimanjaro. It carries a rich sense of history, walked by the early pioneers of African mountaineering.
                        </p>
                        <p className="lux-body">
                            It remains the only route on the mountain that offers accommodation in permanent A-frame dormitory huts, providing a welcome layer of comfort and shelter for those who prefer not to sleep under canvas.
                        </p>
                        <p className="lux-body">
                            While the slope is wonderfully gradual, its shorter duration dictates a rapid ascent profile. We strongly mandate a 6-day itinerary containing an essential acclimatization day at Horombo Hut to maximize your chances of a triumphant summit.
                        </p>
                    </motion.div>
                </div>
            </section>

            {/* ─── EXPEDITION PACKAGES ─── */}
            <section className="lux-packages-section">
                <h2 className="lux-heading" style={{ textAlign: 'center', fontSize: '2.5rem', marginBottom: '10px' }}>Available <em>Packages.</em></h2>
                <div className="lux-packages-grid">
                    {loading ? (
                        [1, 2, 3].map((i) => (
                            <div key={i} className="lux-package-card skeleton" style={{ height: 420, background: 'rgba(255,255,255,0.08)' }} />
                        ))
                    ) : (route?.variations || []).length === 0 ? (
                        <div style={{ textAlign: 'center', width: '100%', opacity: 0.8 }}>
                            <p className="lux-body">No packages are currently available for this route.</p>
                            <Link to="/contact" className="lux-btn" style={{ marginTop: 20, display: 'inline-flex' }}>Contact Us</Link>
                        </div>
                    ) : (
                        (route?.variations || []).map((pkg, index) => (
                            <motion.div
                                key={pkg.id}
                                className="lux-package-card"
                                initial={{ opacity: 0, y: 30 }}
                                whileInView={{ opacity: 1, y: 0 }}
                                viewport={{ once: true, margin: "-50px" }}
                                transition={{ duration: 0.8, delay: index * 0.1 }}
                            >
                                <div className="lux-package-image">
                                    <img src={pkg.hero_image || visualsData.trekking.routes.marangu} alt={pkg.name} />
                                </div>
                                <div className="lux-package-content">
                                    <div>
                                        <span className="lux-package-duration">{pkg.duration} Days • {pkg.difficulty}</span>
                                        <h3 className="lux-package-title">{pkg.name}</h3>
                                        <p className="lux-package-desc">
                                            {pkg.description ? pkg.description.substring(0, 120) + '...' : `Experience the ${pkg.name} with our expert guides.`}
                                        </p>
                                    </div>
                                    <div className="lux-package-footer">
                                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                                            <span style={{ color: 'var(--gold)', fontFamily: 'var(--font-heading)', fontSize: '1.15rem' }}>
                                                From ${Math.round(pkg.base_price).toLocaleString()} <span style={{ opacity: 0.6, fontSize: '0.8rem' }}>/pp</span>
                                            </span>
                                            <Link to={`/trekking/kilimanjaro/marangu/${pkg.id}`} className="lux-link-arrow">
                                                View details
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"><path d="M5 12h14M12 5l7 7-7 7" /></svg>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </motion.div>
                        ))
                    )}
                </div>
            </section>

            <PrivateTrekPricing routeSlug="marangu" fallbackPricePerPerson={route?.base_price ?? null} />

            {/* ─── CTA ─── */}
            <section className="lux-cta">
                <h2 className="lux-heading" style={{ marginBottom: '40px' }}>Begin Your <em>Ascent.</em></h2>
                <Link to="/contact" className="lux-btn">
                    Inquire About Marangu
                </Link>
            </section>
        </div>
    );
};

export default Marangu;
