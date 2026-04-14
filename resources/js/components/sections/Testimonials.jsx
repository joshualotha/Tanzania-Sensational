import React from 'react';
import { motion } from 'framer-motion';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';

const containerVariants = {
  hidden: { opacity: 0 },
  visible: {
    opacity: 1,
    transition: { staggerChildren: 0.2, delayChildren: 0.1 }
  }
};

const cardVariants = {
  hidden: { opacity: 0, y: 30 },
  visible: { 
    opacity: 1, y: 0, 
    transition: { duration: 1, ease: [0.16, 1, 0.3, 1] } 
  }
};

export const Testimonials = () => {
  const visuals = useVisuals();

  const testimonials = [
    {
      text: "The guides were extraordinary, they knew exactly when to push and when to rest. Reaching Uhuru Peak at sunrise was the most profound moment of my life.",
      author: "James Hartwell",
      origin: "London, United Kingdom",
      img: visuals.getSingle('home.testimonial1', visualsData.home.testimonial1)
    },
    {
      text: "I joined a group departure as a solo traveler and couldn't have been more impressed. The safety protocols, the food, the team's energy, truly world-class.",
      author: "Sarah Chen",
      origin: "San Francisco, USA",
      img: visuals.getSingle('home.testimonial2', visualsData.home.testimonial2)
    },
    {
      text: "8 Tage Lemosho Route, absolut unvergesslich. Professionell, sicher, und die persönliche Betreuung war unübertroffen. Nächstes Ziel: Mt. Meru.",
      author: "Klaus Müller",
      origin: "Munich, Germany",
      img: visuals.getSingle('home.testimonial3', visualsData.home.testimonial3)
    }
  ];

  return (
    <motion.section 
      className="testimonials-v3"
      initial="hidden"
      whileInView="visible"
      viewport={{ once: true, margin: "-100px" }}
      variants={containerVariants}
    >
      <div className="testimonials-header-v3">
        <motion.div className="section-eyebrow" variants={cardVariants}>
          <div className="section-eyebrow-line"></div>
          <span className="section-eyebrow-text">The Human Connection</span>
        </motion.div>
        <motion.h2 className="section-title-v3" variants={cardVariants}>
          From the <em>Summit Diary</em>
        </motion.h2>
      </div>

      <div className="testi-grid-v3">
        {testimonials.map((t, i) => (
          <motion.div key={i} className="testi-card-v3" variants={cardVariants}>
            <div className="testi-quote-mark">“</div>
            <p className="testi-text-v3">{t.text}</p>
            <div className="testi-author-v3">
              <div 
                className="testi-avatar-v3" 
                style={{ backgroundImage: `url('${t.img}')` }}
              />
              <div className="testi-meta-v3">
                <div className="testi-name-v3">{t.author}</div>
                <div className="testi-origin-v3">{t.origin}</div>
              </div>
            </div>
          </motion.div>
        ))}
      </div>
    </motion.section>
  );
};
