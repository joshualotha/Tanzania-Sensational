import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { visualsData } from '../../data/visualsData';
import { trekkingService } from '../../services/api';
import { useVisuals } from '../../context/VisualsContext';
import { ArrowRight } from 'lucide-react';

const containerVariants = {
  hidden: { opacity: 0 },
  visible: {
    opacity: 1,
    transition: { staggerChildren: 0.15, delayChildren: 0.2 }
  }
};

const itemVariants = {
  hidden: { opacity: 0, y: 30 },
  visible: { 
    opacity: 1, y: 0, 
    transition: { duration: 0.8, ease: [0.16, 1, 0.3, 1] } 
  }
};

export const RoutesSection = () => {
  const [routes, setRoutes] = useState([]);
  const [loading, setLoading] = useState(true);
  const visuals = useVisuals();

  useEffect(() => {
    trekkingService.getAll()
      .then(res => {
        const data = Array.isArray(res.data) ? res.data : (Array.isArray(res.data?.data) ? res.data.data : []);
        
        if (data.length === 0) {
          setRoutes([]);
          return;
        }

        // Define flagship packages to highlight
        const featuredSlug = 'lemosho-8-days';
        const trailSlugs = ['machame-7-days', 'northern-circuit-9-days', 'rongai-7-days'];
        
        let featured = data.find(r => r.slug === featuredSlug) || data.find(r => r.slug?.includes('lemosho')) || data[0];
        let trails = data.filter(r => trailSlugs.includes(r.slug));
        
        if (trails.length < 3) {
          const remaining = data.filter(r => r.id !== featured?.id);
          trails = [...trails, ...remaining].slice(0, 3);
        } else {
          trails = trails.slice(0, 3);
        }
        
        setRoutes(featured ? [featured, ...trails] : []);
      })
      .catch(err => console.error("Failed to fetch routes:", err))
      .finally(() => setLoading(false));
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

  const featuredRoute = routes[0];
  const trailRoutes = routes.slice(1);

  return (
    <section className="organic-routes-wrapper" id="routes">
      <div className="organic-routes-inner">
        <div className="org-routes-header">
          <span className="org-eyebrow">The Chosen Path</span>
          <h2 className="org-title" dangerouslySetInnerHTML={{ __html: visuals.getSingle('trekking.routes.header.title', 'Choose Your Path <em>to the Top.</em>') }} />
          <p className="org-desc">
            {visuals.getSingle('trekking.routes.header.desc', 'Every ascent tells a different story. From the legendary Whiskey Route to the remote wilderness of Lemosho — we guide you to the summit with organic intention.')}
          </p>
        </div>

        {loading ? (
          <div className="org-skeleton">Preparing the Ascent...</div>
        ) : routes.length > 0 ? (
          <motion.div 
            className="org-content-grid"
            initial="hidden"
            whileInView="visible"
            viewport={{ once: true, margin: "-50px" }}
            variants={containerVariants}
          >
            {/* ── Featured Route ── */}
            {featuredRoute && (
              <motion.div variants={itemVariants}>
                <Link to={getBaseRouteUrl(featuredRoute.slug)} className="org-featured-card">
                  <div className="org-featured-media">
                    <div className="org-badge-absolute">Signature Expedition</div>
                    <img src={featuredRoute.hero_image || visuals.getSingle(`trekking.routes.${featuredRoute.slug}`, visualsData.trekking.routes?.[featuredRoute.slug])} alt={featuredRoute.name} />
                  </div>
                  <div className="org-featured-body">
                    <div className="org-route-meta">
                      <span>{featuredRoute.duration} Days</span>
                      <span>—</span>
                      <span>{featuredRoute.difficulty || 'Expert Tracking'}</span>
                    </div>
                    <h3 className="org-route-title">{featuredRoute.name}</h3>
                    <p className="org-route-summary">{featuredRoute.description || featuredRoute.summary || 'Experience one of the most iconic approaches to the summit of Kilimanjaro with our elite ground team.'}</p>
                    <span className="org-route-cta">
                      Study This Route <ArrowRight size={16} />
                    </span>
                  </div>
                </Link>
              </motion.div>
            )}

            {/* ── Trails List ── */}
            <motion.div className="org-trails-list" variants={containerVariants}>
              {trailRoutes.map((route) => (
                <motion.div key={route.id} variants={itemVariants}>
                  <Link to={getBaseRouteUrl(route.slug)} className="org-trail-card">
                    <div className="org-trail-media">
                      <img src={route.hero_image || visuals.getSingle(`trekking.routes.${route.slug}`, visualsData.trekking.routes?.[route.slug])} alt={route.name} />
                    </div>
                    <div className="org-trail-content">
                      <span className="org-trail-meta">{route.duration} Days</span>
                      <h4 className="org-trail-title">{route.name}</h4>
                      <ArrowRight size={20} className="org-trail-arrow" />
                    </div>
                  </Link>
                </motion.div>
              ))}
            </motion.div>
          </motion.div>
        ) : (
          <div className="org-skeleton">Updating tracking paths...</div>
        )}

        {!loading && routes.length > 0 && (
          <div className="org-footer-actions">
            <Link to="/trekking/prep/best-routes" className="org-btn-outline">
              Compare All Routes <ArrowRight size={16} />
            </Link>
          </div>
        )}
      </div>
    </section>
  );
};


