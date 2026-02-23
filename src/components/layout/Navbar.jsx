import React, { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import logo from '../../assets/logo.png';

export const Navbar = () => {
  const [isScrolled, setIsScrolled] = useState(false);
  const [isMobileOpen, setIsMobileOpen] = useState(false);
  const [activeDropdowns, setActiveDropdowns] = useState([]);
  const location = useLocation();

  // Scroll logic
  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 60);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  // Scroll to top when path changes
  useEffect(() => {
    if (!location.hash) {
      window.scrollTo(0, 0);
    }
  }, [location.pathname]);

  // Close mobile menu on route change
  useEffect(() => {
    setIsMobileOpen(false);
    setActiveDropdowns([]);
  }, [location]);

  // Prevent body scroll when mobile menu is open
  useEffect(() => {
    document.body.style.overflow = isMobileOpen ? 'hidden' : '';
    return () => { document.body.style.overflow = ''; };
  }, [isMobileOpen]);

  // Toggle dropdown on mobile
  const handleToggle = (e, name) => {
    if (window.innerWidth <= 900) {
      e.preventDefault();
      setActiveDropdowns(prev =>
        prev.includes(name) ? prev.filter(n => n !== name) : [...prev, name]
      );
    }
  };

  const isDropdownActive = (name) => activeDropdowns.includes(name);

  return (
    <>
      {/* The Logo Crest — lives outside the nav, overlaps it */}
      <Link to="/" className={`logo-crest ${isScrolled ? 'logo-crest--compact' : ''}`}>
        <img src={logo} alt="Tanzania Sensational" />
      </Link>

      {/* Hamburger Toggle — mobile only */}
      <button
        className={`mobile-hamburger ${isMobileOpen ? 'open' : ''} ${isScrolled ? 'scrolled' : ''}`}
        onClick={() => setIsMobileOpen(!isMobileOpen)}
        aria-label="Toggle navigation menu"
      >
        <span></span>
        <span></span>
        <span></span>
      </button>

      {/* Mobile Overlay */}
      {isMobileOpen && (
        <div className="mobile-overlay" onClick={() => setIsMobileOpen(false)}></div>
      )}

      <nav id="navbar" className={`${isScrolled ? 'scrolled' : ''} ${isMobileOpen ? 'mobile-open' : ''}`}>
        <ul className="nav-links nav-links--left">
          <li className={`dropdown ${isDropdownActive('trekking') ? 'mobile-active' : ''}`}>
            <a
              href="/#routes"
              className="dropdown-toggle"
              onClick={(e) => handleToggle(e, 'trekking')}
            >
              Trekking
              <svg viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" /></svg>
            </a>
            <ul className="dropdown-menu">
              <li className={`has-submenu ${isDropdownActive('kili') ? 'mobile-active' : ''}`}>
                <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'kili')}>
                  Kilimanjaro
                </div>
                <ul className="submenu">
                  <li><Link to="/trekking/kilimanjaro/lemosho">Lemosho Route</Link></li>
                  <li><Link to="/trekking/kilimanjaro/machame">Machame Route</Link></li>
                  <li><Link to="/trekking/kilimanjaro/rongai">Rongai Route</Link></li>
                  <li><Link to="/trekking/kilimanjaro/marangu">Marangu Route</Link></li>
                  <li><Link to="/trekking/kilimanjaro/northern-circuit">Northern Circuit</Link></li>
                  <li><Link to="/trekking/kilimanjaro/umbwe">Umbwe Route</Link></li>
                </ul>
              </li>
              <li className={`has-submenu ${isDropdownActive('meru') ? 'mobile-active' : ''}`}>
                <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'meru')}>
                  Mt. Meru
                </div>
                <ul className="submenu">
                  <li><a href="#">4-Day Trek</a></li>
                  <li><a href="#">3-Day Trek</a></li>
                </ul>
              </li>
              <li className={`has-submenu ${isDropdownActive('prep') ? 'mobile-active' : ''}`}>
                <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'prep')}>
                  Trekking Preparation
                </div>
                <ul className="submenu">
                  <li className={`has-submenu ${isDropdownActive('health') ? 'mobile-active' : ''}`}>
                    <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'health')}>
                      Health &amp; Safety
                    </div>
                    <ul className="submenu">
                      <li><Link to="/trekking/health/vaccinations">Vaccinations</Link></li>
                      <li><Link to="/trekking/health/altitude-sickness">Altitude Sickness</Link></li>
                      <li><Link to="/trekking/health/diamox">Diamox for Acclimatization</Link></li>
                      <li><Link to="/trekking/health/oxygen">Oxygen Supplement</Link></li>
                    </ul>
                  </li>
                  <li className={`has-submenu ${isDropdownActive('before-book') ? 'mobile-active' : ''}`}>
                    <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'before-book')}>
                      Before You Book
                    </div>
                    <ul className="submenu">
                      <li><Link to="/trekking/prep/best-routes">Best Routes</Link></li>
                      <li><Link to="/trekking/prep/best-time">Best Time to Climb</Link></li>
                      <li><Link to="/trekking/prep/why-us">Why Top Climbers</Link></li>
                      <li><Link to="/trekking/prep/tipping-guide">Tipping Guide</Link></li>
                      <li><Link to="/trekking/prep/toilets">Toilets on Kilimanjaro</Link></li>
                      <li><Link to="/trekking/prep/park-fees">Kilimanjaro Park Fees</Link></li>
                    </ul>
                  </li>
                  <li className={`has-submenu ${isDropdownActive('after-arrive') ? 'mobile-active' : ''}`}>
                    <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'after-arrive')}>
                      After You Arrive
                    </div>
                    <ul className="submenu">
                      <li><Link to="/trekking/after/training">Training for Kilimanjaro</Link></li>
                      <li><Link to="/trekking/after/gear-list">Gear you will Need</Link></li>
                      <li><Link to="/trekking/after/getting-there">How to get to Kilimanjaro</Link></li>
                      <li><Link to="/trekking/after/visa">Getting Tanzania Visa</Link></li>
                    </ul>
                  </li>
                  <li className={`has-submenu ${isDropdownActive('during-trek') ? 'mobile-active' : ''}`}>
                    <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'during-trek')}>
                      During the Trek
                    </div>
                    <ul className="submenu">
                      <li><Link to="/trekking/during/daily-routine">Daily Routine</Link></li>
                      <li><Link to="/trekking/during/food-and-drinks">Food &amp; Drinks</Link></li>
                      <li><Link to="/trekking/during/pack-your-daypack">Packing your Daypack</Link></li>
                      <li><Link to="/trekking/during/connectivity">Internet &amp; Mobile Connectivity</Link></li>
                    </ul>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
          <li className={`dropdown ${isDropdownActive('safaris') ? 'mobile-active' : ''}`}>
            <Link
              to="/safaris"
              className="dropdown-toggle"
              onClick={(e) => handleToggle(e, 'safaris')}
            >
              Safaris
              <svg viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" /></svg>
            </Link>
            <ul className="dropdown-menu">
              <li><Link to="/safaris">Destinations Overview</Link></li>
              <li><a href="#">Itineraries / Packages</a></li>
              <li className={`has-submenu ${isDropdownActive('safari-guide') ? 'mobile-active' : ''}`}>
                <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'safari-guide')}>
                  Safari Guide
                </div>
                <ul className="submenu">
                  <li><a href="#">Local Custom</a></li>
                  <li><a href="#">What to Wear</a></li>
                  <li><a href="#">Packing Guide</a></li>
                  <li><a href="#">Accommodation Style</a></li>
                  <li><a href="#">Visa Guide</a></li>
                  <li><a href="#">Health and Safety</a></li>
                </ul>
              </li>
            </ul>
          </li>
          <li><Link to="/zanzibar">Zanzibar</Link></li>
        </ul>

        {/* Center spacer where the logo crest sits */}
        <div className="nav-logo-spacer"></div>

        <ul className="nav-links nav-links--right">
          <li><a href="/#departures">Departures</a></li>
          <li><a href="/about">About</a></li>
          <li><Link to="/contact">Contact</Link></li>
        </ul>
      </nav>
    </>
  );
};
