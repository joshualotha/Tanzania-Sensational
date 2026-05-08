import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from '@inertiajs/react';
import { usePage } from '@inertiajs/react';
import { visualsData } from '../../data/visualsData';
import '../../styles/utility-pages-premium.css';

const SafariAddons = () => {
    const { props } = usePage();
    const visuals = props.visuals;

    const getVisual = (section, fallback) => {
        if (visuals?.[section]?.[0]) return visuals[section][0];
        return fallback;
    };

    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.15, delayChildren: 0.1 } }
    };

    return (
        <div className="utility-root">
            <section className="utility-hero">
                <div className="utility-hero-bg">
                    <img src={getVisual('planning.addonsHero', visualsData.planning.addonsHero)} alt="Tanzania safari add-on — wildlife viewing on the Serengeti plains after Kilimanjaro trek" />
                </div>
                <div className="utility-hero-overlay"></div>
                <motion.div className="utility-hero-content" initial="hidden" animate="visible" variants={staggerContainer}>
                    <motion.span className="utility-hero-eyebrow" variants={fadeInUp}>The Reward</motion.span>
                    <motion.h1 className="utility-hero-title" variants={fadeInUp}>Post-Trek Safari Add-ons</motion.h1>
                    <motion.p className="utility-hero-subtitle" variants={fadeInUp}>
                        You conquered the Roof of Africa. Now rest your legs in the back of a luxury 4x4 and witness the greatest wildlife spectacle on earth.
                    </motion.p>
                </motion.div>
            </section>

            <section className="utility-content">
                <motion.div className="utility-grid" initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-50px" }} variants={staggerContainer} style={{ gridTemplateColumns: '1fr 1fr' }}>

                    <motion.div className="util-card" variants={fadeInUp} style={{ padding: 0, overflow: 'hidden' }}>
                        <img src={getVisual('planning.addonsCrater', visualsData.planning.addonsCrater)} alt="Ngorongoro Crater in Tanzania — post-trek safari add-on destination with wildlife and volcanic caldera views" style={{ width: '100%', height: '300px', objectFit: 'cover' }} loading="lazy" />
                        <div style={{ padding: '40px' }}>
                            <h3 className="util-card-title">2-Day Tarangire & Ngorongoro</h3>
                            <p className="util-card-p" style={{ marginBottom: '20px' }}>
                                The perfect taste of the wild for those short on time. Witness the massive elephant herds of Tarangire before descending into the legendary Ngorongoro Crater in search of the Big Five.
                            </p>
                            <Link href="/safaris/packages/great-migration-edition" className="dep-btn" style={{ border: 'none', padding: 0, textDecoration: 'underline', textUnderlineOffset: '6px' }}>View Safari Packages</Link>
                        </div>
                    </motion.div>

                    <motion.div className="util-card" variants={fadeInUp} style={{ padding: 0, overflow: 'hidden' }}>
                        <img src={getVisual('planning.addonsZanzibar', visualsData.planning.addonsZanzibar)} alt="Zanzibar beaches — white sand and turquoise water post-trek recovery destination in Tanzania" style={{ width: '100%', height: '300px', objectFit: 'cover' }} loading="lazy" />
                        <div style={{ padding: '40px' }}>
                            <h3 className="util-card-title">Zanzibar Beach Recovery</h3>
                            <p className="util-card-p" style={{ marginBottom: '20px' }}>
                                Trade your hiking boots for bare feet. A direct flight from Arusha lands you on the pristine white sands of the Spice Island. The ultimate relaxation after the rigors of the mountain.
                            </p>
                            <Link href="/zanzibar" className="dep-btn" style={{ border: 'none', padding: 0, textDecoration: 'underline', textUnderlineOffset: '6px' }}>Explore Zanzibar</Link>
                        </div>
                    </motion.div>

                </motion.div>

            </section>
        </div>
    );
};

export default SafariAddons;
