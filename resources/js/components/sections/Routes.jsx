import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { motion, AnimatePresence } from 'framer-motion';
import { visualsData } from '../../data/visualsData';
import { trekkingService } from '../../services/api';
import { useVisuals } from '../../context/VisualsContext';
import { ArrowRight } from 'lucide-react';

const staticRoutesFallback = [
  { slug: 'lemosho-8-days', name: 'Lemosho Route', duration: 8, difficulty: 'High', description: 'Experience one of the most remote and profound approaches to the summit of Kilimanjaro with our elite ground team.', hero_image: visualsData.trekking.routes?.lemosho },
  { slug: 'machame-7-days', name: 'Machame Route', duration: 7, difficulty: 'High', description: 'Known as the Whiskey Route, revered for its stunning panoramic views and challenging, scenic ascents.', hero_image: visualsData.trekking.routes?.machame },
  { slug: 'northern-circuit-9-days', name: 'Northern Circuit', duration: 9, difficulty: 'Extreme', description: 'The longest, most solitary, and beautifully remote path crossing the northern flanks of the mountain.', hero_image: visualsData.trekking.routes?.northern },
  { slug: 'rongai-7-days', name: 'Rongai Route', duration: 7, difficulty: 'Moderate', description: 'A drier, wilder approach from the north, offering high chances of seeing large wildlife during the initial days.', hero_image: visualsData.trekking.routes?.rongai }
];

export const RoutesSection = () => {
  const [routes, setRoutes] = useState(staticRoutesFallback);
  const [activeSlug, setActiveSlug] = useState(staticRoutesFallback[0].slug);
  const visuals = useVisuals();

  useEffect(() => {
    trekkingService.getAll()
      .then(res => {
        const data = Array.isArray(res.data) ? res.data : (Array.isArray(res.data?.data) ? res.data.data : []);
        if (data.length === 0) return;

        const featuredSlug = 'lemosho-8-days';
        const trailSlugs = ['machame-7-days', 'northern-circuit-9-days', 'rongai-7-days'];
        
        let featured = data.find(r => r.slug === featuredSlug) || data.find(r => r.slug?.includes('lemosho')) || data[0];
        let trails = data.filter(r => trailSlugs.includes(r.slug));
        
        if (trails.length < 3) {
          const remaining = data.filter(r => r.slug !== featured?.slug);
          trails = [...trails, ...remaining].slice(0, 3);
        } else {
          trails = trails.slice(0, 3);
        }
        
        if (featured) {
            setRoutes([featured, ...trails]);
        }
      })
      .catch(err => console.error("Failed to sync live routes:", err));
  }, []);

  const getBaseRouteUrl = (slug) => {
    if (!slug) return '/#routes';
    if (slug.includes('lemosho')) return '/trekking/kilimanjaro/lemosho';
    if (slug.includes('machame')) return '/trekking/kilimanjaro/machame';
    if (slug.includes('marangu')) return '/trekking/kilimanjaro/marangu';
    if (slug.includes('rongai')) return '/trekking/kilimanjaro/rongai';
    if (slug.includes('northern')) return '/trekking/kilimanjaro/northern-circuit';
    if (slug.includes('umbwe')) return '/trekking/kilimanjaro/umbwe';
    return `/trekking/kilimanjaro/${slug}`;
  };

  const activeRoute = routes.find(r => r.slug === activeSlug) || routes[0];

  return (
    <section className="explorer-routes-wrapper" id="routes">
      
      {/* Absolute Fading Backgrounds */}
      {routes.map((route) => (
        <img 
          key={`bg-${route.slug}`} 
          className={`explorer-bg-layer ${route.slug === activeSlug ? 'is-active' : ''}`}
          src={route.hero_image || visuals.getSingle(`trekking.routes.${route.slug}`, visualsData.trekking.routes?.[route.slug])}
          alt={route.name}
        />
      ))}
      <div className="explorer-overlay"></div>

      <div className="explorer-inner">
        
        {/* Left Column: Menu */}
        <div>
          <span className="explorer-eyebrow">The Chosen Path</span>
          <ul className="explorer-menu">
            {routes.map((route) => (
              <li key={`menu-${route.slug}`} className="explorer-menu-item">
                <button 
                  className={`explorer-route-tab ${route.slug === activeSlug ? 'is-active' : ''}`}
                  onMouseEnter={() => setActiveSlug(route.slug)}
                  onClick={() => setActiveSlug(route.slug)}
                >
                  {route.name}
                </button>
              </li>
            ))}
          </ul>
        </div>

        {/* Right Column: Sliding Active Content */}
        <div>
          <AnimatePresence mode="wait">
            <motion.div 
              key={activeRoute.slug}
              className="explorer-content-panel"
              initial={{ opacity: 0, x: 20 }}
              animate={{ opacity: 1, x: 0 }}
              exit={{ opacity: 0, x: -20 }}
              transition={{ duration: 0.4 }}
            >
              <div className="explorer-meta">
                <span>{activeRoute.duration} Days</span>
                <span>—</span>
                <span>{activeRoute.difficulty || 'Expert Tracking'}</span>
              </div>
              
              <p className="explorer-summary">
                {activeRoute.description || activeRoute.summary || 'Experience one of the most iconic approaches to the summit of Kilimanjaro with our elite ground team.'}
              </p>

              <Link to={getBaseRouteUrl(activeRoute.slug)} className="explorer-cta">
                Study This Path <ArrowRight size={16} />
              </Link>
            </motion.div>
          </AnimatePresence>
        </div>

      </div>
    </section>
  );
};


