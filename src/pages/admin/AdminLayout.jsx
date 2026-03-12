import React from 'react';
import { Outlet, Link, useLocation } from 'react-router-dom';
import { 
    LayoutDashboard, 
    MapPin,
    Tent, 
    Mountain,
    FileText,
    Calendar,
    MessageSquare,
    LogOut, 
    Bell, 
    Search,
    Image as ImageIcon
} from 'lucide-react';
import '../../styles/admin-premium.css';

export const AdminLayout = () => {
    const location = useLocation();

    const navItems = [
        { path: '/admin', label: 'Command Center', icon: LayoutDashboard },
        { path: '/admin/destinations', label: 'Destinations', icon: MapPin },
        { path: '/admin/safaris', label: 'Safari Packages', icon: Tent },
        { path: '/admin/trekking', label: 'Trekking Packages', icon: Mountain },
        { path: '/admin/blog', label: 'Blog Articles', icon: FileText },
        { path: '/admin/departures', label: 'Group Departures', icon: Calendar },
        { path: '/admin/inquiries', label: 'Inquiries', icon: MessageSquare },
        { path: '/admin/visuals', label: 'Visual Assets', icon: ImageIcon },
    ];

    return (
        <div className="admin-root">
            {/* ─── COMMAND SIDEBAR ─── */}
            <aside className="admin-sidebar">
                <div className="admin-brand">
                    <div className="admin-brand-logo">Tanzania<br/>Sensational</div>
                    <div className="admin-brand-tag">Expedition Command</div>
                </div>

                <nav className="admin-nav">
                    <div className="admin-nav-group">
                        <div className="admin-nav-head">Main Operations</div>
                        {navItems.slice(0, 6).map((item) => (
                            <Link 
                                key={item.path} 
                                to={item.path} 
                                className={`admin-nav-item ${location.pathname === item.path ? 'active' : ''}`}
                            >
                                <item.icon size={18} />
                                <span>{item.label}</span>
                            </Link>
                        ))}
                    </div>

                    <div className="admin-nav-group" style={{ marginTop: '20px' }}>
                        <div className="admin-nav-head">Site Intelligence</div>
                        {navItems.slice(6).map((item) => (
                            <Link 
                                key={item.path} 
                                to={item.path} 
                                className={`admin-nav-item ${location.pathname === item.path ? 'active' : ''}`}
                            >
                                <item.icon size={18} />
                                <span>{item.label}</span>
                            </Link>
                        ))}
                    </div>
                </nav>

                <div className="admin-user">
                    <div className="admin-avatar">A</div>
                    <div className="admin-user-info">
                        <h4>Admin Operator</h4>
                        <p>Command Level 1</p>
                    </div>
                </div>
            </aside>

            {/* ─── MAIN CONTENT AREA ─── */}
            <main className="admin-main">
                <header className="admin-header">
                    <h1 className="admin-page-title">
                        {navItems.find(i => i.path === location.pathname)?.label || 'Dashboard'}
                    </h1>
                    
                    <div className="admin-header-actions">
                        <div style={{ position: 'relative' }}>
                            <Search size={16} style={{ position: 'absolute', left: 15, top: '50%', transform: 'translateY(-50%)', color: 'rgba(255,255,255,0.4)' }} />
                            <input 
                                type="text" 
                                placeholder="Search records..." 
                                style={{
                                    background: '#111',
                                    border: '1px solid rgba(255,255,255,0.1)',
                                    padding: '8px 15px 8px 40px',
                                    color: 'white',
                                    borderRadius: '4px',
                                    outline: 'none',
                                    width: '250px'
                                }}
                            />
                        </div>
                        <button style={{ background: 'transparent', border: 'none', color: 'white', cursor: 'pointer', position: 'relative' }}>
                            <Bell size={20} />
                            <span style={{ position: 'absolute', top: -2, right: -2, width: 8, height: 8, background: 'var(--gold)', borderRadius: '50%' }}></span>
                        </button>
                        <Link to="/" style={{ color: 'rgba(255,255,255,0.5)', marginLeft: '20px', transition: 'color 0.3s' }}>
                            <LogOut size={20} />
                        </Link>
                    </div>
                </header>

                <div className="admin-content-scroll">
                    <Outlet />
                </div>
            </main>
        </div>
    );
};
