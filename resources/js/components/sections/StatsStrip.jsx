import React from 'react';
import { motion } from 'framer-motion';

const containerVariants = {
  hidden: { opacity: 0 },
  visible: {
    opacity: 1,
    transition: { staggerChildren: 0.15 }
  }
};

const itemVariants = {
  hidden: { opacity: 0, y: 20 },
  visible: { 
    opacity: 1, y: 0, 
    transition: { duration: 0.8, ease: [0.16, 1, 0.3, 1] } 
  }
};

export const StatsStrip = () => {
  const stats = [
    { num: '98%', label: 'Summit Success Rate' },
    { num: '15+', label: 'Years of Expertise' },
    { num: '3,200+', label: 'Summits Reached' },
    { num: '24/7', label: 'On-Mountain Support' }
  ];

  return (
    <motion.div 
      className="stats"
      initial="hidden"
      whileInView="visible"
      viewport={{ once: true, margin: "-50px" }}
      variants={containerVariants}
    >
      {stats.map((stat, i) => (
        <motion.div key={i} className="stat-item" variants={itemVariants}>
          <div className="stat-num">{stat.num}</div>
          <div className="stat-label">{stat.label}</div>
        </motion.div>
      ))}
    </motion.div>
  );
};
