import React, { useEffect, useMemo, useState } from 'react';
import { useParams, Link, useNavigate, Navigate } from 'react-router-dom';
import { motion, useScroll, useTransform, AnimatePresence } from 'framer-motion';
import { LiveWeatherWidget, SafariCalendar, ElevationGraph } from './MountainIntegrations';
import { departureService } from '../../../services/api';
import '../../../styles/ultra-premium.css';

const PackageDetail = () => {
    const { routeId, packageId } = useParams();
    const navigate = useNavigate();
    const [departure, setDeparture] = useState(null);
    const [loading, setLoading] = useState(true);

    const { scrollY } = useScroll();
    const heroOpacity = useTransform(scrollY, [0, 500], [1, 0]);

    // Format data specifically for Recharts AreaChart
    const trek = departure?.trekking_route || null;
    const itineraryDays = trek?.itinerary_days || [];

    const chartData = useMemo(() => {
        if (!Array.isArray(itineraryDays) || itineraryDays.length === 0) return [];
        if (itineraryDays.every(d => !d.elevation_m && !d.elevation)) return [];
        return itineraryDays.map((day) => ({
            name: `Day ${day.day_number ?? day.day}`,
            elevation: day.elevation_m ?? day.elevation ?? 0,
            camp: (day.camp_name ?? day.accommodation ?? '').split(' (')[0],
        }));
    }, [itineraryDays]);

    useEffect(() => {
        window.scrollTo(0, 0);
        let mounted = true;
        const run = async () => {
            setLoading(true);
            try {
                const res = await departureService.getById(packageId);
                if (!mounted) return;
                setDeparture(res.data || null);
            } catch (e) {
                if (!mounted) return;
                setDeparture(null);
            } finally {
                if (!mounted) return;
                setLoading(false);
            }
        };
        run();
        return () => { mounted = false; };
    }, [packageId]);

    useEffect(() => {
        if (!loading && departure && trek?.slug && routeId && trek.slug !== routeId) {
            navigate(`/trekking/kilimanjaro/${trek.slug}/${packageId}`, { replace: true });
        }
    }, [departure, loading, navigate, packageId, routeId, trek?.slug]);

    if (loading) return (
        <div className="lux-root" style={{ minHeight: '100vh', display: 'grid', placeItems: 'center' }}>
            <div className="lux-heading">Loading…</div>
        </div>
    );

    if (!departure || !trek) {
        return <Navigate to="/group-departures" replace />;
    }

    const pkg = {
        departure_id: departure.id,
        departure_date: departure.departure_date,
        heroImg: trek.hero_image,
        title: `${trek.duration || ''} Days ${trek.name} Route`.trim(),
        overview: trek.description,
        duration: trek.duration ? `${trek.duration} Days` : 'Multi-day',
        difficulty: trek.difficulty,
        successRate: trek.success_rate,
        highlights: Array.isArray(trek.highlights) ? trek.highlights : [],
        itinerary: Array.isArray(itineraryDays) ? itineraryDays.map((d) => ({
            day: d.day_number ?? d.day,
            title: d.title ?? d.name ?? `Day ${d.day_number ?? d.day}`,
            desc: d.description ?? d.desc ?? '',
            elevation: d.elevation_m ?? d.elevation ?? null,
            distance: d.distance_km ? `${d.distance_km} km` : d.distance ?? null,
            hikingTime: d.hiking_time ?? null,
            habitat: d.habitat ?? null,
            accommodation: d.camp_name ?? d.accommodation ?? '',
            meals: d.meals ?? '',
        })) : [],
        inclusions: Array.isArray(departure.inclusions) ? departure.inclusions : [],
        exclusions: Array.isArray(departure.exclusions) ? departure.exclusions : [],
        base_price: (departure.price_cents || 0) / 100,
    };

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    return (
        <div className="lux-root">
            {/* ─── HERO ─── */}
            <motion.section className="lux-hero" style={{ height: '70vh', opacity: heroOpacity }}>
                <img src={pkg.heroImg} alt={pkg.title} />
                <div className="lux-hero-overlay"></div>
                <div className="lux-hero-content">
                    <motion.h1 className="lux-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>
                        {pkg.title}
                    </motion.h1>
                    <motion.div initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.2 }} style={{ marginTop: '30px', display: 'flex', gap: '20px', justifyContent: 'center' }}>
                        <Link to={`/booking/departure/${departure.id}`} className="lux-btn lux-btn-hero">
                            Book This Expedition
                        </Link>
                    </motion.div>
                </div>
            </motion.section>

            {/* ─── EXPEDITION DASHBOARD ─── */}
            <div className="lux-dashboard">
                {/* Highlights Dashboard Card */}
                <div className="lux-dash-col">
                    <div className="lux-dash-card">
                        <span style={{ textTransform: 'uppercase', fontSize: '0.65rem', letterSpacing: '2px', color: 'var(--lux-tan)', display: 'block', marginBottom: '15px' }}>The Highlights</span>
                        <h3 style={{ fontFamily: 'var(--font-heading)', fontSize: '1.4rem', marginBottom: '20px' }}>Curated <em>Experience.</em></h3>
                        <ul style={{ listStyle: 'none', padding: 0, margin: 0, fontSize: '0.9rem' }}>
                            {pkg.highlights?.slice(0, 4).map((h, i) => (
                                <li key={i} style={{ marginBottom: '12px', display: 'flex', gap: '10px' }}>
                                    <span style={{ color: 'var(--lux-tan)' }}>•</span> {h.split(':')[0]}
                                </li>
                            ))}
                        </ul>
                    </div>
                </div>

                {/* Live Weather Dashboard Card */}
                <div className="lux-dash-col">
                    <LiveWeatherWidget zone="Moorland" />
                </div>

                {/* Core Stats Dashboard Card */}
                <div className="lux-dash-col">
                    <div className="lux-dash-card">
                        <span style={{ textTransform: 'uppercase', fontSize: '0.65rem', letterSpacing: '2px', color: 'var(--lux-tan)', display: 'block', marginBottom: '15px' }}>Technical Specs</span>
                        <h3 style={{ fontFamily: 'var(--font-heading)', fontSize: '1.4rem', marginBottom: '25px' }}>Expedition <em>Telemetry.</em></h3>
                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px' }}>
                            <div>
                                <span style={{ display: 'block', fontSize: '0.6rem', textTransform: 'uppercase', color: 'var(--lux-mid)', marginBottom: '4px' }}>Duration</span>
                                <span style={{ fontWeight: '500', fontSize: '1rem' }}>{pkg.duration}</span>
                            </div>
                            <div>
                                <span style={{ display: 'block', fontSize: '0.6rem', textTransform: 'uppercase', color: 'var(--lux-mid)', marginBottom: '4px' }}>Difficulty</span>
                                <span style={{ fontWeight: '500', fontSize: '1rem' }}>{pkg.difficulty}</span>
                            </div>
                            <div>
                                <span style={{ display: 'block', fontSize: '0.6rem', textTransform: 'uppercase', color: 'var(--lux-mid)', marginBottom: '4px' }}>Success</span>
                                <span style={{ fontWeight: '500', fontSize: '1rem' }}>{pkg.successRate}</span>
                            </div>
                            <div>
                                <span style={{ display: 'block', fontSize: '0.6rem', textTransform: 'uppercase', color: 'var(--lux-mid)', marginBottom: '4px' }}>Alt Gain</span>
                                <span style={{ fontWeight: '500', fontSize: '1rem' }}>~600m/d</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {/* ─── NARRATIVE OVERVIEW ─── */}
            <section className="lux-section">
                <div style={{ maxWidth: '900px', margin: '0 auto', textAlign: 'center' }}>
                    <h2 className="lux-heading" style={{ fontSize: '2.8rem' }}>The <em>Journey.</em></h2>
                    <p className="lux-body" style={{ fontSize: '1.2rem', color: 'var(--lux-dark)' }}>
                        {pkg.overview}
                    </p>
                </div>
            </section>

            {/* ─── TECHNICAL SPLIT VIEW (GRAPH + CALENDAR) ─── */}
            {chartData.length > 0 && (
                <section className="lux-section" style={{ backgroundColor: 'var(--lux-cream)' }}>
                    <div style={{ maxWidth: '1400px', margin: '0 auto' }}>
                        <div style={{ marginBottom: '60px' }}>
                            <span style={{ textTransform: 'uppercase', letterSpacing: '4px', fontSize: '0.7rem', color: 'var(--lux-tan)' }}>Technical Profile</span>
                            <h2 className="lux-heading" style={{ fontSize: '2.5rem', marginTop: '10px' }}>Elevation & <em>Departure.</em></h2>
                        </div>

                        <div className="lux-technical-split">
                            <div className="lux-split-main">
                                <ElevationGraph data={chartData} compact={true} />
                            </div>
                            <div className="lux-split-sidebar">
                                <SafariCalendar itinerary={pkg.itinerary} compact={true} />
                            </div>
                        </div>
                    </div>
                </section>
            )}

            {/* ─── DETAILED ITINERARY ─── */}
            <section className="lux-itinerary-section" style={{ backgroundColor: '#fff' }}>
                <h2 className="lux-heading" style={{ textAlign: 'center', fontSize: '2.5rem', marginBottom: '60px' }}>The <em>Journey.</em></h2>
                <div className="lux-itinerary-list" style={{ maxWidth: '1000px' }}>
                    {pkg.itinerary.map((day, index) => (
                        <motion.div
                            key={index}
                            className="lux-itinerary-item"
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true, margin: "-50px" }}
                            variants={fadeInUp}
                        >
                            <div className="lux-day-marker">Day {day.day}</div>
                            <div style={{ flex: 1 }}>
                                <h3 className="lux-day-title">{day.title}</h3>

                                {/* Enriched Data Badges */}
                                {(day.distance || day.hikingTime || day.habitat || day.elevation) && (
                                    <div style={{ display: 'flex', flexWrap: 'wrap', gap: '15px', marginBottom: '20px' }}>
                                        {day.elevation && (
                                            <span style={{ fontSize: '0.8rem', fontFamily: 'Inter', backgroundColor: 'var(--lux-cream)', padding: '5px 12px', border: '1px solid var(--lux-border)', color: 'var(--lux-dark)' }}>
                                                <strong>Elevation:</strong> {day.elevation}m
                                            </span>
                                        )}
                                        {day.distance && (
                                            <span style={{ fontSize: '0.8rem', fontFamily: 'Inter', backgroundColor: 'var(--lux-cream)', padding: '5px 12px', border: '1px solid var(--lux-border)', color: 'var(--lux-dark)' }}>
                                                <strong>Distance:</strong> {day.distance}
                                            </span>
                                        )}
                                        {day.hikingTime && (
                                            <span style={{ fontSize: '0.8rem', fontFamily: 'Inter', backgroundColor: 'var(--lux-cream)', padding: '5px 12px', border: '1px solid var(--lux-border)', color: 'var(--lux-dark)' }}>
                                                <strong>Time:</strong> {day.hikingTime}
                                            </span>
                                        )}
                                        {day.habitat && (
                                            <span style={{ fontSize: '0.8rem', fontFamily: 'Inter', backgroundColor: 'var(--lux-cream)', padding: '5px 12px', border: '1px solid var(--lux-border)', color: 'var(--lux-dark)' }}>
                                                <strong>Habitat:</strong> {day.habitat}
                                            </span>
                                        )}
                                    </div>
                                )}

                                <p className="lux-day-desc">{day.desc}</p>

                                <div style={{ display: 'flex', gap: '30px', marginTop: '20px', fontSize: '0.9rem', color: 'var(--lux-dark)', opacity: 0.8, letterSpacing: '0.5px' }}>
                                    <div><strong>Camp:</strong> <span style={{ fontFamily: 'Inter' }}>{day.accommodation}</span></div>
                                    <div><strong>Meals:</strong> <span style={{ fontFamily: 'Inter' }}>{day.meals}</span></div>
                                </div>
                            </div>
                        </motion.div>
                    ))}
                </div>
            </section>

            {/* ─── CLIMATE & WEATHER ZONES ─── */}
            <section className="lux-section" style={{ backgroundColor: 'var(--lux-dark)', color: 'var(--lux-cream)' }}>
                <div style={{ maxWidth: '1200px', margin: '0 auto' }}>
                    <h2 className="lux-heading" style={{ color: '#fff', textAlign: 'center', marginBottom: '50px' }}>Mountain <em>Conditions.</em></h2>
                    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(280px, 1fr))', gap: '30px' }}>

                        <div style={{ borderLeft: '2px solid var(--lux-tan)', paddingLeft: '20px' }}>
                            <h4 style={{ fontFamily: 'Playfair Display', fontSize: '1.2rem', color: 'var(--lux-tan)', marginBottom: '10px' }}>Rainforest Zone <span style={{ fontSize: '0.9rem', color: 'rgba(255,255,255,0.5)', fontFamily: 'Inter', paddingLeft: '5px' }}>800m - 2,800m</span></h4>
                            <p style={{ fontFamily: 'Inter', fontSize: '0.95rem', lineHeight: '1.6', color: 'rgba(255,255,255,0.8)' }}>
                                Warm and humid. Expect daytime temperatures around 20-25°C. Dense canopy cover, frequent afternoon showers, and muddy trails.
                            </p>
                        </div>

                        <div style={{ borderLeft: '2px solid var(--lux-tan)', paddingLeft: '20px' }}>
                            <h4 style={{ fontFamily: 'Playfair Display', fontSize: '1.2rem', color: 'var(--lux-tan)', marginBottom: '10px' }}>Moorland Zone <span style={{ fontSize: '0.9rem', color: 'rgba(255,255,255,0.5)', fontFamily: 'Inter', paddingLeft: '5px' }}>2,800m - 4,000m</span></h4>
                            <p style={{ fontFamily: 'Inter', fontSize: '0.95rem', lineHeight: '1.6', color: 'rgba(255,255,255,0.8)' }}>
                                Cooler, semi-arid environment. Daytime ranges from 10-15°C, but nights can drop near freezing. Characterized by giant senecios.
                            </p>
                        </div>

                        <div style={{ borderLeft: '2px solid var(--lux-tan)', paddingLeft: '20px' }}>
                            <h4 style={{ fontFamily: 'Playfair Display', fontSize: '1.2rem', color: 'var(--lux-tan)', marginBottom: '10px' }}>Alpine Desert <span style={{ fontSize: '0.9rem', color: 'rgba(255,255,255,0.5)', fontFamily: 'Inter', paddingLeft: '5px' }}>4,000m - 5,000m</span></h4>
                            <p style={{ fontFamily: 'Inter', fontSize: '0.95rem', lineHeight: '1.6', color: 'rgba(255,255,255,0.8)' }}>
                                Harsh, stark, and dry. Extreme temperature swings from blistering solar heat during the day to well below freezing (-5°C) at night.
                            </p>
                        </div>

                        <div style={{ borderLeft: '2px solid var(--lux-tan)', paddingLeft: '20px' }}>
                            <h4 style={{ fontFamily: 'Playfair Display', fontSize: '1.2rem', color: 'var(--lux-tan)', marginBottom: '10px' }}>Arctic Summit <span style={{ fontSize: '0.9rem', color: 'rgba(255,255,255,0.5)', fontFamily: 'Inter', paddingLeft: '5px' }}>5,000m - 5,895m</span></h4>
                            <p style={{ fontFamily: 'Inter', fontSize: '0.95rem', lineHeight: '1.6', color: 'rgba(255,255,255,0.8)' }}>
                                Glacial ice and brutal cold. Summit night temperatures frequently hit -15°C to -25°C with windchill. Oxygen levels are roughly 50% of sea level.
                            </p>
                        </div>

                    </div>
                </div>
            </section>

            {/* ─── INCLUSIONS & EXCLUSIONS (REDESIGNED) ─── */}
            <section className="lux-section" style={{ borderTop: '1px solid var(--lux-border)' }}>
                <div style={{ maxWidth: '1200px', margin: '0 auto' }}>
                    <div style={{ textAlign: 'center', marginBottom: '80px' }}>
                        <h2 className="lux-heading" style={{ fontSize: '3rem' }}>The <em>Standard.</em></h2>
                        <p className="lux-body" style={{ opacity: 0.6 }}>What sets our premium expeditions apart from others.</p>
                    </div>

                    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))', gap: '40px' }}>
                        <motion.div
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true }}
                            variants={fadeInUp}
                            style={{ backgroundColor: '#fff', padding: '50px', border: '1px solid var(--lux-border)' }}
                        >
                            <h3 className="lux-day-title" style={{ fontSize: '1.8rem', marginBottom: '40px', color: 'var(--lux-dark)' }}>Premium <em>Inclusions.</em></h3>
                            <div style={{ display: 'grid', gap: '20px' }}>
                                {pkg.inclusions.map((item, idx) => (
                                    <div key={idx} style={{ display: 'flex', gap: '15px', alignItems: 'flex-start' }}>
                                        <div style={{ minWidth: '24px', height: '24px', borderRadius: '50%', backgroundColor: 'var(--lux-cream)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--lux-tan)' }}>
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="3" strokeLinecap="round" strokeLinejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                        </div>
                                        <span style={{ fontFamily: 'Inter', fontSize: '1rem', color: 'var(--lux-dark)', lineHeight: '1.4' }}>{item}</span>
                                    </div>
                                ))}
                            </div>
                        </motion.div>

                        <motion.div
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true }}
                            variants={fadeInUp}
                            transition={{ delay: 0.2 }}
                            style={{ backgroundColor: 'var(--lux-dark)', padding: '50px', color: 'var(--lux-cream)' }}
                        >
                            <h3 className="lux-day-title" style={{ fontSize: '1.8rem', marginBottom: '40px', color: 'var(--lux-cream)' }}>Plan <em>Accordingly.</em></h3>
                            <div style={{ display: 'grid', gap: '20px' }}>
                                {pkg.exclusions.map((item, idx) => (
                                    <div key={idx} style={{ display: 'flex', gap: '15px', alignItems: 'flex-start', opacity: 0.8 }}>
                                        <div style={{ minWidth: '24px', height: '24px', border: '1px solid rgba(255,255,255,0.2)', borderRadius: '50%', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'rgba(255,255,255,0.4)' }}>
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </div>
                                        <span style={{ fontFamily: 'Inter', fontSize: '1rem', color: 'var(--lux-cream)', lineHeight: '1.4' }}>{item}</span>
                                    </div>
                                ))}
                            </div>
                        </motion.div>
                    </div>
                </div>
            </section>

            {/* ─── CTA ─── */}
            <section className="lux-cta">
                <h2 className="lux-heading" style={{ marginBottom: '20px' }}>Secure Your <em>Ascent.</em></h2>
                <p className="lux-body" style={{ marginBottom: '40px', maxWidth: '600px', margin: '0 auto 40px', color: 'rgba(255,255,255,0.8)' }}>
                    Contact our expedition specialists to discuss availability, pricing, and personalized preparations for the {pkg.title}.
                </p>
                <div style={{ display: 'flex', gap: '20px', justifyContent: 'center' }}>
                    <Link to={`/booking/departure/${departure.id}`} className="lux-btn">
                        Book This Package
                    </Link>
                    <Link to="/contact" className="lux-btn" style={{ background: 'transparent', border: '1px solid white' }}>
                        General Inquiry
                    </Link>
                </div>
            </section>
        </div>
    );
};

export default PackageDetail;
