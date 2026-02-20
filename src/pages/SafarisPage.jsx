import React, { useEffect, useRef } from 'react';
import { motion, useScroll, useTransform } from 'framer-motion';
import { ArrowRight } from 'lucide-react';
import { Link } from 'react-router-dom';
import '../styles/safari-premium.css';

const destinations = [
    {
        name: "Serengeti",
        subtitle: "The Infinite Plains",
        tag: "THE GREAT MIGRATION",
        desc: "Witness the greatest wildlife spectacle on Earth—two million wildebeest thundering across golden savannahs under an endless sky. It is a primal, breathtaking theatre of survival.",
        img: "https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1600&q=85&auto=format&fit=crop",
        highlights: ["The Great Migration", "River Crossings", "Big Five Territory"],
        duration: "3–5 Days"
    },
    {
        name: "Ngorongoro",
        subtitle: "The Lost World",
        tag: "UNESCO CALDERA",
        desc: "Descend into an ancient, unbroken volcanic caldera. This self-contained ecosystem is a sanctuary where endangered black rhinos, apex predators, and flamingos coexist in staggering density.",
        img: "https://images.unsplash.com/photo-1518173335487-347a0e39129d?w=1600&q=85&auto=format&fit=crop",
        highlights: ["Endangered Black Rhino", "Crater Floor Drives", "Maasai Coexistence"],
        duration: "1–2 Days"
    },
    {
        name: "Tarangire",
        subtitle: "Land of Giants",
        tag: "ELEPHANT REALM",
        desc: "Walk in the shadow of ancient baobab trees and encounter the largest elephant herds in Tanzania. The park is a quiet, stunningly beautiful landscape carved by the Tarangire River.",
        img: "https://images.unsplash.com/photo-1581852015102-142a2c317022?w=1600&q=85&auto=format&fit=crop",
        highlights: ["Massive Elephant Herds", "Ancient Baobabs", "Silvery Landscapes"],
        duration: "2–3 Days"
    }
];

const packages = [
    {
        title: "The Great Migration Edition",
        days: "10 Days",
        parks: "Serengeti • Ngorongoro • Manyara",
        price: "8,400",
        img: "https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&q=80&auto=format&fit=crop",
        badge: "SIGNATURE",
        includes: ["Private Custom 4x4 Cruiser", "Ultra-Luxury Tented Camps", "Serengeti Bush Dinners"]
    },
    {
        title: "The Pioneer's Route",
        days: "7 Days",
        parks: "Tarangire • Manyara • Ngorongoro",
        price: "5,200",
        img: "https://images.unsplash.com/photo-1523805081730-6144a778afd0?w=800&q=80&auto=format&fit=crop",
        badge: "CLASSIC",
        includes: ["Elite Head Guide", "Premium Lodge Accommodation", "Guided Walking Safaris"]
    },
    {
        title: "The Grand Canvas",
        days: "14 Days",
        parks: "All Northern Parks • Zanzibar",
        price: "14,500",
        img: "https://images.unsplash.com/photo-1493020256266-db09d97bd02d?w=800&q=80&auto=format&fit=crop",
        badge: "EXCLUSIVE",
        includes: ["Internal Bush Flights", "Private Chef & Butler", "Zanzibar Recovery Retreat"]
    }
];

const reviews = [
    { name: "Sarah & James W.", location: "London, UK", text: "A truly life-altering exhibition of nature. Watching the Serengeti sunrise from our balloon, followed by a champagne breakfast seamlessly prepared in the bush, felt like a dream." },
    { name: "Michael C.", location: "Toronto, Canada", text: "The attention to absolute detail was extraordinary. Every lodge selection, every guide's intuition, every moment felt flawlessly curated. The quintessential luxury expedition." },
    { name: "The Schmidt Family", location: "Munich, Germany", text: "Our private family safari eclipsed every expectation. We felt remarkably safe, entirely pampered, and witnessed wildlife spectacles we will recount for generations." }
];

export const SafarisPage = () => {
    const heroRef = useRef(null);
    const { scrollYProgress } = useScroll({ target: heroRef, offset: ["start start", "end start"] });
    const heroY = useTransform(scrollYProgress, [0, 1], [0, 200]);

    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 40 },
        visible: { opacity: 1, y: 0, transition: { duration: 1, ease: [0.22, 1, 0.36, 1] } }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.15, delayChildren: 0.1 } }
    };

    return (
        <div className="safari-premium-root">

            {/* ─── 1. CINEMATIC EYEBROW HERO ─── */}
            <section ref={heroRef} className="premium-safari-hero">
                <motion.div style={{ y: heroY }} className="premium-safari-bg">
                    <img
                        src="https://images.unsplash.com/photo-1516426122078-c23e76319801?w=2000&q=85&auto=format&fit=crop"
                        alt="Serengeti Safari Wilderness"
                    />
                </motion.div>
                <div className="premium-safari-overlay"></div>
                <motion.div
                    className="premium-safari-content"
                    initial="hidden"
                    animate="visible"
                    variants={staggerContainer}
                >
                    <motion.span className="premium-safari-eyebrow" variants={fadeInUp}>Tanzania Sensational</motion.span>
                    <motion.h1 className="premium-safari-title" variants={fadeInUp}>Into The <em>Wild.</em></motion.h1>
                    <motion.p className="premium-safari-subtitle" variants={fadeInUp}>
                        Bespoke, uncompromising wilderness experiences meticulously curated across Tanzania's most iconic and untamed landscapes.
                    </motion.p>
                    <motion.div className="premium-safari-actions" variants={fadeInUp}>
                        <a href="#destinations" className="premium-btn-solid">Explore Landscapes</a>
                        <Link to="/contact" className="premium-btn-outline">Architect Your Safari</Link>
                    </motion.div>
                </motion.div>
            </section>

            {/* ─── 2. THE DESTINATIONS (DARK GALLERY) ─── */}
            <section id="destinations" className="premium-dest-section">
                <div className="premium-dest-head">
                    <span className="premium-dest-eyebrow">The Canvas</span>
                    <h2 className="premium-dest-title">Iconic <em>Destinations.</em></h2>
                </div>

                <div className="premium-dest-list">
                    {destinations.map((dest, i) => {
                        const isReverse = i % 2 !== 0;
                        return (
                            <motion.div
                                key={i}
                                className={`premium-dest-item ${isReverse ? 'reverse' : ''}`}
                                initial="hidden"
                                whileInView="visible"
                                viewport={{ once: true, margin: "-100px" }}
                                variants={staggerContainer}
                            >
                                <motion.div className="premium-dest-image-wrap" variants={fadeInUp}>
                                    <img src={dest.img} alt={dest.name} className="premium-dest-image" />
                                    <div className="premium-dest-img-badge">{dest.tag}</div>
                                </motion.div>
                                <div className="premium-dest-info">
                                    <motion.h3 className="premium-dest-name" variants={fadeInUp}>{dest.name}</motion.h3>
                                    <motion.span className="premium-dest-subtitle" variants={fadeInUp}>{dest.subtitle}</motion.span>
                                    <motion.p className="premium-dest-desc" variants={fadeInUp}>{dest.desc}</motion.p>

                                    <motion.div className="premium-dest-highlights" variants={fadeInUp}>
                                        {dest.highlights.map((h, j) => (
                                            <span key={j} className="premium-highlight">{h}</span>
                                        ))}
                                    </motion.div>

                                    <motion.div className="premium-dest-meta" variants={fadeInUp}>
                                        <div className="meta-label">Optimal Duration</div>
                                        <div className="meta-value">{dest.duration}</div>
                                    </motion.div>
                                </div>
                            </motion.div>
                        );
                    })}
                </div>
            </section>

            {/* ─── 3. CURATED JOURNEYS (PARCHMENT CARDS) ─── */}
            <section className="premium-pkg-section">
                <div className="premium-pkg-head">
                    <span className="premium-pkg-eyebrow">The Collection</span>
                    <h2 className="premium-pkg-title">Curated <em>Journeys.</em></h2>
                </div>

                <motion.div
                    className="premium-pkg-grid"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: "-50px" }}
                    variants={staggerContainer}
                >
                    {packages.map((pkg, i) => (
                        <motion.div key={i} className="premium-pkg-card" variants={fadeInUp}>
                            <div className="premium-pkg-img-wrap">
                                <img src={pkg.img} alt={pkg.title} />
                                <div className="premium-pkg-badge">{pkg.badge}</div>
                            </div>
                            <div className="premium-pkg-content">
                                <span className="premium-pkg-routing">{pkg.days} • {pkg.parks}</span>
                                <h3 className="premium-pkg-name">{pkg.title}</h3>
                                <ul className="premium-pkg-includes">
                                    {pkg.includes.map((inc, j) => <li key={j}>{inc}</li>)}
                                </ul>
                                <div className="premium-pkg-footer">
                                    <div className="premium-pkg-price-col">
                                        <span className="premium-price-label">Starting From</span>
                                        <span className="premium-price-val">${pkg.price} <span style={{ fontSize: '0.8rem', color: '#888', fontFamily: 'Outfit, sans-serif' }}>/ pp</span></span>
                                    </div>
                                    <Link to="/contact" className="premium-pkg-enquire">Enquire Now</Link>
                                </div>
                            </div>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ─── 4. REVIEWS (EDITORIAL SPREAD) ─── */}
            <section className="premium-reviews-section">
                <div className="premium-reviews-head">
                    <span className="premium-pkg-eyebrow">The Legacy</span>
                    <h2 className="premium-pkg-title">Traveler <em>Accounts.</em></h2>
                </div>

                <motion.div
                    className="premium-reviews-grid"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: "-50px" }}
                    variants={staggerContainer}
                >
                    {reviews.map((r, i) => (
                        <motion.div key={i} className="premium-review-card" variants={fadeInUp}>
                            <div className="premium-review-mark">"</div>
                            <p className="premium-review-text">{r.text}</p>
                            <div className="premium-review-author">{r.name}</div>
                            <span className="premium-review-loc">{r.location}</span>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

        </div>
    );
};
