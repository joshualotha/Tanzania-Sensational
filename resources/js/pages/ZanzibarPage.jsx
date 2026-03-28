import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../data/visualsData';
import { useVisuals } from '../context/VisualsContext';
import '../styles/zanzibar-premium.css';

export const ZanzibarPage = () => {
    const visuals = useVisuals();
    useEffect(() => { window.scrollTo(0, 0); }, []);

    const fadeUp = {
        hidden: { opacity: 0, y: 100 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.8, ease: [0.16, 1, 0.3, 1] } }
    };

    const reveal = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { duration: 2, delay: 0.5 } }
    };

    return (
        <div className="zan-void-root">
            
            {/* ─── 1. THE PREAMBLE (100VH HERO) ─── */}
            <section className="zan-void-hero">
                <div className="zan-void-hero-bg">
                    <img src={visuals.getSingle('zanzibar.hero', visualsData.zanzibar.hero)} alt="Zanzibar" />
                </div>

                <motion.div 
                    className="zan-void-hero-content"
                    initial="hidden"
                    animate="visible"
                    variants={reveal}
                >
                    <h1 className="zan-void-h1">
                        Zanzibar.
                        <em>The essence of the ocean.</em>
                    </h1>
                </motion.div>
            </section>


            {/* ─── 2. THE ANCIENT HEART (STONE TOWN) ─── */}
            <section className="zan-void-section">
                <motion.div 
                    className="zan-void-img-focal"
                    initial={{ opacity: 0, clipPath: 'inset(100% 0 0 0)' }}
                    whileInView={{ opacity: 1, clipPath: 'inset(0% 0 0 0)' }}
                    transition={{ duration: 2, ease: [0.16, 1, 0.3, 1] }}
                    viewport={{ once: true, margin: "-100px" }}
                >
                    <img src={visualsData.zanzibar.regionStoneTown} alt="Stone Town" />
                </motion.div>

                <motion.div 
                    className="zan-void-text-wrap"
                    initial="hidden"
                    whileInView="visible"
                    viewport={{ once: true }}
                    variants={fadeUp}
                >
                    <h2 className="zan-void-title">Ancient Heart.</h2>
                    <p className="zan-void-p">
                        "In the labyrinth of Stone Town, time is not a line, but a scent of cloves and aging coral rag."
                    </p>
                </motion.div>
            </section>


            {/* ─── 3. THE ENDLESS HORIZON (FULL-BLEED) ─── */}
            <section className="zan-void-horizon">
                <div className="zan-void-horizon-bg">
                    <img src={visualsData.zanzibar.regionNungwi} alt="Nungwi" />
                </div>
                
                <motion.div 
                    className="zan-void-horizon-label"
                    initial={{ opacity: 0, letterSpacing: '0em' }}
                    whileInView={{ opacity: 1, letterSpacing: '0.6em' }}
                    transition={{ duration: 2.5 }}
                    viewport={{ once: true }}
                >
                    PRISTINE SILENCE.
                </motion.div>
            </section>


            {/* ─── 4. THE SIGNATURE EXPEDITION (SAFARI BLUE) ─── */}
            <section className="zan-void-focus">
                <div className="zan-void-focus-inner">
                    <motion.div 
                        className="zan-void-focus-img"
                        initial={{ opacity: 0, x: -50 }}
                        whileInView={{ opacity: 1, x: 0 }}
                        transition={{ duration: 1.5, ease: [0.16, 1, 0.3, 1] }}
                        viewport={{ once: true }}
                    >
                        <img src={visualsData.zanzibar.expSafariBlue} alt="Safari Blue" />
                    </motion.div>

                    <motion.div 
                        initial="hidden"
                        whileInView="visible"
                        viewport={{ once: true }}
                        variants={fadeUp}
                    >
                        <span className="zan-hero-m-eyebrow" style={{ color: 'var(--primary)', marginBottom: '30px' }}>The Signature Dispatch</span>
                        <h2 className="zan-void-title" style={{ textAlign: 'left' }}>The Dhow <em>Voyage.</em></h2>
                        <p className="zan-layer-desc" style={{ textAlign: 'left', fontStyle: 'italic' }}>
                            A bespoke mahogany dhow to the Menai Bay area. Snorkel, dine on a sandbank seafood BBQ, and relax in absolute seclusion.
                        </p>
                        <div style={{ textAlign: 'left' }}>
                            <Link to="/contact" className="zan-btn-void">Commence Inquiry</Link>
                        </div>
                    </motion.div>
                </div>
            </section>


            {/* ─── 5. THE VOID (FOOTER) ─── */}
            <section className="zan-void-footer">
                <motion.div
                    initial={{ opacity: 0 }}
                    whileInView={{ opacity: 1 }}
                    transition={{ duration: 2 }}
                    viewport={{ once: true }}
                >
                    <h2 className="zan-void-h1" style={{ fontSize: '4rem', opacity: 0.5 }}>End of the Island.</h2>
                    <p style={{ letterSpacing: '0.3em', opacity: 0.3, marginTop: '40px' }}>© TANZANIA SENSATIONAL ARCHIVES</p>
                </motion.div>
            </section>

        </div>
    );
};
