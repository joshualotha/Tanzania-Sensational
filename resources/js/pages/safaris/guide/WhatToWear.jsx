import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Sun, Cloud, Wind, CheckCircle2, XCircle } from 'lucide-react';
import { visualsData } from '../../../data/visualsData';
import { useVisuals } from '../../../context/VisualsContext';
import '../../../styles/safari-premium.css';

export const WhatToWear = () => {
    const visuals = useVisuals();

    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { 
            opacity: 1, 
            y: 0, 
            transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } 
        }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: {
            opacity: 1,
            transition: { staggerChildren: 0.2 }
        }
    };

    return (
        <div className="safari-premium-root">
            {/* ─── HERO SECTION ─── */}
            <section className="premium-safari-hero" style={{ height: '70vh' }}>
                <motion.div className="premium-safari-bg">
                    <img 
                        src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&q=80&w=2000" 
                        alt="Safari Attire" 
                    />
                    <div className="premium-safari-overlay"></div>
                </motion.div>
                <div className="container">
                    <motion.div 
                        className="premium-safari-hero-content"
                        initial="hidden"
                        animate="visible"
                        variants={staggerContainer}
                    >
                        <motion.span className="premium-eyebrow" variants={fadeInUp}>Safari Guide</motion.span>
                        <motion.h1 className="premium-hero-title" variants={fadeInUp}>The Art of <em>Attire.</em></motion.h1>
                        <motion.p className="premium-hero-subtitle" variants={fadeInUp}>
                            Mastering the balance between bush functionality and effortless elegance.
                        </motion.p>
                    </motion.div>
                </div>
            </section>

            {/* ─── PHILOSOPHY SECTION ─── */}
            <section className="premium-destinations-section" style={{ marginTop: '-80px' }}>
                <div className="container">
                    <div className="premium-dest-content" style={{ maxWidth: '900px', margin: '0 auto', textAlign: 'center', background: 'white', padding: '60px', borderRadius: '4px', boxShadow: '0 30px 60px rgba(0,0,0,0.05)' }}>
                        <h2 className="premium-dest-name">The Philosophy of <em>Layers.</em></h2>
                        <p className="premium-dest-desc">
                            A Tanzanian safari is a journey through microclimates. From the freezing dawn on the Ngorongoro rim to the sun-drenched plains of the Serengeti, your wardrobe must be as adaptive as the wildlife. The key is lightweight, breathable layers in neutral tones.
                        </p>
                    </div>
                </div>
            </section>

            {/* ─── COLOR PALETTE ─── */}
            <section style={{ padding: '100px 0', background: '#fcfaf7' }}>
                <div className="container">
                    <div style={{ textAlign: 'center', marginBottom: '60px' }}>
                        <span className="premium-eyebrow">The Palette</span>
                        <h2 className="premium-dest-name">Camouflage by <em>Nature.</em></h2>
                    </div>
                    <div className="premium-dest-grid">
                        {[
                            { name: 'Khaki & Sand', tone: '#C9B99A', desc: 'The classic safari anchor. Blends perfectly with high-grass environments.' },
                            { name: 'Olive Grove', tone: '#6B7B3A', desc: 'Resilient and practical. Perfect for woodland and bush-intensive regions.' },
                            { name: 'Dust Grey', tone: '#A8A8A8', desc: 'Conceals the inevitable fine dust of the savanna while keeping you cool.' }
                        ].map((color, i) => (
                            <motion.div key={i} className="premium-dest-card" style={{ padding: '30px' }} variants={fadeInUp} initial="hidden" whileInView="visible" viewport={{ once: true }}>
                                <div style={{ width: '100%', height: '120px', backgroundColor: color.tone, borderRadius: '2px', marginBottom: '20px' }} />
                                <h3 className="premium-dest-name" style={{ fontSize: '1.5rem', marginBottom: '10px' }}>{color.name}</h3>
                                <p className="premium-dest-desc" style={{ fontSize: '0.9rem' }}>{color.desc}</p>
                            </motion.div>
                        ))}
                    </div>
                </div>
            </section>

            {/* ─── ESSENTIAL GUIDELINES ─── */}
            <section style={{ padding: '120px 0' }}>
                <div className="container">
                    <div className="editorial-stagger-grid" style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '80px', alignItems: 'center' }}>
                        <div>
                            <span className="premium-eyebrow">The Do's</span>
                            <h2 className="premium-dest-name">What to <em>Prioritize.</em></h2>
                            <ul style={{ listStyle: 'none', padding: 0, marginTop: '30px' }}>
                                {[
                                    { title: 'Breathable Fabrics', text: 'Cotton and linen are your best allies against the heat.' },
                                    { title: 'Early Morning Warmth', text: 'A high-quality fleece or windbreaker for those 5:30 AM starts.' },
                                    { title: 'Long Sleeves', text: 'Essential for sunset protection against mosquitoes and harsh rays.' },
                                    { title: 'Closed-Toe Shoes', text: 'Sturdy trainers or light trail shoes for walking around camp.' }
                                ].map((item, i) => (
                                    <li key={i} style={{ display: 'flex', gap: '15px', marginBottom: '25px', alignItems: 'flex-start' }}>
                                        <CheckCircle2 color="var(--gold)" size={24} style={{ flexShrink: 0 }} />
                                        <div>
                                            <h4 style={{ margin: 0, fontFamily: 'var(--font-heading)', fontSize: '1.2rem' }}>{item.title}</h4>
                                            <p style={{ margin: '5px 0 0', opacity: 0.7, fontSize: '0.95rem' }}>{item.text}</p>
                                        </div>
                                    </li>
                                ))}
                            </ul>
                        </div>
                        <div style={{ position: 'relative' }}>
                            <div className="premium-dest-img-wrap" style={{ borderRadius: '4px', overflow: 'hidden' }}>
                                <img src="https://images.unsplash.com/photo-1523805081730-6144a778afd0?auto=format&fit=crop&q=80&w=1200" alt="Safari Detail" />
                            </div>
                        </div>
                    </div>

                    <div className="editorial-stagger-grid" style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '80px', alignItems: 'center', marginTop: '100px' }}>
                        <div style={{ order: 2 }}>
                            <span className="premium-eyebrow" style={{ color: '#A76B56' }}>The Don'ts</span>
                            <h2 className="premium-dest-name">What to <em>Avoid.</em></h2>
                            <ul style={{ listStyle: 'none', padding: 0, marginTop: '30px' }}>
                                {[
                                    { title: 'Dark Blue & Black', text: 'These specific tones aggressively attract tsetse flies.' },
                                    { title: 'Camouflage Patterns', text: 'Illegal for civilians in many regions; associated with the military.' },
                                    { title: 'Bright Whites', text: 'They reveal dust immediately and can disturb wildlife from a distance.' },
                                    { title: 'Heavy Denim', text: 'Slow to dry and incredibly hot in the afternoon sun.' }
                                ].map((item, i) => (
                                    <li key={i} style={{ display: 'flex', gap: '15px', marginBottom: '25px', alignItems: 'flex-start' }}>
                                        <XCircle color="#A76B56" size={24} style={{ flexShrink: 0 }} />
                                        <div>
                                            <h4 style={{ margin: 0, fontFamily: 'var(--font-heading)', fontSize: '1.2rem' }}>{item.title}</h4>
                                            <p style={{ margin: '5px 0 0', opacity: 0.7, fontSize: '0.95rem' }}>{item.text}</p>
                                        </div>
                                    </li>
                                ))}
                            </ul>
                        </div>
                        <div style={{ order: 1 }}>
                            <div className="premium-dest-img-wrap" style={{ borderRadius: '4px', overflow: 'hidden' }}>
                                <img src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&q=80&w=1200" alt="Safari Landscape" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* ─── FOOTER CTA ─── */}
            <section className="premium-reviews-band">
                <div className="container" style={{ textAlign: 'center' }}>
                    <h2 className="premium-dest-name" style={{ color: 'white' }}>Ready for your <em>Expedition?</em></h2>
                    <div style={{ marginTop: '40px' }}>
                        <a href="/safari-guide/packing-list" className="premium-exp-cta" style={{ justifyContent: 'center' }}>
                            <span>View Detailed Packing List</span>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    );
};
