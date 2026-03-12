import React, { useState } from 'react';
import { Save, Image as ImageIcon, Link as LinkIcon, RefreshCw, ChevronDown, ChevronUp } from 'lucide-react';
import { visualsData as initialData } from '../../data/visualsData';

export const AdminVisuals = () => {
    const [visuals, setVisuals] = useState(initialData);
    const [expandedSection, setExpandedSection] = useState('home');

    const toggleSection = (section) => {
        setExpandedSection(expandedSection === section ? null : section);
    };

    const handleUpdate = (section, key, value) => {
        setVisuals({
            ...visuals,
            [section]: {
                ...visuals[section],
                [key]: value
            }
        });
    };

    return (
        <div>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '30px' }}>
                <div>
                    <h2 style={{ fontSize: '1.5rem', color: 'white', marginBottom: '5px' }}>Visual Asset Manager</h2>
                    <p style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.4)' }}>Control all site-wide backgrounds, heroes, and branding visuals.</p>
                </div>
                <button className="btn-admin-primary" style={{ width: 'auto', padding: '12px 25px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                    <Save size={16} /> Save All Changes
                </button>
            </div>

            {Object.entries(visuals).map(([section, assets]) => (
                <div key={section} className="admin-panel" style={{ marginBottom: '20px' }}>
                    <div 
                        onClick={() => toggleSection(section)}
                        style={{ 
                            padding: '20px 30px', 
                            display: 'flex', 
                            justifyContent: 'space-between', 
                            alignItems: 'center', 
                            cursor: 'pointer',
                            borderBottom: expandedSection === section ? '1px solid rgba(255,255,255,0.05)' : 'none'
                        }}
                    >
                        <div style={{ display: 'flex', alignItems: 'center', gap: '15px' }}>
                            <div style={{ width: 32, height: 32, background: 'rgba(201,168,76,0.1)', borderRadius: 4, display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'var(--gold)' }}>
                                <ImageIcon size={16} />
                            </div>
                            <span style={{ fontWeight: 600, color: 'white', textTransform: 'uppercase', letterSpacing: '0.1em', fontSize: '0.8rem' }}>
                                {section} Page Assets
                            </span>
                        </div>
                        {expandedSection === section ? <ChevronUp size={18} color="rgba(255,255,255,0.3)" /> : <ChevronDown size={18} color="rgba(255,255,255,0.3)" />}
                    </div>

                    {expandedSection === section && (
                        <div style={{ padding: '30px', display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(300px, 1fr))', gap: '30px' }}>
                            {Object.entries(assets).map(([key, url]) => (
                                <div key={key} style={{ background: 'rgba(0,0,0,0.2)', padding: '20px', borderRadius: '4px', border: '1px solid rgba(255,255,255,0.03)' }}>
                                    <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '15px' }}>
                                        <label style={{ fontSize: '0.65rem', color: 'var(--gold)', textTransform: 'uppercase', letterSpacing: '0.1em', fontWeight: 700 }}>
                                            {key.replace(/([A-Z])/g, ' $1')}
                                        </label>
                                        <button 
                                            onClick={() => window.open(url, '_blank')}
                                            style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.3)', cursor: 'pointer' }}
                                        >
                                            <LinkIcon size={14} />
                                        </button>
                                    </div>

                                    <div style={{ width: '100%', height: '120px', borderRadius: '4px', overflow: 'hidden', marginBottom: '15px', border: '1px solid rgba(255,255,255,0.05)' }}>
                                        <img src={url} alt={key} style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                                    </div>

                                    <div style={{ position: 'relative' }}>
                                        <input 
                                            type="text" 
                                            value={url}
                                            onChange={(e) => handleUpdate(section, key, e.target.value)}
                                            style={{ 
                                                width: '100%', 
                                                background: '#000', 
                                                border: '1px solid rgba(255,255,255,0.1)', 
                                                color: 'rgba(255,255,255,0.6)', 
                                                padding: '10px 12px', 
                                                fontSize: '0.75rem',
                                                fontFamily: 'monospace'
                                            }}
                                        />
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            ))}
        </div>
    );
};
