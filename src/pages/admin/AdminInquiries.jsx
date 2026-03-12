import React, { useState } from 'react';
import { Eye, Mail, Trash2, CheckCircle, Search, Filter, RefreshCcw } from 'lucide-react';

const initialInquiries = [
    { id: 1, name: 'James Mitchell', email: 'james@example.com', subject: 'Great Migration Safari', message: 'Interested in the 10-day migration edition for 2 adults in August 2026. Looking for luxury tented camps.', status: 'New', date: 'Mar 12, 2026', phone: '+1 415-555-0123' },
    { id: 2, name: 'Sarah Chen', email: 'sarah.c@email.com', subject: '8-Day Lemosho Route Inquiry', message: 'Can you provide details on the 8-day Lemosho for a group of 4? Do you provide rental gear?', status: 'Read', date: 'Mar 11, 2026', phone: '+86 21 5555 1234' },
    { id: 3, name: 'David Okafor', email: 'david.o@mail.com', subject: 'Corporate Safari Retreat', message: 'We are planning a corporate retreat for 15 people. Looking for a private safari package with high-end lodges.', status: 'Replied', date: 'Mar 10, 2026', phone: '+234 803 555 0000' },
    { id: 4, name: 'Emily Watson', email: 'emily.w@email.com', subject: 'Zanzibar Extension', message: 'After our Kilimanjaro trek, we want to add 5 days in Zanzibar. What are the options for private villas?', status: 'New', date: 'Mar 09, 2026', phone: '+44 20 7946 0123' },
    { id: 5, name: 'Michael Brown', email: 'mbrown@mail.com', subject: 'NYE Summit Lemosho', message: 'Is the December 28 group departure still available? Looking for 2 spots for my son and I.', status: 'Replied', date: 'Mar 08, 2026', phone: '+1 617-555-0987' },
];

export const AdminInquiries = () => {
    const [inquiries, setInquiries] = useState(initialInquiries);
    const [filter, setFilter] = useState('All');
    const [selectedId, setSelectedId] = useState(null);

    const filtered = inquiries.filter(i => filter === 'All' || i.status === filter);
    const selected = inquiries.find(i => i.id === selectedId);

    const updateStatus = (id, newStatus) => {
        setInquiries(inquiries.map(i => i.id === id ? { ...i, status: newStatus } : i));
    };

    const deleteInquiry = (id) => {
        if (window.confirm('Delete this inquiry?')) {
            setInquiries(inquiries.filter(i => i.id !== id));
            if (selectedId === id) setSelectedId(null);
        }
    };

    return (
        <div style={{ display: 'grid', gridTemplateColumns: selected ? '1fr 400px' : '1fr', gap: '30px', transition: 'all 0.4s ease' }}>
            <div>
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '30px' }}>
                    <div>
                        <h2 style={{ fontSize: '1.5rem', color: 'white', marginBottom: '5px' }}>Contact Inquiries ({inquiries.length})</h2>
                        <div style={{ display: 'flex', gap: '15px' }}>
                            <span style={{ fontSize: '0.75rem', color: 'var(--gold)' }}>{inquiries.filter(i => i.status === 'New').length} Pending</span>
                            <span style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.4)' }}>{inquiries.filter(i => i.status === 'Replied').length} Handled</span>
                        </div>
                    </div>
                    <div style={{ display: 'flex', gap: '10px' }}>
                        <select 
                            value={filter} 
                            onChange={(e) => setFilter(e.target.value)}
                            style={{ background: '#111', border: '1px solid rgba(255,255,255,0.1)', color: 'white', padding: '10px 15px', borderRadius: '4px', outline: 'none' }}
                        >
                            <option value="All">All Status</option>
                            <option value="New">New</option>
                            <option value="Read">Read</option>
                            <option value="Replied">Replied</option>
                        </select>
                    </div>
                </div>

                <div className="admin-panel">
                    <table className="admin-table">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th style={{ textAlign: 'right' }}>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {filtered.map((inq) => (
                                <tr key={inq.id} 
                                    onClick={() => setSelectedId(inq.id)}
                                    style={{ 
                                        cursor: 'pointer', 
                                        background: selectedId === inq.id ? 'rgba(201,168,76,0.05)' : 'transparent',
                                        transition: 'background 0.2s'
                                    }}
                                >
                                    <td>
                                        <div style={{ fontWeight: 600, color: selectedId === inq.id ? 'var(--gold)' : 'white' }}>{inq.name}</div>
                                        <div style={{ fontSize: '0.7rem', color: 'rgba(255,255,255,0.4)' }}>{inq.email}</div>
                                    </td>
                                    <td style={{ fontWeight: 500, fontSize: '0.85rem' }}>{inq.subject}</td>
                                    <td>
                                        <span className={`status-pill ${
                                            inq.status === 'New' ? 'status-new' :
                                            inq.status === 'Read' ? 'status-completed' : 'status-confirmed'
                                        }`}>
                                            {inq.status}
                                        </span>
                                    </td>
                                    <td style={{ color: 'rgba(255,255,255,0.5)', fontSize: '0.8rem' }}>{inq.date}</td>
                                    <td style={{ textAlign: 'right' }}>
                                        <button 
                                            onClick={(e) => { e.stopPropagation(); deleteInquiry(inq.id); }}
                                            style={{ background: 'none', border: 'none', color: '#E53E3E', cursor: 'pointer', opacity: 0.6 }}
                                        >
                                            <Trash2 size={16} />
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>

            {/* INQUIRY DETAIL DRAWER */}
            {selected && (
                <div style={{ 
                    background: '#111', 
                    borderLeft: '1px solid rgba(255,255,255,0.08)',
                    padding: '40px 30px',
                    height: 'calc(100vh - 120px)',
                    position: 'sticky',
                    top: '110px',
                    overflowY: 'auto'
                }}>
                    <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: '30px' }}>
                        <span className="status-pill status-new">{selected.status}</span>
                        <button onClick={() => setSelectedId(null)} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.4)', cursor: 'pointer' }}><X size={20} /></button>
                    </div>

                    <h3 style={{ fontSize: '1.2rem', color: 'white', marginBottom: '25px', fontFamily: 'Playfair Display, serif' }}>{selected.subject}</h3>
                    
                    <div style={{ marginBottom: '30px' }}>
                        <div style={{ labelStyle }}>From</div>
                        <div style={{ valueStyle, fontWeight: 700, color: 'var(--gold)' }}>{selected.name}</div>
                        <div style={{ valueStyle }}>{selected.email}</div>
                        <div style={{ valueStyle }}>{selected.phone}</div>
                    </div>

                    <div style={{ marginBottom: '30px' }}>
                        <div style={{ labelStyle }}>Message</div>
                        <div style={{ background: '#000', padding: '20px', borderRadius: '4px', fontSize: '0.9rem', lineHeight: 1.6, border: '1px solid rgba(255,255,255,0.05)' }}>
                            {selected.message}
                        </div>
                    </div>

                    <div style={{ labelStyle, marginBottom: '15px' }}>Update Status</div>
                    <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '10px' }}>
                        <button 
                            onClick={() => updateStatus(selected.id, 'Read')}
                            style={{ background: 'transparent', border: '1px solid rgba(255,255,255,0.1)', color: 'white', padding: '10px', borderRadius: '4px', cursor: 'pointer', fontSize: '0.75rem' }}
                        >
                            Mark as Read
                        </button>
                        <button 
                            onClick={() => updateStatus(selected.id, 'Replied')}
                            className="btn-admin-primary"
                            style={{ padding: '10px', fontSize: '0.75rem' }}
                        >
                            Mark Replied
                        </button>
                    </div>

                    <button 
                        style={{ width: '100%', marginTop: '40px', background: 'transparent', border: '1px solid #E53E3E', color: '#E53E3E', padding: '12px', borderRadius: '4px', cursor: 'pointer', fontSize: '0.8rem', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '10px' }}
                        onClick={() => deleteInquiry(selected.id)}
                    >
                        <Trash2 size={16} /> Delete Inquiry
                    </button>
                </div>
            )}
        </div>
    );
};

const labelStyle = {
    fontSize: '0.65rem',
    color: 'rgba(255,255,255,0.3)',
    textTransform: 'uppercase',
    letterSpacing: '0.15em',
    marginBottom: '8px'
};

const valueStyle = {
    fontSize: '0.9rem',
    color: 'rgba(255,255,255,0.8)',
    marginBottom: '4px'
};
