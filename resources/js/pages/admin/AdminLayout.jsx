import React, { useEffect, useMemo, useState } from 'react';
import { useNavigate, Outlet, Link, useLocation } from 'react-router-dom';
import { motion, AnimatePresence } from 'framer-motion';
import { useAuth } from '../../context/AuthContext';
import '../../styles/admin-premium.css';
import { adminService } from '../../services/api';
import { 
    LayoutDashboard, 
    MapPin,
    Tent, 
    Mountain,
    FileText,
    Calendar,
    MessageSquare,
    Backpack,
    LogOut, 
    Bell, 
    Search,
    CheckCircle,
    Image as ImageIcon,
    BookOpen,
    DollarSign,
    Shield,
    Users,
    Settings,
    ChevronRight,
    Compass,
    Cpu
} from 'lucide-react';

export const AdminLayout = () => {
    const location = useLocation();
    const navigate = useNavigate();
    const { user, logout } = useAuth();
    const [notifOpen, setNotifOpen] = useState(false);
    const [notifLoading, setNotifLoading] = useState(false);
    const [notifications, setNotifications] = useState([]);

    const unreadCount = useMemo(() => notifications.filter((n) => !n.read_at).length, [notifications]);

    const loadNotifications = async () => {
        try {
            setNotifLoading(true);
            const res = await adminService.getNotifications({ per_page: 10 });
            const rows = Array.isArray(res.data?.data) ? res.data.data : (Array.isArray(res.data) ? res.data : []);
            setNotifications(rows);
        } catch (e) {
            // keep silent; bell can degrade gracefully
        } finally {
            setNotifLoading(false);
        }
    };

    const handleLogout = async (e) => {
        e.preventDefault();
        try {
            await logout();
            navigate('/ops-7f3d/login');
        } catch (error) {
            console.error("Logout failed", error);
        }
    };

    const navItems = [
        { path: '/ops-7f3d', label: 'Dashboard', icon: LayoutDashboard, slug: 'HOME' },
        { path: '/ops-7f3d/destinations', label: 'Destinations', icon: MapPin, slug: 'DEST' },
        { path: '/ops-7f3d/safaris', label: 'Safari Packages', icon: Tent, slug: 'SAFA' },
        { path: '/ops-7f3d/trekking', label: 'Trekking Routes', icon: Mountain, slug: 'TREK' },
        { path: '/ops-7f3d/pricing', label: 'Pricing Rules', icon: DollarSign, slug: 'PRICE' },
        { path: '/ops-7f3d/blog', label: 'Blog Posts', icon: FileText, slug: 'BLOG' },
        { path: '/ops-7f3d/departures', label: 'Departures', icon: Calendar, slug: 'DATE' },
        { path: '/ops-7f3d/bookings', label: 'Bookings', icon: CheckCircle, slug: 'BOOK' },
        { path: '/ops-7f3d/gear-requests', label: 'Gear Requests', icon: Backpack, slug: 'GEAR' },
        { path: '/ops-7f3d/inquiries', label: 'Inquiries', icon: MessageSquare, slug: 'LEAD' },
        { path: '/ops-7f3d/pages', label: 'Pages', icon: BookOpen, slug: 'PAGES' },
        { path: '/ops-7f3d/visuals', label: 'Media Library', icon: ImageIcon, slug: 'MEDIA' },
    ];

    const isActivePath = (path) => {
        if (path === '/ops-7f3d') return location.pathname === '/ops-7f3d';
        return location.pathname === path || location.pathname.startsWith(path + '/');
    };

    useEffect(() => {
        // Initial load + periodic refresh
        loadNotifications();
        const t = setInterval(() => loadNotifications(), 30000);
        return () => clearInterval(t);
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, []);

    useEffect(() => {
        const onKey = (e) => {
            if (e.key === 'Escape') setNotifOpen(false);
        };
        window.addEventListener('keydown', onKey);
        return () => window.removeEventListener('keydown', onKey);
    }, []);

    const openNotification = async (n) => {
        try {
            if (n?.id && !n.read_at) {
                await adminService.markNotificationRead(n.id);
                setNotifications((prev) => prev.map((x) => (x.id === n.id ? { ...x, read_at: new Date().toISOString() } : x)));
            }
        } catch (e) {}
        setNotifOpen(false);
        if (n?.url) navigate(n.url);
    };

    const markAllRead = async () => {
        try {
            await adminService.markAllNotificationsRead();
            const nowIso = new Date().toISOString();
            setNotifications((prev) => prev.map((n) => ({ ...n, read_at: n.read_at || nowIso })));
        } catch (e) {}
    };

    return (
        <div className="admin-root">
            
            {/* ─── EXPEDITION COMMAND SIDEBAR ─── */}
            <aside className="admin-sidebar">
                <div className="admin-brand">
                    <div style={{ display: 'flex', alignItems: 'center', gap: '15px' }}>
                        <div style={{ padding: '8px', background: 'rgba(201,168,76,0.1)', borderRadius: '4px', border: '1px solid var(--gold-dim)' }}>
                            <Compass className="animate-spin-slow" size={24} color="var(--gold)" />
                        </div>
                        <div style={{ fontFamily: 'var(--font-heading)', fontSize: '1.4rem', fontWeight: 600, letterSpacing: '0.02em', color: 'white' }}>
                            Tanzania <span style={{ color: 'var(--gold)' }}>Admin</span>
                        </div>
                    </div>
                </div>

                <nav className="custom-scrollbar" style={{ flex: 1, padding: '30px 0', overflowY: 'auto' }}>
                    <div style={{ fontSize: '0.6rem', color: 'var(--gold-dim)', fontFamily: 'var(--font-mono)', letterSpacing: '0.2em', textTransform: 'uppercase', marginBottom: '25px', paddingLeft: '25px' }}>Content</div>
                    {navItems.map((item) => (
                        <Link 
                            key={item.path} 
                            to={item.path} 
                            className={`admin-nav-item ${isActivePath(item.path) ? 'active' : ''}`}
                        >
                            <item.icon size={18} />
                            <span style={{ flex: 1 }}>{item.label}</span>
                            <span style={{ fontSize: '0.55rem', opacity: 0.3, fontFamily: 'var(--font-mono)' }}>{item.slug}</span>
                        </Link>
                    ))}

                    <div style={{ marginTop: '50px', fontSize: '0.6rem', color: 'var(--gold-dim)', fontFamily: 'var(--font-mono)', letterSpacing: '0.2em', textTransform: 'uppercase', marginBottom: '25px', paddingLeft: '25px' }}>Administration</div>
                    <Link to="/ops-7f3d/settings" className={`admin-nav-item ${isActivePath('/ops-7f3d/settings') ? 'active' : ''}`}>
                        <Settings size={18} /> <span>Site Settings</span>
                    </Link>
                    <Link to="/ops-7f3d/users" className={`admin-nav-item ${isActivePath('/ops-7f3d/users') ? 'active' : ''}`}>
                        <Users size={18} /> <span>Users</span>
                    </Link>
                </nav>

                <div style={{ padding: '25px', borderTop: '1px solid var(--border)', background: 'rgba(255,255,255,0.01)', display: 'flex', alignItems: 'center', gap: '15px' }}>
                    <div style={{ width: '40px', height: '40px', background: 'var(--gold)', borderRadius: '2px', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'black', fontWeight: 700 }}>
                        {user?.name ? user.name.charAt(0) : 'A'}
                    </div>
                    <div style={{ flex: 1 }}>
                        <div style={{ fontSize: '0.85rem', color: 'white', fontWeight: 600 }}>{user?.name || 'Admin'}</div>
                        <div style={{ fontSize: '0.6rem', color: 'var(--gold)', textTransform: 'uppercase', letterSpacing: '0.1em' }}>Signed in</div>
                    </div>
                    <button onClick={handleLogout} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.2)', cursor: 'pointer' }} onMouseOver={e => e.currentTarget.style.color = '#ff4444'} onMouseOut={e => e.currentTarget.style.color = 'rgba(255,255,255,0.2)'}>
                        <LogOut size={18} />
                    </button>
                </div>
            </aside>

            {/* ─── MAIN CONTENT AREA ─── */}
            <main className="admin-main">
                <header className="admin-header">
                    <div style={{ display: 'flex', alignItems: 'center', gap: '15px' }}>
                        <div style={{ width: '8px', height: '8px', background: 'var(--success)', borderRadius: '50%', boxShadow: `0 0 10px var(--success)` }}></div>
                        <span style={{ fontSize: '0.65rem', color: 'var(--text-dim)', fontFamily: 'var(--font-mono)', letterSpacing: '0.1em' }}>Online • {new Date().toLocaleTimeString()}</span>
                    </div>
                    
                    <div style={{ display: 'flex', alignItems: 'center', gap: '30px' }}>
                        <div style={{ position: 'relative' }}>
                            <Search size={16} style={{ position: 'absolute', left: '15px', top: '50%', transform: 'translateY(-50%)', color: 'var(--text-dim)' }} />
                            <input 
                                type="text" 
                                placeholder="Search…" 
                                style={{ 
                                    background: 'rgba(255,255,255,0.02)', 
                                    border: '1px solid var(--border)', 
                                    padding: '10px 15px 10px 45px', 
                                    color: 'white', 
                                    fontSize: '0.75rem', 
                                    fontFamily: 'var(--font-mono)', 
                                    borderRadius: '2px',
                                    outline: 'none',
                                    width: '320px',
                                    transition: 'all 0.3s'
                                }}
                                onFocus={e => { e.target.style.borderColor = 'var(--gold)'; e.target.style.background = 'rgba(255,255,255,0.05)'; }}
                                onBlur={e => { e.target.style.borderColor = 'var(--border)'; e.target.style.background = 'rgba(255,255,255,0.02)'; }}
                            />
                        </div>
                        <div style={{ position: 'relative' }}>
                        <button
                            style={{ background: 'none', border: 'none', color: 'var(--text-dim)', position: 'relative', cursor: 'pointer' }}
                            onClick={() => { setNotifOpen((s) => !s); if (!notifOpen) loadNotifications(); }}
                            aria-label="Notifications"
                        >
                            <Bell size={20} />
                            {unreadCount > 0 ? (
                                <span style={{ position: 'absolute', top: -2, right: -2, minWidth: 16, height: 16, padding: '0 5px', background: 'var(--gold)', borderRadius: 999, color: '#111', fontSize: 10, display: 'grid', placeItems: 'center', fontFamily: 'var(--font-mono)', fontWeight: 700 }}>
                                    {unreadCount > 99 ? '99+' : unreadCount}
                                </span>
                            ) : null}
                        </button>
                        <AnimatePresence>
                            {notifOpen && (
                                <motion.div
                                    initial={{ opacity: 0, y: -8, scale: 0.98 }}
                                    animate={{ opacity: 1, y: 0, scale: 1 }}
                                    exit={{ opacity: 0, y: -8, scale: 0.98 }}
                                    transition={{ duration: 0.18 }}
                                    style={{
                                        position: 'absolute',
                                        right: 0,
                                        top: 'calc(100% + 12px)',
                                        width: 420,
                                        maxWidth: '80vw',
                                        background: 'var(--charcoal)',
                                        border: '1px solid var(--border)',
                                        boxShadow: '0 20px 60px rgba(0,0,0,0.45)',
                                        zIndex: 5000,
                                        overflow: 'hidden',
                                    }}
                                >
                                    <div style={{ padding: 14, display: 'flex', alignItems: 'center', justifyContent: 'space-between', borderBottom: '1px solid var(--border)' }}>
                                        <div style={{ fontFamily: 'var(--font-mono)', fontSize: '0.65rem', letterSpacing: '0.18em', textTransform: 'uppercase', color: 'var(--gold)' }}>
                                            Notifications
                                        </div>
                                        <button
                                            className="admin-btn-mini"
                                            style={{ padding: '8px 10px' }}
                                            disabled={notifLoading || unreadCount === 0}
                                            onClick={markAllRead}
                                        >
                                            Mark all read
                                        </button>
                                    </div>

                                    <div className="custom-scrollbar" style={{ maxHeight: 420, overflowY: 'auto' }}>
                                        {notifLoading ? (
                                            <div style={{ padding: 16, color: 'var(--text-dim)', fontFamily: 'var(--font-mono)', fontSize: '0.7rem' }}>Loading…</div>
                                        ) : notifications.length === 0 ? (
                                            <div style={{ padding: 16, color: 'var(--text-dim)' }}>No notifications.</div>
                                        ) : (
                                            notifications.slice(0, 10).map((n) => (
                                                <button
                                                    key={n.id}
                                                    onClick={() => openNotification(n)}
                                                    style={{
                                                        width: '100%',
                                                        textAlign: 'left',
                                                        padding: 14,
                                                        background: n.read_at ? 'transparent' : 'rgba(201,168,76,0.06)',
                                                        border: 'none',
                                                        borderBottom: '1px solid rgba(255,255,255,0.06)',
                                                        color: 'white',
                                                        cursor: 'pointer',
                                                    }}
                                                >
                                                    <div style={{ display: 'flex', justifyContent: 'space-between', gap: 10, alignItems: 'baseline' }}>
                                                        <div style={{ fontSize: '0.9rem', fontWeight: 600 }}>{n.title}</div>
                                                        <div style={{ fontSize: 11, color: 'rgba(255,255,255,0.35)', fontFamily: 'var(--font-mono)' }}>
                                                            {n.created_at ? new Date(n.created_at).toLocaleString() : ''}
                                                        </div>
                                                    </div>
                                                    {n.body ? (
                                                        <div style={{ marginTop: 6, color: 'rgba(255,255,255,0.65)', fontSize: '0.85rem', lineHeight: 1.4 }}>
                                                            {n.body}
                                                        </div>
                                                    ) : null}
                                                </button>
                                            ))
                                        )}
                                    </div>
                                </motion.div>
                            )}
                        </AnimatePresence>
                        </div>
                        <button className="admin-btn-mini" style={{ padding: '8px', background: 'rgba(255,255,255,0.02)', border: '1px solid var(--border)', borderRadius: '2px', color: 'var(--gold)' }}>
                            <Cpu size={16} />
                        </button>
                    </div>
                </header>

                <div className="admin-content-scroll custom-scrollbar" style={{ flex: 1, padding: '60px 80px', overflowY: 'auto' }}>
                    <Outlet />
                </div>
            </main>
        </div>
    );
};
