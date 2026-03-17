import { Coins, Heart, Handshake, Info, Users } from 'lucide-react';
import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../../data/visualsData';
import '../../../styles/utility-pages-premium.css';

const TippingGuide = () => {
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
                        src={visualsData.trekking.prep.tippingHero}
                        alt="Group on the mountain"
                    />
                    <div className="prep-hero-overlay"></div>
                </div>
                <div className="prep-hero-content">
                    <motion.span className="prep-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Ethical Trekking</motion.span>
                    <motion.h1 className="prep-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>Tipping <em>Guidelines.</em></motion.h1>
                </div>
            </section>

            {/* ─── EDITORIAL CONTENT ─── */}
            <section className="prep-grid-section">
                <div className="prep-editorial-grid">
                    <div className="prep-editorial-text">
                        <motion.span className="prep-eyebrow" initial="hidden" whileInView="visible" variants={fadeInUp}>The Culture of Giving</motion.span>
                        <h2 className="prep-section-title">An Expression of <em>Gratitude.</em></h2>
                        <p className="prep-body-text">
                            Tipping is a longstanding tradition on Kilimanjaro. It is not a replacement for a fair wage—which we guarantee—but a profound way for adventurers to acknowledge the tireless work of their crew.
                        </p>
                        <p className="prep-body-text">
                            We encourage a transparent tipping ceremony on the final morning of the trek. To help you calculate, we have broken down our recommended tip amounts based on the specific roles of our elite expedition crew.
                        </p>
                    </div>
                    <motion.div
                        className="prep-editorial-img-wrap"
                        initial={{ opacity: 0, x: 50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 1 }}
                    >
                        <img
                            src={visualsData.trekking.prep.tippingEditorial}
                            className="prep-editorial-img"
                            alt="Mountain Crew"
                        />
                        <span className="prep-img-caption">The Backbone of Your Expedition</span>
                    </motion.div>
                </div>
            </section>

            {/* ─── DETAILED TIPPING BREAKDOWN ─── */}
            <section className="prep-info-grid">
                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <Coins size={32} color="var(--savanna-gold)" />
                        <h3 className="prep-info-card-title">Daily Rates (Per Group)</h3>
                    </div>
                    <p className="prep-body-text" style={{ fontSize: '1rem', marginTop: '-10px', marginBottom: '20px' }}>These amounts are given by the <em>entire climbing group</em> per day, not per individual climber.</p>
                    <ul className="prep-info-list">
                        <li><span>Senior Guide</span> <span style={{ color: 'var(--savanna-gold)', fontWeight: 'bold' }}>$20 – $25 / day</span></li>
                        <li><span>Assistant Guide</span> <span style={{ color: 'var(--savanna-gold)', fontWeight: 'bold' }}>$15 – $20 / day</span></li>
                        <li><span>Summit Porter</span> <span style={{ color: 'var(--savanna-gold)', fontWeight: 'bold' }}>$12 – $15 / day</span></li>
                        <li><span>Cook</span> <span style={{ color: 'var(--savanna-gold)', fontWeight: 'bold' }}>$12 – $15 / day</span></li>
                        <li><span>Waiter / Toilet Crew</span> <span style={{ color: 'var(--savanna-gold)', fontWeight: 'bold' }}>$10 – $12 / day</span></li>
                        <li><span>Porter</span> <span style={{ color: 'var(--savanna-gold)', fontWeight: 'bold' }}>$8 – $10 / day</span></li>
                    </ul>
                </motion.div>

                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true, delay: 0.1 }}>
                    <div className="prep-info-card-header">
                        <Users size={32} color="var(--savanna-gold)" />
                        <h3 className="prep-info-card-title">Crew Sizes by Group</h3>
                    </div>
                    <p className="prep-body-text" style={{ fontSize: '1rem', marginTop: '-10px', marginBottom: '20px' }}>To estimate your total, here are our standard crew ratios based on climber group size.</p>
                    <ul className="prep-info-list">
                        <li><span>1 Climber</span> <span>1 Sr. Guide, 1 Cook, 3-4 Porters</span></li>
                        <li><span>2 Climbers</span> <span>1 Sr, 1 Asst, 1 Cook, 6 Porters</span></li>
                        <li><span>3 Climbers</span> <span>1 Sr, 1 Asst, 1 Cook, 9 Porters</span></li>
                        <li><span>4 Climbers</span> <span>1 Sr, 1 Asst, 1 Cook, 12 Porters</span></li>
                        <li><span>6 Climbers</span> <span>1 Sr, 2 Asst, 2 Cooks, 18 Porters</span></li>
                        <li><span>10 Climbers</span> <span>1 Sr, 3 Asst, 2 Cooks, 30 Porters</span></li>
                    </ul>
                </motion.div>
            </section>

            <motion.div className="prep-highlight-box" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} viewport={{ once: true }}>
                <h3 className="prep-highlight-title">The Tipping Ceremony</h3>
                <p className="prep-highlight-text">
                    On your final morning at the last camp before descending to the gate, the crew will gather to perform the traditional Kilimanjaro song. This is the moment for the tipping ceremony. We advise electing one "spokesperson" among your climbing group. You will hand the respective envelopes directly to the lead guide in front of the crew, naming the amount inside clearly. The lead guide will then distribute the funds exactly as dictated, ensuring complete transparency.
                </p>
            </motion.div>

            {/* ─── CTA BAND ─── */}
            <section className="prep-cta-band">
                <motion.h2 className="prep-cta-title" initial="hidden" whileInView="visible" variants={fadeInUp}>Tread with <em>Integrity.</em></motion.h2>
                <div className="prep-btn-group">
                    <Link to="/contact" className="prep-btn-sand">Plan Your Trek</Link>
                    <Link to="/about" className="prep-btn-outline">Our Ethical Commitments</Link>
                </div>
            </section>
        </div>
    );
};

export default TippingGuide;
