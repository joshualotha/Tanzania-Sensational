import React, { useEffect } from 'react';
import { Link, usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import {
    Clock, MapPin, Home, Coffee, ArrowRight,
    ChevronRight, Shield, Check, X, Users, Star
} from 'lucide-react';
import { visualsData } from '../../data/visualsData';
import OptimizedImage from '../../components/ui/OptimizedImage';
import '../../styles/safari-field-guide.css';

const SafariPackageDetail = ({ pkg }) => {
    const { visuals } = usePage().props;

    useEffect(() => { window.scrollTo(0, 0); }, []);

    const getVisual = (section, fallback) => {
        if (visuals?.[section]?.[0]) return visuals[section][0];
        return fallback;
    };

    if (!pkg) return (
        <div className="field-root" style={{ padding: '200px 24px', textAlign: 'center' }}>
            <h1 style={{ fontFamily: 'var(--field-serif)', fontSize: '3rem', color: 'var(--field-dark)' }}>
                Expedition Not Found
            </h1>
            <p style={{ color: 'var(--field-mid)', marginTop: '16px', marginBottom: '40px' }}>
                The safari package you're looking for doesn't exist or has been removed.
            </p>
            <Link href="/safaris/packages" className="field-btn">
                Browse All Packages <ArrowRight size={16} />
            </Link>
        </div>
    );

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const stagger = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.1 } }
    };

    const heroImage = pkg.hero_image || getVisual('safaris.pillar.hero', 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&q=80');

    return (
        <div className="field-root">
            {/* ─── CINEMATIC HERO ─── */}
            <section className="field-hero">
                <div className="field-hero-img">
                    <OptimizedImage
                        src={heroImage}
                        alt={pkg.name}
                        priority={true}
                        aspectRatio="16/9"
                    />
                </div>
                <div className="field-hero-gradient"></div>
                <div className="field-hero-content">
                    <motion.div
                        initial="hidden"
                        animate="visible"
                        variants={stagger}
                    >
                        <motion.span className="field-hero-eyebrow" variants={fadeInUp}>
                            {pkg.category || 'SIGNATURE'} · {pkg.duration} Days
                        </motion.span>
                        <motion.h1 className="field-hero-title" variants={fadeInUp}>
                            {pkg.name}
                        </motion.h1>
                        <motion.p className="field-hero-subtitle" variants={fadeInUp}>
                            {pkg.description ? pkg.description.substring(0, 160) + '...' : 'A curated safari expedition through Tanzania\'s most magnificent wilderness.'}
                        </motion.p>
                    </motion.div>
                </div>
            </section>

            {/* ─── STATS STRIP ─── */}
            <section style={{ padding: '0 8vw', marginTop: '-40px', position: 'relative', zIndex: 10 }}>
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-50px' }}
                    variants={fadeInUp}
                    className="field-pkg-stats"
                >
                    {[
                        { value: `${pkg.duration} Days`, label: 'Duration', icon: Clock },
                        { value: `From $${Math.round(pkg.base_price).toLocaleString()}`, label: 'Per Person', icon: Star },
                        { value: pkg.meta_tag || 'Tanzania', label: 'Region', icon: MapPin },
                        { value: 'Small Groups', label: 'Max 12 Guests', icon: Users },
                    ].map((stat, i) => (
                        <div key={i} style={{
                            textAlign: 'center',
                            borderRight: i < 3 ? '1px solid var(--field-border)' : 'none',
                            padding: '0 16px',
                        }}>
                            <stat.icon size={18} style={{ color: 'var(--field-gold)', marginBottom: '10px' }} />
                            <div style={{
                                fontFamily: 'var(--field-serif)',
                                fontSize: '1.5rem',
                                color: 'var(--field-dark)',
                                fontWeight: 400,
                                marginBottom: '6px',
                            }}>{stat.value}</div>
                            <div style={{
                                fontSize: '0.65rem',
                                fontWeight: 700,
                                textTransform: 'uppercase',
                                letterSpacing: '0.2em',
                                color: 'var(--field-mid)',
                            }}>{stat.label}</div>
                        </div>
                    ))}
                </motion.div>
            </section>

            {/* ─── MAIN CONTENT + SIDEBAR ─── */}
            <section className="field-chapter" style={{ maxWidth: '1400px' }}>
                <div className="field-pkg-layout" style={{ display: 'grid', gridTemplateColumns: '1fr 380px', gap: '80px', alignItems: 'start' }}>
                    {/* ─── LEFT: ITINERARY ─── */}
                    <div>
                        {/* The Essence */}
                        <motion.div
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true, margin: '-100px' }}
                            variants={fadeInUp}
                        >
                            <span className="field-chapter-eyebrow">The Essence</span>
                            <h2 className="field-chapter-title">Your Safari <em>Story</em></h2>
                            <p className="field-chapter-body" style={{ maxWidth: '100%' }}>
                                {pkg.description || 'A carefully curated expedition through Tanzania\'s most spectacular wilderness areas, designed to immerse you in the raw beauty of East Africa\'s wildlife and landscapes.'}
                            </p>
                        </motion.div>

                        {/* The Journey */}
                        {pkg.itinerary && pkg.itinerary.length > 0 && (
                            <motion.div
                                initial="hidden"
                                whileInView="visible"
                                viewport={{ once: true, margin: '-100px' }}
                                variants={fadeInUp}
                                style={{ marginTop: '80px' }}
                            >
                                <span className="field-chapter-eyebrow">The Journey</span>
                                <h2 className="field-chapter-title">Day by Day <em>Itinerary</em></h2>

                                <div style={{ marginTop: '40px' }}>
                                    {pkg.itinerary.map((day, idx) => (
                                        <motion.div
                                            key={idx}
                                            initial="hidden"
                                            whileInView="visible"
                                            viewport={{ once: true, margin: '-50px' }}
                                            variants={fadeInUp}
                                            className="field-pkg-day-row"
                                            style={{
                                                display: 'grid',
                                                gridTemplateColumns: '80px 1fr',
                                                gap: '40px',
                                                padding: '40px 0',
                                                borderTop: '1px solid var(--field-border)',
                                            }}
                                        >
                                            <div className="field-pkg-day-num">
                                                {String(day.day).padStart(2, '0')}
                                            </div>
                                            <div>
                                                <h3 style={{
                                                    fontFamily: 'var(--field-serif)',
                                                    fontSize: '1.5rem',
                                                    color: 'var(--field-dark)',
                                                    marginBottom: '16px',
                                                    fontWeight: 400,
                                                }}>
                                                    {day.title}
                                                </h3>
                                                <p style={{
                                                    fontSize: '1rem',
                                                    lineHeight: 1.85,
                                                    color: 'var(--field-mid)',
                                                    marginBottom: '24px',
                                                }}>
                                                    {day.desc}
                                                </p>
                                                <div style={{
                                                    display: 'flex',
                                                    gap: '32px',
                                                    padding: '20px 24px',
                                                    background: 'rgba(184, 150, 90, 0.04)',
                                                    border: '1px solid var(--field-border)',
                                                }}>
                                                    {day.accommodation && (
                                                        <div style={{
                                                            display: 'flex',
                                                            alignItems: 'center',
                                                            gap: '10px',
                                                            fontSize: '0.85rem',
                                                            color: 'var(--field-ink)',
                                                        }}>
                                                            <Home size={15} style={{ color: 'var(--field-gold)' }} />
                                                            <span>{day.accommodation}</span>
                                                        </div>
                                                    )}
                                                    {day.meals && (
                                                        <div style={{
                                                            display: 'flex',
                                                            alignItems: 'center',
                                                            gap: '10px',
                                                            fontSize: '0.85rem',
                                                            color: 'var(--field-ink)',
                                                        }}>
                                                            <Coffee size={15} style={{ color: 'var(--field-gold)' }} />
                                                            <span>{day.meals}</span>
                                                        </div>
                                                    )}
                                                </div>
                                            </div>
                                        </motion.div>
                                    ))}
                                </div>
                            </motion.div>
                        )}
                    </div>

                    {/* ─── RIGHT: STICKY SIDEBAR ─── */}
                    <div className="field-pkg-sidebar">
                        {/* Booking Card */}
                        <motion.div
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true }}
                            variants={fadeInUp}
                            style={{
                                background: 'var(--field-dark)',
                                padding: '48px 36px',
                                marginBottom: '24px',
                            }}
                        >
                            <div style={{ textAlign: 'center', marginBottom: '32px' }}>
                                <div style={{
                                    fontSize: '0.65rem',
                                    color: 'var(--field-gold)',
                                    letterSpacing: '0.25em',
                                    textTransform: 'uppercase',
                                    fontWeight: 700,
                                    marginBottom: '12px',
                                }}>Investment From</div>
                                <div style={{
                                    fontFamily: 'var(--field-serif)',
                                    fontSize: '3rem',
                                    color: '#fff',
                                    fontWeight: 400,
                                    lineHeight: 1,
                                }}>
                                    ${Math.round(pkg.base_price).toLocaleString()}
                                </div>
                                <div style={{
                                    fontSize: '0.78rem',
                                    color: 'rgba(255,255,255,0.4)',
                                    marginTop: '8px',
                                }}>per person</div>
                            </div>

                            <Link
                                href={`/booking/safari/${pkg.slug}`}
                                style={{
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    gap: '10px',
                                    width: '100%',
                                    padding: '18px',
                                    background: 'var(--field-gold)',
                                    color: '#fff',
                                    textTransform: 'uppercase',
                                    fontSize: '0.75rem',
                                    fontWeight: 700,
                                    letterSpacing: '0.2em',
                                    textDecoration: 'none',
                                    transition: 'all 0.4s ease',
                                    marginBottom: '12px',
                                }}
                            >
                                Book This Expedition <ArrowRight size={16} />
                            </Link>

                            <Link
                                href="/safaris/packages"
                                style={{
                                    display: 'flex',
                                    alignItems: 'center',
                                    justifyContent: 'center',
                                    gap: '10px',
                                    width: '100%',
                                    padding: '16px',
                                    border: '1px solid rgba(255,255,255,0.15)',
                                    color: 'rgba(255,255,255,0.7)',
                                    textTransform: 'uppercase',
                                    fontSize: '0.7rem',
                                    fontWeight: 600,
                                    letterSpacing: '0.15em',
                                    textDecoration: 'none',
                                    transition: 'all 0.3s ease',
                                }}
                            >
                                View All Packages
                            </Link>
                        </motion.div>

                        {/* Inclusions */}
                        {pkg.inclusions && pkg.inclusions.length > 0 && (
                            <motion.div
                                initial="hidden"
                                whileInView="visible"
                                viewport={{ once: true }}
                                variants={fadeInUp}
                                style={{
                                    background: '#fff',
                                    border: '1px solid var(--field-border)',
                                    padding: '36px 28px',
                                    marginBottom: '24px',
                                }}
                            >
                                <h3 style={{
                                    fontFamily: 'var(--field-serif)',
                                    fontSize: '1.3rem',
                                    color: 'var(--field-dark)',
                                    marginBottom: '24px',
                                    paddingBottom: '16px',
                                    borderBottom: '1px solid var(--field-border)',
                                }}>What's Included</h3>
                                <ul style={{ listStyle: 'none', padding: 0, margin: 0 }}>
                                    {pkg.inclusions.map((inc, i) => (
                                        <li key={i} style={{
                                            display: 'flex',
                                            alignItems: 'flex-start',
                                            gap: '12px',
                                            padding: '10px 0',
                                            fontSize: '0.88rem',
                                            color: 'var(--field-ink)',
                                            lineHeight: 1.5,
                                        }}>
                                            <Check size={15} style={{ color: 'var(--field-green)', marginTop: '3px', flexShrink: 0 }} />
                                            {inc}
                                        </li>
                                    ))}
                                </ul>
                            </motion.div>
                        )}

                        {/* Exclusions */}
                        {pkg.exclusions && pkg.exclusions.length > 0 && (
                            <motion.div
                                initial="hidden"
                                whileInView="visible"
                                viewport={{ once: true }}
                                variants={fadeInUp}
                                style={{
                                    background: '#fff',
                                    border: '1px solid var(--field-border)',
                                    padding: '36px 28px',
                                }}
                            >
                                <h3 style={{
                                    fontFamily: 'var(--field-serif)',
                                    fontSize: '1.3rem',
                                    color: 'var(--field-dark)',
                                    marginBottom: '24px',
                                    paddingBottom: '16px',
                                    borderBottom: '1px solid var(--field-border)',
                                }}>Not Included</h3>
                                <ul style={{ listStyle: 'none', padding: 0, margin: 0 }}>
                                    {pkg.exclusions.map((exc, i) => (
                                        <li key={i} style={{
                                            display: 'flex',
                                            alignItems: 'flex-start',
                                            gap: '12px',
                                            padding: '10px 0',
                                            fontSize: '0.88rem',
                                            color: 'var(--field-mid)',
                                            lineHeight: 1.5,
                                        }}>
                                            <X size={15} style={{ color: 'var(--field-warm)', marginTop: '3px', flexShrink: 0 }} />
                                            {exc}
                                        </li>
                                    ))}
                                </ul>
                            </motion.div>
                        )}
                    </div>
                </div>
            </section>

            {/* ─── PULL QUOTE ─── */}
            <section className="field-pullquote">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <p className="field-pullquote-text">
                        "Every safari is a story waiting to be told. The crack of dawn over the Serengeti, the rumble of elephants at dusk, the silence of the bush at midnight — these are the moments that stay with you forever."
                    </p>
                    <span className="field-pullquote-attr">Tanzania Sensational</span>
                </motion.div>
            </section>

            {/* ─── FINAL CTA ─── */}
            <section className="field-cta">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <h2 className="field-cta-title">Begin Your <em>Expedition</em></h2>
                    <p className="field-cta-body">
                        Ready to experience this safari for yourself? Our expedition specialists will craft
                        every detail to match your travel style, interests, and pace.
                    </p>
                    <div style={{ display: 'flex', gap: '20px', justifyContent: 'center', flexWrap: 'wrap' }}>
                        <Link href={`/booking/safari/${pkg.slug}`} className="field-btn">
                            Book This Safari <ArrowRight size={16} />
                        </Link>
                        <Link href="/contact" className="field-btn" style={{ borderColor: 'var(--field-gold)', color: 'var(--field-gold)' }}>
                            Speak to a Specialist
                        </Link>
                    </div>
                </motion.div>
            </section>
        </div>
    );
};

export default SafariPackageDetail;
