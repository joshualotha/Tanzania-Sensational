import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import { Linkedin, Instagram, Facebook, Youtube, Send, MapPin, ArrowRight } from 'lucide-react';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';

export const Footer = () => {
  const visuals = useVisuals();
  const currentYear = new Date().getFullYear();
  const [email, setEmail] = useState('');
  const [subscribed, setSubscribed] = useState(false);

  const handleSubscribe = (e) => {
    e.preventDefault();
    if (email.trim()) {
      setSubscribed(true);
      setEmail('');
      setTimeout(() => setSubscribed(false), 4000);
    }
  };

  return (
    <footer className="footer-organic">
      {/* Grain texture overlay */}
      <div className="footer-grain" />

      {/* Large decorative watermark */}
      <div className="footer-watermark" aria-hidden="true">Karibu</div>

      {/* Topographic contour lines SVG */}
      <svg className="footer-topo" viewBox="0 0 1440 600" preserveAspectRatio="none" aria-hidden="true">
        <path d="M-20,200 Q200,120 400,200 T800,180 T1200,220 T1460,180" fill="none" stroke="rgba(140,109,82,0.06)" strokeWidth="1.5" />
        <path d="M-20,260 Q240,180 480,260 T880,240 T1240,280 T1460,240" fill="none" stroke="rgba(140,109,82,0.05)" strokeWidth="1.2" />
        <path d="M-20,320 Q180,260 420,320 T840,300 T1280,340 T1460,310" fill="none" stroke="rgba(140,109,82,0.04)" strokeWidth="1" />
        <path d="M-20,400 Q260,340 500,400 T900,380 T1300,420 T1460,390" fill="none" stroke="rgba(140,109,82,0.035)" strokeWidth="0.8" />
        <path d="M-20,480 Q220,420 460,480 T860,460 T1260,500 T1460,470" fill="none" stroke="rgba(140,109,82,0.03)" strokeWidth="0.6" />
      </svg>

      {/* Organic wave divider */}
      <div className="footer-wave-divider">
        <svg viewBox="0 0 1440 80" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M0,48 C180,80 360,16 540,48 C720,80 900,16 1080,48 C1260,80 1350,32 1440,48 L1440,80 L0,80 Z"
            fill="var(--footer-bg)"
          />
        </svg>
      </div>

      <div className="footer-inner">
        {/* ── Newsletter / CTA strip ── */}
        <div className="footer-cta-strip">
          <div className="footer-cta-content">
            <span className="footer-cta-eyebrow">Stay Connected</span>
            <h3 className="footer-cta-title">
              Stories from <em>the summit</em>
            </h3>
            <p className="footer-cta-sub">
              Trail dispatches, expedition stories & exclusive departure alerts — delivered to your inbox.
            </p>
          </div>
          <form className="footer-cta-form" onSubmit={handleSubscribe}>
            <div className={`footer-input-wrap ${subscribed ? 'subscribed' : ''}`}>
              {subscribed ? (
                <span className="footer-subscribed-msg">✦ Asante sana — you're in!</span>
              ) : (
                <>
                  <input
                    type="email"
                    placeholder="your@email.com"
                    value={email}
                    onChange={(e) => setEmail(e.target.value)}
                    className="footer-email-input"
                    required
                  />
                  <button type="submit" className="footer-submit-btn" aria-label="Subscribe">
                    <Send size={16} />
                  </button>
                </>
              )}
            </div>
          </form>
        </div>

        {/* ── Main footer content ── */}
        <div className="footer-upper">
          {/* Brand column */}
          <div className="footer-brand-col">
            <div className="footer-logo-wrap">
              <img
                src={visuals.getSingle('branding.logo', visualsData.branding.logo)}
                alt="Tanzania Sensational"
              />
            </div>
            <p className="footer-tagline">
              East Africa's most trusted mountain trekking authority. Guiding adventurers to the roof of Africa since 2009.
            </p>

            <div className="footer-contact-stack">
              <a href="mailto:info@tssafaris.com" className="footer-contact-link">
                <span className="footer-contact-icon">
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2 4.5l6 4.5 6-4.5M2 3.5h12a1.5 1.5 0 011.5 1.5v7a1.5 1.5 0 01-1.5 1.5H2A1.5 1.5 0 01.5 12V5A1.5 1.5 0 012 3.5z" stroke="currentColor" strokeWidth="1.2" strokeLinecap="round" /></svg>
                </span>
                info@tssafaris.com
              </a>
              <a href="tel:+255621220912" className="footer-contact-link">
                <span className="footer-contact-icon">
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M2.5 2.5c0-.3.2-.5.5-.5h2.6c.2 0 .4.2.5.4l1 2.5c.1.2 0 .4-.1.6L6 7c.8 1.5 2.4 3.1 4 4l1-1c.2-.1.4-.2.6-.1l2.5 1c.2.1.4.3.4.5v2.6c0 .3-.2.5-.5.5C5.5 14 1 9.5 1 4c0-.3 0-.5.5-.5z" stroke="currentColor" strokeWidth="1.2" /></svg>
                </span>
                +255-621220912
              </a>
            </div>

            {/* Location badge */}
            <div className="footer-location-badge">
              <MapPin size={14} />
              <span>Moshi, Kilimanjaro Region</span>
            </div>
          </div>

          {/* Navigation columns */}
          <div className="footer-nav-columns">
            <div className="footer-nav-col">
              <div className="footer-nav-label">
                <span className="footer-label-line" />
                Kilimanjaro
              </div>
              <ul className="footer-links">
                <li><Link to="/trekking/kilimanjaro/lemosho">Lemosho Route</Link></li>
                <li><Link to="/trekking/kilimanjaro/machame">Machame Route</Link></li>
                <li><Link to="/trekking/kilimanjaro/northern-circuit">Northern Circuit</Link></li>
                <li><Link to="/trekking/kilimanjaro/marangu">Marangu Route</Link></li>
                <li><Link to="/trekking/kilimanjaro/rongai">Rongai Route</Link></li>
                <li><Link to="/trekking/kilimanjaro/umbwe">Umbwe Route</Link></li>
              </ul>
            </div>

            <div className="footer-nav-col">
              <div className="footer-nav-label">
                <span className="footer-label-line" />
                Plan Your Trip
              </div>
              <ul className="footer-links">
                <li><Link to="/safaris">Safaris</Link></li>
                <li><Link to="/zanzibar">Zanzibar</Link></li>
                <li><Link to="/trekking/after/training">Training Guide</Link></li>
                <li><Link to="/trekking/after/gear-list">Packing List</Link></li>
                <li><Link to="/group-departures">Group Departures</Link></li>
                <li><Link to="/faq">FAQ</Link></li>
              </ul>
            </div>

            <div className="footer-nav-col">
              <div className="footer-nav-label">
                <span className="footer-label-line" />
                Company
              </div>
              <ul className="footer-links">
                <li><Link to="/about">About Us</Link></li>
                <li><Link to="/blog">Trekker's Blog</Link></li>
                <li><Link to="/contact">Contact</Link></li>
              </ul>

              {/* Social links below Company nav */}
              <div className="footer-social-group">
                <span className="footer-social-label">Follow Along</span>
                <div className="footer-socials">
                  <a href="https://www.linkedin.com" target="_blank" rel="noreferrer" className="social-link" aria-label="LinkedIn">
                    <Linkedin size={15} />
                  </a>
                  <a href="https://www.instagram.com" target="_blank" rel="noreferrer" className="social-link" aria-label="Instagram">
                    <Instagram size={15} />
                  </a>
                  <a href="https://www.facebook.com" target="_blank" rel="noreferrer" className="social-link" aria-label="Facebook">
                    <Facebook size={15} />
                  </a>
                  <a href="https://www.youtube.com" target="_blank" rel="noreferrer" className="social-link" aria-label="YouTube">
                    <Youtube size={15} />
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        {/* ── Bottom bar ── */}
        <div className="footer-lower">
          <div className="footer-lower-left">
            <span className="footer-copy">
              © {currentYear} Tanzania Sensational
            </span>
            <span className="footer-dot">·</span>
            <span className="footer-copy">All rights reserved</span>
          </div>
          <div className="footer-lower-right">
            <span className="footer-craft">Crafted with purpose in Tanzania 🇹🇿</span>
          </div>
        </div>
      </div>
    </footer>
  );
};
