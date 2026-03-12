import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../../data/visualsData';
import { packagesData } from '../../../data/packagesData';
import '../../../styles/ultra-premium.css';

const Marangu = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const packages = packagesData.filter(p => p.routeId === 'marangu');

    return (
        <div className="lux-root">
            {/* ─── HERO ─── */}
            <section className="lux-hero">
                <img
                    src={visualsData.trekking.routes.marangu}
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
                        <span className="lux-stat-label">Duration</span>
                        <div className="lux-stat-value">6 Days</div>
                    </div>
                    <div className="lux-stat-item">
                        <span className="lux-stat-label">Difficulty</span>
                        <div className="lux-stat-value">Moderate</div>
                    </div>
                    <div className="lux-stat-item">
                        <span className="lux-stat-label">Accommodation</span>
                        <div className="lux-stat-value">A-Frame Huts</div>
                    </div>
                    <div className="lux-stat-item">
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
                            src={visualsData.trekking.routes.maranguEditorial}
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

            {/* ─── FULL BLEED PARALLAX ─── */}
            <section className="lux-full-bleed">
                <img
                    src={visualsData.trekking.common.trailLandscape}
                    alt="Kilimanjaro Trail"
                />
            </section>

            {/* ─── EXPEDITION PACKAGES ─── */}
            <section className="lux-packages-section">
                <h2 className="lux-heading" style={{ textAlign: 'center', fontSize: '2.5rem', marginBottom: '10px' }}>Available <em>Expeditions.</em></h2>
                <div className="lux-packages-grid">
                    {packages.map((pkg, index) => (
                        <motion.div
                            key={index}
                            className="lux-package-card"
                            initial={{ opacity: 0, y: 30 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true, margin: "-50px" }}
                            transition={{ duration: 0.8, delay: index * 0.1 }}
                        >
                            <div className="lux-package-image">
                                <img src={pkg.heroImg} alt={pkg.title} />
                            </div>
                            <div className="lux-package-content">
                                <div>
                                    <span className="lux-package-duration">{pkg.duration}</span>
                                    <h3 className="lux-package-title">{pkg.title.replace(/^[0-9]+ Days /, '')}</h3>
                                    <p className="lux-package-desc">{pkg.overview}</p>
                                </div>
                                <div className="lux-package-footer">
                                    <Link to={`/trekking/kilimanjaro/marangu/${pkg.id}`} className="lux-link-arrow">
                                        View Details
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"><path d="M5 12h14M12 5l7 7-7 7" /></svg>
                                    </Link>
                                </div>
                            </div>
                        </motion.div>
                    ))}
                </div>
            </section>

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
