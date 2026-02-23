import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import '../../../styles/safaridraft-trek.css';

// Heroicons (Outline)
const WifiIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
        <path strokeLinecap="round" strokeLinejoin="round" d="M8.288 15.038a5.25 5.25 0 0 1 7.424 0M5.106 11.856c3.807-3.808 9.98-3.808 13.788 0M1.924 8.674c5.565-5.565 14.587-5.565 20.152 0M12.53 18.22a.75.75 0 1 1-1.06 0 .75.75 0 0 1 1.06 0Z" />
    </svg>
);

const BoltIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
        <path strokeLinecap="round" strokeLinejoin="round" d="m3.75 13.5 10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75Z" />
    </svg>
);

const Connectivity = () => {
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
                        src="https://images.unsplash.com/photo-1542332213-9b5a5a3fad35?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80"
                        alt="High altitude ridge"
                    />
                    <div className="sd-hero-overlay"></div>
                </div>
                <div className="sd-hero-content">
                    <motion.span className="sd-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>The Infrastructure</motion.span>
                    <motion.h1 className="sd-h1" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.1 }}>
                        Signals & <em>Power.</em>
                    </motion.h1>
                </div>
            </section>

            {/* ─── CONNECTIVITY STRATEGY ─── */}
            <section className="sd-section">
                <div className="sd-grid-editorial">
                    <motion.div initial={{ opacity: 0, scale: 0.95 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} transition={{ duration: 1 }}>
                        <img
                            src="https://images.unsplash.com/photo-1510100768407-3ce94de8d5c4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80"
                            alt="Starry sky"
                            style={{ width: '100%', borderRadius: '12px', boxShadow: '0 20px 40px rgba(0,0,0,0.1)' }}
                        />
                    </motion.div>
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <h2 className="sd-h2">The Digital <em>Silence.</em></h2>
                        <p className="sd-body">
                            Kilimanjaro is a space for disconnection, but we understand the need for safety communications and the desire to share your summit achievement.
                        </p>
                        <p className="sd-body">
                            Signal strength is highly variable. While certain ridges offer 4G connectivity from urban centers below, most of the route exists in a profound radio shadow. Strategic power management is the key to maintaining your devices through the summit night.
                        </p>
                    </motion.div>
                </div>
            </section>

            {/* ─── SIGNAL & POWER CARDS ─── */}
            <section className="sd-section" style={{ backgroundColor: 'var(--sd-gray)' }}>
                <div className="sd-grid-editorial" style={{ gap: '40px' }}>
                    {/* SIGNAL CARD */}
                    <div className="sd-card">
                        <div className="sd-card-header">
                            <div className="sd-icon-badge">
                                <WifiIcon />
                            </div>
                            <h3 className="sd-card-title">Network <em>Access.</em></h3>
                        </div>
                        <div className="sd-list">
                            <div className="sd-list-item">
                                <span className="sd-list-label">Sporadic Coverage</span>
                                <p className="sd-list-desc">Signals are strongest at Horombo Hut, Barranco Camp, and the Karanga valley. Local SIM cards (Airtel/Vodacom) generally outperform roaming.</p>
                            </div>
                            <div className="sd-list-item">
                                <span className="sd-list-label">Emergency Comms</span>
                                <p className="sd-list-desc">Our guides carry localized radio sets and satellite backup for emergency coordination with our base in Arusha.</p>
                            </div>
                            <div className="sd-list-item">
                                <span className="sd-list-label">The Cloud Gap</span>
                                <p className="sd-list-desc">Thick cloud cover can effectively block signals. Do not rely on continuous connectivity for navigation or social updates.</p>
                            </div>
                        </div>
                    </div>

                    {/* POWER CARD */}
                    <div className="sd-card">
                        <div className="sd-card-header">
                            <div className="sd-icon-badge">
                                <BoltIcon />
                            </div>
                            <h3 className="sd-card-title">Energy <em>Strategy.</em></h3>
                        </div>
                        <div className="sd-list">
                            <div className="sd-list-item">
                                <span className="sd-list-label">Thermal Drain</span>
                                <p className="sd-list-desc">Sub-zero temperatures drain lithium batteries instantly. Keep phones and power banks in insulated pockets inside your clothing.</p>
                            </div>
                            <div className="sd-list-item">
                                <span className="sd-list-label">20,000mAh Reserve</span>
                                <p className="sd-list-desc">We recommend a minimum of 20,000mAh in dedicated power banks. There are no charging outlets available on the mountain.</p>
                            </div>
                            <div className="sd-list-item">
                                <span className="sd-list-label">Summit Night Power</span>
                                <p className="sd-list-desc">Spare camera batteries should be kept against your skin during the final ascent to ensure they have enough voltage to fire the shutter at Uhuru Peak.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* ─── FULL BLEED BREAK ─── */}
            <section className="sd-full-bleed">
                <img
                    src="https://images.unsplash.com/photo-1454496522488-7a8e488e8606?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80"
                    alt="High mountain peak"
                />
            </section>

            {/* ─── BOTTOM CTA ─── */}
            <section className="sd-section" style={{ textAlign: 'center' }}>
                <motion.h2 className="sd-h2" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    Disconnected. <em>Inspired.</em>
                </motion.h2>
                <div style={{ display: 'flex', gap: '20px', justifyContent: 'center', marginTop: '40px' }}>
                    <Link to="/trekking/after/training" className="sd-btn sd-btn-gold">
                        Physical Training
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor" className="w-5 h-5">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </Link>
                </div>
            </section>
        </div>
    );
};

export default Connectivity;
