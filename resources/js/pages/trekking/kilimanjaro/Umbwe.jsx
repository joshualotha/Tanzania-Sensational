import React, { useEffect, useMemo, useState } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Clock, Activity, Camera, TrendingUp } from 'lucide-react';
import { visualsData } from '../../../data/visualsData';
import { trekkingService } from '../../../services/api';
import { PrivateTrekPricing } from '../../../components/pricing/PrivateTrekPricing';
import '../../../styles/ultra-premium.css';

const Umbwe = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);

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
                const res = await trekkingService.getBySlug('umbwe');
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
                    src={visualsData.trekking.routes.umbwe}
                    alt="Umbwe Route Ridge"
                />
                <div className="lux-hero-overlay"></div>
                <div className="lux-hero-content">
                    <motion.span className="lux-hero-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>The Vertical Challenge</motion.span>
                    <motion.h1 className="lux-hero-title" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.1 }}>
                        Umbwe <em>Route.</em>
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
                        <div className="lux-stat-value">Extreme</div>
                    </div>
                    <div className="lux-stat-item">
                        <Camera size={16} className="lux-stat-icon" />
                        <span className="lux-stat-label">Scenery</span>
                        <div className="lux-stat-value">Dramatic</div>
                    </div>
                    <div className="lux-stat-item">
                        <TrendingUp size={16} className="lux-stat-icon" />
                        <span className="lux-stat-label">Success Rate</span>
                        <div className="lux-stat-value">70%+</div>
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
                            src={visualsData.trekking.routes.umbweEditorial}
                            alt="Steep Ridge"
                        />
                        <div className="lux-image-caption">The steepest, most direct path to the roof of Africa.</div>
                    </motion.div>
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-100px" }} variants={fadeInUp}>
                        <h2 className="lux-heading">Short, Steep & <em>Pure.</em></h2>
                        <p className="lux-body">
                            The Umbwe Route is legendary. It is the shortest, steepest, most unyielding path to the summit. It is an ascent that demands respect, known for its rapid altitude gain and dramatic, sheer ridges.
                        </p>
                        <p className="lux-body">
                            Because of its vertical trajectory, the acclimatization window is severely compressed. Consequently, its summit success rate is the lowest of any route. It is an undertaking reserved exclusively for veteran mountaineers who possess absolute confidence in their fitness and their body's ability to adapt rapidly to thin air.
                        </p>
                        <p className="lux-body">
                            If you possess the necessary experience, Umbwe rewards you with a raw, intensely solitary climb showcasing some of the most spectacular, sheer topography on the continent.
                        </p>
                    </motion.div>
                </div>
            </section>

            {/* ─── FULL BLEED PARALLAX ─── */}
            <section className="lux-full-bleed">
                <img
                    src={visualsData.trekking.routes.northernEditorial}
                    alt="Looking down from ridge"
                />
            </section>

            {/* ─── EXPEDITION PACKAGES ─── */}
            <section className="lux-packages-section">
                <h2 className="lux-heading" style={{ textAlign: 'center', fontSize: '2.5rem', marginBottom: '10px' }}>Available <em>Expeditions.</em></h2>
                <div className="lux-packages-grid">
                    {loading ? (
                        [1, 2, 3].map((i) => (
                            <div key={i} className="lux-package-card skeleton" style={{ height: 420, background: 'rgba(255,255,255,0.08)' }} />
                        ))
                    ) : departures.length === 0 ? (
                        <div style={{ textAlign: 'center', width: '100%', opacity: 0.8 }}>
                            <p className="lux-body">No upcoming departures are currently published for this route.</p>
                            <Link to="/booking" className="lux-btn" style={{ marginTop: 20, display: 'inline-flex' }}>Request a Private Date</Link>
                        </div>
                    ) : (
                        departures.map((dep, index) => {
                            const start = dep.departure_date ? new Date(dep.departure_date) : null;
                            const end = dep.return_date ? new Date(dep.return_date) : null;
                            const dateLabel = start
                                ? `${start.toLocaleDateString(undefined, { month: 'short', day: 'numeric' })} – ${(end || start).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' })}`
                                : 'TBA';
                            const price = `$${Math.round((dep.price_cents || 0) / 100).toLocaleString()}`;

                            return (
                                <motion.div
                                    key={dep.id}
                                    className="lux-package-card"
                                    initial={{ opacity: 0, y: 30 }}
                                    whileInView={{ opacity: 1, y: 0 }}
                                    viewport={{ once: true, margin: "-50px" }}
                                    transition={{ duration: 0.8, delay: index * 0.1 }}
                                >
                                    <div className="lux-package-image">
                                        <img src={route?.hero_image || visualsData.trekking.routes.umbwe} alt="Umbwe departure" />
                                    </div>
                                    <div className="lux-package-content">
                                        <div>
                                            <span className="lux-package-duration">{dateLabel}</span>
                                            <h3 className="lux-package-title">{price} <span style={{ opacity: 0.6, fontSize: '0.9rem' }}>/pp</span></h3>
                                            <p className="lux-package-desc">{dep.status || 'Available'} • {dep.available_seats} seats left</p>
                                        </div>
                                        <div className="lux-package-footer">
                                            <div style={{ display: 'flex', justifyContent: 'space-between', gap: 14, alignItems: 'center' }}>
                                                <Link
                                                    to={`/booking/departure/${dep.id}`}
                                                    className="lux-link-arrow"
                                                >
                                                    Request booking
                                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"><path d="M5 12h14M12 5l7 7-7 7" /></svg>
                                                </Link>
                                                <Link to={`/trekking/kilimanjaro/umbwe/${dep.id}`} className="lux-link-arrow" style={{ opacity: 0.8 }}>
                                                    View details
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </motion.div>
                            );
                        })
                    )}
                </div>
            </section>

            <PrivateTrekPricing routeSlug="umbwe" />

            {/* ─── CTA ─── */}
            <section className="lux-cta">
                <h2 className="lux-heading" style={{ marginBottom: '40px' }}>Begin Your <em>Ascent.</em></h2>
                <Link to="/contact" className="lux-btn">
                    Inquire About Umbwe
                </Link>
            </section>
        </div>
    );
};

export default Umbwe;
