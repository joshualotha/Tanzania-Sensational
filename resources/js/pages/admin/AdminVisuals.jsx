import React, { useMemo, useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    Save, Image as ImageIcon, Link as LinkIcon, RefreshCw, 
    ChevronDown, ChevronUp, Maximize2, ExternalLink, Globe, Layers,
    Plus, Search, Trash2, Shield, Eye, Loader2, Zap
} from 'lucide-react';
import { adminService, visualAssetService } from '../../services/api';
import { visualsData } from '../../data/visualsData';
import '../../styles/admin-premium.css';

const BASE_PLACEMENTS = [
    { id: 'custom', label: 'Custom (advanced)', section: null },
    { id: 'homeHero', label: 'Home / Hero (rotating)', section: 'home.hero' },
];

function humanizeSegment(seg) {
    return String(seg || '')
        .replace(/([a-z])([A-Z])/g, '$1 $2')
        .replace(/[_-]+/g, ' ')
        .trim();
}

function titleCase(s) {
    const str = String(s || '');
    return str ? str.charAt(0).toUpperCase() + str.slice(1) : '';
}

function labelFromSection(section) {
    const parts = String(section || '').split('.').filter(Boolean);
    return parts.map((p) => titleCase(humanizeSegment(p))).join(' / ');
}

function collectSectionsFromVisuals(obj, prefix = '') {
    const out = [];
    if (!obj || typeof obj !== 'object') return out;

    for (const [k, v] of Object.entries(obj)) {
        const path = prefix ? `${prefix}.${k}` : k;
        if (typeof v === 'string') {
            out.push({ section: path, kind: 'single' });
        } else if (Array.isArray(v)) {
            if (v.every((x) => typeof x === 'string')) {
                out.push({ section: path, kind: 'list' });
            }
        } else if (v && typeof v === 'object') {
            out.push(...collectSectionsFromVisuals(v, path));
        }
    }
    return out;
}

function formatSectionLabel(section) {
    if (!section) return '';
    const key = String(section);
    return labelFromSection(key);
}

export const AdminVisuals = () => {
    const [assets, setAssets] = useState([]);
    const [pagination, setPagination] = useState({ current_page: 1, last_page: 1, per_page: 24, total: 0 });
    const [loading, setLoading] = useState(true);
    const [selectedAsset, setSelectedAsset] = useState(null);
    const [saving, setSaving] = useState(false);
    const [searchTerm, setSearchTerm] = useState('');
    const [showAdd, setShowAdd] = useState(false);
    const [adding, setAdding] = useState(false);
    const [addError, setAddError] = useState('');
    const [deleteFile, setDeleteFile] = useState(false);
    const [showEditor, setShowEditor] = useState(false);
    const [placementId, setPlacementId] = useState('custom');
    const [placementQuery, setPlacementQuery] = useState('');

    const mediaPlacements = useMemo(() => {
        const seen = new Set();
        const auto = collectSectionsFromVisuals(visualsData).map((item) => {
            const section = item.section;
            const id = `auto_${section.replace(/[^a-zA-Z0-9]+/g, '_')}`;
            const labelBase = labelFromSection(section);
            const label = item.kind === 'list' ? `${labelBase} (gallery)` : labelBase;
            return { id, label, section };
        });

        const combined = [...BASE_PLACEMENTS, ...auto]
            .filter((p) => {
                const key = p.section || p.id;
                if (seen.has(key)) return false;
                seen.add(key);
                return true;
            })
            .sort((a, b) => {
                if (a.id === 'custom') return -1;
                if (b.id === 'custom') return 1;
                if (a.section === 'home.hero') return -1;
                if (b.section === 'home.hero') return 1;
                return String(a.label).localeCompare(String(b.label));
            });

        return combined;
    }, []);

    const filteredPlacements = useMemo(() => {
        const q = String(placementQuery || '').trim().toLowerCase();
        if (!q) return mediaPlacements;
        return mediaPlacements.filter((p) => {
            const hay = `${p.label} ${p.section || ''}`.toLowerCase();
            return hay.includes(q);
        });
    }, [mediaPlacements, placementQuery]);

    const [draft, setDraft] = useState({
        section: '',
        source: 'upload', // upload | url
        key: '',
        url: '',
        type: 'image',
        metadata: { alt: '', caption: '' },
        file: null,
        filename: '',
    });

    useEffect(() => {
        fetchAssets();
    }, []);

    const fetchAssets = async (opts = {}) => {
        try {
            setLoading(true);
            const page = opts.page ?? pagination.current_page ?? 1;
            const section = opts.section ?? (activeCategory === 'All' ? '' : activeCategory);
            const q = opts.q ?? searchTerm;

            const response = await visualAssetService.adminGetAll({
                params: { page, per_page: pagination.per_page, section: section || undefined, q: q || undefined }
            });

            const rows = Array.isArray(response.data?.data) ? response.data.data : (Array.isArray(response.data) ? response.data : []);
            setAssets(rows);
            if (!selectedAsset && rows.length > 0) setSelectedAsset(rows[0]);

            if (response.data?.current_page) {
                setPagination({
                    current_page: response.data.current_page,
                    last_page: response.data.last_page,
                    per_page: response.data.per_page,
                    total: response.data.total,
                });
            }
        } catch (error) {
            console.error("Failed to load media library:", error);
        } finally {
            setLoading(false);
        }
    };

    const normalizeKey = (value) => {
        return String(value || '')
            .trim()
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '_')
            .replace(/^_+|_+$/g, '');
    };

    const inferFilename = (fileOrUrl) => {
        if (!fileOrUrl) return '';
        if (typeof fileOrUrl === 'string') {
            const clean = fileOrUrl.split('?')[0].split('#')[0];
            const parts = clean.split('/');
            return parts[parts.length - 1] || '';
        }
        return fileOrUrl.name || '';
    };

    const proposeKey = (section, fileOrUrl) => {
        const s = normalizeKey(section);
        const fn = normalizeKey(inferFilename(fileOrUrl).replace(/\.[^.]+$/, ''));
        if (!s && !fn) return '';
        if (!s) return fn;
        if (!fn) return s;
        return `${s}_${fn}`;
    };

    const openAddModal = () => {
        setAddError('');
        setShowAdd(true);
        const defaultSection = activeCategory !== 'All' ? activeCategory : '';
        const placement = mediaPlacements.find((p) => p.section && p.section === defaultSection)?.id || 'custom';
        setPlacementId(placement);
        setDraft({
            section: placement === 'custom' ? defaultSection : (mediaPlacements.find((p) => p.id === placement)?.section || defaultSection),
            source: 'upload',
            key: '',
            url: '',
            type: 'image',
            metadata: { alt: '', caption: '' },
            file: null,
            filename: '',
        });
    };

    const handleCreate = async () => {
        setAddError('');
        setAdding(true);
        try {
            let finalUrl = draft.url;
            if (draft.source === 'upload') {
                if (!draft.file) {
                    setAddError('Select a file to upload.');
                    return;
                }
                const folder = `visual-assets/${normalizeKey(draft.section || 'general')}`;
                const up = await adminService.upload(draft.file, folder);
                finalUrl = up.data?.url;
            } else {
                if (!finalUrl?.trim()) {
                    setAddError('Paste an image URL.');
                    return;
                }
            }

            const payload = {
                section: draft.section || 'general',
                key: draft.key || proposeKey(draft.section, draft.file || finalUrl),
                url: finalUrl,
                type: draft.type || 'image',
                metadata: {
                    ...(draft.metadata || {}),
                },
            };

            if (!payload.key) {
                setAddError('Key is required.');
                return;
            }

            await visualAssetService.adminCreate(payload);
            setShowAdd(false);
            await fetchAssets({ page: 1 });
        } catch (e) {
            setAddError(e.response?.data?.message || 'Unable to create media item.');
        } finally {
            setAdding(false);
        }
    };

    const handleUpdate = async (key, data) => {
        try {
            setSaving(true);
            await visualAssetService.adminUpdate(key, data);
            await fetchAssets();
        } catch (error) {
            alert("Asset synchronization failed.");
        } finally {
            setSaving(false);
        }
    };

    const handleDelete = async (key) => {
        if (!window.confirm("Delete this media item?")) return;
        try {
            const params = deleteFile ? { delete_file: 1 } : undefined;
            await visualAssetService.adminDelete(key, { params });
            setAssets(assets.filter(a => a.key !== key));
            setSelectedAsset(null);
        } catch (error) {
            alert("Unable to delete the media item.");
        }
    };

    const categories = useMemo(() => ['All', ...new Set(assets.map(a => a.section).filter(Boolean))], [assets]);
    const [activeCategory, setActiveCategory] = useState('All');

    const displayAssets = assets;

    if (loading) return (
        <div style={{ height: '60vh', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center' }}>
            <Loader2 className="animate-spin" size={48} color="var(--gold)" />
            <span style={{ marginTop: '20px', fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--gold)', letterSpacing: '0.2em' }}>Loading media…</span>
        </div>
    );

    return (
        <div className="admin-visuals-root">
            <header style={{ marginBottom: '50px', display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                <div>
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.2em', textTransform: 'uppercase', marginBottom: '10px' }}>Media</h2>
                    <h1 className="admin-page-title">Media library</h1>
                </div>
                <div style={{ display: 'flex', gap: '15px' }}>
                    <button className="admin-btn-secondary" onClick={() => fetchAssets({ page: 1 })}>
                        <RefreshCw size={14} /> Refresh
                    </button>
                    <button className="admin-btn-primary" onClick={openAddModal}>
                        <Plus size={18} /> Add media
                    </button>
                </div>
            </header>

                <div className="visuals-command-grid" style={{ display: 'grid', gridTemplateColumns: '300px 1fr', gap: '30px', alignItems: 'start' }}>
                
                {/* 1. SECTOR FILTERS */}
                <div className="admin-panel shadow-premium" style={{ padding: '25px' }}>
                    <h4 style={SectionHeadStyle}><Globe size={14} /> Sections</h4>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '8px' }}>
                        {categories.map(cat => (
                            <button 
                                key={cat}
                                onClick={() => {
                                    setActiveCategory(cat);
                                    fetchAssets({ page: 1, section: cat === 'All' ? '' : cat });
                                }}
                                style={{ 
                                    padding: '12px 15px', 
                                    background: activeCategory === cat ? 'var(--gold-glow)' : 'transparent',
                                    border: '1px solid',
                                    borderColor: activeCategory === cat ? 'var(--gold)' : 'transparent',
                                    color: activeCategory === cat ? 'white' : 'var(--text-dim)',
                                    textAlign: 'left',
                                    fontSize: '0.8rem',
                                    textTransform: 'uppercase',
                                    fontFamily: 'var(--font-mono)',
                                    cursor: 'pointer',
                                    transition: '0.3s'
                                }}
                            >
                                {cat === 'All' ? 'All' : formatSectionLabel(cat)}
                            </button>
                        ))}
                    </div>
                </div>

                {/* 2. ASSET LIST */}
                <div className="assets-log-viewport">
                    <div className="admin-search-container" style={{ position: 'relative', marginBottom: '30px' }}>
                        <Search size={16} style={{ position: 'absolute', left: '15px', top: '50%', transform: 'translateY(-50%)', color: 'var(--text-dim)' }} />
                        <input 
                            type="text" 
                            placeholder="Search by key or section…" 
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            onKeyDown={(e) => {
                                if (e.key === 'Enter') fetchAssets({ page: 1, q: e.currentTarget.value });
                            }}
                            style={{ 
                                width: '100%', 
                                background: '#111', 
                                border: '1px solid var(--border)', 
                                padding: '12px 15px 12px 45px', 
                                color: 'white', 
                                fontSize: '0.7rem', 
                                fontFamily: 'var(--font-mono)'
                            }}
                        />
                    </div>

                    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(150px, 1fr))', gap: '15px' }}>
                        {displayAssets.map(asset => (
                            <motion.div 
                                key={asset.key}
                                layoutId={asset.key}
                                onClick={() => {
                                    setSelectedAsset(asset);
                                    setShowEditor(true);
                                }}
                                whileHover={{ scale: 1.02 }}
                                style={{ 
                                    position: 'relative', 
                                    aspectRatio: '1', 
                                    background: '#000', 
                                    border: '1px solid',
                                    borderColor: selectedAsset?.key === asset.key ? 'var(--gold)' : 'var(--border)',
                                    cursor: 'pointer',
                                    overflow: 'hidden'
                                }}
                            >
                                <img src={asset.url} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover', opacity: 0.6 }} />
                                <div style={{ 
                                    position: 'absolute', 
                                    bottom: 0, 
                                    left: 0, 
                                    right: 0, 
                                    padding: '8px', 
                                    background: 'rgba(0,0,0,0.8)',
                                    fontSize: '0.6rem',
                                    color: 'white',
                                    fontFamily: 'var(--font-mono)',
                                    borderTop: '1px solid var(--border)'
                                }}>
                                    {asset.key.split('_').pop().toUpperCase()}
                                </div>
                                {selectedAsset?.key === asset.key && (
                                    <div style={{ position: 'absolute', top: '10px', right: '10px' }}>
                                        <Zap size={14} color="var(--gold)" className="animate-pulse" />
                                    </div>
                                )}
                            </motion.div>
                        ))}
                    </div>

                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginTop: 25, color: 'var(--text-dim)', fontSize: '0.75rem' }}>
                        <span>
                            {pagination.total ? `Showing page ${pagination.current_page} of ${pagination.last_page} (${pagination.total} items)` : ''}
                        </span>
                        <div style={{ display: 'flex', gap: 10 }}>
                            <button className="admin-btn-secondary" disabled={pagination.current_page <= 1} onClick={() => fetchAssets({ page: pagination.current_page - 1 })}>
                                Prev
                            </button>
                            <button className="admin-btn-secondary" disabled={pagination.current_page >= pagination.last_page} onClick={() => fetchAssets({ page: pagination.current_page + 1 })}>
                                Next
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            {showEditor && selectedAsset && (
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
                    onMouseDown={() => setShowEditor(false)}
                >
                    <div
                        className="admin-panel shadow-premium"
                        style={{ width: 'min(920px, 96vw)', padding: 30, background: 'var(--charcoal)', border: '1px solid var(--gold)' }}
                        onMouseDown={(e) => e.stopPropagation()}
                    >
                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', gap: 16, marginBottom: 16 }}>
                            <div>
                                <h4 style={SectionHeadStyle}><Layers size={14} /> Media item</h4>
                                <div style={{ color: 'white', fontSize: '1.1rem' }}>{selectedAsset.key}</div>
                            </div>
                            <button onClick={() => setShowEditor(false)} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.3)', cursor: 'pointer' }}>
                                <Trash2 size={18} style={{ opacity: 0 }} />
                            </button>
                        </div>

                        <div style={{ aspectRatio: '16/9', background: '#000', border: '1px solid var(--border)', borderRadius: 4, marginBottom: 18, overflow: 'hidden' }}>
                            <img src={selectedAsset.url} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 14 }}>
                            <div className="form-group-premium">
                                <label style={LabelStyle}>Section</label>
                                <div style={{ color: 'white', fontSize: '0.9rem' }}>{formatSectionLabel(selectedAsset.section)}</div>
                            </div>
                            <div className="form-group-premium">
                                <label style={LabelStyle}>Key</label>
                                <div style={{ color: 'var(--gold)', fontFamily: 'var(--font-mono)', fontSize: '0.8rem' }}>{selectedAsset.key}</div>
                            </div>
                            <div className="form-group-premium" style={{ gridColumn: '1 / -1' }}>
                                <label style={LabelStyle}>URL</label>
                                <textarea
                                    value={selectedAsset.url}
                                    onChange={(e) => setSelectedAsset({ ...selectedAsset, url: e.target.value })}
                                    style={{ ...CompactInput, height: 90, resize: 'none' }}
                                />
                            </div>
                        </div>

                        <div style={{ display: 'flex', justifyContent: 'space-between', gap: 10, marginTop: 16, alignItems: 'center' }}>
                            {String(selectedAsset.url || '').startsWith('/storage/') ? (
                                <label style={{ display: 'flex', gap: 10, alignItems: 'center', color: 'var(--text-dim)', fontSize: '0.75rem' }}>
                                    <input type="checkbox" checked={deleteFile} onChange={(e) => setDeleteFile(e.target.checked)} />
                                    Also delete stored file
                                </label>
                            ) : <span />}

                            <div style={{ display: 'flex', gap: 10 }}>
                                <button className="admin-btn-secondary" onClick={() => setShowEditor(false)} disabled={saving}>Close</button>
                                <button
                                    className="admin-btn-primary"
                                    disabled={saving}
                                    onClick={async () => {
                                        await handleUpdate(selectedAsset.key, { url: selectedAsset.url });
                                    }}
                                >
                                    {saving ? <Loader2 className="animate-spin" size={16} /> : <Save size={16} />} Save
                                </button>
                                <button
                                    className="admin-btn-secondary"
                                    style={{ color: '#ff4444' }}
                                    onClick={() => handleDelete(selectedAsset.key)}
                                    disabled={saving}
                                >
                                    <Trash2 size={16} />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            )}

            {showAdd && (
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
                    onMouseDown={() => !adding && setShowAdd(false)}
                >
                    <div
                        className="admin-panel shadow-premium"
                        style={{ width: 'min(860px, 96vw)', padding: 28, background: 'var(--charcoal)' }}
                        onMouseDown={(e) => e.stopPropagation()}
                    >
                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', gap: 16 }}>
                            <div>
                                <div style={{ fontFamily: 'var(--font-mono)', fontSize: '0.65rem', color: 'var(--gold)', letterSpacing: '0.2em', textTransform: 'uppercase' }}>Add media</div>
                                <div style={{ color: 'white', fontSize: '1.3rem', marginTop: 6 }}>Create a new media item</div>
                            </div>
                            <button onClick={() => !adding && setShowAdd(false)} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.4)', cursor: 'pointer' }}>
                                <Shield size={18} />
                            </button>
                        </div>

                        {addError && (
                            <div style={{ marginTop: 14, padding: 12, border: '1px solid rgba(248,113,113,0.3)', background: 'rgba(248,113,113,0.08)', color: '#F87171' }}>
                                {addError}
                            </div>
                        )}

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 14, marginTop: 16 }}>
                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={LabelStyle}>Placement</span>
                                <input
                                    value={placementQuery}
                                    onChange={(e) => setPlacementQuery(e.target.value)}
                                    placeholder="Search placements…"
                                    style={CompactInput}
                                />
                                <select
                                    value={placementId}
                                    onChange={(e) => {
                                        const nextId = e.target.value;
                                        setPlacementId(nextId);
                                        const section = mediaPlacements.find((p) => p.id === nextId)?.section || '';
                                        setDraft((d) => ({
                                            ...d,
                                            section: section || d.section,
                                            key: d.key || proposeKey(section || d.section, d.file || d.url),
                                        }));
                                    }}
                                    style={CompactInput}
                                >
                                    {filteredPlacements.map((p) => (
                                        <option key={p.id} value={p.id}>{p.label}</option>
                                    ))}
                                </select>
                            </label>

                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={LabelStyle}>Section *</span>
                                <input
                                    value={draft.section}
                                    onChange={(e) => {
                                        const section = e.target.value;
                                        setDraft((d) => ({
                                            ...d,
                                            section,
                                            key: d.key || proposeKey(section, d.file || d.url),
                                        }));
                                    }}
                                    style={CompactInput}
                                    disabled={placementId !== 'custom'}
                                    placeholder="e.g. home, trekking.routes, blog"
                                />
                            </label>

                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={LabelStyle}>Source</span>
                                <select
                                    value={draft.source}
                                    onChange={(e) => {
                                        const source = e.target.value;
                                        setDraft((d) => ({
                                            ...d,
                                            source,
                                            url: source === 'upload' ? '' : d.url,
                                        }));
                                    }}
                                    style={CompactInput}
                                >
                                    <option value="upload">Upload file</option>
                                    <option value="url">External URL</option>
                                </select>
                            </label>

                            {draft.source === 'upload' ? (
                                <label style={{ display: 'grid', gap: 6 }}>
                                    <span style={LabelStyle}>File *</span>
                                    <input
                                        type="file"
                                        accept="image/*"
                                        onChange={(e) => {
                                            const file = e.target.files?.[0] || null;
                                            setDraft((d) => ({
                                                ...d,
                                                file,
                                                filename: file ? file.name : '',
                                                key: d.key || proposeKey(d.section, file),
                                            }));
                                        }}
                                        style={{ color: 'white' }}
                                    />
                                </label>
                            ) : (
                                <label style={{ display: 'grid', gap: 6 }}>
                                    <span style={LabelStyle}>URL *</span>
                                    <input
                                        value={draft.url}
                                        onChange={(e) => {
                                            const url = e.target.value;
                                            setDraft((d) => ({
                                                ...d,
                                                url,
                                                key: d.key || proposeKey(d.section, url),
                                            }));
                                        }}
                                        style={CompactInput}
                                        placeholder="https://..."
                                    />
                                </label>
                            )}

                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={LabelStyle}>Key *</span>
                                <input
                                    value={draft.key}
                                    onChange={(e) => setDraft((d) => ({ ...d, key: normalizeKey(e.target.value) }))}
                                    style={CompactInput}
                                    placeholder="auto-generated"
                                />
                            </label>

                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={LabelStyle}>Alt text</span>
                                <input
                                    value={draft.metadata.alt}
                                    onChange={(e) => setDraft((d) => ({ ...d, metadata: { ...d.metadata, alt: e.target.value } }))}
                                    style={CompactInput}
                                />
                            </label>

                            <label style={{ display: 'grid', gap: 6 }}>
                                <span style={LabelStyle}>Caption</span>
                                <input
                                    value={draft.metadata.caption}
                                    onChange={(e) => setDraft((d) => ({ ...d, metadata: { ...d.metadata, caption: e.target.value } }))}
                                    style={CompactInput}
                                />
                            </label>
                        </div>

                        <div style={{ display: 'flex', justifyContent: 'flex-end', gap: 10, marginTop: 18 }}>
                            <button className="admin-btn-secondary" disabled={adding} onClick={() => setShowAdd(false)}>
                                Cancel
                            </button>
                            <button className="admin-btn-primary" disabled={adding} onClick={handleCreate}>
                                {adding ? <Loader2 className="animate-spin" size={16} /> : <Plus size={16} />} Create
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
};

const SectionHeadStyle = {
    fontFamily: 'var(--font-mono)',
    fontSize: '0.65rem',
    color: 'var(--gold)',
    letterSpacing: '0.2em',
    textTransform: 'uppercase',
    marginBottom: '20px',
    display: 'flex',
    alignItems: 'center',
    gap: '10px',
    paddingBottom: '10px',
    borderBottom: '1px solid rgba(255,255,255,0.05)'
};

const LabelStyle = {
    display: 'block', 
    fontFamily: 'var(--font-mono)', 
    fontSize: '0.6rem', 
    color: 'var(--text-dim)', 
    textTransform: 'uppercase', 
    marginBottom: '8px'
};

const CompactInput = {
    width: '100%',
    background: '#0a0a0a',
    border: '1px solid var(--border)',
    color: 'white',
    padding: '12px',
    fontSize: '0.8rem',
    fontFamily: 'var(--font-mono)',
    outline: 'none'
};


