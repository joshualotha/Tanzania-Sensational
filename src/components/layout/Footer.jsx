import React from 'react';
import { Link } from 'react-router-dom';
import logo from '../../assets/logo.png';

export const Footer = () => {
  return (
    <footer>
      <div className="footer-top">
        <div className="footer-brand">
          <span className="footer-logo">
            <img src={logo} alt="Tanzania Sensational" style={{ height: '40px' }} />
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
            <li><a href="#">Lemosho Route</a></li>
            <li><a href="#">Machame Route</a></li>
            <li><a href="#">Rongai Route</a></li>
            <li><a href="#">Full Moon Treks</a></li>
            <li><a href="#">Private Expeditions</a></li>
          </ul>
        </div>
        <div>
          <div className="footer-heading">Plan Your Trip</div>
          <ul className="footer-links">
            <li><a href="#">Mt. Meru</a></li>
            <li><a href="#">Group Departures</a></li>
            <li><a href="#">Gear Checklist</a></li>
            <li><a href="#">Training Guide</a></li>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Safari Add-ons</a></li>
          </ul>
        </div>
        <div>
          <div className="footer-heading">Company</div>
          <ul className="footer-links">
            <li><a href="#">About Us</a></li>
            <li><a href="#">Our Guides</a></li>
            <li><a href="#">Safety Protocols</a></li>
            <li><a href="#">Trekker's Blog</a></li>
            <li><Link to="/contact">Contact</Link></li>
          </ul>
        </div>
      </div>
      <div className="footer-bottom">
        <span className="footer-copy">© 2026 Tanzania Sensational. All rights reserved. Moshi, Tanzania.</span>
        <div className="footer-socials">
          <a href="#" className="social-link">in</a>
          <a href="#" className="social-link">ig</a>
          <a href="#" className="social-link">fb</a>
          <a href="#" className="social-link">yt</a>
        </div>
      </div>
    </footer>
  );
};
