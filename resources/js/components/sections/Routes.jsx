import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import { motion } from 'framer-motion';
import { visualsData } from '../../data/visualsData';
import { trekkingService } from '../../services/api';
import { useVisuals } from '../../context/VisualsContext';

const containerVariants = {
  hidden: { opacity: 0 },
  visible: {
    opacity: 1,
    transition: { staggerChildren: 0.2, delayChildren: 0.1 }
  }
};

const itemVariants = {
  hidden: { opacity: 0, y: 30 },
  visible: { 
    opacity: 1, y: 0, 
    transition: { duration: 1, ease: [0.16, 1, 0.3, 1] } 
  }
};

export const RoutesSection = () => {
  const [routes, setRoutes] = useState([]);
  const [loading, setLoading] = useState(true);
  const visuals = useVisuals();

  useEffect(() => {
    trekkingService.getAll()
      .then(res => {
        console.log("Routes API Response:", res);
        const data = Array.isArray(res.data) ? res.data : (Array.isArray(res.data?.data) ? res.data.data : []);
        console.log("Parsed Route Data:", data);
        
        if (data.length === 0) {
          console.warn("No route data found in API response.");
          setRoutes([]);
          return;
        }

        // Define flagship packages to highlight on the home page
        const featuredSlug = 'lemosho-8-days';
        const trailSlugs = ['machame-7-days', 'marangu-6-days', 'northern-circuit-9-days', 'rongai-7-days'];
        
        let featured = data.find(r => r.slug === featuredSlug) || data.find(r => r.slug?.includes('lemosho')) || data[0];
        let trails = data.filter(r => trailSlugs.includes(r.slug));
        
        // Fallback if the specific slugs aren't found
        if (trails.length < 3) {
          const remaining = data.filter(r => r.id !== featured?.id);
          trails = [...trails, ...remaining].slice(0, 3);
        } else {
          trails = trails.slice(0, 3);
        }
        
        const finalRoutes = featured ? [featured, ...trails] : [];
        console.log("Final Routes to Render:", finalRoutes);
        setRoutes(finalRoutes);
      })
      .catch(err => {
        console.error("Failed to fetch routes:", err);
      })
      .finally(() => setLoading(false));
  }, []);

  const featuredRoute = routes[0];
  const trailRoutes = routes.slice(1, 4);

  return (
    <motion.section 
      className="routes-v3" 
      id="routes"
      initial="hidden"
      whileInView="visible"
      viewport={{ once: true, margin: "-100px" }}
      variants={containerVariants}
    >
      <div className="routes-inner-v3">
        <div className="routes-header-v3">
          <motion.div className="section-eyebrow" variants={itemVariants}>
            <div className="section-eyebrow-line"></div>
            <span className="section-eyebrow-text">The Chosen Path</span>
          </motion.div>
          <motion.h2 
            className="section-title-light-v3" 
            variants={itemVariants}
            dangerouslySetInnerHTML={{ __html: visuals.getSingle('trekking.routes.header.title', 'Choose Your Path to the Top') }}
          />
          <motion.p className="routes-desc-v3" variants={itemVariants}>
            {visuals.getSingle('trekking.routes.header.desc', 'Every ascent tells a different story. From the legendary "Whiskey Route" to the scenic wilderness of Lemosho — we\'ll guide you to the summit.')}
          </motion.p>
        </div>

        {loading ? (
          <div className="routes-skeleton-v3" />
        ) : (
          <div className="routes-content-v3">
            {/* ── Featured Hero Card ── */}
            {featuredRoute && (
              <motion.div className="route-hero-card-v3" variants={itemVariants}>
                <Link to={`/trekking/kilimanjaro/${featuredRoute.slug}`} className="route-hero-inner-v3">
                  <div 
                    className="route-hero-img-v3" 
                    style={{
                      backgroundImage: `url(${featuredRoute.hero_image || visuals.getSingle(`trekking.routes.${featuredRoute.slug}`, visualsData.trekking.routes?.[featuredRoute.slug])})`,
                    }}
                  />
                  <div className="route-hero-content-v3">
                    <div className="route-hero-meta-v3">
                      <span className="route-hero-number-v3">01</span>
                      <span className="route-hero-duration-v3">{featuredRoute.duration} Days</span>
                    </div>
                    <h3 className="route-hero-title-v3">{featuredRoute.name}</h3>
                    <p className="route-hero-summary-v3">
                      {featuredRoute.description || featuredRoute.summary || 'Experience one of the most iconic approaches to the summit of Kilimanjaro with our expert team.'}
                    </p>
                    <div className="route-hero-action-v3">
                      Explore This Path
                      <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
                      </svg>
                    </div>
                  </div>
                </Link>
              </motion.div>
            )}

            {/* ── The Trail (Secondary Routes Grid) ── */}
            <div className="routes-trail-grid-v3">
              {trailRoutes.map((route, i) => (
                <motion.div key={route.id} className="route-card-v3" variants={itemVariants}>
                  <Link to={`/trekking/kilimanjaro/${route.slug}`} className="route-card-inner-v3">
                    <div 
                      className="route-card-img-v3" 
                      style={{
                        backgroundImage: `url(${route.hero_image || visuals.getSingle(`trekking.routes.${route.slug}`, visualsData.trekking.routes?.[route.slug])})`,
                      }}
                    />
                    <div className="route-card-content-v3">
                      <div className="route-card-meta-v3">
                        <span className="route-card-tag-v3">{route.duration} Days</span>
                        <span className="route-card-difficulty-v3">{route.difficulty}</span>
                      </div>
                      <h4 className="route-card-title-v3">{route.name}</h4>
                      <div className="route-card-action-v3">
                        Explore Path
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                          <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" />
                        </svg>
                      </div>
                    </div>
                  </Link>
                </motion.div>
              ))}
              
              {/* ── Compare All CTA Card ── */}
              <motion.div className="route-card-v3 cta-card-v3" variants={itemVariants}>
                <Link to="/trekking/prep/best-routes" className="route-cta-inner-v3">
                  <span className="cta-label-v3">Find Your Ideal Ascent</span>
                  <h4 className="cta-title-v3">Compare All Routes</h4>
                  <div className="cta-arrow-v3">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
                    </svg>
                  </div>
                </Link>
              </motion.div>
            </div>
          </div>
        )}

        {!loading && routes.length > 0 && (
          <motion.div className="routes-footer-v3" variants={itemVariants}>
            <Link to="/trekking/prep/best-routes" className="btn-view-all-v3">
              <span>View All Routes</span>
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
              </svg>
            </Link>
          </motion.div>
        )}

        {!loading && routes.length === 0 && (
          <div className="routes-empty-v3">
            <p>Mounting the next expedition. Check back soon for updated paths.</p>
          </div>
        )}
      </div>
    </motion.section>
);
};

