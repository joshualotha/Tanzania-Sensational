import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../../data/visualsData';
import { useVisuals } from '../../../context/VisualsContext';
import '../../../styles/safaridraft-trek.css';

// Heroicons (Outline)
const ClockIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
        <path strokeLinecap="round" strokeLinejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
    </svg>
);

const SunIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
        <path strokeLinecap="round" strokeLinejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M3 12h2.25m.386-6.364 1.591-1.591M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
    </svg>
);

const MapIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor" className="w-6 h-6">
        <path strokeLinecap="round" strokeLinejoin="round" d="m9 9 6-6m0 0 6 6m-6-6v12a3 3 0 1 1-6 0V15m0 0a3 3 0 1 0 0-6M9 15h3m3 3a3 3 0 0 1-3 3H9a3 3 0 0 1-3-3v-3h3m6-3h3m3 3a3 3 0 1 1-6 0V4.5m0 10.5h3" />
    </svg>
);

const DailyRoutine = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);
    const visuals = useVisuals();

    const fadeInUp = {
        hidden: { opacity: 0, y: 20 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.16, 1, 0.3, 1] } }
    };

    const timeline = [
        { time: "06:00", title: "Bed Tea & Morning Ritual", desc: "A gentle wake-up call with hot tea or coffee brought directly to your tent by our mountain crew as dawn breaks." },
        { time: "07:30", title: "High-Calorie Breakfast", desc: "A robust hot breakfast in the mess tent, fueling you with complex carbs and protein for the trek ahead." },
        { time: "08:30", title: "The Slow Ascent", desc: "Set off 'Pole Pole' (slowly, slowly). We maintain a deliberate pace to maximize oxygen intake and ensure perfect acclimatization." },
        { time: "13:00", title: "Picnic or Hot Lunch", desc: "A midday break to refuel and recharge, often served with sweeping views of the surrounding valleys." },
        { time: "16:30", title: "Arrival at Camp", desc: "Welcome back with hot snacks and refreshments as you unwind and settle into your new home for the night." },
        { time: "18:30", title: "Dinner & Briefing", desc: "A 3-course dinner followed by a medical check-up (O2 & Heart Rate) and a deep-dive briefing for tomorrow's route." }
    ];

    return (
        <div className="sd-root">
            {/* ─── HERO ─── */}
            <section className="sd-hero">
                <div className="sd-hero-bg">
                    <img
                        src={visuals.getSingle('trekking.during.routine', visualsData.trekking.during.routine)}
                        alt="Kilimanjaro Trail"
                    />
                    <div className="sd-hero-overlay"></div>
                </div>
                <div className="sd-hero-content">
                    <motion.span className="sd-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>The Expedition Flow</motion.span>
                    <motion.h1 className="sd-h1" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.1 }}>
                        The Daily <em>Routine.</em>
                    </motion.h1>
                </div>
            </section>

            {/* ─── PHILOSOPHY ─── */}
            <section className="sd-section">
                <div className="sd-grid-editorial">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <h2 className="sd-h2">Rhythm is <em>Success.</em></h2>
                        <p className="sd-body">
                            On the slopes of Kilimanjaro, your day is governed by a strict, meditative rhythm. We have perfected this flow over a decade to ensure you are never over-exerted and always well-fueled.
                        </p>
                        <p className="sd-body">
                            Stability in your routine leads to stability in your physiology. By managing every hour of your expedition, we allow you to focus entirely on the horizon.
                        </p>
                    </motion.div>
                    <motion.div
                        initial={{ opacity: 0, scale: 0.95 }}
                        whileInView={{ opacity: 1, scale: 1 }}
                        viewport={{ once: true }}
                        transition={{ duration: 1 }}
                    >
                        <img
                            src={visualsData.trekking.during.routineEditorial}
                            alt="Mawenzi Peak"
                            style={{ width: '100%', borderRadius: '12px', boxShadow: '0 20px 40px rgba(0,0,0,0.1)' }}
                        />
                    </motion.div>
                </div>
            </section>

            {/* ─── TIMELINE SHEET (SaaS Component) ─── */}
            <section className="sd-section" style={{ backgroundColor: 'var(--sd-white)', borderTop: '1px solid var(--sd-border)', borderBottom: '1px solid var(--sd-border)' }}>
                <div style={{ maxWidth: '800px', margin: '0 auto' }}>
                    <div className="sd-card">
                        <div className="sd-card-header">
                            <div className="sd-icon-badge">
                                <ClockIcon />
                            </div>
                            <h3 className="sd-card-title">Expedition <em>Schedule.</em></h3>
                        </div>
                        <div className="sd-list">
                            {timeline.map((item, index) => (
                                <motion.div
                                    key={index}
                                    className="sd-list-item"
                                    initial="hidden"
                                    whileInView="visible"
                                    viewport={{ once: true }}
                                    variants={fadeInUp}
                                    transition={{ delay: index * 0.1 }}
                                >
                                    <span style={{ fontSize: '0.8rem', fontWeight: '700', color: 'var(--sd-gold)', letterSpacing: '0.1em', marginBottom: '8px', display: 'block' }}>{item.time}</span>
                                    <span className="sd-list-label" style={{ fontSize: '1.25rem' }}>{item.title}</span>
                                    <p className="sd-list-desc">{item.desc}</p>
                                </motion.div>
                            ))}
                        </div>
                    </div>
                </div>
            </section>

            {/* ─── FULL BLEED BREAK ─── */}
            <section className="sd-full-bleed">
                <img
                    src={visualsData.trekking.during.foodEditorial}
                    alt="Camp at Night"
                />
            </section>

            {/* ─── BOTTOM CTA ─── */}
            <section className="sd-section" style={{ textAlign: 'center' }}>
                <motion.h2 className="sd-h2" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    Crafted for the <em>Elite.</em>
                </motion.h2>
                <div style={{ display: 'flex', gap: '20px', justifyContent: 'center', marginTop: '40px' }}>
                    <Link to="/trekking/during/food-and-drinks" className="sd-btn sd-btn-gold">
                        Elite Nutrition
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={2} stroke="currentColor" className="w-5 h-5">
                            <path strokeLinecap="round" strokeLinejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </Link>
                </div>
            </section>
        </div>
    );
};

export default DailyRoutine;
