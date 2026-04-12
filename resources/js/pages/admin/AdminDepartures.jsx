import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    Plus, Trash2, Save, ChevronDown, ChevronUp, X, 
    Calendar, MapPin, DollarSign, Users, Loader2,
    Shield, Target, Zap, Clock, AlertTriangle, Layers,
    Activity, ArrowRight, Settings
} from 'lucide-react';
import { adminService, trekkingService } from '../../services/api';
import '../../styles/admin-premium.css';

export const AdminDepartures = () => {
    const [departures, setDepartures] = useState([]);
    const [routes, setRoutes] = useState([]);
    const [loading, setLoading] = useState(true);
    const [expandedId, setExpandedId] = useState(null);
    const [saving, setSaving] = useState(false);

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            const [depRes, routesRes] = await Promise.all([
                adminService.getDepartures(),
                trekkingService.getAll()
            ]);
            setDepartures(depRes.data);
            setRoutes(routesRes.data);
        } catch (error) {
            console.error("Failed to load departures:", error);
        } finally {
            setLoading(false);
        }
    };

    const toggleExpand = (id) => {
        setExpandedId(expandedId === id ? null : id);
    };

    const handleDelete = async (id) => {
        if (!window.confirm('Strike this expedition from the schedule permanently?')) return;
        try {
            await adminService.deleteDeparture(id);
            await fetchData();
        } catch (error) {
            alert("Unable to delete this departure.");
        }
    };

    const handleSave = async (id, data) => {
        try {
            setSaving(true);
            if (id === 'new') {
                await adminService.createDeparture(data);
            } else {
                await adminService.updateDeparture(id, data);
            }
            await fetchData();
            setExpandedId(null);
        } catch (error) {
            alert("Unable to save changes. Please try again.");
        } finally {
            setSaving(false);
        }
    };

    const handleAddNew = () => {
        const newDep = {
            id: 'new',
            trekking_route_id: routes[0]?.id || '',
            departure_date: new Date().toISOString().split('T')[0],
            status: 'Available',
            price_cents: 250000,
            available_seats: 12,
            booked_seats: 0,
            inclusions: [],
            exclusions: []
        };
        setDepartures([newDep, ...departures]);
        setExpandedId('new');
    };

    if (loading) return (
        <div style={{ height: '60vh', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center' }}>
            <Loader2 className="animate-spin" size={48} color="var(--gold)" />
            <span style={{ marginTop: '20px', fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--gold)', letterSpacing: '0.3em' }}>Loading departures…</span>
        </div>
    );

    return (
        <div className="admin-page-root">
            <header style={{ marginBottom: '60px', display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                <div>
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.25em', textTransform: 'uppercase', marginBottom: '12px' }}>Trips</h2>
                    <h1 className="admin-page-title" style={{ fontSize: '3.5rem', fontWeight: 300, color: 'white' }}>Group departures</h1>
                </div>
                <button onClick={handleAddNew} className="admin-btn-primary">
                    <Plus size={18} /> Add departure
                </button>
            </header>

            <div className="departure-windows-stack" style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
                <AnimatePresence>
                    {departures.map((dep, idx) => (
                        <DeparturePanel 
                            key={dep.id || 'new'} 
                            dep={dep} 
                            routes={routes}
                            isExpanded={expandedId === (dep.id || 'new')} 
                            onToggle={() => toggleExpand(dep.id || 'new')}
                            onSave={(data) => handleSave(dep.id || 'new', data)}
                            onDelete={() => handleDelete(dep.id)}
                            saving={saving}
                            index={idx}
                        />
                    ))}
                </AnimatePresence>
            </div>
        </div>
    );
};

function toDateInputValue(value) {
    if (!value) return '';
    // Accept "YYYY-MM-DD" or full ISO timestamps like "2026-08-04T00:00:00.000000Z".
    if (typeof value === 'string' && /^\d{4}-\d{2}-\d{2}$/.test(value)) return value;
    const d = new Date(value);
    if (Number.isNaN(d.getTime())) return '';
    const yyyy = d.getFullYear();
    const mm = String(d.getMonth() + 1).padStart(2, '0');
    const dd = String(d.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
}

const DeparturePanel = ({ dep, routes, isExpanded, onToggle, onSave, onDelete, saving, index }) => {
    const [formData, setFormData] = useState({
        ...dep,
        departure_date: toDateInputValue(dep.departure_date),
        return_date: toDateInputValue(dep.return_date),
        inclusions: dep.inclusions || [],
        exclusions: dep.exclusions || []
    });

    useEffect(() => {
        setFormData({
            ...dep,
            departure_date: toDateInputValue(dep.departure_date),
            return_date: toDateInputValue(dep.return_date),
            inclusions: dep.inclusions || [],
            exclusions: dep.exclusions || []
        });
    }, [dep]);

    const handleChange = (field, value) => {
        setFormData(prev => ({ ...prev, [field]: value }));
    };

    return (
        <motion.div 
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ delay: index * 0.05 }}
            className={`admin-panel ${isExpanded ? 'active' : ''}`} 
            style={{ 
                border: isExpanded ? '1px solid var(--gold)' : '1px solid var(--border)',
                background: 'var(--slate)',
                overflow: 'hidden'
            }}
        >
            <div 
                className="panel-header" 
                onClick={onToggle} 
                style={{ 
                    cursor: 'pointer', 
                    padding: '30px 45px', 
                    display: 'flex', 
                    justifyContent: 'space-between', 
                    alignItems: 'center',
                    background: isExpanded ? 'rgba(201,168,76,0.03)' : 'transparent'
                }}
            >
                <div style={{ display: 'flex', alignItems: 'center', gap: '35px' }}>
                    <div style={{ width: 55, height: 55, background: 'rgba(255,255,255,0.02)', border: '1px solid var(--border)', borderRadius: '2px', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--gold)' }}>
                        <Target size={24} />
                    </div>
                    <div>
                        <div style={{ fontSize: '1.4rem', color: 'white', fontWeight: 300, marginBottom: '6px' }}>
                            {routes.find(r => r.id == formData.trekking_route_id)?.name || 'UNASSIGNED_EXPEDITION'}
                        </div>
                        <div style={{ fontSize: '0.7rem', color: 'var(--text-dim-light)', fontFamily: 'var(--font-mono)', display: 'flex', gap: '20px', alignItems: 'center' }}>
                            <span style={{ display: 'flex', alignItems: 'center', gap: '6px' }}><Calendar size={12} color="var(--gold-dim)" /> {formData.departure_date}</span>
                            <span style={{ width: '4px', height: '4px', background: 'var(--gold)', borderRadius: '50%' }}></span>
                            <span style={{ display: 'flex', alignItems: 'center', gap: '6px' }}><Users size={12} color="var(--gold-dim)" /> {formData.available_seats - formData.booked_seats} AVAILABLE</span>
                            <span style={{ width: '4px', height: '4px', background: 'var(--gold)', borderRadius: '50%' }}></span>
                            <span style={{ display: 'flex', alignItems: 'center', gap: '6px' }}><DollarSign size={12} color="var(--gold-dim)" /> ${formData.price_cents / 100}</span>
                        </div>
                    </div>
                </div>
                <div style={{ display: 'flex', alignItems: 'center', gap: '30px' }}>
                    <span className={`status-pill status-${formData.status.toLowerCase()}`}>
                        {formData.status.toUpperCase()}
                    </span>
                    {isExpanded ? <ChevronUp size={20} color="var(--gold)" /> : <ChevronDown size={20} color="rgba(255,255,255,0.2)" />}
                    {dep.id !== 'new' && (
                        <button 
                            onClick={(e) => { e.stopPropagation(); onDelete(); }} 
                            style={{ background: 'none', border: 'none', color: '#ff4444', cursor: 'pointer', padding: '10px', opacity: 0.3 }}
                            onMouseOver={e => e.currentTarget.style.opacity = 0.8}
                            onMouseOut={e => e.currentTarget.style.opacity = 0.3}
                        >
                            <Trash2 size={18} />
                        </button>
                    )}
                </div>
            </div>

            <AnimatePresence>
                {isExpanded && (
                    <motion.div 
                        initial={{ height: 0, opacity: 0 }}
                        animate={{ height: 'auto', opacity: 1 }}
                        exit={{ height: 0, opacity: 0 }}
                        style={{ borderTop: '1px solid var(--border)', background: 'rgba(0,0,0,0.2)' }}
                    >
                        <div style={{ padding: '60px' }}>
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: '40px', marginBottom: '50px' }}>
                                <div className="form-group">
                                    <label style={LabelStyle}><Layers size={12} /> Route</label>
                                    <select 
                                        value={formData.trekking_route_id} 
                                        onChange={(e) => handleChange('trekking_route_id', e.target.value)}
                                        style={SelectStyle}
                                    >
                                        <option value="">Select Route</option>
                                        {routes.map(r => <option key={r.id} value={r.id}>{r.name}</option>)}
                                    </select>
                                </div>
                                <FieldInput label="Phase Commencement" value={formData.departure_date} type="date" onChange={(v) => handleChange('departure_date', v)} icon={<Clock size={12} />} />
                                <FieldInput label="Price (cents)" value={formData.price_cents} type="number" onChange={(v) => handleChange('price_cents', v)} icon={<DollarSign size={12} />} />
                                
                                <FieldInput label="Current Status" value={formData.status} onChange={(v) => handleChange('status', v)} icon={<Zap size={12} />} />
                                <FieldInput label="Payload Capacity" value={formData.available_seats} type="number" onChange={(v) => handleChange('available_seats', v)} icon={<Users size={12} />} />
                                <FieldInput label="Committed Load" value={formData.booked_seats} type="number" onChange={(v) => handleChange('booked_seats', v)} icon={<Shield size={12} />} />
                            </div>

                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '60px' }}>
                                <EditableList 
                                    label="Inclusions" 
                                    items={formData.inclusions} 
                                    onUpdate={(i, v) => {
                                        const list = [...formData.inclusions];
                                        list[i] = v;
                                        handleChange('inclusions', list);
                                    }}
                                    onAdd={() => handleChange('inclusions', [...formData.inclusions, ''])}
                                    onRemove={(i) => handleChange('inclusions', formData.inclusions.filter((_, idx) => idx !== i))}
                                />
                                <EditableList 
                                    label="Exclusions" 
                                    items={formData.exclusions} 
                                    onUpdate={(i, v) => {
                                        const list = [...formData.exclusions];
                                        list[i] = v;
                                        handleChange('exclusions', list);
                                    }}
                                    onAdd={() => handleChange('exclusions', [...formData.exclusions, ''])}
                                    onRemove={(i) => handleChange('exclusions', formData.exclusions.filter((_, idx) => idx !== i))}
                                />
                            </div>

                            <div style={{ display: 'flex', gap: '20px', justifyContent: 'flex-end', marginTop: '60px', paddingTop: '40px', borderTop: '1px solid rgba(255,255,255,0.05)' }}>
                                <button className="admin-btn-secondary" onClick={onToggle} style={{ padding: '15px 40px' }}>ABORT</button>
                                <button 
                                    className="admin-btn-primary" 
                                    disabled={saving} 
                                    onClick={() => onSave(formData)} 
                                    style={{ padding: '15px 50px' }}
                                >
                                    {saving ? <Loader2 className="animate-spin" size={18} /> : <Save size={18} />}
                                    <span>{saving ? 'Saving…' : 'Save changes'}</span>
                                </button>
                            </div>
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>
        </motion.div>
    );
};

/* ─── HELPER COMPONENTS ─── */

const FieldInput = ({ label, value, onChange, icon, type = "text" }) => (
    <div style={{ marginBottom: '25px' }}>
        <label style={LabelStyle}>{icon} {label}</label>
        <input 
            type={type} 
            value={value || ''} 
            onChange={(e) => onChange(e.target.value)}
            style={InputStyle}
        />
    </div>
);

const LabelStyle = {
    display: 'flex',
    alignItems: 'center',
    gap: '10px',
    fontSize: '0.65rem',
    color: 'var(--text-dim-light)',
    marginBottom: '10px',
    textTransform: 'uppercase',
    letterSpacing: '0.15em',
    fontFamily: 'var(--font-mono)'
};

const InputStyle = {
    width: '100%',
    background: '#000',
    border: '1px solid var(--border)',
    color: 'white',
    padding: '12px 18px',
    fontSize: '0.9rem',
    outline: 'none',
    transition: 'all 0.3s'
};

const SelectStyle = {
    ...InputStyle,
    cursor: 'pointer'
};

const EditableList = ({ label, items, onUpdate, onAdd, onRemove }) => (
    <div>
        <label style={LabelStyle}>{label}</label>
        <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
            {items.map((item, i) => (
                <div key={i} style={{ display: 'flex', alignItems: 'center', gap: '12px' }}>
                    <input 
                        value={item} 
                        onChange={(e) => onUpdate(i, e.target.value)}
                        style={{ ...InputStyle, padding: '10px 15px', fontSize: '0.85rem' }}
                    />
                    <button onClick={() => onRemove(i)} style={{ background: 'none', border: 'none', color: '#ff4444', opacity: 0.3, cursor: 'pointer' }}><X size={16} /></button>
                </div>
            ))}
            <button onClick={onAdd} style={{ width: '100%', padding: '12px', background: 'transparent', border: '1px dashed var(--border)', color: 'var(--text-dim-light)', fontSize: '0.75rem', cursor: 'pointer' }}>+ APPEND INITIAL ENTRY</button>
        </div>
    </div>
);
