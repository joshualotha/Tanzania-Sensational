import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import { Shield, CheckCircle } from 'lucide-react';
import '../../styles/safari-field-guide.css';

const HealthAndSafety = () => {
    useEffect(() => { window.scrollTo(0, 0); }, []);
    const visuals = useVisuals();

    const fade = {
        hidden: { opacity: 0, y: 40 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.4, ease: [0.16, 1, 0.3, 1] } }
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
            num: '01',
            title: 'Water Safety',
            desc: 'Never drink tap water in Tanzania. Stick to sealed bottled water or purified water provided by your lodge. Avoid ice cubes unless you\'re certain they were made from purified water.',
            items: ['Bottled water only (check seal)', 'No tap water for brushing teeth', 'Avoid ice in local establishments', 'Use purification tablets as backup']
        },
        {
            num: '02',
            title: 'Wildlife Encounters',
            desc: 'Wild animals are unpredictable and dangerous when approached. Your guide\'s instructions are absolute law. Stay in the vehicle unless explicitly told it\'s safe to exit.',
            items: ['Never approach wild animals', 'Keep limbs inside the vehicle', 'Speak quietly during sightings', 'Follow guide instructions immediately']
        },
        {
            num: '03',
            title: 'Emergency Protocols',
            desc: 'All reputable safari operators have emergency evacuation plans. Know your camp\'s nearest medical facility and evacuation procedure before departing.',
            items: ['Flying Doctors Service (AMREF)', 'Satellite phone in remote camps', 'Nearest hospital identified on arrival', 'Travel insurance covers evacuation']
        },
        {
            num: '04',
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
        <div className="field-root">

            {/* ═══ HERO ═══ */}
            <section className="field-hero">
                <div className="field-hero-img">
                    <img src={visuals.getSingle('safari.healthHero', visualsData.trekking.health.vaccinations)} alt="Health and safety in Tanzania" />
                </div>
                <div className="field-hero-gradient" />
                <motion.div className="field-hero-content" initial="hidden" animate="visible" variants={fade}>
                    <span className="field-hero-eyebrow">Your Safety, Our Priority</span>
                    <h1 className="field-hero-title">Health & <em>Safety</em></h1>
                    <p className="field-hero-subtitle">
                        The vast majority of health risks are entirely preventable with proper preparation and awareness.
                    </p>
                </motion.div>
            </section>

            {/* ═══ CHAPTER 1 — PREPARE WITH CONFIDENCE ═══ */}
            <div className="field-split">
                <div className="field-split-text">
                    <motion.div initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-80px" }} variants={fade}>
                        <span className="field-chapter-num">01</span>
                        <span className="field-chapter-eyebrow">Before You Go</span>
                        <h2 className="field-chapter-title">Prepare with <em>Confidence</em></h2>
                        <p className="field-chapter-body">
                            Tanzania is a safe and welcoming destination for travelers who take sensible precautions. This guide covers the essential vaccinations, daily safety protocols, and emergency procedures that every traveler should understand before departure.
                        </p>
                        <p className="field-chapter-body">
                            Consult your travel physician 4-6 weeks before your trip for personalized medical advice based on your health history.
                        </p>
                    </motion.div>
                </div>
                <motion.div className="field-split-img" initial={{ opacity: 0, scale: 1.05 }} whileInView={{ opacity: 1, scale: 1 }} viewport={{ once: true }} transition={{ duration: 1.5 }}>
                    <img src={visuals.getSingle('safari.healthEditorial', visualsData.trekking.during.routine)} alt="Medical preparation" />
                </motion.div>
            </div>

            {/* ═══ VACCINATION TABLE ═══ */}
            <section className="field-chapter">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade}>
                    <span className="field-chapter-num">02</span>
                    <span className="field-chapter-eyebrow">Immunisation</span>
                    <h2 className="field-chapter-title">Vaccination <em>Requirements</em></h2>
                </motion.div>
            </section>

            <section className="field-table-section" style={{ paddingTop: 0 }}>
                <motion.div style={{ overflowX: 'auto' }} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade}>
                    <table className="field-table">
                        <thead>
                            <tr>
                                <th>Vaccination</th>
                                <th>Status</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            {vaccinations.map((vax, i) => (
                                <tr key={i}>
                                    <td>
                                        <div className="field-table-name">
                                            {vax.critical ? <Shield size={15} style={{ color: 'var(--field-gold)' }} /> : <CheckCircle size={15} style={{ color: '#16a34a' }} />}
                                            {vax.name}
                                        </div>
                                    </td>
                                    <td>
                                        <span className={`field-table-badge ${vax.status.toLowerCase()}`}>
                                            {vax.status}
                                        </span>
                                    </td>
                                    <td className="field-table-desc">{vax.desc}</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </motion.div>
            </section>

            {/* ═══ PULL QUOTE ═══ */}
            <motion.section className="field-pullquote" initial={{ opacity: 0 }} whileInView={{ opacity: 1 }} viewport={{ once: true }} transition={{ duration: 1.2 }}>
                <p className="field-pullquote-text">
                    "The best insurance policy is preparation. The second best is actual insurance."
                </p>
                <span className="field-pullquote-attr">Safari Safety Guidebook</span>
            </motion.section>

            {/* ═══ CHAPTER 3 — SAFETY PILLARS ═══ */}
            <section className="field-chapter">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade}>
                    <span className="field-chapter-num">03</span>
                    <span className="field-chapter-eyebrow">In the Field</span>
                    <h2 className="field-chapter-title">The Four <em>Pillars</em></h2>
                    <p className="field-chapter-body">
                        Four critical areas of safety awareness that will keep you protected throughout your Tanzanian journey.
                    </p>
                </motion.div>
            </section>

            <section className="field-details-section" style={{ paddingTop: 0 }}>
                {safety.map((item, i) => (
                    <motion.div className="field-detail-row" key={i} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade} transition={{ delay: i * 0.08 }}>
                        <span className="field-detail-num">{item.num}</span>
                        <div>
                            <h3 className="field-detail-title">{item.title}</h3>
                            <p className="field-detail-desc">{item.desc}</p>
                            <ul className="field-detail-items">
                                {item.items.map((bullet, j) => <li key={j}>{bullet}</li>)}
                            </ul>
                        </div>
                    </motion.div>
                ))}
            </section>

            {/* ═══ FULL BLEED ═══ */}
            <section className="field-bleed">
                <img src={visuals.getSingle('safari.healthFullBleed', visualsData.safaris.migrationHero)} alt="Wilderness safety" />
                <span className="field-bleed-caption">Ngorongoro Crater, Tanzania</span>
            </section>

            {/* ═══ EMERGENCY CONTACTS ═══ */}
            <section className="field-chapter">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade}>
                    <span className="field-chapter-num">04</span>
                    <span className="field-chapter-eyebrow">Critical Numbers</span>
                    <h2 className="field-chapter-title">Emergency <em>Contacts</em></h2>
                </motion.div>
            </section>

            <section className="field-details-section" style={{ paddingTop: 0 }}>
                <div className="field-contacts">
                    {emergencyContacts.map((contact, i) => (
                        <motion.div className="field-contact-row" key={i} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade} transition={{ delay: i * 0.08 }}>
                            <div>
                                <div className="field-contact-name">{contact.name}</div>
                                <span className="field-contact-desc">{contact.desc}</span>
                            </div>
                            <div className="field-contact-number">{contact.number}</div>
                        </motion.div>
                    ))}
                </div>
            </section>

            {/* ═══ CTA ═══ */}
            <section className="field-cta">
                <motion.div initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fade}>
                    <h2 className="field-cta-title">Respect the <em>Culture</em></h2>
                    <p className="field-cta-body">
                        Understanding local customs and etiquette will enrich your experience and show respect for the communities you visit.
                    </p>
                    <Link to="/safari-guide/local-customs" className="field-btn">
                        Safari Etiquette Guide
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" /></svg>
                    </Link>
                </motion.div>
            </section>
        </div>
    );
};

export default HealthAndSafety;
