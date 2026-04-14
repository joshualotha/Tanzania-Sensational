import React, { useEffect, useState } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import { Check, Camera, Sun, Shield, Droplets, Heart, Package } from 'lucide-react';
import '../../styles/ultra-premium.css';

const PackingList = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);
    const visuals = useVisuals();
    const [checked, setChecked] = useState({});

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const toggle = (id) => setChecked(prev => ({ ...prev, [id]: !prev[id] }));

    const categories = [
        {
            name: 'Essential Documents',
            icon: <Shield size={20} />,
            items: [
                { id: 'passport', label: 'Valid Passport (6+ months validity)', critical: true },
                { id: 'visa', label: 'Tanzania Entry Visa (or e-Visa confirmation)', critical: true },
                { id: 'yellow-fever', label: 'Yellow Fever Vaccination Certificate', critical: true },
                { id: 'insurance', label: 'Travel & Medical Insurance Documents', critical: true },
                { id: 'flights', label: 'Flight Confirmations & E-Tickets', critical: false },
                { id: 'vouchers', label: 'Safari/Trekking Booking Vouchers', critical: false },
                { id: 'cash', label: 'USD Cash (crisp, post-2009 bills for tips)', critical: false },
            ]
        },
        {
            name: 'Clothing & Footwear',
            icon: <Sun size={20} />,
            items: [
                { id: 'pants', label: 'Quick-dry safari pants (2-3 pairs)', critical: true },
                { id: 'shirts', label: 'Lightweight, neutral-colored shirts (4-5)', critical: true },
                { id: 'fleece', label: 'Warm fleece or down jacket (mornings)', critical: true },
                { id: 'rain', label: 'Light rain jacket or poncho', critical: false },
                { id: 'underwear', label: 'Moisture-wicking underwear', critical: false },
                { id: 'socks', label: 'Merino wool or synthetic socks (5+ pairs)', critical: false },
                { id: 'hat', label: 'Wide-brimmed sun hat (essential)', critical: true },
                { id: 'walking-shoes', label: 'Comfortable walking shoes or boots', critical: true },
                { id: 'sandals', label: 'Camp sandals or flip-flops', critical: false },
            ]
        },
        {
            name: 'Health & Protection',
            icon: <Heart size={20} />,
            items: [
                { id: 'sunscreen', label: 'SPF 50+ broad-spectrum sunscreen', critical: true },
                { id: 'bug-spray', label: 'DEET-based insect repellent (30%+)', critical: true },
                { id: 'meds', label: 'Personal prescription medications', critical: true },
                { id: 'first-aid', label: 'Basic first-aid kit (bandages, antiseptic)', critical: false },
                { id: 'malaria', label: 'Anti-malaria prophylaxis (consult doctor)', critical: true },
                { id: 'hand-sanitizer', label: 'Hand sanitizer (60%+ alcohol)', critical: false },
                { id: 'lip-balm', label: 'SPF lip balm', critical: false },
            ]
        },
        {
            name: 'Photography & Electronics',
            icon: <Camera size={20} />,
            items: [
                { id: 'camera', label: 'DSLR/Mirrorless camera + lenses', critical: false },
                { id: 'binoculars', label: 'Binoculars (8x42 recommended)', critical: true },
                { id: 'batteries', label: 'Spare camera/phone batteries', critical: true },
                { id: 'charger', label: 'Universal power adapter (Type G, UK plug)', critical: true },
                { id: 'power-bank', label: 'Portable power bank (20,000mAh+)', critical: false },
                { id: 'memory', label: 'Extra SD cards or storage', critical: false },
                { id: 'headlamp', label: 'Headlamp or small flashlight', critical: true },
            ]
        },
        {
            name: 'Comfort & Extras',
            icon: <Package size={20} />,
            items: [
                { id: 'daypack', label: 'Small daypack (20-30L for game drives)', critical: true },
                { id: 'water-bottle', label: 'Reusable water bottle (1L+)', critical: true },
                { id: 'sunglasses', label: 'Polarized sunglasses (UV protection)', critical: true },
                { id: 'snacks', label: 'Energy bars or trail mix', critical: false },
                { id: 'journal', label: 'Travel journal or notebook', critical: false },
                { id: 'earplugs', label: 'Earplugs (for light sleepers)', critical: false },
                { id: 'laundry', label: 'Small pack of laundry detergent', critical: false },
            ]
        }
    ];

    const totalItems = categories.reduce((acc, cat) => acc + cat.items.length, 0);
    const checkedCount = Object.values(checked).filter(Boolean).length;
    const progress = Math.round((checkedCount / totalItems) * 100);

    return (
        <div className="lux-root">
            {/* ─── HERO ─── */}
            <section className="lux-hero">
                <img
                    src={visuals.getSingle('safari.packingHero', visualsData.planning.gearHero)}
                    alt="Packing for Safari"
                />
                <div className="lux-hero-overlay"></div>
                <div className="lux-hero-content">
                    <motion.span className="lux-hero-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>The Complete Checklist</motion.span>
                    <motion.h1 className="lux-hero-title" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.1 }}>
                        Packing <em>List.</em>
                    </motion.h1>
                </div>
            </section>

            {/* ─── PROGRESS BAR ─── */}
            <section className="lux-progress-strip">
                <div className="lux-progress-inner">
                    <span className="lux-progress-text">
                        <strong>{checkedCount}</strong> of {totalItems} items packed
                    </span>
                    <div className="lux-progress-track">
                        <motion.div
                            className="lux-progress-fill"
                            initial={{ width: 0 }}
                            animate={{ width: `${progress}%` }}
                            transition={{ duration: 0.5, ease: 'easeOut' }}
                        />
                    </div>
                    <span className="lux-progress-pct" style={{ color: progress === 100 ? '#2d8b4e' : 'var(--lux-tan)' }}>
                        {progress === 100 ? '✓ Ready!' : `${progress}%`}
                    </span>
                </div>
            </section>

            {/* ─── EDITORIAL INTRO ─── */}
            <section className="lux-section">
                <div className="lux-editorial-grid">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-100px" }} variants={fadeInUp}>
                        <h2 className="lux-heading">Pack Light, Pack <em>Right.</em></h2>
                        <p className="lux-body">
                            The golden rule of safari packing: soft-sided luggage only. Most bush camps and lodges use light aircraft transfers with strict 15kg (33lb) weight limits in soft duffel bags — no hard-shell suitcases allowed.
                        </p>
                        <p className="lux-body">
                            Every item on this list has been battle-tested across hundreds of expeditions. The critical items are non-negotiable; the optional ones enhance comfort. Tick them off as you pack.
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
                            src={visuals.getSingle('safari.packingEditorial', visualsData.trekking.routes.lemosho)}
                            alt="Safari Luggage"
                        />
                        <div className="lux-image-caption">Soft duffel bags are the only acceptable luggage for bush flights.</div>
                    </motion.div>
                </div>
            </section>

            {/* ─── CHECKLIST ─── */}
            {categories.map((cat, i) => (
                <section key={i} className={`lux-section ${i % 2 === 0 ? 'lux-section-alt' : ''}`}>
                    <motion.div
                        className="lux-checklist-block"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={fadeInUp}
                    >
                        <div className="lux-checklist-header">
                            <div className="lux-checklist-icon">{cat.icon}</div>
                            <h3 className="lux-checklist-cat-title">{cat.name}</h3>
                        </div>
                        <div className="lux-checklist-items">
                            {cat.items.map((item) => (
                                <motion.div
                                    key={item.id}
                                    className={`lux-checklist-item ${checked[item.id] ? 'checked' : ''}`}
                                    onClick={() => toggle(item.id)}
                                    whileHover={{ scale: 1.01 }}
                                    whileTap={{ scale: 0.99 }}
                                >
                                    <div className="lux-checkbox">
                                        {checked[item.id] && <Check size={14} />}
                                    </div>
                                    <span className="lux-checklist-label">{item.label}</span>
                                    {item.critical && (
                                        <span className="lux-essential-badge">ESSENTIAL</span>
                                    )}
                                </motion.div>
                            ))}
                        </div>
                    </motion.div>
                </section>
            ))}

            {/* ─── FULL BLEED PARALLAX ─── */}
            <section className="lux-full-bleed">
                <img
                    src={visuals.getSingle('safari.packingFullBleed', visualsData.planning.meruHero)}
                    alt="Safari Ready"
                />
            </section>

            {/* ─── CTA ─── */}
            <section className="lux-cta">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    <h2 className="lux-heading" style={{ marginBottom: '20px' }}>Stay Safe in the <em>Bush.</em></h2>
                    <p className="lux-body" style={{ maxWidth: '600px', margin: '0 auto 30px' }}>
                        Now that you're packed and ready, learn about health precautions and safety protocols for your Tanzanian adventure.
                    </p>
                    <Link to="/safari-guide/health-and-safety" className="lux-btn" style={{ display: 'inline-flex', alignItems: 'center', gap: '10px' }}>
                        Health & Safety Guide
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
                        </svg>
                    </Link>
                </motion.div>
            </section>
        </div>
    );
};

export default PackingList;
