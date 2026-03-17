import React, { useState, useEffect, useRef } from 'react';
import { Link } from 'react-router-dom';
import { motion, useInView, useScroll, useTransform } from 'framer-motion';
import { Mountain, Compass, Star, Shield, Heart, Globe, TreePine, ArrowRight } from 'lucide-react';
import { visualsData } from '../data/visualsData';
import { pageService } from '../services/api';
import { CmsSection } from '../components/cms/CmsSection';
import '../styles/about-premium.css';

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
            }, incrementTime);

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

export const AboutPage = () => {
    const [cms, setCms] = useState(null);

    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    useEffect(() => {
        let mounted = true;
        pageService.getBySlug('about')
            .then((res) => { if (mounted) setCms(res.data); })
            .catch(() => {});
        return () => { mounted = false; };
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

    if (cms?.content) {
        return (
            <main style={{ background: '#050505', color: 'white', minHeight: '100vh' }}>
                <section style={{ padding: '120px 20px 60px', maxWidth: 1100, margin: '0 auto' }}>
                    <h1 style={{ fontSize: '3rem', fontWeight: 300 }}>{cms.title || 'About'}</h1>
                    <div style={{ marginTop: 22 }}>
                        <CmsSection html={cms.content} />
                    </div>
                </section>
            </main>
        );
    }

    return (
        <div className="about-premium-root">

            {/* ─── 1. CINEMATIC HERO ─── */}
            <section className="premium-about-hero">
                <motion.div className="premium-about-bg" style={{ y: heroY }}>
                    <img
                        src={visualsData.about.hero}
                        alt="Kilimanjaro Summit at Dawn"
                    />
                    <div className="premium-about-overlay"></div>
                </motion.div>

                <div className="container">
                    <motion.div
                        className="premium-about-content"
                        initial="hidden"
                        animate="visible"
                        variants={staggerContainer}
                    >
                        <motion.span className="premium-eyebrow" variants={fadeInUp}>Our Origins</motion.span>
                        <motion.h1 className="premium-hero-title" variants={fadeInUp}>Born from the <em>Mountain.</em></motion.h1>
                        <motion.p className="premium-hero-subtitle" variants={fadeInUp}>
                            We didn't just start an expedition company. We inherited a calling—to share the incredible majesty of East Africa with the world.
                        </motion.p>
                    </motion.div>
                </div>

                {/* Integrated Stats Strip over the hero */}
                <motion.div
                    className="premium-stats-strip"
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ delay: 0.6, duration: 0.8 }}
                >
                    <div className="premium-stats-grid">
                        <div className="premium-stat-item">
                            <span className="premium-stat-num"><PremiumCountUp to="15" suffix="+" /></span>
                            <span className="premium-stat-label">Years of Mastery</span>
                        </div>
                        <div className="premium-stat-item">
                            <span className="premium-stat-num"><PremiumCountUp to="5000" suffix="+" /></span>
                            <span className="premium-stat-label">Summits Achieved</span>
                        </div>
                        <div className="premium-stat-item">
                            <span className="premium-stat-num"><PremiumCountUp to="98" suffix="%" /></span>
                            <span className="premium-stat-label">Success Rate</span>
                        </div>
                        <div className="premium-stat-item">
                            <span className="premium-stat-num"><PremiumCountUp to="50" suffix="+" /></span>
                            <span className="premium-stat-label">Elite Guides</span>
                        </div>
                    </div>
                </motion.div>
            </section>

            {/* ─── 2. THE LEGACY CARD ─── */}
            <section className="premium-story-section">
                <motion.div
                    className="premium-story-card"
                    initial={{ opacity: 0, y: 40 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true, margin: "-100px" }}
                    transition={{ duration: 1, ease: [0.22, 1, 0.36, 1] }}
                >
                    <div className="premium-story-image">
                        <img
                            src={visualsData.about.legacy}
                            alt="Kilimanjaro Trail"
                        />
                        <div className="premium-story-badge">
                            <Mountain size={28} />
                            <span>Established 2010</span>
                        </div>
                    </div>
                    <div className="premium-story-content">
                        <span className="premium-eyebrow">The Beginning</span>
                        <h2 className="premium-story-title">From a single trail to a <em>Legacy.</em></h2>
                        <p className="premium-story-body">
                            Tanzania Sensational was born from a simple belief: that the mountains and savannas of East Africa deserve to be experienced at the absolute highest standard of excellence.
                        </p>
                        <p className="premium-story-body">
                            Our founder grew up in the shadow of Kilimanjaro. That deep, inherent respect for the mountain became the foundation of our entire operation. Today, we architect luxury expeditions across Kilimanjaro, Mount Meru, the Serengeti, and Zanzibar—always with one principle: excellence without compromise.
                        </p>
                    </div>
                </motion.div>
            </section>

            {/* ─── 3. MISSION & VISION TWINS ─── */}
            <section className="premium-mv-section">
                <div className="premium-mv-grid">
                    <motion.div
                        className="premium-mv-card"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: "-50px" }}
                        variants={fadeInUp}
                    >
                        <div className="premium-mv-inner">
                            <Compass size={40} className="premium-mv-icon" strokeWidth={1.5} />
                            <h3 className="premium-mv-title">The Mission</h3>
                            <p className="premium-mv-text">
                                To engineer transformative travel experiences that connect the world's most discerning adventurers with East Africa's greatest natural wonders—safely, sustainably, and unforgettably.
                            </p>
                        </div>
                    </motion.div>
                    <motion.div
                        className="premium-mv-card"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: "-50px" }}
                        variants={fadeInUp}
                    >
                        <div className="premium-mv-inner">
                            <Star size={40} className="premium-mv-icon" strokeWidth={1.5} />
                            <h3 className="premium-mv-title">The Vision</h3>
                            <p className="premium-mv-text">
                                To be universally recognized as the gold standard in bespoke expedition travel, continually setting incredible new benchmarks for uncompromising safety, service, and environmental stewardship.
                            </p>
                        </div>
                    </motion.div>
                </div>
            </section>

            {/* ─── 4. THE PRINCIPLES ─── */}
            <section className="premium-values-section">
                <div className="premium-values-container">
                    <motion.div
                        className="premium-values-head"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={staggerContainer}
                    >
                        <motion.span className="premium-eyebrow" variants={fadeInUp}>What Guides Us</motion.span>
                        <motion.h2 className="premium-values-title" variants={fadeInUp}>The Principles Behind Every <em>Expedition.</em></motion.h2>
                    </motion.div>

                    <motion.div
                        className="premium-values-grid"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: "-50px" }}
                        variants={staggerContainer}
                    >
                        <motion.div className="premium-value-card" variants={fadeInUp}>
                            <div className="premium-value-icon"><Shield size={24} /></div>
                            <h4 className="premium-value-title">Safety Ascendant</h4>
                            <p className="premium-value-desc">Every expedition is meticulously engineered with certified elite guides, cutting-edge equipment, and rapid-response protocols that exceed international standards.</p>
                        </motion.div>
                        <motion.div className="premium-value-card" variants={fadeInUp}>
                            <div className="premium-value-icon"><Heart size={24} /></div>
                            <h4 className="premium-value-title">Authentic Immersion</h4>
                            <p className="premium-value-desc">We go beyond the traditional tourist veil. Each journey is carefully crafted to create genuine, profound connections with Tanzania's landscapes and people.</p>
                        </motion.div>
                        <motion.div className="premium-value-card" variants={fadeInUp}>
                            <div className="premium-value-icon"><Globe size={24} /></div>
                            <h4 className="premium-value-title">Responsible Travel</h4>
                            <p className="premium-value-desc">We mandate strict group sizes, actively drive local economies, and respect carrying capacities to ensure Tanzania's pristine wilderness thrives.</p>
                        </motion.div>
                        <motion.div className="premium-value-card" variants={fadeInUp}>
                            <div className="premium-value-icon"><TreePine size={24} /></div>
                            <h4 className="premium-value-title">Conservation Legacy</h4>
                            <p className="premium-value-desc">A portion of every expedition directly funds proactive reforestation, critical wildlife corridors, and vital community education programs.</p>
                        </motion.div>
                    </motion.div>
                </div>
            </section>

            {/* ─── 5. FINAL EXPERIENCE BAND ─── */}
            <section className="premium-exp-section">
                <div className="premium-exp-bg">
                    <img
                        src={visualsData.about.experienceBand}
                        alt="Kilimanjaro Trekking Group"
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
                        <motion.span className="premium-eyebrow" style={{ color: 'white' }} variants={fadeInUp}>The Difference</motion.span>
                        <motion.h2 className="premium-exp-title" variants={fadeInUp}>Experience That <em>Speaks.</em></motion.h2>
                        <motion.div variants={fadeInUp}>
                            <Link to="/contact" className="premium-exp-cta">
                                <span>Initialize Your Expedition</span>
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
                                <h4 className="premium-exp-item-title">Locally Born, Globally Trusted</h4>
                                <p className="premium-exp-item-text">Our architects were raised in the Kilimanjaro region. We don't just guide on the mountain—we live it, breathe it, and protect it.</p>
                            </div>
                        </motion.div>
                        <motion.div className="premium-exp-item" variants={fadeInUp}>
                            <span className="premium-exp-num">02</span>
                            <div>
                                <h4 className="premium-exp-item-title">Precision-Planned Itineraries</h4>
                                <p className="premium-exp-item-text">Every detail is painstakingly considered—from specialized acclimatization schedules to high-altitude luxury cuisine. Nothing is left to chance.</p>
                            </div>
                        </motion.div>
                        <motion.div className="premium-exp-item" variants={fadeInUp}>
                            <span className="premium-exp-num">03</span>
                            <div>
                                <h4 className="premium-exp-item-title">Summit Success, Not Attempts</h4>
                                <p className="premium-exp-item-text">Our unparalleled 98% success rate isn't luck—it's the direct result of expert route selection, superior guide training, and an absolute obsession with client wellbeing.</p>
                            </div>
                        </motion.div>
                    </motion.div>
                </div>
            </section>

        </div>
    );
};
