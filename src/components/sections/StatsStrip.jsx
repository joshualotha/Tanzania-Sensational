import React, { useEffect, useRef } from 'react';

export const StatsStrip = () => {
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
      const items = sectionRef.current.querySelectorAll('.stat-item');
      items.forEach(el => observer.observe(el));
    }

    return () => observer.disconnect();
  }, []);

  return (
    <div className="stats" ref={sectionRef}>
      <div className="stat-item">
        <div className="stat-num">98%</div>
        <div className="stat-label">Summit Success Rate</div>
      </div>
      <div className="stat-item">
        <div className="stat-num">15+</div>
        <div className="stat-label">Years of Expertise</div>
      </div>
      <div className="stat-item">
        <div className="stat-num">3,200+</div>
        <div className="stat-label">Summits Reached</div>
      </div>
      <div className="stat-item">
        <div className="stat-num">24/7</div>
        <div className="stat-label">On-Mountain Support</div>
      </div>
    </div>
  );
};
