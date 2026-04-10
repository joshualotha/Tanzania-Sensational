import React, { useEffect, useState, useMemo } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import { Search, ChevronDown, Mail, Phone, MessageSquare } from 'lucide-react';
import '../../styles/utility-pages-premium.css';

const faqs = [
    {
        category: "The Climb",
        icon: "🏔️",
        items: [
            { q: "How difficult is climbing Kilimanjaro?", a: "Kilimanjaro is a non-technical mountain, meaning no ropes or ice axes are needed for the standard routes. However, it is an extreme altitude trek. The physical exertion combined with lower oxygen levels makes it a strenuous challenge requiring mental fortitude and physical preparation." },
            { q: "Which route has the highest success rate?", a: "The longer routes—Lemosho (8 days) and Northern Circuit (9 days)—have the highest success rates, often exceeding 90%. They allow for the necessary 'climb high, sleep low' acclimatization profile." },
            { q: "Do I need to be a professional athlete?", a: "No. Age and fitness levels vary wildly on the mountain. Mental determination and pacing ('Pole Pole' - slowly slowly) are often more important than raw physical strength." },
            { q: "What is the best time of year to climb?", a: "The best climbing seasons are January–March (dry and clear) and June–October (cooler and drier). December and April/May are possible but experience more rainfall." },
            { q: "How many hours do we hike each day?", a: "Typically 4–7 hours of hiking per day, with summit day being 12–16 hours. We follow a 'Pole Pole' (slowly slowly) philosophy to maximize acclimatization." }
        ]
    },
    {
        category: "Health & Safety",
        icon: "⚕️",
        items: [
            { q: "What is Altitude Sickness (AMS)?", a: "Acute Mountain Sickness occurs when ascending to high altitudes too quickly. Symptoms include headache, nausea, and fatigue. Our guides monitor heart rate and oxygen saturation twice daily to catch early signs." },
            { q: "What happens if I cannot continue?", a: "Safety is paramount. If you must descend, an assistant guide will escort you down safely. Depending on your location and the severity of your condition, we will coordinate an evacuation to the nearest gate or organize medical helicopter air-lift." },
            { q: "Is the water safe to drink?", a: "Our porters gather fresh mountain stream water daily, which is then boiled and purified at camp before being served to you. You will need to bring iodine or purification tablets only as an emergency backup." },
            { q: "What vaccinations are required?", a: "Yellow fever vaccination is mandatory for entry into Tanzania. We also recommend Hepatitis A & B, Typhoid, and routine vaccinations. Consult your travel clinic 6–8 weeks before departure." },
            { q: "Do you carry oxygen on the climb?", a: "Yes. All our climbs carry portable oxygen cylinders and comprehensive first-aid kits. Our guides are trained in wilderness first response and altitude medicine." }
        ]
    },
    {
        category: "Booking & Logistics",
        icon: "📅",
        items: [
            { q: "How far in advance should I book?", a: "We recommend booking 6–12 months in advance for the best departure dates and route selection. Last-minute bookings (within 3 months) are sometimes possible but subject to availability." },
            { q: "What is included in the package price?", a: "All packages include: park fees, certified guides & porters, meals on the mountain, accommodation (tents/huts), airport transfers, pre-climb hotel, and safety equipment. Not included: flights, visas, travel insurance, tips, and personal gear." },
            { q: "What is your cancellation policy?", a: "Cancellations 90+ days before departure receive a 75% refund. 60–89 days: 50% refund. 30–59 days: 25% refund. Less than 30 days: no refund. We strongly recommend trip cancellation insurance." },
            { q: "Do you offer group discounts?", a: "Yes. Groups of 4+ receive a 10% discount. Groups of 8+ receive 15% off. Private group departures can be arranged with custom dates and itineraries." },
            { q: "Can I extend my trip with a safari?", a: "Absolutely! Most climbers add a 3–7 day safari in Serengeti, Ngorongoro, or Tarangire. We offer seamless safari extensions with the same premium service standard." }
        ]
    },
    {
        category: "Gear & Preparation",
        icon: "🎒",
        items: [
            { q: "What gear do I need to bring?", a: "We provide a detailed packing list upon booking. Essential items include: waterproof hiking boots, layered clothing (base/mid/outer), sleeping bag (-10°C rating), headlamp, trekking poles, and personal medications." },
            { q: "Do you rent gear?", a: "Yes. We offer high-quality rental gear including sleeping bags, trekking poles, down jackets, and duffel bags. Rental must be reserved at least 30 days before departure." },
            { q: "How should I train for the climb?", a: "Focus on cardiovascular endurance (hiking, running, cycling) and leg strength (squats, lunges). We recommend hiking with a loaded backpack 2–3 times per week for 3–6 months before your climb." },
            { q: "What is the temperature range on the mountain?", a: "Temperatures vary dramatically: rainforest zone (15–25°C), moorland (5–15°C), alpine desert (-5 to 10°C), summit (-10 to -20°C with wind chill). Proper layering is essential." },
            { q: "How much should my backpack weigh?", a: "Your daypack should be 5–8 kg (11–18 lbs) carrying water, snacks, extra layers, camera, and personal items. Porters carry the main duffel (max 15 kg / 33 lbs)." }
        ]
    }
];

export const FAQ = () => {
    const visuals = useVisuals();
    const [openIndex, setOpenIndex] = useState(null);
    const [searchQuery, setSearchQuery] = useState('');
    const [activeCategory, setActiveCategory] = useState('all');

    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const toggleFaq = (idx) => {
        setOpenIndex(openIndex === idx ? null : idx);
    };

    const containerVariants = {
        hidden: { opacity: 0 },
        visible: {
            opacity: 1,
            transition: { staggerChildren: 0.2, delayChildren: 0.3 }
        }
    };

    const itemVariants = {
        hidden: { opacity: 0, y: 30 },
        visible: { 
            opacity: 1, y: 0, 
            transition: { duration: 0.8, ease: [0.16, 1, 0.3, 1] } 
        }
    };

    // Filter FAQs based on search and category
    const filteredFaqs = useMemo(() => {
        return faqs
            .filter(category => activeCategory === 'all' || category.category === activeCategory)
            .map(category => ({
                ...category,
                items: category.items.filter(item =>
                    item.q.toLowerCase().includes(searchQuery.toLowerCase()) ||
                    item.a.toLowerCase().includes(searchQuery.toLowerCase())
                )
            }))
            .filter(category => category.items.length > 0);
    }, [searchQuery, activeCategory]);

    const categories = ['all', ...faqs.map(f => f.category)];

    let globalIdx = 0;

    return (
        <div className="utility-root faq-organic-root">
            <div className="grain-overlay" />
            {/* Hero Section */}
            <section className="utility-hero">
                <div className="utility-hero-bg">
                    <img src={visuals.getSingle('planning.faqHero', visualsData.planning.faqHero)} alt="Kilimanjaro summit with clear sky" />
                </div>
                <div className="utility-hero-overlay"></div>
                <motion.div className="utility-hero-content" initial="hidden" animate="visible" variants={containerVariants}>
                    <span className="utility-hero-eyebrow">Your Questions Answered</span>
                    <h1 className="utility-hero-title" style={{ fontSize: 'clamp(3rem, 5vw, 6.5rem)', fontFamily: "'Playfair Display', serif", fontWeight: 400, letterSpacing: '-0.02em' }}>
                        Frequently Asked Questions
                    </h1>
                    <p className="utility-hero-subtitle">
                        Everything you need to know about climbing Kilimanjaro, preparation, safety, and booking. Can't find your answer? Contact our team directly.
                    </p>
                </motion.div>
            </section>

            {/* Search & Filter Section */}
            <section className="faq-controls-section">
                <div className="faq-controls-container">
                    <div className="faq-search-wrapper">
                        <Search size={20} className="search-icon" />
                        <input
                            type="text"
                            placeholder="Search questions..."
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                            className="faq-search-input"
                        />
                        {searchQuery && (
                            <button onClick={() => setSearchQuery('')} className="clear-search">
                                Clear
                            </button>
                        )}
                    </div>
                    
                    <div className="faq-category-filter">
                        <span className="filter-label">Filter by:</span>
                        <div className="category-buttons">
                            {categories.map(cat => (
                                <button
                                    key={cat}
                                    className={`category-btn ${activeCategory === cat ? 'active' : ''}`}
                                    onClick={() => setActiveCategory(cat)}
                                >
                                    {cat === 'all' ? 'All Questions' : cat}
                                </button>
                            ))}
                        </div>
                    </div>
                </div>
            </section>

            {/* FAQ Body Redesign - Cinematic Bento */}
            <div className="bento-hero-curtain"></div>

            <section className="utility-content bento-theme">
                {/* Precision Search - Glass Pill */}
                <motion.div 
                    className="bento-search-container"
                    initial={{ opacity: 0, y: 20 }}
                    animate={{ opacity: 1, y: 0 }}
                    style={{ maxWidth: '600px', margin: '0 auto 80px', position: 'relative', zIndex: 10 }}
                >
                    <div style={{ 
                        background: 'rgba(255,255,255,0.03)', 
                        backdropFilter: 'blur(20px)', 
                        border: '1px solid rgba(255,255,255,0.1)', 
                        borderRadius: '99px',
                        padding: '12px 24px',
                        display: 'flex',
                        alignItems: 'center',
                        gap: '15px'
                    }}>
                        <Search size={20} color="rgba(255,255,255,0.4)" />
                        <input 
                            type="text" 
                            className="bento-search-input"
                            placeholder="Query the Archive..."
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                            style={{ 
                                background: 'transparent', 
                                border: 'none', 
                                outline: 'none', 
                                color: 'white', 
                                fontFamily: "'Outfit', sans-serif",
                                width: '100%',
                                fontSize: '1rem'
                            }}
                        />
                    </div>
                </motion.div>

                {filteredFaqs.length > 0 ? (
                    <div className="bento-grid">
                        {filteredFaqs.map((section, sIdx) => {
                            // Asymmetrical Bento Logic
                            const spans = ["span-8", "span-4", "span-4", "span-8"];
                            const currentSpan = spans[sIdx % spans.length];
                            
                            const sectionImages = {
                                "The Climb": visuals.getSingle('trekking.routes.lemoshoEditorial', visualsData.trekking.routes.lemoshoEditorial),
                                "Health & Safety": visuals.getSingle('trekking.health.altitudeEditorial', visualsData.trekking.health.altitudeEditorial),
                                "Booking & Logistics": visuals.getSingle('home.experienceMain', visualsData.home.experienceMain),
                                "Gear & Preparation": visuals.getSingle('planning.gearHero', visualsData.planning.gearHero)
                            };

                            return (
                                <motion.div 
                                    key={sIdx}
                                    className={`bento-card ${currentSpan}`}
                                    initial={{ opacity: 0, scale: 0.95 }}
                                    whileInView={{ opacity: 1, scale: 1 }}
                                    viewport={{ once: true }}
                                    transition={{ duration: 0.8, delay: sIdx * 0.1, ease: [0.16, 1, 0.3, 1] }}
                                >
                                    <div className="bento-card-bg-img">
                                        <img src={sectionImages[section.category]} alt={section.category} />
                                    </div>
                                    <div className="bento-card-gradient"></div>
                                    
                                    <div className="bento-card-content">
                                        <div className="bento-accent-pill">Subject {sIdx + 1}</div>
                                        <h2 className="bento-card-title">
                                            {section.category.split(' ')[0]} <em>{section.category.split(' ').slice(1).join(' ')}</em>
                                        </h2>

                                        <div className="bento-qa-list">
                                            {section.items.slice(0, 3).map((item, iIdx) => {
                                                const currentIndex = globalIdx++;
                                                const isOpen = openIndex === currentIndex;

                                                return (
                                                    <div 
                                                        key={currentIndex} 
                                                        className="bento-qa-item"
                                                        onClick={() => toggleFaq(currentIndex)}
                                                    >
                                                        <div className="bento-q">
                                                            <span>{item.q}</span>
                                                            <ChevronDown 
                                                                size={16} 
                                                                style={{ 
                                                                    transform: isOpen ? 'rotate(180deg)' : 'rotate(0)', 
                                                                    transition: 'transform 0.4s cubic-bezier(0.16, 1, 0.3, 1)',
                                                                    opacity: 0.5
                                                                }} 
                                                            />
                                                        </div>
                                                        <AnimatePresence>
                                                            {isOpen && (
                                                                <motion.div
                                                                    initial={{ height: 0, opacity: 0 }}
                                                                    animate={{ height: 'auto', opacity: 1 }}
                                                                    exit={{ height: 0, opacity: 0 }}
                                                                    transition={{ duration: 0.5, ease: [0.16, 1, 0.3, 1] }}
                                                                    className="bento-a"
                                                                >
                                                                    {item.a}
                                                                </motion.div>
                                                            )}
                                                        </AnimatePresence>
                                                    </div>
                                                );
                                            })}
                                        </div>
                                    </div>
                                </motion.div>
                            );
                        })}
                    </div>
                ) : (
                    <div className="no-results-bento" style={{ textAlign: 'center', padding: '100px 0' }}>
                        <h3 style={{ fontFamily: "'Playfair Display', serif", fontSize: '3rem', color: 'white' }}>No Records Found</h3>
                        <p style={{ color: 'rgba(255,255,255,0.4)', marginTop: '20px' }}>Your query remains unanswered in our current architecture.</p>
                        <button 
                            onClick={() => { setSearchQuery(''); setActiveCategory('all'); }}
                            style={{ 
                                marginTop: '40px', 
                                background: '#FF4A5A', 
                                color: 'white', 
                                border: 'none', 
                                padding: '15px 40px', 
                                borderRadius: '99px',
                                fontFamily: "'Outfit', sans-serif",
                                fontWeight: 700,
                                letterSpacing: '0.1em'
                            }}
                        >
                            Reset Architecture
                        </button>
                    </div>
                )}
            </section>

                {/* Contact CTA */}
                <motion.div
                    className="faq-contact-cta"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true }}
                    variants={containerVariants}
                >
                    <div className="cta-icon">
                        <MessageSquare size={32} />
                    </div>
                    <motion.h3 variants={itemVariants} style={{ fontFamily: "'Playfair Display', serif", fontWeight: 400, fontSize: '2.5rem' }}>Still have questions?</motion.h3>
                    <motion.p variants={itemVariants} style={{ opacity: 0.7, fontFamily: "'Inter', sans-serif" }}>Our expert team is here to help you plan your perfect adventure.</motion.p>
                    <div className="cta-buttons">
                        <a href="/contact" className="cta-btn primary">
                            <Mail size={18} />
                            Contact Us
                        </a>
                        <a href="tel:+255787654321" className="cta-btn secondary">
                            <Phone size={18} />
                            Call +255 787 654 321
                        </a>
                    </div>
                </motion.div>
        </div>
    );
};
