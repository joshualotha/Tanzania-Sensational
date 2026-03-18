import React, { useEffect } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import '../../styles/utility-pages-premium.css';

export const TrainingGuide = () => {
    const visuals = useVisuals();
    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 30 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8 } }
    };

    return (
        <div className="utility-root">
            <section className="utility-hero">
                <div className="utility-hero-bg">
                    <img src={visuals.getSingle('planning.trainingHero', visualsData.planning.trainingHero)} alt="Training" />
                </div>
                <div className="utility-hero-overlay"></div>
                <motion.div className="utility-hero-content" initial="hidden" animate="visible" variants={fadeInUp}>
                    <span className="utility-hero-eyebrow">Preparation</span>
                    <h1 className="utility-hero-title">Training Guide</h1>
                    <p className="utility-hero-subtitle">
                        Kilimanjaro is a non-technical hike, but you are trekking at extreme altitude for multiple days. Cardiovascular endurance and leg strength are paramount.
                    </p>
                </motion.div>
            </section>

            <section className="utility-content">
                <div className="utility-grid">
                    <motion.div className="util-card" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <div className="util-card-icon">
                            <span style={{ fontSize: '1.5rem', fontWeight: 'bold' }}>1</span>
                        </div>
                        <h3 className="util-card-title">Cardio Base (12-8 Weeks Out)</h3>
                        <p className="util-card-p">Focus on building raw cardiovascular endurance.</p>
                        <ul className="util-card-list">
                            <li>Running, cycling, or swimming 3-4 times a week for 45-60 minutes.</li>
                            <li>Maintain a moderate, conversational heart rate.</li>
                        </ul>
                    </motion.div>

                    <motion.div className="util-card" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <div className="util-card-icon">
                            <span style={{ fontSize: '1.5rem', fontWeight: 'bold' }}>2</span>
                        </div>
                        <h3 className="util-card-title">Hill Training (8-4 Weeks Out)</h3>
                        <p className="util-card-p">Simulate the mountain terrain by adding elevation.</p>
                        <ul className="util-card-list">
                            <li>Find the longest, steepest local hills or hit the stair-master.</li>
                            <li>Begin carrying a daypack with 5kg-8kg (10-15 lbs) of weight.</li>
                            <li>Do at least one long hike (4+ hours) per week.</li>
                        </ul>
                    </motion.div>

                    <motion.div className="util-card" initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}>
                        <div className="util-card-icon">
                            <span style={{ fontSize: '1.5rem', fontWeight: 'bold' }}>3</span>
                        </div>
                        <h3 className="util-card-title">The Taper (Last 3 Weeks)</h3>
                        <p className="util-card-p">Rest and recovery are just as important as the training.</p>
                        <ul className="util-card-list">
                            <li>Week 3: Reduce training volume by 25%.</li>
                            <li>Week 2: Reduce volume by 50%. Focus on stretching.</li>
                            <li>Week 1: Active rest. Light walking only. Arrive fresh.</li>
                        </ul>
                    </motion.div>
                </div>
            </section>
        </div>
    );
};
