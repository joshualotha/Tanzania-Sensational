import React, { useEffect, useRef, useState } from 'react';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { trekkingService } from '../../services/api';

export const Routes = () => {
  const sectionRef = useRef(null);
  const [routes, setRoutes] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchRoutes = async () => {
      try {
        const response = await trekkingService.getAll();
        setRoutes(response.data);
      } catch (error) {
        console.error("Failed to fetch routes", error);
      } finally {
        setLoading(false);
      }
    };
    fetchRoutes();

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -50px 0px' });

    if (sectionRef.current) {
      const reveals = sectionRef.current.querySelectorAll('.reveal');
      reveals.forEach(el => observer.observe(el));
    }

    return () => observer.disconnect();
  }, []);

  return (
    <section className="routes" id="routes" ref={sectionRef}>
      <div className="routes-header reveal">
        <div className="routes-header-left">
          <div className="section-eyebrow">
            <div className="section-eyebrow-line"></div>
            <span className="section-eyebrow-text">Our Routes</span>
          </div>
          <h2 className="section-title">Choose Your<br /><em>Path to the Top</em></h2>
          <p className="routes-desc">Every route tells a different story. From the scenic wilderness of Lemosho to the legendary Machame "Whiskey Route" — we'll find your perfect ascent.</p>
        </div>
        <Link to="/trekking/prep/best-routes" className="routes-link">
          Compare All
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
          </svg>
        </Link>
      </div>

      <div className="routes-grid reveal">
        {loading ? (
          [1, 2, 3].map(i => (
            <div key={i} className="route-card skeleton" style={{ height: '400px', background: 'rgba(255,255,255,0.05)' }}></div>
          ))
        ) : (
          routes.slice(0, 3).map((route, i) => (
            <Link key={i} to={`/trekking/kilimanjaro/${route.slug}`} className="route-card">
              <div 
                className="route-card-img" 
                style={{
                  backgroundImage: `url(${route.hero_image || visualsData.trekking.routes?.[route.slug] || visualsData.trekking.routes.lemosho})`,
                }}
              ></div>
              <div className="route-card-overlay"></div>
              <div className="route-arrow">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M3 13L13 3M13 3H5M13 3v8" stroke="#c9a55a" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
                </svg>
              </div>
              <div className="route-card-content">
                <span className="route-badge">{route.meta_badge || 'Great Route'}</span>
                <div className="route-name">{route.name}<br />Route</div>
                <div className="route-meta">
                  <span className="route-meta-item">{route.duration} Days</span>
                  <span className="route-meta-item">{route.difficulty}</span>
                </div>
                <div className="route-price">From ${route.base_price} <span>per person</span></div>
              </div>
            </Link>
          ))
        )}
      </div>
    </section>
  );
};

