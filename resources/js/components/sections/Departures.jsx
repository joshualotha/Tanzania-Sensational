import React, { useEffect, useState } from 'react';
import { motion } from 'framer-motion';
import { departureService } from '../../services/api';
import { Link } from '@inertiajs/react';

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

const getNextRecurringDate = (dateStr) => {
  const date = new Date(dateStr);
  const now = new Date();
  if (date >= now) return date;
  const next = new Date(date);
  let attempts = 0;
  while (next < now && attempts < 52) {
    next.setDate(next.getDate() + 7);
    attempts++;
  }
  return next >= now ? next : null;
};

export const Departures = () => {
  const [departures, setDepartures] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    departureService.getAll()
      .then(res => {
        const all = Array.isArray(res.data) ? res.data : [];
        const upcoming = all
          .map(dep => ({
            ...dep,
            departure_date: getNextRecurringDate(dep.departure_date),
          }))
          .filter(dep => dep.departure_date !== null)
          .sort((a, b) => new Date(a.departure_date) - new Date(b.departure_date));
        setDepartures(upcoming);
      })
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
            Traveling solo? Split the cost. Share the adventure. Our group departures place solo travelers into small, curated teams of like-minded explorers.
          </motion.p>
          
          <motion.div variants={itemVariants}>
            <Link href="/group-departures" className="btn-secondary-light">
              View All 2026 Dates
            </Link>
          </motion.div>
        </div>

        <div className="departures-list-v3">
          {loading ? (
            [1, 2, 3].map(i => <div key={i} className="departure-skeleton-v3" />)
          ) : departures.length === 0 ? (
            <motion.div variants={itemVariants} style={{ textAlign: 'center', padding: '40px 20px', background: 'rgba(255,255,255,0.03)', borderRadius: '8px', border: '1px dashed rgba(255,255,255,0.1)' }}>
              <p style={{ color: 'var(--text-dim-light)', fontSize: '0.95rem', marginBottom: '20px' }}>
                No group departures available at the moment.
              </p>
              <Link href="/contact" className="btn-secondary-light">
                Request Private Expedition
              </Link>
            </motion.div>
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
                <Link href={packageUrl} className="departure-card-v3">
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
