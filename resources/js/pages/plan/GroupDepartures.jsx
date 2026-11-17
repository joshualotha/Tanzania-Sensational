import React, { useMemo, useState } from 'react';
import { motion } from 'framer-motion';
import { Sun, CloudRain, Snowflake, ThermometerSun } from 'lucide-react';
import { Link, router } from '@inertiajs/react';
import { usePage } from '@inertiajs/react';
import { Calendar, Users, Map, DollarSign, ChevronRight, Mountain, Eye, Send } from 'lucide-react';
import { visualsData } from '../../data/visualsData';
import '../../styles/group-departures-premium.css';

const GroupDepartures = ({ departures }) => {
    const { props } = usePage();
    const visuals = props.visuals;

    const getVisual = (section, fallback) => {
        if (visuals?.[section]?.[0]) return visuals[section][0];
        return fallback;
    };

    const getNextRecurringDate = (dateStr) => {
        const date = new Date(dateStr);
        const now = new Date();
        if (date >= now) return date;
        const next = new Date(date);
        let attempts = 0;
        while (next < now && attempts < 52) {
            next.setDate(next.getDate() + 7);
            attempts++;
        }
        return next >= now ? next : null;
    };

    const rows = useMemo(() => {
        return (departures || [])
            .map((dep) => {
                const start = getNextRecurringDate(dep.departure_date);
                if (!start) return null;
            const end = dep.return_date ? new Date(dep.return_date) : null;
            const dateLabel = `${start.toLocaleDateString(undefined, { month: 'short', day: 'numeric' })} – ${(end || start).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' })}`;

            const price = `$${Math.round((dep.price_cents || 0) / 100).toLocaleString()}`;
            const routeName = dep.trekking_route?.name ? `${dep.trekking_route.name} Route` : 'Route TBA';
            const status = (dep.status || 'Available');
            const spotsLeft = (dep.remaining_seats ?? dep.available_seats ?? 0);

            const getRouteUrl = (slug) => {
                if (!slug) return '#';
                if (slug.includes('lemosho')) return '/trekking/kilimanjaro/lemosho';
                if (slug.includes('machame')) return '/trekking/kilimanjaro/machame';
                if (slug.includes('marangu')) return '/trekking/kilimanjaro/marangu';
                if (slug.includes('rongai')) return '/trekking/kilimanjaro/rongai';
                if (slug.includes('northern')) return '/trekking/kilimanjaro/northern-circuit';
                if (slug.includes('umbwe')) return '/trekking/kilimanjaro/umbwe';
                return `/trekking/kilimanjaro/${slug}`;
            };

            const packageUrl = getRouteUrl(dep.trekking_route?.slug);

            return {
                id: String(dep.id),
                dateLabel,
                routeName,
                price,
                status,
                spotsLeft,
                packageUrl,
            };
        })
        .filter(Boolean)
        .sort((a, b) => {
            const aDate = new Date(a.dateLabel.split('–')[0].trim());
            const bDate = new Date(b.dateLabel.split('–')[0].trim());
            return aDate - bDate;
        });
    }, [departures]);

    const fadeInUp = {
        hidden: { opacity: 0, y: 40 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    const staggerContainer = {
        hidden: { opacity: 1 },
        visible: {
            opacity: 1,
            transition: {
                staggerChildren: 0.1
            }
        }
    };

    return (
        <div className="utility-root">
            {/* ─── CINEMATIC HERO ─── */}
            <section className="gd-hero">
                <div className="gd-hero-bg">
                    <img
                        src={getVisual('trekking.groupDeparturesHero', visualsData.trekking.groupDeparturesHero)}
                        alt="Kilimanjaro expedition team — group of trekkers and guides preparing for summit climb"
                    />
                    <div className="gd-hero-gradient"></div>
                </div>
                <motion.div 
                    className="gd-hero-content" 
                    initial="hidden" animate="visible" 
                    variants={{ visible: { transition: { staggerChildren: 0.12 } } }}
                >
                    <motion.span className="gd-hero-eyebrow" variants={fadeInUp}>
                        <Users size={14} /> Open Expedition
                    </motion.span>
                    <motion.h1 className="gd-hero-title" variants={fadeInUp}>
                        Expedition <em>Schedule.</em>
                    </motion.h1>
                    <motion.p className="gd-hero-subtitle" variants={fadeInUp}>
                        Share the triumph. Our scheduled group climbs are capped at 12 participants to ensure a personalized, safe, and wildly successful summit bid.
                    </motion.p>
                </motion.div>
            </section>

            {/* THE SCHEDULE LEDGER */}
            <section className="utility-content">
                <motion.div 
                    className="ledger-wrapper"
                    initial="hidden" whileInView="visible" viewport={{ once: true }}
                    variants={fadeInUp}
                >
                    <table className="dep-table desktop-only">
                        <thead>
                            <tr>
                                <th>Dates</th>
                                <th>Route Expedition</th>
                                <th>Investment</th>
                                <th>Status</th>
                                <th>Spots left</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <motion.tbody variants={staggerContainer} initial="hidden" animate="visible">
                            {rows.length === 0 ? (
                                <motion.tr className="dep-row" variants={fadeInUp}>
                                    <td colSpan={6} style={{ padding: '40px 30px', textAlign: 'center' }}>
                                        <p style={{ color: '#7a6f65', marginBottom: '20px', fontSize: '0.95rem' }}>
                                            No group departures available at the moment.
                                        </p>
                                        <Link href="/contact" className="btn-heritage-gold" style={{ display: 'inline-flex', alignItems: 'center', gap: '8px' }}>
                                            Request Private Expedition <Send size={14} />
                                        </Link>
                                    </td>
                                </motion.tr>
                            ) : (
                                rows.map((dep) => (
                                    <motion.tr key={dep.id} className="dep-row" variants={fadeInUp}>
                                        <td className="dep-date" data-label="Dates">
                                            {dep.dateLabel}
                                        </td>
                                        <td className="dep-route" data-label="Route Expedition">
                                            {dep.routeName}
                                        </td>
                                        <td className="dep-price" data-label="Investment">
                                            <span>From</span>{dep.price}
                                        </td>
                                        <td data-label="Status">
                                            <span className={`dep-status ${(dep.status || 'available').toLowerCase()}`}>
                                                {dep.status}
                                            </span>
                                        </td>
                                        <td className="dep-price" style={{ fontFamily: 'var(--font-mono)' }} data-label="Spots left">
                                            {Number(dep.spotsLeft) > 0 ? dep.spotsLeft : 'FULL'}
                                        </td>
                                        <td data-label="Action">
                                            <div style={{ display: 'flex', gap: '8px', alignItems: 'center' }}>
                                                <Link href={dep.packageUrl} className="dep-action-btn" style={{ display: 'inline-flex', alignItems: 'center', gap: '4px' }}>
                                                    Details <Eye size={12} />
                                                </Link>
                                                {dep.status !== 'Full' ? (
                                                    <Link href={`/group-departures/${dep.id}`} className="dep-action-btn" style={{ display: 'inline-flex', alignItems: 'center', gap: '4px' }}>
                                                        Reserve <ChevronRight size={12} />
                                                    </Link>
                                                ) : (
                                                    <span style={{ color: '#999', fontSize: '0.6rem', textTransform: 'uppercase', letterSpacing: '0.1em', fontWeight: 700 }}>
                                                        Waitlist
                                                    </span>
                                                )}
                                            </div>
                                        </td>
                                    </motion.tr>
                                ))
                            )}
                        </motion.tbody>
                    </table>

                    {/* ─── PREMIUM MOBILE CARDS (NATIVE-FEEL) ─── */}
                    <div className="dep-cards mobile-only">
                        {rows.length === 0 ? (
                            <motion.div className="dep-card" variants={fadeInUp}>
                                <div className="dep-card-body" style={{ textAlign: 'center', justifyContent: 'center', flexDirection: 'column', gap: '16px' }}>
                                    <p style={{ color: '#7a6f65', fontSize: '0.95rem' }}>
                                        No group departures available at the moment.
                                    </p>
                                    <Link href="/contact" className="btn-heritage-gold" style={{ display: 'inline-flex', alignItems: 'center', gap: '8px', justifyContent: 'center' }}>
                                        Request Private Expedition <Send size={14} />
                                    </Link>
                                </div>
                            </motion.div>
                        ) : (
                            rows.map((dep) => (
                                <motion.div key={dep.id} className="dep-card" variants={fadeInUp}>
                                    <div className="dep-card-header">
                                        <div className="dep-card-date">
                                            <Calendar size={18} className="gold-icon" />
                                            <span>{dep.dateLabel}</span>
                                        </div>
                                        <div className="dep-card-route">
                                            <Map size={15} className="gold-icon" />
                                            <span>{dep.routeName}</span>
                                        </div>
                                    </div>

                                    <div className="dep-card-body">
                                        <div className="dep-card-metric">
                                            <span className="metric-label">Investment</span>
                                            <span className="metric-value"><span>From</span> {dep.price}</span>
                                        </div>
                                        <div className="dep-card-metric">
                                            <span className="metric-label">Spots left</span>
                                            <span className="metric-value mono">{Number(dep.spotsLeft) > 0 ? dep.spotsLeft : 'FULL'}</span>
                                        </div>
                                    </div>

                                    <div className="dep-card-footer">
                                        <span className={`dep-status ${(dep.status || 'available').toLowerCase()}`}>
                                            {dep.status}
                                        </span>
                                        <div className={`dep-card-actions ${dep.status === 'Full' ? 'single' : ''}`}>
                                            <Link href={dep.packageUrl} className="dep-btn-outline">
                                                Details
                                            </Link>
                                            {dep.status !== 'Full' && (
                                                <Link href={`/group-departures/${dep.id}`} className="dep-btn-fill">
                                                    Reserve
                                                </Link>
                                            )}
                                        </div>
                                    </div>
                                </motion.div>
                            ))
                        )}
                    </div>
                </motion.div>

                {/* PRIVATE EXPEDITION CTA */}
                <motion.div 
                    className="private-exp-cta"
                    initial="hidden" whileInView="visible" viewport={{ once: true }}
                    variants={fadeInUp}
                >
                    <h3 className="private-cta-title">Private <em>Trek</em></h3>
                    <p className="private-cta-text">
                        If you have a group of 2 or more, we can arrange a private climb starting on any date of your choosing, via any route. Professional guides, dedicated crew, and absolute privacy.
                    </p>
                    <Link href="/contact" className="btn-heritage-gold">
                        Request Private Expedition
                    </Link>
                </motion.div>
            </section>
        </div>
    );
};

export default GroupDepartures;
