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
            <section className="lux-section lux-section-alt">
                <motion.h2 className="lux-heading" style={{ textAlign: 'center', marginBottom: '60px' }} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    The Three <em>Pillars.</em>
                </motion.h2>
                <div className="lux-pillar-grid">
                    {wardrobe.map((item, i) => (
                        <motion.div
                            key={i}
                            className="lux-pillar-card"
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true }}
                            variants={fadeInUp}
                            transition={{ delay: i * 0.15 }}
                        >
                            <div className="lux-pillar-icon">{item.icon}</div>
                            <span className="lux-pillar-tag">{item.category}</span>
                            <h3 className="lux-pillar-title">{item.title}</h3>
                            <p className="lux-pillar-desc">{item.desc}</p>
                            <ul className="lux-pillar-list">
                                {item.items.map((itm, j) => (
                                    <li key={j}>
                                        <Check size={14} />
                                        {itm}
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
                <div className="lux-occasion-list">
                    {occasions.map((item, i) => (
                        <motion.div
                            key={i}
                            className="lux-occasion-row"
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true }}
                            variants={fadeInUp}
                            transition={{ delay: i * 0.1 }}
                        >
                            <div>
                                <h4 className="lux-occasion-time">{item.time}</h4>
                                <span className="lux-occasion-temp">{item.temp}</span>
                            </div>
                            <div>
                                <p className="lux-occasion-outfit"><strong>Wear:</strong> {item.outfit}</p>
                                <p className="lux-occasion-note">{item.note}</p>
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
