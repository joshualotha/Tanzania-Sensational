import React, { useState } from 'react';
import { Eye, Edit, Trash2, Plus, Save, ChevronDown, ChevronUp, Image, Type, Hash } from 'lucide-react';
import { blogsData as initialData } from '../../data/blogsData';

export const AdminBlog = () => {
    const [blogs, setBlogs] = useState(initialData);
    const [expandedId, setExpandedId] = useState(null);

    const toggleExpand = (id) => {
        setExpandedId(expandedId === id ? null : id);
    };

    const handleDelete = (slug) => {
        if (window.confirm('Delete this article?')) {
            setBlogs(blogs.filter(b => b.slug !== slug));
        }
    };

    return (
        <div>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '30px' }}>
                <div>
                    <h2 style={{ fontSize: '1.5rem', color: 'white', marginBottom: '5px' }}>Blog Management ({blogs.length})</h2>
                    <p style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.4)' }}>Draft and publish expedition journals and field reports.</p>
                </div>
                <button className="btn-admin-primary" style={{ width: 'auto', padding: '12px 25px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                    <Plus size={16} /> New Article
                </button>
            </div>

            {blogs.map((blog) => (
                <div key={blog.slug} className="admin-panel" style={{ marginBottom: '20px', borderLeft: '3px solid var(--gold)' }}>
                    {/* HEADER ROW */}
                    <div style={{ padding: '20px 30px', display: 'flex', justifyContent: 'space-between', alignItems: 'center', borderBottom: expandedId === blog.slug ? '1px solid rgba(255,255,255,0.05)' : 'none' }}>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '20px' }}>
                            <div style={{ width: 60, height: 40, borderRadius: 2, overflow: 'hidden' }}>
                                <img src={blog.coverImage} alt="" style={{ width: '100%', height: '100%', objectFit: 'cover' }} />
                            </div>
                            <div>
                                <div style={{ fontWeight: 600, color: 'white', fontSize: '1rem' }}>{blog.title}</div>
                                <div style={{ fontSize: '0.7rem', color: 'rgba(255,255,255,0.4)' }}>By {blog.author} · {blog.date} · /blog/{blog.slug}</div>
                            </div>
                        </div>
                        <div style={{ display: 'flex', alignItems: 'center', gap: '15px' }}>
                            <span className="status-pill status-new">{blog.category}</span>
                            <div style={{ width: '1px', height: '20px', background: 'rgba(255,255,255,0.1)' }}></div>
                            <button onClick={() => toggleExpand(blog.slug)} style={{ background: 'none', border: 'none', color: 'var(--gold)', cursor: 'pointer' }}>
                                {expandedId === blog.slug ? <ChevronUp size={18} /> : <ChevronDown size={18} />}
                            </button>
                            <button onClick={() => handleDelete(blog.slug)} style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer', opacity: 0.6 }}>
                                <Trash2 size={16} />
                            </button>
                        </div>
                    </div>

                    {/* EXPANDED EDITOR */}
                    {expandedId === blog.slug && (
                        <div style={{ padding: '40px 30px' }}>
                            {/* SETTINGS SECTION */}
                            <SectionHeader title="Article Settings" />
                            <div style={{ display: 'grid', gridTemplateColumns: '2fr 1fr 1fr', gap: '20px', marginBottom: '40px' }}>
                                <FieldInput label="Title" value={blog.title} />
                                <FieldInput label="Author" value={blog.author} />
                                <FieldInput label="Category" value={blog.category} />
                                <FieldInput label="Date" value={blog.date} />
                                <FieldInput label="Slug (URL Path)" value={blog.slug} />
                                <FieldInput label="Reading Time (e.g. 5 min)" value="6 min" />
                                <FieldInput label="Cover Image URL" value={blog.coverImage} fullComp />
                            </div>

                            {/* CONTENT BLOCK EDITOR */}
                            <SectionHeader title="Content Blocks" />
                            <p style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.3)', marginBottom: '20px', marginTop: '-10px' }}>
                                Articles are composed of content blocks: paragraphs, subheadings, and featured quotes.
                            </p>

                            <div style={{ display: 'flex', flexDirection: 'column', gap: '15px', marginBottom: '30px' }}>
                                {blog.content.map((block, i) => (
                                    <div key={i} style={{ 
                                        background: '#0a0a0a', 
                                        border: '1px solid rgba(255,255,255,0.05)',
                                        padding: '20px',
                                        borderRadius: '4px',
                                        position: 'relative'
                                    }}>
                                        <div style={{ position: 'absolute', right: '15px', top: '15px', display: 'flex', gap: '8px' }}>
                                            <span style={{ fontSize: '0.6rem', color: 'rgba(255,255,255,0.2)', textTransform: 'uppercase' }}>
                                                Block {i + 1}
                                            </span>
                                            <button style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer', opacity: 0.5 }}><Trash2 size={12} /></button>
                                        </div>
                                        <div style={{ display: 'flex', gap: '15px', alignItems: 'flex-start' }}>
                                            <div style={{ padding: '8px', background: 'rgba(255,255,255,0.03)', borderRadius: '4px', color: 'var(--gold)' }}>
                                                {block.type === 'paragraph' ? <Type size={14} /> : block.type === 'subheading' ? <Hash size={14} /> : <Image size={14} />}
                                            </div>
                                            <div style={{ flex: 1 }}>
                                                <select 
                                                    defaultValue={block.type}
                                                    style={{ width: '120px', background: 'transparent', border: 'none', color: 'rgba(255,255,255,0.4)', fontSize: '0.65rem', textTransform: 'uppercase', marginBottom: '8px', outline: 'none' }}
                                                >
                                                    <option value="paragraph">Paragraph</option>
                                                    <option value="subheading">Subheading</option>
                                                    <option value="quote">Quote</option>
                                                </select>
                                                <textarea 
                                                    defaultValue={block.text}
                                                    rows={block.type === 'paragraph' ? 3 : 1}
                                                    style={{ 
                                                        width: '100%', 
                                                        background: 'transparent', 
                                                        border: 'none', 
                                                        color: 'white', 
                                                        fontSize: block.type === 'subheading' ? '1.1rem' : '0.9rem', 
                                                        fontFamily: block.type === 'subheading' ? 'Playfair Display, serif' : 'Outfit, sans-serif',
                                                        resize: 'none',
                                                        outline: 'none',
                                                        lineHeight: 1.6
                                                    }}
                                                />
                                            </div>
                                        </div>
                                    </div>
                                ))}
                                
                                <div style={{ display: 'flex', gap: '10px', marginTop: '10px' }}>
                                    <button style={AddBlockBtn}>+ Add Paragraph</button>
                                    <button style={AddBlockBtn}>+ Add Subheading</button>
                                    <button style={AddBlockBtn}>+ Add Image</button>
                                </div>
                            </div>

                            {/* PUBLISH ACTIONS */}
                            <div style={{ display: 'flex', gap: '15px', justifyContent: 'flex-end', paddingTop: '30px', borderTop: '1px solid rgba(255,255,255,0.05)' }}>
                                <button onClick={() => setExpandedId(null)} style={{ background: 'none', border: '1px solid rgba(255,255,255,0.15)', color: 'rgba(255,255,255,0.5)', padding: '10px 25px', cursor: 'pointer', fontSize: '0.8rem' }}>
                                    Discard Changes
                                </button>
                                <button className="btn-admin-primary" style={{ width: 'auto', padding: '10px 25px', display: 'flex', alignItems: 'center', gap: '8px' }}>
                                    <Save size={14} /> Update Article
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            ))}
        </div>
    );
};

const AddBlockBtn = {
    background: 'rgba(255,255,255,0.03)',
    border: '1px dashed rgba(255,255,255,0.1)',
    color: 'rgba(255,255,255,0.4)',
    padding: '12px 20px',
    fontSize: '0.7rem',
    cursor: 'pointer',
    borderRadius: '4px',
    flex: 1
};

/* ─── REUSABLE FORM COMPONENTS ─── */
const SectionHeader = ({ title }) => (
    <h4 style={{ fontSize: '0.7rem', textTransform: 'uppercase', letterSpacing: '0.15em', color: 'var(--gold)', marginBottom: '20px', paddingBottom: '10px', borderBottom: '1px solid rgba(255,255,255,0.05)' }}>
        {title}
    </h4>
);

const FieldInput = ({ label, value, fullComp }) => (
    <div style={{ gridColumn: fullComp ? '1 / -1' : 'auto' }}>
        <label style={{ display: 'block', fontSize: '0.7rem', color: 'rgba(255,255,255,0.5)', marginBottom: '6px', textTransform: 'uppercase', letterSpacing: '0.05em' }}>{label}</label>
        <input 
            type="text" 
            defaultValue={value} 
            style={{ width: '100%', background: '#000', border: '1px solid rgba(255,255,255,0.1)', color: 'white', padding: '10px 12px', fontSize: '0.85rem', fontFamily: 'Outfit, sans-serif' }}
        />
    </div>
);
