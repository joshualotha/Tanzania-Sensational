import React from 'react';
import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { Shield, Search, DollarSign, Users, FileText, CheckCircle, XCircle, ArrowRight } from 'lucide-react';
import { usePage } from '@inertiajs/react';
import '../../../styles/trekking-prep.css';

const ChooseOperator = () => {
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

    const greenFlags = [
        { icon: Shield, title: 'KINAPA Licensed', desc: 'All legitimate Kilimanjaro operators must hold a valid license from Kilimanjaro National Park. Ask for their license number and verify it with KINAPA directly.' },
        { icon: Users, title: 'Transparent Guide-to-Client Ratios', desc: 'Reputable operators maintain maximum 1:3 guide-to-client ratios on summit day and 1:4 during regular trekking days. Lower ratios mean better safety and support.' },
        { icon: DollarSign, title: 'All-Inclusive Pricing', desc: 'A trustworthy operator provides a detailed breakdown of what is included: park fees, camping fees, rescue fees, meals, guides, porters, and emergency oxygen. Hidden fees are a red flag.' },
        { icon: FileText, title: 'Written Safety Protocols', desc: 'Ask for their written safety procedures including altitude sickness protocols, evacuation plans, and emergency communication systems. They should provide this without hesitation.' },
        { icon: Heart, title: 'Fair Porter Treatment', desc: 'Ethical operators pay porters fair wages, provide proper gear, and follow KPAP (Kilimanjaro Porters Assistance Project) guidelines. Porter welfare is a strong indicator of overall ethics.' },
        { icon: Search, title: 'Verified Reviews on Multiple Platforms', desc: 'Check TripAdvisor, Google Reviews, and SafariBookings.com. Look for consistent positive feedback over several years, not just a handful of recent reviews.' },
    ];

    const redFlags = [
        { title: 'Prices significantly lower than market average', desc: 'If a 7-day Kilimanjaro climb costs under $1,500, corners are being cut on safety, equipment, or porter welfare.' },
        { title: 'Vague or non-existent safety protocols', desc: 'Operators who cannot articulate their altitude sickness procedures or evacuation plans should be avoided.' },
        { title: 'No physical office or local presence', desc: 'A legitimate operator has a physical office in Tanzania (usually Moshi or Arusha) and can provide a local address.' },
        { title: 'Pressure to book immediately', desc: '"Limited time offer" or "only 2 spots left" pressure tactics are common with less reputable operators.' },
        { title: 'Unwillingness to provide references', desc: 'Reputable operators are happy to connect you with past clients or provide detailed references.' },
    ];

    return (
        <div className="prep-savanna-root">
            {/* ─── HERO ─── */}
            <section className="prep-hero">
                <div className="prep-hero-bg">
                    <img
                        src={visuals.getSingle('trekking.prep.chooseOperator', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=1600')}
                        alt="How to choose a Kilimanjaro tour operator — comparing safety, experience, and value"
                    />
                    <div className="prep-hero-overlay"></div>
                </div>
                <div className="prep-hero-content">
                    <motion.span className="prep-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Operator Selection</motion.span>
                    <motion.h1 className="prep-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>How to Choose a <em>Tour Operator</em></motion.h1>
                    <motion.p className="prep-hero-sub" initial="hidden" animate="visible" variants={fadeInUp}>
                        Your operator determines your safety, success, and overall experience. Here is exactly what to look for — and what to avoid.
                    </motion.p>
                </div>
            </section>

            {/* ─── INTRO ─── */}
            <section className="prep-section">
                <div className="prep-container prep-container-narrow">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <h2 className="prep-heading">Why Your Choice Matters</h2>
                        <p className="prep-body">
                            Choosing the right tour operator is the single most important decision you will make for your Kilimanjaro climb or Tanzania safari. A reputable operator ensures your safety, maximises your summit chances, treats their staff ethically, and delivers the experience you are paying for. A poor choice can result in safety risks, hidden costs, uncomfortable conditions, and even a failed summit.
                        </p>
                        <p className="prep-body">
                            Tanzania has over 500 registered tour operators, ranging from world-class expedition companies to informal operators with minimal safety standards. This guide gives you a systematic framework for evaluating and selecting the right operator for your adventure.
                        </p>
                    </motion.div>
                </div>
            </section>

            {/* ─── GREEN FLAGS ─── */}
            <section className="prep-section prep-section-alt">
                <div className="prep-container">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <span className="prep-eyebrow">What to Look For</span>
                        <h2 className="prep-heading">Green Flags: Signs of a Great Operator</h2>
                    </motion.div>

                    <motion.div 
                        className="prep-grid prep-grid-3"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={stagger}
                    >
                        {greenFlags.map((flag, i) => (
                            <motion.div key={i} className="prep-card" variants={fadeInUp}>
                                <div className="prep-card-icon">
                                    <flag.icon size={28} />
                                </div>
                                <h3 className="prep-card-title">{flag.title}</h3>
                                <p className="prep-card-desc">{flag.desc}</p>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* ─── RED FLAGS ─── */}
            <section className="prep-section">
                <div className="prep-container">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <span className="prep-eyebrow">What to Avoid</span>
                        <h2 className="prep-heading">Red Flags: Warning Signs</h2>
                    </motion.div>

                    <motion.div 
                        className="prep-list prep-list-warning"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={stagger}
                    >
                        {redFlags.map((flag, i) => (
                            <motion.div key={i} className="prep-list-item prep-list-item-warning" variants={fadeInUp}>
                                <div className="prep-list-icon">
                                    <XCircle size={24} />
                                </div>
                                <div className="prep-list-content">
                                    <h3>{flag.title}</h3>
                                    <p>{flag.desc}</p>
                                </div>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* ─── QUESTIONS TO ASK ─── */}
            <section className="prep-section prep-section-alt">
                <div className="prep-container prep-container-narrow">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <span className="prep-eyebrow">Due Diligence</span>
                        <h2 className="prep-heading">10 Questions to Ask Before Booking</h2>
                    </motion.div>

                    <motion.div 
                        className="prep-qa-list"
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={stagger}
                    >
                        {[
                            { q: 'What is your KINAPA license number, and can I verify it?', a: 'A legitimate operator will provide their license number without hesitation. You can verify it with Kilimanjaro National Park authorities.' },
                            { q: 'What is your guide-to-client ratio on summit day?', a: 'The answer should be 1:3 or better. Higher ratios compromise safety and individual attention.' },
                            { q: 'What is your summit success rate, and how do you measure it?', a: 'Be wary of operators claiming 100% success rates. Honest operators report 85-95% for longer routes and explain the factors affecting success.' },
                            { q: 'Can you provide a detailed written itinerary with included/excluded items?', a: 'A transparent operator provides a comprehensive itinerary with clear pricing. Everything should be in writing.' },
                            { q: 'What altitude sickness prevention and treatment protocols do you follow?', a: 'They should describe daily health checks, pulse oximetry monitoring, descent protocols, and emergency oxygen availability.' },
                            { q: 'Do you follow KPAP guidelines for porter treatment?', a: 'Ethical operators are KPAP members or followers. This ensures porters are paid fairly, carry appropriate loads, and have proper gear.' },
                            { q: 'What happens if I need to be evacuated?', a: 'They should describe their evacuation plan, including helicopter evacuation partnerships and insurance requirements.' },
                            { q: 'Can I speak with a past client or read independent reviews?', a: 'Reputable operators maintain relationships with past clients and have verified reviews on multiple platforms.' },
                            { q: 'What is your cancellation and refund policy?', a: 'Clear, fair policies are a sign of a professional operation. Be cautious of operators with rigid no-refund policies.' },
                            { q: 'Do you have a physical office in Tanzania I can visit?', a: 'A physical presence in Moshi or Arusha indicates a established, accountable operation.' },
                        ].map((item, i) => (
                            <motion.div key={i} className="prep-qa-item" variants={fadeInUp}>
                                <h3 className="prep-qa-q"><span className="prep-qa-num">{i + 1}.</span> {item.q}</h3>
                                <p className="prep-qa-a">{item.a}</p>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* ─── CTA ─── */}
            <section className="prep-section prep-section-cta">
                <div className="prep-container prep-container-narrow">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <h2 className="prep-heading prep-heading-light">Ready to Climb with Confidence?</h2>
                        <p className="prep-body prep-body-light">
                            Tanzania Sensational meets every green flag on this list. We are KINAPA licensed, KPAP-compliant, 
                            and maintain a 95% summit success rate on our recommended routes. Contact us to discuss your expedition.
                        </p>
                        <div className="prep-cta-actions">
                            <Link href="/contact" className="prep-btn prep-btn-primary">
                                Contact Us <ArrowRight size={16} />
                            </Link>
                            <Link href="/trekking/kilimanjaro" className="prep-btn prep-btn-outline">
                                Explore Routes
                            </Link>
                        </div>
                    </motion.div>
                </div>
            </section>
        </div>
    );
};

export default ChooseOperator;
