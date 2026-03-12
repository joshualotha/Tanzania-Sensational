import React, { useEffect } from 'react';
import { Calendar, Users, Map, DollarSign, ChevronRight, Mountain, Eye } from 'lucide-react';
import { departuresData } from '../../data/departuresData';
import { visualsData } from '../../data/visualsData';
import '../../styles/group-departures-premium.css';

export const GroupDepartures = () => {
    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 40 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    const staggerContainer = {
        hidden: { opacity: 1 },
        visible: {
            opacity: 1,
            transition: {
                staggerChildren: 0.1
            }
        }
    };

    return (
        <div className="utility-root">
            {/* EXPEDITION HORIZON HERO */}
            <section className="utility-hero">
                <div className="utility-hero-bg">
                    <img 
                        src={visualsData.trekking.prep.parkFeesEditorial} 
                        alt="Expedition Team" 
                    />
                </div>
                <div className="utility-hero-overlay"></div>
                <motion.div 
                    className="utility-hero-content" 
                    initial="hidden" animate="visible" variants={fadeInUp}
                >
                    <div className="heritage-type-badge">
                        <Users size={14} />
                        <span>Open Expedition</span>
                    </div>
                    <h1 className="utility-hero-title">Expedition <em>Schedule</em></h1>
                    <p className="utility-hero-subtitle">
                        Share the triumph. Our scheduled group climbs are capped at 12 participants to ensure a personalized, safe, and wildly successful summit bid.
                    </p>
                </motion.div>
            </section>

            {/* THE SCHEDULE LEDGER */}
            <section className="utility-content">
                <motion.div 
                    className="ledger-wrapper"
                    initial="hidden" whileInView="visible" viewport={{ once: true }}
                    variants={fadeInUp}
                >
                    <table className="dep-table">
                        <thead>
                            <tr>
                                <th>Dates</th>
                                <th>Route Expedition</th>
                                <th>Investment</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <motion.tbody variants={staggerContainer} initial="hidden" animate="visible">
                            {departuresData.map((dep) => (
                                <motion.tr key={dep.id} className="dep-row" variants={fadeInUp}>
                                    <td className="dep-date">
                                        {dep.date}
                                    </td>
                                    <td className="dep-route">
                                        {dep.route}
                                    </td>
                                    <td className="dep-price">
                                        <span>From</span>{dep.price}
                                    </td>
                                    <td>
                                        <span className={`dep-status ${dep.status.toLowerCase()}`}>
                                            {dep.status}
                                        </span>
                                    </td>
                                    <td>
                                        <div style={{ display: 'flex', gap: '8px', alignItems: 'center' }}>
                                            <Link to={`/group-departures/${dep.id}`} className="dep-action-btn" style={{ display: 'inline-flex', alignItems: 'center', gap: '4px' }}>
                                                Details <Eye size={12} />
                                            </Link>
                                            {dep.status !== 'Full' ? (
                                                <Link to="/contact" className="dep-action-btn" style={{ display: 'inline-flex', alignItems: 'center', gap: '4px' }}>
                                                    Enquire <ChevronRight size={12} />
                                                </Link>
                                            ) : (
                                                <span style={{ color: '#999', fontSize: '0.6rem', textTransform: 'uppercase', letterSpacing: '0.1em', fontWeight: 700 }}>
                                                    Waitlist
                                                </span>
                                            )}
                                        </div>
                                    </td>
                                </motion.tr>
                            ))}
                        </motion.tbody>
                    </table>
                </motion.div>

                {/* PRIVATE EXPEDITION CTA */}
                <motion.div 
                    className="private-exp-cta"
                    initial="hidden" whileInView="visible" viewport={{ once: true }}
                    variants={fadeInUp}
                >
                    <h3 className="private-cta-title">Private <em>Trek</em></h3>
                    <p className="private-cta-text">
                        If you have a group of 2 or more, we can arrange a private climb starting on any date of your choosing, via any route. Professional guides, dedicated crew, and absolute privacy.
                    </p>
                    <Link to="/contact" className="btn-heritage-gold">
                        Request Private Expedition
                    </Link>
                </motion.div>
            </section>
        </div>
    );
};
