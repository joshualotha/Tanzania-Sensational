import React from 'react';
import { motion } from 'framer-motion';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';

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

export const Experience = () => {
  const visuals = useVisuals();

  return (
    <motion.section 
      className="experience"
      initial="hidden"
      whileInView="visible"
      viewport={{ once: true, margin: "-100px" }}
      variants={containerVariants}
    >
      <div className="experience-visual">
        <motion.div 
          className="exp-img-main" 
          variants={itemVariants}
          style={{ backgroundImage: `url('${visuals.getSingle('home.experienceMain', visualsData.home.experienceMain)}')` }}
        />
        <motion.div 
          className="exp-img-secondary" 
          variants={itemVariants}
          style={{ backgroundImage: `url('${visuals.getSingle('home.experienceSecondary', visualsData.home.experienceSecondary)}')` }}
        />
        <motion.div 
          className="exp-badge-float shadow-premium"
          initial={{ opacity: 0, scale: 0.9 }}
          whileInView={{ opacity: 1, scale: 1 }}
          transition={{ delay: 0.8, duration: 0.6 }}
        >
          <div className="exp-badge-num">15+</div>
          <div className="exp-badge-text">Years guiding<br />to the summit</div>
        </motion.div>
      </div>

      <div className="experience-content">
        <motion.div className="section-eyebrow" variants={itemVariants}>
          <div className="section-eyebrow-line"></div>
          <span className="section-eyebrow-text">The Difference</span>
        </motion.div>
        
        <motion.h2 className="section-title" variants={itemVariants}>
          Safety. <em>Expertise.</em><br />Zero Compromise.
        </motion.h2>
        
        <motion.p className="experience-body" variants={itemVariants}>
          High-altitude trekking demands more than enthusiasm — it demands experience, certified professionals, and a team that's brought thousands of clients safely to Uhuru Peak and back. That's us.
        </motion.p>
        
        <div className="pillars">
          {[
            { id: '01', title: 'Certified Wilderness Guides', desc: 'Every guide holds Wilderness First Responder certification. Daily health checks using pulse oximetry keep you and your summit in sight.' },
            { id: '02', title: 'Acclimatization-First Strategy', desc: 'Our routes are designed around the "Climb High, Sleep Low" principle — the gold standard for altitude safety and summit success.' },
            { id: '03', title: 'Real-Time Pricing & Group Flexibility', desc: 'Solo traveler or a group of 15 — our pricing scales with you. Join existing departures or charter a private expedition, entirely your call.' }
          ].map((p, i) => (
            <motion.div key={p.id} className="pillar" variants={itemVariants}>
              <span className="pillar-num">{p.id}</span>
              <div>
                <div className="pillar-title">{p.title}</div>
                <p className="pillar-desc">{p.desc}</p>
              </div>
            </motion.div>
          ))}
        </div>
      </div>
    </motion.section>
  );
};
