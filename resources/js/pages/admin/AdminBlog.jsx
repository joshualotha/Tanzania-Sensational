import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    Plus, Search, Edit3, Trash2, FileText, Compass, 
    ChevronRight, X, Shield, Clock, Camera, Save, 
    Loader2, AlertTriangle, Layers, Info, BookOpen, User
} from 'lucide-react';
import { adminService } from '../../services/api';
import { RichTextEditor } from '../../components/editor/RichTextEditor';
import '../../styles/admin-premium.css';

export const AdminBlog = () => {
    const [posts, setPosts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedPost, setSelectedPost] = useState(null);
    const [isCurating, setIsCurating] = useState(false);
    const [saving, setSaving] = useState(false);
    const [showCurator, setShowCurator] = useState(false);

    useEffect(() => {
        fetchPosts();
    }, []);

    const fetchPosts = async () => {
        try {
            setLoading(true);
            const response = await adminService.getBlogPosts();
            setPosts(response.data);
        } catch (error) {
            console.error("Intelligence Synchronization Failure:", error);
        } finally {
            setLoading(false);
        }
    };

    const handleOpenCurator = (post = null) => {
        if (post) {
            setSelectedPost({ 
                ...post, 
                content_html: post.content_html || '',
                content_blocks: post.content_blocks || (post.content ? JSON.parse(post.content) : [])
            });
        } else {
            setSelectedPost({
                title: 'NEW_INTELLIGENCE_REPORT',
                slug: `intel-${Date.now()}`,
                excerpt: 'Operational field notes pending...',
                author: 'COMMANDER_ALPHA',
                meta_tag: 'FIELD_REPORT',
                hero_image: 'https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&q=80',
                content_html: '',
                content_blocks: [],
                published_at: null
            });
        }
        setIsCurating(true);
        setShowCurator(true);
    };

    const handleSave = async () => {
        setSaving(true);
        try {
            const dataToSave = {
                ...selectedPost,
                content_html: selectedPost.content_html,
            };
            if (selectedPost.id) {
                await adminService.updateBlogPost(selectedPost.id, dataToSave);
            } else {
                await adminService.createBlogPost(dataToSave);
            }
            await fetchPosts();
            setIsCurating(false);
            setShowCurator(false);
            setSelectedPost(null);
        } catch (error) {
            alert("Archive broadcast failed. Signal lost.");
        } finally {
            setSaving(false);
        }
    };

    const handleDelete = async (id) => {
        if (!window.confirm("Purge this intelligence record from the archives?")) return;
        try {
            await adminService.deleteBlogPost(id);
            setPosts(posts.filter(p => p.id !== id));
            if (selectedPost?.id === id) {
                setIsCurating(false);
                setSelectedPost(null);
            }
        } catch (error) {
            alert("Redaction failure.");
        }
    };

    const filteredPosts = posts.filter(p => 
        (p.title || '').toLowerCase().includes(searchTerm.toLowerCase()) ||
        (p.author || '').toLowerCase().includes(searchTerm.toLowerCase())
    );

    if (loading) return (
        <div style={{ height: '60vh', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center' }}>
            <Loader2 className="animate-spin" size={48} color="var(--gold)" />
            <span style={{ marginTop: '20px', fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--gold)', letterSpacing: '0.3em' }}>SYNCHRONIZING FIELD DATA</span>
        </div>
    );

    return (
        <div className="admin-page-root">
            <header style={{ marginBottom: '60px', display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                <div>
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.25em', textTransform: 'uppercase', marginBottom: '12px' }}>Operational Insights</h2>
                    <h1 className="admin-page-title" style={{ fontSize: '3.5rem', fontWeight: 300 }}>Intelligence Logs</h1>
                </div>
                
                <div style={{ display: 'flex', gap: '20px', alignItems: 'center' }}>
                    <div className="admin-search-wrapper" style={{ border: '1px solid var(--border)', background: 'rgba(255,255,255,0.02)' }}>
                        <Search size={18} color="var(--gold-dim)" />
                        <input 
                            type="text" 
                            placeholder="QUERY ARCHIVES..." 
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            style={{ background: 'transparent', border: 'none', color: 'white', padding: '12px 10px', fontFamily: 'var(--font-mono)', fontSize: '0.75rem' }}
                        />
                    </div>
                    <button className="admin-btn-primary" onClick={() => handleOpenCurator()}>
                        <Plus size={18} /> INITIALIZE LOG
                    </button>
                </div>
            </header>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr', gap: '50px', alignItems: 'start' }}>
                {/* ─── GRID OF REPORTS ─── */}
                <div style={{ display: 'grid', gridTemplateColumns: '1fr', gap: '20px' }}>
                    <AnimatePresence>
                        {filteredPosts.map((post, idx) => (
                            <motion.div 
                                key={post.id}
                                initial={{ opacity: 0, x: -20 }}
                                animate={{ opacity: 1, x: 0 }}
                                transition={{ delay: idx * 0.05 }}
                                className={`intel-report-card ${selectedPost?.id === post.id ? 'active' : ''}`}
                                onClick={() => handleOpenCurator(post)}
                                style={{
                                    background: 'var(--slate)',
                                    border: '1px solid var(--border)',
                                    padding: '25px 40px',
                                    cursor: 'pointer',
                                    display: 'flex',
                                    alignItems: 'center',
                                    gap: '30px',
                                    position: 'relative',
                                    borderColor: selectedPost?.id === post.id ? 'var(--gold)' : 'var(--border)'
                                }}
                            >
                                <div style={{ width: '120px', height: '80px', flexShrink: 0, overflow: 'hidden' }}>
                                    <img src={post.hero_image} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover', opacity: 0.6 }} />
                                </div>
                                <div style={{ flex: 1 }}>
                                    <div style={{ display: 'flex', gap: '15px', alignItems: 'center', marginBottom: '8px' }}>
                                        <span style={{ fontSize: '0.55rem', color: 'var(--gold)', fontFamily: 'var(--font-mono)', letterSpacing: '0.1em' }}>{new Date(post.created_at || Date.now()).toLocaleDateString()}</span>
                                        <span style={{ width: '3px', height: '3px', background: 'rgba(255,255,255,0.2)', borderRadius: '50%' }}></span>
                                        <span style={{ fontSize: '0.55rem', color: 'rgba(255,255,255,0.4)', fontFamily: 'var(--font-mono)' }}>AUTH: {post.author?.toUpperCase()}</span>
                                    </div>
                                    <h3 style={{ fontSize: '1.2rem', color: 'white', fontWeight: 300 }}>{post.title}</h3>
                                </div>
                                <div style={{ display: 'flex', gap: '20px', alignItems: 'center' }}>
                                    <span style={{ fontSize: '0.6rem', padding: '4px 8px', border: '1px solid rgba(255,255,255,0.1)', color: 'rgba(255,255,255,0.3)', fontFamily: 'var(--font-mono)' }}>{post.status || 'DRAFT'}</span>
                                    <button 
                                        onClick={(e) => { e.stopPropagation(); handleDelete(post.id); }}
                                        style={{ background: 'none', border: 'none', color: '#ff4444', opacity: 0.3 }}
                                    >
                                        <Trash2 size={16} />
                                    </button>
                                </div>
                            </motion.div>
                        ))}
                    </AnimatePresence>
                </div>
            </div>

            {showCurator && isCurating && selectedPost && (
                <div
                    role="dialog"
                    aria-modal="true"
                    style={{
                        position: 'fixed',
                        inset: 0,
                        background: 'rgba(0,0,0,0.65)',
                        display: 'grid',
                        placeItems: 'center',
                        zIndex: 4000,
                        padding: 20,
                    }}
                    onMouseDown={() => !saving && (setShowCurator(false), setIsCurating(false))}
                >
                    <div
                        className="admin-panel shadow-premium"
                        style={{ width: 'min(980px, 96vw)', padding: 40, border: '1px solid var(--gold)', background: 'var(--charcoal)', maxHeight: '90vh', overflow: 'auto' }}
                        onMouseDown={(e) => e.stopPropagation()}
                    >
                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: '35px' }}>
                            <div>
                                <h4 style={SectionHeadStyle}><Shield size={14} /> Intelligence Architect</h4>
                                <h2 style={{ fontSize: '1.8rem', color: 'white', fontWeight: 300 }}>{selectedPost.id ? 'REPORT_OVERRIDE' : 'REPORT_INITIALIZE'}</h2>
                            </div>
                            <button onClick={() => !saving && (setShowCurator(false), setIsCurating(false))} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.2)', cursor: 'pointer' }}><X size={24} /></button>
                        </div>

                        <div className="curator-scrollarea custom-scrollbar" style={{ display: 'flex', flexDirection: 'column', gap: '30px' }}>
                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Primary Metadata</h5>
                                <AdminInput label="Report Title" value={selectedPost.title} onChange={v => setSelectedPost({...selectedPost, title: v})} />
                                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '15px', marginTop: '15px' }}>
                                    <AdminInput label="URL Slug" value={selectedPost.slug} onChange={v => setSelectedPost({...selectedPost, slug: v})} />
                                    <AdminInput label="Strategic Author" value={selectedPost.author} onChange={v => setSelectedPost({...selectedPost, author: v})} />
                                </div>
                                <div style={{ marginTop: '15px' }}>
                                    <AdminInput label="Feature Visual (URL)" value={selectedPost.hero_image} onChange={v => setSelectedPost({...selectedPost, hero_image: v})} />
                                </div>
                                <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 15, marginTop: 15 }}>
                                    <AdminInput label="Category" value={selectedPost.category} onChange={v => setSelectedPost({...selectedPost, category: v})} />
                                    <AdminInput label="Published at (empty = draft)" type="datetime-local" value={selectedPost.published_at ? new Date(selectedPost.published_at).toISOString().slice(0,16) : ''} onChange={v => setSelectedPost({...selectedPost, published_at: v ? new Date(v).toISOString() : null})} />
                                </div>
                            </div>

                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Executive Summary</h5>
                                <AdminTextarea label="Report Excerpt" value={selectedPost.excerpt} rows={3} onChange={v => setSelectedPost({...selectedPost, excerpt: v})} />
                            </div>

                            <div className="curator-section">
                                <h5 style={SubHeadStyle}>Content</h5>
                                <RichTextEditor
                                    value={selectedPost.content_html || ''}
                                    onChange={(html) => setSelectedPost((p) => ({ ...p, content_html: html }))}
                                />
                            </div>
                        </div>

                        <div style={{ marginTop: '30px', display: 'flex', gap: '15px' }}>
                            <button className="admin-btn-secondary" style={{ flex: 1 }} onClick={() => !saving && (setShowCurator(false), setIsCurating(false))}>Close</button>
                            <button
                                className="admin-btn-primary"
                                style={{ flex: 2 }}
                                disabled={saving}
                                onClick={handleSave}
                            >
                                {saving ? <Loader2 className="animate-spin" size={16} /> : <Save size={16} />}
                                <span>{saving ? 'Saving…' : 'Save post'}</span>
                            </button>
                        </div>
                    </div>
                </div>
            )}
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

const SubHeadStyle = {
    fontFamily: 'var(--font-mono)',
    fontSize: '0.6rem',
    color: 'var(--text-dim)',
    textTransform: 'uppercase',
    letterSpacing: '0.15em',
    paddingBottom: '10px',
    borderBottom: '1px solid rgba(255,255,255,0.05)',
    marginBottom: '20px'
};

const LabelStyle = {
    display: 'block',
    fontFamily: 'var(--font-mono)',
    fontSize: '0.6rem',
    color: 'var(--text-dim)',
    textTransform: 'uppercase',
    marginBottom: '8px'
};

const AdminInput = ({ label, value, onChange, type = "text" }) => (
    <div style={{ marginBottom: '15px' }}>
        <label style={LabelStyle}>{label}</label>
        <input 
            type={type} 
            value={value || ''} 
            onChange={e => onChange(e.target.value)} 
            style={{ width: '100%', background: '#000', border: '1px solid var(--border)', padding: '10px 12px', color: 'white', fontSize: '0.85rem' }}
        />
    </div>
);

const AdminTextarea = ({ label, value, rows, onChange }) => (
    <div style={{ marginBottom: '15px' }}>
        <label style={LabelStyle}>{label}</label>
        <textarea 
            rows={rows} 
            value={value || ''} 
            onChange={e => onChange(e.target.value)} 
            style={{ width: '100%', background: '#000', border: '1px solid var(--border)', padding: '12px', color: 'white', fontSize: '0.85rem', resize: 'none', lineHeight: '1.6' }}
        />
    </div>
);

const CompactInput = {
    width: '100%',
    background: '#000',
    border: '1px solid var(--border)',
    color: 'white',
    padding: '8px 12px',
    fontSize: '0.8rem',
    outline: 'none'
};
