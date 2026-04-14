import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { ShieldCheck, Droplet, Sun, Zap, AlertTriangle, Heart } from 'lucide-react';
import { visualsData } from '../../../data/visualsData';
import { useVisuals } from '../../../context/VisualsContext';
import '../../../styles/safari-premium.css';

export const HealthSafety = () => {
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

    return (
        <div className="safari-premium-root">
            {/* ─── HERO SECTION ─── */}
            <section className="premium-safari-hero" style={{ height: '70vh' }}>
                <motion.div className="premium-safari-bg">
                    <img 
                        src="https://images.unsplash.com/photo-1547970810-dc1eac37d174?auto=format&fit=crop&q=80&w=2000" 
                        alt="Safari Safety" 
                    />
                    <div className="premium-safari-overlay"></div>
                </motion.div>
                <div className="container">
                    <motion.div 
                        className="premium-safari-hero-content"
                        initial="hidden"
                        animate="visible"
                    >
                        <motion.span className="premium-eyebrow" variants={fadeInUp}>Safari Guide</motion.span>
                        <motion.h1 className="premium-hero-title" variants={fadeInUp}>A Safe <em>Journey.</em></motion.h1>
                        <motion.p className="premium-hero-subtitle" variants={fadeInUp}>
                            Uncompromising standards for your health and well-being in the wild.
                        </motion.p>
                    </motion.div>
                </div>
            </section>

            {/* ─── HEALTH PILLARS ─── */}
            <section style={{ padding: '100px 0' }}>
                <div className="container">
                    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(450px, 1fr))', gap: '30px' }}>
                        
                        {/* Malaria & Insects */}
                        <motion.div 
                            className="premium-dest-card" 
                            style={{ background: 'white', padding: '50px' }}
                            variants={fadeInUp} initial="hidden" whileInView="visible" viewport={{ once: true }}
                        >
                            <ShieldCheck color="var(--gold)" size={40} style={{ marginBottom: '25px' }} />
                            <h2 className="premium-dest-name" style={{ fontSize: '2rem' }}>Malaria & <em>Insects.</em></h2>
                            <p className="premium-dest-desc">
                                Tanzania is a malaria-endemic region. Prophylaxis is highly recommended. Consult your physician well in advance to discuss the best medication for your health profile.
                            </p>
                            <div style={{ borderTop: '1px solid #f0f0f0', paddingTop: '20px', marginTop: '20px' }}>
                                <p style={{ fontSize: '0.9rem', fontWeight: 600, color: 'var(--gold)', marginBottom: '10px' }}>The Defense Strategy:</p>
                                <ul style={{ paddingLeft: '20px', fontSize: '0.9rem', color: '#555', lineHeight: 1.8 }}>
                                    <li>Apply 20-30% DEET or Picaridin repellent to exposed skin.</li>
                                    <li>Wear long-sleeved shirts and trousers in the evening.</li>
                                    <li>Camps provide treated mosquito nets; ensure they are tucked in.</li>
                                </ul>
                            </div>
                        </motion.div>

                        {/* Hydration & Water */}
                        <motion.div 
                            className="premium-dest-card" 
                            style={{ background: '#1c1c1c', padding: '50px', color: 'white' }}
                            variants={fadeInUp} initial="hidden" whileInView="visible" viewport={{ once: true }}
                        >
                            <Droplet color="white" size={40} style={{ marginBottom: '25px' }} />
                            <h2 className="premium-dest-name" style={{ fontSize: '2rem', color: 'white' }}>Water & <em>Hydration.</em></h2>
                            <p className="premium-dest-desc" style={{ color: 'rgba(255,255,255,0.7)' }}>
                                The African sun is relentless. Dehydration is the most common safari ailment. 
                            </p>
                            <div style={{ background: 'rgba(255,255,255,0.05)', padding: '25px', borderRadius: '4px', borderLeft: '3px solid white' }}>
                                <p style={{ margin: 0, fontWeight: 700, letterSpacing: '0.1em', fontSize: '0.8rem', textTransform: 'uppercase', marginBottom: '10px' }}>CRITICAL RULE:</p>
                                <p style={{ margin: 0, fontSize: '1.2rem', fontFamily: 'var(--font-heading)', fontStyle: 'italic' }}>
                                    "Never drink tap water. Ever."
                                </p>
                            </div>
                            <p style={{ marginTop: '20px', fontSize: '0.9rem', opacity: 0.7 }}>
                                Only consume bottled or purified water provided by our team. Use it even for brushing your teeth.
                            </p>
                        </motion.div>

                    </div>
                </div>
            </section>

            {/* ─── WILDLIFE SAFETY ─── */}
            <section style={{ padding: '100px 0', background: '#fcfaf7' }}>
                <div className="container">
                    <div className="editorial-stagger-grid" style={{ display: 'grid', gridTemplateColumns: '1fr 1.2fr', gap: '100px', alignItems: 'center' }}>
                        <div>
                            <div className="premium-dest-img-wrap" style={{ aspectRatio: '3/4', borderRadius: '8px' }}>
                                <img src="https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&q=80&w=1200" alt="Wildlife" />
                            </div>
                        </div>
                        <div>
                            <span className="premium-eyebrow">The Wild Reality</span>
                            <h2 className="premium-dest-name">Wildlife <em>Encounters.</em></h2>
                            <p className="premium-dest-desc">
                                All animals in our parks are wild and unpredictable. While our guides are experts in behavior and threat assessment, your cooperation is essential.
                            </p>
                            
                            <div style={{ marginTop: '40px' }}>
                                {[
                                    { title: 'Stay Inside the Vehicle', text: 'Never exit the vehicle unless specifically instructed by your guide in designated safe zones.' },
                                    { title: 'Silent Sightings', text: 'Loud noises or rapid movements can provoke animals or cause them to flee.' },
                                    { title: 'Lodge Protocol', text: 'Never walk alone around the lodge grounds at night; always request an escort.' }
                                ].map((item, i) => (
                                    <div key={i} style={{ marginBottom: '30px', display: 'flex', gap: '20px' }}>
                                        <AlertTriangle color="#A76B56" style={{ flexShrink: 0 }} />
                                        <div>
                                            <h4 style={{ margin: 0, fontFamily: 'var(--font-heading)', fontSize: '1.2rem' }}>{item.title}</h4>
                                            <p style={{ margin: '5px 0 0', opacity: 0.7, fontSize: '0.95rem' }}>{item.text}</p>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* ─── FINAL ASSURANCE ─── */}
            <section style={{ padding: '120px 0' }}>
                <div className="container" style={{ textAlign: 'center' }}>
                    <div style={{ maxWidth: '800px', margin: '0 auto' }}>
                        <Heart color="var(--gold)" size={48} style={{ margin: '0 auto 30px' }} />
                        <h2 className="premium-dest-name">Our <em>Commitment.</em></h2>
                        <p className="premium-dest-desc">
                            Ndauwo Safari Co. maintains partnerships with emergency medical evacuation services. Every vehicle is equipped with high-frequency radios and first-aid kits. Your safety isn't just a protocol—it is our first priority.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    );
};
