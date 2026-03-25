import React, { useEffect, useMemo, useState, useRef, useCallback } from 'react';
import { Link } from 'react-router-dom';
import { motion, AnimatePresence } from 'framer-motion';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';

const SLIDE_INTERVAL = 6000;

export const Hero = () => {
  const visuals = useVisuals();
  const heroUrls = useMemo(() => {
    const fromApi = Array.isArray(visuals?.home?.hero) ? visuals.home.hero : [];
    if (fromApi.length > 0) return fromApi;
    return visualsData?.home?.hero ? [visualsData.home.hero] : [];
  }, [visuals]);

  const [activeIndex, setActiveIndex] = useState(0);
  const [progress, setProgress] = useState(0);
  const progressRef = useRef(null);

  // Slideshow timer with progress bar sync
  useEffect(() => {
    if (heroUrls.length <= 1) {
      setProgress(100);
      return;
    }
    setProgress(0);
    const startTime = Date.now();
    const tick = () => {
      const elapsed = Date.now() - startTime;
      const pct = Math.min((elapsed / SLIDE_INTERVAL) * 100, 100);
      setProgress(pct);
      if (pct < 100) {
        progressRef.current = requestAnimationFrame(tick);
      }
    };
    progressRef.current = requestAnimationFrame(tick);

    const slideTimer = setTimeout(() => {
      setActiveIndex((i) => (i + 1) % heroUrls.length);
    }, SLIDE_INTERVAL);

    return () => {
      cancelAnimationFrame(progressRef.current);
      clearTimeout(slideTimer);
    };
  }, [activeIndex, heroUrls.length]);

  const goToSlide = useCallback((idx) => {
    setActiveIndex(idx);
  }, []);

  const activeUrl = heroUrls[activeIndex] || visualsData.home.hero;

  return (
    <section className="hero-v2">
      {/* ── Crossfade Background ── */}
      <div className="hero-v2-bg">
        <AnimatePresence mode="sync">
          <motion.img
            key={activeUrl}
            src={activeUrl}
            alt="Tanzania Safari"
            className="hero-v2-bg-img"
            initial={{ opacity: 0, scale: 1.12 }}
            animate={{ opacity: 1, scale: 1.05 }}
            exit={{ opacity: 0 }}
            transition={{ opacity: { duration: 1.4, ease: 'easeInOut' }, scale: { duration: 12, ease: 'linear' } }}
          />
        </AnimatePresence>
      </div>

      {/* ── Cinematic Overlays ── */}
      <div className="hero-v2-overlay" />
      <div className="hero-v2-vignette" />

      {/* ── Floating Altitude Marker ── */}
      <motion.div
        className="hero-v2-altitude"
        initial={{ opacity: 0, y: 30 }}
        animate={{ opacity: 1, y: 0 }}
        transition={{ delay: 1.2, duration: 0.8 }}
      >
        <div className="hero-v2-alt-num">5,895m</div>
        <div className="hero-v2-alt-divider" />
        <div className="hero-v2-alt-label">Uhuru Peak</div>
      </motion.div>

      {/* ── Main Content ── */}
      <div className="hero-v2-content">
        <motion.div
          className="hero-v2-eyebrow"
          initial={{ opacity: 0, x: -30 }}
          animate={{ opacity: 1, x: 0 }}
          transition={{ delay: 0.3, duration: 0.7 }}
        >
          <span className="hero-v2-eyebrow-line" />
          <span>Kilimanjaro & Mt. Meru Specialists · Est. 2009</span>
        </motion.div>

        <motion.h1
          className="hero-v2-title"
          initial={{ opacity: 0, y: 50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.5, duration: 0.9, ease: [0.16, 1, 0.3, 1] }}
        >
          Your Summit.
          <br />
          <em>Our Expertise.</em>
        </motion.h1>

        <motion.p
          className="hero-v2-subtitle"
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 0.8, duration: 0.7 }}
        >
          East Africa's most trusted trekking authority — where every ascent becomes a story worth telling.
        </motion.p>

        <motion.div
          className="hero-v2-actions"
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ delay: 1.0, duration: 0.7 }}
        >
          <Link to="/trekking/prep/best-routes" className="hero-v2-btn-primary">
            <span>Explore Routes</span>
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
              <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
          </Link>
          <Link to="/safaris" className="hero-v2-btn-ghost">
            Join a Departure
          </Link>
        </motion.div>
      </div>

      {/* ── Slide Indicators ── */}
      {heroUrls.length > 1 && (
        <div className="hero-v2-indicators">
          {heroUrls.map((_, idx) => (
            <button
              key={idx}
              className={`hero-v2-dot ${idx === activeIndex ? 'active' : ''}`}
              onClick={() => goToSlide(idx)}
              aria-label={`Go to slide ${idx + 1}`}
            >
              {idx === activeIndex && (
                <span className="hero-v2-dot-progress" style={{ width: `${progress}%` }} />
              )}
            </button>
          ))}
        </div>
      )}

      {/* ── Scroll Indicator ── */}
      <motion.div
        className="hero-v2-scroll"
        initial={{ opacity: 0 }}
        animate={{ opacity: 1 }}
        transition={{ delay: 1.5, duration: 0.8 }}
      >
        <div className="hero-v2-scroll-line" />
        <span>Scroll</span>
      </motion.div>
    </section>
  );
};
