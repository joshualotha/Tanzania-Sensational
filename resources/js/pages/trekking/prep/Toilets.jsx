import { Shield, Sparkles, AlertTriangle } from 'lucide-react';
import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../../data/visualsData';
import '../../../styles/utility-pages-premium.css';

const Toilets = () => {
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
                        src={visualsData.trekking.prep.toiletsHero}
                        alt="High altitude camp"
                    />
                    <div className="prep-hero-overlay"></div>
                </div>
                <div className="prep-hero-content">
                    <motion.span className="prep-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Expedition Comfort</motion.span>
                    <motion.h1 className="prep-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>Mountain <em>Facilities.</em></motion.h1>
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
                            src={visualsData.trekking.prep.toiletsEditorial}
                            className="prep-editorial-img"
                            alt="Kilimanjaro Camp Site"
                        />
                        <span className="prep-img-caption">Dignity at 4,000 Meters</span>
                    </motion.div>
                    <div className="prep-editorial-text">
                        <motion.span className="prep-eyebrow" initial="hidden" whileInView="visible" variants={fadeInUp}>A Refined Experience</motion.span>
                        <h2 className="prep-section-title">Hygiene Without <em>Compromise.</em></h2>
                        <p className="prep-body-text">
                            At Tanzania Sensational, we believe that sanitation is a fundamental component of high-altitude health. Every campsite on a Kilimanjaro trek is equipped with public toilets, but it’s important to adjust your expectations.
                        </p>
                        <p className="prep-body-text">
                            These public facilities are often basic wooden structures surrounding a deep hole in the ground (long drops). Because of the sheer volume of climbers, they can emit strong odors and be unsanitary. We provide a much better alternative.
                        </p>
                    </div>
                </div>
            </section>

            {/* ─── TOILET COMPARISON GRIDS ─── */}
            <section className="prep-info-grid">
                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <Sparkles size={32} color="var(--savanna-gold)" />
                        <h3 className="prep-info-card-title">Our Private Tents</h3>
                    </div>
                    <ul className="prep-info-list">
                        <li style={{ display: 'block', paddingBottom: '10px' }}><strong style={{ color: 'var(--savanna-gold)' }}>The Upgrade:</strong> Fully equipped chemical toilets enclosed in their own discreet, stand-up tents for complete privacy.</li>
                        <li style={{ display: 'block', paddingBottom: '10px' }}><strong style={{ color: 'var(--savanna-gold)' }}>Exclusivity:</strong> Reserved exclusively for you and your group. No sharing with hundreds of other climbers.</li>
                        <li style={{ display: 'block' }}><strong style={{ color: 'var(--savanna-gold)' }}>Maintenance:</strong> Dedicated toilet porters ensure the cleaning, maintenance, and transportation of these toilets between camps.</li>
                    </ul>
                </motion.div>

                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true, delay: 0.1 }}>
                    <div className="prep-info-card-header">
                        <AlertTriangle size={32} color="#666" />
                        <h3 className="prep-info-card-title">Public "Long Drops"</h3>
                    </div>
                    <ul className="prep-info-list">
                        <li style={{ display: 'block', paddingBottom: '10px' }}><strong>The Reality:</strong> Basic pit latrines where human waste is collected in a hole up to one meter deep beneath the seat.</li>
                        <li style={{ display: 'block', paddingBottom: '10px' }}><strong>The Condition:</strong> Prepare for squatting and minimal privacy. Due to high usage, they are often very uncomfortable.</li>
                        <li style={{ display: 'block' }}><strong>The Distance:</strong> They are established by the park and are often located far from where your specific tent will be pitched.</li>
                    </ul>
                </motion.div>
            </section>

            <motion.div className="prep-highlight-box" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} viewport={{ once: true }}>
                <h3 className="prep-highlight-title">Using Toilets Between Camps</h3>
                <p className="prep-highlight-text">
                    For urination on the trail, you can discreetly find a private spot behind a tree or bush—it's advisable to inform your guide. As you ascend beyond the tree line, finding cover becomes challenging. Carrying a suitable container (like a Peebol or Shewee) is a practical solution. If you must defecate on the trail, use disposable plastic bags, carry toilet paper/wet wipes, and proper disposal is crucial—take everything to the next campsite for your porters to manage.
                </p>
            </motion.div>

            {/* ─── CTA BAND ─── */}
            <section className="prep-cta-band">
                <motion.h2 className="prep-cta-title" initial="hidden" whileInView="visible" variants={fadeInUp}>Comfort in the <em>Wilds.</em></motion.h2>
                <div className="prep-btn-group">
                    <Link to="/contact" className="prep-btn-sand">Inquire About Luxury Tiers</Link>
                    <Link to="/safaris" className="prep-btn-outline">View Safari Comforts</Link>
                </div>
            </section>
        </div>
    );
};

export default Toilets;
