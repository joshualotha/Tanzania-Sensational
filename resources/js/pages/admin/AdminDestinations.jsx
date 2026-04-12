import React, { useState, useEffect, useRef } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import {
    Plus, Search, Edit3, Trash2, MapPin, Compass,
    ChevronRight, X, Shield, Globe, Camera, Save,
    Loader2, AlertTriangle, Layers, Info, Upload
} from 'lucide-react';
import { destinationService, adminService } from '../../services/api';
import '../../styles/admin-premium.css';

export const AdminDestinations = () => {
    const [destinations, setDestinations] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedDest, setSelectedDest] = useState(null);
    const [isCurating, setIsCurating] = useState(false);
    const [saving, setSaving] = useState(false);
    const [showCurator, setShowCurator] = useState(false);
    const [uploadingImage, setUploadingImage] = useState(false);
    const [uploadingGallery, setUploadingGallery] = useState(false);
    const heroFileInputRef = useRef(null);
    const galleryFileInputRef = useRef(null);

    useEffect(() => {
        fetchDestinations();
    }, []);

    const fetchDestinations = async () => {
        try {
            setLoading(true);
            const response = await destinationService.getAll();
            setDestinations(response.data);
        } catch (error) {
            console.error("Coordinate Retrieval Failure:", error);
        } finally {
            setLoading(false);
        }
    };

    const handleOpenCurator = (dest = null) => {
        if (dest) {
            setSelectedDest({ ...dest, gallery: dest.gallery || [] });
        } else {
            setSelectedDest({
                name: 'New destination',
                slug: `region-${Date.now()}`,
                meta_tag: 'Destination',
                meta_tier: 'Standard',
                hero_image: 'https://images.unsplash.com/photo-1516026672322-bc52d61a55d5?auto=format&fit=crop&q=80',
                overview: '',
                best_time: 'JUN-OCT',
                meta_coordinates: '-3.0674, 37.3556',
                gallery: []
            });
        }
        setIsCurating(true);
        setShowCurator(true);
    };

    const handleHeroUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image file.');
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('Image size must be less than 5MB.');
            return;
        }

        try {
            setUploadingImage(true);
            const response = await adminService.upload(file, 'destinations');
            const imageUrl = response.data.url;
            
            setSelectedDest({ ...selectedDest, hero_image: imageUrl });
        } catch (error) {
            console.error('Hero image upload failed:', error);
            alert('Failed to upload image. Please try again.');
        } finally {
            setUploadingImage(false);
        }
    };

    const handleGalleryUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image file.');
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            alert('Image size must be less than 5MB.');
            return;
        }

        try {
            setUploadingGallery(true);
            const response = await adminService.upload(file, 'destinations/gallery');
            const imageUrl = response.data.url;
            
            setSelectedDest({ ...selectedDest, gallery: [...(selectedDest.gallery || []), imageUrl] });
        } catch (error) {
            console.error('Gallery image upload failed:', error);
            alert('Failed to upload image. Please try again.');
        } finally {
            setUploadingGallery(false);
        }
    };

    const handleSave = async () => {
        setSaving(true);
        try {
            if (selectedDest.id) {
                await adminService.updateDestination(selectedDest.id, selectedDest);
            } else {
                await adminService.createDestination(selectedDest);
            }
            await fetchDestinations();
            setIsCurating(false);
            setShowCurator(false);
            setSelectedDest(null);
        } catch (error) {
            alert("Unable to save changes. Please try again.");
        } finally {
            setSaving(false);
        }
    };

    const handleDelete = async (id) => {
        if (!window.confirm("Delete this destination? This action is irreversible.")) return;
        try {
            await adminService.deleteDestination(id);
            setDestinations(destinations.filter(d => d.id !== id));
            if (selectedDest?.id === id) {
                setIsCurating(false);
                setSelectedDest(null);
            }
        } catch (error) {
            alert("Unable to delete the destination.");
        }
    };

    const filteredDestinations = destinations.filter(d => 
        (d.name || '').toLowerCase().includes(searchTerm.toLowerCase()) ||
        (d.slug || '').toLowerCase().includes(searchTerm.toLowerCase())
    );

    if (loading) return (
        <div style={{ height: '60vh', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center' }}>
            <Loader2 className="animate-spin" size={48} color="var(--gold)" />
            <span style={{ marginTop: '20px', fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--gold)', letterSpacing: '0.3em' }}>Loading destinations…</span>
        </div>
    );

    return (
        <div className="admin-page-root">
            <header style={{ marginBottom: '60px', display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                <div style={{ position: 'relative' }}>
                    <div style={{ position: 'absolute', left: '-50px', top: '10px', width: '30px', height: '1px', background: 'var(--gold)' }}></div>
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.25em', textTransform: 'uppercase', marginBottom: '12px' }}>Safaris</h2>
                    <h1 className="admin-page-title" style={{ fontSize: '3.5rem', fontWeight: 300, letterSpacing: '-0.02em' }}>Destinations</h1>
                </div>
                
                <div style={{ display: 'flex', gap: '20px', alignItems: 'center' }}>
                    <div className="admin-search-wrapper" style={{ border: '1px solid var(--border)', background: 'rgba(255,255,255,0.02)' }}>
                        <Search size={18} color="var(--gold-dim)" />
                        <input 
                            type="text" 
                            placeholder="Search destinations…" 
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            style={{ background: 'transparent', border: 'none', color: 'white', padding: '12px 20px 12px 10px', fontFamily: 'var(--font-mono)', fontSize: '0.75rem' }}
                        />
                    </div>
                    <button className="admin-btn-primary" onClick={() => handleOpenCurator()}>
                        <Plus size={18} /> Add destination
                    </button>
                </div>
            </header>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr', gap: '50px', alignItems: 'start' }}>
                {/* ─── GRID OF REGIONS ─── */}
                <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(320px, 1fr))', gap: '30px' }}>
                    <AnimatePresence>
                        {filteredDestinations.map((dest, idx) => (
                            <motion.div 
                                key={dest.id}
                                initial={{ opacity: 0, y: 20 }}
                                animate={{ opacity: 1, y: 0 }}
                                transition={{ delay: idx * 0.05 }}
                                className={`dest-command-card ${selectedDest?.id === dest.id ? 'active' : ''}`}
                                onClick={() => handleOpenCurator(dest)}
                                style={{
                                    background: 'var(--slate)',
                                    border: '1px solid var(--border)',
                                    overflow: 'hidden',
                                    cursor: 'pointer',
                                    position: 'relative',
                                    borderColor: selectedDest?.id === dest.id ? 'var(--gold)' : 'var(--border)'
                                }}
                            >
                                <div style={{ height: '240px', position: 'relative', overflow: 'hidden' }}>
                                    <img src={dest.hero_image} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover', transform: selectedDest?.id === dest.id ? 'scale(1.1)' : 'scale(1)', transition: 'transform 1.2s cubic-bezier(0.2, 0, 0.2, 1)' }} />
                                    <div style={{ position: 'absolute', inset: 0, background: 'linear-gradient(to top, rgba(10,10,10,0.95), transparent)' }}></div>
                                    <div style={{ position: 'absolute', top: '20px', left: '20px' }}>
                                        <span style={{ padding: '4px 10px', background: 'rgba(201,168,76,0.1)', border: '1px solid var(--gold-dim)', color: 'var(--gold)', fontSize: '0.6rem', fontFamily: 'var(--font-mono)', textTransform: 'uppercase' }}>
                                            {dest.meta_tier || 'TIER_I'}
                                        </span>
                                    </div>
                                    <div style={{ position: 'absolute', bottom: '25px', left: '30px' }}>
                                        <span style={{ display: 'block', fontFamily: 'var(--font-mono)', fontSize: '0.6rem', color: 'var(--gold)', letterSpacing: '0.2em', textTransform: 'uppercase', marginBottom: '8px' }}>
                                            {dest.meta_tag || 'FIELD AREA'}
                                        </span>
                                        <h3 style={{ fontSize: '1.8rem', color: 'white', fontWeight: 300, lineHeight: 1.1 }}>{dest.name}</h3>
                                    </div>
                                </div>
                                <div style={{ padding: '25px 30px', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                                    <div style={{ display: 'flex', flexDirection: 'column', gap: '4px' }}>
                                        <div style={{ fontSize: '0.6rem', color: 'var(--text-dim-light)', textTransform: 'uppercase', fontFamily: 'var(--font-mono)' }}>Sector Address</div>
                                        <div style={{ fontSize: '0.8rem', color: 'rgba(255,255,255,0.4)', fontFamily: 'var(--font-mono)' }}>/{dest.slug}</div>
                                    </div>
                                    <div style={{ display: 'flex', gap: '15px' }}>
                                        <button 
                                            onClick={(e) => { e.stopPropagation(); handleDelete(dest.id); }}
                                            style={{ background: 'none', border: 'none', color: '#ff4444', padding: '10px', cursor: 'pointer', opacity: 0.3 }}
                                            onMouseOver={e => e.currentTarget.style.opacity = 1}
                                            onMouseOut={e => e.currentTarget.style.opacity = 0.3}
                                        >
                                            <Trash2 size={16} />
                                        </button>
                                        <ChevronRight size={20} color="var(--gold)" />
                                    </div>
                                </div>
                            </motion.div>
                        ))}
                    </AnimatePresence>
                </div>

            </div>

            {showCurator && isCurating && selectedDest && (
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
                    onMouseDown={() => !saving && (setShowCurator(false), setIsCurating(false))}
                >
                    <div
                        className="admin-panel shadow-premium"
                        style={{ width: 'min(980px, 96vw)', padding: 40, border: '1px solid var(--gold)', background: 'var(--charcoal)', maxHeight: '90vh', overflow: 'auto' }}
                        onMouseDown={(e) => e.stopPropagation()}
                    >
                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: '30px' }}>
                            <div>
                                <h4 style={SectionHeadStyle}><Shield size={14} /> Destination editor</h4>
                                <h2 style={{ fontSize: '1.8rem', color: 'white', fontWeight: 300 }}>{selectedDest.id ? 'Edit destination' : 'Add destination'}</h2>
                            </div>
                            <button onClick={() => !saving && (setShowCurator(false), setIsCurating(false))} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.2)', cursor: 'pointer' }}><X size={24} /></button>
                        </div>

                        <div className="curator-scrollarea custom-scrollbar" style={{ display: 'flex', flexDirection: 'column', gap: '30px' }}>
                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Core Coordinates</h5>
                                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '15px' }}>
                                    <AdminInput label="Region Title" value={selectedDest.name} onChange={v => setSelectedDest({...selectedDest, name: v})} />
                                    <AdminInput label="Sector Slug" value={selectedDest.slug} onChange={v => setSelectedDest({...selectedDest, slug: v})} />
                                    <AdminInput label="Tag" value={selectedDest.meta_tag} onChange={v => setSelectedDest({...selectedDest, meta_tag: v})} />
                                    <AdminInput label="Geo Tier" value={selectedDest.meta_tier} onChange={v => setSelectedDest({...selectedDest, meta_tier: v})} />
                                </div>
                            </div>

                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Overview</h5>
                                <AdminTextarea label="Regional Narrative" value={selectedDest.overview} rows={8} onChange={v => setSelectedDest({...selectedDest, overview: v})} />
                            </div>

                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Atmospheric Assets</h5>
                                
                                {/* Hero Image Upload */}
                                <div style={{ marginBottom: '15px' }}>
                                    <label style={LabelStyle}>Hero Visual</label>
                                    <div style={{ display: 'flex', gap: '10px', marginBottom: '10px' }}>
                                        <input
                                            type="file"
                                            ref={heroFileInputRef}
                                            accept="image/*"
                                            onChange={handleHeroUpload}
                                            style={{ display: 'none' }}
                                            disabled={uploadingImage}
                                        />
                                        <button
                                            type="button"
                                            onClick={() => heroFileInputRef.current?.click()}
                                            disabled={uploadingImage}
                                            style={{
                                                flex: 1,
                                                padding: '10px',
                                                background: uploadingImage ? 'rgba(201, 168, 76, 0.1)' : 'transparent',
                                                border: '1px dashed var(--border)',
                                                color: uploadingImage ? 'var(--gold-dim)' : 'var(--text-dim-light)',
                                                fontSize: '0.7rem',
                                                fontFamily: 'var(--font-mono)',
                                                cursor: uploadingImage ? 'not-allowed' : 'pointer',
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center',
                                                gap: '8px'
                                            }}
                                        >
                                            {uploadingImage ? (
                                                <>
                                                    <Loader2 size={12} className="animate-spin" />
                                                    Uploading...
                                                </>
                                            ) : (
                                                <>
                                                    <Upload size={12} />
                                                    Upload Hero
                                                </>
                                            )}
                                        </button>
                                    </div>
                                    <div style={{ display: 'flex', alignItems: 'center', gap: '10px', marginBottom: '10px' }}>
                                        <div style={{ flex: 1, height: '1px', background: 'var(--border)' }}></div>
                                        <span style={{ fontSize: '0.55rem', color: 'var(--text-dim-light)', fontFamily: 'var(--font-mono)' }}>OR USE URL</span>
                                        <div style={{ flex: 1, height: '1px', background: 'var(--border)' }}></div>
                                    </div>
                                    <AdminInput label="Hero Visual URL" value={selectedDest.hero_image} onChange={v => setSelectedDest({...selectedDest, hero_image: v})} />
                                </div>

                                {/* Hero Preview */}
                                <div style={{ height: '180px', background: '#000', border: '1px solid var(--border)', overflow: 'hidden' }}>
                                    <img src={selectedDest.hero_image} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                                </div>

                                <div style={{ marginTop: '20px' }}>
                                    <label style={LabelStyle}>Gallery Matrix</label>
                                    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(5, 1fr)', gap: '8px' }}>
                                        {(selectedDest.gallery || []).map((img, idx) => (
                                            <div key={idx} style={{ aspectRatio: '1', border: '1px solid var(--border)', position: 'relative' }}>
                                                <img src={img} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                                                <button
                                                    onClick={() => setSelectedDest({...selectedDest, gallery: selectedDest.gallery.filter((_, i) => i !== idx)})}
                                                    style={{ position: 'absolute', top: '-5px', right: '-5px', background: '#ff4444', border: 'none', borderRadius: '50%', width: '16px', height: '16px', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', cursor: 'pointer' }}
                                                >
                                                    <X size={10} />
                                                </button>
                                            </div>
                                        ))}
                                        <input
                                            type="file"
                                            ref={galleryFileInputRef}
                                            accept="image/*"
                                            onChange={handleGalleryUpload}
                                            style={{ display: 'none' }}
                                            disabled={uploadingGallery}
                                        />
                                        <button
                                            type="button"
                                            onClick={() => galleryFileInputRef.current?.click()}
                                            disabled={uploadingGallery}
                                            style={{
                                                aspectRatio: '1',
                                                border: '1px dashed var(--border)',
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center',
                                                color: uploadingGallery ? 'var(--gold-dim)' : 'var(--text-dim-light)',
                                                cursor: uploadingGallery ? 'not-allowed' : 'pointer',
                                                background: uploadingGallery ? 'rgba(201, 168, 76, 0.1)' : 'transparent'
                                            }}
                                        >
                                            {uploadingGallery ? (
                                                <Loader2 size={16} className="animate-spin" />
                                            ) : (
                                                <Plus size={16} />
                                            )}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Travel info</h5>
                                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '15px' }}>
                                    <AdminInput label="Optimal Window" value={selectedDest.best_time} onChange={v => setSelectedDest({...selectedDest, best_time: v})} />
                                    <AdminInput label="Geo Coordinates" value={selectedDest.meta_coordinates} onChange={v => setSelectedDest({...selectedDest, meta_coordinates: v})} />
                                </div>
                            </div>
                        </div>

                        <div style={{ marginTop: '30px', display: 'flex', gap: '15px' }}>
                            <button className="admin-btn-secondary" style={{ flex: 1 }} onClick={() => !saving && (setShowCurator(false), setIsCurating(false))}>Close</button>
                            <button
                                className="admin-btn-primary"
                                style={{ flex: 2 }}
                                disabled={saving}
                                onClick={handleSave}
                            >
                                {saving ? <Loader2 className="animate-spin" size={16} /> : <Save size={16} />}
                                <span>{saving ? 'Saving…' : 'Save'}</span>
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
    marginBottom: '10px',
    display: 'flex',
    alignItems: 'center',
    gap: '10px'
};

const SubHeadStyle = {
    fontFamily: 'var(--font-mono)',
    fontSize: '0.6rem',
    color: 'var(--text-dim-light)',
    textTransform: 'uppercase',
    letterSpacing: '0.15em',
    paddingBottom: '10px',
    borderBottom: '1px solid rgba(255,255,255,0.05)',
    marginBottom: '20px'
};

const LabelStyle = {
    display: 'block',
    fontFamily: 'var(--font-mono)',
    fontSize: '0.6rem',
    color: 'var(--text-dim-light)',
    textTransform: 'uppercase',
    marginBottom: '8px'
};

const AdminInput = ({ label, value, onChange }) => (
    <div style={{ marginBottom: '15px' }}>
        <label style={LabelStyle}>{label}</label>
        <input 
            type="text" 
            value={value || ''} 
            onChange={e => onChange(e.target.value)} 
            style={{ width: '100%', background: '#000', border: '1px solid var(--border)', padding: '10px 12px', color: 'white', fontSize: '0.85rem' }}
        />
    </div>
);

const AdminTextarea = ({ label, value, rows, onChange }) => (
    <div style={{ marginBottom: '15px' }}>
        <label style={LabelStyle}>{label}</label>
        <textarea 
            rows={rows} 
            value={value || ''} 
            onChange={e => onChange(e.target.value)} 
            style={{ width: '100%', background: '#000', border: '1px solid var(--border)', padding: '12px', color: 'white', fontSize: '0.85rem', resize: 'none', lineHeight: '1.6' }}
        />
    </div>
);
