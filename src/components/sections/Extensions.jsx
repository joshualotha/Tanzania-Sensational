import React, { useEffect, useRef } from 'react';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import '../../styles/extensions.css';

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
    </section>
  );
};
