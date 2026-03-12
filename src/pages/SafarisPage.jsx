import React, { useEffect, useRef, useState } from 'react';
import { motion, useScroll, useTransform, useInView } from 'framer-motion';
import { Link } from 'react-router-dom';
import { ArrowRight, Mountain, Trees, Waves, Map, Star, Shield, Sun } from 'lucide-react';
import '../styles/safari-premium.css';

import { destinationsData as destinations } from '../data/destinationsData';

const PremiumCountUp = ({ to, prefix = "", suffix = "", duration = 2 }) => {
    const ref = useRef(null);
    const isInView = useInView(ref, { once: true, margin: "-50px" });
    const [count, setCount] = useState(0);

    useEffect(() => {
        if (isInView) {
            let start = 0;
            const end = parseInt(to.replace(/,/g, ''));
            if (start === end) return;

            let totalMilisecDur = duration * 1000;
            let incrementTime = (totalMilisecDur / end);

            let timer = setInterval(() => {
                start += 1;
                setCount(start);
                if (start >= end) {
                    setCount(end);
                    clearInterval(timer);
                }
            }, Math.max(incrementTime, 1));

            return () => clearInterval(timer);
        }
    }, [isInView, to, duration]);

    const formatNumber = (num) => {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };

    return (
        <span ref={ref}>
            {prefix}{formatNumber(count)}<span>{suffix}</span>
        </span>
    );
};

const reviews = [
    { name: "Sarah & James W.", location: "London, UK", text: "A truly life-altering exhibition of nature. Watching the Serengeti sunrise from our balloon, followed by a champagne breakfast seamlessly prepared in the bush, felt like a dream." },
    { name: "Michael C.", location: "Toronto, Canada", text: "The attention to absolute detail was extraordinary. Every lodge selection, every guide's intuition, every moment felt flawlessly curated. The quintessential luxury expedition." },
    { name: "The Schmidt Family", location: "Munich, Germany", text: "Our private family safari eclipsed every expectation. We felt remarkably safe, entirely pampered, and witnessed wildlife spectacles we will recount for generations." }
];

export const SafarisPage = () => {
    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const { scrollYProgress } = useScroll();
    const heroY = useTransform(scrollYProgress, [0, 0.3], [0, 150]);

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

    return (
        <div className="safari-premium-root">

            {/* ─── 1. CINEMATIC HERO (ABOUT STYLE) ─── */}
            <section className="premium-safari-hero">
                <motion.div className="premium-safari-bg" style={{ y: heroY }}>
                    <img
                        src="https://images.unsplash.com/photo-1516426122078-c23e76319801?w=2000&q=85&auto=format&fit=crop"
                        alt="African Wilderness at Dawn"
                    />
                    <div className="premium-safari-overlay"></div>
                </motion.div>

                <div className="container">
                    <motion.div
                        className="premium-safari-hero-content"
                        initial="hidden"
                        animate="visible"
                        variants={staggerContainer}
                    >
                        <motion.span className="premium-eyebrow" variants={fadeInUp}>The Expedition Collective</motion.span>
                        <motion.h1 className="premium-hero-title" variants={fadeInUp}>Into the <em>Untamed.</em></motion.h1>
                        <motion.p className="premium-hero-subtitle" variants={fadeInUp}>
                            Architecting bespoke, uncompromising wilderness journeys across East Africa's most legendary landscapes.
                        </motion.p>
                    </motion.div>
                </div>

                {/* Floating Stats Strip */}
                <motion.div
                    className="premium-stats-strip"
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ delay: 0.6, duration: 0.8 }}
                >
                    <div className="premium-stats-grid">
                        <div className="premium-stat-item">
                            <span className="premium-stat-num"><PremiumCountUp to="8" /></span>
                            <span className="premium-stat-label">National Parks</span>
                        </div>
                        <div className="premium-stat-item">
                            <span className="premium-stat-num"><PremiumCountUp to="120" suffix="+" /></span>
                            <span className="premium-stat-label">Guided Expeditions</span>
                        </div>
                        <div className="premium-stat-item">
                            <span className="premium-stat-num"><PremiumCountUp to="12" /></span>
                            <span className="premium-stat-label">Boutique Camps</span>
                        </div>
                        <div className="premium-stat-item">
                            <span className="premium-stat-num"><PremiumCountUp to="450" suffix="+" /></span>
                            <span className="premium-stat-label">Species Cataloged</span>
                        </div>
                    </div>
                </motion.div>
            </section>

            {/* ─── 2. DESTINATIONS MODULAR GRID ─── */}
            <section id="expeditions" className="premium-destinations-section">
                <motion.div 
                    className="premium-dest-grid"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: "-100px" }}
                    variants={staggerContainer}
                >
                    {destinations.map((dest, i) => (
                        <motion.div key={dest.id} variants={fadeInUp}>
                            <Link to={`/safaris/destinations/${dest.id}`} className="premium-dest-card">
                                <div className="premium-dest-img-wrap">
                                    <img src={dest.heroImg} alt={dest.name} />
                                </div>
                                <span className="premium-dest-tag">Expedition Focus: {dest.tag}</span>
                                <h3 className="premium-dest-name">{dest.name}</h3>
                                <p className="premium-dest-desc">{dest.shortDesc}</p>
                                <div className="premium-dest-link">
                                    <span>Detailed Dossier</span>
                                    <ArrowRight size={16} color="var(--gold)" />
                                </div>
                            </Link>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ─── 4. REVIEWS BAND ─── */}
            <section className="premium-reviews-band">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true }}
                    variants={fadeInUp}
                >
                    <span className="premium-eyebrow">The Legacy</span>
                    <p className="premium-review-quote">
                        "The attention to absolute detail was extraordinary. Every lodge selection, every guide's intuition, every moment felt flawlessly curated. The quintessential luxury expedition."
                    </p>
                    <div className="premium-dest-tag">Michael C. • Toronto, Canada</div>
                </motion.div>
            </section>

            {/* ─── 5. FINAL EXPERIENCE BAND ─── */}
            <section className="premium-exp-band">
                <div className="premium-exp-bg">
                    <img
                        src="https://images.unsplash.com/photo-1650668302197-7f556c34cb91?q=80&w=2000&auto=format&fit=crop"
                        alt="Kilimanjaro Trekking"
                    />
                    <div className="premium-exp-overlay"></div>
                </div>
                <div className="premium-exp-container">
                    <motion.div
                        className="premium-exp-left"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={staggerContainer}
                    >
                        <span className="premium-eyebrow" style={{ color: 'white' }}>The Difference</span>
                        <h2 className="premium-exp-title">Experience That <em>Speaks.</em></h2>
                        <motion.div variants={fadeInUp}>
                            <Link to="/contact" className="premium-exp-cta">
                                <span>Initialize Your Journey</span>
                                <ArrowRight size={18} />
                            </Link>
                        </motion.div>
                    </motion.div>

                    <motion.div
                        className="premium-exp-list"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={staggerContainer}
                    >
                        <motion.div className="premium-exp-item" variants={fadeInUp}>
                            <span className="premium-exp-num">01</span>
                            <div>
                                <h4 className="premium-exp-item-title">Architected Itineraries</h4>
                                <p className="premium-exp-item-text">Every detail is painstakingly considered—from specialized wildlife mapping to high-altitude luxury cuisine. Nothing is left to chance.</p>
                            </div>
                        </motion.div>
                        <motion.div className="premium-exp-item" variants={fadeInUp}>
                            <span className="premium-exp-num">02</span>
                            <div>
                                <h4 className="premium-exp-item-title">Locally Born Mastery</h4>
                                <p className="premium-exp-item-text">Our architects were raised in the heart of the savanna. We don't just guide on the mountain—we live it, breathe it, and protect it.</p>
                            </div>
                        </motion.div>
                    </motion.div>
                </div>
            </section>

        </div>
    );
};
