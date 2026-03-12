import React from 'react';
import { Eye, Edit, Trash2, Plus } from 'lucide-react';
import { packagesData } from '../../data/packagesData';

export const AdminTrekking = () => {
    // Group packages by route
    const routeGroups = packagesData.reduce((acc, pkg) => {
        const route = pkg.routeId;
        if (!acc[route]) acc[route] = [];
        acc[route].push(pkg);
        return acc;
    }, {});

    return (
        <div>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '30px' }}>
                <h2 style={{ fontSize: '1.5rem', color: 'white' }}>Trekking Packages ({packagesData.length})</h2>
                <button className="btn-admin-primary" style={{ width: 'auto', padding: '12px 25px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                    <Plus size={16} /> Add Package
                </button>
            </div>

            {Object.entries(routeGroups).map(([routeName, packages]) => (
                <div key={routeName} style={{ marginBottom: '40px' }}>
                    <h3 style={{ fontSize: '0.8rem', textTransform: 'uppercase', letterSpacing: '0.15em', color: 'var(--gold)', marginBottom: '15px', paddingBottom: '10px', borderBottom: '1px solid rgba(255,255,255,0.05)' }}>
                        {routeName.replace(/-/g, ' ')} Route — {packages.length} packages
                    </h3>
                    <div className="admin-panel">
                        <table className="admin-table">
                            <thead>
                                <tr>
                                    <th>Package</th>
                                    <th>Duration</th>
                                    <th>Difficulty</th>
                                    <th>Success Rate</th>
                                    <th>Itinerary Days</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {packages.map((pkg, idx) => (
                                    <tr key={idx}>
                                        <td style={{ fontWeight: 600 }}>{pkg.title}</td>
                                        <td>{pkg.duration}</td>
                                        <td>
                                            <span className={`status-pill ${
                                                pkg.difficulty === 'Extreme' ? 'status-new' :
                                                pkg.difficulty === 'High' ? 'status-confirmed' : 'status-completed'
                                            }`}>
                                                {pkg.difficulty}
                                            </span>
                                        </td>
                                        <td style={{ color: 'var(--gold)' }}>{pkg.successRate}</td>
                                        <td>{pkg.itinerary.length} days</td>
                                        <td>
                                            <div style={{ display: 'flex', gap: '10px' }}>
                                                <button style={{ background: 'none', border: 'none', color: 'var(--gold)', cursor: 'pointer' }}><Eye size={16} /></button>
                                                <button style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.5)', cursor: 'pointer' }}><Edit size={16} /></button>
                                                <button style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer' }}><Trash2 size={16} /></button>
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
    );
};
