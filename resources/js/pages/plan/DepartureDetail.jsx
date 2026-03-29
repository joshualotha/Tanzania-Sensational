import React, { useEffect, useMemo, useState } from 'react';
import { useParams, Navigate, Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { Calendar, Users, Mountain, MapPin, Clock, DollarSign, Check, X as XIcon, ArrowRight, ChevronLeft, AlertTriangle } from 'lucide-react';
import { departureService } from '../../services/api';
import '../../styles/group-departures-premium.css';

export const DepartureDetail = () => {
    const { departureId } = useParams();
    const [dep, setDep] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        window.scrollTo(0, 0);
    }, [departureId]);

    useEffect(() => {
        let mounted = true;
        const run = async () => {
            setLoading(true);
            setError(null);
            try {
                const res = await departureService.getById(departureId);
                if (!mounted) return;
                setDep(res.data || null);
            } catch (e) {
                if (!mounted) return;
                setError(e);
            } finally {
                if (!mounted) return;
                setLoading(false);
            }
        };
        run();
        return () => { mounted = false; };
    }, [departureId]);

    const viewModel = useMemo(() => {
        if (!dep) return null;

        const start = dep.departure_date ? new Date(dep.departure_date) : null;
        const end = dep.return_date ? new Date(dep.return_date) : null;
        const dateLabel = start
            ? `${start.toLocaleDateString(undefined, { month: 'short', day: 'numeric' })} – ${(end || start).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' })}`
            : 'TBA';

        const priceNumber = Math.round((dep.price_cents || 0) / 100);
        const priceLabel = `$${priceNumber.toLocaleString()}`;

        const totalSeats = (dep.total_seats ?? ((dep.available_seats ?? 0) + (dep.booked_seats ?? 0)));
        const spotsLeft = (dep.remaining_seats ?? dep.available_seats ?? 0);

        const itinerary = dep.trekking_route?.itinerary_days || dep.trekking_route?.itineraryDays || [];
        const itinerarySummary = Array.isArray(itinerary)
            ? itinerary.slice(0, 10).map((d) => ({
                day: d.day_number ?? d.day ?? '?',
                title: d.title ?? d.name ?? 'Day',
                elevation: d.elevation ?? d.elevation_m ?? '',
            }))
            : [];

        return {
            heroImg: dep.trekking_route?.hero_image,
            routeTitle: dep.trekking_route?.name ? `${dep.trekking_route.name} Route` : 'Group Departure',
            dateLabel,
            summitNight: dep.summit_night || 'TBA',
            difficulty: dep.trekking_route?.difficulty || 'TBA',
            groupSize: totalSeats ? `Up to ${totalSeats}` : 'Group',
            priceLabel,
            status: dep.status || 'Available',
            spotsLeft,
            briefingDate: dep.briefing_date || 'TBA',
            meetingPoint: dep.meeting_point || 'TBA',
            description: dep.description || 'Details coming soon.',
            highlights: Array.isArray(dep.trekking_route?.highlights) ? dep.trekking_route.highlights : [],
            itinerarySummary,
            inclusions: Array.isArray(dep.inclusions) ? dep.inclusions : [],
            exclusions: Array.isArray(dep.exclusions) ? dep.exclusions : [],
        };
    }, [dep]);

    if (!loading && (error || !viewModel)) {
        return <Navigate to="/group-departures" replace />;
    }

    if (loading || !viewModel) {
        return (
            <div className="utility-root">
                <section className="utility-hero" style={{ minHeight: '65vh' }}>
                    <div className="utility-hero-bg" />
                    <div className="utility-hero-overlay" />
                    <div className="utility-hero-content">
                        <Link to="/group-departures" style={{ display: 'inline-flex', alignItems: 'center', gap: '6px', color: 'var(--gold)', fontSize: '0.75rem', textTransform: 'uppercase', letterSpacing: '0.15em', fontWeight: 600, marginBottom: '20px', textDecoration: 'none' }}>
                            <ChevronLeft size={14} /> All Departures
                        </Link>
                        <h1 className="utility-hero-title" style={{ fontSize: 'clamp(2rem, 5vw, 3.5rem)' }}>Loading…</h1>
                    </div>
                </section>
            </div>
        );
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
                    <img src={viewModel.heroImg} alt={viewModel.routeTitle} />
                </div>
                <div className="utility-hero-overlay"></div>
                <motion.div className="utility-hero-content" initial="hidden" animate="visible" variants={fadeInUp}>
                    <Link to="/group-departures" style={{ display: 'inline-flex', alignItems: 'center', gap: '6px', color: 'var(--gold)', fontSize: '0.75rem', textTransform: 'uppercase', letterSpacing: '0.15em', fontWeight: 600, marginBottom: '20px', textDecoration: 'none' }}>
                        <ChevronLeft size={14} /> All Departures
                    </Link>
                    <div className="heritage-type-badge">
                        <Users size={14} />
                        <span>{viewModel.groupSize}</span>
                    </div>
                    <h1 className="utility-hero-title" style={{ fontSize: 'clamp(2rem, 5vw, 3.5rem)' }}>{viewModel.routeTitle}</h1>
                    <p className="utility-hero-subtitle" style={{ maxWidth: '700px' }}>{viewModel.dateLabel}</p>
                </motion.div>
            </section>

            {/* QUICK STATS STRIP */}
            <section style={{ background: 'var(--dark)', borderBottom: '1px solid rgba(255,255,255,0.08)' }}>
                <div className="dep-detail-stats">
                    <StatItem icon={<Calendar size={16} />} label="Summit Night" value={viewModel.summitNight} />
                    <StatItem icon={<Mountain size={16} />} label="Difficulty" value={viewModel.difficulty} />
                    <StatItem icon={<Users size={16} />} label="Group Size" value={viewModel.groupSize} />
                    <StatItem icon={<DollarSign size={16} />} label="Investment" value={viewModel.priceLabel + " pp"} />
                    <StatItem icon={<AlertTriangle size={16} />} label="Spots Left" value={viewModel.spotsLeft > 0 ? `${viewModel.spotsLeft} remaining` : "FULL"} highlight={viewModel.spotsLeft <= 3} />
                </div>
            </section>

            {/* MAIN CONTENT */}
            <section className="dep-detail-section">
                <div className="dep-detail-main">
                    
                    {/* LEFT COLUMN */}
                    <div>
                        {/* DESCRIPTION */}
                        <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                            <h2 style={{ fontFamily: 'Playfair Display, serif', fontSize: '1.8rem', color: 'var(--dark)', marginBottom: '20px' }}>About This Expedition</h2>
                            <p style={{ lineHeight: 1.8, color: '#4a3f35', fontSize: '1rem' }}>{viewModel.description}</p>
                        </motion.div>

                        {/* HIGHLIGHTS */}
                        <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp} style={{ marginTop: '50px' }}>
                            <h3 style={{ fontFamily: 'Playfair Display, serif', fontSize: '1.3rem', color: 'var(--dark)', marginBottom: '20px' }}>Expedition Highlights</h3>
                            <ul style={{ listStyle: 'none', padding: 0 }}>
                                {viewModel.highlights.map((h, i) => (
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
                            {viewModel.itinerarySummary.map((day, i) => (
                                <div key={i} style={{ display: 'grid', gridTemplateColumns: '50px 1fr auto', gap: '15px', alignItems: 'center', padding: '14px 0', borderBottom: '1px solid rgba(0,0,0,0.06)' }}>
                                    <span style={{ fontWeight: 700, color: 'var(--gold)', fontSize: '0.75rem', textTransform: 'uppercase' }}>Day {day.day}</span>
                                    <span style={{ color: 'var(--dark)', fontWeight: 500 }}>{day.title}</span>
                                    <span style={{ fontSize: '0.75rem', color: '#8a7e72', fontFamily: 'monospace', whiteSpace: 'nowrap' }}>{day.elevation}</span>
                                </div>
                            ))}
                        </motion.div>

                        {/* INCLUSIONS & EXCLUSIONS */}
                        <div className="dep-detail-inc-exc">
                            <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                                <h3 style={{ fontFamily: 'Playfair Display, serif', fontSize: '1.2rem', color: 'var(--dark)', marginBottom: '18px' }}>Inclusions</h3>
                                <ul style={{ listStyle: 'none', padding: 0 }}>
                                    {viewModel.inclusions.map((inc, i) => (
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
                                    {viewModel.exclusions.map((exc, i) => (
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
                        <div className="dep-detail-sidebar-sticky">
                            {/* BOOKING CARD */}
                            <div style={{ background: 'var(--dark)', color: 'white', padding: '35px 30px', borderRadius: '4px', marginBottom: '20px' }}>
                                <div style={{ fontSize: '0.65rem', color: 'var(--gold)', letterSpacing: '0.2em', textTransform: 'uppercase', marginBottom: '8px' }}>Per Person</div>
                                <div style={{ fontSize: '2.5rem', fontWeight: 600, marginBottom: '5px' }}>{viewModel.priceLabel}</div>
                                <div style={{ fontSize: '0.8rem', color: 'rgba(255,255,255,0.5)', marginBottom: '30px' }}>All-inclusive mountain package</div>

                                <div style={{ borderTop: '1px solid rgba(255,255,255,0.1)', paddingTop: '20px', marginBottom: '25px' }}>
                                    <DetailRow label="Date" value={viewModel.dateLabel} />
                                    <DetailRow label="Summit Night" value={viewModel.summitNight} />
                                    <DetailRow label="Briefing" value={viewModel.briefingDate} />
                                    <DetailRow label="Meeting Point" value={viewModel.meetingPoint} />
                                    <DetailRow label="Spots Left" value={viewModel.spotsLeft > 0 ? `${viewModel.spotsLeft}` : "FULL"} />
                                </div>

                                {viewModel.status !== 'Full' ? (
                                    <Link
                                        to={`/booking/departure/${dep.id}`}
                                        style={{
                                            display: 'flex',
                                            alignItems: 'center',
                                            justifyContent: 'center',
                                            gap: '10px',
                                            width: '100%',
                                            background: 'var(--gold)',
                                            color: 'var(--dark)',
                                            padding: '14px',
                                            fontWeight: 700,
                                            textDecoration: 'none',
                                            textTransform: 'uppercase',
                                            letterSpacing: '0.1em',
                                            fontSize: '0.8rem',
                                            border: '1px solid var(--gold)',
                                            cursor: 'pointer',
                                        }}
                                    >
                                        Reserve Your Spot <ArrowRight size={16} />
                                    </Link>
                                ) : (
                                    <div style={{ textAlign: 'center', padding: '14px', border: '1px solid rgba(255,255,255,0.15)', color: 'rgba(255,255,255,0.5)', fontSize: '0.8rem', textTransform: 'uppercase', letterSpacing: '0.1em' }}>
                                        Join Waitlist
                                    </div>
                                )}
                            </div>

                            {/* STATUS BADGE */}
                            <div style={{ background: viewModel.status === 'Available' ? 'rgba(56,161,105,0.1)' : viewModel.status === 'Limited' ? 'rgba(201,168,76,0.1)' : 'rgba(229,62,62,0.1)', border: `1px solid ${viewModel.status === 'Available' ? 'rgba(56,161,105,0.3)' : viewModel.status === 'Limited' ? 'rgba(201,168,76,0.3)' : 'rgba(229,62,62,0.3)'}`, padding: '16px 20px', textAlign: 'center', fontSize: '0.75rem', fontWeight: 700, textTransform: 'uppercase', letterSpacing: '0.15em', color: viewModel.status === 'Available' ? '#38A169' : viewModel.status === 'Limited' ? 'var(--gold)' : '#E53E3E' }}>
                                {viewModel.status === 'Available' ? '✓ Spaces Available' : viewModel.status === 'Limited' ? '⚠ Limited Availability' : '✕ Fully Booked'}
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
