import React, { useEffect, useRef } from 'react';
import route1 from '../../assets/route-1.jpg';
import route2 from '../../assets/route-2.jpg';
import route3 from '../../assets/route-3.jpg';

export const Routes = () => {
  const sectionRef = useRef(null);

  useEffect(() => {
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
        <a href="#" className="routes-link">
          All Routes
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
            <path d="M4 10h12M11 5l5 5-5 5" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
          </svg>
        </a>
      </div>

      <div className="routes-grid reveal">
        {/* Lemosho */}
        <a href="#" className="route-card">
          <div className="route-card-img" style={{ backgroundImage: `url(${route1})` }}></div>
          <div className="route-card-overlay"></div>
          <div className="route-arrow">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
              <path d="M3 13L13 3M13 3H5M13 3v8" stroke="#c9a55a" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
          </div>
          <div className="route-card-content">
            <span className="route-badge">Most Scenic</span>
            <div className="route-name">Lemosho<br />Route</div>
            <div className="route-meta">
              <span className="route-meta-item">8 Days</span>
              <span className="route-meta-item">Advanced</span>
              <span className="route-meta-item">98% Success</span>
            </div>
            <div className="route-price">From $2,200 <span>per person</span></div>
          </div>
        </a>
        {/* Machame */}
        <a href="#" className="route-card">
          <div className="route-card-img" style={{ backgroundImage: `url(${route2})` }}></div>
          <div className="route-card-overlay"></div>
          <div className="route-arrow">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
              <path d="M3 13L13 3M13 3H5M13 3v8" stroke="#c9a55a" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
          </div>
          <div className="route-card-content">
            <span className="route-badge">Most Popular</span>
            <div className="route-name">Machame<br />Route</div>
            <div className="route-meta">
              <span className="route-meta-item">7 Days</span>
              <span className="route-meta-item">Challenging</span>
            </div>
            <div className="route-price">From $1,900 <span>per person</span></div>
          </div>
        </a>
        {/* Rongai */}
        <a href="#" className="route-card">
          <div className="route-card-img" style={{ backgroundImage: `url(${route3})` }}></div>
          <div className="route-card-overlay"></div>
          <div className="route-arrow">
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
              <path d="M3 13L13 3M13 3H5M13 3v8" stroke="#c9a55a" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
          </div>
          <div className="route-card-content">
            <span className="route-badge">Quietest Trail</span>
            <div className="route-name">Rongai<br />Route</div>
            <div className="route-meta">
              <span className="route-meta-item">7 Days</span>
              <span className="route-meta-item">Moderate</span>
            </div>
            <div className="route-price">From $1,850 <span>per person</span></div>
          </div>
        </a>
      </div>
    </section>
  );
};
