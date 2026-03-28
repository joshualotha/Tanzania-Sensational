import React, { useEffect, useRef } from 'react';
import { motion, useScroll, useTransform } from 'framer-motion';
import { Link } from 'react-router-dom';
import { ArrowRight } from 'lucide-react';
import { visualsData } from '../data/visualsData';
import { useVisuals } from '../context/VisualsContext';
import '../styles/zanzibar-premium.css';

export const ZanzibarPage = () => {
    const visuals = useVisuals();
    const containerRef = useRef(null);

    useEffect(() => { window.scrollTo(0, 0); }, []);

    const { scrollYProgress } = useScroll({
        target: containerRef,
        offset: ["start start", "end start"]
    });
    const heroY = useTransform(scrollYProgress, [0, 1], [0, 200]);

    const fadeInUp = {
        hidden: { opacity: 0, y: 40 },
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
            transition: { staggerChildren: 0.15, delayChildren: 0.1 }
        }
    };

    const regions = [
        {
            name: 'Stone Town',
            tag: 'UNESCO Heritage',
            desc: 'A labyrinth of coral-rag alleys, carved wooden doors, and a history layered with sultans, spice traders, and Swahili poets.',
            img: visualsData.zanzibar.regionStoneTown
        },
        {
            name: 'Nungwi & Kendwa',
            tag: 'Northern Coast',
            desc: 'Powder-white sand meeting the Indian Ocean in shades of impossible turquoise. Legendary sunsets and dhow-building villages.',
            img: visualsData.zanzibar.regionNungwi
        },
        {
            name: 'Paje & Jambiani',
            tag: 'Eastern Shore',
            desc: 'Kite-surfing paradise by day, bioluminescent shores by night. Seaweed farms paint the low-tide flats in geometric beauty.',
            img: visualsData.zanzibar.regionPaje
        }
    ];

    const experiences = [
        {
            name: 'Safari Blue Voyage',
            tag: 'Signature Dispatch',
            desc: 'A bespoke mahogany dhow to the Menai Bay area. Snorkel pristine reefs, dine on a sandbank seafood BBQ, and relax in absolute seclusion.',
            img: visualsData.zanzibar.expSafariBlue
        },
        {
            name: 'Spice Plantation Tour',
            tag: 'Cultural Immersion',
            desc: 'Walk through the aromatic groves that gave Zanzibar its name. Clove, cinnamon, vanilla, and cardamom — harvested and tasted fresh from the source.',
            img: visualsData.zanzibar.expSpice
        },
        {
            name: 'Prison Island',
            tag: 'Historical Excursion',
            desc: 'A short boat ride reveals giant Aldabra tortoises, coral gardens, and the haunting remains of a 19th-century detention chamber turned sanctuary.',
            img: visualsData.zanzibar.expPrisonIsland
        }
    ];

    return (
        <div ref={containerRef} className="zan-root">

            {/* ─── 1. CINEMATIC HERO ─── */}
            <section className="zan-hero">
                <motion.div className="zan-hero-bg" style={{ y: heroY }}>
                    <img
                        src={visuals.getSingle('zanzibar.hero', visualsData.zanzibar.hero)}
                        alt="Zanzibar Coastline"
                    />
                    <div className="zan-hero-overlay"></div>
                </motion.div>

                <div className="zan-hero-content">
                    <motion.div
                        initial="hidden"
                        animate="visible"
                        variants={staggerContainer}
                    >
                        <motion.span className="zan-eyebrow" variants={fadeInUp}>The Spice Archipelago</motion.span>
                        <motion.h1 className="zan-hero-title" variants={fadeInUp}>Zanzibar<em>.</em></motion.h1>
                        <motion.p className="zan-hero-subtitle" variants={fadeInUp}>
                            Where ancient stone meets endless turquoise. An island woven from coral, clove, and centuries of untold stories.
                        </motion.p>
                    </motion.div>
                </div>

                <motion.div
                    className="zan-stats-strip"
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ delay: 0.8, duration: 0.8 }}
                >
                    <div className="zan-stats-grid">
                        <div className="zan-stat-item">
                            <span className="zan-stat-num">26<span>+</span></span>
                            <span className="zan-stat-label">Pristine Beaches</span>
                        </div>
                        <div className="zan-stat-item">
                            <span className="zan-stat-num">4</span>
                            <span className="zan-stat-label">Distinct Regions</span>
                        </div>
                        <div className="zan-stat-item">
                            <span className="zan-stat-num">600<span>+</span></span>
                            <span className="zan-stat-label">Years of History</span>
                        </div>
                        <div className="zan-stat-item">
                            <span className="zan-stat-num">28<span>°</span></span>
                            <span className="zan-stat-label">Year-Round Warmth</span>
                        </div>
                    </div>
                </motion.div>
            </section>


            {/* ─── 2. EDITORIAL NARRATIVE (STONE TOWN) ─── */}
            <section className="zan-editorial">
                <div className="zan-editorial-grid">
                    <motion.div
                        className="zan-editorial-text"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: "-100px" }}
                        variants={staggerContainer}
                    >
                        <motion.span className="zan-eyebrow" variants={fadeInUp}>The Ancient Heart</motion.span>
                        <motion.h2 className="zan-section-title" variants={fadeInUp}>
                            Where History <em>Breathes.</em>
                        </motion.h2>
                        <motion.p className="zan-body" variants={fadeInUp}>
                            In the labyrinth of Stone Town, time is not a line — it is a scent of cloves and aging coral rag. Every carved doorway tells a dynasty's story. Every narrow alley opens to a courtyard where Swahili, Arabic, Indian, and European influences have fused into something entirely its own.
                        </motion.p>
                        <motion.p className="zan-body" variants={fadeInUp}>
                            UNESCO recognized this living museum as a World Heritage Site, but no designation can capture the feeling of watching a crimson sunset from the Forodhani Gardens while the aroma of grilled octopus and urojo rises from the night market below.
                        </motion.p>
                    </motion.div>

                    <motion.div
                        className="zan-editorial-img"
                        initial={{ opacity: 0, scale: 0.95 }}
                        whileInView={{ opacity: 1, scale: 1 }}
                        viewport={{ once: true }}
                        transition={{ duration: 1.5, ease: "easeOut" }}
                    >
                        <img src={visualsData.zanzibar.regionStoneTown} alt="Stone Town Alleyway" />
                    </motion.div>
                </div>
            </section>


            {/* ─── 3. REGIONAL MOSAIC GRID ─── */}
            <section className="zan-regions">
                <div className="zan-regions-header">
                    <span className="zan-eyebrow" style={{ color: 'var(--gold)' }}>Explore the Island</span>
                    <h2 className="zan-section-title" style={{ marginTop: '20px' }}>
                        Three Worlds, One <em>Island.</em>
                    </h2>
                </div>

                <motion.div
                    className="zan-regions-grid"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: "-100px" }}
                    variants={staggerContainer}
                >
                    {regions.map((region, i) => (
                        <motion.div key={i} className="zan-region-card" variants={fadeInUp}>
                            <div className="zan-region-img">
                                <img src={region.img} alt={region.name} />
                            </div>
                            <span className="zan-region-tag">{region.tag}</span>
                            <h3 className="zan-region-name">{region.name}</h3>
                            <p className="zan-region-desc">{region.desc}</p>
                            <Link to="/contact" className="zan-region-link">
                                <span>Detailed Dossier</span>
                                <ArrowRight size={14} />
                            </Link>
                        </motion.div>
                    ))}
                </motion.div>
            </section>


            {/* ─── 4. FULL-BLEED PARALLAX BREAK ─── */}
            <section className="zan-parallax">
                <img src={visualsData.zanzibar.regionNungwi} alt="Nungwi Beach" />
                <div className="zan-parallax-overlay"></div>
                <motion.div
                    className="zan-parallax-label"
                    initial={{ opacity: 0, letterSpacing: '0em' }}
                    whileInView={{ opacity: 1, letterSpacing: '0.6em' }}
                    transition={{ duration: 2.5 }}
                    viewport={{ once: true }}
                >
                    PRISTINE SILENCE
                </motion.div>
            </section>


            {/* ─── 5. SIGNATURE EXPERIENCES ─── */}
            <section className="zan-experiences">
                <div className="zan-experiences-header">
                    <span className="zan-eyebrow" style={{ color: 'var(--gold)' }}>Curated Moments</span>
                    <h2 className="zan-section-title" style={{ marginTop: '20px' }}>
                        The Island <em>Experience.</em>
                    </h2>
                </div>

                <motion.div
                    className="zan-exp-grid"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: "-100px" }}
                    variants={staggerContainer}
                >
                    {experiences.map((exp, i) => (
                        <motion.div key={i} className="zan-exp-card" variants={fadeInUp}>
                            <div className="zan-exp-img">
                                <img src={exp.img} alt={exp.name} />
                            </div>
                            <div className="zan-exp-content">
                                <span className="zan-eyebrow">{exp.tag}</span>
                                <h3 className="zan-exp-title">{exp.name}</h3>
                                <p className="zan-exp-desc">{exp.desc}</p>
                                <Link to="/contact" className="zan-exp-cta">
                                    <span>Inquire</span>
                                    <ArrowRight size={14} />
                                </Link>
                            </div>
                        </motion.div>
                    ))}
                </motion.div>
            </section>


            {/* ─── 6. TESTIMONIAL BAND ─── */}
            <section className="zan-testimonial">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true }}
                    variants={fadeInUp}
                >
                    <span className="zan-eyebrow">The Legacy</span>
                    <p className="zan-testimonial-quote">
                        "We came for the beaches. We stayed for the culture. And we left knowing that Zanzibar had fundamentally changed the way we see the world."
                    </p>
                    <div className="zan-testimonial-author">Maria & David R. • Milan, Italy</div>
                </motion.div>
            </section>


            {/* ─── 7. CTA FOOTER BAND ─── */}
            <section className="zan-cta-band">
                <div className="zan-cta-bg">
                    <img src={visualsData.zanzibar.regionPaje} alt="Paje Beach" />
                    <div className="zan-cta-overlay"></div>
                </div>

                <motion.div
                    className="zan-cta-content"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true }}
                    variants={staggerContainer}
                >
                    <motion.span className="zan-eyebrow" variants={fadeInUp} style={{ color: 'rgba(255,255,255,0.7)' }}>Your Island Awaits</motion.span>
                    <motion.h2 className="zan-cta-title" variants={fadeInUp}>
                        Begin Your Island <em>Chapter.</em>
                    </motion.h2>
                    <motion.p className="zan-cta-subtitle" variants={fadeInUp}>
                        Whether as the perfect finale to a Kilimanjaro summit or a standalone retreat, our Zanzibar extensions are crafted around your rhythm.
                    </motion.p>
                    <motion.div className="zan-btn-group" variants={fadeInUp}>
                        <Link to="/contact" className="zan-btn-primary">
                            <span>Commission Your Stay</span>
                            <ArrowRight size={16} />
                        </Link>
                        <Link to="/safaris" className="zan-btn-outline">
                            <span>Explore Safari Pairings</span>
                            <ArrowRight size={16} />
                        </Link>
                    </motion.div>
                </motion.div>
            </section>

        </div>
    );
};
