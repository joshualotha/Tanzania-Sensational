import React, { useEffect, useRef } from 'react';
import { Link } from 'react-router-dom';
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

  const routeData = [
    { name: "Lemosho", slug: "lemosho", badge: "Most Scenic", days: "8 Days", difficulty: "Advanced", price: "$2,200", img: route1 },
    { name: "Machame", slug: "machame", badge: "Most Popular", days: "7 Days", difficulty: "Challenging", price: "$1,900", img: route2 },
    { name: "Rongai", slug: "rongai", badge: "Quietest Trail", days: "7 Days", difficulty: "Moderate", price: "$1,850", img: route3 },
    { name: "Marangu", slug: "marangu", badge: "Classic Route", days: "6 Days", difficulty: "Moderate", price: "$1,700", img: route1 },
    { name: "Northern Circuit", slug: "northern-circuit", badge: "Maximum Success", days: "9 Days", difficulty: "Advanced", price: "$2,600", img: route2 },
    { name: "Umbwe", slug: "umbwe", badge: "Technical Edge", days: "6 Days", difficulty: "Pro", price: "$1,850", img: route3 }
  ];

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
        {routeData.slice(0, 3).map((route, i) => (
          <Link key={i} to={`/trekking/kilimanjaro/${route.slug}`} className="route-card">
            <div className="route-card-img" style={{ backgroundImage: `url(${route.img})` }}></div>
            <div className="route-card-overlay"></div>
            <div className="route-arrow">
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                <path d="M3 13L13 3M13 3H5M13 3v8" stroke="#c9a55a" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" />
              </svg>
            </div>
            <div className="route-card-content">
              <span className="route-badge">{route.badge}</span>
              <div className="route-name">{route.name}<br />Route</div>
              <div className="route-meta">
                <span className="route-meta-item">{route.days}</span>
                <span className="route-meta-item">{route.difficulty}</span>
              </div>
              <div className="route-price">From {route.price} <span>per person</span></div>
            </div>
          </Link>
        ))}
      </div>
    </section>
  );
};

