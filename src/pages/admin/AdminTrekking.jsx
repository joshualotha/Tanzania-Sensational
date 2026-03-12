import React, { useState } from 'react';
import { Eye, Edit, Trash2, Plus, X, Save, Clock, Activity, Camera, TrendingUp } from 'lucide-react';
import { packagesData } from '../../data/packagesData';

export const AdminTrekking = () => {
    const [packages, setPackages] = useState(packagesData);
    const [selectedPkg, setSelectedPkg] = useState(null);
    const [isEditing, setIsEditing] = useState(false);

    // Group packages by route for the Master View
    const routeGroups = packages.reduce((acc, pkg) => {
        const route = pkg.routeId;
        if (!acc[route]) acc[route] = [];
        acc[route].push(pkg);
        return acc;
    }, {});

    const handleEdit = (pkg) => {
        setSelectedPkg({ ...pkg });
        setIsEditing(true);
    };

    const handleDelete = (id) => {
        if (window.confirm('Are you sure you want to delete this package?')) {
            setPackages(packages.filter(p => p.id !== id));
            if (selectedPkg?.id === id) setSelectedPkg(null);
        }
    };

    const handleSave = () => {
        setPackages(packages.map(p => p.id === selectedPkg.id ? selectedPkg : p));
        setIsEditing(false);
        setSelectedPkg(null);
    };

    return (
        <div style={{ display: 'grid', gridTemplateColumns: selectedPkg ? '1fr 500px' : '1fr', gap: '30px', transition: 'all 0.4s ease' }}>
            {/* ─── MASTER VIEW: TABLE ─── */}
            <div>
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '30px' }}>
                    <h2 style={{ fontSize: '1.5rem', color: 'white' }}>Trekking Expeditions ({packages.length})</h2>
                    <button className="btn-admin-primary" style={{ width: 'auto', padding: '12px 25px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                        <Plus size={16} /> Add New Package
                    </button>
                </div>

                {Object.entries(routeGroups).map(([routeName, packages]) => (
                    <div key={routeName} style={{ marginBottom: '40px' }}>
                        <h3 style={{ fontSize: '0.8rem', textTransform: 'uppercase', letterSpacing: '0.15em', color: 'var(--gold)', marginBottom: '15px', paddingBottom: '10px', borderBottom: '1px solid rgba(255,255,255,0.05)' }}>
                            {routeName.replace(/-/g, ' ')} Route
                        </h3>
                        <div className="admin-panel" style={{ background: 'rgba(255,255,255,0.02)', border: '1px solid rgba(255,255,255,0.05)' }}>
                            <table className="admin-table">
                                <thead>
                                    <tr>
                                        <th>Package</th>
                                        <th>Duration</th>
                                        <th>Difficulty</th>
                                        <th style={{ textAlign: 'right' }}>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {packages.map((pkg) => (
                                        <tr key={pkg.id} 
                                            onClick={() => setSelectedPkg(pkg)}
                                            style={{ cursor: 'pointer', background: selectedPkg?.id === pkg.id ? 'rgba(201,168,76,0.05)' : 'transparent' }}
                                        >
                                            <td style={{ fontWeight: 600, color: selectedPkg?.id === pkg.id ? 'var(--gold)' : 'white' }}>{pkg.title}</td>
                                            <td>{pkg.duration}</td>
                                            <td>
                                                <span className={`status-pill ${
                                                    pkg.difficulty === 'Extreme' ? 'status-new' :
                                                    pkg.difficulty === 'High' ? 'status-confirmed' : 'status-completed'
                                                }`}>
                                                    {pkg.difficulty}
                                                </span>
                                            </td>
                                            <td style={{ textAlign: 'right' }}>
                                                <div style={{ display: 'flex', gap: '10px', justifyContent: 'flex-end' }}>
                                                    <button onClick={(e) => { e.stopPropagation(); handleEdit(pkg); }} style={iconBtnStyle}><Edit size={16} /></button>
                                                    <button onClick={(e) => { e.stopPropagation(); handleDelete(pkg.id); }} style={{ ...iconBtnStyle, color: '#E53E3E' }}><Trash2 size={16} /></button>
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                ))}
            </div>

            {/* ─── DETAIL VIEW: EDITOR/PREVIEW ─── */}
            {selectedPkg && (
                <div style={{ 
                    background: '#111', 
                    borderLeft: '1px solid rgba(255,255,255,0.08)',
                    padding: '40px 30px',
                    height: 'calc(100vh - 120px)',
                    position: 'sticky',
                    top: '110px',
                    overflowY: 'auto'
                }}>
                    <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '30px' }}>
                        <span className="status-pill status-new">{isEditing ? 'Editing' : 'Preview'}</span>
                        <div style={{ display: 'flex', gap: '10px' }}>
                            {isEditing && (
                                <button onClick={handleSave} style={{ background: 'var(--gold)', border: 'none', color: '#000', padding: '5px 15px', borderRadius: '4px', cursor: 'pointer', fontWeight: 600, display: 'flex', alignItems: 'center', gap: '5px' }}>
                                    <Save size={14} /> Save
                                </button>
                            )}
                            {!isEditing && (
                                <button onClick={() => setIsEditing(true)} style={{ background: 'rgba(255,255,255,0.1)', border: 'none', color: 'white', padding: '5px 15px', borderRadius: '4px', cursor: 'pointer', fontWeight: 600 }}>
                                    Edit
                                </button>
                            )}
                            <button onClick={() => { setSelectedPkg(null); setIsEditing(false); }} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.4)', cursor: 'pointer' }}><X size={20} /></button>
                        </div>
                    </div>

                    {isEditing ? (
                        <div style={{ display: 'flex', flexDirection: 'column', gap: '20px' }}>
                            <div style={inputGroupStyle}>
                                <label style={labelStyle}>Package Title</label>
                                <input 
                                    style={inputStyle} 
                                    value={selectedPkg.title} 
                                    onChange={(e) => setSelectedPkg({ ...selectedPkg, title: e.target.value })}
                                />
                            </div>

                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '15px' }}>
                                <div style={inputGroupStyle}>
                                    <label style={labelStyle}>Duration</label>
                                    <input 
                                        style={inputStyle} 
                                        value={selectedPkg.duration} 
                                        onChange={(e) => setSelectedPkg({ ...selectedPkg, duration: e.target.value })}
                                    />
                                </div>
                                <div style={inputGroupStyle}>
                                    <label style={labelStyle}>Difficulty</label>
                                    <select 
                                        style={inputStyle} 
                                        value={selectedPkg.difficulty} 
                                        onChange={(e) => setSelectedPkg({ ...selectedPkg, difficulty: e.target.value })}
                                    >
                                        <option value="Moderate">Moderate</option>
                                        <option value="Moderate-High">Moderate-High</option>
                                        <option value="High">High</option>
                                        <option value="Extreme">Extreme</option>
                                    </select>
                                </div>
                            </div>

                            <div style={inputGroupStyle}>
                                <label style={labelStyle}>Overview Narration</label>
                                <textarea 
                                    style={{ ...inputStyle, minHeight: '100px', resize: 'vertical' }} 
                                    value={selectedPkg.overview} 
                                    onChange={(e) => setSelectedPkg({ ...selectedPkg, overview: e.target.value })}
                                />
                            </div>

                            <div style={inputGroupStyle}>
                                <label style={labelStyle}>Inclusions</label>
                                <div style={{ display: 'flex', flexDirection: 'column', gap: '8px' }}>
                                    {(selectedPkg.inclusions || []).map((inc, i) => (
                                        <div key={i} style={{ display: 'flex', gap: '10px' }}>
                                            <input 
                                                style={{ ...inputStyle, fontSize: '0.8rem' }} 
                                                value={inc}
                                                onChange={(e) => {
                                                    const newIncs = [...selectedPkg.inclusions];
                                                    newIncs[i] = e.target.value;
                                                    setSelectedPkg({ ...selectedPkg, inclusions: newIncs });
                                                }}
                                            />
                                            <button 
                                                onClick={() => {
                                                    const newIncs = selectedPkg.inclusions.filter((_, idx) => idx !== i);
                                                    setSelectedPkg({ ...selectedPkg, inclusions: newIncs });
                                                }}
                                                style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer' }}
                                            >
                                                <Trash2 size={16} />
                                            </button>
                                        </div>
                                    ))}
                                    <button 
                                        onClick={() => setSelectedPkg({ ...selectedPkg, inclusions: [...(selectedPkg.inclusions || []), "New Inclusion item"] })}
                                        style={{ background: 'rgba(255,255,255,0.05)', border: '1px dashed rgba(255,255,255,0.2)', color: 'white', padding: '8px', borderRadius: '4px', cursor: 'pointer', fontSize: '0.75rem' }}
                                    >
                                        + Add Inclusion
                                    </button>
                                </div>
                            </div>

                            <div style={inputGroupStyle}>
                                <label style={labelStyle}>Exclusions</label>
                                <div style={{ display: 'flex', flexDirection: 'column', gap: '8px' }}>
                                    {(selectedPkg.exclusions || []).map((exc, i) => (
                                        <div key={i} style={{ display: 'flex', gap: '10px' }}>
                                            <input 
                                                style={{ ...inputStyle, fontSize: '0.8rem' }} 
                                                value={exc}
                                                onChange={(e) => {
                                                    const newExcs = [...selectedPkg.exclusions];
                                                    newExcs[i] = e.target.value;
                                                    setSelectedPkg({ ...selectedPkg, exclusions: newExcs });
                                                }}
                                            />
                                            <button 
                                                onClick={() => {
                                                    const newExcs = selectedPkg.exclusions.filter((_, idx) => idx !== i);
                                                    setSelectedPkg({ ...selectedPkg, exclusions: newExcs });
                                                }}
                                                style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer' }}
                                            >
                                                <Trash2 size={16} />
                                            </button>
                                        </div>
                                    ))}
                                    <button 
                                        onClick={() => setSelectedPkg({ ...selectedPkg, exclusions: [...(selectedPkg.exclusions || []), "New Exclusion item"] })}
                                        style={{ background: 'rgba(255,255,255,0.05)', border: '1px dashed rgba(255,255,255,0.2)', color: 'white', padding: '8px', borderRadius: '4px', cursor: 'pointer', fontSize: '0.75rem' }}
                                    >
                                        + Add Exclusion
                                    </button>
                                </div>
                            </div>

                            <div style={inputGroupStyle}>
                                <label style={labelStyle}>Itinerary Management</label>
                                <div style={{ display: 'flex', flexDirection: 'column', gap: '10px' }}>
                                    {selectedPkg.itinerary.map((day, dIdx) => (
                                        <div key={dIdx} style={{ background: 'rgba(255,255,255,0.03)', padding: '15px', borderRadius: '4px', border: '1px solid rgba(255,255,255,0.05)' }}>
                                            <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '10px' }}>
                                                <span style={{ fontSize: '0.7rem', fontWeight: 700, color: 'var(--gold)' }}>DAY {day.day}</span>
                                                <button 
                                                    onClick={() => {
                                                        const newItin = selectedPkg.itinerary.filter((_, idx) => idx !== dIdx).map((d, i) => ({ ...d, day: i + 1 }));
                                                        setSelectedPkg({ ...selectedPkg, itinerary: newItin });
                                                    }}
                                                    style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer' }}
                                                >
                                                    <Trash2 size={12} />
                                                </button>
                                            </div>
                                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '10px', marginBottom: '8px' }}>
                                                <div style={inputGroupStyle}>
                                                    <label style={{ ...labelStyle, fontSize: '0.55rem' }}>Elevation (m)</label>
                                                    <input 
                                                        style={{ ...inputStyle, padding: '8px 12px', fontSize: '0.8rem' }} 
                                                        type="number"
                                                        value={day.elevation || ''}
                                                        onChange={(e) => {
                                                            const newItin = [...selectedPkg.itinerary];
                                                            newItin[dIdx].elevation = parseInt(e.target.value);
                                                            setSelectedPkg({ ...selectedPkg, itinerary: newItin });
                                                        }}
                                                    />
                                                </div>
                                                <div style={inputGroupStyle}>
                                                    <label style={{ ...labelStyle, fontSize: '0.55rem' }}>Accommodation</label>
                                                    <input 
                                                        style={{ ...inputStyle, padding: '8px 12px', fontSize: '0.8rem' }} 
                                                        value={day.accommodation || ''}
                                                        onChange={(e) => {
                                                            const newItin = [...selectedPkg.itinerary];
                                                            newItin[dIdx].accommodation = e.target.value;
                                                            setSelectedPkg({ ...selectedPkg, itinerary: newItin });
                                                        }}
                                                    />
                                                </div>
                                            </div>
                                            <input 
                                                style={{ ...inputStyle, marginBottom: '8px', fontSize: '0.8rem', padding: '8px 12px' }} 
                                                value={day.title}
                                                placeholder="Day Title"
                                                onChange={(e) => {
                                                    const newItin = [...selectedPkg.itinerary];
                                                    newItin[dIdx].title = e.target.value;
                                                    setSelectedPkg({ ...selectedPkg, itinerary: newItin });
                                                }}
                                            />
                                            <textarea 
                                                style={{ ...inputStyle, fontSize: '0.75rem', minHeight: '60px', padding: '8px 12px' }} 
                                                value={day.desc}
                                                placeholder="Day Description"
                                                onChange={(e) => {
                                                    const newItin = [...selectedPkg.itinerary];
                                                    newItin[dIdx].desc = e.target.value;
                                                    setSelectedPkg({ ...selectedPkg, itinerary: newItin });
                                                }}
                                            />
                                        </div>
                                    ))}
                                    <button 
                                        onClick={() => {
                                            const newDay = { day: selectedPkg.itinerary.length + 1, title: "New Expedition Day", desc: "", elevation: 0, accommodation: "", meals: "B, L, D" };
                                            setSelectedPkg({ ...selectedPkg, itinerary: [...selectedPkg.itinerary, newDay] });
                                        }}
                                        style={{ background: 'rgba(201,168,76,0.1)', border: '1px dashed var(--gold)', color: 'var(--gold)', padding: '10px', borderRadius: '4px', cursor: 'pointer', fontSize: '0.8rem' }}
                                    >
                                        + Add Itinerary Day
                                    </button>
                                </div>
                            </div>
                        </div>
                    ) : (
                        <div>
                            <img src={selectedPkg.heroImg} style={{ width: '100%', height: '180px', objectFit: 'cover', borderRadius: '4px', marginBottom: '25px' }} />
                            <h3 style={{ fontSize: '1.4rem', color: 'white', marginBottom: '10px', fontFamily: 'Playfair Display' }}>{selectedPkg.title}</h3>
                            
                            <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '15px', marginBottom: '30px' }}>
                                <div style={statBoxStyle}>
                                    <Clock size={14} color="var(--gold)" />
                                    <span>{selectedPkg.duration}</span>
                                </div>
                                <div style={statBoxStyle}>
                                    <Activity size={14} color="var(--gold)" />
                                    <span>{selectedPkg.difficulty}</span>
                                </div>
                                <div style={statBoxStyle}>
                                    <TrendingUp size={14} color="var(--gold)" />
                                    <span>{selectedPkg.successRate} Success</span>
                                </div>
                                <div style={statBoxStyle}>
                                    <Camera size={14} color="var(--gold)" />
                                    <span>{selectedPkg.itinerary.length} Days</span>
                                </div>
                            </div>

                            <div style={{ marginBottom: '30px' }}>
                                <label style={labelStyle}>Overview</label>
                                <p style={{ fontSize: '0.9rem', color: 'rgba(255,255,255,0.7)', lineHeight: 1.6 }}>{selectedPkg.overview}</p>
                            </div>

                            <div style={{ marginBottom: '30px' }}>
                                <label style={labelStyle}>Inclusions ({selectedPkg.inclusions?.length || 0})</label>
                                <ul style={{ padding: 0, margin: 0, listStyle: 'none' }}>
                                    {selectedPkg.inclusions?.slice(0, 5).map((inc, i) => (
                                        <li key={i} style={{ fontSize: '0.8rem', color: 'rgba(255,255,255,0.5)', marginBottom: '5px', paddingLeft: '15px', position: 'relative' }}>
                                            <span style={{ position: 'absolute', left: 0, color: 'var(--gold)' }}>•</span> {inc}
                                        </li>
                                    ))}
                                </ul>
                            </div>
                        </div>
                    )}
                </div>
            )}
        </div>
    );
};

const iconBtnStyle = {
    background: 'none',
    border: 'none',
    color: 'var(--gold)',
    cursor: 'pointer',
    opacity: 0.7,
    padding: '5px',
    display: 'flex',
    alignItems: 'center',
    justifyContent: 'center',
    transition: 'opacity 0.2s'
};

const inputGroupStyle = {
    display: 'flex',
    flexDirection: 'column',
    gap: '8px'
};

const labelStyle = {
    fontSize: '0.65rem',
    color: 'rgba(255,255,255,0.3)',
    textTransform: 'uppercase',
    letterSpacing: '0.15em',
    fontWeight: 700
};

const inputStyle = {
    background: '#000',
    border: '1px solid rgba(255,255,255,0.1)',
    color: 'white',
    padding: '12px 15px',
    borderRadius: '4px',
    fontSize: '0.9rem',
    outline: 'none',
    width: '100%'
};

const statBoxStyle = {
    background: 'rgba(255,255,255,0.03)',
    padding: '15px',
    borderRadius: '4px',
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
    gap: '8px',
    fontSize: '0.8rem',
    color: 'white',
    textAlign: 'center'
};
