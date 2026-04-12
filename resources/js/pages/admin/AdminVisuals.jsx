import React, { useMemo, useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    Image as ImageIcon, RefreshCw, 
    Globe, Layers, Plus, Trash2, Loader2,
    Compass, Mountain, Sun, MapPin, Heart, BookOpen, Info, Phone, Palette, LayoutDashboard, X
} from 'lucide-react';
import { adminService, visualAssetService } from '../../services/api';
import { visualsData } from '../../data/visualsData';
import '../../styles/admin-premium.css';

// 1. Sidebar Categories & Icon Map
const CATEGORY_MAP = [
    { id: 'home', label: 'Home Page', icon: Globe },
    { id: 'safaris', label: 'Safaris', icon: Compass },
    { id: 'trekking', label: 'Trekking', icon: Mountain },
    { id: 'zanzibar', label: 'Zanzibar', icon: Sun },
    { id: 'destinations', label: 'Destinations', icon: MapPin },
    { id: 'planning', label: 'Planning & Prep', icon: Heart },
    { id: 'blogs', label: 'Journal', icon: BookOpen },
    { id: 'about', label: 'About Us', icon: Info },
    { id: 'contact', label: 'Contact', icon: Phone },
    { id: 'branding', label: 'Branding', icon: Palette },
    { id: 'common', label: 'Common patterns', icon: Layers },
];

function humanize(str) {
    const s = String(str || '').replace(/([A-Z])/g, ' $1').replace(/[_-]+/g, ' ').trim();
    return s.charAt(0).toUpperCase() + s.slice(1);
}

// 2. Discover placements inherently structured in visualsData
function buildTree(obj, prefix = '') {
    const list = [];
    if (!obj || typeof obj !== 'object') return list;
    for (const [k, v] of Object.entries(obj)) {
        const path = prefix ? `${prefix}.${k}` : k;
        if (typeof v === 'string') {
            list.push({ section: path, kind: 'single', name: humanize(k), category: prefix ? prefix.split('.')[0] : k });
        } else if (Array.isArray(v)) {
            list.push({ section: path, kind: 'list', name: humanize(k) + ' (Gallery)', category: prefix ? prefix.split('.')[0] : k });
        } else {
            list.push(...buildTree(v, path));
        }
    }
    return list;
}

const ALL_PLACEMENTS = buildTree(visualsData);

export const AdminVisuals = () => {
    const [assets, setAssets] = useState([]);
    const [loading, setLoading] = useState(true);
    const [activeCategory, setActiveCategory] = useState('home');
    const [uploadingSection, setUploadingSection] = useState(null);

    useEffect(() => {
        fetchAssets();
    }, []);

    // We fetch ALL assets at once to make sidebar filtering instant
    const fetchAssets = async () => {
        setLoading(true);
        try {
            let allItems = [];
            let page = 1;
            let lastPage = 1;

            do {
                const res = await visualAssetService.adminGetAll({ params: { per_page: 96, page } });
                const rows = Array.isArray(res.data?.data) ? res.data.data : (Array.isArray(res.data) ? res.data : []);
                allItems = [...allItems, ...rows];
                lastPage = res.data?.last_page || 1;
                page++;
            } while (page <= lastPage);

            setAssets(allItems);
        } catch (e) {
            console.error("Failed to load visuals:", e);
        } finally {
            setLoading(false);
        }
    };

    const normalizeKey = (value) => String(value || '').trim().toLowerCase().replace(/[^a-z0-9]+/g, '_').replace(/^_+|_+$/g, '');
    const inferFilename = (file) => file?.name || '';

    const handleUpload = async (file, section, isGallery = false, existingKeyToReplace = null) => {
        if (!file) return;
        setUploadingSection(section);
        try {
            const folder = `visual-assets/${normalizeKey(section.replace(/\./g, '_'))}`;
            const uploadRes = await adminService.upload(file, folder);
            const finalUrl = uploadRes.data?.url;

            if (existingKeyToReplace) {
                // If replacing an existing specific image (single), just update its URL instead of deleting/recreating
                await visualAssetService.adminUpdate(existingKeyToReplace, { url: finalUrl });
            } else {
                // Creating a new asset entry (for galleries, or singles that don't exist yet)
                const s = normalizeKey(section.replace(/\./g, '_'));
                const fn = normalizeKey(inferFilename(file).replace(/\.[^.]+$/, ''));
                const key = `${s}_${fn}_${Math.floor(Math.random() * 99999)}`;

                const payload = { section, key, url: finalUrl, type: 'image', metadata: { alt: '' } };
                await visualAssetService.adminCreate(payload);
            }

            await fetchAssets();
        } catch (e) {
            alert('Upload failed: ' + (e.response?.data?.message || e.message));
        } finally {
            setUploadingSection(null);
        }
    };

    const handleDelete = async (key) => {
        if (!window.confirm("Remove this image?")) return;
        try {
            await visualAssetService.adminDelete(key, { params: { delete_file: 1 } });
            setAssets(assets.filter(a => a.key !== key));
        } catch (error) {
            alert("Unable to delete the image.");
        }
    };

    // Derived active placements
    const activePlacements = useMemo(() => {
        return ALL_PLACEMENTS.filter(p => p.category === activeCategory);
    }, [activeCategory]);

    if (loading && assets.length === 0) return (
        <div style={{ height: '60vh', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center' }}>
            <Loader2 className="animate-spin" size={48} color="var(--gold)" />
            <span style={{ marginTop: '20px', fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--gold)', letterSpacing: '0.2em' }}>Initializing Theme Editor…</span>
        </div>
    );

    return (
        <div className="admin-visuals-root">
            <header style={{ marginBottom: '40px', display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                <div>
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.2em', textTransform: 'uppercase', marginBottom: '10px' }}>Media</h2>
                    <h1 className="admin-page-title" style={{ fontSize: '2.4rem' }}>Theme Customizer</h1>
                </div>
                <button className="admin-btn-secondary" onClick={() => fetchAssets()}>
                    <RefreshCw size={14} className={loading ? "animate-spin" : ""} /> Refresh
                </button>
            </header>

            <div style={{ display: 'grid', gridTemplateColumns: '260px 1fr', gap: '40px', alignItems: 'start' }}>
                
                {/* 1. APP CATEGORIES SIDEBAR */}
                <div className="admin-panel shadow-premium" style={{ padding: '20px' }}>
                    <h4 style={SectionHeadStyle}><LayoutDashboard size={14} /> Sections</h4>
                    <div style={{ display: 'flex', flexDirection: 'column', gap: '6px' }}>
                        {CATEGORY_MAP.map(cat => {
                            const Icon = cat.icon;
                            const isActive = activeCategory === cat.id;
                            return (
                                <button 
                                    key={cat.id}
                                    onClick={() => setActiveCategory(cat.id)}
                                    style={{ 
                                        padding: '12px 16px', 
                                        background: isActive ? 'var(--gold-glow)' : 'transparent',
                                        border: '1px solid',
                                        borderColor: isActive ? 'var(--gold)' : 'transparent',
                                        color: isActive ? 'white' : 'var(--text-dim-light)',
                                        textAlign: 'left',
                                        fontSize: '0.8rem',
                                        fontFamily: 'var(--font-sans)',
                                        fontWeight: 500,
                                        display: 'flex',
                                        alignItems: 'center',
                                        gap: '12px',
                                        borderRadius: '4px',
                                        cursor: 'pointer',
                                        transition: '0.2s',
                                        letterSpacing: '0.02em'
                                    }}
                                >
                                    <Icon size={16} color={isActive ? 'var(--gold)' : 'var(--text-dim-light)'} />
                                    {cat.label}
                                </button>
                            );
                        })}
                    </div>
                </div>

                {/* 2. PLACEMENT EDITOR BLOCKS */}
                <div style={{ display: 'flex', flexDirection: 'column', gap: '30px' }}>
                    {activePlacements.map(placement => {
                        const placementAssets = assets.filter(a => a.section === placement.section);
                        const isGallery = placement.kind === 'list';
                        const isUploading = uploadingSection === placement.section;
                        
                        return (
                            <div key={placement.section} className="admin-panel shadow-premium" style={{ padding: '30px', background: 'var(--charcoal)', border: '1px solid var(--border)' }}>
                                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: '25px', borderBottom: '1px solid rgba(255,255,255,0.05)', paddingBottom: '15px' }}>
                                    <div>
                                        <h3 style={{ fontSize: '1.2rem', color: 'white', marginBottom: '6px' }}>{placement.name}</h3>
                                        <div style={{ fontFamily: 'var(--font-mono)', fontSize: '0.65rem', color: 'var(--text-dim-light)' }}>
                                            {placement.section} • {isGallery ? 'Multiple images allowed' : 'Single image strictly enforced'}
                                        </div>
                                    </div>
                                    
                                    {/* Upload Button */}
                                    {(!isGallery && placementAssets.length > 0) ? (
                                        <label className="admin-btn-primary" style={{ cursor: isUploading ? 'not-allowed' : 'pointer', fontSize: '0.8rem' }}>
                                            {isUploading ? <Loader2 className="animate-spin" size={14} /> : <ImageIcon size={14} />} 
                                            {isUploading ? 'Uploading...' : 'Replace Image'}
                                            <input
                                                type="file" accept="image/*" style={{ display: 'none' }} disabled={isUploading}
                                                onChange={(e) => handleUpload(e.target.files?.[0], placement.section, false, placementAssets[0].key)}
                                            />
                                        </label>
                                    ) : (
                                        <label className="admin-btn-primary" style={{ cursor: isUploading ? 'not-allowed' : 'pointer', fontSize: '0.8rem' }}>
                                            {isUploading ? <Loader2 className="animate-spin" size={14} /> : <Plus size={14} />} 
                                            {isUploading ? 'Uploading...' : (isGallery ? 'Add to Gallery' : 'Upload Image')}
                                            <input
                                                type="file" accept="image/*" style={{ display: 'none' }} disabled={isUploading}
                                                onChange={(e) => handleUpload(e.target.files?.[0], placement.section, isGallery)}
                                            />
                                        </label>
                                    )}
                                </div>

                                {/* Current Imagery View */}
                                {placementAssets.length === 0 ? (
                                    <div style={{ padding: '40px 20px', textAlign: 'center', border: '1px dashed var(--border)', borderRadius: '4px', background: 'rgba(0,0,0,0.2)' }}>
                                        <ImageIcon size={32} color="var(--border)" style={{ margin: '0 auto 10px' }} />
                                        <div style={{ color: 'var(--text-dim-light)', fontSize: '0.85rem' }}>No image set for this section. <br/>It may fallback to placeholder defaults.</div>
                                    </div>
                                ) : (
                                    <div style={{ 
                                        display: 'grid', 
                                        gridTemplateColumns: isGallery ? 'repeat(auto-fill, minmax(200px, 1fr))' : '1fr', 
                                        gap: '20px' 
                                    }}>
                                        {placementAssets.map(asset => (
                                            <div key={asset.key} style={{ position: 'relative', background: '#000', borderRadius: '4px', overflow: 'hidden', border: '1px solid rgba(255,255,255,0.1)', aspectRatio: isGallery ? '1' : '21/9' }}>
                                                <img src={asset.url} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover', opacity: 0.8 }} />
                                                
                                                {/* Delete Overlay */}
                                                <div style={{ position: 'absolute', top: 0, left: 0, right: 0, padding: '12px', background: 'linear-gradient(to bottom, rgba(0,0,0,0.8), transparent)', display: 'flex', justifyContent: 'flex-end' }}>
                                                    <button 
                                                        onClick={() => handleDelete(asset.key)}
                                                        style={{ background: 'rgba(0,0,0,0.5)', border: '1px solid rgba(255,255,255,0.2)', color: 'white', padding: '6px', borderRadius: '4px', cursor: 'pointer', transition: '0.2s' }}
                                                        onMouseEnter={e => e.currentTarget.style.background = '#ff4444'}
                                                        onMouseLeave={e => e.currentTarget.style.background = 'rgba(0,0,0,0.5)'}
                                                    >
                                                        <X size={14} />
                                                    </button>
                                                </div>
                                            </div>
                                        ))}
                                    </div>
                                )}
                            </div>
                        );
                    })}
                </div>
            </div>
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
