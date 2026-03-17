import React, { useEffect, useState } from 'react';
import { Loader2 } from 'lucide-react';
import api from '../../services/api';

export function PrivateTrekPricing({ routeSlug }) {
    const [date, setDate] = useState(() => new Date(Date.now() + 21 * 86400000).toISOString().split('T')[0]);
    const [groupSize, setGroupSize] = useState(2);
    const [loading, setLoading] = useState(false);
    const [price, setPrice] = useState(null);
    const [error, setError] = useState('');

    useEffect(() => {
        let mounted = true;
        const run = async () => {
            if (!routeSlug) return;
            setLoading(true);
            setError('');
            try {
                const res = await api.get('/pricing/trekking', {
                    params: { route_slug: routeSlug, date, group_size: groupSize },
                });
                if (!mounted) return;
                setPrice(res.data);
            } catch (e) {
                if (!mounted) return;
                setError('Unable to calculate price right now.');
                setPrice(null);
            } finally {
                if (!mounted) return;
                setLoading(false);
            }
        };
        run();
        return () => { mounted = false; };
    }, [date, groupSize, routeSlug]);

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
                        <span style={{ fontSize: 12, textTransform: 'uppercase', letterSpacing: 1, opacity: 0.7 }}>Price per person</span>
                        <div style={{ padding: '12px 14px', border: '1px solid rgba(0,0,0,0.12)', minHeight: 46, display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                            {loading ? (
                                <span style={{ display: 'inline-flex', alignItems: 'center', gap: 10, opacity: 0.8 }}>
                                    <Loader2 className="animate-spin" size={18} /> Calculating…
                                </span>
                            ) : error ? (
                                <span style={{ color: '#b91c1c' }}>{error}</span>
                            ) : price ? (
                                <>
                                    <span style={{ fontWeight: 700 }}>
                                        ${Math.round((price.price_per_person_cents != null ? (price.price_per_person_cents / 100) : price.price_per_person)).toLocaleString()}
                                    </span>
                                    <span style={{ opacity: 0.7, fontSize: 13 }}>/pp</span>
                                </>
                            ) : (
                                <span style={{ opacity: 0.7 }}>—</span>
                            )}
                        </div>
                        <div style={{ fontSize: 12, opacity: 0.65, marginTop: 8 }}>
                            Admin tip: update rules in <strong>Dashboard → Pricing Rules</strong>.
                        </div>
                    </div>
                </div>
            </div>
        </section>
    );
}

