import React, { useState, useEffect } from 'react';
import { motion } from 'framer-motion';
import { 
    Users, Calendar, MessageSquare, TrendingUp, 
    Shield, Activity, Zap, Compass, MapPin, 
    ArrowUpRight, Target, Clock, AlertTriangle, Layers,
    DollarSign, Briefcase, Eye, Search, Maximize2, ChevronRight
} from 'lucide-react';
import { useNavigate } from 'react-router-dom';
import { adminService, destinationService, safariService, trekkingService } from '../../services/api';
import '../../styles/admin-premium.css';

export const AdminDashboard = () => {
    const navigate = useNavigate();
    const [stats, setStats] = useState({
        bookings: 0,
        inquiries: 0,
        safaris: 0,
        revenue: 0,
        destinations: 0,
        trekking: 0
    });
    const [recentBookings, setRecentBookings] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        fetchDashboardData();
    }, []);

    const fetchDashboardData = async () => {
        try {
            setLoading(true);
            const [statsRes, bookingsRes, destinationsRes, safarisRes, trekkingRes, inquiriesRes] = await Promise.all([
                adminService.getStats(),
                adminService.getBookings(),
                destinationService.getAll(),
                safariService.getAll(),
                trekkingService.getAll(),
                adminService.getInquiries()
            ]);
            
            const bookings = Array.isArray(bookingsRes.data?.data) ? bookingsRes.data.data : (Array.isArray(bookingsRes.data) ? bookingsRes.data : []);

            // Derive revenue (assuming price_cents)
            const revenue = bookings.reduce((acc, b) => acc + (b.total_price_cents || 0), 0) / 100;
            
            setStats({
                bookings: bookings.length,
                inquiries: inquiriesRes.data.length,
                safaris: safarisRes.data.length,
                revenue: revenue,
                destinations: destinationsRes.data.length,
                trekking: trekkingRes.data.length
            });
            setRecentBookings(bookings.slice(0, 5));
        } catch (error) {
            console.error("Dashboard Intelligence Sync Failure:", error);
        } finally {
            setLoading(false);
        }
    };

    const metrics = [
        { label: 'Bookings', value: stats.bookings, icon: Target, trend: '+12%', color: 'var(--gold)' },
        { label: 'Inquiries', value: stats.inquiries, icon: MessageSquare, trend: '+5%', color: 'var(--success)' },
        { label: 'Packages & Routes', value: stats.safaris + stats.trekking, icon: Shield, trend: '—', color: 'var(--warning)' },
        { label: 'Revenue', value: `$${stats.revenue.toLocaleString()}`, icon: DollarSign, trend: '+22%', color: 'white' }
    ];

    return (
        <div className="admin-page-root">
            {/* ─── TACTICAL HEADER ─── */}
            <header style={{ marginBottom: '60px', display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                <div>
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.25em', textTransform: 'uppercase', marginBottom: '12px' }}>Overview</h2>
                    <h1 className="admin-page-title" style={{ fontSize: '3.5rem', fontWeight: 300, color: 'white' }}>Dashboard</h1>
                </div>
                
                <div style={{ display: 'flex', gap: '20px', alignItems: 'center' }}>
                    <div style={{ textAlign: 'right', display: 'flex', flexDirection: 'column', gap: '4px' }}>
                        <span style={{ fontSize: '0.55rem', color: 'var(--gold-dim)', fontFamily: 'var(--font-mono)' }}>STATUS: OK</span>
                        <span style={{ fontSize: '0.55rem', color: 'rgba(255,255,255,0.2)', fontFamily: 'var(--font-mono)' }}>UPDATED: {new Date().toLocaleTimeString()}</span>
                    </div>
                </div>
            </header>

            {/* ─── CORE METRICS ─── */}
            <div className="admin-grid-top">
                {metrics.map((m, i) => (
                    <motion.div 
                        key={i}
                        initial={{ opacity: 0, y: 20 }}
                        animate={{ opacity: 1, y: 0 }}
                        transition={{ delay: i * 0.1 }}
                        className="admin-metric-card"
                    >
                        <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '25px' }}>
                            <div style={{ padding: '12px', background: 'rgba(255,255,255,0.02)', border: '1px solid var(--border)', borderRadius: '2px' }}>
                                <m.icon size={20} color={m.color} />
                            </div>
                            <span style={{ fontSize: '0.65rem', color: 'var(--success)', fontFamily: 'var(--font-mono)', display: 'flex', alignItems: 'center', gap: '4px' }}>
                                <ArrowUpRight size={12} /> {m.trend}
                            </span>
                        </div>
                        <div style={{ color: 'white', fontSize: '2.5rem', fontWeight: 300, marginBottom: '5px' }}>{m.value}</div>
                        <div style={{ fontSize: '0.7rem', color: 'var(--text-dim)', textTransform: 'uppercase', letterSpacing: '0.1em', fontFamily: 'var(--font-mono)' }}>{m.label}</div>
                        
                        <div style={{ position: 'absolute', bottom: 0, right: 0, opacity: 0.05, transform: 'rotate(-20deg) translate(20px, 20px)' }}>
                            <m.icon size={120} color="white" />
                        </div>
                    </motion.div>
                ))}
            </div>

            {/* ─── STRATEGIC DIVISIONS ─── */}
            <div style={{ display: 'grid', gridTemplateColumns: '1.6fr 1fr', gap: '40px' }}>
                
                {/* RECENT MISSION LEDGER */}
                <div className="admin-panel shadow-premium" style={{ padding: '50px' }}>
                    <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: '40px', paddingBottom: '20px', borderBottom: '1px solid var(--border)' }}>
                        <div>
                            <h4 style={SectionHeadStyle}><Target size={14} /> Recent bookings</h4>
                            <h3 style={{ fontSize: '1.4rem', color: 'white', fontWeight: 300, marginTop: '5px' }}>Latest enquiries & reservations</h3>
                        </div>
                        <button
                            className="admin-btn-mini"
                            style={{ padding: '8px 15px', background: 'rgba(255,255,255,0.02)', border: '1px solid var(--border)', fontSize: '0.6rem', fontFamily: 'var(--font-mono)', color: 'var(--text-dim)' }}
                            onClick={() => navigate('/ops-7f3d/bookings')}
                        >
                            View all
                        </button>
                    </div>

                    <table className="admin-table">
                        <thead>
                            <tr>
                                <th>Explorer</th>
                                <th>Deployment Asset</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {recentBookings.map((b, i) => (
                                <tr
                                    key={i}
                                    style={{ cursor: 'pointer' }}
                                    onClick={() => navigate('/ops-7f3d/bookings', { state: { openBookingId: b.id } })}
                                >
                                    <td>
                                        <div style={{ fontWeight: 600 }}>{b.customer_name}</div>
                                        <div style={{ fontSize: '0.7rem', color: 'var(--text-dim)', fontFamily: 'var(--font-mono)' }}>{b.email}</div>
                                    </td>
                                    <td style={{ fontSize: '0.8rem' }}>{b.safari_package?.name || b.departure?.trekking_route?.name || 'CUSTOM'}</td>
                                    <td>
                                        <span className={`status-pill status-${(b.status || '').toLowerCase()}`}>
                                            {(b.status || '').toUpperCase()}
                                        </span>
                                    </td>
                                    <td>
                                        <button
                                            style={{ background: 'none', border: 'none', color: 'var(--gold)', cursor: 'pointer' }}
                                            onClick={(e) => {
                                                e.preventDefault();
                                                e.stopPropagation();
                                                navigate('/ops-7f3d/bookings', { state: { openBookingId: b.id } });
                                            }}
                                            aria-label="Open booking"
                                        >
                                            <ChevronRight size={18} />
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                {/* QUICK INSIGHTS */}
                <div style={{ display: 'flex', flexDirection: 'column', gap: '40px' }}>
                    <div className="admin-panel shadow-premium" style={{ padding: '40px' }}>
                        <h4 style={SectionHeadStyle}><Zap size={14} /> Content overview</h4>
                        <div style={{ display: 'flex', flexDirection: 'column', gap: '20px', marginTop: '30px' }}>
                            <DistributionBar label="Safari packages" value={stats.safaris} total={stats.safaris + stats.trekking} color="var(--gold)" />
                            <DistributionBar label="Trekking routes" value={stats.trekking} total={stats.safaris + stats.trekking} color="white" />
                            <DistributionBar label="Destinations" value={stats.destinations} total={Math.max(stats.destinations, 1)} color="var(--success)" />
                        </div>
                    </div>

                    <div className="admin-panel shadow-premium" style={{ padding: '40px', background: 'var(--obsidian)', border: '1px solid var(--gold-dim)' }}>
                        <h4 style={SectionHeadStyle}><Shield size={14} /> Admin access</h4>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '25px', marginTop: '20px' }}>
                            <div className="animate-pulse-gold" style={{ width: '60px', height: '60px', borderRadius: '50%', background: 'rgba(201,168,76,0.1)', border: '1px solid var(--gold)', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                                <Shield size={24} color="var(--gold)" />
                            </div>
                            <div>
                                <div style={{ color: 'white', fontWeight: 600, fontSize: '0.9rem' }}>Access is enabled.</div>
                                <div style={{ color: 'var(--text-dim)', fontSize: '0.75rem', marginTop: '4px' }}>Admin and Manager roles are supported.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

const DistributionBar = ({ label, value, total, color }) => (
    <div>
        <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '10px', fontSize: '0.75rem' }}>
            <span style={{ color: 'var(--text-dim)' }}>{label}</span>
            <span style={{ color: 'white', fontFamily: 'var(--font-mono)' }}>{value}</span>
        </div>
        <div style={{ height: '4px', background: 'rgba(255,255,255,0.05)', borderRadius: '10px', overflow: 'hidden' }}>
            <motion.div 
                initial={{ width: 0 }}
                animate={{ width: `${(value / total) * 100}%` }}
                transition={{ duration: 1.5, ease: "easeOut" }}
                style={{ height: '100%', background: color }}
            />
        </div>
    </div>
);
