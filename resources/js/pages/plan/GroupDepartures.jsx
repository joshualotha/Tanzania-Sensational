import React, { useEffect, useMemo, useState } from 'react';
import { motion } from 'framer-motion';
import { Sun, CloudRain, Snowflake, ThermometerSun } from 'lucide-react';
import { Link } from 'react-router-dom';
import { Calendar, Users, Map, DollarSign, ChevronRight, Mountain, Eye } from 'lucide-react';
import { departureService } from '../../services/api';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import '../../styles/group-departures-premium.css';

export const GroupDepartures = () => {
    const [departures, setDepartures] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);
    const visuals = useVisuals();

    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    useEffect(() => {
        let mounted = true;
        const run = async () => {
            setLoading(true);
            setError(null);
            try {
                const res = await departureService.getAll();
                if (!mounted) return;
                setDepartures(Array.isArray(res.data) ? res.data : []);
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
    }, []);

    const rows = useMemo(() => {
        return departures.map((dep) => {
            const start = dep.departure_date ? new Date(dep.departure_date) : null;
            const end = dep.return_date ? new Date(dep.return_date) : null;
            const dateLabel = start
                ? `${start.toLocaleDateString(undefined, { month: 'short', day: 'numeric' })} – ${(end || start).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' })}`
                : 'TBA';

            const price = `$${Math.round((dep.price_cents || 0) / 100).toLocaleString()}`;
            const routeName = dep.trekking_route?.name ? `${dep.trekking_route.name} Route` : 'Route TBA';
            const status = (dep.status || 'Available');
            const spotsLeft = (dep.remaining_seats ?? dep.available_seats ?? 0);

            return {
                id: String(dep.id),
                dateLabel,
                routeName,
                price,
                status,
                spotsLeft,
            };
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
                        src={visuals.getSingle('trekking.prep.parkFeesEditorial', visualsData.trekking.prep.parkFeesEditorial)} 
                        alt="Expedition Team" 
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
                    <table className="dep-table">
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
                            {loading ? (
                                [1, 2, 3, 4].map((i) => (
                                    <motion.tr key={i} className="dep-row" variants={fadeInUp}>
                                        <td className="dep-date" style={{ opacity: 0.5 }}>Loading…</td>
                                        <td className="dep-route" style={{ opacity: 0.5 }}>Loading…</td>
                                        <td className="dep-price" style={{ opacity: 0.5 }}>—</td>
                                        <td><span className="dep-status available" style={{ opacity: 0.5 }}>Loading</span></td>
                                        <td>—</td>
                                    </motion.tr>
                                ))
                            ) : error ? (
                                <motion.tr className="dep-row" variants={fadeInUp}>
                                    <td colSpan={6} style={{ padding: '30px', textAlign: 'center', color: '#7a6f65' }}>
                                        Couldn’t load departures right now. Please refresh or try again in a moment.
                                    </td>
                                </motion.tr>
                            ) : rows.length === 0 ? (
                                <motion.tr className="dep-row" variants={fadeInUp}>
                                    <td colSpan={6} style={{ padding: '30px', textAlign: 'center', color: '#7a6f65' }}>
                                        No group departures are currently scheduled.
                                    </td>
                                </motion.tr>
                            ) : (
                                rows.map((dep) => (
                                    <motion.tr key={dep.id} className="dep-row" variants={fadeInUp}>
                                        <td className="dep-date">
                                            {dep.dateLabel}
                                        </td>
                                        <td className="dep-route">
                                            {dep.routeName}
                                        </td>
                                        <td className="dep-price">
                                            <span>From</span>{dep.price}
                                        </td>
                                        <td>
                                            <span className={`dep-status ${(dep.status || 'available').toLowerCase()}`}>
                                                {dep.status}
                                            </span>
                                        </td>
                                        <td className="dep-price" style={{ fontFamily: 'var(--font-mono)' }}>
                                            {Number(dep.spotsLeft) > 0 ? dep.spotsLeft : 'FULL'}
                                        </td>
                                        <td>
                                            <div style={{ display: 'flex', gap: '8px', alignItems: 'center' }}>
                                                <Link to={`/group-departures/${dep.id}`} className="dep-action-btn" style={{ display: 'inline-flex', alignItems: 'center', gap: '4px' }}>
                                                    Details <Eye size={12} />
                                                </Link>
                                                {dep.status !== 'Full' ? (
                                                    <Link to={`/group-departures/${dep.id}`} className="dep-action-btn" style={{ display: 'inline-flex', alignItems: 'center', gap: '4px' }}>
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
                    <Link to="/contact" className="btn-heritage-gold">
                        Request Private Expedition
                    </Link>
                </motion.div>
            </section>
        </div>
    );
};
