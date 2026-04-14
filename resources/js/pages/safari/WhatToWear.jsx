import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import { Sun, Wind, Droplets, Camera, Shield, Check } from 'lucide-react';
import '../../styles/ultra-premium.css';

const WhatToWear = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);
    const visuals = useVisuals();

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const fadeIn = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { duration: 0.8 } }
    };

    const wardrobe = [
        {
            category: 'Color Philosophy',
            icon: <Camera size={20} />,
            title: 'The Safari Palette',
            desc: 'Leave the bright whites and neon tones at home. On safari, your wardrobe should blend with the landscape, not compete with it. Khaki, olive, tan, and muted earth tones are the gold standard.',
            items: ['Khaki & Olive (primary)', 'Tan & Beige (secondary)', 'Avoid: White, Black, Bright Blue', 'Avoid: Neon or Fluorescent Colors']
        },
        {
            category: 'Fabric Science',
            icon: <Wind size={20} />,
            title: 'Breathable is Everything',
            desc: 'The African sun is relentless, but your clothing doesn\'t have to be. Choose lightweight, moisture-wicking fabrics that dry quickly and resist wrinkles. Cotton is acceptable in camp, but synthetic blends rule the field.',
            items: ['Quick-dry synthetics (primary)', 'Merino wool (excellent)', 'Linen (acceptable in camp)', 'Avoid: Heavy denim, Pure cotton']
        },
        {
            category: 'Layering Strategy',
            icon: <Droplets size={20} />,
            title: 'The Temperature Swing',
            desc: 'Safari mornings begin at 4 AM in near-freezing game drive vehicles. By noon, you\'ll be baking in 35°C heat. The solution? Strategic layering that sheds as the day warms.',
            items: ['Base: Light, breathable tee', 'Mid: Fleece or light sweater', 'Outer: Windproof jacket (mornings)', 'Hat: Wide-brimmed essential']
        }
    ];

    const occasions = [
        {
            time: 'Morning Game Drive',
            temp: '5-15°C (41-59°F)',
            outfit: 'Long pants + long-sleeve shirt + fleece + windproof jacket + beanie + gloves',
            note: 'The 4 AM departures are genuinely cold. Dress as if you\'re going skiing.'
        },
        {
            time: 'Midday at Camp',
            temp: '28-35°C (82-95°F)',
            outfit: 'Shorts + short-sleeve shirt + sun hat + sunglasses',
            note: 'Light, airy, and sunscreen-reliant. This is when the pool calls.'
        },
        {
            time: 'Evening Sundowner',
            temp: '18-25°C (64-77°F)',
            outfit: 'Smart casual: chinos + collared shirt + light jacket',
            note: 'Safari camps elevate at dusk. Think "refined bush elegance."'
        },
        {
            time: 'Walking Safari',
            temp: 'Variable',
            outfit: 'Long pants + closed-toe shoes + neutral colors + sun protection',
            note: 'Neutral colors are non-negotiable. White and bright colors startle wildlife.'
        }
    ];

    return (
        <div className="lux-root">
            {/* ─── HERO ─── */}
            <section className="lux-hero">
                <img
                    src={visuals.getSingle('safari.whatToWearHero', visualsData.safaris.listHero)}
                    alt="Safari Style"
                />
                <div className="lux-hero-overlay"></div>
                <div className="lux-hero-content">
                    <motion.span className="lux-hero-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>The Field Manual</motion.span>
                    <motion.h1 className="lux-hero-title" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.1 }}>
                        What to <em>Wear.</em>
                    </motion.h1>
                </div>
            </section>

            {/* ─── EDITORIAL INTRO ─── */}
            <section className="lux-section">
                <div className="lux-editorial-grid">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-100px" }} variants={fadeInUp}>
                        <h2 className="lux-heading">Dress Like a <em>Professional.</em></h2>
                        <p className="lux-body">
                            On safari, your clothing serves three critical purposes: blending into the environment, regulating your body temperature across extreme swings, and protecting you from the equatorial sun and insects.
                        </p>
                        <p className="lux-body">
                            The experienced safari hand doesn't dress for Instagram — they dress for the bush. Neutral tones, practical layers, and fabrics that perform under harsh conditions are the hallmarks of someone who understands the terrain.
                        </p>
                        <p className="lux-body">
                            Here is the complete field manual for dressing correctly on a Tanzanian safari.
                        </p>
                    </motion.div>
                    <motion.div
                        initial={{ opacity: 0, scale: 0.95 }}
                        whileInView={{ opacity: 1, scale: 1 }}
                        viewport={{ once: true }}
                        transition={{ duration: 1.5, ease: "easeOut" }}
                        className="lux-image-wrapper"
                    >
                        <img
                            src={visuals.getSingle('safari.whatToWearEditorial', visualsData.planning.meruHero)}
                            alt="Safari Wardrobe"
                        />
                        <div className="lux-image-caption">Neutral tones blend seamlessly into the savanna landscape.</div>
                    </motion.div>
                </div>
            </section>

            {/* ─── WARDROBE PRINCIPLES ─── */}
            <section className="lux-section" style={{ background: 'var(--lux-offwhite)' }}>
                <motion.h2 className="lux-heading" style={{ textAlign: 'center', marginBottom: '60px' }} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    The Three <em>Pillars.</em>
                </motion.h2>
                <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: '40px', maxWidth: '1200px', margin: '0 auto' }}>
                    {wardrobe.map((item, i) => (
                        <motion.div
                            key={i}
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true }}
                            variants={fadeInUp}
                            transition={{ delay: i * 0.15 }}
                            style={{ background: 'white', padding: '40px 30px', borderRadius: '8px', boxShadow: '0 4px 20px rgba(0,0,0,0.06)' }}
                        >
                            <div style={{ width: '48px', height: '48px', background: 'var(--lux-tan)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', marginBottom: '20px' }}>
                                {item.icon}
                            </div>
                            <span style={{ fontSize: '0.7rem', color: 'var(--lux-tan)', textTransform: 'uppercase', letterSpacing: '0.15em', fontWeight: 600 }}>{item.category}</span>
                            <h3 style={{ fontFamily: 'var(--font-heading)', fontSize: '1.5rem', margin: '10px 0 15px', color: 'var(--lux-dark)' }}>{item.title}</h3>
                            <p style={{ fontSize: '0.95rem', lineHeight: '1.7', color: 'var(--lux-mid)', marginBottom: '20px' }}>{item.desc}</p>
                            <ul style={{ listStyle: 'none', padding: 0, margin: 0 }}>
                                {item.items.map((item, j) => (
                                    <li key={j} style={{ fontSize: '0.85rem', padding: '6px 0', borderBottom: '1px solid var(--lux-border)', color: 'var(--lux-dark)', display: 'flex', alignItems: 'center', gap: '8px' }}>
                                        <Check size={14} style={{ color: 'var(--lux-tan)' }} />
                                        {item}
                                    </li>
                                ))}
                            </ul>
                        </motion.div>
                    ))}
                </div>
            </section>

            {/* ─── FULL BLEED PARALLAX ─── */}
            <section className="lux-full-bleed">
                <img
                    src={visuals.getSingle('safari.whatToWearFullBleed', visualsData.safaris.migrationHero)}
                    alt="Safari Landscape"
                />
            </section>

            {/* ─── OCCASION GUIDE ─── */}
            <section className="lux-section">
                <motion.h2 className="lux-heading" style={{ textAlign: 'center', marginBottom: '60px' }} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    The Daily <em>Rotation.</em>
                </motion.h2>
                <div style={{ maxWidth: '900px', margin: '0 auto' }}>
                    {occasions.map((item, i) => (
                        <motion.div
                            key={i}
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true }}
                            variants={fadeInUp}
                            transition={{ delay: i * 0.1 }}
                            style={{ display: 'grid', gridTemplateColumns: '200px 1fr', gap: '40px', padding: '30px 0', borderBottom: '1px solid var(--lux-border)' }}
                        >
                            <div>
                                <h4 style={{ fontFamily: 'var(--font-heading)', fontSize: '1.2rem', color: 'var(--lux-dark)', marginBottom: '8px' }}>{item.time}</h4>
                                <span style={{ fontSize: '0.75rem', color: 'var(--lux-tan)', fontWeight: 600, letterSpacing: '0.1em' }}>{item.temp}</span>
                            </div>
                            <div>
                                <p style={{ fontSize: '0.95rem', color: 'var(--lux-dark)', marginBottom: '10px', lineHeight: '1.6' }}><strong>Wear:</strong> {item.outfit}</p>
                                <p style={{ fontSize: '0.85rem', color: 'var(--lux-mid)', fontStyle: 'italic' }}>{item.note}</p>
                            </div>
                        </motion.div>
                    ))}
                </div>
            </section>

            {/* ─── CTA ─── */}
            <section className="lux-cta">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    <h2 className="lux-heading" style={{ marginBottom: '20px' }}>Ready for the <em>Bush?</em></h2>
                    <p className="lux-body" style={{ maxWidth: '600px', margin: '0 auto 30px' }}>
                        Now that you know what to wear, explore our complete packing list to ensure nothing is left behind.
                    </p>
                    <Link to="/safari-guide/packing-guide" className="lux-btn" style={{ display: 'inline-flex', alignItems: 'center', gap: '10px' }}>
                        View Full Packing List
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
                        </svg>
                    </Link>
                </motion.div>
            </section>
        </div>
    );
};

export default WhatToWear;
