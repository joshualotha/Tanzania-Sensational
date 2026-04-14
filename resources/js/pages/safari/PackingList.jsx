import React, { useEffect, useState } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import { Check, Shield, Sun, Heart, Camera, Package } from 'lucide-react';
import '../../styles/safari-field-guide.css';

const PackingList = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);
    const visuals = useVisuals();
    const [checked, setChecked] = useState({});

    const fade = {
        hidden: { opacity: 0, y: 40 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.4, ease: [0.16, 1, 0.3, 1] } }
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
        <div className="field-root">

            {/* ═══ HERO ═══ */}
            <section className="field-hero">
                <div className="field-hero-img">
                    <img src={visuals.getSingle('safari.packingHero', visualsData.planning.gearHero)} alt="Safari gear laid out" />
                </div>
                <div className="field-hero-gradient" />
                <motion.div className="field-hero-content" initial="hidden" animate="visible" variants={fade}>
                    <span className="field-hero-eyebrow">The Complete Checklist</span>
                    <h1 className="field-hero-title">Packing <em>List</em></h1>
                    <p className="field-hero-subtitle">
                        Every item battle-tested across hundreds of expeditions. Tick them off as you pack.
                    </p>
                </motion.div>
            </section>

            {/* ═══ PROGRESS BAR ═══ */}
            <section className="field-progress">
                <span className="field-progress-text">
                    <strong>{checkedCount}</strong> of {totalItems} items packed
                </span>
                <div className="field-progress-track">
                    <motion.div
                        className="field-progress-fill"
                        initial={{ width: 0 }}
                        animate={{ width: `${progress}%` }}
                        transition={{ duration: 0.5 }}
                    />
                </div>
                <span className="field-progress-pct" style={{ color: progress === 100 ? '#4ade80' : undefined }}>
                    {progress === 100 ? '✓ Ready' : `${progress}%`}
                </span>
            </section>

            {/* ═══ EDITORIAL INTRO — SPLIT ═══ */}
            <div className="field-split">
                <div className="field-split-text">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-80px" }} variants={fade}>
                        <span className="field-chapter-eyebrow">Before You Pack</span>
                        <h2 className="field-chapter-title">Pack Light, Pack <em>Right</em></h2>
                        <p className="field-chapter-body">
                            The golden rule of safari packing: soft-sided luggage only. Most bush camps use light aircraft transfers with strict 15kg weight limits in soft duffel bags — no hard-shell suitcases allowed.
                        </p>
                        <p className="field-chapter-body">
                            The critical items are non-negotiable. The optional ones enhance comfort. Everything here has earned its place.
                        </p>
                    </motion.div>
                </div>
                <motion.div className="field-split-img" initial={{ opacity: 0, scale: 1.05 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} transition={{ duration: 1.5 }}>
                    <img src={visuals.getSingle('safari.packingEditorial', visualsData.trekking.routes.lemosho)} alt="Safari duffel bag" />
                </motion.div>
            </div>

            {/* ═══ CHECKLIST CATEGORIES ═══ */}
            {categories.map((cat, i) => (
                <section key={i} className={`field-checklist-section ${i % 2 !== 0 ? 'field-section-alt' : ''}`}>
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade}>
                        <div className="field-checklist-header">
                            <span className="field-checklist-icon">{cat.icon}</span>
                            <h3 className="field-checklist-cat">{cat.name}</h3>
                        </div>
                        {cat.items.map((item) => (
                            <motion.div
                                key={item.id}
                                className={`field-check-item ${checked[item.id] ? 'checked' : ''}`}
                                onClick={() => toggle(item.id)}
                                whileTap={{ scale: 0.99 }}
                            >
                                <div className="field-check-box">
                                    {checked[item.id] && <Check size={13} />}
                                </div>
                                <span className="field-check-label">{item.label}</span>
                                {item.critical && <span className="field-check-badge">Essential</span>}
                            </motion.div>
                        ))}
                    </motion.div>
                </section>
            ))}

            {/* ═══ FULL BLEED ═══ */}
            <section className="field-bleed">
                <img src={visuals.getSingle('safari.packingFullBleed', visualsData.planning.meruHero)} alt="Safari expedition ready" />
                <span className="field-bleed-caption">Ready for the bush</span>
            </section>

            {/* ═══ CTA ═══ */}
            <section className="field-cta">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade}>
                    <h2 className="field-cta-title">Stay Safe in the <em>Bush</em></h2>
                    <p className="field-cta-body">
                        Now that you're packed, learn about health precautions and safety protocols for your Tanzanian adventure.
                    </p>
                    <Link to="/safari-guide/health-and-safety" className="field-btn">
                        Health & Safety Guide
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" /></svg>
                    </Link>
                </motion.div>
            </section>
        </div>
    );
};

export default PackingList;
