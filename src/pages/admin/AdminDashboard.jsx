import React from 'react';
import { TrendingUp, TrendingDown, Users, BookOpen, Tent, FileText } from 'lucide-react';
import { safarisData } from '../../data/safarisData';
import { blogsData } from '../../data/blogsData';
import { destinationsData } from '../../data/destinationsData';
import { packagesData } from '../../data/packagesData';

const recentActivity = [
    { id: 1, client: 'James Mitchell', type: 'Safari Inquiry', expedition: 'Great Migration Edition', status: 'New', date: 'Mar 12, 2026' },
    { id: 2, client: 'Sarah Chen', type: 'Booking Confirmed', expedition: '8-Day Lemosho Route', status: 'Confirmed', date: 'Mar 11, 2026' },
    { id: 3, client: 'David Okafor', type: 'Safari Inquiry', expedition: "The Pioneer's Route", status: 'New', date: 'Mar 10, 2026' },
    { id: 4, client: 'Emily Watson', type: 'Trek Completed', expedition: '7-Day Machame Route', status: 'Completed', date: 'Mar 09, 2026' },
    { id: 5, client: 'Michael Brown', type: 'Booking Confirmed', expedition: 'The Grand Canvas', status: 'Confirmed', date: 'Mar 08, 2026' },
];

export const AdminDashboard = () => {
    return (
        <div>
            {/* KPI METRICS */}
            <div className="admin-grid-top">
                <div className="admin-metric-card">
                    <BookOpen size={28} className="metric-icon" />
                    <div className="metric-label">Active Bookings</div>
                    <div className="metric-value">24</div>
                    <div className="metric-trend trend-up">
                        <TrendingUp size={14} /> +12% this month
                    </div>
                </div>

                <div className="admin-metric-card">
                    <Tent size={28} className="metric-icon" />
                    <div className="metric-label">Total Expeditions</div>
                    <div className="metric-value">{safarisData.length + packagesData.length}</div>
                    <div className="metric-trend trend-up">
                        <TrendingUp size={14} /> {safarisData.length} safaris, {packagesData.length} treks
                    </div>
                </div>

                <div className="admin-metric-card">
                    <Users size={28} className="metric-icon" />
                    <div className="metric-label">Destinations</div>
                    <div className="metric-value">{destinationsData.length}</div>
                    <div className="metric-trend" style={{ color: 'rgba(255,255,255,0.4)' }}>
                        Active safari zones
                    </div>
                </div>

                <div className="admin-metric-card">
                    <FileText size={28} className="metric-icon" />
                    <div className="metric-label">Published Articles</div>
                    <div className="metric-value">{blogsData.length}</div>
                    <div className="metric-trend trend-up">
                        <TrendingUp size={14} /> Content active
                    </div>
                </div>
            </div>

            {/* RECENT ACTIVITY */}
            <div className="admin-panel">
                <div className="panel-header">
                    <h2 className="panel-title">Recent Activity</h2>
                </div>
                <table className="admin-table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Type</th>
                            <th>Expedition</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        {recentActivity.map((item) => (
                            <tr key={item.id}>
                                <td style={{ fontWeight: 600 }}>{item.client}</td>
                                <td>{item.type}</td>
                                <td>{item.expedition}</td>
                                <td>
                                    <span className={`status-pill status-${item.status.toLowerCase()}`}>
                                        {item.status}
                                    </span>
                                </td>
                                <td style={{ color: 'rgba(255,255,255,0.5)' }}>{item.date}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </div>
    );
};
