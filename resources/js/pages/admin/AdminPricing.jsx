import React, { useEffect, useMemo, useState } from 'react';
import { Loader2, Plus, Trash2, Save, X } from 'lucide-react';
import { adminService } from '../../services/api';
import '../../styles/admin-premium.css';

const SEASONS = [
    { value: 'peak', label: 'Peak' },
    { value: 'shoulder', label: 'Shoulder' },
    { value: 'low', label: 'Low' },
];

export const AdminPricing = () => {
    const [routes, setRoutes] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');

    const [activeRouteId, setActiveRouteId] = useState(null);

    const [showAdd, setShowAdd] = useState(false);
    const [adding, setAdding] = useState(false);
    const [addForm, setAddForm] = useState({ season: 'peak', min_group_size: 1, max_group_size: 2, price_per_person_cents: 0 });

    const [savingId, setSavingId] = useState(null);
    const [deletingId, setDeletingId] = useState(null);

    const activeRoute = useMemo(() => routes.find((r) => r.id === activeRouteId) || null, [routes, activeRouteId]);

    const load = async () => {
        setLoading(true);
        setError('');
        try {
            const res = await adminService.getPricingRules();
            const list = Array.isArray(res.data?.routes) ? res.data.routes : [];
            setRoutes(list);
            if (!activeRouteId && list[0]?.id) setActiveRouteId(list[0].id);
        } catch (e) {
            setError('Unable to load pricing rules.');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => { load(); }, []);

    const openAdd = () => {
        if (!activeRouteId) return;
        setAddForm({ season: 'peak', min_group_size: 1, max_group_size: 2, price_per_person_cents: Math.max(0, Number(activeRoute?.base_price || 0) * 100) });
        setShowAdd(true);
    };

    const createRule = async () => {
        if (!activeRouteId) return;
        setAdding(true);
        setError('');
        try {
            await adminService.createPricingRule({
                trekking_route_id: activeRouteId,
                season: addForm.season,
                min_group_size: Number(addForm.min_group_size),
                max_group_size: Number(addForm.max_group_size),
                price_per_person_cents: Number(addForm.price_per_person_cents),
            });
            await load();
            setShowAdd(false);
        } catch (e) {
            setError(e.response?.data?.message || 'Unable to create rule.');
        } finally {
            setAdding(false);
        }
    };

    const saveRule = async (rule) => {
        setSavingId(rule.id);
        setError('');
        try {
            await adminService.updatePricingRule(rule.id, {
                season: rule.season,
                min_group_size: Number(rule.min_group_size),
                max_group_size: Number(rule.max_group_size),
                price_per_person_cents: Number(rule.price_per_person_cents),
            });
            await load();
        } catch (e) {
            setError(e.response?.data?.message || 'Unable to save rule.');
        } finally {
            setSavingId(null);
        }
    };

    const deleteRule = async (ruleId) => {
        if (!window.confirm('Delete this pricing rule?')) return;
        setDeletingId(ruleId);
        setError('');
        try {
            await adminService.deletePricingRule(ruleId);
            await load();
        } catch (e) {
            setError(e.response?.data?.message || 'Unable to delete rule.');
        } finally {
            setDeletingId(null);
        }
    };

    const updateActiveRuleLocal = (ruleId, patch) => {
        setRoutes((prev) => prev.map((r) => {
            if (r.id !== activeRouteId) return r;
            return {
                ...r,
                pricing_rules: (r.pricing_rules || []).map((pr) => (pr.id === ruleId ? { ...pr, ...patch } : pr)),
            };
        }));
    };

    if (loading) {
        return (
            <div style={{ height: '60vh', display: 'grid', placeItems: 'center' }}>
                <Loader2 className="animate-spin" size={32} color="var(--gold)" />
            </div>
        );
    }

    return (
        <div className="admin-page-root">
            <header style={{ marginBottom: 50, display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                <div>
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.25em', textTransform: 'uppercase', marginBottom: 12 }}>Pricing</h2>
                    <h1 className="admin-page-title" style={{ fontSize: '3.5rem', fontWeight: 300 }}>Private Trek Pricing</h1>
                </div>
                <div style={{ display: 'flex', gap: 12, alignItems: 'center' }}>
                    <select
                        value={activeRouteId || ''}
                        onChange={(e) => setActiveRouteId(Number(e.target.value))}
                        style={{ background: 'rgba(255,255,255,0.02)', border: '1px solid var(--border)', color: 'white', padding: '10px 16px', fontFamily: 'var(--font-mono)', fontSize: '0.75rem' }}
                    >
                        {routes.map((r) => <option key={r.id} value={r.id}>{r.name} ({r.slug})</option>)}
                    </select>
                    <button className="admin-btn-primary" onClick={openAdd} disabled={!activeRouteId}>
                        <Plus size={16} /> Add rule
                    </button>
                </div>
            </header>

            {error ? (
                <div style={{ marginBottom: 14, padding: 12, border: '1px solid rgba(248,113,113,0.3)', background: 'rgba(248,113,113,0.08)', color: '#F87171' }}>
                    {error}
                </div>
            ) : null}

            <div className="admin-panel shadow-premium" style={{ padding: 26 }}>
                <div style={{ color: 'var(--text-dim-light)', marginBottom: 16, lineHeight: 1.6 }}>
                    These rules power the <strong>price estimate</strong> shown on each trekking route page. Add one rule per season and group-size range.
                </div>

                {!activeRoute ? (
                    <div style={{ color: 'var(--text-dim-light)' }}>No trekking routes found.</div>
                ) : (activeRoute.pricing_rules?.length ? (
                    <div style={{ display: 'grid', gap: 10 }}>
                        {activeRoute.pricing_rules.map((rule) => (
                            <div key={rule.id} style={{ display: 'grid', gridTemplateColumns: '140px 1fr 1fr 1fr 120px', gap: 10, alignItems: 'center', border: '1px solid var(--border)', padding: 12 }}>
                                <select
                                    value={rule.season || 'peak'}
                                    onChange={(e) => updateActiveRuleLocal(rule.id, { season: e.target.value })}
                                    style={{ background: '#0a0a0a', border: '1px solid var(--border)', color: 'white', padding: '10px 12px' }}
                                >
                                    {SEASONS.map((s) => <option key={s.value} value={s.value}>{s.label}</option>)}
                                </select>
                                <input
                                    type="number"
                                    min={1}
                                    max={20}
                                    value={rule.min_group_size ?? 1}
                                    onChange={(e) => updateActiveRuleLocal(rule.id, { min_group_size: Number(e.target.value) })}
                                    style={{ background: '#0a0a0a', border: '1px solid var(--border)', color: 'white', padding: '10px 12px' }}
                                    placeholder="Min group size"
                                />
                                <input
                                    type="number"
                                    min={1}
                                    max={20}
                                    value={rule.max_group_size ?? 2}
                                    onChange={(e) => updateActiveRuleLocal(rule.id, { max_group_size: Number(e.target.value) })}
                                    style={{ background: '#0a0a0a', border: '1px solid var(--border)', color: 'white', padding: '10px 12px' }}
                                    placeholder="Max group size"
                                />
                                <input
                                    type="number"
                                    min={0}
                                    value={rule.price_per_person_cents ?? 0}
                                    onChange={(e) => updateActiveRuleLocal(rule.id, { price_per_person_cents: Number(e.target.value) })}
                                    style={{ background: '#0a0a0a', border: '1px solid var(--border)', color: 'white', padding: '10px 12px' }}
                                    placeholder="Price (cents)"
                                />
                                <div style={{ display: 'flex', gap: 8, justifyContent: 'flex-end' }}>
                                    <button className="admin-btn-secondary" onClick={() => saveRule(rule)} disabled={savingId === rule.id}>
                                        {savingId === rule.id ? <Loader2 className="animate-spin" size={16} /> : <Save size={16} />}
                                    </button>
                                    <button className="admin-btn-secondary" onClick={() => deleteRule(rule.id)} disabled={deletingId === rule.id}>
                                        {deletingId === rule.id ? <Loader2 className="animate-spin" size={16} /> : <Trash2 size={16} />}
                                    </button>
                                </div>
                            </div>
                        ))}
                    </div>
                ) : (
                    <div style={{ color: 'var(--text-dim-light)' }}>
                        No pricing rules yet for this route. Click <strong>Add rule</strong> to set them up.
                    </div>
                ))}
            </div>

            {showAdd && (
                <div
                    role="dialog"
                    aria-modal="true"
                    style={{ position: 'fixed', inset: 0, background: 'rgba(0,0,0,0.65)', display: 'grid', placeItems: 'center', zIndex: 4000, padding: 20 }}
                    onMouseDown={() => !adding && setShowAdd(false)}
                >
                    <div
                        className="admin-panel shadow-premium"
                        style={{ width: 'min(760px, 96vw)', padding: 28, border: '1px solid var(--gold)', background: 'var(--charcoal)' }}
                        onMouseDown={(e) => e.stopPropagation()}
                    >
                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: 18 }}>
                            <div>
                                <h2 style={{ color: 'white', fontWeight: 300, margin: 0, fontSize: '1.8rem' }}>Add pricing rule</h2>
                                <div style={{ color: 'var(--text-dim-light)', marginTop: 6 }}>{activeRoute?.name}</div>
                            </div>
                            <button onClick={() => !adding && setShowAdd(false)} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.25)', cursor: 'pointer' }}>
                                <X size={24} />
                            </button>
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '160px 1fr 1fr 1fr', gap: 10 }}>
                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={{ fontSize: 12, color: 'var(--text-dim-light)', letterSpacing: 1, textTransform: 'uppercase' }}>Season</span>
                                <select value={addForm.season} onChange={(e) => setAddForm((s) => ({ ...s, season: e.target.value }))} style={{ background: '#0a0a0a', border: '1px solid var(--border)', color: 'white', padding: '10px 12px' }}>
                                    {SEASONS.map((s) => <option key={s.value} value={s.value}>{s.label}</option>)}
                                </select>
                            </label>
                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={{ fontSize: 12, color: 'var(--text-dim-light)', letterSpacing: 1, textTransform: 'uppercase' }}>Min group size</span>
                                <input type="number" min={1} max={20} value={addForm.min_group_size} onChange={(e) => setAddForm((s) => ({ ...s, min_group_size: Number(e.target.value) }))} style={{ background: '#0a0a0a', border: '1px solid var(--border)', color: 'white', padding: '10px 12px' }} />
                            </label>
                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={{ fontSize: 12, color: 'var(--text-dim-light)', letterSpacing: 1, textTransform: 'uppercase' }}>Max group size</span>
                                <input type="number" min={1} max={20} value={addForm.max_group_size} onChange={(e) => setAddForm((s) => ({ ...s, max_group_size: Number(e.target.value) }))} style={{ background: '#0a0a0a', border: '1px solid var(--border)', color: 'white', padding: '10px 12px' }} />
                            </label>
                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={{ fontSize: 12, color: 'var(--text-dim-light)', letterSpacing: 1, textTransform: 'uppercase' }}>Price per person (cents)</span>
                                <input type="number" min={0} value={addForm.price_per_person_cents} onChange={(e) => setAddForm((s) => ({ ...s, price_per_person_cents: Number(e.target.value) }))} style={{ background: '#0a0a0a', border: '1px solid var(--border)', color: 'white', padding: '10px 12px' }} />
                            </label>
                        </div>

                        <div style={{ marginTop: 18, display: 'flex', gap: 10, justifyContent: 'flex-end' }}>
                            <button className="admin-btn-secondary" onClick={() => !adding && setShowAdd(false)}>Cancel</button>
                            <button className="admin-btn-primary" onClick={createRule} disabled={adding}>
                                {adding ? <Loader2 className="animate-spin" size={16} /> : <Save size={16} />}
                                <span style={{ marginLeft: 8 }}>{adding ? 'Saving…' : 'Save rule'}</span>
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

