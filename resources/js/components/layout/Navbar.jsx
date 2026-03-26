import React, { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import { trekkingService } from '../../services/api';

export const Navbar = () => {
  const [isScrolled, setIsScrolled] = useState(false);
  const [isMobileOpen, setIsMobileOpen] = useState(false);
  const [activeDropdowns, setActiveDropdowns] = useState([]);
  const [meruPackages, setMeruPackages] = useState([]);
  const location = useLocation();
  const visuals = useVisuals();

  const scrollToSection = (id) => {
    const el = document.getElementById(id);
    if (!el) return;
    const nav = document.getElementById('navbar');
    const navH = nav ? nav.getBoundingClientRect().height : 0;
    const top = window.scrollY + el.getBoundingClientRect().top - Math.max(80, navH + 16);
    window.scrollTo({ top, behavior: 'smooth' });
  };

  // Scroll logic
  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 60);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  // Fetch Mt Meru packages for dropdown
  useEffect(() => {
    let mounted = true;
    trekkingService.getAll().then(res => {
        if (mounted && res.data) {
            const meru = res.data
                .filter(r => r.slug && r.slug.startsWith('mt-meru'))
                .sort((a, b) => (b.duration || 0) - (a.duration || 0)); // e.g. 4-day before 3-day
            setMeruPackages(meru);
        }
    }).catch(err => console.error("Could not load Mt Meru packages", err));
    return () => { mounted = false; };
  }, []);

  // Scroll to top when path changes
  useEffect(() => {
    if (!location.hash) {
      window.scrollTo(0, 0);
    }
  }, [location.pathname]);

  // Scroll to section when navigating with a hash (e.g. /#routes)
  useEffect(() => {
    if (!location.hash) return;
    const id = location.hash.replace('#', '').trim();
    if (!id) return;
    // Allow render/layout to settle before measuring offsets
    const t = window.setTimeout(() => scrollToSection(id), 50);
    return () => window.clearTimeout(t);
  }, [location.hash]);

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
      <nav id="navbar" className={`${isScrolled ? 'scrolled' : ''}`}>
        <div className="nav-island-inner">
          {/* Logo integrated into the island */}
          <Link to="/" className="nav-logo">
            <img 
              src={visuals.getSingle('branding.logo', visualsData.branding.logo)} 
              alt="Tanzania Sensational" 
            />
          </Link>

          <ul className="nav-links">
            {/* Trekking Dropdown */}
            <li className={`dropdown ${isDropdownActive('trekking') ? 'mobile-active' : ''}`}>
              <Link to="/#routes" className="dropdown-toggle" onClick={(e) => handleToggle(e, 'trekking')}>
                Trekking
                <svg viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" /></svg>
              </Link>
              <ul className="dropdown-menu">
                <li className={`has-submenu ${isDropdownActive('kili') ? 'mobile-active' : ''}`}>
                  <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'kili')}>Kilimanjaro</div>
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
                  <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'meru')}>Mt. Meru</div>
                  <ul className="submenu">
                    {meruPackages.map(pkg => (
                      <li key={pkg.id}><Link to={`/trekking/meru/${pkg.slug}`}>{pkg.name}</Link></li>
                    ))}
                  </ul>
                </li>
                <li><Link to="/trekking/prep/best-routes">Prep & Routes</Link></li>
              </ul>
            </li>

            {/* Safaris Dropdown */}
            <li className={`dropdown ${isDropdownActive('safaris') ? 'mobile-active' : ''}`}>
              <Link to="/safaris" className="dropdown-toggle" onClick={(e) => handleToggle(e, 'safaris')}>
                Safaris
                <svg viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" /></svg>
              </Link>
              <ul className="dropdown-menu">
                <li><Link to="/safaris">Overview</Link></li>
                <li><Link to="/safaris/packages">Packages</Link></li>
                <li><Link to="/safari-guide/what-to-wear">Safari Guide</Link></li>
              </ul>
            </li>

            <li><Link to="/zanzibar">Zanzibar</Link></li>
            <li><Link to="/group-departures">Departures</Link></li>
            <li><Link to="/about">About Us</Link></li>
          </ul>

          <Link to="/contact" className="nav-cta">
            Plan Your Journey
          </Link>
        </div>
      </nav>

      {/* Mobile Toggle & Menu - Preserved Logic but potentially needs CSS updates */}
      <button
        className={`mobile-hamburger ${isMobileOpen ? 'open' : ''} ${isScrolled ? 'scrolled' : ''}`}
        onClick={() => setIsMobileOpen(!isMobileOpen)}
      >
        <span></span><span></span><span></span>
      </button>

      {isMobileOpen && <div className="mobile-overlay" onClick={() => setIsMobileOpen(false)}></div>}
    </>
  );
};
