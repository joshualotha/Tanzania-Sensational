import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../../data/visualsData';
import '../../../styles/safaridraft-trek.css';

// Heroicons (Outline)
const ShoppingBagIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
        <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
    </svg>
);

const ShieldCheckIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
        <path strokeLinecap="round" strokeLinejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
    </svg>
);

const PackYourDaypack = () => {
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
                        src={visualsData.trekking.during.packDaypack}
                        alt="Trekking pack"
                    />
                    <div className="sd-hero-overlay"></div>
                </div>
                <div className="sd-hero-content">
                    <motion.span className="sd-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>The Trail Capsule</motion.span>
                    <motion.h1 className="sd-h1" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.1 }}>
                        Pack Your <em>Daypack.</em>
                    </motion.h1>
                </div>
            </section>

            {/* ─── INVENTORY STRATEGY ─── */}
            <section className="sd-section">
                <div className="sd-grid-editorial">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <h2 className="sd-h2">Your Daily <em>Lifeline.</em></h2>
                        <p className="sd-body">
                            While our porters carry your main duffel bag (max 15kg) between camps, your daypack (25-35L) is your only access to gear while trekking. It must be packed with precision.
                        </p>
                        <p className="sd-body">
                            The mountain's climate is volatile. In a single hour, you may transition from searing equatorial sun to a sub-zero sleet storm. Your daypack inventory is your thermal defense system.
                        </p>
                    </motion.div>
                    <motion.div initial={{ opacity: 0, scale: 0.95 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} transition={{ duration: 1 }}>
                        <img
                            src={visualsData.trekking.during.packDaypackEditorial}
                            alt="Gear layout"
                            style={{ width: '100%', borderRadius: '12px', boxShadow: '0 20px 40px rgba(0,0,0,0.1)' }}
                        />
                    </motion.div>
                </div>
            </section>

            {/* ─── GEAR CARDS ─── */}
            <section className="sd-section" style={{ backgroundColor: 'var(--sd-gray)' }}>
                <div className="sd-grid-editorial" style={{ gap: '40px' }}>
                    {/* GEAR CARD */}
                    <div className="sd-card">
                        <div className="sd-card-header">
                            <div className="sd-icon-badge">
                                <ShoppingBagIcon />
                            </div>
                            <h3 className="sd-card-title">Essential <em>Inventory.</em></h3>
                        </div>
                        <div className="sd-list">
                            <div className="sd-list-item">
                                <span className="sd-list-label">Climate Armor</span>
                                <p className="sd-list-desc">Gore-Tex waterproof jacket and trousers, plus a lightweight down layer for sudden temperature drops.</p>
                            </div>
                            <div className="sd-list-item">
                                <span className="sd-list-label">Hydration Transport</span>
                                <p className="sd-list-desc">3L Camelbak bladder for continuous sipping, plus a 1L Nalgene for summit night as backup.</p>
                            </div>
                            <div className="sd-list-item">
                                <span className="sd-list-label">Summit Protection</span>
                                <p className="sd-list-desc">High-altitude sunglasses (Category 4), professional-grade sunscreen (SPF 50+), and a wide-brimmed sun hat.</p>
                            </div>
                        </div>
                    </div>

                    {/* MEDICAL CARD */}
                    <div className="sd-card">
                        <div className="sd-card-header">
                            <div className="sd-icon-badge">
                                <ShieldCheckIcon />
                            </div>
                            <h3 className="sd-card-title">Personal <em>Medikit.</em></h3>
                        </div>
                        <div className="sd-list">
                            <div className="sd-list-item">
                                <span className="sd-list-label">Blister Management</span>
                                <p className="sd-list-desc">Compeed blister pads and moleskin. Hot spots must be treated the minute they are felt.</p>
                            </div>
                            <div className="sd-list-item">
                                <span className="sd-list-label">Metabolic Support</span>
                                <p className="sd-list-desc">Electrolyte tabs, glucose chews, and high-energy snacks for when altitude suppresses your solid food intake.</p>
                            </div>
                            <div className="sd-list-item">
                                <span className="sd-list-label">Daily Rations</span>
                                <p className="sd-list-desc">Personal prescription medications, Diamox (if prescribed), and standard painkillers for mild altitude headaches.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* ─── FULL BLEED BREAK ─── */}
            <section className="sd-full-bleed">
                <img
                    src={visualsData.trekking.during.routineEditorial}
                    alt="High mountain peak"
                />
            </section>

            {/* ─── BOTTOM CTA ─── */}
            <section className="sd-section" style={{ textAlign: 'center' }}>
                <motion.h2 className="sd-h2" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    Equipped for the <em>Edge.</em>
                </motion.h2>
                <div style={{ display: 'flex', gap: '20px', justifyContent: 'center', marginTop: '40px' }}>
                    <Link to="/trekking/during/connectivity" className="sd-btn sd-btn-gold">
                        Signals & Power
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor" className="w-5 h-5">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </Link>
                </div>
            </section>
        </div>
    );
};

export default PackYourDaypack;
