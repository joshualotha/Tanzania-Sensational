import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Mail, Phone, MapPin, Send, MessageSquare, Instagram, Facebook, Youtube, ShieldCheck, Navigation } from 'lucide-react';
import logo from '../assets/logo.png';

export const ContactPage = () => {
    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const pageVariants = {
        hidden: { opacity: 0 },
        visible: {
            opacity: 1,
            transition: { staggerChildren: 0.15, delayChildren: 0.1 }
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

    const hubVariants = {
        hidden: { opacity: 0, y: 40, scale: 0.98 },
        visible: {
            opacity: 1,
            y: 0,
            scale: 1,
            transition: {
                duration: 1.2,
                ease: [0.22, 1, 0.36, 1]
            }
        }
    };

    return (
        <motion.div
            className="contact-v3-root"
            initial="hidden"
            animate="visible"
            variants={pageVariants}
        >
            {/* Cinematic Image Hero */}
            <section className="contact-v3-hero">
                <div className="v3-hero-bg">
                    <img
                        src="https://images.unsplash.com/photo-1621414050946-1b936a78490b?q=80&w=2000&auto=format&fit=crop"
                        alt="Kilimanjaro Landscape"
                    />
                    <div className="v3-hero-overlay"></div>
                </div>
                <div className="container v3-hero-container">
                    <motion.div className="v3-hero-content" variants={fadeInUp}>
                        <span className="v3-eyebrow">Connect with Excellence</span>
                        <h1 className="v3-main-title">Start Your <em>Expedition</em></h1>
                        <div className="v3-title-line"></div>
                    </motion.div>
                </div>
            </section>

            {/* The Inquiry Hub */}
            <section className="contact-v3-hub-section">
                <div className="container">
                    <motion.div
                        className="v3-inquiry-hub"
                        variants={hubVariants}
                    >
                        {/* Hub Left: Direct Communication */}
                        <div className="v3-hub-info">
                            <div className="v3-info-inner">
                                <motion.div className="v3-hub-logo" variants={fadeInUp}>
                                    <img src={logo} alt="Tanzania Sensational" />
                                </motion.div>
                                <motion.div className="v3-section-tag" variants={fadeInUp}>
                                    Direct Contact
                                </motion.div>
                                <motion.h2 className="v3-info-heading" variants={fadeInUp}>
                                    Speak with an <span>Expert Specialist</span>
                                </motion.h2>
                                <motion.p className="v3-info-text" variants={fadeInUp}>
                                    Whether planning a summit or a remote wilderness escape, our senior specialists are ready to architect your legacy.
                                </motion.p>

                                <div className="v3-contact-stack">
                                    {[
                                        { label: "Inquiries", value: "inquiry@tanzaniasensational.com", isLink: true, href: "mailto:inquiry@tanzaniasensational.com", icon: <Mail size={18} /> },
                                        { label: "Direct Line", value: "+255 784 123 456", isLink: true, href: "tel:+255784123456", icon: <Phone size={18} /> },
                                        { label: "WhatsApp", value: "+255 784 123 456", isLink: true, href: "https://wa.me/255784123456", isWhatsApp: true, icon: <MessageSquare size={18} /> }
                                    ].map((item, i) => (
                                        <motion.div key={i} className="v3-contact-item" variants={fadeInUp}>
                                            <div className={`v3-contact-icon ${item.isWhatsApp ? 'wa' : ''}`}>
                                                {item.icon}
                                            </div>
                                            <div className="v3-contact-data">
                                                <span className="v3-data-label">{item.label}</span>
                                                {item.isLink ? (
                                                    <a href={item.href} className="v3-data-value link">{item.value}</a>
                                                ) : (
                                                    <span className="v3-data-value">{item.value}</span>
                                                )}
                                            </div>
                                        </motion.div>
                                    ))}
                                </div>

                                <motion.div className="v3-social-wrap" variants={fadeInUp}>
                                    <span className="v3-social-title">Join the Conversation</span>
                                    <div className="v3-social-grid">
                                        <a href="#"><Instagram size={18} /><span>Instagram</span></a>
                                        <a href="#"><Facebook size={18} /><span>Facebook</span></a>
                                        <a href="#"><Youtube size={18} /><span>YouTube</span></a>
                                    </div>
                                </motion.div>
                            </div>
                        </div>

                        {/* Hub Right: The Inquiry Form */}
                        <div className="v3-hub-form">
                            <motion.div className="v3-form-header" variants={fadeInUp}>
                                <h2 className="v3-form-title">Send an Inquiry</h2>
                                <p className="v3-form-subtitle">Receive a custom itinerary within 24 hours.</p>
                            </motion.div>

                            <form className="v3-form-body">
                                <div className="v3-field-row">
                                    <motion.div className="v3-field" variants={fadeInUp}>
                                        <label>Your Name</label>
                                        <input type="text" placeholder="Full Name" />
                                        <div className="v3-field-focus"></div>
                                    </motion.div>
                                    <motion.div className="v3-field" variants={fadeInUp}>
                                        <label>Email Address</label>
                                        <input type="email" placeholder="email@example.com" />
                                        <div className="v3-field-focus"></div>
                                    </motion.div>
                                </div>

                                <div className="v3-field-row">
                                    <motion.div className="v3-field" variants={fadeInUp}>
                                        <label>Exploration Type</label>
                                        <select>
                                            <option>Kilimanjaro Expedition</option>
                                            <option>Wildlife Safari</option>
                                            <option>Zanzibar Getaway</option>
                                            <option>Mt. Meru Climb</option>
                                            <option>Custom Adventure</option>
                                        </select>
                                        <div className="v3-field-focus"></div>
                                    </motion.div>
                                    <motion.div className="v3-field" variants={fadeInUp}>
                                        <label>Group Size</label>
                                        <input type="number" min="1" placeholder="1" />
                                        <div className="v3-field-focus"></div>
                                    </motion.div>
                                </div>

                                <motion.div className="v3-field" variants={fadeInUp}>
                                    <label>Preferred Travel Dates</label>
                                    <input type="text" placeholder="e.g., Late August 2026" />
                                    <div className="v3-field-focus"></div>
                                </motion.div>

                                <motion.div className="v3-field" variants={fadeInUp}>
                                    <label>The Vision for Your Trip</label>
                                    <textarea rows="5" placeholder="Share your dreams, expectations, or specific requirements..."></textarea>
                                    <div className="v3-field-focus"></div>
                                </motion.div>

                                <motion.button
                                    className="v3-submit-trigger"
                                    variants={fadeInUp}
                                    whileHover={{ y: -2 }}
                                    whileTap={{ scale: 0.98 }}
                                    type="button"
                                >
                                    <span>Initialize Conquest</span>
                                    <Send size={18} />
                                </motion.button>

                                <motion.div className="v3-form-footer" variants={fadeInUp}>
                                    <ShieldCheck size={14} />
                                    <span>We respect your privacy and provide expert-level security for your data.</span>
                                </motion.div>
                            </form>
                        </div>
                    </motion.div>
                </div>
            </section>

            {/* Dedicated Presence Section — Text ABOVE Map */}
            <section className="contact-v4-location">
                <div className="container">
                    {/* Centered Header */}
                    <motion.div className="v4-loc-header" variants={fadeInUp}>
                        <div className="section-eyebrow v4-eyebrow-center">
                            <span className="section-eyebrow-line"></span>
                            <span className="section-eyebrow-text">Our Presence</span>
                            <span className="section-eyebrow-line"></span>
                        </div>
                        <h2 className="section-title v4-loc-title">Based in the Heart of <em>Kilimanjaro</em></h2>
                        <p className="v4-loc-desc">
                            From our headquarters at the foot of Africa's highest peak, we coordinate world-class expeditions led by elite guides.
                        </p>
                        <div className="v4-address-row">
                            <div className="v4-addr-item">
                                <MapPin size={20} className="v4-icon" />
                                <div className="v4-addr-data">
                                    <span className="v4-label">Moshi Headquarters</span>
                                    <span className="v4-value">Arusha-Himo Road, Base 1</span>
                                    <span className="v4-city">Kilimanjaro Region, TZ</span>
                                </div>
                            </div>
                            <div className="v4-addr-item">
                                <Navigation size={20} className="v4-icon" />
                                <div className="v4-addr-data">
                                    <span className="v4-label">Coordinates</span>
                                    <span className="v4-value">3.3440° S, 37.3340° E</span>
                                </div>
                            </div>
                        </div>
                    </motion.div>

                    {/* Full-Width Map Below */}
                    <motion.div className="v4-map-hub" variants={fadeInUp}>
                        <div className="v4-map-frame">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15941.348633!2d37.3340!3d-3.3440!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x18370f2f00000001%3A0x0!2zTW9zaGksIFRhbnphbmlh!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus"
                                width="100%"
                                height="500"
                                style={{ border: 0, filter: 'grayscale(1) contrast(1.1)' }}
                                allowFullScreen=""
                                loading="lazy"
                                title="Moshi Base Map"
                            ></iframe>
                            <div className="v4-map-overlay"></div>
                        </div>
                    </motion.div>
                </div>
            </section>

            {/* Final Background Visual */}
            <div className="v3-footer-visual">
                <div className="v3-visual-overlay"></div>
            </div>
        </motion.div>
    );
};
