import React, { useEffect, useState } from 'react';
import { motion } from 'framer-motion';
import { Phone, Mail, MessageCircle, Send, ShieldCheck, Instagram, Facebook, Youtube, MapPin, Navigation } from 'lucide-react';
import { visualsData } from '../data/visualsData';
import { useVisuals } from '../context/VisualsContext';
import { contactService, pageService } from '../services/api';
import { CmsSection } from '../components/cms/CmsSection';
import '../styles/contact-premium.css';

export const ContactPage = () => {
    const [cms, setCms] = useState(null);
    const visuals = useVisuals();
    const [formData, setFormData] = useState({
        first_name: '',
        last_name: '',
        email: '',
        phone: '',
        objective: 'Kilimanjaro Summit Expedition',
        vision: ''
    });
    const [isSubmitting, setIsSubmitting] = useState(false);
    const [submitted, setSubmitted] = useState(false);

    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    useEffect(() => {
        let mounted = true;
        pageService.getBySlug('contact')
            .then((res) => { if (mounted) setCms(res.data); })
            .catch(() => {});
        return () => { mounted = false; };
    }, []);

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData(prev => ({ ...prev, [name]: value }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            setIsSubmitting(true);
            await contactService.submit(formData);
            setSubmitted(true);
            setFormData({
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
                objective: 'Kilimanjaro Summit Expedition',
                vision: ''
            });
        } catch (error) {
            alert("Failed to submit inquiry. Please try again or contact us via WhatsApp.");
        } finally {
            setIsSubmitting(false);
        }
    };

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: {
            opacity: 1,
            y: 0,
            transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] }
        }
    };

    const straggerGroup = {
        hidden: { opacity: 0 },
        visible: {
            opacity: 1,
            transition: { staggerChildren: 0.15, delayChildren: 0.1 }
        }
    };

    return (
        <div className="contact-premium-root">

            {/* ─── 1. HERO SECTION ─── */}
            <section className="premium-hero">
                <div className="premium-hero-bg">
                    <img
                        src={visuals.getSingle('contact.hero', visualsData.contact.hero)}
                        alt="African Landscape"
                    />
                    <div className="premium-hero-overlay"></div>
                </div>
                <div className="container">
                    <motion.div
                        className="premium-hero-content"
                        initial="hidden"
                        animate="visible"
                        variants={straggerGroup}
                    >
                        <motion.span className="premium-hero-eyebrow" variants={fadeInUp}>Basecamp Communications</motion.span>
                        <motion.h1 className="premium-hero-title" variants={fadeInUp}>Connect with <em>Excellence</em></motion.h1>
                    </motion.div>
                </div>
            </section>

            {/* ─── 2. EXPEDITION DESK (Overlapping) ─── */}
            <section className="premium-desk-section">
                <motion.div
                    className="premium-desk-card"
                    initial={{ opacity: 0, y: 40 }}
                    animate={{ opacity: 1, y: 0 }}
                    transition={{ duration: 1, delay: 0.2, ease: [0.22, 1, 0.36, 1] }}
                >
                    {/* LEFT COLUMN: The Concierge */}
                    <div className="premium-concierge">
                        <div className="premium-concierge-inner">
                            <div className="premium-crest">
                                <div className="premium-crest-text">TS.</div>
                            </div>

                            <h2 className="premium-concierge-title">
                                Your <em>Expedition</em> Awaits.
                            </h2>

                            <p className="premium-concierge-desc">
                                Whether you seek the summit of Africa or the profound silence of the Serengeti, our senior architects are ready to forge your legacy.
                            </p>

                            <div className="premium-contact-list">
                                <div className="premium-contact-card">
                                    <div className="premium-icon-wrap"><Phone size={20} strokeWidth={1.5} /></div>
                                    <div className="premium-contact-info">
                                        <span className="premium-contact-label">Direct Line (Arusha HQ)</span>
                                        <a href="tel:+255621220912" className="premium-contact-val">+255-621220912</a>
                                    </div>
                                </div>

                                <div className="premium-contact-card">
                                    <div className="premium-icon-wrap"><MessageCircle size={20} strokeWidth={1.5} /></div>
                                    <div className="premium-contact-info">
                                        <span className="premium-contact-label">Priority WhatsApp</span>
                                        <a href="https://wa.me/255621220912" className="premium-contact-val" style={{ color: '#25D366' }}>Message an Expert</a>
                                    </div>
                                </div>

                                <div className="premium-contact-card">
                                    <div className="premium-icon-wrap"><Mail size={20} strokeWidth={1.5} /></div>
                                    <div className="premium-contact-info">
                                        <span className="premium-contact-label">Official Inquiries</span>
                                        <a href="mailto:info@tssafaris.com" className="premium-contact-val">info@tssafaris.com</a>
                                    </div>
                                </div>
                            </div>

                            <div className="premium-socials">
                                <a href="https://www.instagram.com" target="_blank" rel="noreferrer" className="premium-social-link"><Instagram size={18} /></a>
                                <a href="https://www.facebook.com" target="_blank" rel="noreferrer" className="premium-social-link"><Facebook size={18} /></a>
                                <a href="https://www.youtube.com" target="_blank" rel="noreferrer" className="premium-social-link"><Youtube size={18} /></a>
                            </div>
                        </div>
                    </div>

                    {/* RIGHT COLUMN: The Planner */}
                    <div className="premium-planner">
                        <div className="premium-form-heading">
                            <h2 className="premium-form-title">Plan your journey</h2>
                            <p className="premium-form-subtitle">Provide your details, and an expert will respond within 24 hours.</p>
                        </div>

                        {submitted ? (
                            <motion.div 
                                className="premium-success-message"
                                initial={{ opacity: 0, scale: 0.9 }}
                                animate={{ opacity: 1, scale: 1 }}
                                style={{ padding: '40px', textAlign: 'center', background: 'rgba(201,168,76,0.1)', color: 'var(--gold)', borderRadius: '8px', border: '1px solid var(--gold)' }}
                            >
                                <ShieldCheck size={48} style={{ marginBottom: '20px' }} />
                                <h3 style={{ fontSize: '1.4rem', marginBottom: '10px' }}>Strategy Received</h3>
                                <p style={{ opacity: 0.8 }}>Your expedition architectural brief has been successfully transmitted. Our senior concierge will respond within 24 hours.</p>
                                <button onClick={() => setSubmitted(false)} className="premium-submit-btn" style={{ marginTop: '30px', marginInline: 'auto' }}>
                                    <span>Send Another Message</span>
                                </button>
                            </motion.div>
                        ) : (
                            <form className="premium-form" onSubmit={handleSubmit}>
                                <div className="premium-form-row">
                                    <div className="premium-input-group">
                                        <label>Your First Name</label>
                                        <input 
                                            name="first_name" 
                                            type="text" 
                                            required 
                                            className="premium-input" 
                                            placeholder="e.g. John" 
                                            value={formData.first_name}
                                            onChange={handleInputChange}
                                        />
                                    </div>
                                    <div className="premium-input-group">
                                        <label>Your Last Name</label>
                                        <input 
                                            name="last_name" 
                                            type="text" 
                                            required 
                                            className="premium-input" 
                                            placeholder="e.g. Smith" 
                                            value={formData.last_name}
                                            onChange={handleInputChange}
                                        />
                                    </div>
                                </div>

                                <div className="premium-form-row">
                                    <div className="premium-input-group">
                                        <label>Email Address</label>
                                        <input 
                                            name="email" 
                                            type="email" 
                                            required 
                                            className="premium-input" 
                                            placeholder="name@domain.com" 
                                            value={formData.email}
                                            onChange={handleInputChange}
                                        />
                                    </div>
                                    <div className="premium-input-group">
                                        <label>Phone (Optional)</label>
                                        <input 
                                            name="phone" 
                                            type="tel" 
                                            className="premium-input" 
                                            placeholder="+1 (555) 000-0000" 
                                            value={formData.phone}
                                            onChange={handleInputChange}
                                        />
                                    </div>
                                </div>

                                <div className="premium-input-group">
                                    <label>The Objective</label>
                                    <select 
                                        name="objective" 
                                        className="premium-select"
                                        value={formData.objective}
                                        onChange={handleInputChange}
                                    >
                                        <option value="Kilimanjaro Summit Expedition">Kilimanjaro Summit Expedition</option>
                                        <option value="Kilimanjaro Route Advice (Help me choose)">Kilimanjaro Route Advice (Help me choose)</option>
                                        <option value="Group Departure (Join a scheduled date)">Group Departure (Join a scheduled date)</option>
                                        <option value="Ultimate Wildlife Safari">Ultimate Wildlife Safari</option>
                                        <option value="Safari Packages (Help me choose)">Safari Packages (Help me choose)</option>
                                        <option value="Mount Meru Acclimatization">Mount Meru Acclimatization</option>
                                        <option value="Zanzibar Recovery Retreat">Zanzibar Recovery Retreat</option>
                                        <option value="Gear Rental Request">Gear Rental Request</option>
                                        <option value="Booking Follow-up (I already submitted a request)">Booking Follow-up (I already submitted a request)</option>
                                        <option value="Partnership / Agent Inquiry">Partnership / Agent Inquiry</option>
                                        <option value="Media / Press">Media / Press</option>
                                        <option value="Custom Hybrid Adventure">Custom Hybrid Adventure</option>
                                    </select>
                                </div>

                                <div className="premium-input-group">
                                    <label>The Vision</label>
                                    <textarea
                                        name="vision"
                                        className="premium-textarea"
                                        placeholder="Share the dream. Are you celebrating a milestone? Do you have specific terrain or wildlife encounters in mind?"
                                        value={formData.vision}
                                        onChange={handleInputChange}
                                    ></textarea>
                                </div>

                                <div className="premium-action-area">
                                    <button type="submit" className="premium-submit-btn" disabled={isSubmitting}>
                                        <span>{isSubmitting ? 'Sending…' : 'Send inquiry'}</span>
                                        {isSubmitting ? <span className="animate-spin">⌛</span> : <Send className="premium-submit-icon" size={16} />}
                                    </button>
                                    <div className="premium-trust-mark">
                                        <ShieldCheck size={20} />
                                        <span>We’ll reply by email within 24 hours. Your details stay private.</span>
                                    </div>
                                </div>
                            </form>
                        )}
                    </div>
                </motion.div>
            </section>

            {/* ─── 3. MAP SECTION ─── */}
            <section className="premium-map-section">
                <motion.div
                    className="premium-map-header"
                    initial={{ opacity: 0, y: 20 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true, margin: "-100px" }}
                    transition={{ duration: 0.8 }}
                >
                    <span className="premium-map-eyebrow">Our Presence</span>
                    <h2 className="premium-map-title">Based in the Heart of <em>Tanzania</em></h2>

                    <div className="premium-address-row">
                        <div className="premium-addr-item">
                            <MapPin className="premium-addr-icon" size={24} />
                            <div className="premium-addr-info">
                                <span className="premium-addr-label">Arusha Basecamp</span>
                                <span className="premium-addr-value">Moshi-Arusha Road</span>
                            </div>
                        </div>
                        <div className="premium-addr-item">
                            <Navigation className="premium-addr-icon" size={24} />
                            <div className="premium-addr-info">
                                <span className="premium-addr-label">Coordinates</span>
                                <span className="premium-addr-value">3.3869° S, 36.6830° E</span>
                            </div>
                        </div>
                    </div>
                </motion.div>

                <div className="premium-map-frame">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15941.348633!2d37.3340!3d-3.3440!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x18370f2f00000001%3A0x0!2zTW9zaGksIFRhbnphbmlh!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus"
                        title="Tanzania Base Map"
                        loading="lazy"
                    ></iframe>
                </div>
            </section>

        </div>
    );
};
