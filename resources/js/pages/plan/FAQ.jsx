import React, { useEffect, useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import '../../styles/utility-pages-premium.css';

const faqs = [
    {
        category: "The Climb",
        items: [
            { q: "How difficult is climbing Kilimanjaro?", a: "Kilimanjaro is a non-technical mountain, meaning no ropes or ice axes are needed for the standard routes. However, it is an extreme altitude trek. The physical exertion combined with lower oxygen levels makes it a strenuous challenge requiring mental fortitude and physical preparation." },
            { q: "Which route has the highest success rate?", a: "The longer routes—Lemosho (8 days) and Northern Circuit (9 days)—have the highest success rates, often exceeding 90%. They allow for the necessary 'climb high, sleep low' acclimatization profile." },
            { q: "Do I need to be a professional athlete?", a: "No. Age and fitness levels vary wildly on the mountain. Mental determination and pacing ('Pole Pole' - slowly slowly) are often more important than raw physical strength." }
        ]
    },
    {
        category: "Health & Safety",
        items: [
            { q: "What is Altitude Sickness (AMS)?", a: "Acute Mountain Sickness occurs when ascending to high altitudes too quickly. Symptoms include headache, nausea, and fatigue. Our guides monitor heart rate and oxygen saturation twice daily to catch early signs." },
            { q: "What happens if I cannot continue?", a: "Safety is paramount. If you must descend, an assistant guide will escort you down safely. Depending on your location and the severity of your condition, we will coordinate an evacuation to the nearest gate or organize medical helicopter air-lift." },
            { q: "Is the water safe to drink?", a: "Our porters gather fresh mountain stream water daily, which is then boiled and purified at camp before being served to you. You will need to bring iodine or purification tablets only as an emergency backup." }
        ]
    }
];

export const FAQ = () => {
    const visuals = useVisuals();
    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const [openIndex, setOpenIndex] = useState(null);

    const toggleFaq = (idx) => {
        setOpenIndex(openIndex === idx ? null : idx);
    };

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8 } }
    };

    let globalIdx = 0;

    return (
        <div className="utility-root">
            <section className="utility-hero">
                <div className="utility-hero-bg">
                    <img src={visuals.getSingle('planning.faqHero', visualsData.planning.faqHero)} alt="Questions" />
                </div>
                <div className="utility-hero-overlay"></div>
                <motion.div className="utility-hero-content" initial="hidden" animate="visible" variants={fadeInUp}>
                    <h1 className="utility-hero-title" style={{ fontSize: 'clamp(3rem, 5vw, 4.5rem)' }}>Frequently Asked Questions</h1>
                </motion.div>
            </section>

            <section className="utility-content">
                <div className="faq-container">
                    {faqs.map((section, sIdx) => (
                        <motion.div key={sIdx} initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                            <h2 className="faq-category-title">{section.category}</h2>
                            {section.items.map((item) => {
                                const currentIndex = globalIdx++;
                                const isOpen = openIndex === currentIndex;
                                return (
                                    <div className="faq-item" key={currentIndex}>
                                        <div className="faq-question" onClick={() => toggleFaq(currentIndex)}>
                                            {item.q}
                                            <div className={`faq-icon ${isOpen ? 'open' : ''}`}>
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                            </div>
                                        </div>
                                        <AnimatePresence>
                                            {isOpen && (
                                                <motion.div
                                                    initial={{ height: 0, opacity: 0 }}
                                                    animate={{ height: 'auto', opacity: 1 }}
                                                    exit={{ height: 0, opacity: 0 }}
                                                    transition={{ duration: 0.3 }}
                                                    style={{ overflow: 'hidden' }}
                                                >
                                                    <div className="faq-answer">{item.a}</div>
                                                </motion.div>
                                            )}
                                        </AnimatePresence>
                                    </div>
                                );
                            })}
                        </motion.div>
                    ))}
                </div>
            </section>
        </div>
    );
};
