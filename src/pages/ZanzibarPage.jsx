import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import '../styles/zanzibar-premium.css';

const regions = [
    {
        name: "Stone Town",
        tag: "WORLD HERITAGE",
        desc: "Lose yourself in the labyrinthine alleys of Stone Town. Discover a rich tapestry of Swahili, Arab, Persian, and Indian influences reflected in intricately carved wooden doors and vibrant bazaars.",
        img: "https://images.unsplash.com/photo-1590089855523-a55d49646b97?w=1600&q=85&auto=format&fit=crop",
        isLarge: true
    },
    {
        name: "Nungwi & Kendwa",
        tag: "THE PRISTINE NORTH",
        desc: "Experience the quintessential tropical paradise. The northern tip boasts powdery white beaches, tide-independent swimming, and the most spectacular ocean sunsets.",
        img: "https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?w=1200&q=85&auto=format&fit=crop",
        isLarge: false
    },
    {
        name: "Paje & Jambiani",
        tag: "THE BREEZY SOUTHEAST",
        desc: "A stretched-out coastline where the rhythm of tides commands the day. Famous for kite surfing, this laid-back region offers authentic encounters with local fishermen.",
        img: "https://plus.unsplash.com/premium_photo-1661963242691-030612dbf378?w=1200&q=85&auto=format&fit=crop",
        isLarge: false
    }
];

const experiences = [
    {
        title: "The Spice Tour",
        duration: "Half Day Expedition",
        desc: "Awaken your senses on a guided walking tour through lush spice farms. Discover the origins of cloves, nutmeg, cinnamon, and pepper that gave Zanzibar its legendary nickname.",
        price: "45",
        img: "https://images.unsplash.com/photo-1605333527581-fd1367069c9b?w=800&q=80&auto=format&fit=crop"
    },
    {
        title: "The Safari Blue",
        duration: "Full Day Sailing",
        desc: "Sail on a traditional mahogany dhow to the idyllic Menai Bay Conservation Area. Snorkel amidst brilliant marine life, feast on a seafood barbecue, and relax on vanished sandbanks.",
        price: "120",
        img: "https://images.unsplash.com/photo-1563177651-40348f06f52e?w=800&q=80&auto=format&fit=crop"
    },
    {
        title: "Prison Island Sanctuary",
        duration: "Half Day Escape",
        desc: "Take a short boat ride to Changuu Island. Mingle with the giant Aldabra tortoises—some over a century old—and snorkel the spectacular coral fringes surrounding the historic ruins.",
        price: "60",
        img: "https://images.unsplash.com/photo-1510414842594-a61c69b5ae57?w=800&q=80&auto=format&fit=crop"
    }
];

export const ZanzibarPage = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 50 },
        visible: { opacity: 1, y: 0, transition: { duration: 1, ease: [0.22, 1, 0.36, 1] } }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.15, delayChildren: 0.1 } }
    };

    return (
        <div className="zanzibar-custom-root">

            {/* ─── 1. ASYMMETRICAL EDITORIAL HERO ─── */}
            <section className="zan-asym-hero">
                <motion.div
                    className="zan-hero-text-col"
                    initial="hidden"
                    animate="visible"
                    variants={staggerContainer}
                >
                    <motion.span className="zan-eyebrow" variants={fadeInUp}>The Spice Island</motion.span>
                    <motion.h1 className="zan-hero-title" variants={fadeInUp}>Tropical<br /><em>Escape.</em></motion.h1>
                    <motion.p className="zan-hero-desc" variants={fadeInUp}>
                        Trade the mountain air for the Indian Ocean breeze. Discover pristine white sands, turquoise waters, and ancient Stone Town history.
                    </motion.p>
                    <motion.div className="zan-hero-actions" variants={fadeInUp}>
                        <a href="#regions" className="zan-btn-solid">Explore the Coast</a>
                        <Link to="/contact" className="zan-btn-text">Plan Island Retreat →</Link>
                    </motion.div>
                </motion.div>

                <motion.div
                    className="zan-hero-img-col"
                    initial={{ opacity: 0, x: 100 }}
                    animate={{ opacity: 1, x: 0 }}
                    transition={{ duration: 1.5, ease: [0.22, 1, 0.36, 1] }}
                >
                    <div className="zan-hero-img-wrap">
                        <img src="https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?w=1600&q=85&auto=format&fit=crop" alt="Zanzibar Coastline" />
                    </div>
                </motion.div>
            </section>

            {/* ─── 2. THE ARCHIPELAGO (MASONRY GRID) ─── */}
            <section id="regions" className="zan-regions-sec">
                <div className="zan-section-header">
                    <span className="zan-eyebrow">The Archipelago</span>
                    <h2 className="zan-section-title">Coastal <em>Regions.</em></h2>
                </div>

                <motion.div
                    className="zan-masonry"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: "-100px" }}
                    variants={staggerContainer}
                >
                    {regions.map((region, i) => (
                        <motion.div
                            key={i}
                            className={`zan-region-card ${region.isLarge ? 'zan-region-large' : 'zan-region-polaroid'}`}
                            variants={fadeInUp}
                        >
                            <div className="zan-region-img">
                                <img src={region.img} alt={region.name} />
                                <div className="zan-region-badge">{region.tag}</div>
                            </div>
                            <div className="zan-region-info">
                                <h3 className="zan-region-name">{region.name}</h3>
                                <p className="zan-region-desc">{region.desc}</p>
                            </div>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ─── 3. ISLAND EXPERIENCES (MINIMALIST LIST ROW) ─── */}
            <section className="zan-exp-sec">
                <div className="zan-section-header">
                    <span className="zan-eyebrow">Leisure & Expedition</span>
                    <h2 className="zan-section-title">Island <em>Experiences.</em></h2>
                </div>

                <div className="zan-exp-list">
                    {experiences.map((exp, i) => (
                        <motion.div
                            key={i}
                            className="zan-exp-row"
                            initial={{ opacity: 0, y: 30 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            viewport={{ once: true, margin: "-50px" }}
                            transition={{ duration: 0.8, delay: i * 0.1 }}
                        >
                            <div className="zan-exp-data">
                                <h3 className="zan-exp-title">{exp.title}</h3>
                                <p className="zan-exp-desc">{exp.desc}</p>
                            </div>

                            <div className="zan-exp-meta">
                                <span className="zan-exp-duration">{exp.duration}</span>
                                <span className="zan-exp-price">From ${exp.price}</span>
                                <Link to="/contact" className="zan-btn-text">Enquire →</Link>
                            </div>

                            <img src={exp.img} alt={exp.title} className="zan-exp-hover-img" />
                        </motion.div>
                    ))}
                </div>

                <div className="zan-footer-ctas">
                    <Link to="/safaris" className="zan-btn-text" style={{ borderBottomColor: 'var(--gold)', color: 'var(--gold)' }}>← Back to Safaris</Link>
                    <Link to="/contact" className="zan-btn-solid">Build Custom Retreat</Link>
                </div>
            </section>

        </div>
    );
};
