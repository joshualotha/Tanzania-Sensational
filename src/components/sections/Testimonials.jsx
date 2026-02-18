import React, { useEffect, useRef } from 'react';

export const Testimonials = () => {
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
    <section className="testimonials" ref={sectionRef}>
      <div className="testimonials-header">
        <div className="section-eyebrow">
          <div className="section-eyebrow-line"></div>
          <span className="section-eyebrow-text">Client Stories</span>
          <div className="section-eyebrow-line"></div>
        </div>
        <h2 className="section-title" style={{ marginTop: '16px' }}>From the <em>Summit Diary</em></h2>
      </div>
      <div className="testi-grid">
        <div className="testi-card reveal">
          <div className="testi-stars">★★★★★</div>
          <div className="testi-quote">"</div>
          <p className="testi-text">The guides were extraordinary — they knew exactly when to push and when to rest. Reaching Uhuru Peak at sunrise was the most profound moment of my life. Tanzania Sensational made it possible.</p>
          <div className="testi-author">
            <div className="testi-avatar" style={{ backgroundImage: "url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80&auto=format&fit=crop')" }}></div>
            <div>
              <div className="testi-name">James Hartwell</div>
              <div className="testi-origin">London, United Kingdom</div>
            </div>
          </div>
        </div>
        <div className="testi-card reveal reveal-delay-2">
          <div className="testi-stars">★★★★★</div>
          <div className="testi-quote">"</div>
          <p className="testi-text">I joined a group departure as a solo traveler and couldn't have been more impressed. The safety protocols, the food on the mountain, the team's energy — this is truly a world-class operation.</p>
          <div className="testi-author">
            <div className="testi-avatar" style={{ backgroundImage: "url('https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&q=80&auto=format&fit=crop')" }}></div>
            <div>
              <div className="testi-name">Sarah Chen</div>
              <div className="testi-origin">San Francisco, USA</div>
            </div>
          </div>
        </div>
        <div className="testi-card reveal reveal-delay-3">
          <div className="testi-stars">★★★★★</div>
          <div className="testi-quote">"</div>
          <p className="testi-text">Wir haben die Lemosho Route gemacht — 8 Tage, absolut unvergesslich. Professionell, sicher, und die persönliche Betreuung war unübertroffen. Nächstes Ziel: Mt. Meru.</p>
          <div className="testi-author">
            <div className="testi-avatar" style={{ backgroundImage: "url('https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100&q=80&auto=format&fit=crop')" }}></div>
            <div>
              <div className="testi-name">Klaus Müller</div>
              <div className="testi-origin">Munich, Germany</div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};
