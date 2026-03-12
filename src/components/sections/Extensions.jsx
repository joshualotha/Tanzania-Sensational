import React, { useEffect, useRef } from 'react';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';

export const Extensions = () => {
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
    <section className="extensions" id="extensions" ref={sectionRef}>
      <div className="section-eyebrow reveal">
        <div className="section-eyebrow-line"></div>
        <span className="section-eyebrow-text">Beyond the Summit</span>
      </div>
      <h2 className="section-title reveal">Complete Your<br /><em>African Odyssey</em></h2>

      <div className="extensions-grid">
        <div className="extension-card reveal">
          <div className="extension-img" style={{ backgroundImage: `url('${visualsData.home.extensionSerengeti}')` }}></div>
          <div className="extension-overlay"></div>
          <div className="extension-content">
            <h3 className="extension-name">Wilderness Safaris</h3>
            <p className="extension-desc">From the endless plains of the Serengeti to the "Eden" of Ngorongoro. Experience the Great Migration in unparalleled luxury.</p>
            <a href="/safaris" className="extension-link">Explore Safaris</a>
          </div>
        </div>

        <div className="extension-card reveal reveal-delay-2">
          <div className="extension-img" style={{ backgroundImage: `url('${visualsData.home.extensionZanzibar}')` }}></div>
          <div className="extension-overlay"></div>
          <div className="extension-content">
            <h3 className="extension-name">Zanzibar Escapes</h3>
            <p className="extension-desc">Trade the mountain air for the Indian Ocean breeze. Pristine white sands, turquoise waters, and ancient Stone Town history.</p>
            <Link to="/zanzibar" className="extension-link">Island Extensions</Link>
          </div>
        </div>
      </div>

      <style jsx>{`
        .extensions {
          background: var(--bg-parchment);
          padding: 120px 60px;
        }
        .extensions .section-title {
          margin-bottom: 70px;
        }
        .extensions-grid {
          display: grid;
          grid-template-columns: 1fr 1fr;
          gap: 30px;
        }
        .extension-card {
          position: relative;
          height: 500px;
          overflow: hidden;
          cursor: pointer;
          border: 1px solid rgba(255,255,255,0.05);
          transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.6s ease;
        }
        .extension-card:hover {
          transform: translateY(-10px);
          box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
        .extension-img {
          position: absolute;
          inset: 0;
          background-size: cover;
          background-position: center;
          transition: transform 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
        .extension-card:hover .extension-img {
          transform: scale(1.1);
        }
        .extension-overlay {
          position: absolute;
          inset: 0;
          background: linear-gradient(to top, rgba(13,13,11,0.9) 0%, rgba(13,13,11,0.4) 50%, rgba(13,13,11,0) 100%);
          transition: background 0.5s;
        }
        .extension-card:hover .extension-overlay {
          background: linear-gradient(to top, rgba(13,13,11,0.95) 0%, rgba(13,13,11,0.6) 60%, rgba(13,13,11,0.2) 100%);
        }
        .extension-content {
          position: absolute;
          bottom: 0;
          left: 0;
          padding: 50px;
          max-width: 500px;
        }
        .extension-name {
          font-family: 'Playfair Display', serif;
          font-size: 2.2rem;
          color: var(--white);
          margin-bottom: 15px;
        }
        .extension-desc {
          font-family: 'Cormorant Garamond', serif;
          font-size: 1.2rem;
          font-style: italic;
          color: rgba(255, 255, 255, 0.9);
          line-height: 1.6;
          margin-bottom: 25px;
        }
        .extension-link {
          font-size: 0.75rem;
          letter-spacing: 0.2em;
          text-transform: uppercase;
          color: var(--gold);
          text-decoration: none;
          display: inline-block;
          border-bottom: 1px solid var(--gold);
          padding-bottom: 5px;
          transition: border-bottom 0.3s, color 0.3s;
        }
        .extension-link:hover {
          color: var(--gold-light);
          border-bottom-color: var(--gold-light);
        }

        @media (max-width: 1024px) {
          .extensions-grid {
            grid-template-columns: 1fr;
          }
          .extension-card {
            height: 400px;
          }
          .extension-content {
            padding: 30px;
          }
          .extension-name {
            font-size: 1.8rem;
          }
        }
      `}</style>
    </section>
  );
};
