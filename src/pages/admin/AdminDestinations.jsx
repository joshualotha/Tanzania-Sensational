import React, { useState } from 'react';
import { Plus, Trash2, Save, ChevronDown, ChevronUp, X } from 'lucide-react';
import { destinationsData } from '../../data/destinationsData';

export const AdminDestinations = () => {
    const [expandedId, setExpandedId] = useState(null);

    const toggleExpand = (id) => {
        setExpandedId(expandedId === id ? null : id);
    };

    return (
        <div>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '30px' }}>
                <h2 style={{ fontSize: '1.5rem', color: 'white' }}>Safari Destinations ({destinationsData.length})</h2>
                <button className="btn-admin-primary" style={{ width: 'auto', padding: '12px 25px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                    <Plus size={16} /> Add Destination
                </button>
            </div>

            {destinationsData.map((dest) => (
                <div key={dest.id} className="admin-panel" style={{ marginBottom: '20px' }}>
                    {/* HEADER ROW */}
                    <div style={{ padding: '20px 30px', display: 'flex', justifyContent: 'space-between', alignItems: 'center', borderBottom: expandedId === dest.id ? '1px solid rgba(255,255,255,0.05)' : 'none' }}>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
                            <div style={{ width: 50, height: 50, borderRadius: 4, overflow: 'hidden', flexShrink: 0 }}>
                                <img src={dest.heroImg} alt={dest.name} style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                            </div>
                            <div>
                                <div style={{ fontWeight: 600, color: 'white', fontSize: '1rem' }}>{dest.name}</div>
                                <div style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.4)' }}>{dest.subtitle} · {dest.coordinates}</div>
                            </div>
                        </div>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                            <span className="status-pill status-new">{dest.tag}</span>
                            <button onClick={() => toggleExpand(dest.id)} style={{ background: 'none', border: 'none', color: 'var(--gold)', cursor: 'pointer' }}>
                                {expandedId === dest.id ? <ChevronUp size={18} /> : <ChevronDown size={18} />}
                            </button>
                            <button style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer' }}><Trash2 size={16} /></button>
                        </div>
                    </div>

                    {/* EXPANDED EDIT FORM */}
                    {expandedId === dest.id && (
                        <div style={{ padding: '30px' }}>

                            {/* ── SECTION 1: HERO & IDENTITY ── */}
                            <SectionHeader title="Section 1 · Hero & Identity" />
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '20px', marginBottom: '40px' }}>
                                <FieldInput label="Destination Name" value={dest.name} />
                                <FieldInput label="Subtitle" value={dest.subtitle} />
                                <FieldInput label="Tag / Badge" value={dest.tag} />
                                <FieldInput label="Coordinates" value={dest.coordinates} />
                                <FieldInput label="Elevation" value={dest.elevation} />
                                <FieldInput label="Recommended Duration" value={dest.duration} />
                                <FieldInput label="Best Time to Visit" value={dest.bestTime} full />
                                <FieldInput label="Hero Image URL" value={dest.heroImg} full />
                            </div>

                            {/* ── SECTION 2: EXPEDITION METADATA ── */}
                            <SectionHeader title="Section 2 · Expedition Ledger (Metadata Sidebar)" />
                            <p style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.35)', marginBottom: '15px', marginTop: '-10px' }}>
                                These populate the metadata sidebar on the detail page: Encounter Rate, Best Time, Expedition Tier, Tracking Method.
                            </p>
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr 1fr', gap: '20px', marginBottom: '40px' }}>
                                <FieldInput label="Encounter Rate" value={dest.encounterRate} />
                                <FieldInput label="Expedition Tier" value={dest.expeditionTier} />
                                <FieldInput label="Tracking Method" value={dest.trackingMethod} />
                            </div>

                            {/* ── SECTION 3: NARRATIVE OVERVIEW ── */}
                            <SectionHeader title="Section 3 · Narrative Content" />
                            <FieldTextarea label="Short Description (Card Preview on listing page)" value={dest.shortDesc} rows={3} />
                            <FieldTextarea label="Full Overview (Detail Page body text)" value={dest.overview} rows={5} />
                            <FieldTextarea label="Overview Quote (italic pullquote in narrative)" value={dest.overviewQuote} rows={2} />

                            {/* ── SECTION 4: EXPERIENCE NARRATIVES ── */}
                            {dest.experience && (
                                <div style={{ marginBottom: '40px' }}>
                                    <SectionHeader title="Section 4 · Experience Narratives (Data source for ledger cards)" />
                                    <FieldTextarea label="Atmosphere" value={dest.experience.atmosphere} rows={4} />
                                    <FieldTextarea label="Wildlife" value={dest.experience.wildlife} rows={4} />
                                    <FieldTextarea label="Impact" value={dest.experience.impact} rows={4} />
                                </div>
                            )}

                            {/* ── SECTION 5: ATMOSPHERE VITALS (Left Ledger Card) ── */}
                            <SectionHeader title="Section 5 · Atmosphere Vitals (Left Ledger Card)" />
                            <p style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.35)', marginBottom: '15px', marginTop: '-10px' }}>
                                4 vital items displayed in "The Atmosphere" card on the detail page.
                            </p>
                            <div style={{ marginBottom: '20px' }}>
                                {(dest.atmosphereVitals || []).map((vital, i) => (
                                    <VitalRow key={i} index={i} label={vital.label} text={vital.text} />
                                ))}
                            </div>
                            <FieldInput label="Atmosphere Card Footer Quote" value={dest.atmosphereFooter} full />
                            <div style={{ marginBottom: '40px' }}></div>

                            {/* ── SECTION 6: WILDLIFE VITALS (Right Ledger Card) ── */}
                            <SectionHeader title="Section 6 · Wildlife Vitals (Right Ledger Card)" />
                            <p style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.35)', marginBottom: '15px', marginTop: '-10px' }}>
                                4 vital items displayed in "Wildlife Ledger" card on the detail page.
                            </p>
                            <div style={{ marginBottom: '20px' }}>
                                {(dest.wildlifeVitals || []).map((vital, i) => (
                                    <VitalRow key={i} index={i} label={vital.label} text={vital.text} />
                                ))}
                            </div>
                            <FieldInput label="Wildlife Card Footer Note" value={dest.wildlifeFooter} full />
                            <div style={{ marginBottom: '40px' }}></div>

                            {/* ── SECTION 7: HIGHLIGHTS & WILDLIFE LIST ── */}
                            <SectionHeader title="Section 7 · Highlights & Wildlife Species" />
                            <TagList label="Highlights" items={dest.highlights} />
                            <TagList label="Wildlife Species List" items={dest.wildlifeList} />

                            {/* ── SECTION 8: GALLERY (6 Images) ── */}
                            <SectionHeader title="Section 8 · Visual Archive (Gallery — 6 Images)" />
                            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: '15px', marginBottom: '40px' }}>
                                {dest.gallery.map((img, i) => (
                                    <div key={i}>
                                        <img src={img} alt={`Gallery ${i+1}`} style={{ width: '100%', height: '120px', objectFit: 'cover', borderRadius: '4px', border: '1px solid rgba(255,255,255,0.1)' }} />
                                        <input 
                                            type="text" 
                                            defaultValue={img} 
                                            style={{ width: '100%', background: '#000', border: '1px solid rgba(255,255,255,0.1)', color: 'rgba(255,255,255,0.6)', padding: '6px 8px', fontSize: '0.65rem', marginTop: '5px' }} 
                                        />
                                    </div>
                                ))}
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

const VitalRow = ({ index, label, text }) => (
    <div style={{ display: 'grid', gridTemplateColumns: '160px 1fr 30px', gap: '10px', alignItems: 'center', marginBottom: '8px' }}>
        <input 
            type="text" 
            defaultValue={label} 
            style={{ background: '#000', border: '1px solid rgba(201,168,76,0.2)', color: 'var(--gold)', padding: '8px 10px', fontSize: '0.8rem' }}
        />
        <input 
            type="text" 
            defaultValue={text} 
            style={{ background: '#000', border: '1px solid rgba(255,255,255,0.1)', color: 'rgba(255,255,255,0.8)', padding: '8px 10px', fontSize: '0.8rem' }}
        />
        <button style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer' }}><X size={14} /></button>
    </div>
);

const TagList = ({ label, items }) => (
    <div style={{ marginBottom: '30px' }}>
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
