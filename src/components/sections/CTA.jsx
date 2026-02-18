import React, { useEffect, useRef } from 'react';

export const CTA = () => {
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
    <section className="cta-banner" ref={sectionRef}>
      <div className="cta-bg"></div>
      <div className="cta-content reveal">
        <h2 className="cta-title">The Summit<br />is <em>Waiting For You</em></h2>
        <p className="cta-sub">Most people say "someday." Our clients say "I stood at the roof of Africa." Your journey begins with one conversation.</p>
        <div className="cta-actions">
          <a href="#" className="btn-primary"><span>Plan My Trek</span></a>
          <a href="https://wa.me/255700000000" target="_blank" className="btn-secondary" style={{ color: '#25D366' }}>
            WhatsApp Us
            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
              <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
            </svg>
          </a>
        </div>
      </div>
    </section>
  );
};
