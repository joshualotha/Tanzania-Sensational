import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Briefcase, Camera, HeartPulse, FileText, Luggage, Umbrella } from 'lucide-react';
import { visualsData } from '../../../data/visualsData';
import { useVisuals } from '../../../context/VisualsContext';
import '../../../styles/safari-premium.css';

export const PackingList = () => {
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

    const categories = [
        {
            title: 'Bush Clothing',
            icon: Luggage,
            items: [
                '3-4 T-shirts (Neutral colors)',
                '2 Long-sleeved shirts',
                '2 Pairs of trousers (Zip-offs recommended)',
                '1 Warm fleece or jacket',
                '1 Lightweight rain shell',
                'Comfortable trainers or walking shoes',
                'Wide-brimmed safari hat',
                'Swimwear for lodge pools'
            ]
        },
        {
            title: 'Technology & Optics',
            icon: Camera,
            items: [
                'Binoculars (Essential, one per person)',
                'Camera with zoom lens (200mm+)',
                'Extra memory cards & batteries',
                'Universal power adapter',
                'High-capacity power bank',
                'Smartphone with offline maps'
            ]
        },
        {
            title: 'Health & Personal',
            icon: HeartPulse,
            items: [
                'Insect repellent (DEET or Picaridin)',
                'High SPF Sunscreen & Lip balm',
                'Prescription medications',
                'Personal first-aid kit',
                'Anti-malaria prophylaxis',
                'Sanitizing wipes & gel'
            ]
        },
        {
            title: 'Documents',
            icon: FileText,
            items: [
                'Valid Passport (6 months+ left)',
                'E-Visa or print-outs',
                'Yellow Fever certificate (if required)',
                'Travel insurance details',
                'Emergency contact list',
                'Flight itineraries'
            ]
        }
    ];

    return (
        <div className="safari-premium-root">
            {/* ─── HERO SECTION ─── */}
            <section className="premium-safari-hero" style={{ height: '65vh' }}>
                <motion.div className="premium-safari-bg">
                    <img 
                        src="https://images.unsplash.com/photo-1522814300958-f584e27fdf00?auto=format&fit=crop&q=80&w=2000" 
                        alt="Safari Packing" 
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
                        <motion.h1 className="premium-hero-title" variants={fadeInUp}>The Expedition <em>Manifest.</em></motion.h1>
                        <motion.p className="premium-hero-subtitle" variants={fadeInUp}>
                            A curated list for the prepared wilderness explorer.
                        </motion.p>
                    </motion.div>
                </div>
            </section>

            {/* ─── LUGGAGE LIMITS CARD ─── */}
            <section style={{ padding: '80px 0', marginTop: '-100px', position: 'relative', zIndex: 10 }}>
                <div className="container">
                    <div style={{ background: 'var(--dark)', color: 'white', padding: '50px', borderRadius: '4px', borderLeft: '4px solid var(--gold)' }}>
                        <div style={{ display: 'flex', gap: '30px', alignItems: 'center', flexWrap: 'wrap' }}>
                            <div style={{ flex: 1, minWidth: '300px' }}>
                                <h3 className="premium-dest-name" style={{ color: 'var(--gold)', fontSize: '1.8rem' }}>The Golden Rule: <em>Soft Bags Only.</em></h3>
                                <p style={{ opacity: 0.8, lineHeight: 1.8 }}>
                                    If you are traveling via light aircraft to remote camps, standard hard-shell suitcases are prohibited. You must use **soft-sided duffel bags** that can be easily stowed in small cargo pods.
                                </p>
                            </div>
                            <div style={{ display: 'flex', gap: '40px' }}>
                                <div style={{ textAlign: 'center' }}>
                                    <span style={{ display: 'block', fontSize: '2.5rem', fontWeight: 700, color: 'white' }}>15kg</span>
                                    <span style={{ fontSize: '0.7rem', textTransform: 'uppercase', letterSpacing: '0.2em', opacity: 0.5 }}>Weight Limit</span>
                                </div>
                                <div style={{ textAlign: 'center' }}>
                                    <span style={{ display: 'block', fontSize: '2.5rem', fontWeight: 700, color: 'white' }}>Soft</span>
                                    <span style={{ fontSize: '0.7rem', textTransform: 'uppercase', letterSpacing: '0.2em', opacity: 0.5 }}>Bag Requirement</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {/* ─── PACKING GRID ─── */}
            <section style={{ padding: '80px 0' }}>
                <div className="container">
                    <div className="premium-dest-grid" style={{ gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))' }}>
                        {categories.map((cat, i) => (
                            <motion.div 
                                key={i} 
                                className="premium-dest-card" 
                                style={{ background: 'white', borderTop: 'none', borderBottom: '1px solid #eee' }}
                                initial={{ opacity: 0, y: 20 }}
                                whileInView={{ opacity: 1, y: 0 }}
                                viewport={{ once: true }}
                                transition={{ delay: i * 0.1 }}
                            >
                                <div style={{ display: 'flex', alignItems: 'center', gap: '15px', marginBottom: '30px' }}>
                                    <cat.icon color="var(--gold)" size={28} />
                                    <h3 className="premium-dest-name" style={{ fontSize: '1.4rem', margin: 0 }}>{cat.title}</h3>
                                </div>
                                <ul style={{ listStyle: 'none', padding: 0 }}>
                                    {cat.items.map((item, j) => (
                                        <li key={j} style={{ padding: '12px 0', borderBottom: j === cat.items.length - 1 ? 'none' : '1px solid #f5f5f5', fontSize: '0.95rem', color: '#555', display: 'flex', gap: '10px' }}>
                                            <span style={{ color: 'var(--gold)' }}>—</span> {item}
                                        </li>
                                    ))}
                                </ul>
                            </motion.div>
                        ))}
                    </div>
                </div>
            </section>

            {/* ─── PROHIBITED ITEMS ─── */}
            <section style={{ padding: '100px 0', background: '#1c1c1c', color: 'white' }}>
                <div className="container">
                    <div style={{ textAlign: 'center', marginBottom: '60px' }}>
                        <h2 className="premium-dest-name" style={{ color: 'white' }}>Strictly <em>Prohibited.</em></h2>
                        <p style={{ opacity: 0.6, maxWidth: '600px', margin: '0 auto' }}>Tanzania has strict environmental and safety regulations. Do not pack the following:</p>
                    </div>
                    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(200px, 1fr))', gap: '40px' }}>
                        {[
                            { title: 'Single-Use Plastics', icon: XCircle, desc: 'Tanzania has a strict ban on all plastic bags. They will be confiscated at the airport.' },
                            { title: 'Drones', icon: XCircle, desc: 'Prohibited in all National Parks without expensive, prior-approved official permits.' },
                            { title: 'Camo Clothing', icon: XCircle, desc: 'Restricted for civilian use; highly associated with military personnel only.' }
                        ].map((item, i) => (
                            <div key={i} style={{ textAlign: 'center', padding: '20px' }}>
                                <h4 style={{ color: '#A76B56', fontSize: '1.2rem', marginBottom: '15px' }}>{item.title}</h4>
                                <p style={{ fontSize: '0.9rem', opacity: 0.7, lineHeight: 1.6 }}>{item.desc}</p>
                            </div>
                        ))}
                    </div>
                </div>
            </section>
        </div>
    );
};

const XCircle = ({ color, size }) => (
    <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke={color} strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
        <circle cx="12" cy="12" r="10" />
        <line x1="15" y1="9" x2="9" y2="15" />
        <line x1="9" y1="9" x2="15" y2="15" />
    </svg>
);
