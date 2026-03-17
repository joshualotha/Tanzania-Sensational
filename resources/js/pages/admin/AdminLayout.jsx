import React from 'react';
import { useNavigate, Outlet, Link, useLocation } from 'react-router-dom';
import { motion, AnimatePresence } from 'framer-motion';
import { useAuth } from '../../context/AuthContext';
import '../../styles/admin-premium.css';
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

    const handleLogout = async (e) => {
        e.preventDefault();
        try {
            await logout();
            navigate('/admin/login');
        } catch (error) {
            console.error("Logout failed", error);
        }
    };

    const navItems = [
        { path: '/admin', label: 'Dashboard', icon: LayoutDashboard, slug: 'HOME' },
        { path: '/admin/destinations', label: 'Destinations', icon: MapPin, slug: 'DEST' },
        { path: '/admin/safaris', label: 'Safari Packages', icon: Tent, slug: 'SAFA' },
        { path: '/admin/trekking', label: 'Trekking Routes', icon: Mountain, slug: 'TREK' },
        { path: '/admin/pricing', label: 'Pricing Rules', icon: DollarSign, slug: 'PRICE' },
        { path: '/admin/blog', label: 'Blog Posts', icon: FileText, slug: 'BLOG' },
        { path: '/admin/departures', label: 'Departures', icon: Calendar, slug: 'DATE' },
        { path: '/admin/bookings', label: 'Bookings', icon: CheckCircle, slug: 'BOOK' },
        { path: '/admin/gear-requests', label: 'Gear Requests', icon: Backpack, slug: 'GEAR' },
        { path: '/admin/inquiries', label: 'Inquiries', icon: MessageSquare, slug: 'LEAD' },
        { path: '/admin/pages', label: 'Pages', icon: BookOpen, slug: 'PAGES' },
        { path: '/admin/visuals', label: 'Media Library', icon: ImageIcon, slug: 'MEDIA' },
    ];

    const isActivePath = (path) => {
        if (path === '/admin') return location.pathname === '/admin';
        return location.pathname === path || location.pathname.startsWith(path + '/');
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
                    <Link to="/admin/settings" className={`admin-nav-item ${isActivePath('/admin/settings') ? 'active' : ''}`}>
                        <Settings size={18} /> <span>Site Settings</span>
                    </Link>
                    <Link to="/admin/users" className={`admin-nav-item ${isActivePath('/admin/users') ? 'active' : ''}`}>
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
                        <button style={{ background: 'none', border: 'none', color: 'var(--text-dim)', position: 'relative', cursor: 'pointer' }}>
                            <Bell size={20} />
                            <span style={{ position: 'absolute', top: -2, right: -2, width: '6px', height: '6px', background: 'var(--gold)', borderRadius: '50%', boxShadow: '0 0 5px var(--gold)' }}></span>
                        </button>
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
