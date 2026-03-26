import React from 'react';
import { motion } from 'framer-motion';
import { visualsData } from '../../data/visualsData';
import { Link } from 'react-router-dom';
import { useVisuals } from '../../context/VisualsContext';

export const CTA = () => {
  const visuals = useVisuals();

  return (
    <section className="cta-banner-v3">
      <motion.div 
        className="cta-bg-v3" 
        style={{ backgroundImage: `url('${visuals.getSingle('home.ctaBg', visualsData.home.ctaBg)}')` }}
        initial={{ scale: 1.1 }}
        whileInView={{ scale: 1 }}
        transition={{ duration: 1.5, ease: "easeOut" }}
      />
      <div className="cta-overlay-v3" />
      
      <div className="cta-content-v3">
        <motion.h2 
          className="cta-title-v3"
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 1, ease: [0.16, 1, 0.3, 1] }}
        >
          The Summit<br />is <em>Waiting For You</em>
        </motion.h2>

        <motion.div 
          className="cta-btns-v3"
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          viewport={{ once: true }}
          transition={{ duration: 1, delay: 0.3, ease: [0.16, 1, 0.3, 1] }}
        >
          <Link to="/contact" className="nav-cta" style={{ position: 'relative' }}>
            Plan My Journey
          </Link>
          <a 
            href="https://wa.me/255700000000" 
            target="_blank" 
            rel="noopener noreferrer"
            className="btn-secondary-light"
          >
            WhatsApp Us
          </a>
        </motion.div>
      </div>
    </section>
  );
};
