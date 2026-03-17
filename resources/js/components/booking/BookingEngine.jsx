import React, { useState, useEffect } from 'react';
import { X, ArrowRight, ArrowLeft, Check, Loader2, AlertCircle, Calendar, Users, Mail } from 'lucide-react';
import { bookingService } from '../../services/api';
import '../../styles/booking-engine.css';

const STEPS = ['Details', 'Review'];

export const BookingEngine = ({ pkg, onClose, mode = 'modal' }) => {
    const [step, setStep] = useState(0);
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [success, setSuccess] = useState(null);
    const [error, setError] = useState(null);

    const [formData, setFormData] = useState({
        customer_name: '',
        email: '',
        phone: '',
        country: '',
        group_size: 1,
        preferred_date: '',
        special_requests: '',
    });

    const isModal = mode === 'modal';

    // Lock body scrolling when modal is open
    useEffect(() => {
        if (!isModal) return;
        document.body.style.overflow = 'hidden';
        return () => { document.body.style.overflow = ''; };
    }, [isModal]);

    const isDepartureBooking = Boolean(pkg?.departure_id);
    const isSafariBooking = Boolean(pkg?.id) && !isDepartureBooking;

    const handleChange = (field, value) => {
        setFormData(prev => ({ ...prev, [field]: value }));
        setError(null);
    };

    const canAdvance = () => {
        if (step === 0) return formData.customer_name.trim() !== '' && formData.email.trim() !== '' && formData.group_size >= 1;
        if (!isDepartureBooking) return formData.preferred_date !== '';
        return true;
    };

    const handleNext = () => {
        if (!canAdvance()) {
            setError('Please fill in all required fields.');
            return;
        }
        setError(null);
        setStep(prev => Math.min(prev + 1, 1));
    };

    const handleBack = () => {
        setError(null);
        setStep(prev => Math.max(prev - 1, 0));
    };

    const handleSubmit = async () => {
        setError(null);
        setIsSubmitting(true);
        try {
            const response = isDepartureBooking
                ? await bookingService.create({
                    departure_id: pkg.departure_id,
                    customer_name: formData.customer_name,
                    email: formData.email,
                    phone: formData.phone || null,
                    country: formData.country || null,
                    group_size: Number(formData.group_size),
                    special_requests: formData.special_requests || null,
                })
                : await bookingService.createSafariBooking({
                    safari_package_id: pkg.id,
                    customer_name: formData.customer_name,
                    email: formData.email,
                    phone: formData.phone || null,
                    country: formData.country || null,
                    group_size: Number(formData.group_size),
                    preferred_date: formData.preferred_date,
                    special_requests: formData.special_requests || null,
                });
            setSuccess(response.data);
        } catch (err) {
            const msg = err.response?.data?.message || 'Booking failed. Please try again or contact us.';
            setError(msg);
        } finally {
            setIsSubmitting(false);
        }
    };

    // ─── SUCCESS SCREEN ───
    if (success) {
        const remainingSeats = success?.booking?.departure?.remaining_seats;
        const heldSeats = success?.booking?.held_seats;
        if (!isModal) {
            return (
                <div className="booking-modal booking-page-card">
                    <div className="booking-success">
                        <div className="booking-success-icon">
                            <Check size={36} />
                        </div>
                        <h2 className="booking-success-title">Request received</h2>
                        <div className="booking-success-ref">{success.booking_ref}</div>
                        <p className="booking-success-text">
                            {success.message}
                        </p>
                        {isDepartureBooking && typeof remainingSeats === 'number' ? (
                            <div style={{ marginTop: 12, color: 'rgba(255,255,255,0.7)', fontSize: '0.9rem' }}>
                                Seats are now on hold for your request{typeof heldSeats === 'number' && heldSeats > 0 ? ` (${heldSeats} seat${heldSeats === 1 ? '' : 's'})` : ''}. Remaining spots: <strong style={{ color: 'white' }}>{remainingSeats}</strong>.
                            </div>
                        ) : null}
                        <a className="booking-success-btn" href="/contact">
                            Contact us
                        </a>
                    </div>
                </div>
            );
        }

        return (
            <div className="booking-overlay" onClick={onClose}>
                <div className="booking-modal" onClick={e => e.stopPropagation()}>
                    <button className="booking-close" onClick={onClose}><X size={18} /></button>
                    <div className="booking-success">
                        <div className="booking-success-icon">
                            <Check size={36} />
                        </div>
                        <h2 className="booking-success-title">Request received</h2>
                        <div className="booking-success-ref">{success.booking_ref}</div>
                        <p className="booking-success-text">
                            {success.message}
                        </p>
                        <button className="booking-success-btn" onClick={onClose}>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        );
    }

    if (!isModal) {
        return (
            <div className="booking-modal booking-page-card">
                {/* ─── HEADER ─── */}
                <div className="booking-header">
                    <span className="booking-header-eyebrow">Booking request</span>
                    <h2 className="booking-header-title">{pkg.name || pkg.title}</h2>
                    <div className="booking-header-meta">
                        {pkg.duration ? `${pkg.duration} Days` : ''}{pkg.meta_tag ? ` · ${pkg.meta_tag}` : ''}
                    </div>
                    {isDepartureBooking && pkg.departure_date && (
                        <div className="booking-price-strip">
                            <span className="booking-price-from">Departure</span>
                            <span className="booking-price-amount">{new Date(pkg.departure_date).toLocaleDateString()}</span>
                            <span className="booking-price-pp">Group departure</span>
                        </div>
                    )}
                </div>

                {/* ─── STEPPER ─── */}
                <div className="booking-stepper">
                    {STEPS.map((label, i) => (
                        <div
                            key={label}
                            className={`booking-step-indicator ${i === step ? 'active' : ''} ${i < step ? 'completed' : ''}`}
                        >
                            {i < step ? <Check size={12} style={{ marginRight: 6, verticalAlign: 'middle' }} /> : null}
                            {label}
                        </div>
                    ))}
                </div>

                {/* ─── BODY ─── */}
                <div className="booking-body">
                    {error && (
                        <div className="booking-error">
                            <AlertCircle size={16} /> {error}
                        </div>
                    )}

                    {/* STEP 0: Contact + group size */}
                    {step === 0 && (
                        <div className="booking-form-section">
                            <div className="booking-form-label">Your details</div>
                            <div className="booking-form-grid">
                                <div className="booking-input-group full-width">
                                    <label className="booking-input-label">Full Name *</label>
                                    <input
                                        type="text"
                                        className="booking-input"
                                        placeholder="John Smith"
                                        value={formData.customer_name}
                                        onChange={e => handleChange('customer_name', e.target.value)}
                                    />
                                </div>
                                <div className="booking-input-group">
                                    <label className="booking-input-label">Email *</label>
                                    <input
                                        type="email"
                                        className="booking-input"
                                        placeholder="name@domain.com"
                                        value={formData.email}
                                        onChange={e => handleChange('email', e.target.value)}
                                    />
                                </div>
                                <div className="booking-input-group">
                                    <label className="booking-input-label">Phone</label>
                                    <input
                                        type="tel"
                                        className="booking-input"
                                        placeholder="+1 555 000 0000"
                                        value={formData.phone}
                                        onChange={e => handleChange('phone', e.target.value)}
                                    />
                                </div>
                                <div className="booking-input-group full-width">
                                    <label className="booking-input-label">Country</label>
                                    <input
                                        type="text"
                                        className="booking-input"
                                        placeholder="e.g. United States"
                                        value={formData.country}
                                        onChange={e => handleChange('country', e.target.value)}
                                    />
                                </div>
                                {!isDepartureBooking && (
                                    <div className="booking-input-group full-width">
                                        <label className="booking-input-label">Preferred Travel Date *</label>
                                        <input
                                            type="date"
                                            className="booking-input"
                                            value={formData.preferred_date}
                                            onChange={e => handleChange('preferred_date', e.target.value)}
                                            min={new Date(Date.now() + 14 * 86400000).toISOString().split('T')[0]}
                                        />
                                    </div>
                                )}
                                <div className="booking-input-group full-width">
                                    <label className="booking-input-label">Group Size *</label>
                                    <input
                                        type="number"
                                        min={1}
                                        max={20}
                                        className="booking-input"
                                        value={formData.group_size}
                                        onChange={e => handleChange('group_size', e.target.value)}
                                    />
                                </div>
                                <div className="booking-input-group full-width">
                                    <label className="booking-input-label">Special Requests</label>
                                    <textarea
                                        className="booking-textarea"
                                        placeholder="Dietary requirements, mobility considerations, etc."
                                        value={formData.special_requests}
                                        onChange={e => handleChange('special_requests', e.target.value)}
                                    />
                                </div>
                            </div>
                        </div>
                    )}

                    {/* STEP 1: Review */}
                    {step === 1 && (
                        <div className="booking-form-section">
                            <div className="booking-form-label">
                                <Mail size={14} style={{ verticalAlign: 'middle', marginRight: 8 }} />
                                Review your request
                            </div>

                            <div className="booking-price-summary">
                                <div className="price-line">
                                    <span className="price-line-label">Trip</span>
                                    <span>{pkg.name || pkg.title}</span>
                                </div>
                                <div className="price-line">
                                    <span className="price-line-label">Departure</span>
                                    <span>{isDepartureBooking && pkg.departure_date ? new Date(pkg.departure_date).toLocaleDateString() : formData.preferred_date}</span>
                                </div>
                                <div className="price-line">
                                    <span className="price-line-label">Name</span>
                                    <span>{formData.customer_name}</span>
                                </div>
                                <div className="price-line">
                                    <span className="price-line-label">Email</span>
                                    <span>{formData.email}</span>
                                </div>
                                <div className="price-line">
                                    <span className="price-line-label">Group size</span>
                                    <span>{formData.group_size} pax</span>
                                </div>
                                {formData.special_requests && (
                                    <div className="price-line">
                                        <span className="price-line-label">Requests</span>
                                        <span style={{ maxWidth: 300, textAlign: 'right' }}>{formData.special_requests}</span>
                                    </div>
                                )}
                            </div>

                            <p style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.35)', lineHeight: 1.7, fontFamily: "'Outfit', sans-serif" }}>
                                No payment is collected online. After you submit, our team will email you to confirm details and arrange payment.
                            </p>
                        </div>
                    )}
                </div>

                {/* ─── ACTIONS ─── */}
                <div className="booking-actions">
                    {step > 0 && (
                        <button className="booking-btn-back" onClick={handleBack}>
                            <ArrowLeft size={14} style={{ marginRight: 6, verticalAlign: 'middle' }} />
                            Back
                        </button>
                    )}

                    {step < 1 ? (
                        <button
                            className="booking-btn-next"
                            onClick={handleNext}
                            disabled={!canAdvance()}
                        >
                            Continue
                            <ArrowRight size={14} />
                        </button>
                    ) : (
                        <button
                            className="booking-btn-next"
                            onClick={handleSubmit}
                            disabled={isSubmitting}
                        >
                            {isSubmitting ? (
                                <>
                                    <Loader2 size={16} className="booking-spin" />
                                    Submitting...
                                </>
                            ) : (
                                <>
                                    Submit request
                                    <Check size={14} />
                                </>
                            )}
                        </button>
                    )}
                </div>
            </div>
        );
    }

    return (
        <div className="booking-overlay" onClick={onClose}>
            <div className="booking-modal" onClick={e => e.stopPropagation()}>
                <button className="booking-close" onClick={onClose}><X size={18} /></button>

                {/* ─── HEADER ─── */}
                <div className="booking-header">
                    <span className="booking-header-eyebrow">Booking request</span>
                    <h2 className="booking-header-title">{pkg.name || pkg.title}</h2>
                    <div className="booking-header-meta">
                        {pkg.duration ? `${pkg.duration} Days` : ''}{pkg.meta_tag ? ` · ${pkg.meta_tag}` : ''}
                    </div>
                    {isDepartureBooking && pkg.departure_date && (
                        <div className="booking-price-strip">
                            <span className="booking-price-from">Departure</span>
                            <span className="booking-price-amount">{new Date(pkg.departure_date).toLocaleDateString()}</span>
                            <span className="booking-price-pp">Group departure</span>
                        </div>
                    )}
                </div>

                {/* ─── STEPPER ─── */}
                <div className="booking-stepper">
                    {STEPS.map((label, i) => (
                        <div
                            key={label}
                            className={`booking-step-indicator ${i === step ? 'active' : ''} ${i < step ? 'completed' : ''}`}
                        >
                            {i < step ? <Check size={12} style={{ marginRight: 6, verticalAlign: 'middle' }} /> : null}
                            {label}
                        </div>
                    ))}
                </div>

                {/* ─── BODY ─── */}
                <div className="booking-body">
                    {error && (
                        <div className="booking-error">
                            <AlertCircle size={16} /> {error}
                        </div>
                    )}

                    {/* STEP 0: Contact + group size */}
                    {step === 0 && (
                        <div className="booking-form-section">
                            <div className="booking-form-label">Your details</div>
                            <div className="booking-form-grid">
                                <div className="booking-input-group full-width">
                                    <label className="booking-input-label">Full Name *</label>
                                    <input
                                        type="text"
                                        className="booking-input"
                                        placeholder="John Smith"
                                        value={formData.customer_name}
                                        onChange={e => handleChange('customer_name', e.target.value)}
                                    />
                                </div>
                                <div className="booking-input-group">
                                    <label className="booking-input-label">Email *</label>
                                    <input
                                        type="email"
                                        className="booking-input"
                                        placeholder="name@domain.com"
                                        value={formData.email}
                                        onChange={e => handleChange('email', e.target.value)}
                                    />
                                </div>
                                <div className="booking-input-group">
                                    <label className="booking-input-label">Phone</label>
                                    <input
                                        type="tel"
                                        className="booking-input"
                                        placeholder="+1 555 000 0000"
                                        value={formData.phone}
                                        onChange={e => handleChange('phone', e.target.value)}
                                    />
                                </div>
                                <div className="booking-input-group full-width">
                                    <label className="booking-input-label">Country</label>
                                    <input
                                        type="text"
                                        className="booking-input"
                                        placeholder="e.g. United States"
                                        value={formData.country}
                                        onChange={e => handleChange('country', e.target.value)}
                                    />
                                </div>
                                {!isDepartureBooking && (
                                    <div className="booking-input-group full-width">
                                        <label className="booking-input-label">Preferred Travel Date *</label>
                                        <input
                                            type="date"
                                            className="booking-input"
                                            value={formData.preferred_date}
                                            onChange={e => handleChange('preferred_date', e.target.value)}
                                            min={new Date(Date.now() + 14 * 86400000).toISOString().split('T')[0]}
                                        />
                                    </div>
                                )}
                                <div className="booking-input-group full-width">
                                    <label className="booking-input-label">Group Size *</label>
                                    <input
                                        type="number"
                                        min={1}
                                        max={20}
                                        className="booking-input"
                                        value={formData.group_size}
                                        onChange={e => handleChange('group_size', e.target.value)}
                                    />
                                </div>
                                <div className="booking-input-group full-width">
                                    <label className="booking-input-label">Special Requests</label>
                                    <textarea
                                        className="booking-textarea"
                                        placeholder="Dietary requirements, mobility considerations, etc."
                                        value={formData.special_requests}
                                        onChange={e => handleChange('special_requests', e.target.value)}
                                    />
                                </div>
                            </div>
                        </div>
                    )}

                    {/* STEP 1: Review */}
                    {step === 1 && (
                        <div className="booking-form-section">
                            <div className="booking-form-label">
                                <Mail size={14} style={{ verticalAlign: 'middle', marginRight: 8 }} />
                                Review your request
                            </div>

                            <div className="booking-price-summary">
                                <div className="price-line">
                                    <span className="price-line-label">Trip</span>
                                    <span>{pkg.name || pkg.title}</span>
                                </div>
                                <div className="price-line">
                                    <span className="price-line-label">Departure</span>
                                    <span>{isDepartureBooking && pkg.departure_date ? new Date(pkg.departure_date).toLocaleDateString() : formData.preferred_date}</span>
                                </div>
                                <div className="price-line">
                                    <span className="price-line-label">Name</span>
                                    <span>{formData.customer_name}</span>
                                </div>
                                <div className="price-line">
                                    <span className="price-line-label">Email</span>
                                    <span>{formData.email}</span>
                                </div>
                                <div className="price-line">
                                    <span className="price-line-label">Group size</span>
                                    <span>{formData.group_size} pax</span>
                                </div>
                                {formData.special_requests && (
                                    <div className="price-line">
                                        <span className="price-line-label">Requests</span>
                                        <span style={{ maxWidth: 300, textAlign: 'right' }}>{formData.special_requests}</span>
                                    </div>
                                )}
                            </div>

                            <p style={{ fontSize: '0.75rem', color: 'rgba(255,255,255,0.35)', lineHeight: 1.7, fontFamily: "'Outfit', sans-serif" }}>
                                No payment is collected online. After you submit, our team will email you to confirm details and arrange payment.
                            </p>
                        </div>
                    )}
                </div>

                {/* ─── ACTIONS ─── */}
                <div className="booking-actions">
                    {step > 0 && (
                        <button className="booking-btn-back" onClick={handleBack}>
                            <ArrowLeft size={14} style={{ marginRight: 6, verticalAlign: 'middle' }} />
                            Back
                        </button>
                    )}
                    
                    {step < 1 ? (
                        <button 
                            className="booking-btn-next" 
                            onClick={handleNext}
                            disabled={!canAdvance()}
                        >
                            Continue
                            <ArrowRight size={14} />
                        </button>
                    ) : (
                        <button 
                            className="booking-btn-next" 
                            onClick={handleSubmit}
                            disabled={isSubmitting}
                        >
                            {isSubmitting ? (
                                <>
                                    <Loader2 size={16} className="booking-spin" />
                                    Submitting...
                                </>
                            ) : (
                                <>
                                    Submit request
                                    <Check size={14} />
                                </>
                            )}
                        </button>
                    )}
                </div>
            </div>
        </div>
    );
};
