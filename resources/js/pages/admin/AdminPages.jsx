import React, { useEffect, useMemo, useState } from 'react';
import { Loader2 } from 'lucide-react';
import { adminService } from '../../services/api';
import '../../styles/admin-premium.css';

const CORE_SLUGS = ['home', 'about', 'routes-overview', 'contact'];

export const AdminPages = () => {
    const [pages, setPages] = useState([]);
    const [loading, setLoading] = useState(true);
    const [saving, setSaving] = useState(false);
    const [error, setError] = useState('');
    const [activeSlug, setActiveSlug] = useState('home');
    const [form, setForm] = useState({ title: '', content: '', meta_title: '', meta_description: '', og_image: '' });
    const [creating, setCreating] = useState(false);
    const [createSlug, setCreateSlug] = useState('');
    const [createTitle, setCreateTitle] = useState('');

    const activePage = useMemo(() => pages.find((p) => p.slug === activeSlug) || null, [activeSlug, pages]);
    const slugOptions = useMemo(() => {
        const dynamic = pages.map((p) => p.slug).filter(Boolean);
        const merged = Array.from(new Set([...CORE_SLUGS, ...dynamic]));
        return merged.sort();
    }, [pages]);

    const load = async () => {
        setLoading(true);
        setError('');
        try {
            const res = await adminService.getPages();
            const list = Array.isArray(res.data) ? res.data : [];
            setPages(list);
        } catch (e) {
            setError('Unable to load pages.');
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => { load(); }, []);

    useEffect(() => {
        if (!activePage) return;
        setForm({
            title: activePage.title || '',
            content: activePage.content || '',
            meta_title: activePage.meta_title || '',
            meta_description: activePage.meta_description || '',
            og_image: activePage.og_image || '',
        });
    }, [activePage]);

    const save = async () => {
        if (!activeSlug) return;
        setSaving(true);
        setError('');
        try {
            const res = await adminService.updatePage(activeSlug, form);
            const updated = res.data;
            setPages((prev) => prev.map((p) => (p.slug === activeSlug ? updated : p)));
        } catch (e) {
            setError(e.response?.data?.message || 'Unable to save changes.');
        } finally {
            setSaving(false);
        }
    };

    const create = async () => {
        const slug = String(createSlug || '').trim();
        const title = String(createTitle || '').trim();
        if (!slug || !title) {
            setError('Slug and title are required.');
            return;
        }
        setCreating(true);
        setError('');
        try {
            const res = await adminService.createPage({
                slug,
                title,
                content: '',
                meta_title: '',
                meta_description: '',
                og_image: '',
            });
            const created = res.data;
            setPages((prev) => [...prev, created]);
            setActiveSlug(created.slug);
            setCreateSlug('');
            setCreateTitle('');
        } catch (e) {
            setError(e.response?.data?.message || 'Unable to create page.');
        } finally {
            setCreating(false);
        }
    };

    return (
        <div className="admin-page-root">
            <header style={{ marginBottom: 50, display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                <div>
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.25em', textTransform: 'uppercase', marginBottom: 12 }}>Content</h2>
                    <h1 className="admin-page-title" style={{ fontSize: '3.5rem', fontWeight: 300 }}>Pages</h1>
                </div>
                <div style={{ display: 'flex', gap: 12, alignItems: 'center' }}>
                    <select
                        value={activeSlug}
                        onChange={(e) => setActiveSlug(e.target.value)}
                        style={{ background: 'rgba(255,255,255,0.02)', border: '1px solid var(--border)', color: 'white', padding: '10px 16px', fontFamily: 'var(--font-mono)', fontSize: '0.75rem' }}
                    >
                        {slugOptions.map((s) => <option key={s} value={s}>{s}</option>)}
                    </select>
                    <button className="admin-btn-primary" disabled={saving || loading || !activePage} onClick={save}>
                        {saving ? 'Saving…' : 'Save'}
                    </button>
                </div>
            </header>

            {loading ? (
                <div style={{ height: '50vh', display: 'grid', placeItems: 'center' }}>
                    <Loader2 className="animate-spin" size={32} color="var(--gold)" />
                </div>
            ) : (
                <div className="admin-panel shadow-premium" style={{ padding: 30 }}>
                    {error && (
                        <div style={{ marginBottom: 14, padding: 12, border: '1px solid rgba(248,113,113,0.3)', background: 'rgba(248,113,113,0.08)', color: '#F87171' }}>
                            {error}
                        </div>
                    )}

                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 150px', gap: 10, marginBottom: 18 }}>
                        <input
                            placeholder="New page slug (e.g. company-our-guides)"
                            value={createSlug}
                            onChange={(e) => setCreateSlug(e.target.value)}
                            style={{ background: '#0a0a0a', border: '1px solid var(--border)', padding: '10px 12px', color: 'white' }}
                        />
                        <input
                            placeholder="New page title"
                            value={createTitle}
                            onChange={(e) => setCreateTitle(e.target.value)}
                            style={{ background: '#0a0a0a', border: '1px solid var(--border)', padding: '10px 12px', color: 'white' }}
                        />
                        <button className="admin-btn-secondary" disabled={creating} onClick={create}>
                            {creating ? 'Creating…' : 'Create'}
                        </button>
                    </div>

                    {!activePage ? (
                        <div style={{ color: 'var(--text-dim)' }}>
                            Missing page record for <strong>{activeSlug}</strong>. Create it above.
                        </div>
                    ) : (
                        <div style={{ display: 'grid', gridTemplateColumns: '1fr', gap: 14 }}>
                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={{ fontSize: 12, color: 'var(--text-dim)', letterSpacing: 1, textTransform: 'uppercase' }}>Title</span>
                                <input
                                    value={form.title}
                                    onChange={(e) => setForm((s) => ({ ...s, title: e.target.value }))}
                                    style={{ background: '#0a0a0a', border: '1px solid var(--border)', padding: '10px 12px', color: 'white' }}
                                />
                            </label>

                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={{ fontSize: 12, color: 'var(--text-dim)', letterSpacing: 1, textTransform: 'uppercase' }}>Content (HTML)</span>
                                <textarea
                                    value={form.content}
                                    onChange={(e) => setForm((s) => ({ ...s, content: e.target.value }))}
                                    rows={14}
                                    style={{ background: '#0a0a0a', border: '1px solid var(--border)', padding: '10px 12px', color: 'white', lineHeight: 1.6 }}
                                />
                            </label>

                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 14 }}>
                                <label style={{ display: 'grid', gap: 6 }}>
                                    <span style={{ fontSize: 12, color: 'var(--text-dim)', letterSpacing: 1, textTransform: 'uppercase' }}>Meta title</span>
                                    <input
                                        value={form.meta_title}
                                        onChange={(e) => setForm((s) => ({ ...s, meta_title: e.target.value }))}
                                        style={{ background: '#0a0a0a', border: '1px solid var(--border)', padding: '10px 12px', color: 'white' }}
                                    />
                                </label>
                                <label style={{ display: 'grid', gap: 6 }}>
                                    <span style={{ fontSize: 12, color: 'var(--text-dim)', letterSpacing: 1, textTransform: 'uppercase' }}>OG image URL</span>
                                    <input
                                        value={form.og_image}
                                        onChange={(e) => setForm((s) => ({ ...s, og_image: e.target.value }))}
                                        style={{ background: '#0a0a0a', border: '1px solid var(--border)', padding: '10px 12px', color: 'white' }}
                                    />
                                    <input
                                        type="file"
                                        accept="image/*"
                                        onChange={async (e) => {
                                            const file = e.target.files?.[0];
                                            if (!file) return;
                                            try {
                                                const res = await adminService.upload(file, `pages/${activeSlug}`);
                                                setForm((s) => ({ ...s, og_image: res.data.url }));
                                            } finally {
                                                e.target.value = '';
                                            }
                                        }}
                                        style={{ marginTop: 8 }}
                                    />
                                </label>
                            </div>

                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={{ fontSize: 12, color: 'var(--text-dim)', letterSpacing: 1, textTransform: 'uppercase' }}>Meta description</span>
                                <textarea
                                    value={form.meta_description}
                                    onChange={(e) => setForm((s) => ({ ...s, meta_description: e.target.value }))}
                                    rows={4}
                                    style={{ background: '#0a0a0a', border: '1px solid var(--border)', padding: '10px 12px', color: 'white', lineHeight: 1.6 }}
                                />
                            </label>
                        </div>
                    )}
                </div>
            )}
        </div>
    );
};

