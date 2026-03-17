import React from 'react';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';

export const Hero = () => {
  return (
    <section className="hero">
      <div className="hero-bg">
        <img
          src={visualsData.home.hero}
          alt="Kilimanjaro at Sunrise"
          className="hero-bg-img"
        />
      </div>
      <div className="hero-overlay"></div>
      <div className="hero-overlay-side"></div>

      <div className="hero-badge">
        <div className="hero-badge-num">5,895</div>
        <div className="hero-badge-unit">metres above sea level</div>
        <div className="hero-badge-label">Uhuru Peak · Kilimanjaro</div>
      </div>

      <div className="hero-content">
        <div className="hero-eyebrow">
          <div className="hero-eyebrow-line"></div>
          <span className="hero-eyebrow-text">Kilimanjaro & Mt. Meru Specialists · Est. 2009</span>
        </div>
        <h1 className="hero-title">Your Summit.<br /><em>Our Expertise.</em></h1>
        <p className="hero-subtitle">East Africa's most trusted trekking authority — where every ascent becomes a story worth telling.</p>
        <div className="hero-actions">
          <Link to="/trekking/prep/best-routes" className="btn-primary"><span>Explore Routes</span></Link>
          <Link to="/safaris" className="btn-secondary">
            Join a Departure
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
              <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
          </Link>
        </div>
      </div>

      <div className="hero-scroll">
        <div className="scroll-line"></div>
        <span>Scroll</span>
      </div>
    </section>
  );
};
