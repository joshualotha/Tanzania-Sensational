import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
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

  return (
    <section className="carousel-routes-wrapper" id="routes">
      <div className="carousel-routes-header">
        <div className="carousel-header-left">
          <span className="carousel-eyebrow">The Chosen Path</span>
          <h2 className="carousel-title" dangerouslySetInnerHTML={{ __html: visuals.getSingle('trekking.routes.header.title', 'Choose Your Path <em>to the Top.</em>') }} />
        </div>
        <div className="carousel-header-right">
          <Link to="/trekking/prep/best-routes" className="carousel-view-all">
            Compare All Routes <ArrowRight size={16} />
          </Link>
        </div>
      </div>

      <div className="carousel-track-container">
        <div className="carousel-track">
          {routes.map((route, index) => (
            <Link key={`route-${route.slug}`} to={getBaseRouteUrl(route.slug)} className="carousel-card">
              <div className="carousel-card-media">
                {index === 0 && <span className="carousel-badge">Signature</span>}
                <img 
                  src={route.hero_image || visuals.getSingle(`trekking.routes.${route.slug}`, visualsData.trekking.routes?.[route.slug])} 
                  alt={route.name} 
                  loading="lazy"
                />
              </div>
              <div className="carousel-card-content">
                <div className="carousel-card-meta">
                  <span>{route.duration} Days</span>
                  <span>•</span>
                  <span>{route.difficulty || 'Expert Tracking'}</span>
                </div>
                <h3 className="carousel-card-title">{route.name}</h3>
                <p className="carousel-card-desc">
                  {route.description || route.summary || 'Experience one of the most iconic approaches to the summit of Kilimanjaro with our elite ground team.'}
                </p>
                <div className="carousel-card-cta">
                  Study Route <ArrowRight size={14} />
                </div>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
};


