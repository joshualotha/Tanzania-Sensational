import React, { useEffect, useRef, useState } from 'react';
import { departureService } from '../../services/api';
import { Link } from 'react-router-dom';

export const Departures = () => {
  const sectionRef = useRef(null);
  const [departures, setDepartures] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchDepartures = async () => {
      try {
        const response = await departureService.getAll();
        setDepartures(Array.isArray(response.data) ? response.data : []);
      } catch (error) {
        console.error("Failed to fetch departures", error);
      } finally {
        setLoading(false);
      }
    };
    fetchDepartures();

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
          <Link to="/group-departures" className="btn-primary"><span>View All Departures</span></Link>
        </div>
        <div className="departures-list reveal">
          {loading ? (
            [1, 2, 3].map(i => (
              <div key={i} className="departure-row skeleton" style={{ height: '70px', background: 'rgba(255,255,255,0.02)', marginBottom: '10px' }}></div>
            ))
          ) : (
            departures.slice(0, 5).map((dep, i) => (
              <Link key={i} to={`/group-departures/${dep.id}`} className="departure-row">
                <div>
                  <div className="dep-route">{dep.trekking_route?.name} Route · {dep.trekking_route?.duration} Days</div>
                  <div className="dep-date" style={{ marginTop: '4px' }}>
                    {new Date(dep.departure_date).toLocaleDateString(undefined, { month: 'short', day: 'numeric' })} – 
                    {new Date(dep.return_date || dep.departure_date).toLocaleDateString(undefined, { month: 'short', day: 'numeric', year: 'numeric' })}
                  </div>
                </div>
                <span className={`dep-seats ${dep.available_seats <= 3 ? 'low' : ''}`}>
                  {dep.available_seats} Seats Left
                </span>
                <div className="dep-price">${Math.round((dep.price_cents || 0) / 100)}<span style={{ fontSize: '0.75rem', color: 'var(--cream-dim)' }}>/pp</span></div>
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
                  <path d="M4 9h10M9 4l5 5-5 5" stroke="#c9a55a" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
                </svg>
              </Link>
            ))
          )}
        </div>
      </div>
    </section>
  );
};
