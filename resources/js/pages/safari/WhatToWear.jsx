import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import { Check } from 'lucide-react';
import '../../styles/safari-field-guide.css';

const WhatToWear = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);
    const visuals = useVisuals();

    const fade = {
        hidden: { opacity: 0, y: 40 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.4, ease: [0.16, 1, 0.3, 1] } }
    };

    const occasions = [
        {
            num: '01',
            title: 'Morning Game Drive',
            desc: 'The 4 AM departures are genuinely cold. Open-top vehicles at 5°C with wind chill will test your resolve if you\'re underprepared. Dress as if you\'re going skiing.',
            items: ['Long pants', 'Long-sleeve shirt', 'Heavy fleece', 'Windproof jacket', 'Beanie', 'Gloves']
        },
        {
            num: '02',
            title: 'Midday at Camp',
            desc: 'By noon, the mercury has swung 30 degrees. Camp is where you shed everything and embrace the equatorial heat. Light, airy, sunscreen-heavy.',
            items: ['Shorts', 'Short-sleeve shirt', 'Wide-brim sun hat', 'Sunglasses', 'SPF 50+', 'Camp sandals']
        },
        {
            num: '03',
            title: 'Evening Sundowner',
            desc: 'Safari camps elevate at dusk. The bush bar, the fire pit, the long table under the stars — this is where "refined bush elegance" earns its meaning.',
            items: ['Chinos or clean trousers', 'Collared shirt', 'Light jacket', 'Closed-toe shoes', 'Watch (no phone)', 'A good story']
        },
        {
            num: '04',
            title: 'Walking Safari',
            desc: 'On foot in Big Five territory, neutral colors are non-negotiable. White and bright colors startle wildlife. You are entering their home, not a fashion show.',
            items: ['Long pants (earth tones)', 'Neutral long-sleeve', 'Closed-toe boots', 'Gaiters (optional)', 'Sun protection', 'Binoculars']
        }
    ];

    return (
        <div className="field-root">

            {/* ═══ HERO ═══ */}
            <section className="field-hero">
                <div className="field-hero-img">
                    <img src={visuals.getSingle('safari.whatToWearHero', visualsData.safaris.listHero)} alt="Safari attire in the bush" />
                </div>
                <div className="field-hero-gradient" />
                <motion.div className="field-hero-content" initial="hidden" animate="visible" variants={fade}>
                    <span className="field-hero-eyebrow">The Field Manual</span>
                    <h1 className="field-hero-title">What to <em>Wear</em></h1>
                    <p className="field-hero-subtitle">
                        Your clothing is your first line of defense. Against the sun, the cold, the insects, and bad photographs.
                    </p>
                </motion.div>
            </section>

            {/* ═══ CHAPTER 1 — THE PHILOSOPHY ═══ */}
            <div className="field-split">
                <div className="field-split-text">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-80px" }} variants={fade}>
                        <span className="field-chapter-num">01</span>
                        <span className="field-chapter-eyebrow">Color Philosophy</span>
                        <h2 className="field-chapter-title">The Safari <em>Palette</em></h2>
                        <p className="field-chapter-body">
                            Leave the bright whites and neon tones at home. On safari, your wardrobe should blend with the landscape, not compete with it.
                        </p>
                        <p className="field-chapter-body">
                            Khaki, olive, tan, and muted earth tones are the gold standard. These colors don't attract tsetse flies, don't spook game, and photograph beautifully against the golden hour light.
                        </p>
                    </motion.div>
                </div>
                <motion.div className="field-split-img" initial={{ opacity: 0, scale: 1.05 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} transition={{ duration: 1.5 }}>
                    <img src={visuals.getSingle('safari.whatToWearEditorial', visualsData.planning.meruHero)} alt="Earth-toned safari clothing" />
                </motion.div>
            </div>

            {/* ═══ PULL QUOTE ═══ */}
            <motion.section className="field-pullquote" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} viewport={{ once: true }} transition={{ duration: 1.2 }}>
                <p className="field-pullquote-text">
                    "The experienced safari hand doesn't dress for Instagram — they dress for the bush."
                </p>
                <span className="field-pullquote-attr">Field Notes, Northern Tanzania</span>
            </motion.section>

            {/* ═══ CHAPTER 2 — FABRIC SCIENCE ═══ */}
            <div className="field-split reversed field-split-dark">
                <motion.div className="field-split-img" initial={{ opacity: 0, scale: 1.05 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} transition={{ duration: 1.5 }}>
                    <img src={visuals.getSingle('safari.whatToWearFullBleed', visualsData.safaris.migrationHero)} alt="Breathable safari fabrics" />
                </motion.div>
                <div className="field-split-text">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-80px" }} variants={fade}>
                        <span className="field-chapter-num">02</span>
                        <span className="field-chapter-eyebrow">Fabric Science</span>
                        <h2 className="field-chapter-title">Breathable is <em>Everything</em></h2>
                        <p className="field-chapter-body">
                            The African sun is relentless, but your clothing doesn't have to be. Choose lightweight, moisture-wicking fabrics that dry quickly and resist wrinkles.
                        </p>
                        <p className="field-chapter-body">
                            Cotton is acceptable in camp, but synthetic blends dominate the field. Quick-dry nylon and merino wool are the fabrics of choice for professionals who spend weeks in the bush.
                        </p>
                    </motion.div>
                </div>
            </div>

            {/* ═══ FULL BLEED BREAK ═══ */}
            <section className="field-bleed">
                <img src={visuals.getSingle('safari.whatToWearFullBleed', visualsData.safaris.migrationHero)} alt="Savanna landscape" />
                <span className="field-bleed-caption">Serengeti, Tanzania</span>
            </section>

            {/* ═══ CHAPTER 3 — THE DAILY ROTATION ═══ */}
            <section className="field-chapter">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade}>
                    <span className="field-chapter-num">03</span>
                    <span className="field-chapter-eyebrow">The Daily Rotation</span>
                    <h2 className="field-chapter-title">Four Outfits for <em>Four Moments</em></h2>
                    <p className="field-chapter-body">
                        A single safari day swings from near-freezing to scorching heat. The solution is not one outfit — it's four strategic wardrobe changes built into your day.
                    </p>
                </motion.div>
            </section>

            <section className="field-details-section" style={{ paddingTop: 0 }}>
                {occasions.map((item, i) => (
                    <motion.div className="field-detail-row" key={i} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade} transition={{ delay: i * 0.08 }}>
                        <span className="field-detail-num">{item.num}</span>
                        <div>
                            <h3 className="field-detail-title">{item.title}</h3>
                            <p className="field-detail-desc">{item.desc}</p>
                            <ul className="field-detail-items">
                                {item.items.map((itm, j) => <li key={j}>{itm}</li>)}
                            </ul>
                        </div>
                    </motion.div>
                ))}
            </section>

            {/* ═══ CTA ═══ */}
            <section className="field-cta">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade}>
                    <h2 className="field-cta-title">Ready for the <em>Bush?</em></h2>
                    <p className="field-cta-body">
                        Now that you know what to wear, explore our complete packing list to ensure nothing is left behind.
                    </p>
                    <Link to="/safari-guide/packing-guide" className="field-btn">
                        View Packing List
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" /></svg>
                    </Link>
                </motion.div>
            </section>
        </div>
    );
};

export default WhatToWear;
