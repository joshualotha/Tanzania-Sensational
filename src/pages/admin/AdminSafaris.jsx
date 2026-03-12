import React, { useState } from 'react';
import { Plus, Trash2, Save, ChevronDown, ChevronUp, X } from 'lucide-react';
import { safarisData } from '../../data/safarisData';

export const AdminSafaris = () => {
    const [expandedId, setExpandedId] = useState(null);

    const toggleExpand = (id) => {
        setExpandedId(expandedId === id ? null : id);
    };

    return (
        <div>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '30px' }}>
                <h2 style={{ fontSize: '1.5rem', color: 'white' }}>Safari Packages ({safarisData.length})</h2>
                <button className="btn-admin-primary" style={{ width: 'auto', padding: '12px 25px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                    <Plus size={16} /> Add Package
                </button>
            </div>

            {safarisData.map((pkg) => (
                <div key={pkg.id} className="admin-panel" style={{ marginBottom: '20px' }}>
                    {/* HEADER ROW */}
                    <div style={{ padding: '20px 30px', display: 'flex', justifyContent: 'space-between', alignItems: 'center', borderBottom: expandedId === pkg.id ? '1px solid rgba(255,255,255,0.05)' : 'none' }}>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
                            <div style={{ width: 50, height: 50, borderRadius: 4, overflow: 'hidden', flexShrink: 0 }}>
                                <img src={pkg.heroImg} alt={pkg.title} style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                            </div>
                            <div>
                                <div style={{ fontWeight: 600, color: 'white' }}>{pkg.title}</div>
                                <div style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.4)' }}>{pkg.duration} · {pkg.parks} · {pkg.price}</div>
                            </div>
                        </div>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                            <span className={`status-pill ${pkg.badge === 'SIGNATURE' ? 'status-new' : pkg.badge === 'EXCLUSIVE' ? 'status-confirmed' : 'status-completed'}`}>{pkg.badge}</span>
                            <button onClick={() => toggleExpand(pkg.id)} style={{ background: 'none', border: 'none', color: 'var(--gold)', cursor: 'pointer' }}>
                                {expandedId === pkg.id ? <ChevronUp size={18} /> : <ChevronDown size={18} />}
                            </button>
                            <button style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer' }}><Trash2 size={16} /></button>
                        </div>
                    </div>

                    {/* EXPANDED EDIT FORM */}
                    {expandedId === pkg.id && (
                        <div style={{ padding: '30px' }}>
                            {/* SECTION 1: HERO & CORE INFO */}
                            <SectionHeader title="Section 1: Hero & Core Identity" />
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px', marginBottom: '40px' }}>
                                <FieldInput label="Package Title" value={pkg.title} />
                                <FieldInput label="Duration" value={pkg.duration} />
                                <FieldInput label="Parks / Route" value={pkg.parks} />
                                <FieldInput label="Price (pp)" value={pkg.price} />
                                <FieldInput label="Badge (SIGNATURE / CLASSIC / EXCLUSIVE)" value={pkg.badge} />
                                <FieldInput label="Hero Image URL" value={pkg.heroImg} full />
                            </div>

                            {/* SECTION 2: OVERVIEW & ESSENCE */}
                            <SectionHeader title="Section 2: Narrative Overview (Essence Brief + Hero)" />
                            <FieldTextarea label="Overview (appears in Hero and 'The Essence' section)" value={pkg.overview} rows={4} />

                            {/* SECTION 3: METRICS BAR */}
                            <SectionHeader title="Section 3: Technical Metrics Bar" />
                            <p style={{ fontSize: '0.8rem', color: 'rgba(255,255,255,0.4)', marginBottom: '15px', marginTop: '-10px' }}>
                                These fields populate the data ribbon below the hero: Duration, Parks, Pace Level, and Price.
                            </p>
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr 1fr', gap: '20px', marginBottom: '40px' }}>
                                <FieldInput label="Expedition Length" value={pkg.duration} />
                                <FieldInput label="Operational Area" value={pkg.parks} />
                                <FieldInput label="Pace Level" value={pkg.paceLevel || "Signature Heritage"} />
                                <FieldInput label="Investment" value={pkg.price} />
                            </div>

                            {/* SECTION 4: HIGHLIGHTS */}
                            {pkg.highlights && (
                                <>
                                    <SectionHeader title="Section 4: Highlights" />
                                    <TagList label="Key Highlights" items={pkg.highlights} />
                                </>
                            )}

                            {/* SECTION 5: ITINERARY (The Journey) */}
                            <SectionHeader title="Section 5: Itinerary — The Journey" />
                            <div style={{ marginBottom: '40px' }}>
                                {pkg.itinerary.map((day, idx) => (
                                    <div key={idx} style={{ background: 'rgba(0,0,0,0.3)', border: '1px solid rgba(255,255,255,0.05)', padding: '20px', marginBottom: '10px', borderRadius: '4px' }}>
                                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '15px' }}>
                                            <span style={{ color: 'var(--gold)', fontWeight: 700, fontSize: '0.8rem' }}>Day {day.day}</span>
                                            <button style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer' }}><Trash2 size={14} /></button>
                                        </div>
                                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '15px' }}>
                                            <FieldInput label="Day Title" value={day.title} />
                                            <FieldInput label="Accommodation" value={day.accommodation} />
                                            <FieldTextarea label="Description" value={day.desc} rows={2} />
                                            <FieldInput label="Meals" value={day.meals} />
                                        </div>
                                    </div>
                                ))}
                                <button style={{ background: 'none', border: '1px dashed rgba(255,255,255,0.15)', color: 'rgba(255,255,255,0.4)', padding: '12px', width: '100%', cursor: 'pointer', fontSize: '0.8rem', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '8px' }}>
                                    <Plus size={14} /> Add Day
                                </button>
                            </div>

                            {/* SECTION 6: INCLUSIONS & EXCLUSIONS (Sidebar) */}
                            <SectionHeader title="Section 6: Inclusions & Exclusions (Prestige Sidebar)" />
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '30px', marginBottom: '40px' }}>
                                <EditableList label="Inclusions" items={pkg.inclusions} color="#38A169" />
                                <EditableList label="Exclusions" items={pkg.exclusions} color="#E53E3E" />
                            </div>

                            {/* SAVE / CANCEL */}
                            <div style={{ display: 'flex', gap: '15px', justifyContent: 'flex-end', paddingTop: '20px', borderTop: '1px solid rgba(255,255,255,0.05)' }}>
                                <button onClick={() => setExpandedId(null)} style={{ background: 'none', border: '1px solid rgba(255,255,255,0.15)', color: 'rgba(255,255,255,0.5)', padding: '10px 25px', cursor: 'pointer', fontSize: '0.8rem' }}>
                                    Cancel
                                </button>
                                <button className="btn-admin-primary" style={{ width: 'auto', padding: '10px 25px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                                    <Save size={14} /> Save Changes
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
