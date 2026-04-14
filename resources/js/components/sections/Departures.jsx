import React, { useEffect, useState } from 'react';
import { motion } from 'framer-motion';
import { departureService } from '../../services/api';
import { Link } from 'react-router-dom';

const containerVariants = {
  hidden: { opacity: 0 },
  visible: {
    opacity: 1,
    transition: { staggerChildren: 0.1, delayChildren: 0.2 }
  }
};

const itemVariants = {
  hidden: { opacity: 0, x: -20 },
  visible: { 
    opacity: 1, x: 0, 
    transition: { duration: 0.8, ease: [0.16, 1, 0.3, 1] } 
  }
};

export const Departures = () => {
  const [departures, setDepartures] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    departureService.getAll()
      .then(res => setDepartures(Array.isArray(res.data) ? res.data : []))
      .catch(err => console.error("Failed to fetch departures", err))
      .finally(() => setLoading(false));
  }, []);

  return (
    <motion.section 
      className="departures-v3"
      initial="hidden"
      whileInView="visible"
      viewport={{ once: true, margin: "-100px" }}
      variants={containerVariants}
    >
      <div className="departures-inner-asymmetric">
        <div className="departures-content-side">
          <motion.div className="section-eyebrow" variants={itemVariants}>
            <div className="section-eyebrow-line"></div>
            <span className="section-eyebrow-text">Join a Team</span>
          </motion.div>
          
          <motion.h2 className="section-title-light" variants={itemVariants}>
            Group<br /><em>Departures</em>
          </motion.h2>
          
          <motion.p className="departures-desc-v3" variants={itemVariants}>
            Traveling solo? Split the cost. Share the summit. Our group departures place solo adventurers into small, curated teams of like-minded explorers.
          </motion.p>
          
          <motion.div variants={itemVariants}>
            <Link to="/group-departures" className="btn-secondary-light">
              View All 2026 Dates
            </Link>
          </motion.div>
        </div>

        <div className="departures-list-v3">
          {loading ? (
            [1, 2, 3].map(i => <div key={i} className="departure-skeleton-v3" />)
          ) : (
            departures.slice(0, 4).map((dep, i) => {
              const getRouteUrl = (slug) => {
                if (!slug) return '#';
                if (slug.includes('lemosho')) return '/trekking/kilimanjaro/lemosho';
                if (slug.includes('machame')) return '/trekking/kilimanjaro/machame';
                if (slug.includes('marangu')) return '/trekking/kilimanjaro/marangu';
                if (slug.includes('rongai')) return '/trekking/kilimanjaro/rongai';
                if (slug.includes('northern')) return '/trekking/kilimanjaro/northern-circuit';
                if (slug.includes('umbwe')) return '/trekking/kilimanjaro/umbwe';
                return `/trekking/kilimanjaro/${slug}`;
              };
              const packageUrl = getRouteUrl(dep.trekking_route?.slug);
              
              return (
              <motion.div key={dep.id || i} variants={itemVariants}>
                <Link to={packageUrl} className="departure-card-v3">
                  <div className="dep-info-v3">
                    <span className="dep-route-v3">{dep.trekking_route?.name} Route</span>
                    <span className="dep-date-v3">
                      {new Date(dep.departure_date).toLocaleDateString(undefined, { month: 'short', day: 'numeric' })}
                    </span>
                  </div>
                  
                  <div className="dep-meta-v3">
                    <span className={`dep-seats-pill-v3 ${dep.available_seats <= 3 ? 'low' : ''}`}>
                      {dep.available_seats} spots left
                    </span>
                    <span className="dep-price-v3">From ${Math.round((dep.price_cents || 0) / 100)}</span>
                  </div>
                  
                  <div className="dep-arrow-v3">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                      <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
                    </svg>
                  </div>
                </Link>
              </motion.div>
            )})
          )}
        </div>
      </div>
    </motion.section>
  );
};
