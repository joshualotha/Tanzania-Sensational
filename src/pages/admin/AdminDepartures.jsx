import React, { useState } from 'react';
import { Plus, Trash2, Save, ChevronDown, ChevronUp, X, Calendar, MapPin, DollarSign, Users } from 'lucide-react';
import { departuresData as initialData } from '../../data/departuresData';

export const AdminDepartures = () => {
    const [departures, setDepartures] = useState(initialData);
    const [expandedId, setExpandedId] = useState(null);

    const toggleExpand = (id) => {
        setExpandedId(expandedId === id ? null : id);
    };

    const handleDelete = (id) => {
        if (window.confirm('Are you sure you want to delete this departure?')) {
            setDepartures(departures.filter(d => d.id !== id));
        }
    };

    return (
        <div>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '30px' }}>
                <h2 style={{ fontSize: '1.5rem', color: 'white' }}>Group Departures ({departures.length})</h2>
                <button className="btn-admin-primary" style={{ width: 'auto', padding: '12px 25px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                    <Plus size={16} /> Schedule Departure
                </button>
            </div>

            {departures.map((dep) => (
                <div key={dep.id} className="admin-panel" style={{ marginBottom: '20px' }}>
                    {/* HEADER ROW */}
                    <div style={{ padding: '20px 30px', display: 'flex', justifyContent: 'space-between', alignItems: 'center', borderBottom: expandedId === dep.id ? '1px solid rgba(255,255,255,0.05)' : 'none' }}>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
                            <div style={{ width: 45, height: 45, background: 'rgba(201,168,76,0.1)', borderRadius: 4, display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--gold)' }}>
                                <Calendar size={20} />
                            </div>
                            <div>
                                <div style={{ fontWeight: 600, color: 'white' }}>{dep.route}</div>
                                <div style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.4)' }}>{dep.date} · {dep.price} · {dep.spotsLeft} spots left</div>
                            </div>
                        </div>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                            <span className={`status-pill ${dep.status === 'Available' ? 'status-confirmed' : dep.status === 'Limited' ? 'status-new' : 'status-completed'}`}>
                                {dep.status}
                            </span>
                            <button onClick={() => toggleExpand(dep.id)} style={{ background: 'none', border: 'none', color: 'var(--gold)', cursor: 'pointer' }}>
                                {expandedId === dep.id ? <ChevronUp size={18} /> : <ChevronDown size={18} />}
                            </button>
                            <button onClick={() => handleDelete(dep.id)} style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer' }}>
                                <Trash2 size={16} />
                            </button>
                        </div>
                    </div>

                    {/* EXPANDED EDIT FORM */}
                    {expandedId === dep.id && (
                        <div style={{ padding: '30px' }}>
                            {/* SECTION 1: CORE DETAILS */}
                            <SectionHeader title="Section 1 · Schedule & Core Info" />
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px', marginBottom: '40px' }}>
                                <FieldInput label="Date Range" value={dep.date} />
                                <FieldInput label="Route Name" value={dep.route} />
                                <FieldInput label="Investment (Price)" value={dep.price} />
                                <FieldInput label="Current Status (Available/Limited/Full)" value={dep.status} />
                                <FieldInput label="Difficulty Level" value={dep.difficulty} />
                                <FieldInput label="Maximum Group Size" value={dep.groupSize} />
                                <FieldInput label="Spots Remaining" value={dep.spotsLeft.toString()} />
                                <FieldInput label="Hero Image URL" value={dep.heroImg} full />
                            </div>

                            {/* SECTION 2: LOGISTICS */}
                            <SectionHeader title="Section 2 · Logistics & Dates" />
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px', marginBottom: '40px' }}>
                                <FieldInput label="Summit Night Date" value={dep.summitNight} />
                                <FieldInput label="Meeting Point" value={dep.meetingPoint} />
                                <FieldInput label="Briefing Date/Time" value={dep.briefingDate} full />
                            </div>

                            {/* SECTION 3: DESCRIPTION */}
                            <SectionHeader title="Section 3 · Narrative Description" />
                            <FieldTextarea label="Expedition Overview" value={dep.description} rows={4} />

                            {/* SECTION 4: HIGHLIGHTS */}
                            <SectionHeader title="Section 4 · Key Highlights" />
                            <TagList label="Highlights" items={dep.highlights} />

                            {/* SECTION 5: ITINERARY SUMMARY */}
                            <SectionHeader title="Section 5 · Itinerary & Elevations" />
                            <div style={{ marginBottom: '40px' }}>
                                {dep.itinerarySummary.map((item, idx) => (
                                    <div key={idx} style={{ display: 'grid', gridTemplateColumns: '80px 1fr 150px 30px', gap: '15px', alignItems: 'center', marginBottom: '10px' }}>
                                        <div style={{ fontSize: '0.75rem', fontWeight: 700, color: 'var(--gold)' }}>DAY {item.day}</div>
                                        <input type="text" defaultValue={item.title} style={{ background: '#000', border: '1px solid rgba(255,255,255,0.1)', color: 'white', padding: '8px 10px', fontSize: '0.8rem' }} />
                                        <input type="text" defaultValue={item.elevation} placeholder="Elevation" style={{ background: '#000', border: '1px solid rgba(255,255,255,0.1)', color: 'rgba(255,255,255,0.6)', padding: '8px 10px', fontSize: '0.8rem' }} />
                                        <button style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer' }}><X size={14} /></button>
                                    </div>
                                ))}
                                <button style={{ background: 'none', border: '1px dashed rgba(255,255,255,0.15)', color: 'rgba(255,255,255,0.4)', padding: '10px', width: '100%', cursor: 'pointer', fontSize: '0.75rem', marginTop: '10px' }}>
                                    + Add Itinerary Day
                                </button>
                            </div>

                            {/* SECTION 6: INCLUSIONS & EXCLUSIONS */}
                            <SectionHeader title="Section 6 · Ledger Inclusions & Exclusions" />
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '30px', marginBottom: '40px' }}>
                                <EditableList label="Inclusions" items={dep.inclusions} color="#38A169" />
                                <EditableList label="Exclusions" items={dep.exclusions} color="#E53E3E" />
                            </div>

                            {/* SAVE / CANCEL */}
                            <div style={{ display: 'flex', gap: '15px', justifyContent: 'flex-end', paddingTop: '20px', borderTop: '1px solid rgba(255,255,255,0.05)' }}>
                                <button onClick={() => setExpandedId(null)} style={{ background: 'none', border: '1px solid rgba(255,255,255,0.15)', color: 'rgba(255,255,255,0.5)', padding: '10px 25px', cursor: 'pointer', fontSize: '0.8rem' }}>
                                    Cancel
                                </button>
                                <button className="btn-admin-primary" style={{ width: 'auto', padding: '10px 25px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                                    <Save size={14} /> Update Schedule
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            ))}
        </div>
    );
};

/* ─── REUSABLE FORM COMPONENTS ─── */
const SectionHeader = ({ title }) => (
    <h4 style={{ fontSize: '0.7rem', textTransform: 'uppercase', letterSpacing: '0.15em', color: 'var(--gold)', marginBottom: '20px', paddingBottom: '10px', borderBottom: '1px solid rgba(255,255,255,0.05)' }}>
        {title}
    </h4>
);

const FieldInput = ({ label, value, full }) => (
    <div style={{ gridColumn: full ? '1 / -1' : 'auto' }}>
        <label style={{ display: 'block', fontSize: '0.7rem', color: 'rgba(255,255,255,0.5)', marginBottom: '6px', textTransform: 'uppercase', letterSpacing: '0.05em' }}>{label}</label>
        <input 
            type="text" 
            defaultValue={value} 
            style={{ width: '100%', background: '#000', border: '1px solid rgba(255,255,255,0.1)', color: 'white', padding: '10px 12px', fontSize: '0.85rem', fontFamily: 'Outfit, sans-serif' }}
        />
    </div>
);

const FieldTextarea = ({ label, value, rows = 3 }) => (
    <div style={{ marginBottom: '20px' }}>
        <label style={{ display: 'block', fontSize: '0.7rem', color: 'rgba(255,255,255,0.5)', marginBottom: '6px', textTransform: 'uppercase', letterSpacing: '0.05em' }}>{label}</label>
        <textarea 
            defaultValue={value} 
            rows={rows}
            style={{ width: '100%', background: '#000', border: '1px solid rgba(255,255,255,0.1)', color: 'white', padding: '12px', fontSize: '0.85rem', fontFamily: 'Outfit, sans-serif', resize: 'vertical', lineHeight: '1.6' }}
        />
    </div>
);

const TagList = ({ label, items }) => (
    <div style={{ marginBottom: '40px' }}>
        <label style={{ display: 'block', fontSize: '0.7rem', color: 'rgba(255,255,255,0.5)', marginBottom: '10px', textTransform: 'uppercase', letterSpacing: '0.05em' }}>{label}</label>
        <div style={{ display: 'flex', flexWrap: 'wrap', gap: '8px' }}>
            {items.map((item, i) => (
                <div key={i} style={{ display: 'flex', alignItems: 'center', gap: '6px', background: 'rgba(201,168,76,0.08)', border: '1px solid rgba(201,168,76,0.2)', padding: '4px 10px', fontSize: '0.75rem', color: 'var(--gold)' }}>
                    {item}
                    <X size={12} style={{ cursor: 'pointer', opacity: 0.5 }} />
                </div>
            ))}
            <button style={{ background: 'none', border: '1px dashed rgba(255,255,255,0.15)', color: 'rgba(255,255,255,0.4)', padding: '4px 12px', fontSize: '0.75rem', cursor: 'pointer' }}>
                + Add
            </button>
        </div>
    </div>
);

const EditableList = ({ label, items, color }) => (
    <div>
        <label style={{ display: 'block', fontSize: '0.7rem', color: 'rgba(255,255,255,0.5)', marginBottom: '10px', textTransform: 'uppercase', letterSpacing: '0.05em' }}>{label}</label>
        {items.map((item, i) => (
            <div key={i} style={{ display: 'flex', alignItems: 'center', gap: '10px', marginBottom: '8px' }}>
                <div style={{ width: 6, height: 6, borderRadius: '50%', background: color, flexShrink: 0 }}></div>
                <input 
                    type="text" 
                    defaultValue={item} 
                    style={{ flex: 1, background: '#000', border: '1px solid rgba(255,255,255,0.1)', color: 'rgba(255,255,255,0.8)', padding: '8px 10px', fontSize: '0.8rem' }}
                />
                <button style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer', flexShrink: 0 }}><X size={14} /></button>
            </div>
        ))}
        <button style={{ background: 'none', border: '1px dashed rgba(255,255,255,0.15)', color: 'rgba(255,255,255,0.4)', padding: '8px', width: '100%', cursor: 'pointer', fontSize: '0.75rem', marginTop: '8px' }}>
            + Add Item
        </button>
    </div>
);
