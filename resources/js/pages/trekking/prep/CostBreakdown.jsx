import React from 'react';
import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { DollarSign, PieChart, Shield, Tent, Users, Plane, FileText, ArrowRight, Info } from 'lucide-react';
import { usePage } from '@inertiajs/react';
import '../../../styles/trekking-prep.css';

const CostBreakdown = () => {
    const { props } = usePage();
    const visuals = props.visuals;

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    const stagger = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.1 } }
    };

    const costCategories = [
        {
            icon: FileText,
            title: 'Park Fees (KINAPA)',
            amount: '$600 - $900',
            percent: '35-40%',
            desc: 'The largest single cost component. Kilimanjaro National Park charges conservation fees, camping fees, and rescue fees. These are non-negotiable and set by the Tanzania National Parks Authority (TANAPA). Longer routes incur higher fees because you spend more days in the park.',
            details: [
                'Conservation fee: ~$70/day per person',
                'Camping fee: ~$50/night per person',
                'Rescue fee: ~$20/person (one-time)',
                'Vehicle fee: ~$200/vehicle (split across group)',
            ]
        },
        {
            icon: Users,
            title: 'Guide & Porter Team',
            amount: '$400 - $700',
            percent: '20-25%',
            desc: 'Your mountain support team includes a lead guide, assistant guides, cooks, and porters. This cost covers wages, park entry for staff, food, and equipment. Ethical operators pay fair wages and provide proper gear for their team.',
            details: [
                'Lead guide: $20-30/day',
                'Assistant guide: $15-20/day',
                'Cook: $12-18/day',
                'Porters: $8-12/day each (recommend 1 porter per 2 clients)',
            ]
        },
        {
            icon: Tent,
            title: 'Camping Equipment & Logistics',
            amount: '$200 - $400',
            percent: '10-15%',
            desc: 'Includes tents, sleeping mats, mess tents, cooking equipment, and transport of all gear. Quality equipment is essential for comfort and safety at altitude.',
            details: [
                '4-season mountain tents',
                'Sleeping mats (Therm-a-Rest quality)',
                'Mess tent with tables and chairs',
                'Portable toilet (on premium climbs)',
                'Equipment transport and logistics',
            ]
        },
        {
            icon: Shield,
            title: 'Safety & Emergency Equipment',
            amount: '$100 - $200',
            percent: '5-8%',
            desc: 'Essential safety equipment including emergency oxygen, first aid kits, pulse oximeters, satellite phones, and communication devices. This is non-negotiable for a safe climb.',
            details: [
                'Emergency oxygen cylinders',
                'Comprehensive first aid kits',
                'Pulse oximeters for daily checks',
                'Satellite phone or VHF radio',
                'Emergency evacuation plan',
            ]
        },
        {
            icon: Plane,
            title: 'Transport & Transfers',
            amount: '$100 - $200',
            percent: '5-8%',
            desc: 'Airport transfers, transport to and from the mountain gate, and any internal flights if combining with a safari. Most operators include Kilimanjaro International Airport (JRO) transfers.',
            details: [
                'JRO airport pickup and drop-off',
                'Transfer to Londorossi/Lemosho gate',
                'Transfer from Marangu/Mweka gate',
                'Hotel night before and after climb',
            ]
        },
        {
            icon: DollarSign,
            title: 'Food, Water & Supplies',
            amount: '$150 - $300',
            percent: '8-12%',
            desc: 'All meals on the mountain, drinking water, snacks, and cooking fuel. Quality nutrition is critical for altitude performance. Reputable operators provide plentiful, varied meals.',
            details: [
                '3 meals per day plus snacks',
                '4+ litres of drinking water per day',
                'Hot drinks (tea, coffee, cocoa)',
                'Fresh fruits and vegetables',
                'Cooking fuel and supplies',
            ]
        },
    ];

    const routeCosts = [
        { route: 'Marangu (5 days)', range: '$1,800 - $2,500', success: '50-70%', best: 'Budget-conscious, hut accommodation' },
        { route: 'Machame (6 days)', range: '$2,000 - $3,000', success: '75-85%', best: 'Popular, great scenery' },
        { route: 'Lemosho (7 days)', range: '$2,500 - $3,800', success: '90-95%', best: 'Best acclimatisation, high success' },
        { route: 'Rongai (6 days)', range: '$2,200 - $3,200', success: '80-85%', best: 'Dry season, northern approach' },
        { route: 'Northern Circuit (9 days)', range: '$3,500 - $5,000', success: '95%+', best: 'Maximum acclimatisation, remote' },
        { route: 'Umbwe (5 days)', range: '$1,800 - $2,500', success: '50-65%', best: 'Experienced trekkers, challenge' },
    ];

    return (
        <div className="prep-savanna-root">
            {/* ─── HERO ─── */}
            <section className="prep-hero">
                <div className="prep-hero-bg">
                    <img
                        src={visuals.getSingle('trekking.prep.costBreakdown', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=1600')}
                        alt="Kilimanjaro climb cost breakdown — park fees, guide costs, and equipment expenses explained"
                    />
                    <div className="prep-hero-overlay"></div>
                </div>
                <div className="prep-hero-content">
                    <motion.span className="prep-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Financial Planning</motion.span>
                    <motion.h1 className="prep-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>Kilimanjaro <em>Cost Breakdown</em></motion.h1>
                    <motion.p className="prep-hero-sub" initial="hidden" animate="visible" variants={fadeInUp}>
                        Understand exactly where your money goes — from park fees to porter wages — so you can budget with confidence.
                    </motion.p>
                </div>
            </section>

            {/* ─── INTRO ─── */}
            <section className="prep-section">
                <div className="prep-container prep-container-narrow">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <h2 className="prep-heading">What Does It Cost to Climb Kilimanjaro?</h2>
                        <p className="prep-body">
                            A Kilimanjaro climb typically costs between <strong>$2,000 and $5,000</strong> per person, depending on the route, duration, group size, and level of service. The wide range reflects real differences in what is included — from basic budget climbs to premium expeditions with private toilets, gourmet meals, and the best equipment.
                        </p>
                        <p className="prep-body">
                            <strong>Important:</strong> If a price seems too good to be true (under $1,500 for a 7-day climb), it almost certainly is. Extremely low prices usually mean corners are being cut on safety equipment, porter welfare, food quality, or guide qualifications. Your safety and experience depend on choosing an operator who charges a fair price for a quality service.
                        </p>
                    </motion.div>
                </div>
            </section>

            {/* ─── COST BREAKDOWN ─── */}
            <section className="prep-section prep-section-alt">
                <div className="prep-container">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <span className="prep-eyebrow">Where Your Money Goes</span>
                        <h2 className="prep-heading">Cost Component Breakdown</h2>
                        <p className="prep-body prep-body-center">
                            Here is how a typical $3,000 Kilimanjaro climb is allocated across different cost components.
                        </p>
                    </motion.div>

                    <motion.div 
                        className="prep-grid prep-grid-3"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={stagger}
                    >
                        {costCategories.map((cat, i) => (
                            <motion.div key={i} className="prep-card" variants={fadeInUp}>
                                <div className="prep-card-icon">
                                    <cat.icon size={28} />
                                </div>
                                <h3 className="prep-card-title">{cat.title}</h3>
                                <div className="prep-card-meta">
                                    <span className="prep-card-amount">{cat.amount}</span>
                                    <span className="prep-card-percent">{cat.percent} of total</span>
                                </div>
                                <p className="prep-card-desc">{cat.desc}</p>
                                <ul className="prep-card-list">
                                    {cat.details.map((d, j) => (
                                        <li key={j}>{d}</li>
                                    ))}
                                </ul>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* ─── ROUTE COST COMPARISON ─── */}
            <section className="prep-section">
                <div className="prep-container">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <span className="prep-eyebrow">Route Comparison</span>
                        <h2 className="prep-heading">Cost by Route</h2>
                        <p className="prep-body prep-body-center">
                            Longer routes cost more because you spend additional days in the park (paying daily fees) and require more support staff. However, they also offer significantly higher summit success rates.
                        </p>
                    </motion.div>

                    <motion.div 
                        className="prep-table-wrap"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={fadeInUp}
                    >
                        <table className="prep-table">
                            <thead>
                                <tr>
                                    <th>Route</th>
                                    <th>Price Range (per person)</th>
                                    <th>Success Rate</th>
                                    <th>Best For</th>
                                </tr>
                            </thead>
                            <tbody>
                                {routeCosts.map((r, i) => (
                                    <tr key={i}>
                                        <td><Link href={`/trekking/kilimanjaro/${r.route.split(' ')[0].toLowerCase()}`}>{r.route}</Link></td>
                                        <td>{r.range}</td>
                                        <td>{r.success}</td>
                                        <td>{r.best}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </motion.div>
                </div>
            </section>

            {/* ─── ADDITIONAL COSTS ─── */}
            <section className="prep-section prep-section-alt">
                <div className="prep-container prep-container-narrow">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <span className="prep-eyebrow">Budget Planning</span>
                        <h2 className="prep-heading">Additional Costs to Budget For</h2>
                    </motion.div>

                    <motion.div 
                        className="prep-list"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={stagger}
                    >
                        {[
                            { title: 'International Flights', amount: '$800 - $1,500', desc: 'Round-trip to Kilimanjaro International Airport (JRO). Prices vary by departure city and season. Book 3-6 months ahead for best rates.' },
                            { title: 'Travel Insurance', amount: '$100 - $300', desc: 'Must cover high-altitude trekking (to 6,000m) and emergency evacuation including helicopter rescue. This is mandatory for all reputable operators.' },
                            { title: 'Visa', amount: '$50 - $100', desc: 'Tanzania visa on arrival ($50 USD single entry) or e-Visa (same price, apply online before travel). See our visa guide for details.' },
                            { title: 'Tips for Crew', amount: '$200 - $350', desc: 'Tipping your guide, assistant guides, cook, and porters is customary and expected. Budget approximately $200-350 total for your support team.' },
                            { title: 'Personal Gear & Clothing', amount: '$200 - $800', desc: 'If you need to purchase gear (boots, sleeping bag, jacket, layers), budget accordingly. Many items can be rented in Moshi for $50-100 total.' },
                            { title: 'Accommodation (Pre/Post Climb)', amount: '$100 - $300', desc: 'Most packages include 1-2 nights hotel in Moshi. Additional nights, upgrades, or luxury options cost extra.' },
                        ].map((item, i) => (
                            <motion.div key={i} className="prep-list-item" variants={fadeInUp}>
                                <div className="prep-list-icon">
                                    <DollarSign size={24} />
                                </div>
                                <div className="prep-list-content">
                                    <div className="prep-list-header">
                                        <h3>{item.title}</h3>
                                        <span className="prep-list-amount">{item.amount}</span>
                                    </div>
                                    <p>{item.desc}</p>
                                </div>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* ─── SAVING TIPS ─── */}
            <section className="prep-section">
                <div className="prep-container prep-container-narrow">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <span className="prep-eyebrow">Smart Budgeting</span>
                        <h2 className="prep-heading">How to Save Without Compromising Safety</h2>
                    </motion.div>

                    <motion.div 
                        className="prep-tips"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={stagger}
                    >
                        {[
                            { title: 'Join a Group Departure', desc: 'Group departures split fixed costs (guide team, equipment transport, park vehicle fees) across more people, reducing the per-person price by 15-25%.' },
                            { title: 'Choose a 6-7 Day Route', desc: 'While 5-day routes are cheaper, they have significantly lower success rates. The extra 1-2 days on a 7-day Lemosho or 6-day Machame dramatically improve your summit odds.' },
                            { title: 'Travel in Shoulder Season', desc: 'January-February and September-October offer excellent weather with slightly lower demand and prices than the peak June-August window.' },
                            { title: 'Rent Gear in Moshi', desc: 'Instead of buying expensive cold-weather gear you may never use again, rent quality equipment in Moshi for a fraction of the purchase price.' },
                            { title: 'Book Early for Best Rates', desc: 'Many operators offer early-bird discounts for bookings made 6+ months in advance. You also get your preferred departure date.' },
                        ].map((tip, i) => (
                            <motion.div key={i} className="prep-tip-item" variants={fadeInUp}>
                                <div className="prep-tip-num">{i + 1}</div>
                                <div className="prep-tip-content">
                                    <h3>{tip.title}</h3>
                                    <p>{tip.desc}</p>
                                </div>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* ─── CTA ─── */}
            <section className="prep-section prep-section-cta">
                <div className="prep-container prep-container-narrow">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <h2 className="prep-heading prep-heading-light">Ready to Plan Your Climb?</h2>
                        <p className="prep-body prep-body-light">
                            We offer transparent, all-inclusive pricing with no hidden fees. Browse our group departures for the best value, 
                            or contact us for a custom private expedition quote.
                        </p>
                        <div className="prep-cta-actions">
                            <Link href="/group-departures" className="prep-btn prep-btn-primary">
                                View Group Departures <ArrowRight size={16} />
                            </Link>
                            <Link href="/contact" className="prep-btn prep-btn-outline">
                                Request a Quote
                            </Link>
                        </div>
                    </motion.div>
                </div>
            </section>
        </div>
    );
};

export default CostBreakdown;
