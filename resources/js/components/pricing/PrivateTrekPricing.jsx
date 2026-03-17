import React, { useEffect, useState } from 'react';
import { Loader2 } from 'lucide-react';
import { Link } from 'react-router-dom';
import api from '../../services/api';

export function PrivateTrekPricing({ routeSlug, fallbackPricePerPerson = null }) {
    const [date, setDate] = useState(() => new Date(Date.now() + 21 * 86400000).toISOString().split('T')[0]);
    const [groupSize, setGroupSize] = useState(2);
    const [loading, setLoading] = useState(false);
    const [price, setPrice] = useState(null);
    const [error, setError] = useState('');
    const [hint, setHint] = useState('');

    useEffect(() => {
        let mounted = true;
        const run = async () => {
            if (!routeSlug) return;
            setLoading(true);
            setError('');
            setHint('');
            try {
                const res = await api.get('/pricing/trekking', {
                    params: { route_slug: routeSlug, date, group_size: groupSize },
                });
                if (!mounted) return;
                setPrice(res.data);
            } catch (e) {
                if (!mounted) return;
                const status = e?.response?.status;
                if (status === 422) {
                    setError('Price estimate is unavailable for the selected date/group size.');
                    setHint('Try a different start date or group size, or request a quote.');
                } else if (status === 404) {
                    setError('Price estimate is unavailable for this route right now.');
                    setHint('Please request a quote and our team will confirm pricing by email.');
                } else {
                    setError('Price estimate is temporarily unavailable.');
                    setHint('Please try again in a moment, or request a quote.');
                }
                setPrice(null);
            } finally {
                if (!mounted) return;
                setLoading(false);
            }
        };
        run();
        return () => { mounted = false; };
    }, [date, groupSize, routeSlug]);

    const computedFallback = (() => {
        const n = Number(fallbackPricePerPerson);
        return Number.isFinite(n) && n > 0 ? n : null;
    })();

    const perPerson = (() => {
        if (price) {
            const v = price.price_per_person_cents != null
                ? (Number(price.price_per_person_cents) / 100)
                : Number(price.price_per_person);
            return Number.isFinite(v) && v > 0 ? v : null;
        }
        return computedFallback;
    })();

    const total = perPerson ? perPerson * Number(groupSize || 0) : null;

    return (
        <section className="lux-section" style={{ background: '#fff' }}>
            <div style={{ maxWidth: 1100, margin: '0 auto' }}>
                <h2 className="lux-heading" style={{ fontSize: '2.2rem', textAlign: 'center' }}>
                    Private trek <em>price estimate</em>
                </h2>
                <p className="lux-body" style={{ textAlign: 'center', maxWidth: 720, margin: '10px auto 0', opacity: 0.8 }}>
                    This is an estimate for private treks. Group departures have fixed pricing shown above. Payment is arranged offline after we confirm details by email.
                </p>

                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: 16, marginTop: 24 }}>
                    <label style={{ display: 'grid', gap: 6 }}>
                        <span style={{ fontSize: 12, textTransform: 'uppercase', letterSpacing: 1, opacity: 0.7 }}>Start date</span>
                        <input
                            type="date"
                            value={date}
                            onChange={(e) => setDate(e.target.value)}
                            style={{ padding: '12px 14px', border: '1px solid rgba(0,0,0,0.12)' }}
                        />
                    </label>
                    <label style={{ display: 'grid', gap: 6 }}>
                        <span style={{ fontSize: 12, textTransform: 'uppercase', letterSpacing: 1, opacity: 0.7 }}>Group size</span>
                        <input
                            type="number"
                            min={1}
                            max={20}
                            value={groupSize}
                            onChange={(e) => setGroupSize(Number(e.target.value))}
                            style={{ padding: '12px 14px', border: '1px solid rgba(0,0,0,0.12)' }}
                        />
                    </label>
                    <div style={{ display: 'grid', gap: 6, alignContent: 'end' }}>
                        <span style={{ fontSize: 12, textTransform: 'uppercase', letterSpacing: 1, opacity: 0.7 }}>Total estimate</span>
                        <div style={{ padding: '12px 14px', border: '1px solid rgba(0,0,0,0.12)', minHeight: 46, display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                            {loading ? (
                                <span style={{ display: 'inline-flex', alignItems: 'center', gap: 10, opacity: 0.8 }}>
                                    <Loader2 className="animate-spin" size={18} /> Calculating…
                                </span>
                            ) : error ? (
                                <span style={{ color: '#b91c1c' }}>{computedFallback ? 'Estimate unavailable' : error}</span>
                            ) : total ? (
                                <>
                                    <span style={{ fontWeight: 700 }}>
                                        ${Math.round(total).toLocaleString()}
                                    </span>
                                    <span style={{ opacity: 0.7, fontSize: 13 }}>total</span>
                                </>
                            ) : (
                                <span style={{ opacity: 0.7 }}>—</span>
                            )}
                        </div>
                        {!loading && !error && perPerson && total ? (
                            <div style={{ fontSize: 12, opacity: 0.7, marginTop: 8 }}>
                                ≈ ${Math.round(perPerson).toLocaleString()} per person × {Number(groupSize || 0)} people
                            </div>
                        ) : null}
                        {error ? (
                            <div style={{ marginTop: 10 }}>
                                {computedFallback ? (
                                    <div style={{ fontSize: 12, opacity: 0.75, lineHeight: 1.5 }}>
                                        We can’t compute a live estimate right now. Typical pricing starts around <strong>${Math.round(computedFallback).toLocaleString()}</strong> per person (final quote confirmed by email).
                                    </div>
                                ) : (
                                    <div style={{ fontSize: 12, opacity: 0.75, lineHeight: 1.5 }}>
                                        {hint || 'Please try again, or request a quote.'}
                                    </div>
                                )}
                                <div style={{ display: 'flex', gap: 10, flexWrap: 'wrap', marginTop: 12 }}>
                                    <Link to="/booking" style={{ padding: '10px 14px', background: 'var(--gold)', color: 'var(--dark)', textDecoration: 'none', fontWeight: 700, letterSpacing: '0.08em', textTransform: 'uppercase', fontSize: 12 }}>
                                        Request a quote
                                    </Link>
                                    <Link to="/contact" style={{ padding: '10px 14px', border: '1px solid rgba(0,0,0,0.18)', color: 'var(--dark)', textDecoration: 'none', fontWeight: 700, letterSpacing: '0.08em', textTransform: 'uppercase', fontSize: 12 }}>
                                        General inquiry
                                    </Link>
                                </div>
                            </div>
                        ) : null}
                    </div>
                </div>
            </div>
        </section>
    );
}

