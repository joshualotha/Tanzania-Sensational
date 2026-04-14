import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import '../../styles/safari-field-guide.css';

const SafariEtiquette = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);
    const visuals = useVisuals();

    const fade = {
        hidden: { opacity: 0, y: 40 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.4, ease: [0.16, 1, 0.3, 1] } }
    };

    const guidelines = [
        {
            num: '01',
            title: 'The Greeting Ritual',
            desc: 'In Tanzania, greetings are not a formality — they are a ritual of respect and human connection. Before any business, negotiation, or conversation begins, there is a proper exchange of pleasantries.',
            items: ['Always say "Jambo" or "Habari" before anything else', 'Ask about family, health, and work first', 'Shake hands gently — firm grip is aggressive', 'Use "Asante sana" frequently and genuinely', 'Never rush a greeting — it\'s disrespectful']
        },
        {
            num: '02',
            title: 'Photography Etiquette',
            desc: 'Photography is a privilege, not a right. Always ask permission before photographing people, their homes, or their property. A smile and a gesture toward your camera is universally understood.',
            items: ['Always ask before photographing people', 'Offer to show them the photo afterward', 'Never photograph government buildings', 'Tip guides who help with great shots', 'Silence your shutter in sensitive moments']
        },
        {
            num: '03',
            title: 'Dress with Modesty',
            desc: 'Tanzania is a conservative country with significant Muslim and Christian populations. Outside of beach resorts and safari lodges, modest dress is expected and respected.',
            items: ['Cover shoulders and knees in villages', 'Swimwear only at pools and beaches', 'Remove shoes when entering homes or mosques', 'Dress conservatively in Stone Town', 'Safari attire can be casual — you\'re in the bush']
        },
        {
            num: '04',
            title: 'Tipping Culture',
            desc: 'Tipping is not just appreciated — it is an essential part of the Tanzanian tourism economy. Your guides, drivers, cooks, and camp staff rely on tips for a significant portion of their income.',
            items: ['Safari Guide: $15-25 per guest per day', 'Driver: $10-15 per guest per day', 'Camp Staff: $5-10 per guest per day (pooled)', 'Restaurant: 10% if no service charge', 'Porters: $5-10 per bag']
        },
        {
            num: '05',
            title: 'Patience & "Pole Pole"',
            desc: '"Pole pole" (slowly, slowly) is the Tanzanian philosophy of life. Things move at their own pace, and frustration is counterproductive. Embrace the rhythm — it is part of the adventure.',
            items: ['Service may be slower — smile and wait', '"Hakuna matata" is a way of life here', 'Never show anger or impatience', 'Delays and detours are normal', 'The journey matters more than the schedule']
        },
        {
            num: '06',
            title: 'Bargaining with Grace',
            desc: 'In local markets and with independent vendors, bargaining is expected and enjoyed. It is a social dance, not a confrontation. Approach it with humor, respect, and a willingness to walk away.',
            items: ['Start at 40-50% of the asking price', 'Smile — it\'s a conversation, not a battle', 'If you agree, you must buy', 'Don\'t haggle over small amounts', 'Fixed-price shops don\'t negotiate']
        }
    ];

    const taboos = [
        { label: 'Never use your left hand for greetings or eating', reason: 'It is considered unclean' },
        { label: 'Never point with your index finger', reason: 'Use your thumb or gesture with your chin' },
        { label: 'Never photograph people without permission', reason: 'It is deeply disrespectful and may be illegal' },
        { label: 'Never discuss politics or religion aggressively', reason: 'These are sensitive topics best approached gently' },
        { label: 'Never refuse food or drink offered by a host', reason: 'It is a grave insult; accept at least a sip or bite' },
        { label: 'Never display public affection beyond hand-holding', reason: 'Tanzania is culturally conservative' },
    ];

    return (
        <div className="field-root">

            {/* ═══ HERO ═══ */}
            <section className="field-hero">
                <div className="field-hero-img">
                    <img src={visuals.getSingle('safari.etiquetteHero', visualsData.about.hero)} alt="Tanzanian cultural interaction" />
                </div>
                <div className="field-hero-gradient" />
                <motion.div className="field-hero-content" initial="hidden" animate="visible" variants={fade}>
                    <span className="field-hero-eyebrow">Cultural Intelligence</span>
                    <h1 className="field-hero-title">Safari <em>Etiquette</em></h1>
                    <p className="field-hero-subtitle">
                        The best travelers are not tourists — they are guests. This is how you become one.
                    </p>
                </motion.div>
            </section>

            {/* ═══ CHAPTER 1 — TRAVEL LIKE A GUEST ═══ */}
            <div className="field-split">
                <div className="field-split-text">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-80px" }} variants={fade}>
                        <span className="field-chapter-num">01</span>
                        <span className="field-chapter-eyebrow">Philosophy</span>
                        <h2 className="field-chapter-title">Travel Like a <em>Guest</em></h2>
                        <p className="field-chapter-body">
                            When you enter someone's homeland, their customs, and their way of life, you carry the responsibility of respect. Tanzania is a country of extraordinary warmth and hospitality.
                        </p>
                        <p className="field-chapter-body">
                            The Swahili people welcome visitors with open arms, but that welcome is deepened when you demonstrate an understanding of their traditions, their values, and their rhythm of life.
                        </p>
                    </motion.div>
                </div>
                <motion.div className="field-split-img" initial={{ opacity: 0, scale: 1.05 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} transition={{ duration: 1.5 }}>
                    <img src={visuals.getSingle('safari.etiquetteEditorial', visualsData.zanzibar.regionStoneTown)} alt="Zanzibar Stone Town culture" />
                </motion.div>
            </div>

            {/* ═══ PULL QUOTE ═══ */}
            <motion.section className="field-pullquote" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} viewport={{ once: true }} transition={{ duration: 1.2 }}>
                <p className="field-pullquote-text">
                    "A proper greeting is the foundation of every meaningful interaction in Tanzania."
                </p>
                <span className="field-pullquote-attr">Swahili Proverb</span>
            </motion.section>

            {/* ═══ THE FIELD MANUAL — ALL GUIDELINES ═══ */}
            <section className="field-chapter">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade}>
                    <span className="field-chapter-num">02</span>
                    <span className="field-chapter-eyebrow">The Field Manual</span>
                    <h2 className="field-chapter-title">Six Rules for the <em>Road</em></h2>
                    <p className="field-chapter-body">
                        These guidelines will transform you from a visitor into a welcomed guest — the kind of traveler locals remember fondly.
                    </p>
                </motion.div>
            </section>

            <section className="field-details-section" style={{ paddingTop: 0 }}>
                {guidelines.map((item, i) => (
                    <motion.div className="field-detail-row" key={i} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade} transition={{ delay: i * 0.06 }}>
                        <span className="field-detail-num">{item.num}</span>
                        <div>
                            <h3 className="field-detail-title">{item.title}</h3>
                            <p className="field-detail-desc">{item.desc}</p>
                            <ul className="field-detail-items">
                                {item.items.map((detail, j) => <li key={j}>{detail}</li>)}
                            </ul>
                        </div>
                    </motion.div>
                ))}
            </section>

            {/* ═══ FULL BLEED ═══ */}
            <section className="field-bleed">
                <img src={visuals.getSingle('safari.etiquetteFullBleed', visualsData.safaris.migrationHero)} alt="Tanzanian landscape" />
                <span className="field-bleed-caption">The Serengeti, Tanzania</span>
            </section>

            {/* ═══ CULTURAL TABOOS ═══ */}
            <section className="field-chapter">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade}>
                    <span className="field-chapter-num">03</span>
                    <span className="field-chapter-eyebrow">Know the Boundaries</span>
                    <h2 className="field-chapter-title">Cultural <em>Taboos</em></h2>
                    <p className="field-chapter-body">
                        Avoiding these behaviors will prevent unintentional offense and demonstrate your respect for Tanzanian culture.
                    </p>
                </motion.div>
            </section>

            <section className="field-details-section" style={{ paddingTop: 0 }}>
                <div className="field-warnings">
                    {taboos.map((taboo, i) => (
                        <motion.div className="field-warning-row" key={i} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade} transition={{ delay: i * 0.06 }}>
                            <div className="field-warning-label">{taboo.label}</div>
                            <div className="field-warning-reason">{taboo.reason}</div>
                        </motion.div>
                    ))}
                </div>
            </section>

            {/* ═══ CTA ═══ */}
            <section className="field-cta">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade}>
                    <h2 className="field-cta-title">Ready for Your <em>Adventure?</em></h2>
                    <p className="field-cta-body">
                        With cultural awareness and proper preparation, your Tanzanian safari will be the most transformative travel experience of your life.
                    </p>
                    <Link to="/contact" className="field-btn">
                        Plan Your Safari
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" /></svg>
                    </Link>
                </motion.div>
            </section>
        </div>
    );
};

export default SafariEtiquette;
