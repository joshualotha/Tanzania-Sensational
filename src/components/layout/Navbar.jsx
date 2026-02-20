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
                  <li><a href="#">Lemosho Route</a></li>
                  <li><a href="#">Machame Route</a></li>
                  <li><a href="#">Rongai Route</a></li>
                  <li><a href="#">Marangu Route</a></li>
                  <li><a href="#">Northern Circuit</a></li>
                  <li><a href="#">Umbwe Route</a></li>
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
                      <li><a href="#">Vaccinations</a></li>
                      <li><a href="#">Altitude Sickness</a></li>
                      <li><a href="#">Diamox for Acclimatization</a></li>
                      <li><a href="#">Oxygen Supplement</a></li>
                    </ul>
                  </li>
                  <li className={`has-submenu ${isDropdownActive('before-book') ? 'mobile-active' : ''}`}>
                    <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'before-book')}>
                      Before You Book
                    </div>
                    <ul className="submenu">
                      <li><a href="#">Best Routes</a></li>
                      <li><a href="#">Best Time to Climb</a></li>
                      <li><a href="#">Why Top Climbers</a></li>
                      <li><a href="#">Tipping Guide</a></li>
                      <li><a href="#">Toilets on Kilimanjaro</a></li>
                      <li><a href="#">Kilimanjaro Park Fees</a></li>
                    </ul>
                  </li>
                  <li className={`has-submenu ${isDropdownActive('after-arrive') ? 'mobile-active' : ''}`}>
                    <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'after-arrive')}>
                      After You Arrive
                    </div>
                    <ul className="submenu">
                      <li><a href="#">Training for Kilimanjaro</a></li>
                      <li><a href="#">Gear you will Need</a></li>
                      <li><a href="#">How to get to Kilimanjaro</a></li>
                      <li><a href="#">Getting Tanzania Visa</a></li>
                    </ul>
                  </li>
                  <li className={`has-submenu ${isDropdownActive('during-trek') ? 'mobile-active' : ''}`}>
                    <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'during-trek')}>
                      During the Trek
                    </div>
                    <ul className="submenu">
                      <li><a href="#">Daily Routine</a></li>
                      <li><a href="#">Food &amp; Drinks</a></li>
                      <li><a href="#">Packing your Daypack</a></li>
                      <li><a href="#">Internet &amp; Mobile Connectivity</a></li>
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
          <li><a href="/#extensions">Zanzibar</a></li>
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
