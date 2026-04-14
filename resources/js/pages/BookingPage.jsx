import React, { useEffect, useMemo, useState } from 'react';
import { Link, useLocation, useParams } from 'react-router-dom';
import { Loader2, AlertTriangle, ArrowLeft } from 'lucide-react';
import { BookingEngine } from '../components/booking/BookingEngine';
import { departureService, safariService } from '../services/api';
import '../styles/booking-page.css';

function useQuery() {
    const { search } = useLocation();
    return useMemo(() => new URLSearchParams(search), [search]);
}

export const BookingPage = () => {
    const params = useParams();
    const query = useQuery();

    const typedDepartureId = params.departureId ? String(params.departureId) : null;
    const typedSafariId = params.packageId ? String(params.packageId) : null;

    const type = (query.get('type') || (typedDepartureId ? 'departure' : (typedSafariId ? 'safari' : ''))).toLowerCase();
    const id = query.get('id') || typedDepartureId || typedSafariId;

    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');
    const [pkg, setPkg] = useState(null);
    const [pageMeta, setPageMeta] = useState({ hero_image: null, title: '', subtitle: '' });

    useEffect(() => {
        window.scrollTo(0, 0);
    }, [type, id]);

    useEffect(() => {
        let mounted = true;
        const run = async () => {
            setLoading(true);
            setError('');
            setPkg(null);
            try {
                if (!id || !type) {
                    setPageMeta({
                        hero_image: null,
                        title: 'Book Your Expedition',
                        subtitle: 'Choose a departure or safari package, then submit your booking request. No payment is collected online, our team confirms details by email.',
                    });
                    return;
                }

                if (type === 'departure') {
                    const res = await departureService.getById(id);
                    if (!mounted) return;
                    const dep = res.data || null;
                    if (!dep?.id) throw new Error('Departure not found.');
                    setPkg({
                        departure_id: dep.id,
                        name: dep.trekking_route?.name ? `${dep.trekking_route.name} Route` : 'Group Departure',
                        departure_date: dep.departure_date,
                        duration: dep.trekking_route?.duration_days || dep.trekking_route?.duration || null,
                        meta_tag: dep.status || null,
                        hero_image: dep.trekking_route?.hero_image || null,
                    });
                    setPageMeta({
                        hero_image: dep.trekking_route?.hero_image || null,
                        title: dep.trekking_route?.name ? `${dep.trekking_route.name} Route` : 'Group Departure',
                        subtitle: 'Submit your booking request and we’ll confirm availability, details, and payment instructions by email.',
                    });
                    return;
                }

                if (type === 'safari') {
                    const res = await safariService.getById(id);
                    if (!mounted) return;
                    const safari = res.data || null;
                    if (!safari?.id) throw new Error('Safari package not found.');
                    setPkg(safari);
                    setPageMeta({
                        hero_image: safari.hero_image || null,
                        title: safari.name || 'Safari Booking',
                        subtitle: 'Submit your booking request and we’ll confirm details and payment instructions by email.',
                    });
                    return;
                }

                throw new Error('Unknown booking type.');
            } catch (e) {
                if (!mounted) return;
                setError(e?.message || 'Unable to load booking page.');
            } finally {
                if (!mounted) return;
                setLoading(false);
            }
        };
        run();
        return () => { mounted = false; };
    }, [id, type]);

    const backTo = type === 'safari' ? '/safaris/packages' : '/group-departures';
    const backLabel = type === 'safari' ? 'Back to safari packages' : 'Back to group departures';

    if (loading) {
        return (
            <div className="booking-page-root" style={{ padding: '140px 20px', display: 'grid', placeItems: 'center' }}>
                <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'center', gap: 16 }}>
                    <Loader2 className="animate-spin" size={44} color="var(--gold)" />
                    <div style={{ fontFamily: 'var(--font-mono)', letterSpacing: '0.2em', fontSize: '0.75rem', color: 'var(--gold)' }}>Loading booking…</div>
                </div>
            </div>
        );
    }

    if (error || (type && id && !pkg)) {
        return (
            <div className="booking-page-root" style={{ padding: '140px 20px', display: 'grid', placeItems: 'center' }}>
                <div style={{ maxWidth: 680, width: '100%' }}>
                    <Link to={backTo} style={{ display: 'inline-flex', alignItems: 'center', gap: 8, color: 'var(--gold)', textDecoration: 'none', textTransform: 'uppercase', letterSpacing: '0.14em', fontSize: '0.75rem' }}>
                        <ArrowLeft size={16} /> {backLabel}
                    </Link>
                    <div style={{ marginTop: 18, padding: 18, border: '1px solid rgba(248,113,113,0.25)', background: 'rgba(248,113,113,0.08)', display: 'flex', gap: 12, alignItems: 'flex-start' }}>
                        <AlertTriangle size={18} color="#F87171" style={{ marginTop: 2 }} />
                        <div>
                            <div style={{ fontSize: '1.1rem', color: 'white' }}>We couldn’t load this booking</div>
                            <div style={{ marginTop: 6, color: 'rgba(255,255,255,0.65)', lineHeight: 1.6 }}>{error || 'Unknown error.'}</div>
                        </div>
                    </div>
                    <div style={{ marginTop: 18, color: 'rgba(255,255,255,0.45)', fontSize: '0.85rem' }}>
                        Prefer? You can still <Link to="/contact" style={{ color: 'var(--gold)' }}>contact us</Link> for a general inquiry.
                    </div>
                </div>
            </div>
        );
    }

    const heroImg = pageMeta.hero_image || pkg?.hero_image || 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=2000&q=80';

    return (
        <div className="booking-page-root">
            <section className="booking-page-hero">
                <div className="booking-page-hero-bg">
                    <img src={heroImg} alt={pageMeta.title || 'Booking'} />
                </div>
                <div className="booking-page-hero-overlay" />

                <div className="booking-page-hero-content">
                    <span className="booking-page-eyebrow">Booking</span>
                    <h1 className="booking-page-title">{pageMeta.title || pkg?.name || pkg?.title || 'Book your expedition'}</h1>
                    <p className="booking-page-subtitle">
                        {pageMeta.subtitle || 'Submit your booking request and we’ll confirm details by email.'}
                    </p>

                    {(type && id) ? (
                        <div style={{ marginTop: 22 }}>
                            <Link to={backTo} style={{ display: 'inline-flex', alignItems: 'center', gap: 8, color: 'var(--gold)', textDecoration: 'none', textTransform: 'uppercase', letterSpacing: '0.14em', fontSize: '0.75rem' }}>
                                <ArrowLeft size={16} /> {backLabel}
                            </Link>
                        </div>
                    ) : null}
                </div>
            </section>

            <section className="booking-page-body">
                <div className="booking-page-container">
                    <div>
                        {(!type || !id) ? (
                            <div className="booking-page-panel">
                                <h3>Choose what you want to book</h3>
                                <p style={{ marginTop: 8 }}>
                                    Start from a trip page to book a specific departure or safari package.
                                </p>
                                <div className="booking-choice-grid">
                                    <div className="booking-choice-actions">
                                        <Link to="/group-departures" className="btn-heritage-gold booking-choice-btn" style={{ textDecoration: 'none' }}>
                                            Group departures
                                        </Link>
                                        <Link to="/safaris/packages" className="btn-heritage-gold booking-choice-btn" style={{ textDecoration: 'none' }}>
                                            Safari packages
                                        </Link>
                                    </div>
                                    <div className="booking-choice-meta">
                                        <div className="booking-choice-note">
                                            Prefer a custom request?
                                        </div>
                                        <Link to="/contact" className="booking-choice-link">
                                            General inquiry
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        ) : (
                            <BookingEngine pkg={pkg} mode="page" />
                        )}
                    </div>

                    <aside className="booking-page-sticky">
                        <div className="booking-page-panel">
                            <h3>What happens after you submit?</h3>
                            <p>
                                We confirm availability, finalize details, and send payment instructions by email. Add special requirements in your request.
                            </p>
                            <div style={{ marginTop: 14, color: 'rgba(255,255,255,0.55)', fontSize: '0.9rem', lineHeight: 1.7 }}>
                                Prefer to talk first? <Link to="/contact" style={{ color: 'var(--gold)' }}>Contact us</Link>.
                            </div>
                        </div>
                    </aside>
                </div>
            </section>
        </div>
    );
};

