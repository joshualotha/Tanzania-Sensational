import React, { useEffect, useRef, useState } from 'react';
import { motion, useScroll, useTransform, useInView, AnimatePresence } from 'framer-motion';
import '../styles/safaris.css';

const fadeUp = {
    hidden: { opacity: 0, y: 60 },
    visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
};

const stagger = {
    visible: { transition: { staggerChildren: 0.15 } }
};

const scaleIn = {
    hidden: { scale: 0.9, opacity: 0 },
    visible: { scale: 1, opacity: 1, transition: { duration: 0.7, ease: [0.22, 1, 0.36, 1] } }
};

const slideRight = {
    hidden: { x: -80, opacity: 0 },
    visible: { x: 0, opacity: 1, transition: { duration: 0.9, ease: [0.22, 1, 0.36, 1] } }
};

const Counter = ({ target, suffix = "" }) => {
    const ref = useRef(null);
    const isInView = useInView(ref, { once: true });
    const [count, setCount] = useState(0);

    useEffect(() => {
        if (isInView) {
            let start = 0;
            const end = parseInt(target);
            const duration = 2000;
            const step = end / (duration / 16);
            const timer = setInterval(() => {
                start += step;
                if (start >= end) { setCount(end); clearInterval(timer); }
                else setCount(Math.floor(start));
            }, 16);
            return () => clearInterval(timer);
        }
    }, [isInView, target]);

    return <span ref={ref}>{count}{suffix}</span>;
};

const destinations = [
    {
        name: "Serengeti",
        subtitle: "The Infinite Plains",
        tag: "MIGRATION",
        desc: "Witness the greatest wildlife spectacle on Earth — two million wildebeest thundering across golden savannahs under an endless sky.",
        img: "https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1600&q=85&auto=format&fit=crop",
        highlights: ["Great Migration", "Big Five", "Hot Air Balloons"],
        duration: "3–5 Days"
    },
    {
        name: "Ngorongoro",
        subtitle: "The Lost World",
        tag: "UNESCO SITE",
        desc: "Descend into an ancient volcanic caldera, a self-contained ecosystem where black rhinos, lions, and flamingos coexist in stunning density.",
        img: "https://images.unsplash.com/photo-1518173335487-347a0e39129d?w=1600&q=85&auto=format&fit=crop",
        highlights: ["Black Rhino", "Crater Floor", "Maasai Culture"],
        duration: "1–2 Days"
    },
    {
        name: "Tarangire",
        subtitle: "Land of Giants",
        tag: "ELEPHANTS",
        desc: "Walk amongst ancient baobab trees and the largest elephant herds in Tanzania, in a landscape sculpted by time and the Tarangire River.",
        img: "https://images.unsplash.com/photo-1581852015102-142a2c317022?w=1600&q=85&auto=format&fit=crop",
        highlights: ["Elephant Herds", "Baobab Forest", "Night Safari"],
        duration: "2–3 Days"
    }
];

const packages = [
    {
        title: "The Great Migration",
        days: "10 Days",
        parks: "Serengeti • Ngorongoro • Manyara",
        price: "8,400",
        img: "https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?w=800&q=80&auto=format&fit=crop",
        badge: "SIGNATURE",
        includes: ["Private 4x4 Vehicle", "Luxury Lodges", "Bush Dinners"]
    },
    {
        title: "Wilderness Explorer",
        days: "7 Days",
        parks: "Tarangire • Manyara • Ngorongoro",
        price: "5,200",
        img: "https://images.unsplash.com/photo-1523805081730-6144a778afd0?w=800&q=80&auto=format&fit=crop",
        badge: "ADVENTURE",
        includes: ["Expert Guides", "Tented Camps", "Walking Safaris"]
    },
    {
        title: "Ultimate Northern Circuit",
        days: "14 Days",
        parks: "All Northern Parks • Zanzibar",
        price: "14,500",
        img: "https://images.unsplash.com/photo-1493020256266-db09d97bd02d?w=800&q=80&auto=format&fit=crop",
        badge: "EXCLUSIVE",
        includes: ["Helicopter Transfers", "Private Chef", "Spa Treatments"]
    }
];

const reviews = [
    { name: "Sarah & James", location: "London, UK", text: "Absolutely life-changing. The Serengeti sunrise from our hot air balloon is something we'll never forget.", rating: 5 },
    { name: "Michael Chen", location: "Toronto, Canada", text: "The attention to detail was extraordinary. Every lodge, every guide, every moment felt personally curated just for us.", rating: 5 },
    { name: "Familie Schmidt", location: "Munich, Germany", text: "Our family safari exceeded every expectation. The kids still talk about the baby elephants at Tarangire.", rating: 5 }
];

export const SafarisPage = () => {
    const [activeDestination, setActiveDestination] = useState(0);
    const [activePkg, setActivePkg] = useState(null);
    const heroRef = useRef(null);
    const { scrollYProgress } = useScroll({ target: heroRef, offset: ["start start", "end start"] });
    const heroY = useTransform(scrollYProgress, [0, 1], [0, 200]);
    const heroOpacity = useTransform(scrollYProgress, [0, 0.8], [1, 0]);

    useEffect(() => { window.scrollTo(0, 0); }, []);

    return (
        <div className="sf-page">
            {/* ═══ ANIMATED HERO ═══ */}
            <section ref={heroRef} className="sf-hero">
                <motion.div style={{ y: heroY }} className="sf-hero-media">
                    <motion.img
                        initial={{ scale: 1.3 }}
                        animate={{ scale: 1 }}
                        transition={{ duration: 2.5, ease: [0.22, 1, 0.36, 1] }}
                        src="https://images.unsplash.com/photo-1516426122078-c23e76319801?w=1920&q=90&auto=format&fit=crop"
                        alt="Safari"
                    />
                </motion.div>
                <div className="sf-hero-grad"></div>
                <motion.div style={{ opacity: heroOpacity }} className="sf-hero-inner">
                    <motion.span initial={{ opacity: 0, letterSpacing: '0.05em' }} animate={{ opacity: 1, letterSpacing: '0.35em' }} transition={{ duration: 1.5 }} className="sf-hero-tag">
                        TANZANIA SENSATIONAL
                    </motion.span>
                    <h1 className="sf-hero-h1">
                        <motion.div className="sf-h1-line" initial={{ clipPath: 'inset(0 100% 0 0)' }} animate={{ clipPath: 'inset(0 0% 0 0)' }} transition={{ duration: 1.2, delay: 0.3, ease: [0.22, 1, 0.36, 1] }}>
                            Into The
                        </motion.div>
                        <motion.div className="sf-h1-accent" initial={{ clipPath: 'inset(0 100% 0 0)' }} animate={{ clipPath: 'inset(0 0% 0 0)' }} transition={{ duration: 1.2, delay: 0.6, ease: [0.22, 1, 0.36, 1] }}>
                            Wild.
                        </motion.div>
                    </h1>
                    <motion.p initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: 1.2, duration: 0.8 }} className="sf-hero-sub">
                        Curated wilderness experiences across Tanzania's most iconic landscapes.
                    </motion.p>
                    <motion.div initial={{ opacity: 0, y: 20 }} animate={{ opacity: 1, y: 0 }} transition={{ delay: 1.6, duration: 0.8 }} className="sf-hero-actions">
                        <a href="#destinations" className="sf-btn-primary">EXPLORE DESTINATIONS</a>
                        <a href="/contact" className="sf-btn-ghost">PLAN YOUR TRIP</a>
                    </motion.div>
                </motion.div>
                <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} transition={{ delay: 2 }} className="sf-scroll-indicator">
                    <div className="sf-scroll-line"></div>
                    <span>SCROLL</span>
                </motion.div>
            </section>

            {/* ═══ STATS BAND ═══ */}
            <motion.section variants={stagger} initial="hidden" whileInView="visible" viewport={{ once: true }} className="sf-stats">
                {[
                    { number: "15", suffix: "+", label: "Years Experience" },
                    { number: "98", suffix: "%", label: "Wildlife Sightings" },
                    { number: "2500", suffix: "+", label: "Happy Travelers" },
                    { number: "5", suffix: "★", label: "Rated Excellence" }
                ].map((stat, i) => (
                    <motion.div key={i} variants={fadeUp} className="sf-stat">
                        <div className="sf-stat-num"><Counter target={stat.number} suffix={stat.suffix} /></div>
                        <div className="sf-stat-label">{stat.label}</div>
                    </motion.div>
                ))}
            </motion.section>

            {/* ═══ DESTINATIONS — Interactive Tabs ═══ */}
            <section id="destinations" className="sf-destinations">
                <motion.div variants={stagger} initial="hidden" whileInView="visible" viewport={{ once: true }} className="sf-section-head">
                    <motion.span variants={fadeUp} className="sf-tag">WHERE WE GO</motion.span>
                    <motion.h2 variants={fadeUp} className="sf-heading">Iconic <em>Destinations</em></motion.h2>
                </motion.div>

                <div className="sf-dest-tabs">
                    <div className="sf-dest-nav">
                        {destinations.map((d, i) => (
                            <motion.button
                                key={i}
                                onClick={() => setActiveDestination(i)}
                                className={`sf-dest-tab ${activeDestination === i ? 'active' : ''}`}
                                whileHover={{ x: 10 }}
                                whileTap={{ scale: 0.98 }}
                            >
                                <span className="tab-index">0{i + 1}</span>
                                <div className="tab-info">
                                    <span className="tab-name">{d.name}</span>
                                    <span className="tab-sub">{d.subtitle}</span>
                                </div>
                                <span className="tab-arrow">→</span>
                            </motion.button>
                        ))}
                    </div>

                    <AnimatePresence mode="wait">
                        <motion.div
                            key={activeDestination}
                            initial={{ opacity: 0, x: 40 }}
                            animate={{ opacity: 1, x: 0 }}
                            exit={{ opacity: 0, x: -40 }}
                            transition={{ duration: 0.5, ease: [0.22, 1, 0.36, 1] }}
                            className="sf-dest-display"
                        >
                            <div className="sf-dest-img-wrap">
                                <motion.img
                                    key={destinations[activeDestination].img}
                                    initial={{ scale: 1.15 }}
                                    animate={{ scale: 1 }}
                                    transition={{ duration: 1.2 }}
                                    src={destinations[activeDestination].img}
                                    alt={destinations[activeDestination].name}
                                />
                                <div className="sf-dest-img-overlay"></div>
                                <div className="sf-dest-badge">{destinations[activeDestination].tag}</div>
                            </div>
                            <div className="sf-dest-details">
                                <h3 className="sf-dest-name">{destinations[activeDestination].name}</h3>
                                <span className="sf-dest-subtitle">{destinations[activeDestination].subtitle}</span>
                                <p className="sf-dest-desc">{destinations[activeDestination].desc}</p>
                                <div className="sf-dest-highlights">
                                    {destinations[activeDestination].highlights.map((h, i) => (
                                        <motion.span key={i} initial={{ opacity: 0, scale: 0.8 }} animate={{ opacity: 1, scale: 1 }} transition={{ delay: i * 0.1 }} className="sf-highlight">{h}</motion.span>
                                    ))}
                                </div>
                                <div className="sf-dest-duration">
                                    <span className="duration-label">Recommended</span>
                                    <span className="duration-value">{destinations[activeDestination].duration}</span>
                                </div>
                            </div>
                        </motion.div>
                    </AnimatePresence>
                </div>
            </section>

            {/* ═══ SAFARI PACKAGES ═══ */}
            <section className="sf-packages">
                <motion.div variants={stagger} initial="hidden" whileInView="visible" viewport={{ once: true }} className="sf-section-head">
                    <motion.span variants={fadeUp} className="sf-tag">CURATED JOURNEYS</motion.span>
                    <motion.h2 variants={fadeUp} className="sf-heading">Signature <em>Packages</em></motion.h2>
                </motion.div>

                <motion.div variants={stagger} initial="hidden" whileInView="visible" viewport={{ once: true }} className="sf-pkg-grid">
                    {packages.map((pkg, i) => (
                        <motion.div
                            key={i} variants={scaleIn}
                            className={`sf-pkg-card ${activePkg === i ? 'expanded' : ''}`}
                            onMouseEnter={() => setActivePkg(i)}
                            onMouseLeave={() => setActivePkg(null)}
                        >
                            <div className="sf-pkg-img">
                                <img src={pkg.img} alt={pkg.title} />
                                <div className="sf-pkg-img-overlay"></div>
                                <span className="sf-pkg-badge">{pkg.badge}</span>
                            </div>
                            <div className="sf-pkg-body">
                                <div className="sf-pkg-meta">
                                    <span className="pkg-days">{pkg.days}</span>
                                    <span className="pkg-divider">|</span>
                                    <span className="pkg-parks">{pkg.parks}</span>
                                </div>
                                <h3 className="sf-pkg-title">{pkg.title}</h3>
                                <AnimatePresence>
                                    {activePkg === i && (
                                        <motion.div initial={{ height: 0, opacity: 0 }} animate={{ height: 'auto', opacity: 1 }} exit={{ height: 0, opacity: 0 }} transition={{ duration: 0.4 }} className="sf-pkg-expand">
                                            <ul className="sf-pkg-includes">
                                                {pkg.includes.map((inc, j) => (
                                                    <motion.li key={j} initial={{ x: -10, opacity: 0 }} animate={{ x: 0, opacity: 1 }} transition={{ delay: j * 0.1 }}>{inc}</motion.li>
                                                ))}
                                            </ul>
                                        </motion.div>
                                    )}
                                </AnimatePresence>
                                <div className="sf-pkg-footer">
                                    <div className="sf-pkg-price">
                                        <span className="price-from">From</span>
                                        <span className="price-amount">${pkg.price}</span>
                                        <span className="price-per">per person</span>
                                    </div>
                                    <a href="/contact" className="sf-pkg-cta">ENQUIRE →</a>
                                </div>
                            </div>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ═══ IMMERSIVE QUOTE ═══ */}
            <section className="sf-quote">
                <div className="sf-quote-bg">
                    <img src="https://images.unsplash.com/photo-1523805081730-6144a778afd0?w=1920&q=70&auto=format&fit=crop" alt="" />
                </div>
                <div className="sf-quote-overlay"></div>
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={stagger} className="sf-quote-inner">
                    <motion.div variants={fadeUp} className="sf-quote-mark">"</motion.div>
                    <motion.blockquote variants={fadeUp} className="sf-quote-text">
                        There is something about safari life that makes you forget all your sorrows.
                    </motion.blockquote>
                    <motion.cite variants={fadeUp} className="sf-quote-cite">Karen Blixen</motion.cite>
                </motion.div>
            </section>

            {/* ═══ REVIEWS ═══ */}
            <section className="sf-reviews">
                <motion.div variants={stagger} initial="hidden" whileInView="visible" viewport={{ once: true }} className="sf-section-head">
                    <motion.span variants={fadeUp} className="sf-tag">TRAVELER STORIES</motion.span>
                    <motion.h2 variants={fadeUp} className="sf-heading">What They <em>Say</em></motion.h2>
                </motion.div>

                <motion.div variants={stagger} initial="hidden" whileInView="visible" viewport={{ once: true }} className="sf-review-grid">
                    {reviews.map((r, i) => (
                        <motion.div key={i} variants={fadeUp} className="sf-review-card">
                            <div className="sf-review-stars">{'★'.repeat(r.rating)}</div>
                            <p className="sf-review-text">"{r.text}"</p>
                            <div className="sf-review-author">
                                <span className="author-name">{r.name}</span>
                                <span className="author-loc">{r.location}</span>
                            </div>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ═══ FINAL CTA ═══ */}
            <section className="sf-cta">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={stagger} className="sf-cta-inner">
                    <motion.h2 variants={fadeUp} className="sf-cta-title">Ready For Your <em>Adventure?</em></motion.h2>
                    <motion.p variants={fadeUp} className="sf-cta-sub">Let our expert team craft your perfect Tanzanian safari experience.</motion.p>
                    <motion.div variants={fadeUp} className="sf-cta-actions">
                        <a href="/contact" className="sf-btn-primary large">START PLANNING</a>
                        <a href="https://wa.me/255700000000" className="sf-btn-ghost large">WHATSAPP US</a>
                    </motion.div>
                </motion.div>
            </section>
        </div>
    );
};
