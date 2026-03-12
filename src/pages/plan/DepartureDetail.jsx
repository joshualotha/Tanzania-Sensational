import React, { useEffect } from 'react';
import { useParams, Navigate, Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Calendar, Users, Mountain, MapPin, Clock, DollarSign, Check, X as XIcon, ArrowRight, ChevronLeft, AlertTriangle } from 'lucide-react';
import { departuresData } from '../../data/departuresData';
import '../../styles/group-departures-premium.css';

export const DepartureDetail = () => {
    const { departureId } = useParams();
    const dep = departuresData.find(d => d.id === departureId);

    useEffect(() => {
        window.scrollTo(0, 0);
    }, [departureId]);

    if (!dep) {
        return <Navigate to="/group-departures" replace />;
    }

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    const stagger = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.1 } }
    };

    return (
        <div className="utility-root">
            {/* HERO */}
            <section className="utility-hero" style={{ minHeight: '65vh' }}>
                <div className="utility-hero-bg">
                    <img src={dep.heroImg} alt={dep.route} />
                </div>
                <div className="utility-hero-overlay"></div>
                <motion.div className="utility-hero-content" initial="hidden" animate="visible" variants={fadeInUp}>
                    <Link to="/group-departures" style={{ display: 'inline-flex', alignItems: 'center', gap: '6px', color: 'var(--gold)', fontSize: '0.75rem', textTransform: 'uppercase', letterSpacing: '0.15em', fontWeight: 600, marginBottom: '20px', textDecoration: 'none' }}>
                        <ChevronLeft size={14} /> All Departures
                    </Link>
                    <div className="heritage-type-badge">
                        <Users size={14} />
                        <span>{dep.groupSize}</span>
                    </div>
                    <h1 className="utility-hero-title" style={{ fontSize: 'clamp(2rem, 5vw, 3.5rem)' }}>{dep.route}</h1>
                    <p className="utility-hero-subtitle" style={{ maxWidth: '700px' }}>{dep.date}</p>
                </motion.div>
            </section>

            {/* QUICK STATS STRIP */}
            <section style={{ background: 'var(--dark)', borderBottom: '1px solid rgba(255,255,255,0.08)' }}>
                <div style={{ maxWidth: '1100px', margin: '0 auto', display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(150px, 1fr))', gap: '0' }}>
                    <StatItem icon={<Calendar size={16} />} label="Summit Night" value={dep.summitNight} />
                    <StatItem icon={<Mountain size={16} />} label="Difficulty" value={dep.difficulty} />
                    <StatItem icon={<Users size={16} />} label="Group Size" value={dep.groupSize} />
                    <StatItem icon={<DollarSign size={16} />} label="Investment" value={dep.price + " pp"} />
                    <StatItem icon={<AlertTriangle size={16} />} label="Spots Left" value={dep.spotsLeft > 0 ? `${dep.spotsLeft} remaining` : "FULL"} highlight={dep.spotsLeft <= 3} />
                </div>
            </section>

            {/* MAIN CONTENT */}
            <section style={{ background: 'var(--bg-parchment)', padding: '80px 40px' }}>
                <div style={{ maxWidth: '1100px', margin: '0 auto', display: 'grid', gridTemplateColumns: '1fr 380px', gap: '60px' }}>
                    
                    {/* LEFT COLUMN */}
                    <div>
                        {/* DESCRIPTION */}
                        <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                            <h2 style={{ fontFamily: 'Playfair Display, serif', fontSize: '1.8rem', color: 'var(--dark)', marginBottom: '20px' }}>About This Expedition</h2>
                            <p style={{ lineHeight: 1.8, color: '#4a3f35', fontSize: '1rem' }}>{dep.description}</p>
                        </motion.div>

                        {/* HIGHLIGHTS */}
                        <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp} style={{ marginTop: '50px' }}>
                            <h3 style={{ fontFamily: 'Playfair Display, serif', fontSize: '1.3rem', color: 'var(--dark)', marginBottom: '20px' }}>Expedition Highlights</h3>
                            <ul style={{ listStyle: 'none', padding: 0 }}>
                                {dep.highlights.map((h, i) => (
                                    <li key={i} style={{ display: 'flex', alignItems: 'flex-start', gap: '12px', marginBottom: '14px', color: '#4a3f35', lineHeight: 1.6 }}>
                                        <Check size={16} color="var(--gold)" style={{ flexShrink: 0, marginTop: '3px' }} />
                                        {h}
                                    </li>
                                ))}
                            </ul>
                        </motion.div>

                        {/* ITINERARY */}
                        <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp} style={{ marginTop: '50px' }}>
                            <h3 style={{ fontFamily: 'Playfair Display, serif', fontSize: '1.3rem', color: 'var(--dark)', marginBottom: '25px' }}>Route Itinerary</h3>
                            {dep.itinerarySummary.map((day, i) => (
                                <div key={i} style={{ display: 'grid', gridTemplateColumns: '50px 1fr auto', gap: '15px', alignItems: 'center', padding: '14px 0', borderBottom: '1px solid rgba(0,0,0,0.06)' }}>
                                    <span style={{ fontWeight: 700, color: 'var(--gold)', fontSize: '0.75rem', textTransform: 'uppercase' }}>Day {day.day}</span>
                                    <span style={{ color: 'var(--dark)', fontWeight: 500 }}>{day.title}</span>
                                    <span style={{ fontSize: '0.75rem', color: '#8a7e72', fontFamily: 'monospace', whiteSpace: 'nowrap' }}>{day.elevation}</span>
                                </div>
                            ))}
                        </motion.div>

                        {/* INCLUSIONS & EXCLUSIONS */}
                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '40px', marginTop: '50px' }}>
                            <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                                <h3 style={{ fontFamily: 'Playfair Display, serif', fontSize: '1.2rem', color: 'var(--dark)', marginBottom: '18px' }}>Inclusions</h3>
                                <ul style={{ listStyle: 'none', padding: 0 }}>
                                    {dep.inclusions.map((inc, i) => (
                                        <li key={i} style={{ display: 'flex', alignItems: 'flex-start', gap: '10px', marginBottom: '10px', fontSize: '0.85rem', color: '#4a3f35', lineHeight: 1.5 }}>
                                            <Check size={14} color="#38A169" style={{ flexShrink: 0, marginTop: '2px' }} />
                                            {inc}
                                        </li>
                                    ))}
                                </ul>
                            </motion.div>
                            <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                                <h3 style={{ fontFamily: 'Playfair Display, serif', fontSize: '1.2rem', color: 'var(--dark)', marginBottom: '18px' }}>Exclusions</h3>
                                <ul style={{ listStyle: 'none', padding: 0 }}>
                                    {dep.exclusions.map((exc, i) => (
                                        <li key={i} style={{ display: 'flex', alignItems: 'flex-start', gap: '10px', marginBottom: '10px', fontSize: '0.85rem', color: '#4a3f35', lineHeight: 1.5 }}>
                                            <XIcon size={14} color="#E53E3E" style={{ flexShrink: 0, marginTop: '2px' }} />
                                            {exc}
                                        </li>
                                    ))}
                                </ul>
                            </motion.div>
                        </div>
                    </div>

                    {/* RIGHT SIDEBAR */}
                    <div>
                        <div style={{ position: 'sticky', top: '120px' }}>
                            {/* BOOKING CARD */}
                            <div style={{ background: 'var(--dark)', color: 'white', padding: '35px 30px', borderRadius: '4px', marginBottom: '20px' }}>
                                <div style={{ fontSize: '0.65rem', color: 'var(--gold)', letterSpacing: '0.2em', textTransform: 'uppercase', marginBottom: '8px' }}>Per Person</div>
                                <div style={{ fontSize: '2.5rem', fontWeight: 600, marginBottom: '5px' }}>{dep.price}</div>
                                <div style={{ fontSize: '0.8rem', color: 'rgba(255,255,255,0.5)', marginBottom: '30px' }}>All-inclusive mountain package</div>

                                <div style={{ borderTop: '1px solid rgba(255,255,255,0.1)', paddingTop: '20px', marginBottom: '25px' }}>
                                    <DetailRow label="Date" value={dep.date} />
                                    <DetailRow label="Summit Night" value={dep.summitNight} />
                                    <DetailRow label="Briefing" value={dep.briefingDate} />
                                    <DetailRow label="Meeting Point" value={dep.meetingPoint} />
                                    <DetailRow label="Spots Left" value={dep.spotsLeft > 0 ? `${dep.spotsLeft} of 12` : "FULL"} />
                                </div>

                                {dep.status !== 'Full' ? (
                                    <Link to="/contact" style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '10px', background: 'var(--gold)', color: 'var(--dark)', padding: '14px', fontWeight: 700, textDecoration: 'none', textTransform: 'uppercase', letterSpacing: '0.1em', fontSize: '0.8rem' }}>
                                        Reserve Your Spot <ArrowRight size={16} />
                                    </Link>
                                ) : (
                                    <div style={{ textAlign: 'center', padding: '14px', border: '1px solid rgba(255,255,255,0.15)', color: 'rgba(255,255,255,0.5)', fontSize: '0.8rem', textTransform: 'uppercase', letterSpacing: '0.1em' }}>
                                        Join Waitlist
                                    </div>
                                )}
                            </div>

                            {/* STATUS BADGE */}
                            <div style={{ background: dep.status === 'Available' ? 'rgba(56,161,105,0.1)' : dep.status === 'Limited' ? 'rgba(201,168,76,0.1)' : 'rgba(229,62,62,0.1)', border: `1px solid ${dep.status === 'Available' ? 'rgba(56,161,105,0.3)' : dep.status === 'Limited' ? 'rgba(201,168,76,0.3)' : 'rgba(229,62,62,0.3)'}`, padding: '16px 20px', textAlign: 'center', fontSize: '0.75rem', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.15em', color: dep.status === 'Available' ? '#38A169' : dep.status === 'Limited' ? 'var(--gold)' : '#E53E3E' }}>
                                {dep.status === 'Available' ? '✓ Spaces Available' : dep.status === 'Limited' ? '⚠ Limited Availability' : '✕ Fully Booked'}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    );
};

/* HELPER COMPONENTS */
const StatItem = ({ icon, label, value, highlight }) => (
    <div style={{ padding: '20px 25px', borderRight: '1px solid rgba(255,255,255,0.05)', textAlign: 'center' }}>
        <div style={{ color: highlight ? '#E53E3E' : 'var(--gold)', marginBottom: '6px' }}>{icon}</div>
        <div style={{ fontSize: '0.6rem', color: 'rgba(255,255,255,0.4)', textTransform: 'uppercase', letterSpacing: '0.1em', marginBottom: '4px' }}>{label}</div>
        <div style={{ color: highlight ? '#E53E3E' : 'white', fontWeight: 600, fontSize: '0.85rem' }}>{value}</div>
    </div>
);

const DetailRow = ({ label, value }) => (
    <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '12px', fontSize: '0.8rem' }}>
        <span style={{ color: 'rgba(255,255,255,0.5)' }}>{label}</span>
        <span style={{ fontWeight: 500, textAlign: 'right', maxWidth: '60%' }}>{value}</span>
    </div>
);
