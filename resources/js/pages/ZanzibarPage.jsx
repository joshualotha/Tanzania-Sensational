import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { ArrowRight, Waves, Sun, History, Compass } from 'lucide-react';
import { visualsData } from '../data/visualsData';
import { useVisuals } from '../context/VisualsContext';
import '../styles/zanzibar-premium.css';

const regions = [
    {
        name: "Stone Town.",
        tag: "THE ANCIENT HEART",
        desc: "Lose yourself in the labyrinthine alleys of a UNESCO masterpiece. Discover a rich tapestry of Swahili, Arab, Persian, and Indian influences reflected in intricately carved wooden doors and vibrant spice bazaars.",
        img: visualsData.zanzibar.regionStoneTown,
        reverse: false
    },
    {
        name: "Nungwi Shores.",
        tag: "THE PRISTINE NORTH",
        desc: "Experience the quintessential tropical paradise. Powdery white beaches, tide-independent swimming, and the most spectacular, unobstructed Indian Ocean sunsets from bespoke northern retreats.",
        img: visualsData.zanzibar.regionNungwi,
        reverse: true
    },
    {
        name: "Paje & Jambiani.",
        tag: "THE BREEZY COAST",
        desc: "A stretched-out coastline where the rhythm of tides commands the day. Famous world-wide for kite surfing and rhythmic solitude, this laid-back region offers authentic encounters with a local coastal lifestyle.",
        img: visualsData.zanzibar.regionPaje,
        reverse: false
    }
];

const experiences = [
    {
        title: "The Spice Masterclass",
        desc: "Awaken your senses on a private walking tour. Discover the origins of cloves, nutmeg, cinnamon, and pepper in the island's secret plantations.",
        img: visualsData.zanzibar.expSpice,
        price: "From $45"
    },
    {
        title: "Safari Blue Sailing",
        desc: "Board a bespoke mahogany dhow to the Menai Bay area. Snorkel, dine on a sandbank seafood BBQ, and relax in absolute seclusion.",
        img: visualsData.zanzibar.expSafariBlue,
        price: "From $120"
    },
    {
        title: "Prison Island Retreat",
        desc: "Take a short boat ride to Changuu Island. Mingle with centuries-old Aldabra tortoises and snorkel the spectacular coral fringes.",
        img: visualsData.zanzibar.expPrisonIsland,
        price: "From $60"
    }
];

export const ZanzibarPage = () => {
    const visuals = useVisuals();
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeUp = {
        hidden: { opacity: 0, y: 50 },
        visible: { opacity: 1, y: 0, transition: { duration: 1, ease: [0.16, 1, 0.3, 1] } }
    };

    return (
        <div className="zan-light-root">

            {/* ─── 1. AIRY COASTAL HERO ─── */}
            <section className="zan-m-hero">
                <div className="zan-m-hero-bg">
                    <img src={visuals.getSingle('zanzibar.hero', visualsData.zanzibar.hero)} alt="Zanzibar Ocean" />
                    <div className="zan-m-hero-scrim"></div>
                </div>

                <motion.div
                    className="zan-m-hero-content"
                    initial="hidden"
                    animate="visible"
                    variants={{
                        hidden: { opacity: 0 },
                        visible: { opacity: 1, transition: { staggerChildren: 0.2, delayChildren: 0.3 } }
                    }}
                >
                    <motion.span className="zan-m-eyebrow" variants={fadeUp}>The Turquoise Extension</motion.span>
                    <motion.h1 className="zan-m-hero-title zan-m-title" variants={fadeUp}>
                        Zanzibar <em>Archipelago.</em>
                    </motion.h1>
                    <motion.p className="zan-m-hero-desc zan-m-text" variants={fadeUp}>
                        Trade the mountain air for the Indian Ocean breeze. Discover pristine coral reefs, ancient coastal history, and ultra-high-end island luxury.
                    </motion.p>
                    <motion.div className="zan-m-hero-line" variants={fadeUp}></motion.div>
                </motion.div>
            </section>


            {/* ─── 2. MAGAZINE SPREAD PANELS (REGIONS) ─── */}
            <section className="zan-m-section">
                <div className="zan-m-section-header">
                    <span className="zan-m-eyebrow">Island Geography</span>
                    <h2 className="zan-m-section-title zan-m-title">Corners of the Spice Island.</h2>
                </div>

                <div className="zan-m-panel-list">
                    {regions.map((region, i) => (
                        <div key={i} className={`zan-m-panel ${region.reverse ? 'reverse' : ''}`}>
                            <motion.div
                                className="zan-m-panel-img-wrap"
                                initial={{ opacity: 0, x: region.reverse ? 50 : -50 }}
                                whileInView={{ opacity: 1, x: 0 }}
                                transition={{ duration: 1.2, ease: [0.16, 1, 0.3, 1] }}
                                viewport={{ once: true, margin: "-100px" }}
                            >
                                <img src={region.img} alt={region.name} />
                            </motion.div>

                            <motion.div
                                className="zan-m-panel-content"
                                initial={{ opacity: 0, scale: 0.95 }}
                                whileInView={{ opacity: 1, scale: 1 }}
                                transition={{ duration: 0.8, delay: 0.2, ease: "easeOut" }}
                                viewport={{ once: true, margin: "-100px" }}
                            >
                                <span className="zan-m-eyebrow">{region.tag}</span>
                                <h3 className="zan-m-panel-title zan-m-title">{region.name}</h3>
                                <p className="zan-m-text mb-8">{region.desc}</p>
                                <Link to="/contact" className="zan-m-btn-outline">
                                    Explore Territory <ArrowRight size={14} className="ml-2 inline" />
                                </Link>
                            </motion.div>
                        </div>
                    ))}
                </div>
            </section>


            {/* ─── 3. BOUTIQUE STATIONERY CARDS (EXPERIENCES) ─── */}
            <section className="zan-m-section" style={{ background: '#f9f6f1' }}>
                <div className="zan-m-section-header">
                    <span className="zan-m-eyebrow">Curated Moments</span>
                    <h2 className="zan-m-section-title zan-m-title">Exclusive Island Escapes.</h2>
                </div>

                <div className="zan-m-cards-grid">
                    {experiences.map((exp, i) => (
                        <motion.div
                            key={i}
                            className="zan-m-card"
                            initial={{ opacity: 0, y: 40 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.8, delay: i * 0.15, ease: "easeOut" }}
                            viewport={{ once: true, margin: "-50px" }}
                        >
                            <div className="zan-m-card-img">
                                <img src={exp.img} alt={exp.title} />
                            </div>

                            <div className="zan-m-card-content">
                                <h3 className="zan-m-card-title zan-m-title">{exp.title}</h3>
                                <p className="zan-m-card-desc zan-m-text">{exp.desc}</p>

                                <div className="zan-m-card-footer">
                                    <span className="zan-m-card-price">{exp.price}</span>
                                    <Link to="/contact" className="zan-m-eyebrow mb-0">Enquire ➝</Link>
                                </div>
                            </div>
                        </motion.div>
                    ))}
                </div>

                <div className="zan-m-cta-group">
                    <Link to="/safaris" className="zan-m-btn-outline">View Safari Pairings</Link>
                    <Link to="/contact" className="zan-m-btn-solid">Commission Custom Trip</Link>
                </div>
            </section>

        </div>
    );
};
