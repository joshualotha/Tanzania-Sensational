import React, { useEffect, useRef } from 'react';

export const Departures = () => {
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
    <section className="departures" ref={sectionRef}>
      <div className="departures-inner">
        <div className="reveal">
          <div className="section-eyebrow">
            <div className="section-eyebrow-line"></div>
            <span className="section-eyebrow-text">Upcoming</span>
          </div>
          <h2 className="section-title" style={{ fontSize: '2.4rem' }}>Join a<br /><em>Group Departure</em></h2>
          <p style={{ fontFamily: "'Cormorant Garamond',serif", fontSize: '1.1rem', fontStyle: 'italic', color: 'var(--cream-dim)', marginTop: '20px', lineHeight: '1.8', marginBottom: '36px' }}>Traveling solo? Split the cost. Share the summit. Our group departures place solo adventurers into small, curated teams.</p>
          <a href="#" className="btn-primary"><span>View All Departures</span></a>
        </div>
        <div className="departures-list reveal">
          <div className="departure-row">
            <div>
              <div className="dep-route">Lemosho Route · 8 Days</div>
              <div className="dep-date" style={{ marginTop: '4px' }}>Mar 15 – Mar 23, 2026</div>
            </div>
            <span className="dep-seats">6 Seats Left</span>
            <div className="dep-price">$2,200<span style={{ fontSize: '0.75rem', color: 'var(--cream-dim)' }}>/pp</span></div>
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M4 9h10M9 4l5 5-5 5" stroke="#c9a55a" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" /></svg>
          </div>
          <div className="departure-row">
            <div>
              <div className="dep-route">Machame Route · 7 Days</div>
              <div className="dep-date" style={{ marginTop: '4px' }}>Apr 2 – Apr 9, 2026</div>
            </div>
            <span className="dep-seats">8 Seats Left</span>
            <div className="dep-price">$1,900<span style={{ fontSize: '0.75rem', color: 'var(--cream-dim)' }}>/pp</span></div>
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M4 9h10M9 4l5 5-5 5" stroke="#c9a55a" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" /></svg>
          </div>
          <div className="departure-row">
            <div>
              <div className="dep-route">Rongai Route · 7 Days</div>
              <div className="dep-date" style={{ marginTop: '4px' }}>Apr 20 – Apr 27, 2026</div>
            </div>
            <span className="dep-seats">5 Seats Left</span>
            <div className="dep-price">$1,850<span style={{ fontSize: '0.75rem', color: 'var(--cream-dim)' }}>/pp</span></div>
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M4 9h10M9 4l5 5-5 5" stroke="#c9a55a" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" /></svg>
          </div>
          <div className="departure-row">
            <div>
              <div className="dep-route">Full Moon Machame · 7 Days</div>
              <div className="dep-date" style={{ marginTop: '4px' }}>Jun 1 – Jun 8, 2026</div>
            </div>
            <span className="dep-seats low">2 Seats Left</span>
            <div className="dep-price">$2,100<span style={{ fontSize: '0.75rem', color: 'var(--cream-dim)' }}>/pp</span></div>
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M4 9h10M9 4l5 5-5 5" stroke="#c9a55a" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" /></svg>
          </div>
          <div className="departure-row">
            <div>
              <div className="dep-route">Lemosho Route · 8 Days</div>
              <div className="dep-date" style={{ marginTop: '4px' }}>Jul 5 – Jul 13, 2026</div>
            </div>
            <span className="dep-seats">8 Seats Left</span>
            <div className="dep-price">$2,200<span style={{ fontSize: '0.75rem', color: 'var(--cream-dim)' }}>/pp</span></div>
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><path d="M4 9h10M9 4l5 5-5 5" stroke="#c9a55a" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" /></svg>
          </div>
        </div>
      </div>
    </section>
  );
};
