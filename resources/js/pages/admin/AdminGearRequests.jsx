import React, { useEffect, useMemo, useState } from 'react';
import { Loader2, Mail, X } from 'lucide-react';
import { adminService } from '../../services/api';
import '../../styles/admin-premium.css';

export const AdminGearRequests = () => {
    const [rows, setRows] = useState([]);
    const [loading, setLoading] = useState(true);
    const [selected, setSelected] = useState(null);
    const [filter, setFilter] = useState('ALL');
    const [showModal, setShowModal] = useState(false);

    const fetchRows = async () => {
        setLoading(true);
        try {
            const res = await adminService.getGearRentalRequests();
            const data = Array.isArray(res.data?.data) ? res.data.data : [];
            setRows(data);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => { fetchRows(); }, []);

    const filtered = useMemo(() => {
        if (filter === 'ALL') return rows;
        return rows.filter((r) => (r.status || '').toUpperCase() === filter);
    }, [filter, rows]);

    const updateStatus = async (id, status) => {
        await adminService.updateGearRentalRequestStatus(id, status);
        await fetchRows();
    };

    return (
        <div className="admin-page-root">
            <header style={{ marginBottom: '50px', display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                <div>
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.25em', textTransform: 'uppercase', marginBottom: '12px' }}>Gear rental</h2>
                    <h1 className="admin-page-title" style={{ fontSize: '3.5rem', fontWeight: 300 }}>Requests</h1>
                </div>
                <select
                    value={filter}
                    onChange={(e) => setFilter(e.target.value)}
                    style={{ background: 'rgba(255,255,255,0.02)', border: '1px solid var(--border)', color: 'white', padding: '10px 16px', fontFamily: 'var(--font-mono)', fontSize: '0.75rem' }}
                >
                    <option value="ALL">All</option>
                    <option value="NEW">New</option>
                    <option value="CONTACTED">Contacted</option>
                    <option value="CONFIRMED">Confirmed</option>
                    <option value="CANCELLED">Cancelled</option>
                </select>
            </header>

            {loading ? (
                <div style={{ height: '50vh', display: 'grid', placeItems: 'center' }}>
                    <Loader2 className="animate-spin" size={32} color="var(--gold)" />
                </div>
            ) : (
                <div style={{ display: 'grid', gridTemplateColumns: '1fr', gap: 30 }}>
                    <div className="admin-panel shadow-premium" style={{ overflow: 'hidden' }}>
                        <table className="admin-table">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {filtered.map((r) => (
                                    <tr
                                        key={r.id}
                                        style={{ cursor: 'pointer' }}
                                        onClick={() => {
                                            setSelected(r);
                                            setShowModal(true);
                                        }}
                                    >
                                        <td style={{ color: 'white', fontWeight: 600 }}>{r.customer_name}</td>
                                        <td style={{ color: 'var(--text-dim-light)' }}>{r.email}</td>
                                        <td>
                                            <span className={`status-pill status-${(r.status || '').toLowerCase()}`}>{String(r.status || '').toUpperCase()}</span>
                                        </td>
                                    </tr>
                                ))}
                                {filtered.length === 0 && (
                                    <tr><td colSpan={3} style={{ padding: 30, color: 'var(--text-dim-light)' }}>No requests.</td></tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </div>
            )}

            {showModal && selected && (
                <div
                    role="dialog"
                    aria-modal="true"
                    style={{
                        position: 'fixed',
                        inset: 0,
                        background: 'rgba(0,0,0,0.65)',
                        display: 'grid',
                        placeItems: 'center',
                        zIndex: 4000,
                        padding: 20,
                    }}
                    onMouseDown={() => setShowModal(false)}
                >
                    <div
                        className="admin-panel shadow-premium"
                        style={{ width: 'min(860px, 96vw)', padding: 30, background: 'var(--charcoal)', border: '1px solid var(--gold)' }}
                        onMouseDown={(e) => e.stopPropagation()}
                    >
                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: 16 }}>
                            <div>
                                <div style={{ fontFamily: 'var(--font-mono)', fontSize: '0.65rem', color: 'var(--gold)', letterSpacing: '0.2em', textTransform: 'uppercase' }}>Request</div>
                                <div style={{ color: 'white', fontSize: '1.3rem', marginTop: 6 }}>{selected.customer_name}</div>
                                <div style={{ color: 'var(--text-dim-light)', marginTop: 2 }}>{selected.email}</div>
                            </div>
                            <button onClick={() => setShowModal(false)} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.4)', cursor: 'pointer' }}>
                                <X size={18} />
                            </button>
                        </div>

                        <div style={{ color: 'rgba(255,255,255,0.8)', fontSize: '0.9rem', lineHeight: 1.6 }}>
                            <div style={{ marginBottom: 10 }}><strong>Status:</strong> {String(selected.status || '').toUpperCase()}</div>
                            {selected.booking_id && <div style={{ marginBottom: 10 }}><strong>Booking ID:</strong> {selected.booking_id}</div>}
                            <div style={{ marginBottom: 10 }}><strong>Items:</strong></div>
                            <pre style={{ whiteSpace: 'pre-wrap', background: 'rgba(255,255,255,0.02)', padding: 12, border: '1px solid var(--border)' }}>
                                {JSON.stringify(selected.items, null, 2)}
                            </pre>
                        </div>

                        <div style={{ display: 'flex', flexWrap: 'wrap', gap: 10, marginTop: 16, justifyContent: 'space-between' }}>
                            <a className="admin-btn-secondary" href={`mailto:${selected.email}`} style={{ display: 'inline-flex', alignItems: 'center', gap: 10 }}>
                                <Mail size={16} /> Email customer
                            </a>
                            <div style={{ display: 'flex', gap: 10 }}>
                                <button className="admin-btn-secondary" onClick={() => updateStatus(selected.id, 'contacted')}>Mark contacted</button>
                                <button className="admin-btn-primary" onClick={() => updateStatus(selected.id, 'confirmed')}>Confirm</button>
                                <button className="admin-btn-secondary" onClick={() => updateStatus(selected.id, 'cancelled')}>Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

