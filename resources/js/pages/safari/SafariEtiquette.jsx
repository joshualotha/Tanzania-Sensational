import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import { Heart, Users, Camera, Hand, Smile, Gift } from 'lucide-react';
import '../../styles/ultra-premium.css';

const SafariEtiquette = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);
    const visuals = useVisuals();

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const guidelines = [
        {
            icon: <Heart size={28} />,
            title: 'The Greeting Ritual',
            category: 'Daily Interaction',
            desc: 'In Tanzania, greetings are not a formality — they are a ritual of respect and human connection. Before any business, negotiation, or conversation begins, there is a proper exchange of pleasantries.',
            details: [
                'Always say "Jambo" (Hello) or "Habari" (How are you?) before anything else',
                'Ask about family, health, and work before discussing your needs',
                'Shake hands gently — a firm grip is considered aggressive',
                'Use "Asante sana" (Thank you very much) frequently and genuinely',
                'Never rush a greeting — it is seen as disrespectful and impatient'
            ]
        },
        {
            icon: <Camera size={28} />,
            title: 'Photography Etiquette',
            category: 'Respect & Consent',
            desc: 'Photography is a privilege, not a right. Always ask permission before photographing people, their homes, or their property. A smile and a gesture toward your camera is universally understood.',
            details: [
                'Always ask before photographing local people',
                'Offer to show them the photo on your screen — it builds connection',
                'Never photograph government buildings, military, or airports',
                'Tip guides and trackers when they help you get great shots',
                'Silence your camera shutter in sensitive wildlife situations'
            ]
        },
        {
            icon: <Users size={28} />,
            title: 'Dress with Modesty',
            category: 'Cultural Respect',
            desc: 'Tanzania is a conservative country with significant Muslim and Christian populations. Outside of beach resorts and safari lodges, modest dress is expected and respected.',
            details: [
                'Cover shoulders and knees when visiting villages or towns',
                'Swimwear is acceptable only at pools, beaches, or lodges',
                'Remove shoes when entering someone\'s home or a mosque',
                'Dress conservatively in Stone Town and Zanzibar',
                'Safari game drive attire can be casual — you\'re in the bush'
            ]
        },
        {
            icon: <Hand size={28} />,
            title: 'Tipping Culture',
            category: 'Generosity & Gratitude',
            desc: 'Tipping is not just appreciated — it is an essential part of the Tanzanian tourism economy. Your guides, drivers, cooks, and camp staff rely on tips for a significant portion of their income.',
            details: [
                'Safari Guide: $15-25 per guest per day',
                'Driver: $10-15 per guest per day',
                'Camp/Lodge Staff: $5-10 per guest per day (pooled)',
                'Restaurant: 10% if service charge not included',
                'Porters: $5-10 per bag at airports and hotels'
            ]
        },
        {
            icon: <Smile size={28} />,
            title: 'Patience & "Pole Pole"',
            category: 'Mindset',
            desc: '"Pole pole" (slowly, slowly) is the Tanzanian philosophy of life. Things move at their own pace, and frustration is counterproductive. Embrace the rhythm — it is part of the adventure.',
            details: [
                'Service may be slower than you\'re accustomed to — smile and wait',
                '"Hakuna matata" (No worries) is a way of life, not just a phrase',
                'Never show anger or impatience — it is deeply frowned upon',
                'Traffic, delays, and detours are normal — plan accordingly',
                'The journey matters more than the schedule'
            ]
        },
        {
            icon: <Gift size={28} />,
            title: 'Bargaining with Grace',
            category: 'Marketplace',
            desc: 'In local markets and with independent vendors, bargaining is expected and enjoyed. It is a social dance, not a confrontation. Approach it with humor, respect, and a willingness to walk away.',
            details: [
                'Start at 40-50% of the asking price',
                'Smile and be friendly — it\'s a conversation, not a battle',
                'If you agree on a price, you must buy — backing out is rude',
                'Don\'t bargain over a few hundred shillings — it\'s insulting',
                'Fixed-price shops and lodges do not negotiate — respect that'
            ]
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
        <div className="lux-root">
            {/* ─── HERO ─── */}
            <section className="lux-hero">
                <img
                    src={visuals.getSingle('safari.etiquetteHero', visualsData.about.hero)}
                    alt="Safari Etiquette"
                />
                <div className="lux-hero-overlay"></div>
                <div className="lux-hero-content">
                    <motion.span className="lux-hero-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Cultural Intelligence</motion.span>
                    <motion.h1 className="lux-hero-title" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.1 }}>
                        Safari <em>Etiquette.</em>
                    </motion.h1>
                </div>
            </section>

            {/* ─── EDITORIAL INTRO ─── */}
            <section className="lux-section">
                <div className="lux-editorial-grid">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-100px" }} variants={fadeInUp}>
                        <h2 className="lux-heading">Travel Like a <em>Guest.</em></h2>
                        <p className="lux-body">
                            The best travelers are not tourists — they are guests. When you enter someone's homeland, their customs, and their way of life, you carry the responsibility of respect.
                        </p>
                        <p className="lux-body">
                            Tanzania is a country of extraordinary warmth and hospitality. The Swahili people welcome visitors with open arms, but that welcome is deepened when you demonstrate an understanding of their traditions, their values, and their rhythm of life.
                        </p>
                        <p className="lux-body">
                            This guide covers the essential etiquette that will transform you from a visitor into a welcomed guest — the kind of traveler locals remember fondly and guides are proud to host.
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
                            src={visuals.getSingle('safari.etiquetteEditorial', visualsData.zanzibar.regionStoneTown)}
                            alt="Cultural Connection"
                        />
                        <div className="lux-image-caption">A proper greeting is the foundation of every meaningful interaction in Tanzania.</div>
                    </motion.div>
                </div>
            </section>

            {/* ─── GUIDELINES ─── */}
            <section className="lux-section lux-section-alt">
                <motion.h2 className="lux-heading" style={{ textAlign: 'center', marginBottom: '60px' }} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    The Field <em>Manual.</em>
                </motion.h2>
                <div className="lux-guideline-list">
                    {guidelines.map((item, i) => (
                        <motion.div
                            key={i}
                            className="lux-guideline-row"
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true }}
                            variants={fadeInUp}
                            transition={{ delay: i * 0.1 }}
                        >
                            <div className="lux-guideline-icon">{item.icon}</div>
                            <div>
                                <span className="lux-guideline-tag">{item.category}</span>
                                <h3 className="lux-guideline-title">{item.title}</h3>
                                <p className="lux-guideline-desc">{item.desc}</p>
                                <ul className="lux-guideline-details">
                                    {item.details.map((detail, j) => (
                                        <li key={j}>{detail}</li>
                                    ))}
                                </ul>
                            </div>
                        </motion.div>
                    ))}
                </div>
            </section>

            {/* ─── FULL BLEED PARALLAX ─── */}
            <section className="lux-full-bleed">
                <img
                    src={visuals.getSingle('safari.etiquetteFullBleed', visualsData.safaris.migrationHero)}
                    alt="Tanzanian Culture"
                />
            </section>

            {/* ─── CULTURAL TABOOS ─── */}
            <section className="lux-section">
                <motion.h2 className="lux-heading" style={{ textAlign: 'center', marginBottom: '50px' }} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    Cultural <em>Taboos.</em>
                </motion.h2>
                <p className="lux-body" style={{ textAlign: 'center', maxWidth: '700px', margin: '0 auto 40px' }}>
                    Avoiding these behaviors will prevent unintentional offense and demonstrate your respect for Tanzanian culture.
                </p>
                <div className="lux-taboo-list">
                    {taboos.map((taboo, i) => (
                        <motion.div
                            key={i}
                            className="lux-taboo-row"
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true }}
                            variants={fadeInUp}
                            transition={{ delay: i * 0.08 }}
                        >
                            <div className="lux-taboo-x">✕</div>
                            <div>
                                <span className="lux-taboo-label">{taboo.label}</span>
                                <span className="lux-taboo-reason">Because: {taboo.reason}</span>
                            </div>
                        </motion.div>
                    ))}
                </div>
            </section>

            {/* ─── CTA ─── */}
            <section className="lux-cta">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    <h2 className="lux-heading" style={{ marginBottom: '20px' }}>Ready for Your <em>Adventure?</em></h2>
                    <p className="lux-body" style={{ maxWidth: '600px', margin: '0 auto 30px' }}>
                        With cultural awareness and proper preparation, your Tanzanian safari will be the most transformative travel experience of your life.
                    </p>
                    <Link to="/contact" className="lux-btn" style={{ display: 'inline-flex', alignItems: 'center', gap: '10px' }}>
                        Plan Your Safari
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
                        </svg>
                    </Link>
                </motion.div>
            </section>
        </div>
    );
};

export default SafariEtiquette;
