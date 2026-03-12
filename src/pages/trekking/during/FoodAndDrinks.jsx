import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../../data/visualsData';
import '../../../styles/safaridraft-trek.css';

// Heroicons (Outline)
const BeakerIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
        <path strokeLinecap="round" strokeLinejoin="round" d="M9.75 3.104v17.792m0-17.792a4.474 4.474 0 0 0-4.474 4.474v13.318a4.474 4.474 0 0 0 4.474 4.474m0-17.792a4.474 4.474 0 0 1 4.474 4.474v13.318a4.474 4.474 0 0 1-4.474 4.474M15.75 6.75l-4.5 4.5m4.5 9-4.5-9" />
    </svg>
);

const UtensilsIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
        <path strokeLinecap="round" strokeLinejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
    </svg>
);

const FoodAndDrinks = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 20 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.16, 1, 0.3, 1] } }
    };

    return (
        <div className="sd-root">
            {/* ─── HERO ─── */}
            <section className="sd-hero">
                <div className="sd-hero-bg">
                    <img
                        src={visualsData.trekking.during.food}
                        alt="Cooking at altitude"
                    />
                    <div className="sd-hero-overlay"></div>
                </div>
                <div className="sd-hero-content">
                    <motion.span className="sd-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Expedition Nutrition</motion.span>
                    <motion.h1 className="sd-h1" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.1 }}>
                        Food & <em>Drinks.</em>
                    </motion.h1>
                </div>
            </section>

            {/* ─── NUTRITION STRATEGY ─── */}
            <section className="sd-section">
                <div className="sd-grid-editorial">
                    <motion.div initial={{ opacity: 0, scale: 0.95 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} transition={{ duration: 1 }}>
                        <img
                            src={visualsData.trekking.during.foodEditorial}
                            alt="Dining Tent"
                            style={{ width: '100%', borderRadius: '12px', boxShadow: '0 20px 40px rgba(0,0,0,0.1)' }}
                        />
                    </motion.div>
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <h2 className="sd-h2">The Metabolic <em>Engine.</em></h2>
                        <p className="sd-body">
                            Altitude suppresses appetite, but your body requires 4,000+ calories daily to climb Kilimanjaro. Our nutrition strategy focuses on caloric density, ease of digestion, and palatability.
                        </p>
                        <p className="sd-body">
                            Our chefs are trained to prepare multi-course meals that provide the complex carbohydrates, proteins, and fats necessary to maintain your strength through extreme thermal shifts.
                        </p>
                    </motion.div>
                </div>
            </section>

            {/* ─── MENU & HYDRATION CARDS ─── */}
            <section className="sd-section" style={{ backgroundColor: 'var(--sd-gray)' }}>
                <div className="sd-grid-editorial" style={{ gap: '40px' }}>
                    {/* MENU CARD */}
                    <div className="sd-card">
                        <div className="sd-card-header">
                            <div className="sd-icon-badge">
                                <UtensilsIcon />
                            </div>
                            <h3 className="sd-card-title">Executive <em>Dining.</em></h3>
                        </div>
                        <div className="sd-list">
                            <div className="sd-list-item">
                                <span className="sd-list-label">Sunrise Fuel</span>
                                <p className="sd-list-desc">Porridge, eggs cooked to order, sausages, bacon, and fresh tropical fruit served with Tanzanian coffee.</p>
                            </div>
                            <div className="sd-list-item">
                                <span className="sd-list-label">The Midday Break</span>
                                <p className="sd-list-desc">A hot lunch (soup, pasta, or rice dishes) or a high-energy picnic box including chicken, sandwiches, and energy bars.</p>
                            </div>
                            <div className="sd-list-item">
                                <span className="sd-list-label">The Evening Feast</span>
                                <p className="sd-list-desc">A warming 3-course dinner: Fresh soup, followed by a main (beef, chicken, or vegetarian curry), and a light dessert.</p>
                            </div>
                        </div>
                    </div>

                    {/* HYDRATION CARD */}
                    <div className="sd-card">
                        <div className="sd-card-header">
                            <div className="sd-icon-badge">
                                <BeakerIcon />
                            </div>
                            <h3 className="sd-card-title">Hydration <em>Protocol.</em></h3>
                        </div>
                        <div className="sd-list">
                            <div className="sd-list-item">
                                <span className="sd-list-label">4 Liters Daily</span>
                                <p className="sd-list-desc">Hydration is critical for acclimatization. Porters collect mountain stream water, which we boil and purify for your consumption.</p>
                            </div>
                            <div className="sd-list-item">
                                <span className="sd-list-label">Unlimited Beverages</span>
                                <p className="sd-list-desc">Unlimited tea, coffee, hot chocolate, and herbal infusions available at every camp and during every break.</p>
                            </div>
                            <div className="sd-list-item">
                                <span className="sd-list-label">O2 Transport</span>
                                <p className="sd-list-desc">Water is the vehicle for oxygen in your blood. Our guides monitor your fluid intake daily to ensure peak performance.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* ─── FULL BLEED BREAK ─── */}
            <section className="sd-full-bleed">
                <img
                    src={visualsData.trekking.routes.marangu}
                    alt="Fresh vegetables in mountain camp"
                />
            </section>

            {/* ─── BOTTOM CTA ─── */}
            <section className="sd-section" style={{ textAlign: 'center' }}>
                <motion.h2 className="sd-h2" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    Nutrition by <em>Design.</em>
                </motion.h2>
                <div style={{ display: 'flex', gap: '20px', justifyContent: 'center', marginTop: '40px' }}>
                    <Link to="/trekking/during/pack-your-daypack" className="sd-btn sd-btn-gold">
                        Pack Your Daypack
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor" className="w-5 h-5">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </Link>
                </div>
            </section>
        </div>
    );
};

export default FoodAndDrinks;
