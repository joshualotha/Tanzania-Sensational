import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link, usePage } from '@inertiajs/react';
import {
    Compass, Map, Sun, Clock, Shield, Users,
    Camera, Heart, Luggage, BookOpen, ArrowRight,
    ChevronRight, Globe, Star, Trees, Waves
} from 'lucide-react';
import { visualsData } from '../../data/visualsData';
import '../../styles/safari-field-guide.css';

const SafariPillar = ({ destinations, packages }) => {
    const { props } = usePage();
    const visuals = props.visuals;

    useEffect(() => { window.scrollTo(0, 0); }, []);

    const getVisual = (section, fallback) => {
        if (visuals?.[section]?.[0]) return visuals[section][0];
        return fallback;
    };

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const stagger = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.1 } }
    };

    const guideTopics = [
        { slug: 'what-to-wear', label: 'What to Wear on Safari', icon: Luggage, desc: 'Essential safari clothing guide — from lightweight khakis to evening layers for bush dinners.' },
        { slug: 'packing-guide', label: 'Safari Packing List', icon: BookOpen, desc: 'Complete packing checklist for your East African safari adventure.' },
        { slug: 'health-and-safety', label: 'Health & Safety', icon: Shield, desc: 'Vaccinations, malaria prevention, and wildlife safety protocols.' },
        { slug: 'local-customs', label: 'Local Customs & Etiquette', icon: Heart, desc: 'Cultural norms, photography etiquette, and respectful travel practices.' },
        { slug: 'accommodation-style', label: 'Accommodation Styles', icon: Map, desc: 'From luxury lodges to mobile tented camps — find your safari style.' },
        { slug: 'visa-guide', label: 'Tanzania Visa Guide', icon: Globe, desc: 'Visa requirements, application process, and entry requirements for Tanzania.' },
    ];

    const planningTopics = [
        { slug: '/faq', label: 'Frequently Asked Questions', icon: Compass, desc: 'Quick answers to the most common safari questions.' },
        { slug: '/group-departures', label: 'Group Joining Safaris', icon: Users, desc: 'Fixed-departure group safaris for solo travelers and small groups.' },
        { slug: '/safari-addons', label: 'Safari Add-ons & Extensions', icon: Camera, desc: 'Zanzibar beach extensions, gorilla trekking, and cultural experiences.' },
        { slug: '/safaris/packages', label: 'Browse All Packages', icon: Star, desc: 'View our complete collection of curated safari expeditions.' },
    ];

    const destinationsList = [
        { slug: 'serengeti', name: 'Serengeti National Park', tagline: 'The Endless Plains', desc: 'The world\'s most iconic wildlife destination — home to the Great Migration and the Big Five.' },
        { slug: 'ngorongoro', name: 'Ngorongoro Crater', tagline: 'Africa\'s Eden', desc: 'A UNESCO World Heritage Site and the world\'s largest intact volcanic caldera.' },
        { slug: 'tarangire', name: 'Tarangire National Park', tagline: 'Land of Giants', desc: 'Famous for its massive elephant herds and ancient baobab trees.' },
        { slug: 'manyara', name: 'Lake Manyara National Park', tagline: 'The Rift Valley Gem', desc: 'Known for tree-climbing lions, flamingos, and stunning groundwater forests.' },
        { slug: 'arusha', name: 'Arusha National Park', tagline: 'The Miniature Gem', desc: 'A compact park with diverse landscapes — from Mount Meru to crater lakes.' },
        { slug: 'ruaha', name: 'Ruaha National Park', tagline: 'The Wild Frontier', desc: 'Tanzania\'s largest national park — remote, rugged, and teeming with wildlife.' },
        { slug: 'selous', name: 'Nyerere (Selous) Reserve', tagline: 'Untamed Wilderness', desc: 'One of Africa\'s largest protected areas — known for boat safaris on the Rufiji River.' },
        { slug: 'katavi', name: 'Katavi National Park', tagline: 'The Last Wilderness', desc: 'Remote and untouched — for the adventurous traveler seeking true solitude.' },
    ];

    const styleTopics = [
        { slug: '/safaris/family', label: 'Family Safaris', icon: Heart, desc: 'Kid-friendly itineraries with educational activities.' },
        { slug: '/safaris/honeymoon', label: 'Honeymoon Safaris', icon: Heart, desc: 'Romantic escapes with luxury bush dining and sundowners.' },
        { slug: '/safaris/luxury', label: 'Luxury Safaris', icon: Star, desc: 'Premium lodges, private guides, and exclusive experiences.' },
        { slug: '/safaris/photographic', label: 'Photographic Safaris', icon: Camera, desc: 'Specialist-led trips for wildlife photography enthusiasts.' },
        { slug: '/safaris/group-joining', label: 'Group Joining', icon: Users, desc: 'Join scheduled departures with shared costs and new friends.' },
    ];

    return (
        <div className="field-root">
            {/* ─── CINEMATIC HERO ─── */}
            <section className="field-hero">
                <div className="field-hero-img">
                    <img
                        src={getVisual('safaris.pillar.hero', 'https://images.unsplash.com/photo-1516422213484-2af298bf06ad?auto=format&fit=crop&q=80')}
                        alt="African Safari — The Ultimate Guide to Tanzania Wildlife Expeditions"
                    />
                </div>
                <div className="field-hero-gradient"></div>
                <div className="field-hero-content">
                    <motion.div
                        initial="hidden"
                        animate="visible"
                        variants={stagger}
                    >
                        <motion.span className="field-hero-eyebrow" variants={fadeInUp}>The Complete Guide</motion.span>
                        <motion.h1 className="field-hero-title" variants={fadeInUp}>
                            Tanzania <em>Safari.</em>
                        </motion.h1>
                        <motion.p className="field-hero-subtitle" variants={fadeInUp}>
                            Everything you need to plan the ultimate East African safari — from choosing your destination to packing for the bush.
                        </motion.p>
                    </motion.div>
                </div>
            </section>

            {/* ─── INTRO CHAPTER ─── */}
            <section className="field-chapter">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">Your Safari Journey</span>
                    <h2 className="field-chapter-title">Africa's Greatest Wildlife <em>Experience</em></h2>
                    <p className="field-chapter-body">
                        Tanzania is home to some of the most spectacular wildlife viewing on Earth. From the endless plains of the 
                        Serengeti — where the Great Migration sees over 1.5 million wildebeest thunder across the savannah — to the 
                        Ngorongoro Crater, a natural amphitheatre teeming with predators and prey, Tanzania offers safari experiences 
                        that are simply unmatched anywhere else on the continent.
                    </p>
                    <p className="field-chapter-body">
                        Whether you are a first-time safari-goer or a seasoned wildlife enthusiast, this guide covers everything you 
                        need to plan your perfect Tanzania safari. Explore our destinations, compare packages, and prepare for the 
                        adventure of a lifetime.
                    </p>
                </motion.div>
            </section>

            {/* ─── DESTINATIONS ─── */}
            <section className="field-chapter">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">Choose Your Wilderness</span>
                    <h2 className="field-chapter-title">Safari <em>Destinations</em></h2>
                    <p className="field-chapter-body">
                        Tanzania's national parks and game reserves each offer a unique character and wildlife experience. 
                        Explore them below to find your perfect safari destination.
                    </p>
                </motion.div>

                <motion.div
                    className="field-pillar-grid field-pillar-grid-4"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={stagger}
                >
                    {destinationsList.map((dest) => (
                        <motion.div key={dest.slug} className="field-pillar-card" variants={fadeInUp}>
                            <div className="field-pillar-card-body">
                                <div className="field-pillar-card-eyebrow">{dest.tagline}</div>
                                <h3 className="field-pillar-card-title">{dest.name}</h3>
                                <p className="field-pillar-card-desc">{dest.desc}</p>
                            </div>
                            <Link href={`/safaris/destinations/${dest.slug}`} className="field-pillar-card-link">
                                Explore Destination <ArrowRight size={14} />
                            </Link>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ─── SAFARI PACKAGES ─── */}
            <section className="field-chapter field-section-alt">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">Curated Expeditions</span>
                    <h2 className="field-chapter-title">Safari <em>Packages</em></h2>
                    <p className="field-chapter-body">
                        From intimate 3-day getaways to comprehensive 14-day expeditions, our safari packages are designed 
                        to match every travel style and budget.
                    </p>
                </motion.div>

                <motion.div
                    className="field-pillar-grid field-pillar-grid-3"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={stagger}
                >
                    {packages && packages.length > 0 ? packages.slice(0, 6).map((pkg) => (
                        <motion.div key={pkg.id} className="field-pillar-card" variants={fadeInUp}>
                            <div className="field-pillar-card-body">
                                <div className="field-pillar-card-eyebrow">{pkg.category || 'SIGNATURE'} · {pkg.duration} Days</div>
                                <h3 className="field-pillar-card-title">{pkg.name}</h3>
                                <p className="field-pillar-card-desc">
                                    {pkg.description ? pkg.description.substring(0, 120) + '...' : 'An exclusive safari expedition through Tanzania\'s most magnificent wilderness.'}
                                </p>
                                <div className="field-pillar-card-meta">
                                    <span>From ${Math.round(pkg.base_price)}</span>
                                </div>
                            </div>
                            <Link href={`/safaris/packages/${pkg.slug}`} className="field-pillar-card-link">
                                View Package <ArrowRight size={14} />
                            </Link>
                        </motion.div>
                    )) : (
                        <motion.div variants={fadeInUp}>
                            <Link href="/safaris/packages" className="field-pillar-card">
                                <div className="field-pillar-card-body">
                                    <h3 className="field-pillar-card-title">Browse All Packages</h3>
                                    <p className="field-pillar-card-desc">View our complete collection of curated safari expeditions.</p>
                                </div>
                                <span className="field-pillar-card-link">
                                    View All Packages <ArrowRight size={14} />
                                </span>
                            </Link>
                        </motion.div>
                    )}
                </motion.div>

                <motion.div
                    style={{ textAlign: 'center', marginTop: '60px' }}
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true }}
                    variants={fadeInUp}
                >
                    <Link href="/safaris/packages" className="field-btn">
                        View All Safari Packages <ArrowRight size={16} />
                    </Link>
                </motion.div>
            </section>

            {/* ─── SAFARI GUIDE TOPICS ─── */}
            <section className="field-chapter">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">Prepare for the Bush</span>
                    <h2 className="field-chapter-title">Safari Preparation <em>Guides</em></h2>
                    <p className="field-chapter-body">
                        Proper preparation transforms a good safari into an extraordinary one. These guides cover everything 
                        from what to pack to understanding local customs.
                    </p>
                </motion.div>

                <motion.div
                    className="field-pillar-grid field-pillar-grid-3"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={stagger}
                >
                    {guideTopics.map((topic) => (
                        <motion.div key={topic.slug} className="field-pillar-card" variants={fadeInUp}>
                            <div className="field-pillar-card-body">
                                <topic.icon size={24} className="field-pillar-card-icon" />
                                <h3 className="field-pillar-card-title">{topic.label}</h3>
                                <p className="field-pillar-card-desc">{topic.desc}</p>
                            </div>
                            <Link href={`/safari-guide/${topic.slug}`} className="field-pillar-card-link">
                                Read Guide <ArrowRight size={14} />
                            </Link>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ─── PLANNING RESOURCES ─── */}
            <section className="field-chapter field-section-alt">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">Plan Your Adventure</span>
                    <h2 className="field-chapter-title">Planning <em>Resources</em></h2>
                    <p className="field-chapter-body">
                        From frequently asked questions to group joining options, these resources will help you plan 
                        every aspect of your safari.
                    </p>
                </motion.div>

                <motion.div
                    className="field-pillar-grid field-pillar-grid-4"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={stagger}
                >
                    {planningTopics.map((topic) => (
                        <motion.div key={topic.label} className="field-pillar-card" variants={fadeInUp}>
                            <div className="field-pillar-card-body">
                                <topic.icon size={24} className="field-pillar-card-icon" />
                                <h3 className="field-pillar-card-title">{topic.label}</h3>
                                <p className="field-pillar-card-desc">{topic.desc}</p>
                            </div>
                            <Link href={topic.slug} className="field-pillar-card-link">
                                Learn More <ArrowRight size={14} />
                            </Link>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ─── SAFARI BY STYLE ─── */}
            <section className="field-chapter">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">Find Your Style</span>
                    <h2 className="field-chapter-title">Safari by Travel <em>Style</em></h2>
                    <p className="field-chapter-body">
                        Whether you are travelling with family, celebrating a honeymoon, or seeking luxury — we have a safari 
                        designed for your needs.
                    </p>
                </motion.div>

                <motion.div
                    className="field-pillar-grid field-pillar-grid-5"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={stagger}
                >
                    {styleTopics.map((style) => (
                        <motion.div key={style.slug} className="field-pillar-card" variants={fadeInUp}>
                            <div className="field-pillar-card-body">
                                <style.icon size={24} className="field-pillar-card-icon" />
                                <h3 className="field-pillar-card-title">{style.label}</h3>
                                <p className="field-pillar-card-desc">{style.desc}</p>
                            </div>
                            <Link href={style.slug} className="field-pillar-card-link">
                                Explore <ArrowRight size={14} />
                            </Link>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ─── FAQ SNIPPET ─── */}
            <section className="field-chapter field-section-alt">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <span className="field-chapter-eyebrow">Quick Answers</span>
                    <h2 className="field-chapter-title">Frequently Asked <em>Questions</em></h2>

                    <div className="field-pillar-faq">
                        <div className="field-pillar-faq-item">
                            <h3>When is the best time to go on safari in Tanzania?</h3>
                            <p>The dry season (June to October) offers the best wildlife viewing, as animals congregate around water sources. The wildebeest migration peaks in the Serengeti from July to September. The green season (November to May) offers lush landscapes, fewer crowds, and lower rates.</p>
                        </div>
                        <div className="field-pillar-faq-item">
                            <h3>What is the Big Five and will I see them?</h3>
                            <p>The Big Five — lion, leopard, elephant, buffalo, and rhino — are all present in Tanzania. You are highly likely to see lions, elephants, and buffalo in most parks. Leopards require a keen eye, and rhinos are most reliably seen at Ngorongoro Crater.</p>
                        </div>
                        <div className="field-pillar-faq-item">
                            <h3>Is a safari safe for children?</h3>
                            <p>Yes, many of our family-friendly safaris are designed specifically for children. We recommend private vehicles, shorter game drives, and lodges with family facilities. Children aged 6+ generally enjoy the experience most. See our <Link href="/safaris/family">family safaris</Link> for more details.</p>
                        </div>
                        <div className="field-pillar-faq-item">
                            <h3>What should I pack for a Tanzania safari?</h3>
                            <p>Lightweight, neutral-coloured clothing, a warm layer for morning game drives, comfortable walking shoes, sunscreen, insect repellent, a hat, binoculars, and a camera with a zoom lens. See our <Link href="/safari-guide/packing-guide">complete packing list</Link> for details.</p>
                        </div>
                    </div>

                    <div style={{ textAlign: 'center', marginTop: '60px' }}>
                        <Link href="/faq" className="field-btn">
                            View All FAQs <ChevronRight size={16} />
                        </Link>
                    </div>
                </motion.div>
            </section>

            {/* ─── FINAL CTA ─── */}
            <section className="field-cta">
                <motion.div
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true, margin: '-100px' }}
                    variants={fadeInUp}
                >
                    <h2 className="field-cta-title">Ready for the <em>Adventure?</em></h2>
                    <p className="field-cta-body">
                        Whether you have a specific itinerary in mind or need help designing the perfect safari from scratch, 
                        our expert team is here to help.
                    </p>
                    <div style={{ display: 'flex', gap: '20px', justifyContent: 'center', flexWrap: 'wrap' }}>
                        <Link href="/safaris/packages" className="field-btn">
                            Browse Safari Packages <ArrowRight size={16} />
                        </Link>
                        <Link href="/contact" className="field-btn" style={{ borderColor: 'var(--field-gold)', color: 'var(--field-gold)' }}>
                            Contact Our Team
                        </Link>
                    </div>
                </motion.div>
            </section>
        </div>
    );
};

export default SafariPillar;
