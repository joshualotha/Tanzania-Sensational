import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    Plus, Search, Edit3, Trash2, Camera, Clock, 
    ChevronRight, MapPin, DollarSign, X, Loader2, Save,
    Shield, Briefcase, List, Info, Layers, Zap
} from 'lucide-react';
import { adminService, safariService } from '../../services/api';
import '../../styles/admin-premium.css';

export const AdminSafaris = () => {
    const [safaris, setSafaris] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedSafari, setSelectedSafari] = useState(null);
    const [isCurating, setIsCurating] = useState(false);
    const [saving, setSaving] = useState(false);
    const [showCurator, setShowCurator] = useState(false);

    useEffect(() => {
        fetchSafaris();
    }, []);

    const fetchSafaris = async () => {
        try {
            setLoading(true);
            const response = await safariService.getAll();
            setSafaris(response.data);
        } catch (error) {
            console.error("Inventory Acquisition Failure:", error);
        } finally {
            setLoading(false);
        }
    };

    const handleOpenCurator = (safari = null) => {
        if (safari) {
            setSelectedSafari({ 
                ...safari, 
                itinerary: safari.itinerary || [],
                inclusions: safari.inclusions || [],
                exclusions: safari.exclusions || []
            });
        } else {
            setSelectedSafari({
                name: 'New safari package',
                slug: `safari-${Date.now()}`,
                base_price: 4500,
                duration: 7,
                description: '',
                meta_tag: 'EXCLUSIVE',
                category: 'SIGNATURE',
                hero_image: 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&q=80',
                itinerary: [],
                inclusions: [],
                exclusions: []
            });
        }
        setIsCurating(true);
        setShowCurator(true);
    };

    const handleSave = async () => {
        setSaving(true);
        try {
            if (selectedSafari.id) {
                await adminService.updateSafari(selectedSafari.id, selectedSafari);
            } else {
                await adminService.createSafari(selectedSafari);
            }
            await fetchSafaris();
            setIsCurating(false);
            setShowCurator(false);
            setSelectedSafari(null);
        } catch (error) {
            alert("Unable to save changes. Please try again.");
        } finally {
            setSaving(false);
        }
    };

    const handleDelete = async (id) => {
        if (!window.confirm("Delete this safari package? This action is irreversible.")) return;
        try {
            await adminService.deleteSafari(id);
            setSafaris(safaris.filter(s => s.id !== id));
            if (selectedSafari?.id === id) {
                setIsCurating(false);
                setSelectedSafari(null);
            }
        } catch (error) {
            alert("Unable to delete the package.");
        }
    };

    const filteredSafaris = safaris.filter(s => 
        (s.name || '').toLowerCase().includes(searchTerm.toLowerCase()) ||
        (s.description || '').toLowerCase().includes(searchTerm.toLowerCase())
    );

    if (loading) return (
        <div style={{ height: '60vh', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center' }}>
            <Loader2 className="animate-spin" size={48} color="var(--gold)" />
            <span style={{ marginTop: '20px', fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--gold)', letterSpacing: '0.3em' }}>Loading safari packages…</span>
        </div>
    );

    return (
        <div className="admin-page-root">
            <header style={{ marginBottom: '60px', display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                <div>
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.25em', textTransform: 'uppercase', marginBottom: '12px' }}>Safaris</h2>
                    <h1 className="admin-page-title" style={{ fontSize: '3.5rem', fontWeight: 300 }}>Safari Collection</h1>
                </div>
                
                <div style={{ display: 'flex', gap: '20px', alignItems: 'center' }}>
                    <div className="admin-search-wrapper" style={{ border: '1px solid var(--border)', background: 'rgba(255,255,255,0.02)' }}>
                        <Search size={18} color="var(--gold-dim)" />
                        <input 
                            type="text" 
                            placeholder="Search packages…" 
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            style={{ background: 'transparent', border: 'none', color: 'white', padding: '12px 10px', fontFamily: 'var(--font-mono)', fontSize: '0.75rem' }}
                        />
                    </div>
                    <button className="admin-btn-primary" onClick={() => handleOpenCurator()}>
                        <Plus size={18} /> Add package
                    </button>
                </div>
            </header>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr', gap: '50px', alignItems: 'start' }}>
                {/* ─── GRID OF EXPEDITIONS ─── */}
                <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(350px, 1fr))', gap: '30px' }}>
                    <AnimatePresence>
                        {filteredSafaris.map((safari, idx) => (
                            <motion.div 
                                key={safari.id}
                                initial={{ opacity: 0, scale: 0.98 }}
                                animate={{ opacity: 1, scale: 1 }}
                                transition={{ delay: idx * 0.05 }}
                                className={`safari-command-card ${selectedSafari?.id === safari.id ? 'active' : ''}`}
                                onClick={() => handleOpenCurator(safari)}
                                style={{
                                    background: 'var(--slate)',
                                    border: '1px solid var(--border)',
                                    borderRadius: '4px',
                                    overflow: 'hidden',
                                    cursor: 'pointer',
                                    position: 'relative',
                                    borderColor: selectedSafari?.id === safari.id ? 'var(--gold)' : 'var(--border)'
                                }}
                            >
                                <div style={{ height: '220px', position: 'relative' }}>
                                    <img src={safari.hero_image} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover', opacity: 0.8 }} />
                                    <div style={{ position: 'absolute', inset: 0, background: 'linear-gradient(to top, rgba(10,10,10,0.9), transparent)' }}></div>
                                    <div style={{ position: 'absolute', top: '15px', right: '15px' }}>
                                        <span className="status-pill status-active" style={{ fontSize: '0.55rem' }}>{safari.category || 'SIGNATURE'}</span>
                                    </div>
                                    <div style={{ position: 'absolute', bottom: '20px', left: '20px', right: '20px' }}>
                                        <div style={{ display: 'flex', gap: '12px', alignItems: 'center', marginBottom: '6px' }}>
                                            <span style={{ display: 'flex', alignItems: 'center', gap: '4px', fontSize: '0.65rem', color: 'rgba(255,255,255,0.6)', fontFamily: 'var(--font-mono)' }}>
                                                <Clock size={10} /> {safari.duration}D
                                            </span>
                                            <span style={{ width: '3px', height: '3px', background: 'var(--gold)', borderRadius: '50%' }}></span>
                                            <span style={{ fontSize: '0.65rem', color: 'var(--gold)', fontFamily: 'var(--font-mono)' }}>
                                                FROM ${Math.round(safari.base_price).toLocaleString()}
                                            </span>
                                        </div>
                                        <h3 style={{ fontSize: '1.4rem', color: 'white', fontWeight: 300 }}>{safari.name}</h3>
                                    </div>
                                </div>
                                <div style={{ padding: '20px 25px', borderTop: '1px solid rgba(255,255,255,0.03)', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
                                    <span style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.4)', fontFamily: 'var(--font-mono)' }}>ID: {safari.slug}</span>
                                    <button 
                                        onClick={(e) => { e.stopPropagation(); handleDelete(safari.id); }}
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

            {showCurator && isCurating && selectedSafari && (
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
                                <h4 style={SectionHeadStyle}><Shield size={14} /> Package editor</h4>
                                <h2 style={{ fontSize: '1.8rem', color: 'white', fontWeight: 300 }}>{selectedSafari.id ? 'Edit package' : 'Add package'}</h2>
                            </div>
                            <button onClick={() => !saving && (setShowCurator(false), setIsCurating(false))} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.2)', cursor: 'pointer' }}><X size={24} /></button>
                        </div>

                        <div className="curator-scrollarea custom-scrollbar" style={{ display: 'flex', flexDirection: 'column', gap: '30px' }}>
                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Details</h5>
                                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '15px', marginBottom: '15px' }}>
                                    <AdminInput label="Expedition Name" value={selectedSafari.name} onChange={v => setSelectedSafari({...selectedSafari, name: v})} />
                                    <AdminInput label="Slug" value={selectedSafari.slug} onChange={v => setSelectedSafari({...selectedSafari, slug: v})} />
                                    <AdminInput label="Duration (Days)" type="number" value={selectedSafari.duration} onChange={v => setSelectedSafari({...selectedSafari, duration: v})} />
                                    <AdminInput label="Base Price ($)" type="number" value={selectedSafari.base_price} onChange={v => setSelectedSafari({...selectedSafari, base_price: v})} />
                                </div>
                                <AdminInput label="Hero Visual URL" value={selectedSafari.hero_image} onChange={v => setSelectedSafari({...selectedSafari, hero_image: v})} />
                            </div>

                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Description</h5>
                                <AdminTextarea label="Description" value={selectedSafari.description} rows={6} onChange={v => setSelectedSafari({...selectedSafari, description: v})} />
                            </div>

                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Sequential Milestones (Itinerary)</h5>
                                <div style={{ display: 'flex', flexDirection: 'column', gap: '15px' }}>
                                    {(selectedSafari.itinerary || []).map((day, idx) => (
                                        <div key={idx} style={{ background: 'rgba(255,255,255,0.02)', border: '1px solid var(--border)', padding: '15px' }}>
                                            <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '10px' }}>
                                                <span style={{ fontSize: '0.6rem', color: 'var(--gold)', fontFamily: 'var(--font-mono)' }}>DAY {day.day || idx + 1}</span>
                                                <button
                                                    onClick={() => setSelectedSafari({...selectedSafari, itinerary: selectedSafari.itinerary.filter((_, i) => i !== idx)})}
                                                    style={{ background: 'none', border: 'none', color: '#ff4444', opacity: 0.5, cursor: 'pointer' }}
                                                ><X size={12} /></button>
                                            </div>
                                            <input
                                                placeholder="Milestone Title"
                                                value={day.title}
                                                onChange={(e) => {
                                                    const it = [...selectedSafari.itinerary];
                                                    it[idx].title = e.target.value;
                                                    setSelectedSafari({...selectedSafari, itinerary: it});
                                                }}
                                                style={CompactInput}
                                            />
                                            <textarea
                                                placeholder="Detailed brief..."
                                                value={day.desc}
                                                rows={3}
                                                onChange={(e) => {
                                                    const it = [...selectedSafari.itinerary];
                                                    it[idx].desc = e.target.value;
                                                    setSelectedSafari({...selectedSafari, itinerary: it});
                                                }}
                                                style={{ ...CompactInput, marginTop: '8px', height: '60px', resize: 'none' }}
                                            />
                                        </div>
                                    ))}
                                    <button
                                        onClick={() => setSelectedSafari({...selectedSafari, itinerary: [...(selectedSafari.itinerary || []), { day: (selectedSafari.itinerary?.length || 0) + 1, title: '', desc: '' }]})}
                                        style={{ width: '100%', padding: '12px', background: 'transparent', border: '1px dashed var(--border)', color: 'var(--text-dim-light)', fontSize: '0.7rem', cursor: 'pointer' }}
                                    >+ APPEND MILESTONE</button>
                                </div>
                            </div>

                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Logistic Parameters</h5>
                                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px' }}>
                                    <EditableList
                                        label="Inclusions"
                                        items={selectedSafari.inclusions}
                                        onAdd={() => setSelectedSafari({...selectedSafari, inclusions: [...(selectedSafari.inclusions || []), '']})}
                                        onUpdate={(i, v) => {
                                            const list = [...selectedSafari.inclusions];
                                            list[i] = v;
                                            setSelectedSafari({...selectedSafari, inclusions: list});
                                        }}
                                        onRemove={(i) => setSelectedSafari({...selectedSafari, inclusions: selectedSafari.inclusions.filter((_, idx) => idx !== i)})}
                                    />
                                    <EditableList
                                        label="Exclusions"
                                        items={selectedSafari.exclusions}
                                        onAdd={() => setSelectedSafari({...selectedSafari, exclusions: [...(selectedSafari.exclusions || []), '']})}
                                        onUpdate={(i, v) => {
                                            const list = [...selectedSafari.exclusions];
                                            list[i] = v;
                                            setSelectedSafari({...selectedSafari, exclusions: list});
                                        }}
                                        onRemove={(i) => setSelectedSafari({...selectedSafari, exclusions: selectedSafari.exclusions.filter((_, idx) => idx !== i)})}
                                    />
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
