import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import { Shield, AlertTriangle, Droplets, Syringe, Heart, Phone, Activity, CheckCircle } from 'lucide-react';
import '../../styles/ultra-premium.css';

const HealthAndSafety = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);
    const visuals = useVisuals();

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const vaccinations = [
        { name: 'Yellow Fever', status: 'Required', desc: 'Mandatory for entry. Certificate must be carried at all times.', critical: true },
        { name: 'Hepatitis A', status: 'Recommended', desc: 'Transmitted through contaminated food and water. Highly advised for all travelers.', critical: true },
        { name: 'Typhoid', status: 'Recommended', desc: 'Essential if traveling outside major cities or eating local cuisine.', critical: true },
        { name: 'Hepatitis B', status: 'Recommended', desc: 'Recommended for extended stays or if medical procedures are anticipated.', critical: false },
        { name: 'Tetanus', status: 'Required', desc: 'Ensure your booster is up to date (within 10 years).', critical: true },
        { name: 'Rabies', status: 'Optional', desc: 'Recommended for remote areas or extended stays. Not mandatory for standard safaris.', critical: false },
    ];

    const safety = [
        {
            icon: <Droplets size={24} />,
            title: 'Water Safety',
            desc: 'Never drink tap water in Tanzania. Stick to sealed bottled water or purified water provided by your lodge. Avoid ice cubes unless you\'re certain they were made from purified water.',
            items: ['Bottled water only (check seal)', 'No tap water for brushing teeth', 'Avoid ice in local establishments', 'Use water purification tablets as backup']
        },
        {
            icon: <AlertTriangle size={24} />,
            title: 'Wildlife Encounters',
            desc: 'Wild animals are unpredictable and dangerous when approached. Your guide\'s instructions are absolute law. Stay in the vehicle unless explicitly told it\'s safe to exit.',
            items: ['Never approach wild animals', 'Keep limbs inside the vehicle', 'Speak quietly during sightings', 'Follow guide instructions immediately']
        },
        {
            icon: <Activity size={24} />,
            title: 'Emergency Protocols',
            desc: 'All reputable safari operators have emergency evacuation plans. Know your camp\'s nearest medical facility and evacuation procedure before departing.',
            items: ['Flying Doctors Service (AMREF)', 'Satellite phone in remote camps', 'Nearest hospital identified on arrival', 'Travel insurance covers evacuation']
        },
        {
            icon: <Syringe size={24} />,
            title: 'Malaria Prevention',
            desc: 'Tanzania is a high-risk malaria zone. Consult your doctor 4-6 weeks before travel for the appropriate prophylaxis. Combine medication with physical barriers.',
            items: ['Start prophylaxis before travel', 'Use DEET 30%+ repellent daily', 'Sleep under treated mosquito nets', 'Wear long sleeves after dusk']
        }
    ];

    const emergencyContacts = [
        { name: 'AMREF Flying Doctors', number: '+255 20 732 2612', desc: 'Emergency air evacuation' },
        { name: 'Tanzania Tourist Police', number: '+255 20 219 1311', desc: 'Tourist assistance & emergencies' },
        { name: 'US Embassy (Dar es Salaam)', number: '+255 22 266 8001', desc: 'Consular services' },
        { name: 'Aga Khan Hospital (Dar)', number: '+255 22 211 5151', desc: 'Premier medical facility' },
    ];

    return (
        <div className="lux-root">
            {/* ─── HERO ─── */}
            <section className="lux-hero">
                <img
                    src={visuals.getSingle('safari.healthHero', visualsData.trekking.health.vaccinations)}
                    alt="Health & Safety"
                />
                <div className="lux-hero-overlay"></div>
                <div className="lux-hero-content">
                    <motion.span className="lux-hero-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Your Safety, Our Priority</motion.span>
                    <motion.h1 className="lux-hero-title" initial="hidden" animate="visible" variants={fadeInUp} transition={{ delay: 0.1 }}>
                        Health & <em>Safety.</em>
                    </motion.h1>
                </div>
            </section>

            {/* ─── EDITORIAL INTRO ─── */}
            <section className="lux-section">
                <div className="lux-editorial-grid">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-100px" }} variants={fadeInUp}>
                        <h2 className="lux-heading">Prepare with <em>Confidence.</em></h2>
                        <p className="lux-body">
                            Tanzania is a safe and welcoming destination for travelers who take sensible precautions. The vast majority of health risks are entirely preventable with proper preparation and awareness.
                        </p>
                        <p className="lux-body">
                            This guide covers the essential vaccinations, daily safety protocols, and emergency procedures that every traveler to Tanzania should understand before departure.
                        </p>
                        <p className="lux-body">
                            Consult your travel physician 4-6 weeks before your trip for personalized medical advice based on your health history.
                        </p>
                    </motion.div>
                    <motion.div
                        initial={{ opacity: 0, scale: 0.95 }}
                        whileInView={{ opacity: 1, scale: 1 }}
                        viewport={{ once: true }}
                        transition={{ duration: 1.5, ease: "easeOut" }}
                        className="lux-image-wrapper"
                    >
                        <img
                            src={visuals.getSingle('safari.healthEditorial', visualsData.trekking.during.routine)}
                            alt="Medical Preparedness"
                        />
                        <div className="lux-image-caption">Professional medical support is available throughout your journey.</div>
                    </motion.div>
                </div>
            </section>

            {/* ─── VACCINATION TABLE ─── */}
            <section className="lux-section" style={{ background: 'var(--lux-offwhite)' }}>
                <motion.h2 className="lux-heading" style={{ textAlign: 'center', marginBottom: '50px' }} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    Vaccination <em>Requirements.</em>
                </motion.h2>
                <div style={{ maxWidth: '900px', margin: '0 auto', overflowX: 'auto' }}>
                    <motion.table
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={fadeInUp}
                        style={{ width: '100%', borderCollapse: 'collapse', background: 'white', borderRadius: '8px', overflow: 'hidden', boxShadow: '0 4px 20px rgba(0,0,0,0.06)' }}
                    >
                        <thead>
                            <tr style={{ background: 'var(--lux-dark)' }}>
                                <th style={{ padding: '16px 24px', textAlign: 'left', color: 'white', fontSize: '0.75rem', textTransform: 'uppercase', letterSpacing: '0.1em' }}>Vaccination</th>
                                <th style={{ padding: '16px 24px', textAlign: 'left', color: 'white', fontSize: '0.75rem', textTransform: 'uppercase', letterSpacing: '0.1em' }}>Status</th>
                                <th style={{ padding: '16px 24px', textAlign: 'left', color: 'white', fontSize: '0.75rem', textTransform: 'uppercase', letterSpacing: '0.1em' }}>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            {vaccinations.map((vax, i) => (
                                <tr key={i} style={{ borderBottom: '1px solid var(--lux-border)' }}>
                                    <td style={{ padding: '16px 24px', fontSize: '0.95rem', color: 'var(--lux-dark)', fontWeight: 600 }}>
                                        <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
                                            {vax.critical ? <Shield size={16} style={{ color: 'var(--lux-tan)' }} /> : <CheckCircle size={16} style={{ color: 'var(--lux-green)' }} />}
                                            {vax.name}
                                        </div>
                                    </td>
                                    <td style={{ padding: '16px 24px' }}>
                                        <span style={{
                                            fontSize: '0.7rem',
                                            padding: '4px 10px',
                                            borderRadius: '999px',
                                            fontWeight: 600,
                                            letterSpacing: '0.05em',
                                            background: vax.status === 'Required' ? 'rgba(220, 38, 38, 0.1)' : vax.status === 'Recommended' ? 'rgba(201, 168, 76, 0.1)' : 'rgba(34, 197, 94, 0.1)',
                                            color: vax.status === 'Required' ? '#DC2626' : vax.status === 'Recommended' ? 'var(--lux-tan)' : 'var(--lux-green)',
                                        }}>
                                            {vax.status.toUpperCase()}
                                        </span>
                                    </td>
                                    <td style={{ padding: '16px 24px', fontSize: '0.85rem', color: 'var(--lux-mid)', lineHeight: '1.5' }}>{vax.desc}</td>
                                </tr>
                            ))}
                        </tbody>
                    </motion.table>
                </div>
            </section>

            {/* ─── SAFETY PILLARS ─── */}
            <section className="lux-section">
                <motion.h2 className="lux-heading" style={{ textAlign: 'center', marginBottom: '60px' }} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    The Four <em>Pillars.</em>
                </motion.h2>
                <div style={{ display: 'grid', gridTemplateColumns: 'repeat(2, 1fr)', gap: '40px', maxWidth: '1200px', margin: '0 auto' }}>
                    {safety.map((item, i) => (
                        <motion.div
                            key={i}
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true }}
                            variants={fadeInUp}
                            transition={{ delay: i * 0.15 }}
                            style={{ background: 'white', padding: '40px', borderRadius: '8px', boxShadow: '0 4px 20px rgba(0,0,0,0.06)', border: '1px solid var(--lux-border)' }}
                        >
                            <div style={{ width: '56px', height: '56px', background: 'var(--lux-tan)', borderRadius: '12px', display: 'flex', alignItems: 'center', justifyContent: 'center', color: 'white', marginBottom: '20px' }}>
                                {item.icon}
                            </div>
                            <h3 style={{ fontFamily: 'var(--font-heading)', fontSize: '1.5rem', color: 'var(--lux-dark)', marginBottom: '15px' }}>{item.title}</h3>
                            <p style={{ fontSize: '0.95rem', lineHeight: '1.7', color: 'var(--lux-mid)', marginBottom: '20px' }}>{item.desc}</p>
                            <ul style={{ listStyle: 'none', padding: 0, margin: 0, display: 'flex', flexDirection: 'column', gap: '8px' }}>
                                {item.items.map((item, j) => (
                                    <li key={j} style={{ fontSize: '0.85rem', color: 'var(--lux-dark)', display: 'flex', alignItems: 'flex-start', gap: '8px' }}>
                                        <div style={{ width: '6px', height: '6px', background: 'var(--lux-tan)', borderRadius: '50%', marginTop: '6px', flexShrink: 0 }} />
                                        {item}
                                    </li>
                                ))}
                            </ul>
                        </motion.div>
                    ))}
                </div>
            </section>

            {/* ─── FULL BLEED PARALLAX ─── */}
            <section className="lux-full-bleed">
                <img
                    src={visuals.getSingle('safari.healthFullBleed', visualsData.safaris.migrationHero)}
                    alt="Safety in the Wild"
                />
            </section>

            {/* ─── EMERGENCY CONTACTS ─── */}
            <section className="lux-section" style={{ background: 'var(--lux-offwhite)' }}>
                <motion.h2 className="lux-heading" style={{ textAlign: 'center', marginBottom: '50px' }} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    Emergency <em>Contacts.</em>
                </motion.h2>
                <div style={{ maxWidth: '800px', margin: '0 auto', display: 'grid', gap: '16px' }}>
                    {emergencyContacts.map((contact, i) => (
                        <motion.div
                            key={i}
                            initial="hidden"
                            whileInView="visible"
                            viewport={{ once: true }}
                            variants={fadeInUp}
                            transition={{ delay: i * 0.08 }}
                            style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', padding: '20px 25px', background: 'white', borderRadius: '8px', border: '1px solid var(--lux-border)' }}
                        >
                            <div>
                                <h4 style={{ fontFamily: 'var(--font-body)', fontSize: '1rem', color: 'var(--lux-dark)', marginBottom: '4px' }}>{contact.name}</h4>
                                <span style={{ fontSize: '0.8rem', color: 'var(--lux-mid)' }}>{contact.desc}</span>
                            </div>
                            <div style={{ fontSize: '1.1rem', fontFamily: 'var(--font-mono)', color: 'var(--lux-tan)', fontWeight: 600, letterSpacing: '0.05em' }}>
                                {contact.number}
                            </div>
                        </motion.div>
                    ))}
                </div>
            </section>

            {/* ─── CTA ─── */}
            <section className="lux-cta">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                    <h2 className="lux-heading" style={{ marginBottom: '20px' }}>Respect the <em>Culture.</em></h2>
                    <p className="lux-body" style={{ maxWidth: '600px', margin: '0 auto 30px' }}>
                        Understanding local customs and etiquette will enrich your experience and show respect for the communities you visit.
                    </p>
                    <Link to="/safari-guide/local-customs" className="lux-btn" style={{ display: 'inline-flex', alignItems: 'center', gap: '10px' }}>
                        Safari Etiquette Guide
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
                        </svg>
                    </Link>
                </motion.div>
            </section>
        </div>
    );
};

export default HealthAndSafety;
