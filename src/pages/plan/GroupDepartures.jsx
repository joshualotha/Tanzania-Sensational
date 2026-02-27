import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import '../../styles/utility-pages-premium.css';

const departuresData = [
    { id: 1, date: "July 12 - July 20, 2026", route: "8-Day Lemosho Route", status: "Available", price: "$2,850" },
    { id: 2, date: "August 04 - August 12, 2026", route: "8-Day Lemosho Route", status: "Limited", price: "$2,850" },
    { id: 3, date: "September 15 - September 23, 2026", route: "9-Day Northern Circuit", status: "Available", price: "$3,300" },
    { id: 4, date: "October 02 - October 08, 2026", route: "7-Day Machame Route", status: "Full", price: "$2,450" },
    { id: 5, date: "December 28 - Jan 05, 2027", route: "8-Day Lemosho (NYE Summit)", status: "Limited", price: "$2,950" },
];

export const GroupDepartures = () => {
    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8 } }
    };

    return (
        <div className="utility-root">
            <section className="utility-hero">
                <div className="utility-hero-bg">
                    <img src="https://images.unsplash.com/photo-1549488344-1f9b8d2bd1f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80" alt="Group Trek" style={{ filter: 'brightness(0.6)' }} />
                </div>
                <div className="utility-hero-overlay"></div>
                <motion.div className="utility-hero-content" initial="hidden" animate="visible" variants={fadeInUp}>
                    <span className="utility-hero-eyebrow">Join The Journey</span>
                    <h1 className="utility-hero-title">Group Departures</h1>
                    <p className="utility-hero-subtitle">
                        Share the triumph. Our scheduled group climbs are capped at 12 participants to ensure a personalized, safe, and wildly successful summit bid.
                    </p>
                </motion.div>
            </section>

            <section className="utility-content">
                <motion.div className="departures-table-wrapper" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    <table className="dep-table">
                        <thead>
                            <tr>
                                <th>Dates</th>
                                <th>Route</th>
                                <th>Price (PP)</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {departuresData.map((dep) => (
                                <tr key={dep.id} className="dep-row">
                                    <td style={{ fontWeight: 600 }}>{dep.date}</td>
                                    <td>{dep.route}</td>
                                    <td style={{ fontFamily: "'Playfair Display', serif", fontSize: '1.2rem' }}>{dep.price}</td>
                                    <td>
                                        <span className={`dep-status ${dep.status.toLowerCase()}`}>{dep.status}</span>
                                    </td>
                                    <td>
                                        {dep.status !== 'Full' ? (
                                            <Link to="/contact" className="dep-btn">Enquire</Link>
                                        ) : (
                                            <span style={{ color: 'rgba(255,255,255,0.4)', fontSize: '0.8rem', textTransform: 'uppercase', letterSpacing: '0.1em' }}>Waitlist Available</span>
                                        )}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </motion.div>

                <div style={{ marginTop: '80px', textAlign: 'center', maxWidth: '700px', margin: '80px auto 0' }}>
                    <h3 style={{ fontFamily: 'Playfair Display', fontSize: '2.5rem', marginBottom: '20px' }}>Prefer a Private Trek?</h3>
                    <p style={{ color: 'rgba(255,255,255,0.7)', lineHeight: '1.6', marginBottom: '30px' }}>
                        If you have a group of 2 or more, we can arrange a private climb starting on any date of your choosing, via any route.
                    </p>
                    <Link to="/contact" className="dep-btn" style={{ padding: '15px 40px' }}>Request Private Safari</Link>
                </div>
            </section>
        </div>
    );
};
