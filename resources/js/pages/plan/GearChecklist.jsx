import React, { useEffect, useMemo, useState } from 'react';
import { motion } from 'framer-motion';
import { visualsData } from '../../data/visualsData';
import { gearService } from '../../services/api';
import { Loader2 } from 'lucide-react';
import { useVisuals } from '../../context/VisualsContext';
import '../../styles/utility-pages-premium.css';

export const GearChecklist = () => {
    const visuals = useVisuals();
    const [items, setItems] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');
    const [packed, setPacked] = useState(() => {
        try { return JSON.parse(localStorage.getItem('gearPacked') || '{}'); } catch { return {}; }
    });
    const [rentalQty, setRentalQty] = useState({});
    const [requestForm, setRequestForm] = useState({ booking_ref: '', customer_name: '', email: '' });
    const [requestSending, setRequestSending] = useState(false);
    const [requestResult, setRequestResult] = useState(null);

    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    useEffect(() => {
        localStorage.setItem('gearPacked', JSON.stringify(packed));
    }, [packed]);

    useEffect(() => {
        let mounted = true;
        const run = async () => {
            setLoading(true);
            setError('');
            try {
                const res = await gearService.getItems();
                if (!mounted) return;
                setItems(Array.isArray(res.data) ? res.data : []);
            } catch (e) {
                if (!mounted) return;
                setError('Unable to load gear list.');
            } finally {
                if (!mounted) return;
                setLoading(false);
            }
        };
        run();
        return () => { mounted = false; };
    }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8 } }
    };

    const grouped = useMemo(() => {
        const map = new Map();
        for (const it of items) {
            const cat = it.category || 'Other';
            if (!map.has(cat)) map.set(cat, []);
            map.get(cat).push(it);
        }
        return Array.from(map.entries());
    }, [items]);

    const selectedRentalItems = useMemo(() => {
        const out = {};
        for (const [id, qty] of Object.entries(rentalQty)) {
            const n = Number(qty);
            if (Number.isFinite(n) && n > 0) out[id] = n;
        }
        return out;
    }, [rentalQty]);

    const submitRental = async () => {
        setRequestSending(true);
        setRequestResult(null);
        try {
            const res = await gearService.requestRental({
                booking_ref: requestForm.booking_ref || null,
                customer_name: requestForm.customer_name,
                email: requestForm.email,
                items: selectedRentalItems,
            });
            setRequestResult(res.data);
        } catch (e) {
            setRequestResult({ message: e.response?.data?.message || 'Unable to submit request.' });
        } finally {
            setRequestSending(false);
        }
    };

    return (
        <div className="utility-root">
            <section className="utility-hero">
                <div className="utility-hero-bg">
                    <img src={visuals.getSingle('planning.gearHero', visualsData.planning.gearHero)} alt="Mountain Gear" />
                </div>
                <div className="utility-hero-overlay"></div>
                <motion.div className="utility-hero-content" initial="hidden" animate="visible" variants={fadeInUp}>
                    <span className="utility-hero-eyebrow">Preparation</span>
                    <h1 className="utility-hero-title">Gear Checklist</h1>
                    <p className="utility-hero-subtitle">
                        From the tropical rainforest to the arctic summit, climbing Kilimanjaro requires a highly adaptable layering system. Make sure you don't compromise on the essentials.
                    </p>
                </motion.div>
            </section>

            <section className="utility-content">
                {loading ? (
                    <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', padding: 80 }}>
                        <Loader2 className="animate-spin" size={28} color="var(--gold)" />
                    </div>
                ) : error ? (
                    <div style={{ textAlign: 'center', color: 'rgba(255,255,255,0.7)' }}>{error}</div>
                ) : (
                    <>
                        <div className="utility-grid">
                            {grouped.map(([cat, catItems]) => (
                                <motion.div key={cat} className="util-card" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                                    <h3 className="util-card-title">{cat}</h3>
                                    <ul className="util-card-list">
                                        {catItems.map((it) => (
                                            <li key={it.id} style={{ display: 'flex', alignItems: 'center', gap: 12 }}>
                                                <input
                                                    type="checkbox"
                                                    checked={Boolean(packed[it.id])}
                                                    onChange={(e) => setPacked((p) => ({ ...p, [it.id]: e.target.checked }))}
                                                />
                                                <span style={{ flex: 1 }}>{it.name}</span>
                                                <input
                                                    type="number"
                                                    min={0}
                                                    max={20}
                                                    value={rentalQty[it.id] ?? 0}
                                                    onChange={(e) => setRentalQty((r) => ({ ...r, [it.id]: Number(e.target.value) }))}
                                                    style={{ width: 80 }}
                                                    aria-label={`Rental quantity for ${it.name}`}
                                                />
                                            </li>
                                        ))}
                                    </ul>
                                </motion.div>
                            ))}
                        </div>

                        <motion.div className="util-card" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp} style={{ marginTop: 30 }}>
                            <h3 className="util-card-title">Request gear rental</h3>
                            <p style={{ color: 'rgba(255,255,255,0.65)', lineHeight: 1.7 }}>
                                Select quantities above (0 means you do not need to rent that item), then submit your request. We’ll confirm availability and pricing by email. No online payment.
                            </p>

                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 14, marginTop: 16 }}>
                                <label style={{ display: 'grid', gap: 6 }}>
                                    <span style={{ color: 'rgba(255,255,255,0.7)' }}>Full name *</span>
                                    <input value={requestForm.customer_name} onChange={(e) => setRequestForm((s) => ({ ...s, customer_name: e.target.value }))} />
                                </label>
                                <label style={{ display: 'grid', gap: 6 }}>
                                    <span style={{ color: 'rgba(255,255,255,0.7)' }}>Email *</span>
                                    <input type="email" value={requestForm.email} onChange={(e) => setRequestForm((s) => ({ ...s, email: e.target.value }))} />
                                </label>
                                <label style={{ display: 'grid', gap: 6 }}>
                                    <span style={{ color: 'rgba(255,255,255,0.7)' }}>Booking reference (optional)</span>
                                    <input value={requestForm.booking_ref} onChange={(e) => setRequestForm((s) => ({ ...s, booking_ref: e.target.value }))} placeholder="TS-XXXXXXXX" />
                                </label>
                                <div />
                            </div>

                            {requestResult?.message && (
                                <div style={{ marginTop: 12, color: 'rgba(255,255,255,0.8)' }}>
                                    {requestResult.message}
                                </div>
                            )}

                            <button
                                className="btn-primary"
                                style={{ marginTop: 16 }}
                                disabled={requestSending || !requestForm.customer_name || !requestForm.email || Object.keys(selectedRentalItems).length === 0}
                                onClick={submitRental}
                            >
                                {requestSending ? 'Submitting…' : 'Submit rental request'}
                            </button>
                        </motion.div>
                    </>
                )}
            </section>
        </div>
    );
};
