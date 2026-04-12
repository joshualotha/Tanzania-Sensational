import React, { useState, useEffect, useRef } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import {
    Plus, Search, Edit3, Trash2, Mountain, Compass,
    ChevronRight, X, Shield, Activity, Camera, Save,
    Loader2, AlertTriangle, Layers, Info, TrendingUp, Upload
} from 'lucide-react';
import { adminService, trekkingService } from '../../services/api';
import '../../styles/admin-premium.css';

export const AdminTrekking = () => {
    const [packages, setPackages] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedPkg, setSelectedPkg] = useState(null);
    const [isCurating, setIsCurating] = useState(false);
    const [saving, setSaving] = useState(false);
    const [showCurator, setShowCurator] = useState(false);
    const [uploadingImage, setUploadingImage] = useState(false);
    const [imagePreview, setImagePreview] = useState(null);
    const fileInputRef = useRef(null);
    const [uploadingEditorial1, setUploadingEditorial1] = useState(false);
    const [uploadingEditorial2, setUploadingEditorial2] = useState(false);
    const editorialFileInputRef1 = useRef(null);
    const editorialFileInputRef2 = useRef(null);

    useEffect(() => {
        fetchPackages();
    }, []);

    const fetchPackages = async () => {
        try {
            setLoading(true);
            const response = await trekkingService.getAll();
            setPackages(response.data);
        } catch (error) {
            console.error("Failed to load trekking routes:", error);
        } finally {
            setLoading(false);
        }
    };

    const handleOpenCurator = (pkg = null) => {
        if (pkg) {
            console.log('Opening route for edit:', {
                id: pkg.id,
                name: pkg.name,
                editorial_image: pkg.editorial_image,
                editorial_image_2: pkg.editorial_image_2
            });
            setSelectedPkg({
                ...pkg,
                highlights: pkg.highlights || [],
                inclusions: pkg.inclusions || [],
                exclusions: pkg.exclusions || [],
                itinerary: pkg.itinerary_days || pkg.itinerary || []
            });
            setImagePreview(pkg.hero_image || null);
        } else {
            setSelectedPkg({
                name: 'New trekking route',
                slug: `ascent-${Date.now()}`,
                base_price: 2500,
                duration: 7,
                difficulty: 'Moderate',
                success_rate: '95%',
                hero_image: 'https://images.unsplash.com/photo-1549449875-9689b1473215?auto=format&fit=crop&q=80',
                description: '',
                highlights: [],
                inclusions: [],
                exclusions: [],
                itinerary: []
            });
            setImagePreview('https://images.unsplash.com/photo-1549449875-9689b1473215?auto=format&fit=crop&q=80');
        }
        setIsCurating(true);
        setShowCurator(true);
    };

    const handleImageUpload = async (e) => {
        const file = e.target.files[0];
        if (!file) return;

        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Please select a valid image file.');
            return;
        }

        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            alert('Image size must be less than 5MB.');
            return;
        }

        try {
            setUploadingImage(true);
            const response = await adminService.upload(file, 'trekking-routes');
            const imageUrl = response.data.url;
            
            setSelectedPkg({ ...selectedPkg, hero_image: imageUrl });
            setImagePreview(imageUrl);
        } catch (error) {
            console.error('Image upload failed:', error);
            alert('Failed to upload image. Please try again.');
        } finally {
            setUploadingImage(false);
        }
    };

    const handleEditorialUpload1 = async (e) => {
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
            setUploadingEditorial1(true);
            const response = await adminService.upload(file, 'trekking-routes/editorial');
            const imageUrl = response.data.url;
            
            setSelectedPkg({ ...selectedPkg, editorial_image: imageUrl });
        } catch (error) {
            console.error('Editorial image upload failed:', error);
            alert('Failed to upload image. Please try again.');
        } finally {
            setUploadingEditorial1(false);
        }
    };

    const handleEditorialUpload2 = async (e) => {
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
            setUploadingEditorial2(true);
            const response = await adminService.upload(file, 'trekking-routes/editorial');
            const imageUrl = response.data.url;
            
            setSelectedPkg({ ...selectedPkg, editorial_image_2: imageUrl });
        } catch (error) {
            console.error('Editorial image upload failed:', error);
            alert('Failed to upload image. Please try again.');
        } finally {
            setUploadingEditorial2(false);
        }
    };

    const handleSave = async () => {
        setSaving(true);
        try {
            console.log('Saving trekking route with editorial images:', {
                id: selectedPkg.id,
                editorial_image: selectedPkg.editorial_image,
                editorial_image_2: selectedPkg.editorial_image_2,
                editorial_content: selectedPkg.editorial_content
            });
            
            if (selectedPkg.id && !String(selectedPkg.id).startsWith('ascent-')) {
                await adminService.updateTrekking(selectedPkg.id, selectedPkg);
            } else {
                await adminService.createTrekking(selectedPkg);
            }
            await fetchPackages();
            setIsCurating(false);
            setShowCurator(false);
            setSelectedPkg(null);
        } catch (error) {
            console.error('Save error:', error);
            alert("Unable to save changes. Please try again.");
        } finally {
            setSaving(false);
        }
    };

    const handleDelete = async (id) => {
        if (!window.confirm("Delete this trekking route? This action is irreversible.")) return;
        try {
            await adminService.deleteTrekking(id);
            setPackages(packages.filter(p => p.id !== id));
            if (selectedPkg?.id === id) {
                setIsCurating(false);
                setSelectedPkg(null);
            }
        } catch (error) {
            alert("Unable to delete the route.");
        }
    };

    const filteredPackages = packages.filter(p => 
        (p.name || '').toLowerCase().includes(searchTerm.toLowerCase()) ||
        (p.slug || '').toLowerCase().includes(searchTerm.toLowerCase())
    );

    if (loading) return (
        <div style={{ height: '60vh', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center' }}>
            <Loader2 className="animate-spin" size={48} color="var(--gold)" />
            <span style={{ marginTop: '20px', fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--gold)', letterSpacing: '0.3em' }}>Loading trekking routes…</span>
        </div>
    );

    return (
        <div className="admin-page-root">
            <header style={{ marginBottom: '60px', display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                <div>
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.25em', textTransform: 'uppercase', marginBottom: '12px' }}>Trips</h2>
                    <h1 className="admin-page-title" style={{ fontSize: '3.5rem', fontWeight: 300 }}>Trekking routes</h1>
                </div>

                <div style={{ display: 'flex', gap: '20px', alignItems: 'center' }}>
                    <div className="admin-search-wrapper" style={{ border: '1px solid var(--border)', background: 'rgba(255,255,255,0.02)' }}>
                        <Search size={18} color="var(--gold-dim)" />
                        <input
                            type="text"
                            placeholder="Search routes…"
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            style={{ background: 'transparent', border: 'none', color: 'white', padding: '12px 10px', fontFamily: 'var(--font-mono)', fontSize: '0.75rem' }}
                        />
                    </div>
                    <button className="admin-btn-primary" onClick={() => handleOpenCurator()}>
                        <Plus size={18} /> Add route
                    </button>
                </div>
            </header>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr', gap: '50px', alignItems: 'start' }}>
                {/* ─── GRID OF ASCENTS ─── */}
                <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(320px, 1fr))', gap: '30px' }}>
                    <AnimatePresence>
                        {filteredPackages.map((pkg, idx) => (
                            <motion.div 
                                key={pkg.id}
                                initial={{ opacity: 0, scale: 0.98 }}
                                animate={{ opacity: 1, scale: 1 }}
                                transition={{ delay: idx * 0.05 }}
                                className={`trek-command-card ${selectedPkg?.id === pkg.id ? 'active' : ''}`}
                                onClick={() => handleOpenCurator(pkg)}
                                style={{
                                    background: 'var(--slate)',
                                    border: '1px solid var(--border)',
                                    borderRadius: '4px',
                                    overflow: 'hidden',
                                    cursor: 'pointer',
                                    position: 'relative',
                                    borderColor: selectedPkg?.id === pkg.id ? 'var(--gold)' : 'var(--border)'
                                }}
                            >
                                <div style={{ height: '220px', position: 'relative' }}>
                                    <img src={pkg.hero_image} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover', opacity: 0.8 }} />
                                    <div style={{ position: 'absolute', inset: 0, background: 'linear-gradient(to top, rgba(10,10,10,0.9), transparent)' }}></div>
                                    <div style={{ position: 'absolute', top: '15px', right: '15px' }}>
                                        <span className={`status-pill ${pkg.difficulty?.toLowerCase()}`} style={{ fontSize: '0.55rem' }}>{pkg.difficulty?.toUpperCase()}</span>
                                    </div>
                                    <div style={{ position: 'absolute', bottom: '20px', left: '20px', right: '20px' }}>
                                        <div style={{ display: 'flex', gap: '12px', alignItems: 'center', marginBottom: '6px' }}>
                                            <span style={{ display: 'flex', alignItems: 'center', gap: '4px', fontSize: '0.65rem', color: 'rgba(255,255,255,0.6)', fontFamily: 'var(--font-mono)' }}>
                                                <Activity size={10} /> {pkg.duration}D
                                            </span>
                                            <span style={{ width: '3px', height: '3px', background: 'var(--gold)', borderRadius: '50%' }}></span>
                                            <span style={{ fontSize: '0.65rem', color: 'var(--gold)', fontFamily: 'var(--font-mono)' }}>
                                                {pkg.success_rate} SUCCESS
                                            </span>
                                        </div>
                                        <h3 style={{ fontSize: '1.4rem', color: 'white', fontWeight: 300 }}>{pkg.name}</h3>
                                    </div>
                                </div>
                                <div style={{ padding: '20px 25px', borderTop: '1px solid rgba(255,255,255,0.03)', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                                    <span style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.4)', fontFamily: 'var(--font-mono)' }}>${pkg.base_price.toLocaleString()}</span>
                                    <button
                                        onClick={(e) => { e.stopPropagation(); handleDelete(pkg.id); }}
                                        style={{ background: 'none', border: 'none', color: '#ff4444', opacity: 0.3, cursor: 'pointer' }}
                                    >
                                        <Trash2 size={16} />
                                    </button>
                                </div>
                            </motion.div>
                        ))}
                    </AnimatePresence>
                </div>

                {/* curator moved to modal */}
            </div>

            {showCurator && isCurating && selectedPkg && (
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
                                <h4 style={SectionHeadStyle}><Shield size={14} /> Route editor</h4>
                                <h2 style={{ fontSize: '1.8rem', color: 'white', fontWeight: 300 }}>{selectedPkg.id ? 'Edit route' : 'Add route'}</h2>
                            </div>
                            <button onClick={() => !saving && (setShowCurator(false), setIsCurating(false))} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.2)', cursor: 'pointer' }}><X size={24} /></button>
                        </div>

                        <div className="curator-scrollarea custom-scrollbar" style={{ display: 'flex', flexDirection: 'column', gap: '30px' }}>
                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Vertical Parametrics</h5>
                                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '15px', marginBottom: '15px' }}>
                                    <AdminInput label="Ascent Designation" value={selectedPkg.name} onChange={v => setSelectedPkg({...selectedPkg, name: v})} />
                                    <AdminInput label="Slug" value={selectedPkg.slug} onChange={v => setSelectedPkg({...selectedPkg, slug: v})} />
                                    <AdminInput label="Technical Severity" value={selectedPkg.difficulty} onChange={v => setSelectedPkg({...selectedPkg, difficulty: v})} />
                                    <AdminInput label="Summit Window" value={selectedPkg.duration} type="number" onChange={v => setSelectedPkg({...selectedPkg, duration: v})} />
                                    <AdminInput label="Success Probability" value={selectedPkg.success_rate} onChange={v => setSelectedPkg({...selectedPkg, success_rate: v})} />
                                    <AdminInput label="Base Capital ($)" value={selectedPkg.base_price} type="number" onChange={v => setSelectedPkg({...selectedPkg, base_price: v})} />
                                </div>
                            </div>

                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Prime Visual Asset</h5>
                                
                                {/* Image Preview */}
                                {imagePreview && (
                                    <div style={{ 
                                        marginBottom: '15px', 
                                        border: '1px solid var(--border)', 
                                        borderRadius: '4px',
                                        overflow: 'hidden',
                                        height: '200px',
                                        position: 'relative'
                                    }}>
                                        <img 
                                            src={imagePreview} 
                                            alt="Hero preview" 
                                            style={{ 
                                                width: '100%', 
                                                height: '100%', 
                                                objectFit: 'cover',
                                                opacity: 0.9 
                                            }} 
                                        />
                                    </div>
                                )}

                                {/* Upload Button */}
                                <div style={{ 
                                    marginBottom: '15px',
                                    display: 'flex',
                                    gap: '10px',
                                    alignItems: 'center'
                                }}>
                                    <input
                                        type="file"
                                        ref={fileInputRef}
                                        accept="image/*"
                                        onChange={handleImageUpload}
                                        style={{ display: 'none' }}
                                        disabled={uploadingImage}
                                    />
                                    <button
                                        type="button"
                                        onClick={() => fileInputRef.current?.click()}
                                        disabled={uploadingImage}
                                        style={{
                                            flex: 1,
                                            padding: '12px',
                                            background: uploadingImage ? 'rgba(212, 175, 55, 0.1)' : 'rgba(255,255,255,0.02)',
                                            border: '1px dashed var(--border)',
                                            color: uploadingImage ? 'var(--gold-dim)' : 'var(--text-dim)',
                                            fontSize: '0.75rem',
                                            fontFamily: 'var(--font-mono)',
                                            cursor: uploadingImage ? 'not-allowed' : 'pointer',
                                            display: 'flex',
                                            alignItems: 'center',
                                            justifyContent: 'center',
                                            gap: '8px',
                                            borderRadius: '4px'
                                        }}
                                    >
                                        {uploadingImage ? (
                                            <>
                                                <Loader2 size={14} className="animate-spin" />
                                                Uploading...
                                            </>
                                        ) : (
                                            <>
                                                <Upload size={14} />
                                                Upload Image
                                            </>
                                        )}
                                    </button>
                                </div>

                                {/* OR Divider */}
                                <div style={{ 
                                    marginBottom: '15px',
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: '10px'
                                }}>
                                    <div style={{ flex: 1, height: '1px', background: 'var(--border)' }}></div>
                                    <span style={{ fontSize: '0.6rem', color: 'var(--text-dim)', fontFamily: 'var(--font-mono)' }}>OR USE URL</span>
                                    <div style={{ flex: 1, height: '1px', background: 'var(--border)' }}></div>
                                </div>

                                {/* URL Input */}
                                <AdminInput 
                                    label="Image URL (alternative)" 
                                    value={selectedPkg.hero_image} 
                                    onChange={v => {
                                        setSelectedPkg({...selectedPkg, hero_image: v});
                                        setImagePreview(v);
                                    }} 
                                />
                            </div>

                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Summit Narrative</h5>
                                <AdminTextarea label="Description" value={selectedPkg.description} rows={6} onChange={v => setSelectedPkg({...selectedPkg, description: v})} />
                            </div>

                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Editorial Content Images</h5>
                                
                                {/* Editorial Image 1 */}
                                <div style={{ marginBottom: '20px' }}>
                                    <label style={LabelStyle}>Editorial Image (Section 1)</label>
                                    <div style={{ display: 'flex', gap: '10px', marginBottom: '10px' }}>
                                        <input
                                            type="file"
                                            ref={editorialFileInputRef1}
                                            accept="image/*"
                                            onChange={handleEditorialUpload1}
                                            style={{ display: 'none' }}
                                            disabled={uploadingEditorial1}
                                        />
                                        <button
                                            type="button"
                                            onClick={() => editorialFileInputRef1.current?.click()}
                                            disabled={uploadingEditorial1}
                                            style={{
                                                flex: 1,
                                                padding: '10px',
                                                background: uploadingEditorial1 ? 'rgba(201, 168, 76, 0.1)' : 'transparent',
                                                border: '1px dashed var(--border)',
                                                color: uploadingEditorial1 ? 'var(--gold-dim)' : 'var(--text-dim-light)',
                                                fontSize: '0.7rem',
                                                fontFamily: 'var(--font-mono)',
                                                cursor: uploadingEditorial1 ? 'not-allowed' : 'pointer',
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center',
                                                gap: '8px'
                                            }}
                                        >
                                            {uploadingEditorial1 ? (
                                                <>
                                                    <Loader2 size={12} className="animate-spin" />
                                                    Uploading...
                                                </>
                                            ) : (
                                                <>
                                                    <Upload size={12} />
                                                    Upload Editorial Image
                                                </>
                                            )}
                                        </button>
                                    </div>
                                    <AdminInput 
                                        label="Editorial Image URL (alternative)" 
                                        value={selectedPkg.editorial_image || ''} 
                                        onChange={v => setSelectedPkg({...selectedPkg, editorial_image: v})} 
                                    />
                                    {selectedPkg.editorial_image && (
                                        <div style={{ height: '120px', background: '#000', border: '1px solid var(--border)', marginTop: '10px', overflow: 'hidden' }}>
                                            <img src={selectedPkg.editorial_image} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                                        </div>
                                    )}
                                </div>

                                {/* Editorial Image 2 */}
                                <div style={{ marginBottom: '20px' }}>
                                    <label style={LabelStyle}>Editorial Image (Section 2)</label>
                                    <div style={{ display: 'flex', gap: '10px', marginBottom: '10px' }}>
                                        <input
                                            type="file"
                                            ref={editorialFileInputRef2}
                                            accept="image/*"
                                            onChange={handleEditorialUpload2}
                                            style={{ display: 'none' }}
                                            disabled={uploadingEditorial2}
                                        />
                                        <button
                                            type="button"
                                            onClick={() => editorialFileInputRef2.current?.click()}
                                            disabled={uploadingEditorial2}
                                            style={{
                                                flex: 1,
                                                padding: '10px',
                                                background: uploadingEditorial2 ? 'rgba(201, 168, 76, 0.1)' : 'transparent',
                                                border: '1px dashed var(--border)',
                                                color: uploadingEditorial2 ? 'var(--gold-dim)' : 'var(--text-dim-light)',
                                                fontSize: '0.7rem',
                                                fontFamily: 'var(--font-mono)',
                                                cursor: uploadingEditorial2 ? 'not-allowed' : 'pointer',
                                                display: 'flex',
                                                alignItems: 'center',
                                                justifyContent: 'center',
                                                gap: '8px'
                                            }}
                                        >
                                            {uploadingEditorial2 ? (
                                                <>
                                                    <Loader2 size={12} className="animate-spin" />
                                                    Uploading...
                                                </>
                                            ) : (
                                                <>
                                                    <Upload size={12} />
                                                    Upload Editorial Image 2
                                                </>
                                            )}
                                        </button>
                                    </div>
                                    <AdminInput 
                                        label="Editorial Image 2 URL (alternative)" 
                                        value={selectedPkg.editorial_image_2 || ''} 
                                        onChange={v => setSelectedPkg({...selectedPkg, editorial_image_2: v})} 
                                    />
                                    {selectedPkg.editorial_image_2 && (
                                        <div style={{ height: '120px', background: '#000', border: '1px solid var(--border)', marginTop: '10px', overflow: 'hidden' }}>
                                            <img src={selectedPkg.editorial_image_2} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                                        </div>
                                    )}
                                </div>

                                {/* Editorial Content Text */}
                                <div>
                                    <AdminTextarea 
                                        label="Editorial Content (Optional)" 
                                        value={selectedPkg.editorial_content || ''} 
                                        rows={4} 
                                        onChange={v => setSelectedPkg({...selectedPkg, editorial_content: v})} 
                                    />
                                </div>
                            </div>

                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Strategic Highlights</h5>
                                <EditableList
                                    label="Highlights"
                                    items={selectedPkg.highlights}
                                    onAdd={() => setSelectedPkg({...selectedPkg, highlights: [...(selectedPkg.highlights || []), '']})}
                                    onUpdate={(i, v) => {
                                        const list = [...selectedPkg.highlights];
                                        list[i] = v;
                                        setSelectedPkg({...selectedPkg, highlights: list});
                                    }}
                                    onRemove={(i) => setSelectedPkg({...selectedPkg, highlights: selectedPkg.highlights.filter((_, idx) => idx !== i)})}
                                />
                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Logistics & Provisions</h5>
                                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '30px' }}>
                                    <EditableList
                                        label="Inclusions"
                                        items={selectedPkg.inclusions}
                                        onAdd={() => setSelectedPkg({...selectedPkg, inclusions: [...(selectedPkg.inclusions || []), '']})}
                                        onUpdate={(i, v) => {
                                            const list = [...selectedPkg.inclusions];
                                            list[i] = v;
                                            setSelectedPkg({...selectedPkg, inclusions: list});
                                        }}
                                        onRemove={(i) => setSelectedPkg({...selectedPkg, inclusions: selectedPkg.inclusions.filter((_, idx) => idx !== i)})}
                                    />
                                    <EditableList
                                        label="Exclusions"
                                        items={selectedPkg.exclusions}
                                        onAdd={() => setSelectedPkg({...selectedPkg, exclusions: [...(selectedPkg.exclusions || []), '']})}
                                        onUpdate={(i, v) => {
                                            const list = [...selectedPkg.exclusions];
                                            list[i] = v;
                                            setSelectedPkg({...selectedPkg, exclusions: list});
                                        }}
                                        onRemove={(i) => setSelectedPkg({...selectedPkg, exclusions: selectedPkg.exclusions.filter((_, idx) => idx !== i)})}
                                    />
                                </div>
                            </div>
                        </div>

                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Vertical Milestones</h5>
                                <div style={{ display: 'flex', flexDirection: 'column', gap: '15px' }}>
                                    {(selectedPkg.itinerary || []).map((day, idx) => (
                                        <div key={idx} style={{ background: 'rgba(255,255,255,0.02)', border: '1px solid var(--border)', padding: '15px' }}>
                                            <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '10px' }}>
                                                <span style={{ fontSize: '0.6rem', color: 'var(--gold)', fontFamily: 'var(--font-mono)' }}>ALTITUDE PHASE {idx + 1}</span>
                                                <button
                                                    onClick={() => setSelectedPkg({...selectedPkg, itinerary: selectedPkg.itinerary.filter((_, i) => i !== idx)})}
                                                    style={{ background: 'none', border: 'none', color: '#ff4444', opacity: 0.5, cursor: 'pointer' }}
                                                ><X size={12} /></button>
                                            </div>
                                            <input
                                                placeholder="Phase Headline"
                                                value={day.title || ''}
                                                onChange={(e) => {
                                                    const it = [...selectedPkg.itinerary];
                                                    it[idx].title = e.target.value;
                                                    setSelectedPkg({...selectedPkg, itinerary: it});
                                                }}
                                                style={CompactInput}
                                            />
                                            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: '10px', marginTop: '10px' }}>
                                                <div>
                                                    <label style={{...LabelStyle, fontSize: '10px', marginBottom: '4px'}}>Elevation (m)</label>
                                                    <input placeholder="e.g. 2800" value={day.elevation_m || ''} onChange={e => { const it=[...selectedPkg.itinerary]; it[idx].elevation_m=e.target.value; setSelectedPkg({...selectedPkg, itinerary:it}); }} style={CompactInput} />
                                                </div>
                                                <div>
                                                    <label style={{...LabelStyle, fontSize: '10px', marginBottom: '4px'}}>Distance</label>
                                                    <input placeholder="e.g. 5 km" value={day.distance_km || ''} onChange={e => { const it=[...selectedPkg.itinerary]; it[idx].distance_km=e.target.value; setSelectedPkg({...selectedPkg, itinerary:it}); }} style={CompactInput} />
                                                </div>
                                                <div>
                                                    <label style={{...LabelStyle, fontSize: '10px', marginBottom: '4px'}}>Hiking Time</label>
                                                    <input placeholder="e.g. 4-5 hours" value={day.hiking_time || ''} onChange={e => { const it=[...selectedPkg.itinerary]; it[idx].hiking_time=e.target.value; setSelectedPkg({...selectedPkg, itinerary:it}); }} style={CompactInput} />
                                                </div>
                                                <div>
                                                    <label style={{...LabelStyle, fontSize: '10px', marginBottom: '4px'}}>Habitat</label>
                                                    <input placeholder="e.g. Rainforest" value={day.habitat || ''} onChange={e => { const it=[...selectedPkg.itinerary]; it[idx].habitat=e.target.value; setSelectedPkg({...selectedPkg, itinerary:it}); }} style={CompactInput} />
                                                </div>
                                                <div>
                                                    <label style={{...LabelStyle, fontSize: '10px', marginBottom: '4px'}}>Camp Name</label>
                                                    <input placeholder="e.g. Mti Mkubwa Camp" value={day.camp_name || ''} onChange={e => { const it=[...selectedPkg.itinerary]; it[idx].camp_name=e.target.value; setSelectedPkg({...selectedPkg, itinerary:it}); }} style={CompactInput} />
                                                </div>
                                                <div>
                                                    <label style={{...LabelStyle, fontSize: '10px', marginBottom: '4px'}}>Meals</label>
                                                    <input placeholder="e.g. B, L, D" value={day.meals || ''} onChange={e => { const it=[...selectedPkg.itinerary]; it[idx].meals=e.target.value; setSelectedPkg({...selectedPkg, itinerary:it}); }} style={CompactInput} />
                                                </div>
                                            </div>
                                            <textarea
                                                placeholder="Day details…"
                                                value={day.description || ''}
                                                rows={3}
                                                onChange={(e) => {
                                                    const it = [...selectedPkg.itinerary];
                                                    it[idx].description = e.target.value;
                                                    setSelectedPkg({...selectedPkg, itinerary: it});
                                                }}
                                                style={{ ...CompactInput, marginTop: '10px', height: '60px', resize: 'none' }}
                                            />
                                        </div>
                                    ))}
                                    <button
                                        onClick={() => setSelectedPkg({...selectedPkg, itinerary: [...(selectedPkg.itinerary || []), { title: '', description: '', elevation_m: '', distance_km: '', hiking_time: '', habitat: '', camp_name: '', meals: '' }]})}
                                        style={{ width: '100%', padding: '12px', background: 'transparent', border: '1px dashed var(--border)', color: 'var(--text-dim-light)', fontSize: '0.7rem', cursor: 'pointer' }}
                                    >+ APPEND ASCENT PHASE</button>
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

/* ─── HELPER COMPONENTS ─── */

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

const AdminInput = ({ label, value, onChange, type = "text" }) => (
    <div style={{ marginBottom: '15px' }}>
        <label style={LabelStyle}>{label}</label>
        <input
            type={type}
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

const CompactInput = {
    width: '100%',
    background: '#000',
    border: '1px solid var(--border)',
    color: 'white',
    padding: '8px 12px',
    fontSize: '0.8rem',
    outline: 'none'
};

const EditableList = ({ label, items, onAdd, onUpdate, onRemove }) => (
    <div>
        <label style={LabelStyle}>{label}</label>
        <div style={{ display: 'flex', flexDirection: 'column', gap: '8px' }}>
            {(items || []).map((item, i) => (
                <div key={i} style={{ display: 'flex', gap: '8px', alignItems: 'center' }}>
                    <input 
                        value={item} 
                        onChange={e => onUpdate(i, e.target.value)}
                        style={{ ...CompactInput, fontSize: '0.75rem' }}
                    />
                    <button onClick={() => onRemove(i)} style={{ background: 'none', border: 'none', color: '#ff4444', opacity: 0.5, cursor: 'pointer' }}><X size={12} /></button>
                </div>
            ))}
            <button onClick={onAdd} style={{ width: '100%', padding: '6px', background: 'transparent', border: '1px dashed var(--border)', color: 'var(--text-dim-light)', fontSize: '0.65rem' }}>+ ADD</button>
        </div>
    </div>
);
