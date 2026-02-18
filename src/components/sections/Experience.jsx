import React, { useEffect, useRef } from 'react';

export const Experience = () => {
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
    <div className="experience" ref={sectionRef}>
      <div className="experience-visual reveal">
        <div className="exp-img-main"></div>
        <div className="exp-img-secondary"></div>
        <div className="exp-badge-float">
          <div className="exp-badge-num">15+</div>
          <div className="exp-badge-text">Years guiding<br />to the summit</div>
        </div>
      </div>
      <div className="experience-content">
        <div className="section-eyebrow reveal">
          <div className="section-eyebrow-line"></div>
          <span className="section-eyebrow-text">The Difference</span>
        </div>
        <h2 className="section-title reveal">Safety. <em>Expertise.</em><br />Zero Compromise.</h2>
        <p className="experience-body reveal">High-altitude trekking demands more than enthusiasm — it demands experience, certified professionals, and a team that's brought thousands of clients safely to Uhuru Peak and back. That's us.</p>
        <div className="pillars">
          <div className="pillar reveal reveal-delay-1">
            <span className="pillar-num">01</span>
            <div>
              <div className="pillar-title">Certified Wilderness Guides</div>
              <p className="pillar-desc">Every guide holds Wilderness First Responder certification. Daily health checks using pulse oximetry keep you and your summit in sight.</p>
            </div>
          </div>
          <div className="pillar reveal reveal-delay-2">
            <span className="pillar-num">02</span>
            <div>
              <div className="pillar-title">Acclimatization-First Strategy</div>
              <p className="pillar-desc">Our routes are designed around the "Climb High, Sleep Low" principle — the gold standard for altitude safety and summit success.</p>
            </div>
          </div>
          <div className="pillar reveal reveal-delay-3">
            <span className="pillar-num">03</span>
            <div>
              <div className="pillar-title">Real-Time Pricing & Group Flexibility</div>
              <p className="pillar-desc">Solo traveler or a group of 15 — our pricing scales with you. Join existing departures or charter a private expedition, entirely your call.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
