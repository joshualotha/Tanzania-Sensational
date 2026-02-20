import React, { useEffect } from 'react';
import { motion, useScroll, useTransform, useSpring, useInView } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Mountain, Shield, Users, Star, Award, Compass, ArrowRight, Heart, Globe, TreePine } from 'lucide-react';
import logo from '../assets/logo.png';

const CountUp = ({ to, prefix = "", suffix = "", duration = 2 }) => {
    const ref = React.useRef(null);
    const isInView = useInView(ref, { once: true, margin: "-100px" });
    const [count, setCount] = React.useState(0);

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
                if (start === end) clearInterval(timer);
            }, incrementTime);

            return () => clearInterval(timer);
        }
    }, [isInView, to, duration]);

    const formatNumber = (num) => {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };

    return (
        <span ref={ref}>
            {prefix}{formatNumber(count)}{suffix}
        </span>
    );
};

export const AboutPage = () => {
    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const pageVariants = {
        hidden: { opacity: 0 },
        visible: {
            opacity: 1,
            transition: { staggerChildren: 0.12, delayChildren: 0.1 }
        }
    };

    const { scrollYProgress } = useScroll();
    const heroY = useTransform(scrollYProgress, [0, 0.3], [0, 200]);
    const whyY = useTransform(scrollYProgress, [0.7, 1], [-100, 100]);

    const fadeInUp = {
        hidden: { opacity: 0, y: 60 },
        visible: {
            opacity: 1,
            y: 0,
            transition: { duration: 1, ease: [0.22, 1, 0.36, 1] }
        }
    };

    const fadeInHeader = {
        hidden: { opacity: 0, y: 30 },
        visible: {
            opacity: 1,
            y: 0,
            transition: { duration: 0.8, ease: "easeOut" }
        }
    };

    const imageReveal = {
        hidden: { clipPath: "inset(0 100% 0 0)", opacity: 0 },
        visible: {
            clipPath: "inset(0 0% 0 0)",
            opacity: 1,
            transition: { duration: 1.2, ease: [0.22, 1, 0.36, 1] }
        }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: {
            opacity: 1,
            transition: { staggerChildren: 0.15, delayChildren: 0.1 }
        }
    };

    const values = [
        { icon: <Shield size={28} />, title: "Safety First", desc: "Every expedition is meticulously planned with certified guides, premium equipment, and emergency protocols that exceed international standards." },
        { icon: <Heart size={28} />, title: "Authentic Experiences", desc: "We go beyond tourism. Each journey is crafted to create genuine connections with Tanzania's landscapes, wildlife, and communities." },
        { icon: <Globe size={28} />, title: "Responsible Travel", desc: "We limit group sizes, support local economies, and invest in conservation to ensure Tanzania's wilderness thrives for generations." },
        { icon: <TreePine size={28} />, title: "Conservation Legacy", desc: "A portion of every expedition funds reforestation, wildlife corridors, and community education programs across the Kilimanjaro region." }
    ];

    const stats = [
        { to: "15", suffix: "+", label: "Years of Excellence" },
        { to: "5000", suffix: "+", label: "Summits Reached" },
        { to: "98", suffix: "%", label: "Success Rate" },
        { to: "50", suffix: "+", label: "Expert Guides" }
    ];


    return (
        <motion.div
            className="about-root"
            initial="hidden"
            animate="visible"
            variants={pageVariants}
        >
            {/* ─── CINEMATIC HERO ─── */}
            <section className="about-hero">
                <motion.div className="about-hero-bg" style={{ y: heroY }}>
                    <img
                        src="https://images.unsplash.com/photo-1609198092458-38a293c7ac4b?q=80&w=2000&auto=format&fit=crop"
                        alt="Kilimanjaro Summit at Dawn"
                    />
                    <div className="about-hero-overlay"></div>
                </motion.div>
                <div className="container about-hero-container">
                    <motion.div
                        className="about-hero-content"
                        variants={fadeInUp}
                        initial="hidden"
                        animate="visible"
                    >
                        <span className="about-eyebrow">Our Story</span>
                        <h1 className="about-hero-title">Born from the <em>Mountain</em></h1>
                        <p className="about-hero-subtitle">
                            We didn't start a travel company. We inherited a calling — to share the majesty of Tanzania with the world.
                        </p>
                        <div className="about-title-line"></div>
                    </motion.div>

                    {/* Integrated Stats Strip */}
                    <motion.div
                        className="about-hero-stats"
                        variants={fadeInUp}
                        initial="hidden"
                        animate="visible"
                        transition={{ delay: 0.4 }}
                    >
                        <div className="about-stats-row hero-integrated">
                            {stats.map((s, i) => (
                                <div key={i} className="about-stat">
                                    <span className="about-stat-num">
                                        <CountUp to={s.to} suffix={s.suffix} duration={2} />
                                    </span>
                                    <span className="about-stat-label">{s.label}</span>
                                </div>
                            ))}
                        </div>
                    </motion.div>
                </div>
            </section>


            {/* ─── ORIGIN STORY ─── */}
            <section className="about-story">
                <div className="container about-story-grid">
                    <motion.div
                        className="about-story-image"
                        variants={imageReveal}
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: "-50px" }}
                    >
                        <img
                            src="https://images.unsplash.com/photo-1631646109206-4919df38eb68?q=80&w=800&auto=format&fit=crop"
                            alt="Kilimanjaro Trail"
                        />
                        <div className="about-story-badge">
                            <Mountain size={24} />
                            <span>Est. 2010</span>
                        </div>
                    </motion.div>
                    <motion.div
                        className="about-story-text"
                        variants={fadeInUp}
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: "-50px" }}
                    >
                        <div className="section-eyebrow">
                            <span className="section-eyebrow-line"></span>
                            <span className="section-eyebrow-text">The Beginning</span>
                        </div>
                        <h2 className="section-title">From a Single Trail to a <em>Legacy</em></h2>
                        <p className="about-body-text">
                            Tanzania Sensational was born from a simple belief: that the mountains and savannas of East Africa
                            deserve to be experienced at the highest standard of excellence. What began as a single guide leading
                            treks on the Marangu Route has evolved into Tanzania's most trusted expedition company.
                        </p>
                        <p className="about-body-text">
                            Our founder, Emmanuel Kimaro, grew up in the shadow of Kilimanjaro. His deep respect for the mountain
                            and its ecosystems became the foundation of everything we do. Today, we operate across Kilimanjaro,
                            Mount Meru, the Serengeti, Ngorongoro, and Zanzibar — always with the same principle: <strong>excellence without compromise.</strong>
                        </p>
                    </motion.div>
                </div>
            </section>

            {/* ─── MISSION / VISION SPLIT ─── */}
            <section className="about-mission">
                <div className="container about-mission-grid">
                    <motion.div
                        className="about-mission-card"
                        variants={fadeInUp}
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: "-50px" }}
                    >
                        <div className="about-mission-icon">
                            <Compass size={32} />
                        </div>
                        <h3 className="about-mission-title">Our Mission</h3>
                        <p className="about-mission-text">
                            To deliver transformative travel experiences that connect people with East Africa's
                            greatest natural wonders — safely, sustainably, and unforgettably.
                        </p>
                    </motion.div>
                    <motion.div
                        className="about-mission-card"
                        variants={fadeInUp}
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: "-50px" }}
                    >
                        <div className="about-mission-icon">
                            <Star size={32} />
                        </div>
                        <h3 className="about-mission-title">Our Vision</h3>
                        <p className="about-mission-text">
                            To be recognized globally as the gold standard in East African expedition travel,
                            setting new benchmarks for safety, service, and environmental stewardship.
                        </p>
                    </motion.div>
                </div>
            </section>

            {/* ─── VALUES ─── */}
            <section className="about-values">
                <div className="container">
                    <motion.div
                        className="about-values-header"
                        variants={fadeInHeader}
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                    >
                        <div className="section-eyebrow about-eyebrow-center">
                            <span className="section-eyebrow-line"></span>
                            <span className="section-eyebrow-text">What Guides Us</span>
                            <span className="section-eyebrow-line"></span>
                        </div>
                        <h2 className="section-title about-center-title">The Principles Behind Every <em>Expedition</em></h2>
                    </motion.div>
                    <motion.div
                        className="about-values-grid"
                        variants={staggerContainer}
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                    >
                        {values.map((v, i) => (
                            <motion.div key={i} className="about-value-card" variants={fadeInUp}>
                                <div className="about-value-icon">{v.icon}</div>
                                <h4 className="about-value-title">{v.title}</h4>
                                <p className="about-value-desc">{v.desc}</p>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* ─── EXPERIENCE THE DIFFERENCE ─── */}
            <section className="about-experience">
                <div className="container about-experience-grid">
                    <motion.div
                        className="about-exp-image"
                        variants={imageReveal}
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true, margin: "-50px" }}
                    >
                        <img
                            src="https://images.unsplash.com/photo-1650668302197-7f556c34cb91?q=80&w=800&auto=format&fit=crop"
                            alt="Kilimanjaro Trekking Group"
                        />
                    </motion.div>
                    <motion.div
                        className="about-exp-content"
                        variants={staggerContainer}
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                    >
                        <motion.div className="section-eyebrow" variants={fadeInHeader}>
                            <span className="section-eyebrow-line"></span>
                            <span className="section-eyebrow-text">The Difference</span>
                        </motion.div>
                        <motion.h2 className="section-title" variants={fadeInUp}>Experience That <em>Speaks</em></motion.h2>
                        <div className="about-exp-list">
                            {[
                                { num: "01", title: "Locally Born, Globally Trusted", text: "Our team was raised in the Kilimanjaro region. We don't read about the mountain — we live it, breathe it, and protect it." },
                                { num: "02", title: "Precision-Planned Itineraries", text: "Every detail is considered — from acclimatization schedules to camp cuisine. Nothing is left to chance on your adventure." },
                                { num: "03", title: "Summit Success, Not Just Attempts", text: "Our 98% success rate isn't luck — it's the result of expert route selection, superior guides, and an obsession with client wellbeing." }
                            ].map((item, idx) => (
                                <motion.div key={idx} className="about-exp-item" variants={fadeInUp}>
                                    <span className="about-exp-num">{item.num}</span>
                                    <div>
                                        <h4 className="about-exp-item-title">{item.title}</h4>
                                        <p className="about-exp-item-text">{item.text}</p>
                                    </div>
                                </motion.div>
                            ))}
                        </div>
                    </motion.div>
                </div>
            </section>

            {/* ─── WHY CHOOSE US / CINEMATIC BAND ─── */}
            <section className="about-why">
                <motion.div className="about-why-bg" style={{ y: whyY }}>
                    <img
                        src="https://images.unsplash.com/photo-1516426122078-c23e76319801?q=80&w=2000&auto=format&fit=crop"
                        alt="African Safari Landscape"
                    />
                    <div className="about-why-overlay"></div>
                </motion.div>
                <div className="container about-why-container">
                    <motion.div
                        className="about-why-content"
                        variants={fadeInUp}
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                    >
                        <span className="about-why-eyebrow">Why Tanzania Sensational</span>
                        <h2 className="about-why-title">Your Journey Deserves <em>the Best</em></h2>
                        <div className="about-why-features">
                            {[
                                { icon: <Award size={22} />, text: "KPAP & TALA Certified Operator" },
                                { icon: <Users size={22} />, text: "Small Groups, Personal Attention" },
                                { icon: <Shield size={22} />, text: "Premium Safety & Equipment Standards" }
                            ].map((f, i) => (
                                <div key={i} className="about-why-feature">
                                    {f.icon}
                                    <span>{f.text}</span>
                                </div>
                            ))}
                        </div>
                        <Link to="/contact" className="about-why-cta">
                            <span>Start Your Expedition</span>
                            <ArrowRight size={18} />
                        </Link>
                    </motion.div>
                </div>
            </section>
        </motion.div>
    );
};
