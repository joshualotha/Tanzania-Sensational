import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    MessageSquare, Search, Eye, Trash2, 
    User, Mail, Phone, Clock, FileText, ChevronRight, X, Loader2,
    Send, Shield, Briefcase, Zap, Inbox, Filter, Compass
} from 'lucide-react';
import { adminService } from '../../services/api';
import '../../styles/admin-premium.css';

export const AdminInquiries = () => {
    const [inquiries, setInquiries] = useState([]);
    const [loading, setLoading] = useState(true);
    const [selectedInquiry, setSelectedInquiry] = useState(null);
    const [searchTerm, setSearchTerm] = useState('');

    useEffect(() => {
        fetchInquiries();
    }, []);

    const fetchInquiries = async () => {
        try {
            setLoading(true);
            const response = await adminService.getInquiries();
            setInquiries(response.data);
        } catch (error) {
            console.error("Intelligence Interception Failure:", error);
        } finally {
            setLoading(false);
        }
    };

    const handleDelete = async (id) => {
        if (!window.confirm("Strike this brief from the record permanently? This action is irreversible.")) return;
        try {
            await adminService.deleteInquiry(id);
            setInquiries(inquiries.filter(i => i.id !== id));
            setSelectedInquiry(null);
        } catch (error) {
            alert("Redaction failure. Archive remains locked.");
        }
    };

    const filteredInquiries = inquiries.filter(i => 
        (i.first_name || '').toLowerCase().includes(searchTerm.toLowerCase()) ||
        (i.last_name || '').toLowerCase().includes(searchTerm.toLowerCase()) ||
        (i.email || '').toLowerCase().includes(searchTerm.toLowerCase())
    );

    if (loading) return (
        <div style={{ height: '60vh', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center' }}>
            <Loader2 className="animate-spin" size={48} color="var(--gold)" />
            <span style={{ marginTop: '20px', fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--gold)', letterSpacing: '0.3em' }}>DECRYPTING INCOMING BRIEFS</span>
        </div>
    );

    return (
        <div className="admin-page-root">
            <header style={{ marginBottom: '50px', display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                <div>
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.25em', textTransform: 'uppercase', marginBottom: '12px' }}>Operational Intel</h2>
                    <h1 className="admin-page-title" style={{ fontSize: '3.5rem', fontWeight: 300, color: 'white' }}>Field Transmissions</h1>
                </div>
                
                <div style={{ display: 'flex', gap: '20px', alignItems: 'center' }}>
                    <div className="admin-search-wrapper" style={{ border: '1px solid var(--border)', background: 'rgba(255,255,255,0.02)' }}>
                        <Search size={18} color="var(--gold-dim)" />
                        <input 
                            type="text" 
                            placeholder="QUERY TRANSMISSIONS..." 
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            style={{ background: 'transparent', border: 'none', color: 'white', padding: '12px 10px', fontFamily: 'var(--font-mono)', fontSize: '0.75rem' }}
                        />
                    </div>
                </div>
            </header>

            <div style={{ display: 'grid', gridTemplateColumns: 'minmax(400px, 1fr) 500px', gap: '40px', alignItems: 'start' }}>
                {/* ─── TRANSMISSION LOG (LIST) ─── */}
                <div style={{ display: 'flex', flexDirection: 'column', gap: '15px' }}>
                    <AnimatePresence>
                        {filteredInquiries.length > 0 ? filteredInquiries.map((inq, idx) => (
                            <motion.div 
                                key={inq.id}
                                initial={{ opacity: 0, x: -20 }}
                                animate={{ opacity: 1, x: 0 }}
                                transition={{ delay: idx * 0.05 }}
                                className={`transmission-card ${selectedInquiry?.id === inq.id ? 'active' : ''}`}
                                onClick={() => setSelectedInquiry(inq)}
                                style={{
                                    background: 'var(--slate)',
                                    border: '1px solid var(--border)',
                                    padding: '30px 40px',
                                    cursor: 'pointer',
                                    position: 'relative',
                                    borderColor: selectedInquiry?.id === inq.id ? 'var(--gold)' : 'var(--border)',
                                    display: 'flex',
                                    justifyContent: 'space-between',
                                    alignItems: 'center'
                                }}
                            >
                                <div style={{ display: 'flex', gap: '25px', alignItems: 'center' }}>
                                    <div style={{ width: '45px', height: '45px', borderRadius: '50%', background: 'rgba(201,168,76,0.1)', border: '1px solid var(--gold-dim)', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', fontWeight: 700 }}>
                                        {inq.first_name?.[0] || 'X'}
                                    </div>
                                    <div>
                                        <div style={{ display: 'flex', gap: '15px', alignItems: 'center', marginBottom: '4px' }}>
                                            <span style={{ fontSize: '0.6rem', color: 'var(--gold)', fontFamily: 'var(--font-mono)', letterSpacing: '0.1em' }}>{new Date(inq.created_at).toLocaleDateString()}</span>
                                            <span style={{ fontSize: '1.2rem', color: 'white', fontWeight: 300 }}>{inq.first_name} {inq.last_name}</span>
                                        </div>
                                        <p style={{ fontSize: '0.8rem', color: 'var(--text-dim)', maxWidth: '400px', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis' }}>{inq.objective}</p>
                                    </div>
                                </div>
                                <div style={{ textAlign: 'right', display: 'flex', flexDirection: 'column', gap: '8px', alignItems: 'flex-end' }}>
                                    <span style={{ fontSize: '0.55rem', color: 'rgba(255,255,255,0.2)', fontFamily: 'var(--font-mono)' }}>#{inq.id.toString().padStart(4, '0')}</span>
                                    <div className="status-pill status-pending" style={{ padding: '4px 10px', fontSize: '0.5rem' }}>INCOMING_INTEL</div>
                                </div>
                            </motion.div>
                        )) : (
                            <div style={{ padding: '100px', textAlign: 'center', background: 'rgba(255,255,255,0.01)', border: '1px dashed var(--border)' }}>
                                <Inbox size={64} style={{ marginBottom: '30px', opacity: 0.1 }} />
                                <span style={{ fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--text-dim)', letterSpacing: '0.2em' }}>NO ACTIVE FIELD TRANSMISSIONS</span>
                            </div>
                        )}
                    </AnimatePresence>
                </div>

                {/* ─── INTELLIGENCE DOSSIER (SIDEBAR) ─── */}
                <aside style={{ position: 'sticky', top: '120px' }}>
                    <AnimatePresence mode="wait">
                        {selectedInquiry ? (
                            <motion.div 
                                key={selectedInquiry.id}
                                initial={{ opacity: 0, scale: 0.98 }}
                                animate={{ opacity: 1, scale: 1 }}
                                exit={{ opacity: 0, scale: 0.98 }}
                                className="admin-panel shadow-premium"
                                style={{ padding: '50px', border: '1px solid var(--gold)', background: 'var(--charcoal)' }}
                            >
                                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: '40px' }}>
                                    <div>
                                        <h4 style={SectionHeadStyle}><Shield size={14} /> Mission Brief Dossier</h4>
                                        <h2 style={{ fontSize: '2.2rem', color: 'white', fontWeight: 300, marginTop: '8px' }}>{selectedInquiry.first_name} {selectedInquiry.last_name}</h2>
                                    </div>
                                    <button onClick={() => setSelectedInquiry(null)} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.2)', cursor: 'pointer' }}><X size={24} /></button>
                                </div>

                                <div style={{ display: 'flex', flexDirection: 'column', gap: '35px' }}>
                                    <div className="dossier-section">
                                        <h5 style={SubHeadStyle}>Field Identity</h5>
                                        <div style={{ display: 'flex', flexDirection: 'column', gap: '12px' }}>
                                            <div style={InfoRowStyle}><Mail size={16} /> <span>{selectedInquiry.email}</span></div>
                                            {selectedInquiry.phone && <div style={InfoRowStyle}><Phone size={16} /> <span>{selectedInquiry.phone}</span></div>}
                                            <div style={InfoRowStyle}><Compass size={16} /> <span>Origin Point: {selectedInquiry.country || 'GLOBAL_UNSET'}</span></div>
                                        </div>
                                    </div>

                                    <div className="dossier-section">
                                        <h5 style={SubHeadStyle}>Mission Objective</h5>
                                        <div style={{ background: 'rgba(255,255,255,0.02)', padding: '30px', borderLeft: '3px solid var(--gold)', borderRadius: '2px' }}>
                                            <p style={{ fontSize: '1rem', color: 'white', lineHeight: '1.8', fontStyle: 'italic' }}>"{selectedInquiry.objective}"</p>
                                        </div>
                                    </div>

                                    {selectedInquiry.vision && (
                                        <div className="dossier-section">
                                            <h5 style={SubHeadStyle}>Strategic Vision</h5>
                                            <p style={{ fontSize: '0.9rem', color: 'rgba(255,255,255,0.6)', lineHeight: '1.8' }}>{selectedInquiry.vision}</p>
                                        </div>
                                    )}

                                    <div style={{ marginTop: '20px', display: 'flex', flexDirection: 'column', gap: '15px' }}>
                                        <a href={`mailto:${selectedInquiry.email}`} className="admin-btn-primary" style={{ width: '100%', padding: '18px', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '15px' }}>
                                            <Send size={20} /> INITIATE STRATEGIC RESPONSE
                                        </a>
                                        <button 
                                            onClick={() => handleDelete(selectedInquiry.id)}
                                            style={{ width: '100%', padding: '15px', color: '#ff4444', border: '1px solid rgba(255,68,68,0.1)', background: 'transparent', cursor: 'pointer', fontFamily: 'var(--font-mono)', fontSize: '0.7rem', textTransform: 'uppercase', letterSpacing: '0.1em' }}
                                        >
                                            <Trash2 size={16} /> REDACT BRIEF FROM ARCHIVE
                                        </button>
                                    </div>
                                </div>
                            </motion.div>
                        ) : (
                            <motion.div 
                                initial={{ opacity: 0 }}
                                animate={{ opacity: 1 }}
                                className="admin-panel shadow-premium"
                                style={{ height: '600px', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center', background: 'rgba(255,255,255,0.01)', border: '1px dashed var(--border)' }}
                            >
                                <Briefcase size={64} color="rgba(255,255,255,0.03)" style={{ marginBottom: '30px' }} />
                                <span style={{ fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--text-dim)', letterSpacing: '0.3em', textTransform: 'uppercase' }}>Select Transmission for Intelligence synthesis</span>
                            </motion.div>
                        )}
                    </AnimatePresence>
                </aside>
            </div>
        </div>
    );
};

/* ─── STYLES ─── */

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
    paddingBottom: '12px',
    borderBottom: '1px solid rgba(255,255,255,0.05)',
    marginBottom: '20px'
};

const InfoRowStyle = {
    display: 'flex',
    alignItems: 'center',
    gap: '15px',
    fontSize: '0.9rem',
    color: 'rgba(255,255,255,0.6)'
};
