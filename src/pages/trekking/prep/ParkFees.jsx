import React, { useEffect } from 'react';
import { Link } from 'react-router-dom';
import { Wallet, PieChart, Info, FileText, CheckCircle } from 'lucide-react';
import { visualsData } from '../../../data/visualsData';
import '../../../styles/utility-pages-premium.css';

const ParkFees = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    return (
        <div className="prep-savanna-root">
            {/* ─── HERO ─── */}
            <section className="prep-hero">
                <div className="prep-hero-bg">
                    <img
                        src={visualsData.trekking.prep.parkFeesHero}
                        alt="Serengeti Plains"
                    />
                    <div className="prep-hero-overlay"></div>
                </div>
                <div className="prep-hero-content">
                    <motion.span className="prep-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Financial Transparency</motion.span>
                    <motion.h1 className="prep-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>Park <em>Fees.</em></motion.h1>
                </div>
            </section>

            {/* ─── EDITORIAL CONTENT ─── */}
            <section className="prep-grid-section">
                <div className="prep-editorial-grid">
                    <motion.div
                        className="prep-editorial-img-wrap"
                        initial={{ opacity: 0, x: -50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        viewport={{ once: true }}
                        transition={{ duration: 1 }}
                    >
                        <img
                            src={visualsData.trekking.prep.parkFeesEditorial}
                            className="prep-editorial-img"
                            alt="The Mountain"
                        />
                        <span className="prep-img-caption">Protecting Tanzania's Heritage</span>
                    </motion.div>
                    <div className="prep-editorial-text">
                        <motion.span className="prep-eyebrow" initial="hidden" whileInView="visible" variants={fadeInUp}>The Cost of Conservation</motion.span>
                        <h2 className="prep-section-title">Deconstructing <em>Pricing.</em></h2>
                        <p className="prep-body-text">
                            A significant portion of your expedition cost does not go to the operator or the crew—it goes directly to the Tanzanian government as mandatory Park Fees. These fees are vital; they safeguard and maintain the integrity of Kilimanjaro National Park.
                        </p>
                        <p className="prep-body-text">
                            You cannot pay these fees directly to KINAPA. Only registered tour operators can process them. To provide complete transparency, here is the exact breakdown of the $800+ you pay simply to step foot on the mountain.
                        </p>
                    </div>
                </div>
            </section>

            {/* ─── PARK FEES BREAKDOWN ─── */}
            <section className="prep-info-grid">
                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true }}>
                    <div className="prep-info-card-header">
                        <PieChart size={32} color="var(--savanna-gold)" />
                        <h3 className="prep-info-card-title">The 6 Components</h3>
                    </div>
                    <ul className="prep-info-list" style={{ paddingRight: '10px' }}>
                        <li style={{ display: 'block', paddingBottom: '10px' }}><strong style={{ color: 'var(--savanna-gold)' }}>1. Conservation Fees: </strong> $70 per trekker per day. A 7-day trek incurs $490.</li>
                        <li style={{ display: 'block', paddingBottom: '10px' }}><strong style={{ color: 'var(--savanna-gold)' }}>2. Camping Fees: </strong> $50 per trekker per night (all routes except Marangu). A 7-day trek (6 nights) incurs $300.</li>
                        <li style={{ display: 'block', paddingBottom: '10px' }}><strong style={{ color: 'var(--savanna-gold)' }}>3. Hut Fees: </strong> $60 per trekker per night (Marangu route only).</li>
                        <li style={{ display: 'block', paddingBottom: '10px' }}><strong style={{ color: 'var(--savanna-gold)' }}>4. Rescue Fees: </strong> $20 per trekker per trip. Mandatory regardless of use.</li>
                        <li style={{ display: 'block', paddingBottom: '10px' }}><strong style={{ color: 'var(--savanna-gold)' }}>5. Crater Camping: </strong> Optional extra fee of $100 per trekker per night for crater sleepers.</li>
                        <li style={{ display: 'block' }}><strong style={{ color: 'var(--savanna-gold)' }}>6. Crew Entrance: </strong> $2 per support crew member per trip.</li>
                    </ul>
                </motion.div>

                <motion.div className="prep-info-card" initial={{ opacity: 0, y: 30 }} whileInView={{ opacity: 1, y: 0 }} viewport={{ once: true, delay: 0.1 }}>
                    <div className="prep-info-card-header">
                        <Wallet size={32} color="var(--savanna-gold)" />
                        <h3 className="prep-info-card-title">Total Fee Examples</h3>
                    </div>
                    <p className="prep-body-text" style={{ fontSize: '1rem', marginTop: '-10px', marginBottom: '10px' }}>
                        These exact totals include the Tanzanian government's 18% Value Added Tax (VAT) introduced in 2016. <br />These numbers are <em>just the park fees</em>—they exclude crew wages, food, transport, and equipment.
                    </p>
                    <ul className="prep-info-list">
                        <li><span>Marangu 6 days</span> <span>USD 873.20</span></li>
                        <li><span>Machame 6 days</span> <span>USD 814.20</span></li>
                        <li><span>Machame 7 days</span> <span>USD 955.80</span></li>
                        <li><span>Lemosho 7 days</span> <span>USD 955.80</span></li>
                        <li><span>Lemosho 8 days</span> <span style={{ color: 'var(--savanna-gold)', fontWeight: 'bold' }}>USD 1097.40</span></li>
                        <li><span>Rongai 7 days</span> <span>USD 955.80</span></li>
                        <li><span>Umbwe 6 days</span> <span>USD 814.20</span></li>
                    </ul>
                </motion.div>
            </section>

            <motion.div className="prep-highlight-box" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} viewport={{ once: true }}>
                <h3 className="prep-highlight-title">Direct Payment and Discounts</h3>
                <p className="prep-highlight-text">
                    You cannot directly pay park fees to KINAPA. Only registered tour operators can process park fee payments. All Kilimanjaro operators include the Park Fee in their total tour cost. Discounts are available for children under 16, and substantial discounts apply to Tanzanian Residents, Ex-Pats, and East African Citizens.
                </p>
            </motion.div>

            {/* ─── CTA BAND ─── */}
            <section className="prep-cta-band">
                <motion.h2 className="prep-cta-title" initial="hidden" whileInView="visible" variants={fadeInUp}>Clarity at Every <em>Step.</em></motion.h2>
                <div className="prep-btn-group">
                    <Link to="/contact" className="prep-btn-sand">Get a Custom Quote</Link>
                    <Link to="/about" className="prep-btn-outline">Why Experience Matters</Link>
                </div>
            </section>
        </div>
    );
};

export default ParkFees;
