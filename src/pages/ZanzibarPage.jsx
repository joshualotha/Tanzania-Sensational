import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import '../styles/zanzibar-premium.css';

const regions = [
    {
        name: "Stone Town.",
        tag: "THE ANCIENT HEART",
        desc: "Lose yourself in the labyrinthine alleys. Discover a rich tapestry of Swahili, Arab, Persian, and Indian influences reflected in intricately carved wooden doors and vibrant spice bazaars.",
        img: "https://images.unsplash.com/photo-1590089855523-a55d49646b97?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80",
        reverse: false
    },
    {
        name: "Nungwi Shores.",
        tag: "THE PRISTINE NORTH",
        desc: "Experience the quintessential tropical paradise. Powdery white beaches, tide-independent swimming, and the most spectacular, unobstructed Indian Ocean sunsets.",
        img: "https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80",
        reverse: true
    },
    {
        name: "Paje & Jambiani.",
        tag: "THE BREEZY COAST",
        desc: "A stretched-out coastline where the rhythm of tides commands the day. Famous world-wide for kite surfing, this laid-back region offers authentic encounters with a local coastal lifestyle.",
        img: "https://images.unsplash.com/photo-1595304604924-f7a9af316fa7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80",
        reverse: false
    }
];

const experiences = [
    {
        title: "The Spice Masterclass",
        desc: "Awaken your senses on a private walking tour. Discover the origins of cloves, nutmeg, cinnamon, and pepper.",
        img: "https://images.unsplash.com/photo-1596649811094-1a221f573af4?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80",
        price: "$45 pp"
    },
    {
        title: "Safari Blue Sailing",
        desc: "Board a bespoke mahogany dhow to the Menai Bay area. Snorkel, dine on a seafood BBQ, and relax on vanished sandbanks.",
        img: "https://images.unsplash.com/photo-1509515091-e40798cd317d?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80",
        price: "$120 pp"
    },
    {
        title: "Prison Island Retreat",
        desc: "Take a short boat ride to Changuu Island. Mingle with giant Aldabra tortoises and snorkel the spectacular coral fringes.",
        img: "https://images.unsplash.com/photo-1527715694-82ea466ae78a?ixlib=rb-4.0.3&auto=format&fit=crop&h=800&q=80",
        price: "$60 pp"
    }
];

export const ZanzibarPage = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeUp = {
        hidden: { opacity: 0, y: 50 },
        visible: { opacity: 1, y: 0, transition: { duration: 1, ease: [0.16, 1, 0.3, 1] } }
    };

    return (
        <div className="zan-midnight-root">

            {/* ─── 1. CINEMATIC HERO (Matched to Safaris) ─── */}
            <section className="zan-m-hero">
                <div className="zan-m-hero-bg">
                    <img src="https://images.unsplash.com/photo-1548502395-50e599bdf993?ixlib=rb-4.0.3&auto=format&fit=crop&w=2400&q=80" alt="Zanzibar Ocean" />
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
                    <motion.span className="zan-m-eyebrow" variants={fadeUp}>— The Tropical Extension —</motion.span>
                    <motion.h1 className="zan-m-hero-title zan-m-title" variants={fadeUp}>
                        Zanzibar <em>Archipelago</em>.
                    </motion.h1>
                    <motion.p className="zan-m-hero-desc zan-m-text" variants={fadeUp}>
                        Trade the mountain air for the Indian Ocean breeze. Discover pristine coral reefs, ancient coastal history, and ultra-high-end island luxury.
                    </motion.p>
                    <motion.div className="zan-m-hero-line" variants={fadeUp}></motion.div>
                </motion.div>
            </section>


            {/* ─── 2. ALTERNATING CINEMATIC PANELS ─── */}
            <section className="zan-m-section">
                <div className="zan-m-section-header">
                    <span className="zan-m-eyebrow">The Regions</span>
                    <h2 className="zan-m-section-title zan-m-title">Corners of the Spice Island.</h2>
                </div>

                <div className="zan-m-panel-list">
                    {regions.map((region, i) => (
                        <div key={i} className={`zan-m-panel ${region.reverse ? 'reverse' : ''}`}>
                            <motion.div
                                className="zan-m-panel-img-wrap"
                                initial={{ opacity: 0, scale: 0.95 }}
                                whileInView={{ opacity: 1, scale: 1 }}
                                transition={{ duration: 1.2, ease: [0.16, 1, 0.3, 1] }}
                                viewport={{ once: true, margin: "-100px" }}
                            >
                                <img src={region.img} alt={region.name} />
                                <div className="zan-m-panel-img-scrim"></div>
                            </motion.div>

                            <motion.div
                                className="zan-m-panel-content"
                                initial={{ opacity: 0, y: 50 }}
                                whileInView={{ opacity: 1, y: "-50%" }} /* maintain perfect center offset */
                                transition={{ duration: 1, delay: 0.3, ease: "easeOut" }}
                                viewport={{ once: true, margin: "-100px" }}
                            >
                                <span className="zan-m-eyebrow">{region.tag}</span>
                                <h3 className="zan-m-panel-title zan-m-title">{region.name}</h3>
                                <p className="zan-m-text mb-4">{region.desc}</p>
                                <Link to="/contact" className="zan-m-btn-outline">Explore Region</Link>
                            </motion.div>
                        </div>
                    ))}
                </div>
            </section>


            {/* ─── 3. PORTRAIT OVERLAY CARDS ─── */}
            <section className="zan-m-section">
                <div className="zan-m-section-header">
                    <span className="zan-m-eyebrow">Curated Moments</span>
                    <h2 className="zan-m-section-title zan-m-title">Exclusive Island Escapes.</h2>
                </div>

                <div className="zan-m-cards-grid">
                    {experiences.map((exp, i) => (
                        <motion.div
                            key={i}
                            className="zan-m-card"
                            initial={{ opacity: 0, y: 60 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            transition={{ duration: 0.8, delay: i * 0.15, ease: "easeOut" }}
                            viewport={{ once: true, margin: "-50px" }}
                        >
                            <div className="zan-m-card-img">
                                <img src={exp.img} alt={exp.title} />
                            </div>
                            <div className="zan-m-card-grad"></div>

                            <div className="zan-m-card-content">
                                <h3 className="zan-m-card-title zan-m-title">{exp.title}</h3>
                                <p className="zan-m-card-desc zan-m-text">{exp.desc}</p>

                                <div className="zan-m-card-footer">
                                    <span className="zan-m-card-price zan-m-text">{exp.price}</span>
                                    <Link to="/contact" className="zan-m-eyebrow mb-0 text-[#EAE5DB]">Enquire ➝</Link>
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
