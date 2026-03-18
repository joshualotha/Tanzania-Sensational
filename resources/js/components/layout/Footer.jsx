import React from 'react';
import { Link } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';

export const Footer = () => {
  const visuals = useVisuals();
  return (
    <footer>
      <div className="footer-top">
        <div className="footer-brand">
          <span className="footer-logo">
            <img src={visuals.getSingle('branding.logo', visualsData.branding.logo)} alt="Tanzania Sensational" style={{ height: '40px' }} />
          </span>
          <p className="footer-tagline">East Africa's most trusted mountain trekking authority. Guiding adventurers to the roof of Africa since 2009.</p>
          <div className="footer-contact-item">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 4l5 4 5-4M2 3h10a1 1 0 011 1v6a1 1 0 01-1 1H2a1 1 0 01-1-1V4a1 1 0 011-1z" stroke="#c9a55a" strokeWidth="1.2" strokeLinecap="round" /></svg>
            <a href="mailto:info@tanzaniasensational.com">info@tanzaniasensational.com</a>
          </div>
          <div className="footer-contact-item">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 2.5c0-.3.2-.5.5-.5h2.6c.2 0 .4.2.5.4l1 2.5c.1.2 0 .4-.1.6L5.5 6.5C6.3 8 7.9 9.6 9.5 10.5l1-1c.2-.1.4-.2.6-.1l2.5 1c.2.1.4.3.4.5v2.6c0 .3-.2.5-.5.5C5 13.5.5 9 .5 3.5c0-.3 0-.5.5-.5z" stroke="#c9a55a" strokeWidth="1.2" /></svg>
            <a href="tel:+255700000000">+255 700 000 000</a>
          </div>
        </div>
        <div>
          <div className="footer-heading">Kilimanjaro</div>
          <ul className="footer-links">
            <li><Link to="/trekking/kilimanjaro/lemosho">Lemosho Route</Link></li>
            <li><Link to="/trekking/kilimanjaro/machame">Machame Route</Link></li>
            <li><Link to="/trekking/kilimanjaro/northern-circuit">Northern Circuit</Link></li>
            <li><Link to="/trekking/kilimanjaro/marangu">Marangu Route</Link></li>
            <li><Link to="/trekking/kilimanjaro/rongai">Rongai Route</Link></li>
            <li><Link to="/trekking/kilimanjaro/umbwe">Umbwe Route</Link></li>
          </ul>
        </div>
        <div>
          <div className="footer-heading">Plan Your Trip</div>
          <ul className="footer-links">
            <li><Link to="/meru">Mt. Meru</Link></li>
            <li><Link to="/group-departures">Group Departures</Link></li>
            <li><Link to="/gear-checklist">Gear Checklist</Link></li>
            <li><Link to="/training-guide">Training Guide</Link></li>
            <li><Link to="/faq">FAQ</Link></li>
            <li><Link to="/safari-addons">Safari Add-ons</Link></li>
          </ul>
        </div>
        <div>
          <div className="footer-heading">Company</div>
          <ul className="footer-links">
            <li><Link to="/about">About Us</Link></li>
            <li><Link to="/company/our-guides">Our Guides</Link></li>
            <li><Link to="/company/safety-protocols">Safety Protocols</Link></li>
            <li><Link to="/blog">Trekker's Blog</Link></li>
            <li><Link to="/contact">Contact</Link></li>
          </ul>
        </div>
      </div>
      <div className="footer-bottom">
        <span className="footer-copy">© 2026 Tanzania Sensational. All rights reserved. Moshi, Tanzania.</span>
        <div className="footer-socials">
          <a href="https://www.linkedin.com" target="_blank" rel="noreferrer" className="social-link">in</a>
          <a href="https://www.instagram.com" target="_blank" rel="noreferrer" className="social-link">ig</a>
          <a href="https://www.facebook.com" target="_blank" rel="noreferrer" className="social-link">fb</a>
          <a href="https://www.youtube.com" target="_blank" rel="noreferrer" className="social-link">yt</a>
        </div>
      </div>
    </footer>
  );
};
