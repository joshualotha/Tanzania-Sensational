import React from 'react';
import { Link } from '@inertiajs/react';
import { AlertTriangle, ArrowLeft } from 'lucide-react';
import { BookingEngine } from '../components/booking/BookingEngine';
import '../styles/booking-page.css';

const BookingPage = ({ type, id, pkg, pageMeta }) => {
    const backTo = type === 'safari' ? '/safaris/packages' : '/group-departures';
    const backLabel = type === 'safari' ? 'Back to safari packages' : 'Back to group departures';

    const heroImg = pageMeta?.hero_image || pkg?.hero_image || 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=2000&q=80';

    return (
        <div className="booking-page-root">
            <section className="booking-page-hero">
                <div className="booking-page-hero-bg">
                    <img src={heroImg} alt={pageMeta?.title || 'Booking'} />
                </div>
                <div className="booking-page-hero-overlay" />

                <div className="booking-page-hero-content">
                    <span className="booking-page-eyebrow">Booking</span>
                    <h1 className="booking-page-title">{pageMeta?.title || pkg?.name || pkg?.title || 'Book your expedition'}</h1>
                    <p className="booking-page-subtitle">
                        {pageMeta?.subtitle || 'Submit your booking request and we\'ll confirm details by email.'}
                    </p>

                    {(type && id) ? (
                        <div style={{ marginTop: 22 }}>
                            <Link href={backTo} style={{ display: 'inline-flex', alignItems: 'center', gap: 8, color: 'var(--gold)', textDecoration: 'none', textTransform: 'uppercase', letterSpacing: '0.14em', fontSize: '0.75rem' }}>
                                <ArrowLeft size={16} /> {backLabel}
                            </Link>
                        </div>
                    ) : null}
                </div>
            </section>

            <section className="booking-page-body">
                <div className="booking-page-container">
                    <div>
                        {(!type || !id) ? (
                            <div className="booking-page-panel">
                                <h3>Choose what you want to book</h3>
                                <p style={{ marginTop: 8 }}>
                                    Start from a trip page to book a specific departure or safari package.
                                </p>
                                <div className="booking-choice-grid">
                                    <div className="booking-choice-actions">
                                        <Link href="/group-departures" className="btn-heritage-gold booking-choice-btn" style={{ textDecoration: 'none' }}>
                                            Group departures
                                        </Link>
                                        <Link href="/safaris/packages" className="btn-heritage-gold booking-choice-btn" style={{ textDecoration: 'none' }}>
                                            Safari packages
                                        </Link>
                                    </div>
                                    <div className="booking-choice-meta">
                                        <div className="booking-choice-note">
                                            Prefer a custom request?
                                        </div>
                                        <Link href="/contact" className="booking-choice-link">
                                            General inquiry
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        ) : (
                            <BookingEngine pkg={pkg} mode="page" />
                        )}
                    </div>

                    <aside className="booking-page-sticky">
                        <div className="booking-page-panel">
                            <h3>What happens after you submit?</h3>
                            <p>
                                We confirm availability, finalize details, and send payment instructions by email. Add special requirements in your request.
                            </p>
                            <div style={{ marginTop: 14, color: 'rgba(255,255,255,0.55)', fontSize: '0.9rem', lineHeight: 1.7 }}>
                                Prefer to talk first? <Link href="/contact" style={{ color: 'var(--gold)' }}>Contact us</Link>.
                            </div>
                        </div>
                    </aside>
                </div>
            </section>
        </div>
    );
};

export default BookingPage;
