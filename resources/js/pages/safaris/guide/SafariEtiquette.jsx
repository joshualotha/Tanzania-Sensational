import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { VolumeX, Camera, Users, Banknote, Map, Info } from 'lucide-react';
import { visualsData } from '../../../data/visualsData';
import { useVisuals } from '../../../context/VisualsContext';
import '../../../styles/safari-premium.css';

export const SafariEtiquette = () => {
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
                        src="https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&q=80&w=2000" 
                        alt="Safari Etiquette" 
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
                        <motion.h1 className="premium-hero-title" variants={fadeInUp}>Rules of the <em>Bush.</em></motion.h1>
                        <motion.p className="premium-hero-subtitle" variants={fadeInUp}>
                            Honoring the dignity of the wilderness and the culture of its people.
                        </motion.p>
                    </motion.div>
                </div>
            </section>

            {/* ─── WILDLIFE RESPECT ─── */}
            <section style={{ padding: '120px 0' }}>
                <div className="container">
                    <div style={{ textAlign: 'center', marginBottom: '80px' }}>
                        <span className="premium-eyebrow">Wildlife Protocol</span>
                        <h2 className="premium-dest-name">Silent <em>Observers.</em></h2>
                    </div>
                    
                    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))', gap: '40px' }}>
                        {[
                            {
                                title: 'The Whisper Rule',
                                icon: VolumeX,
                                text: 'Maintain a soft whisper during wildlife sightings. Loud noises can cause stress to animals and disturb their natural behavior.'
                            },
                            {
                                title: 'No Feeding',
                                icon: Info,
                                text: 'Feeding animals habituates them to humans, often leading to aggressive behavior and necessary, tragic intervention by authorities.'
                            },
                            {
                                title: 'Respect the Tracks',
                                icon: Map,
                                text: 'Off-roading is strictly prohibited in most Tanzanian parks to preserve the delicate root systems of the savanna grass.'
                            }
                        ].map((item, i) => (
                            <motion.div 
                                key={i} 
                                className="premium-dest-card" 
                                style={{ textAlign: 'center', padding: '50px 30px' }}
                                initial={{ opacity: 0, y: 20 }}
                                whileInView={{ opacity: 1, y: 0 }}
                                viewport={{ once: true }}
                                transition={{ delay: i * 0.1 }}
                            >
                                <item.icon color="var(--gold)" size={40} style={{ margin: '0 auto 25px' }} />
                                <h3 className="premium-dest-name" style={{ fontSize: '1.4rem' }}>{item.title}</h3>
                                <p className="premium-dest-desc" style={{ fontSize: '0.9rem' }}>{item.text}</p>
                            </motion.div>
                        ))}
                    </div>
                </div>
            </section>

            {/* ─── HUMAN RESPECT (EDITORIAL SECTION) ─── */}
            <section style={{ padding: '100px 0', background: '#1c1c1c', color: 'white' }}>
                <div className="container">
                    <div className="editorial-stagger-grid" style={{ display: 'grid', gridTemplateColumns: '1.2fr 1fr', gap: '100px', alignItems: 'center' }}>
                        <div>
                            <span className="premium-eyebrow" style={{ color: 'var(--gold)' }}>Cultural Dignity</span>
                            <h2 className="premium-dest-name" style={{ color: 'white' }}>People & <em>Portraits.</em></h2>
                            <p className="premium-dest-desc" style={{ color: 'rgba(255,255,255,0.7)', fontSize: '1.1rem' }}>
                                Tanzania is home to vibrant cultures, including the Maasai, Hadzabe, and Datoga. Respecting their personal space and dignity is a core value of Ndauwo.
                            </p>
                            
                            <div style={{ marginTop: '40px' }}>
                                <div style={{ marginBottom: '30px', display: 'flex', gap: '25px', alignItems: 'flex-start' }}>
                                    <Camera color="var(--gold)" style={{ flexShrink: 0 }} size={28} />
                                    <div>
                                        <h4 style={{ margin: 0, fontFamily: 'var(--font-heading)', fontSize: '1.3rem' }}>Ask First. Always.</h4>
                                        <p style={{ margin: '8px 0 0', opacity: 0.6, lineHeight: 1.6 }}>
                                            Never photograph local people or their children without explicit permission. Your guide can assist in facilitating respectful photography.
                                        </p>
                                    </div>
                                </div>
                                <div style={{ marginBottom: '30px', display: 'flex', gap: '25px', alignItems: 'flex-start' }}>
                                    <Users color="var(--gold)" style={{ flexShrink: 0 }} size={28} />
                                    <div>
                                        <h4 style={{ margin: 0, fontFamily: 'var(--font-heading)', fontSize: '1.3rem' }}>Support the Community</h4>
                                        <p style={{ margin: '8px 0 0', opacity: 0.6, lineHeight: 1.6 }}>
                                            Instead of handing out candy or small change to children—which encourages begging—we recommend donating to established community projects.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div className="premium-dest-img-wrap" style={{ borderRadius: '4px', overflow: 'hidden', boxShadow: '0 50px 100px rgba(0,0,0,0.5)' }}>
                                <img src="https://images.unsplash.com/photo-1549366021-9f761d450615?auto=format&fit=crop&q=80&w=1200" alt="Cultural Interaction" />
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* ─── TIPPING ─── */}
            <section style={{ padding: '120px 0' }}>
                <div className="container">
                    <div style={{ maxWidth: '850px', margin: '0 auto', background: '#fcfaf7', padding: '60px', border: '1px solid #eee' }}>
                        <div style={{ textAlign: 'center', marginBottom: '40px' }}>
                            <Banknote color="var(--gold)" size={40} style={{ margin: '0 auto 20px' }} />
                            <h2 className="premium-dest-name">The Art of <em>Gratitude.</em></h2>
                            <p className="premium-dest-desc">
                                Tipping is a traditional way to show appreciation for the hard work of your safari crew. While always at your discretion, the following guidelines are standard:
                            </p>
                        </div>
                        
                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '40px', borderTop: '1px solid #ddd', paddingTop: '40px' }}>
                            <div>
                                <h4 style={{ textTransform: 'uppercase', letterSpacing: '0.15em', fontSize: '0.8rem', opacity: 0.5, marginBottom: '15px' }}>Safari Guide</h4>
                                <p style={{ fontSize: '1.6rem', fontFamily: 'var(--font-heading)', margin: 0 }}>$20—$30 <span style={{ fontSize: '0.9rem', opacity: 0.5 }}>/ Per Day</span></p>
                                <p style={{ fontSize: '0.85rem', marginTop: '10px', opacity: 0.7 }}>Typically presented in a sealed envelope at the end of the journey.</p>
                            </div>
                            <div>
                                <h4 style={{ textTransform: 'uppercase', letterSpacing: '0.15em', fontSize: '0.8rem', opacity: 0.5, marginBottom: '15px' }}>Lodge Staff</h4>
                                <p style={{ fontSize: '1.6rem', fontFamily: 'var(--font-heading)', margin: 0 }}>$10—$15 <span style={{ fontSize: '0.9rem', opacity: 0.5 }}>/ Per Day</span></p>
                                <p style={{ fontSize: '0.85rem', marginTop: '10px', opacity: 0.7 }}>Usually placed in the communal "tip box" found in the main lodge reception.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
};
