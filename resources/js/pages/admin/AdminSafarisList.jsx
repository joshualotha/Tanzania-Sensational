import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    Plus, Edit3, Trash2, MapPin, Clock, DollarSign, 
    ChevronRight, X, Shield, Search, RefreshCw, Loader2,
    Layers, Zap, Info
} from 'lucide-react';
import { adminService } from '../../services/api';
import '../../styles/admin-premium.css';

export const AdminSafarisList = () => {
    const [safaris, setSafaris] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');
    const [showForm, setShowForm] = useState(false);
    const [editingSafari, setEditingSafari] = useState(null);
    const [submitting, setSubmitting] = useState(false);

    // Form State
    const [formData, setFormData] = useState({
        name: '',
        slug: '',
        duration: '',
        base_price: '',
        description: '',
        category: 'Private Safari',
        meta_tag: 'Premium Expedition'
    });

    useEffect(() => {
        fetchSafaris();
    }, []);

    const fetchSafaris = async () => {
        try {
            setLoading(true);
            const response = await adminService.getSafaris();
            setSafaris(response.data);
        } catch (error) {
            console.error("Safaris Fetch Failure:", error);
        } finally {
            setLoading(false);
        }
    };

    const handleOpenForm = (safari = null) => {
        if (safari) {
            setEditingSafari(safari);
            setFormData({
                name: safari.name,
                slug: safari.slug,
                duration: safari.duration,
                base_price: safari.base_price,
                description: safari.description,
                category: safari.category || 'Private Safari',
                meta_tag: safari.meta_tag || 'Premium Expedition'
            });
        } else {
            setEditingSafari(null);
            setFormData({
                name: '',
                slug: '',
                duration: '',
                base_price: '',
                description: '',
                category: 'Private Safari',
                meta_tag: 'Premium Expedition'
            });
        }
        setShowForm(true);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setSubmitting(true);
        try {
            if (editingSafari) {
                await adminService.updateSafari(editingSafari.id, formData);
            } else {
                const finalData = { ...formData, slug: formData.slug || formData.name.toLowerCase().replace(/ /g, '-') };
                await adminService.createSafari(finalData);
            }
            setShowForm(false);
            fetchSafaris();
        } catch (error) {
            alert("Unable to save changes. Please try again.");
        } finally {
            setSubmitting(false);
        }
    };

    const handleDelete = async (id) => {
        if (!window.confirm("Delete this safari package?")) return;
        try {
            await adminService.deleteSafari(id);
            setSafaris(safaris.filter(s => s.id !== id));
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
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--gold)', letterSpacing: '0.25em', marginBottom: '12px' }}>Safaris</h2>
                    <h1 className="admin-page-title">Safari Collection</h1>
                </div>
                <div style={{ display: 'flex', gap: '20px' }}>
                    <div className="admin-search-wrapper">
                        <Search size={18} />
                        <input 
                            type="text" 
                            placeholder="Search packages…" 
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                        />
                    </div>
                    <button className="admin-btn-primary" onClick={() => handleOpenForm()}>
                        <Plus size={18} /> Add package
                    </button>
                </div>
            </header>

            <div className="admin-grid-layout" style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(380px, 1fr))', gap: '30px' }}>
                <AnimatePresence>
                    {filteredSafaris.map((safari, idx) => (
                        <motion.div 
                            key={safari.id}
                            initial={{ opacity: 0, y: 30 }}
                            animate={{ opacity: 1, y: 0 }}
                            transition={{ delay: idx * 0.05 }}
                            className="admin-safari-card-premium"
                            style={{ 
                                background: 'rgba(255,255,255,0.01)',
                                border: '1px solid var(--border)',
                                borderRadius: '4px',
                                overflow: 'hidden'
                            }}
                        >
                            <div style={{ height: '200px', overflow: 'hidden', position: 'relative' }}>
                                <img 
                                    src={safari.hero_image || 'https://images.unsplash.com/photo-1516428990250-d8ab18c99149?auto=format&fit=crop&q=80'} 
                                    alt="" 
                                    style={{ width: '100%', height: '100%', objectFit: 'cover', opacity: 0.7 }}
                                />
                                <div style={{ position: 'absolute', top: '15px', right: '15px', display: 'flex', gap: '10px' }}>
                                    <button 
                                        onClick={() => handleOpenForm(safari)}
                                        style={{ background: 'rgba(0,0,0,0.5)', border: '1px solid rgba(255,255,255,0.1)', padding: '8px', borderRadius: '4px', color: 'white', cursor: 'pointer' }}
                                    >
                                        <Edit3 size={14} />
                                    </button>
                                    <button 
                                        onClick={() => handleDelete(safari.id)}
                                        style={{ background: 'rgba(255,68,68,0.2)', border: '1px solid rgba(255,68,68,0.2)', padding: '8px', borderRadius: '4px', color: '#ff4444', cursor: 'pointer' }}
                                    >
                                        <Trash2 size={14} />
                                    </button>
                                </div>
                                <div style={{ position: 'absolute', bottom: '0', left: '0', right: '0', padding: '20px', background: 'linear-gradient(to top, rgba(0,0,0,0.8), transparent)' }}>
                                    <div style={{ display: 'flex', gap: '15px', fontSize: '0.6rem', color: 'rgba(255,255,255,0.6)', fontFamily: 'var(--font-mono)', textTransform: 'uppercase', letterSpacing: '0.1em' }}>
                                        <span><Clock size={10} style={{ verticalAlign: 'middle', marginRight: '4px' }} /> {safari.duration} DAYS</span>
                                        <span><Layers size={10} style={{ verticalAlign: 'middle', marginRight: '4px' }} /> {safari.category || 'EXPEDITION'}</span>
                                    </div>
                                </div>
                            </div>
                            <div style={{ padding: '25px' }}>
                                <h3 style={{ fontSize: '1.2rem', color: 'white', fontWeight: 600, marginBottom: '12px' }}>{safari.name}</h3>
                                <p style={{ fontSize: '0.85rem', color: 'rgba(255,255,255,0.5)', lineHeight: '1.6', height: '54px', overflow: 'hidden', marginBottom: '25px' }}>
                                    {safari.description}
                                </p>
                                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', paddingTop: '20px', borderTop: '1px solid rgba(255,255,255,0.05)' }}>
                                    <div>
                                        <span style={{ display: 'block', fontSize: '0.6rem', color: 'var(--gold)', textTransform: 'uppercase', letterSpacing: '0.1em', marginBottom: '4px' }}>Base Investment</span>
                                        <span style={{ fontSize: '1.2rem', color: 'white', fontWeight: 600 }}>${Number(safari.base_price || 0).toLocaleString()}</span>
                                    </div>
                                    <button className="admin-btn-mini info" style={{ padding: '8px 15px', color: 'var(--gold)', border: '1px solid var(--gold-dim)', background: 'transparent', fontSize: '0.7rem', fontFamily: 'var(--font-mono)' }}>
                                        DETAILS <ChevronRight size={14} style={{ verticalAlign: 'middle' }} />
                                    </button>
                                </div>
                            </div>
                        </motion.div>
                    ))}
                </AnimatePresence>
            </div>

            {/* FORM MODAL */}
            <AnimatePresence>
                {showForm && (
                    <div className="admin-modal-overlay" onClick={() => setShowForm(false)}>
                        <motion.div 
                            className="admin-modal shadow-premium"
                            initial={{ opacity: 0, scale: 0.95 }}
                            animate={{ opacity: 1, scale: 1 }}
                            exit={{ opacity: 0, scale: 0.95 }}
                            onClick={e => e.stopPropagation()}
                            style={{ maxWidth: '650px', width: '90%' }}
                        >
                            <div className="modal-header">
                                <h2>{editingSafari ? 'Edit package' : 'Add package'}</h2>
                                <button onClick={() => setShowForm(false)} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.3)', cursor: 'pointer' }}>
                                    <X size={24} />
                                </button>
                            </div>
                            <div className="modal-body">
                                <form onSubmit={handleSubmit} style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
                                    <div className="form-group-premium">
                                        <label style={LabelStyle}>Expedition Designation</label>
                                        <input 
                                            type="text" 
                                            value={formData.name}
                                            onChange={(e) => setFormData({...formData, name: e.target.value})}
                                            placeholder="SERENGETI LEGACY COLLECTIVE" 
                                            required 
                                            style={InputStyle}
                                        />
                                    </div>
                                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px' }}>
                                        <div className="form-group-premium">
                                            <label style={LabelStyle}>Asset Base Price ($)</label>
                                            <input 
                                                type="number" 
                                                value={formData.base_price}
                                                onChange={(e) => setFormData({...formData, base_price: e.target.value})}
                                                placeholder="8400" 
                                                required 
                                                style={InputStyle}
                                            />
                                        </div>
                                        <div className="form-group-premium">
                                            <label style={LabelStyle}>Cycle Duration (Days)</label>
                                            <input 
                                                type="number" 
                                                value={formData.duration}
                                                onChange={(e) => setFormData({...formData, duration: e.target.value})}
                                                placeholder="10" 
                                                required 
                                                style={InputStyle}
                                            />
                                        </div>
                                    </div>
                                    <div className="form-group-premium">
                                        <label style={LabelStyle}>Description</label>
                                        <textarea 
                                            value={formData.description}
                                            onChange={(e) => setFormData({...formData, description: e.target.value})}
                                            placeholder="Short description for the package…" 
                                            required 
                                            style={{ ...InputStyle, height: '120px', resize: 'none' }}
                                        />
                                    </div>
                                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px' }}>
                                        <div className="form-group-premium">
                                            <label style={LabelStyle}>Designation Category</label>
                                            <select 
                                                value={formData.category}
                                                onChange={(e) => setFormData({...formData, category: e.target.value})}
                                                style={InputStyle}
                                            >
                                                <option>Private Safari</option>
                                                <option>Group Expedition</option>
                                                <option>Luxury Collective</option>
                                            </select>
                                        </div>
                                        <div className="form-group-premium">
                                            <label style={LabelStyle}>Meta classification</label>
                                            <input 
                                                type="text" 
                                                value={formData.meta_tag}
                                                onChange={(e) => setFormData({...formData, meta_tag: e.target.value})}
                                                placeholder="Bespoke Experience" 
                                                style={InputStyle}
                                            />
                                        </div>
                                    </div>
                                    <div className="modal-footer" style={{ marginTop: '20px', padding: '0', border: 'none' }}>
                                        <button type="button" className="admin-btn-secondary" onClick={() => setShowForm(false)}>ABORT</button>
                                        <button type="submit" className="admin-btn-primary" disabled={submitting}>
                                            {submitting ? <Loader2 className="animate-spin" size={16} /> : <Shield size={16} />}
                                            <span>{editingSafari ? 'COMMIT RECONFIGURATION' : 'LOG INITIAL ENTRY'}</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </motion.div>
                    </div>
                )}
            </AnimatePresence>
        </div>
    );
};

const LabelStyle = {
    display: 'block',
    fontSize: '0.65rem',
    color: 'var(--text-dim-light)',
    marginBottom: '10px',
    textTransform: 'uppercase',
    letterSpacing: '0.1em',
    fontFamily: 'var(--font-mono)'
};

const InputStyle = {
    width: '100%',
    background: 'rgba(255,255,255,0.03)',
    border: '1px solid var(--border)',
    color: 'white',
    padding: '14px 18px',
    fontSize: '0.9rem',
    borderRadius: '4px',
    transition: 'all 0.3s ease',
    outline: 'none',
    fontFamily: 'var(--font-body)'
};


