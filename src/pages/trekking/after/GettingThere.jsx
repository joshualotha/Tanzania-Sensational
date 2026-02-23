import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Plane, Bus, Compass, MapPin } from 'lucide-react';
import '../../../styles/getting-there-premium.css';

const GettingThere = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.16, 1, 0.3, 1] } }
    };

    // Add staggered children animation
    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: {
            opacity: 1,
            transition: { staggerChildren: 0.15 }
        }
    };

    return (
        <div className="getting-there-root">
            {/* ─── 1. CINEMATIC HERO ─── */}
            <section className="gt-hero">
                <div className="gt-hero-bg">
                    <img
                        src="https://images.unsplash.com/photo-1516496636080-14fb876e029d?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80"
                        alt="Logistics View"
                    />
                    <div className="gt-hero-overlay"></div>
                </div>
                <div className="gt-hero-content">
                    <motion.span className="gt-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Logistical Deployment</motion.span>
                    <motion.h1 className="gt-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>The Path to <em>Moshi.</em></motion.h1>
                </div>
            </section>

            {/* ─── 2. ASYMMETRICAL EDITORIAL SECTION ─── */}
            <section className="gt-editorial-section">
                <div className="gt-editorial-grid">
                    <div className="gt-editorial-text">
                        <motion.span className="gt-eyebrow" style={{ color: 'var(--gold)', marginBottom: '15px' }} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>Deployment Logistics</motion.span>
                        <motion.h2 className="gt-section-title" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>Gateway to <em>Adventure.</em></motion.h2>

                        <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                            <p className="gt-body-text">
                                The most convenient way to reach Kilimanjaro is by flying directly into Kilimanjaro International Airport (JRO). Airlines like KLM, Kenya Airways, Ethiopian, Turkish, and Condor Airlines provide services to this gateway.
                            </p>
                            <p className="gt-body-text">
                                Upon arrival, you can get a private taxi transfer to Moshi for $50-$60 one way. Alternatively, we can arrange this seamless transfer for you, handling the final mile with professional precision so you can focus entirely on the physical and mental climb ahead.
                            </p>
                        </motion.div>
                    </div>

                    <motion.div
                        className="gt-editorial-img-wrap"
                        initial={{ opacity: 0, scale: 0.95 }}
                        whileInView={{ opacity: 1, scale: 1 }}
                        viewport={{ once: true }}
                        transition={{ duration: 1.2, ease: [0.16, 1, 0.3, 1] }}
                    >
                        <img
                            src="https://images.unsplash.com/photo-1569154941061-e231b47cb8f0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80"
                            className="gt-editorial-img"
                            alt="JRO Airport"
                        />
                        <span className="gt-img-caption">The roof of Africa awaits.</span>
                    </motion.div>
                </div>
            </section>

            {/* ─── 3. PARCHMENT INFO GRID (REGIONAL CONNECTIONS) ─── */}
            <section className="gt-pkg-section">
                <motion.div className="gt-pkg-grid" variants={staggerContainer} initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-100px" }}>

                    <motion.div className="gt-pkg-card" variants={fadeInUp}>
                        <div className="gt-card-header">
                            <div className="gt-icon-wrapper">
                                <MapPin size={32} color="var(--gold)" strokeWidth={1.5} />
                            </div>
                            <h3 className="gt-card-title">From Nairobi (NBO)</h3>
                        </div>
                        <ul className="gt-info-list">
                            <li>
                                <strong>Flight Option</strong>
                                <p>For swift access, Kenya Airways and Precision Airways offer regular flights connecting Nairobi and Kilimanjaro (JRO).</p>
                            </li>
                            <li>
                                <strong>Riverside Bus Shuttle</strong>
                                <p>This 6-hour journey costs $40 per person each way and departs daily from Nairobi at 8 AM. The shuttle stops at the border for immigration (visa required) and in Arusha for lunch.</p>
                            </li>
                            <li>
                                <strong>Private Car</strong>
                                <p>Take a private car (7-8 people for ~$500) or a mini-bus (20-25 passengers). You control the pickup time and location for a personalized experience.</p>
                            </li>
                        </ul>
                    </motion.div>

                    <motion.div className="gt-pkg-card" variants={fadeInUp}>
                        <div className="gt-card-header">
                            <div className="gt-icon-wrapper">
                                <Plane size={32} color="var(--gold)" strokeWidth={1.5} />
                            </div>
                            <h3 className="gt-card-title">Dar es Salaam to JRO</h3>
                        </div>
                        <ul className="gt-info-list">
                            <li>
                                <strong>Domestic Flight</strong>
                                <p>Swiftly bridge the distance with a domestic flight taking approximately 1 hour, costing around $240 one way.</p>
                            </li>
                            <li>
                                <strong>Bus Journey</strong>
                                <p>A cost-effective option at around $50 per person for an 8-hour one-way trip between Dar es Salaam and Moshi. Morning departures are available.</p>
                            </li>
                        </ul>
                    </motion.div>

                    <motion.div className="gt-pkg-card" variants={fadeInUp}>
                        <div className="gt-card-header">
                            <div className="gt-icon-wrapper">
                                <Compass size={32} color="var(--gold)" strokeWidth={1.5} />
                            </div>
                            <h3 className="gt-card-title">Mombasa & Zanzibar</h3>
                        </div>
                        <ul className="gt-info-list">
                            <li>
                                <strong>From Zanzibar (ZNZ)</strong>
                                <p>Domestic flights connecting Zanzibar and Kilimanjaro (JRO) are priced at approximately $240 one way per person. International flights are also accessible to/from Zanzibar.</p>
                            </li>
                            <li>
                                <strong>From Mombasa (MBA)</strong>
                                <p>Flights to and from Mombasa are available at a cost of about $150.</p>
                            </li>
                        </ul>
                    </motion.div>

                    <motion.div className="gt-pkg-card" variants={fadeInUp}>
                        <div className="gt-card-header">
                            <div className="gt-icon-wrapper">
                                <Bus size={32} color="var(--gold)" strokeWidth={1.5} />
                            </div>
                            <h3 className="gt-card-title">Travel Advisory</h3>
                        </div>
                        <ul className="gt-info-list">
                            <li>
                                <strong>Kenya Visa Notice</strong>
                                <p>For those journeying through Kenya, note that visa costs amount to at least $50 per person.</p>
                            </li>
                            <li>
                                <strong>Acclimatization Advisory</strong>
                                <p>Arrival at least one day ahead of your Kilimanjaro trek or safari is highly advised, granting essential time for rest and acclimatization.</p>
                            </li>
                        </ul>
                    </motion.div>

                </motion.div>
            </section>

            {/* ─── 4. CTA BAND ─── */}
            <section className="gt-cta-band">
                <motion.h2 className="gt-cta-title" initial={{ opacity: 0, y: 20 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    Finalize the <em>Paperwork.</em>
                </motion.h2>
                <motion.div className="gt-btn-group" initial={{ opacity: 0, y: 20 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }} transition={{ delay: 0.1 }}>
                    <Link to="/trekking/after/visa" className="gt-btn-solid">Visa Requirements</Link>
                    <Link to="/contact" className="gt-btn-outline">Arrange My Pickup</Link>
                </motion.div>
            </section>
        </div>
    );
};

export default GettingThere;
