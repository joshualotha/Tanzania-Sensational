import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Backpack, ThermometerSnowflake, Ruler, Shirt, Check, Download, PackageOpen, ClipboardList } from 'lucide-react';
import { jsPDF } from 'jspdf';
import '../../../styles/trekking-prep.css';

const GEAR_DATA = [
    {
        category: "Bags & Packs",
        icon: <Backpack size={30} />,
        items: [
            { id: "duffle", label: "Duffle Bag (70-90L)", desc: "Soft-shell, waterproof, max 15kg for porters." },
            { id: "daypack", label: "Day Pack (30-40L)", desc: "With rain cover for daily essentials and 3L water." },
            { id: "drybags", label: "Dry Bags (Set of 3)", desc: "Internal waterproofing for all internal cargo." }
        ]
    },
    {
        category: "Sleeping Equipment",
        icon: <ThermometerSnowflake size={30} />,
        items: [
            { id: "sleepingbag", label: "4-Season Sleeping Bag", desc: "Rated to -15°C for high-altitude nights." },
            { id: "liner", label: "Sleeping Bag Liner", desc: "Silk or fleece for added insulation and hygiene." },
            { id: "pillow", label: "Inflatable Pillow", desc: "Compact support for better recovery." }
        ]
    },
    {
        category: "Technical Clothing",
        icon: <Shirt size={30} />,
        items: [
            { id: "hardshell", label: "GoreTex Hard Shell", desc: "Windproof and waterproof outer layer." },
            { id: "downjacket", label: "Heavy Down Parka", desc: "Substantial insulation for summit night." },
            { id: "midlayer", label: "Fleece Mid-Layer", desc: "1-2 weights for temperature regulation." },
            { id: "base", label: "Merino Base Layers", desc: "Moisture-wicking tops and bottoms (No cotton)." },
            { id: "gloves", label: "Insulated Mitts", desc: "Thick outer gloves + thin inner liners." }
        ]
    },
    {
        category: "Footwear",
        icon: <Ruler size={30} />,
        items: [
            { id: "boots", label: "Trekking Boots", desc: "Waterproof, high-ankle, and fully broken-in." },
            { id: "socks", label: "Thermal Socks", desc: "Heavyweight wool for summit + trekking pairs." },
            { id: "gaiters", label: "Gaiters", desc: "Prevents scree and water from entering boots." }
        ]
    }
];

const GearList = () => {
    const [checkedItems, setCheckedItems] = useState(() => {
        const saved = localStorage.getItem('trek_manifest_checked');
        return saved ? JSON.parse(saved) : [];
    });

    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    useEffect(() => {
        localStorage.setItem('trek_manifest_checked', JSON.stringify(checkedItems));
    }, [checkedItems]);

    const toggleItem = (id) => {
        setCheckedItems(prev =>
            prev.includes(id) ? prev.filter(i => i !== id) : [...prev, id]
        );
    };

    const totalItems = GEAR_DATA.reduce((acc, cat) => acc + cat.items.length, 0);
    const progress = (checkedItems.length / totalItems) * 100;

    const downloadPDF = () => {
        const doc = new jsPDF();
        const gold = "#C9A84C";
        const dark = "#1A1A17";

        // Brand Header
        doc.setFillColor(dark);
        doc.rect(0, 0, 210, 40, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFont("helvetica", "bold");
        doc.setFontSize(22);
        doc.text("EXPEDITION MANIFEST", 20, 25);

        doc.setFontSize(10);
        doc.setTextColor(gold);
        doc.text("TANZANIA SENSATIONAL — KILIMANJARO & MERU", 20, 32);

        let y = 60;

        GEAR_DATA.forEach((cat) => {
            // Category Title
            doc.setFontSize(14);
            doc.setTextColor(dark);
            doc.setFont("helvetica", "bold");
            doc.text(cat.category.toUpperCase(), 20, y);

            doc.setDrawColor(gold);
            doc.setLineWidth(0.5);
            doc.line(20, y + 2, 80, y + 2);

            y += 15;

            cat.items.forEach(item => {
                const isChecked = checkedItems.includes(item.id);

                // Checkbox
                doc.setDrawColor(200, 200, 200);
                doc.rect(20, y - 4, 5, 5);
                if (isChecked) {
                    doc.setFillColor(gold);
                    doc.rect(20, y - 4, 5, 5, 'F');
                    doc.setTextColor(gold);
                } else {
                    doc.setTextColor(100, 100, 100);
                }

                doc.setFontSize(11);
                doc.setFont("helvetica", isChecked ? "bold" : "normal");
                doc.text(item.label, 30, y);

                doc.setFontSize(9);
                doc.setFont("helvetica", "normal");
                doc.setTextColor(150, 150, 150);
                doc.text(item.desc, 30, y + 5);

                y += 15;

                // Page break check
                if (y > 270) {
                    doc.addPage();
                    y = 20;
                }
            });

            y += 10;
        });

        // Footer
        const finalY = doc.internal.pageSize.height - 20;
        doc.setFontSize(8);
        doc.setTextColor(180, 180, 180);
        doc.text("Generated on " + new Date().toLocaleDateString() + " | Prepare for the Summit.", 20, finalY);

        doc.save('Expedition_Manifest.pdf');
    };

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.16, 1, 0.3, 1] } }
    };

    return (
        <div className="prep-savanna-root">
            {/* ─── HERO ─── */}
            <section className="prep-hero">
                <div className="prep-hero-bg">
                    <img
                        src="https://images.unsplash.com/photo-1542282088-fe8426682b8f?ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80"
                        alt="Expedition Inventory"
                    />
                    <div className="prep-hero-overlay"></div>
                </div>
                <div className="prep-hero-content">
                    <motion.span className="prep-eyebrow" initial="hidden" animate="visible" variants={fadeInUp}>Inventory Protocol</motion.span>
                    <motion.h1 className="prep-hero-title" initial="hidden" animate="visible" variants={fadeInUp}>Equip for the <em>Elements.</em></motion.h1>
                </div>
            </section>

            {/* ─── EDITORIAL INTRO ─── */}
            <section className="prep-grid-section">
                <div className="prep-editorial-grid">
                    <motion.div
                        className="prep-editorial-img-wrap"
                        initial={{ opacity: 0, scale: 0.95 }}
                        whileInView={{ opacity: 1, scale: 1 }}
                        transition={{ duration: 1.2, ease: [0.16, 1, 0.3, 1] }}
                    >
                        <img
                            src="https://images.unsplash.com/photo-1536882240095-0379873feb4e?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80"
                            className="prep-editorial-img"
                            alt="Precision Preparation"
                        />
                        <span className="prep-img-caption">Precision in packing is the hallmark of a professional.</span>
                    </motion.div>
                    <div className="prep-editorial-text">
                        <motion.span className="prep-eyebrow" initial="hidden" whileInView="visible" variants={fadeInUp}>The Essentials</motion.span>
                        <h2 className="prep-section-title">The Master <em>Inventory.</em></h2>
                        <p className="prep-body-text">
                            Kilimanjaro is a mountain of vast microclimates. Your gear must perform in everything from humid rain forests to the sub-zero arctic environment of the summit.
                        </p>
                        <p className="prep-body-text">
                            Below is your interactive <strong>Expedition Manifest</strong>. Track your readiness in real-time and export your personalized checklist as a PDF for offline reference during final staging.
                        </p>
                    </div>
                </div>
            </section>

            {/* ─── THE MANIFEST (INTERACTIVE) ─── */}
            <section className="manifest-section">
                <motion.div
                    className="manifest-hud"
                    initial={{ opacity: 0, y: 30 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    viewport={{ once: true }}
                >
                    <div className="manifest-progress-col">
                        <span className="manifest-status-text">Manifest Progress</span>
                        <div className="manifest-counter">{checkedItems.length} <small style={{ fontSize: '1rem', opacity: 0.5 }}>/ {totalItems}</small></div>
                        <div className="manifest-bar-wrap">
                            <motion.div
                                className="manifest-bar-fill"
                                style={{ scaleX: progress / 100 }}
                            />
                        </div>
                    </div>
                    <button onClick={downloadPDF} className="prep-btn-sand" style={{ display: 'flex', alignItems: 'center', gap: '12px', border: 'none', cursor: 'pointer' }}>
                        <Download size={20} />
                        Download Manifest
                    </button>
                </motion.div>

                <div className="manifest-grid">
                    {GEAR_DATA.map((cat, idx) => (
                        <motion.div
                            key={idx}
                            className="manifest-category"
                            initial={{ opacity: 0, y: 20 }}
                            whileInView={{ opacity: 1, y: 0 }}
                            transition={{ delay: idx * 0.1 }}
                        >
                            <h3 className="manifest-cat-title">
                                {cat.icon}
                                {cat.category}
                            </h3>
                            <div className="manifest-item-list">
                                {cat.items.map(item => (
                                    <div
                                        key={item.id}
                                        className={`manifest-item ${checkedItems.includes(item.id) ? 'checked' : ''}`}
                                        onClick={() => toggleItem(item.id)}
                                    >
                                        <div className="manifest-checkbox">
                                            {checkedItems.includes(item.id) && <Check size={16} color="white" />}
                                        </div>
                                        <div className="manifest-item-text">
                                            <span className="manifest-item-label">{item.label}</span>
                                            <span className="manifest-item-desc">{item.desc}</span>
                                        </div>
                                    </div>
                                ))}
                            </div>
                        </motion.div>
                    ))}
                </div>
            </section>

            <section className="prep-highlight-box">
                <h3 className="prep-highlight-title">Concierge Support</h3>
                <p className="prep-highlight-text">
                    Struggling with technical specifications? Our Moshi-based staging team provides professional fitting and high-altitude gear rentals at our headquarters. From Mountain Hardwear bags to technical parkas—we ensure you are inserted onto the mountain with zero vulnerability.
                </p>
            </section>

            <section className="prep-cta-band">
                <h2 className="prep-cta-title">Finalize the <em>Logistics.</em></h2>
                <div className="prep-btn-group">
                    <Link to="/trekking/after/getting-there" className="prep-btn-sand">Travel Logistics</Link>
                    <Link to="/trekking/after/visa" className="prep-btn-outline">Visa Requirements</Link>
                </div>
            </section>
        </div>
    );
};

export default GearList;
