import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Phone, Mail, MessageCircle, Send, ShieldCheck, Instagram, Facebook, Youtube, MapPin, Navigation } from 'lucide-react';
import '../styles/contact-premium.css';

export const ContactPage = () => {
    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

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
                        src="https://images.unsplash.com/photo-1547970810-dc1eac37d174?q=80&w=2000&auto=format&fit=crop"
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
                                        <a href="tel:+255784123456" className="premium-contact-val">+255 784 123 456</a>
                                    </div>
                                </div>

                                <div className="premium-contact-card">
                                    <div className="premium-icon-wrap"><MessageCircle size={20} strokeWidth={1.5} /></div>
                                    <div className="premium-contact-info">
                                        <span className="premium-contact-label">Priority WhatsApp</span>
                                        <a href="https://wa.me/255784123456" className="premium-contact-val" style={{ color: '#25D366' }}>Message an Expert</a>
                                    </div>
                                </div>

                                <div className="premium-contact-card">
                                    <div className="premium-icon-wrap"><Mail size={20} strokeWidth={1.5} /></div>
                                    <div className="premium-contact-info">
                                        <span className="premium-contact-label">Official Inquiries</span>
                                        <a href="mailto:expeditions@tanzaniasensational.com" className="premium-contact-val">expeditions@tzsafaris.com</a>
                                    </div>
                                </div>
                            </div>

                            <div className="premium-socials">
                                <a href="#" className="premium-social-link"><Instagram size={18} /></a>
                                <a href="#" className="premium-social-link"><Facebook size={18} /></a>
                                <a href="#" className="premium-social-link"><Youtube size={18} /></a>
                            </div>
                        </div>
                    </div>

                    {/* RIGHT COLUMN: The Planner */}
                    <div className="premium-planner">
                        <div className="premium-form-heading">
                            <h2 className="premium-form-title">Architect Your Journey</h2>
                            <p className="premium-form-subtitle">Provide your details, and an expert will respond within 24 hours.</p>
                        </div>

                        <form className="premium-form">
                            <div className="premium-form-row">
                                <div className="premium-input-group">
                                    <label>Your First Name</label>
                                    <input type="text" className="premium-input" placeholder="e.g. John" />
                                </div>
                                <div className="premium-input-group">
                                    <label>Your Last Name</label>
                                    <input type="text" className="premium-input" placeholder="e.g. Smith" />
                                </div>
                            </div>

                            <div className="premium-form-row">
                                <div className="premium-input-group">
                                    <label>Email Address</label>
                                    <input type="email" className="premium-input" placeholder="name@domain.com" />
                                </div>
                                <div className="premium-input-group">
                                    <label>Phone (Optional)</label>
                                    <input type="tel" className="premium-input" placeholder="+1 (555) 000-0000" />
                                </div>
                            </div>

                            <div className="premium-input-group">
                                <label>The Objective</label>
                                <select className="premium-select">
                                    <option>Kilimanjaro Summit Expedition</option>
                                    <option>Ultimate Wildlife Safari</option>
                                    <option>Mount Meru Acclimatization</option>
                                    <option>Zanzibar Recovery Retreat</option>
                                    <option>Custom Hybrid Adventure</option>
                                </select>
                            </div>

                            <div className="premium-input-group">
                                <label>The Vision</label>
                                <textarea
                                    className="premium-textarea"
                                    placeholder="Share the dream. Are you celebrating a milestone? Do you have specific terrain or wildlife encounters in mind?"
                                ></textarea>
                            </div>

                            <div className="premium-action-area">
                                <button type="button" className="premium-submit-btn">
                                    <span>Initialize Expedition</span>
                                    <Send className="premium-submit-icon" size={16} />
                                </button>
                                <div className="premium-trust-mark">
                                    <ShieldCheck size={20} />
                                    <span>All submissions are secured with end-to-end encryption.</span>
                                </div>
                            </div>
                        </form>
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
