import React, { useMemo, useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { 
    Search, Trash2, CheckCircle, Clock, Filter, 
    MoreHorizontal, ChevronRight, X, Loader2, 
    Calendar, Users, DollarSign, Shield, FileText,
    ArrowUpRight, Mail, Phone
} from 'lucide-react';
import { useLocation } from 'react-router-dom';
import { adminService } from '../../services/api';
import '../../styles/admin-premium.css';

export const AdminBookingsList = () => {
    const location = useLocation();
    const [bookings, setBookings] = useState([]);
    const [loading, setLoading] = useState(true);
    const [searchTerm, setSearchTerm] = useState('');
    const [filterStatus, setFilterStatus] = useState('ALL');
    const [selectedBooking, setSelectedBooking] = useState(null);
    const [showDetails, setShowDetails] = useState(false);
    const [isReplying, setIsReplying] = useState(false);
    const [replySubject, setReplySubject] = useState('');
    const [replyMessage, setReplyMessage] = useState('');
    const [replySending, setReplySending] = useState(false);
    const [replyError, setReplyError] = useState('');

    useEffect(() => {
        fetchBookings();
    }, []);

    useEffect(() => {
        const openBookingId = location.state?.openBookingId;
        if (!openBookingId) return;
        const found = bookings.find((b) => String(b.id) === String(openBookingId));
        if (found) {
            setSelectedBooking(found);
            setShowDetails(true);
        }
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [bookings, location.state?.openBookingId]);

    const fetchBookings = async () => {
        try {
            setLoading(true);
            const response = await adminService.getBookings();
            const rows = Array.isArray(response.data?.data) ? response.data.data : (Array.isArray(response.data) ? response.data : []);
            setBookings(rows.map((b) => ({
                ...b,
                status: (b.status || '').toUpperCase(),
            })));
        } catch (error) {
            console.error("Ledger Retrieval Failure:", error);
        } finally {
            setLoading(false);
        }
    };

    const handleStatusUpdate = async (id, status) => {
        try {
            await adminService.updateBookingStatus(id, status);
            setBookings(bookings.map(b => b.id === id ? { ...b, status: String(status).toUpperCase() } : b));
            if (selectedBooking?.id === id) setSelectedBooking({ ...selectedBooking, status: String(status).toUpperCase() });
        } catch (error) {
            alert("Status synchronization failed.");
        }
    };

    const openReply = (booking) => {
        setSelectedBooking(booking);
        setReplyError('');
        setReplySubject(`Re: Booking request ${booking.booking_ref || `#${booking.id}`}`);
        setReplyMessage('');
        setShowDetails(false);
        setIsReplying(true);
    };

    const openDetails = (booking) => {
        setSelectedBooking(booking);
        setShowDetails(true);
    };

    const sendReply = async () => {
        if (!selectedBooking) return;
        setReplySending(true);
        setReplyError('');
        try {
            await adminService.replyToBooking(selectedBooking.id, {
                subject: replySubject,
                message: replyMessage,
            });
            setIsReplying(false);
            setReplySubject('');
            setReplyMessage('');
            await fetchBookings();
        } catch (e) {
            setReplyError(e.response?.data?.message || 'Unable to send email.');
        } finally {
            setReplySending(false);
        }
    };

    const handleDelete = async (id) => {
        if (!window.confirm("Delete this booking request?")) return;
        try {
            await adminService.deleteBooking(id);
            setBookings(bookings.filter(b => b.id !== id));
            setSelectedBooking(null);
        } catch (error) {
            alert("Redaction failure.");
        }
    };

    const filteredBookings = useMemo(() => {
        return bookings.filter(b => {
            const matchesSearch = (b.customer_name || '').toLowerCase().includes(searchTerm.toLowerCase()) || 
                                 (b.email || '').toLowerCase().includes(searchTerm.toLowerCase()) ||
                                 (b.booking_ref || '').toLowerCase().includes(searchTerm.toLowerCase());
            const matchesFilter = filterStatus === 'ALL' || b.status === filterStatus;
            return matchesSearch && matchesFilter;
        });
    }, [bookings, filterStatus, searchTerm]);

    if (loading) return (
        <div style={{ height: '60vh', display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'center' }}>
            <Loader2 className="animate-spin" size={48} color="var(--gold)" />
            <span style={{ marginTop: '20px', fontFamily: 'var(--font-mono)', fontSize: '0.7rem', color: 'var(--gold)', letterSpacing: '0.2em' }}>Loading bookings…</span>
        </div>
    );

    return (
        <div className="admin-page-root">
            <header style={{ marginBottom: '50px', display: 'flex', justifyContent: 'space-between', alignItems: 'flex-end' }}>
                <div>
                    <h2 style={{ fontFamily: 'var(--font-mono)', fontSize: '0.75rem', color: 'var(--gold)', letterSpacing: '0.25em', textTransform: 'uppercase', marginBottom: '12px' }}>Bookings</h2>
                    <h1 className="admin-page-title" style={{ fontSize: '3.5rem', fontWeight: 300 }}>All bookings</h1>
                </div>
                
                <div style={{ display: 'flex', gap: '15px' }}>
                    <div className="admin-search-wrapper" style={{ border: '1px solid var(--border)', background: 'rgba(255,255,255,0.02)' }}>
                        <Search size={18} color="var(--gold-dim)" />
                        <input 
                            type="text" 
                            placeholder="Search by name or email…" 
                            value={searchTerm}
                            onChange={(e) => setSearchTerm(e.target.value)}
                            style={{ background: 'transparent', border: 'none', color: 'white', padding: '12px 10px', fontFamily: 'var(--font-mono)', fontSize: '0.75rem' }}
                        />
                    </div>
                    <select 
                        value={filterStatus}
                        onChange={(e) => setFilterStatus(e.target.value)}
                        style={{ background: 'rgba(255,255,255,0.02)', border: '1px solid var(--border)', color: 'white', padding: '0 20px', fontFamily: 'var(--font-mono)', fontSize: '0.7rem' }}
                    >
                        <option value="ALL">All statuses</option>
                        <option value="NEW">NEW</option>
                        <option value="CONTACTED">CONTACTED</option>
                        <option value="CONFIRMED">CONFIRMED</option>
                        <option value="CANCELLED">CANCELLED</option>
                    </select>
                </div>
            </header>

            <div style={{ display: 'grid', gridTemplateColumns: '1fr', gap: '30px', transition: 'all 0.5s ease' }}>
                {/* ─── LEDGER TABLE ─── */}
                <div className="admin-panel shadow-premium" style={{ overflow: 'hidden' }}>
                    <div className="admin-table-container">
                        <table className="admin-table">
                            <thead>
                                <tr>
                                    <th>Customer</th>
                                    <th>Route</th>
                                    <th>Departure</th>
                                    <th>Group</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <AnimatePresence>
                                    {filteredBookings.map((booking, idx) => (
                                        <motion.tr 
                                            key={booking.id}
                                            initial={{ opacity: 0, y: 10 }}
                                            animate={{ opacity: 1, y: 0 }}
                                            transition={{ delay: idx * 0.03 }}
                                            onClick={() => openDetails(booking)}
                                            style={{ cursor: 'pointer', background: selectedBooking?.id === booking.id ? 'rgba(201,168,76,0.05)' : 'transparent' }}
                                        >
                                            <td>
                                                <div style={{ display: 'flex', flexDirection: 'column' }}>
                                                    <span style={{ fontWeight: 600, color: 'white' }}>{booking.customer_name}</span>
                                                    <span style={{ fontSize: '0.7rem', color: 'rgba(255,255,255,0.4)', fontFamily: 'var(--font-mono)' }}>{booking.email}</span>
                                                </div>
                                            </td>
                                            <td style={{ fontSize: '0.85rem' }}>
                                                {booking.safari_package?.name || booking.departure?.trekking_route?.name || 'Custom Ascent'}
                                            </td>
                                            <td>
                                                <div style={{ display: 'flex', alignItems: 'center', gap: '8px', fontSize: '0.8rem' }}>
                                                    <Calendar size={12} color="var(--gold-dim)" />
                                                    {booking.departure?.departure_date
                                                        ? new Date(booking.departure.departure_date).toLocaleDateString()
                                                        : (booking.preferred_date || '—')}
                                                </div>
                                            </td>
                                            <td style={{ fontFamily: 'var(--font-mono)', color: 'var(--text-main)' }}>
                                                {booking.group_size} pax
                                            </td>
                                            <td>
                                                <span className={`status-pill status-${booking.status.toLowerCase()}`}>
                                                    {booking.status}
                                                </span>
                                            </td>
                                            <td>
                                                <div style={{ display: 'flex', gap: '10px' }}>
                                                    <button
                                                        onClick={(e) => { e.stopPropagation(); openReply(booking); }}
                                                        style={{ background: 'none', border: 'none', color: 'var(--gold)', opacity: 0.4 }}
                                                        title="Reply by email"
                                                    ><Mail size={16} /></button>
                                                    <button 
                                                        onClick={(e) => { e.stopPropagation(); handleStatusUpdate(booking.id, 'CONFIRMED'); }}
                                                        style={{ background: 'none', border: 'none', color: '#4ade80', opacity: 0.3 }}
                                                        title="Confirm"
                                                    ><CheckCircle size={16} /></button>
                                                    <button 
                                                        onClick={(e) => { e.stopPropagation(); handleDelete(booking.id); }}
                                                        style={{ background: 'none', border: 'none', color: '#f87171', opacity: 0.3 }}
                                                        title="Delete"
                                                    ><Trash2 size={16} /></button>
                                                </div>
                                            </td>
                                        </motion.tr>
                                    ))}
                                </AnimatePresence>
                            </tbody>
                        </table>
                        {filteredBookings.length === 0 && (
                            <div style={{ padding: '100px', textAlign: 'center', color: 'var(--text-dim)' }}>
                                <Shield size={48} style={{ marginBottom: '20px', opacity: 0.1 }} />
                                <p style={{ fontFamily: 'var(--font-mono)', fontSize: '0.7rem', letterSpacing: '0.2em' }}>No matching bookings</p>
                            </div>
                        )}
                    </div>
                </div>
            </div>

            {isReplying && selectedBooking && (
                <div
                    role="dialog"
                    aria-modal="true"
                    style={{
                        position: 'fixed',
                        inset: 0,
                        background: 'rgba(0,0,0,0.6)',
                        display: 'grid',
                        placeItems: 'center',
                        zIndex: 4500,
                        padding: 20,
                    }}
                    onMouseDown={() => !replySending && setIsReplying(false)}
                >
                    <div
                        className="admin-panel shadow-premium"
                        style={{ width: 'min(820px, 96vw)', padding: 30, background: 'var(--charcoal)' }}
                        onMouseDown={(e) => e.stopPropagation()}
                    >
                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', gap: 20, marginBottom: 16 }}>
                            <div>
                                <div style={{ fontFamily: 'var(--font-mono)', fontSize: '0.65rem', color: 'var(--gold)', letterSpacing: '0.2em', textTransform: 'uppercase' }}>Reply</div>
                                <div style={{ color: 'white', marginTop: 6, fontSize: '1.2rem' }}>{selectedBooking.customer_name}</div>
                                <div style={{ color: 'var(--text-dim)', marginTop: 2, fontSize: '0.85rem' }}>{selectedBooking.email}</div>
                            </div>
                            <button onClick={() => !replySending && setIsReplying(false)} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.4)', cursor: 'pointer' }}>
                                <X size={20} />
                            </button>
                        </div>

                        {replyError && (
                            <div style={{ marginBottom: 12, padding: 12, border: '1px solid rgba(248,113,113,0.3)', background: 'rgba(248,113,113,0.08)', color: '#F87171' }}>
                                {replyError}
                            </div>
                        )}

                        <label style={{ display: 'grid', gap: 6, marginBottom: 12 }}>
                            <span style={{ fontSize: '0.7rem', color: 'var(--text-dim)' }}>Subject</span>
                            <input
                                value={replySubject}
                                onChange={(e) => setReplySubject(e.target.value)}
                                style={{ width: '100%', background: '#0a0a0a', border: '1px solid var(--border)', padding: '10px 12px', color: 'white', fontSize: '0.95rem', outline: 'none' }}
                            />
                        </label>

                        <label style={{ display: 'grid', gap: 6 }}>
                            <span style={{ fontSize: '0.7rem', color: 'var(--text-dim)' }}>Message</span>
                            <textarea
                                value={replyMessage}
                                onChange={(e) => setReplyMessage(e.target.value)}
                                rows={10}
                                style={{ width: '100%', background: '#0a0a0a', border: '1px solid var(--border)', padding: '10px 12px', color: 'white', fontSize: '0.95rem', outline: 'none', resize: 'vertical', lineHeight: 1.6 }}
                            />
                        </label>

                        <div style={{ marginTop: 16, display: 'flex', justifyContent: 'flex-end', gap: 10 }}>
                            <button className="admin-btn-secondary" disabled={replySending} onClick={() => setIsReplying(false)}>Cancel</button>
                            <button className="admin-btn-primary" disabled={replySending || !replySubject.trim() || !replyMessage.trim()} onClick={sendReply}>
                                {replySending ? <Loader2 className="animate-spin" size={16} /> : <Mail size={16} />} Send email
                            </button>
                        </div>
                    </div>
                </div>
            )}

            {showDetails && selectedBooking && (
                <div
                    role="dialog"
                    aria-modal="true"
                    style={{
                        position: 'fixed',
                        inset: 0,
                        background: 'rgba(0,0,0,0.65)',
                        display: 'grid',
                        placeItems: 'center',
                        zIndex: 3000,
                        padding: 20,
                    }}
                    onMouseDown={() => setShowDetails(false)}
                >
                    <div
                        className="admin-panel shadow-premium"
                        style={{ width: 'min(920px, 96vw)', padding: 30, background: 'var(--charcoal)', border: '1px solid var(--gold)' }}
                        onMouseDown={(e) => e.stopPropagation()}
                    >
                        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', marginBottom: 18 }}>
                            <div>
                                <h4 style={SectionHeadStyle}><Shield size={14} /> Booking details</h4>
                                <h2 style={{ fontSize: '1.4rem', color: 'white', fontWeight: 400 }}>{selectedBooking.booking_ref || `#${selectedBooking.id}`}</h2>
                            </div>
                            <button onClick={() => setShowDetails(false)} style={{ background: 'none', border: 'none', color: 'rgba(255,255,255,0.2)', cursor: 'pointer' }}><X size={24} /></button>
                        </div>

                        <div style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: 18 }}>
                            <div className="detail-section">
                                <h5 style={SubHeadStyle}>Customer</h5>
                                <div style={{ display: 'flex', flexDirection: 'column', gap: 12 }}>
                                    <div style={InfoRowStyle}><Users size={14} /><span>{selectedBooking.customer_name}</span></div>
                                    <div style={InfoRowStyle}><Mail size={14} /><span>{selectedBooking.email}</span></div>
                                    {selectedBooking.phone ? <div style={InfoRowStyle}><Phone size={14} /><span>{selectedBooking.phone}</span></div> : null}
                                </div>
                            </div>

                            <div className="detail-section">
                                <h5 style={SubHeadStyle}>Booking</h5>
                                <div style={{ display: 'flex', flexDirection: 'column', gap: 12 }}>
                                    <div style={InfoRowStyle}><Shield size={14} /><span style={{ color: 'white' }}>{selectedBooking.safari_package?.name || selectedBooking.departure?.trekking_route?.name || 'Custom booking'}</span></div>
                                    <div style={InfoRowStyle}><Calendar size={14} /><span>Departure: {selectedBooking.departure?.departure_date ? new Date(selectedBooking.departure.departure_date).toLocaleDateString() : (selectedBooking.preferred_date || 'TBD')}</span></div>
                                    <div style={InfoRowStyle}><Users size={14} /><span>Group size: {selectedBooking.group_size} pax</span></div>
                                </div>
                            </div>

                            <div className="detail-section" style={{ gridColumn: '1 / -1' }}>
                                <h5 style={SubHeadStyle}>Estimated price</h5>
                                <div style={{ background: 'rgba(0,0,0,0.3)', padding: 18, borderLeft: '3px solid var(--gold)' }}>
                                    <div style={{ display: 'flex', justifyContent: 'space-between', marginBottom: 8 }}>
                                        <span style={{ fontSize: '0.6rem', color: 'var(--text-dim)', textTransform: 'uppercase' }}>Total</span>
                                        <span style={{ color: 'white', fontFamily: 'var(--font-mono)' }}>${(((selectedBooking.total_price ?? 0) || ((selectedBooking.total_price_cents ?? 0) / 100)) || 0).toLocaleString()}</span>
                                    </div>
                                    <div style={{ display: 'flex', justifyContent: 'space-between' }}>
                                        <span style={{ fontSize: '0.6rem', color: 'var(--text-dim)', textTransform: 'uppercase' }}>Status</span>
                                        <span style={{ color: 'var(--gold)', fontFamily: 'var(--font-mono)', fontSize: '0.8rem' }}>{selectedBooking.status}</span>
                                    </div>
                                </div>
                            </div>

                            {(selectedBooking.notes || selectedBooking.special_requests) ? (
                                <div className="detail-section" style={{ gridColumn: '1 / -1' }}>
                                    <h5 style={SubHeadStyle}>Special requests</h5>
                                    <p style={{ fontSize: '0.85rem', color: 'rgba(255,255,255,0.6)', lineHeight: 1.6, background: 'rgba(255,255,255,0.02)', padding: 15 }}>
                                        "{selectedBooking.special_requests || selectedBooking.notes}"
                                    </p>
                                </div>
                            ) : null}
                        </div>

                        <div style={{ marginTop: 18, display: 'flex', justifyContent: 'space-between', flexWrap: 'wrap', gap: 10 }}>
                            <button className="admin-btn-secondary" onClick={() => openReply(selectedBooking)}>Reply</button>
                            <div style={{ display: 'flex', gap: 10 }}>
                                <button
                                    className="admin-btn-secondary"
                                    style={{ borderColor: selectedBooking.status === 'CANCELLED' ? 'var(--gold)' : 'var(--border)' }}
                                    onClick={() => handleStatusUpdate(selectedBooking.id, 'CANCELLED')}
                                >
                                    Cancel
                                </button>
                                <button
                                    className="admin-btn-primary"
                                    onClick={() => handleStatusUpdate(selectedBooking.id, 'CONFIRMED')}
                                    disabled={selectedBooking.status === 'CONFIRMED'}
                                >
                                    {selectedBooking.status === 'CONFIRMED' ? 'Confirmed' : 'Confirm'}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            )}
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
    paddingBottom: '10px',
    borderBottom: '1px solid rgba(255,255,255,0.05)',
    marginBottom: '20px'
};

const InfoRowStyle = {
    display: 'flex',
    alignItems: 'center',
    gap: '12px',
    fontSize: '0.85rem',
    color: 'rgba(255,255,255,0.6)'
};
