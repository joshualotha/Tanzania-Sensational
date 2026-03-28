import React, { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import { trekkingService, destinationService } from '../../services/api';

export const Navbar = () => {
  const [isScrolled, setIsScrolled] = useState(false);
  const [isMobileOpen, setIsMobileOpen] = useState(false);
  const [activeDropdowns, setActiveDropdowns] = useState([]);
  const [meruPackages, setMeruPackages] = useState([]);
  const [safariDestinations, setSafariDestinations] = useState([]);
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

  // Fetch Mt Meru packages and Safari destinations for dropdown
  useEffect(() => {
    let mounted = true;
    trekkingService.getAll().then(res => {
        if (mounted && res.data) {
            const meru = res.data
                .filter(r => r.slug && r.slug.startsWith('mt-meru'))
                .sort((a, b) => (b.duration || 0) - (a.duration || 0));
            setMeruPackages(meru);
        }
    }).catch(err => console.error("Could not load Mt Meru packages", err));

    destinationService.getAll().then(res => {
        if (mounted && res.data) {
            setSafariDestinations(res.data);
        }
    }).catch(err => console.error("Could not load Safari destinations", err));

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
      {/* ─── LOGO CREST — Floating brand mark ─── */}
      <Link 
        to="/" 
        className={`logo-crest ${isScrolled ? 'logo-crest--compact' : ''}`}
      >
        <img 
          src={visuals.getSingle('branding.logo', visualsData.branding.logo)} 
          alt="Tanzania Sensational" 
        />
      </Link>

      <nav id="navbar" className={`${isScrolled ? 'scrolled' : ''} ${isMobileOpen ? 'mobile-open' : ''}`}>
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
            <li className={`dropdown mega-dropdown ${isDropdownActive('trekking') ? 'mobile-active' : ''}`}>
              <Link to="/#routes" className="dropdown-toggle" onClick={(e) => handleToggle(e, 'trekking')}>
                Trekking
                <svg viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" /></svg>
              </Link>
              
              {/* ─── HORIZON MEGA MENU (Desktop) ─── */}
              <div className="mega-menu">
                <div className="mega-menu-inner">
                  {/* Column 1: Destinations */}
                  <div className="mega-col">
                    <h3 className="mega-heading">Destinations</h3>
                    <div className="mega-links-group">
                      <h4 className="mega-subheading">Kilimanjaro</h4>
                      <ul className="mega-sub-links">
                        <li><Link to="/trekking/kilimanjaro/lemosho">Lemosho Route</Link></li>
                        <li><Link to="/trekking/kilimanjaro/machame">Machame Route</Link></li>
                        <li><Link to="/trekking/kilimanjaro/marangu">Marangu Route</Link></li>
                        <li><Link to="/trekking/kilimanjaro/rongai">Rongai Route</Link></li>
                        <li><Link to="/trekking/kilimanjaro/northern-circuit">Northern Circuit</Link></li>
                        <li><Link to="/trekking/kilimanjaro/umbwe">Umbwe Route</Link></li>
                      </ul>
                    </div>
                    <div className="mega-links-group" style={{ marginTop: '25px' }}>
                      <h4 className="mega-subheading">Mount Meru</h4>
                      <ul className="mega-sub-links">
                        {meruPackages.length > 0 ? (
                          meruPackages.map(pkg => (
                            <li key={pkg.id}>
                              <Link to={`/trekking/meru/${pkg.slug}`}>{pkg.name}</Link>
                            </li>
                          ))
                        ) : (
                          <li><Link to="/trekking/meru/4-day-mount-meru-trekking">Mount Meru Trek</Link></li>
                        )}
                      </ul>
                    </div>
                  </div>

                  {/* Column 2: Preparation */}
                  <div className="mega-col">
                    <h3 className="mega-heading">Preparation</h3>
                    <ul className="mega-sub-links">
                      <li><Link to="/trekking/prep/best-time">Best Time to Climb</Link></li>
                      <li><Link to="/trekking/prep/best-routes">Best Routes</Link></li>
                      <li><Link to="/trekking/prep/why-us">Why Ndauwo?</Link></li>
                      <li><Link to="/trekking/prep/tipping-guide">Tipping Guide</Link></li>
                      <li><Link to="/trekking/prep/park-fees">Park Fees</Link></li>
                      <li><Link to="/trekking/prep/toilets">Toilets on Kili</Link></li>
                    </ul>
                  </div>

                  {/* Column 3: Health & Safety */}
                  <div className="mega-col">
                    <h3 className="mega-heading">Health & Safety</h3>
                    <ul className="mega-sub-links">
                      <li><Link to="/trekking/health/vaccinations">Vaccinations</Link></li>
                      <li><Link to="/trekking/health/altitude-sickness">Altitude Sickness</Link></li>
                      <li><Link to="/trekking/health/diamox">Diamox</Link></li>
                      <li><Link to="/trekking/health/oxygen">Oxygen & Safety</Link></li>
                    </ul>
                  </div>

                  {/* Column 4: During the Trek */}
                  <div className="mega-col">
                    <h3 className="mega-heading">During the Trek</h3>
                    <ul className="mega-sub-links">
                      <li><Link to="/trekking/during/daily-routine">Daily Routine</Link></li>
                      <li><Link to="/trekking/during/food-and-drinks">Food & Drinks</Link></li>
                      <li><Link to="/trekking/during/pack-your-daypack">Daypack Essentials</Link></li>
                      <li><Link to="/trekking/during/connectivity">Connectivity</Link></li>
                    </ul>
                  </div>

                  {/* Column 5: Before You Go */}
                  <div className="mega-col">
                    <h3 className="mega-heading">Before You Go</h3>
                    <ul className="mega-sub-links">
                      <li><Link to="/trekking/after/training">Training Guide</Link></li>
                      <li><Link to="/trekking/after/gear-list">Gear List</Link></li>
                      <li><Link to="/trekking/after/getting-there">Getting There</Link></li>
                      <li><Link to="/trekking/after/visa">Visa Info</Link></li>
                    </ul>
                  </div>
                </div>
              </div>

              {/* ─── MOBILE ACCORDION (Hidden on Desktop) ─── */}
              <ul className="dropdown-menu mobile-only">
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
                <li className={`has-submenu ${isDropdownActive('tips') ? 'mobile-active' : ''}`}>
                  <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'tips')}>Tips</div>
                  <ul className="submenu">
                    <li className={`has-submenu ${isDropdownActive('prep') ? 'mobile-active' : ''}`}>
                      <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'prep')}>Preparation</div>
                      <ul className="submenu">
                        <li><Link to="/trekking/prep/best-routes">Best Routes</Link></li>
                        <li><Link to="/trekking/prep/best-time">Best Time to Climb</Link></li>
                        <li><Link to="/trekking/prep/why-us">Why Climb With Us</Link></li>
                        <li><Link to="/trekking/prep/tipping-guide">Tipping Guide</Link></li>
                        <li><Link to="/trekking/prep/park-fees">Park Fees</Link></li>
                        <li><Link to="/trekking/prep/toilets">Toilets on Kilimanjaro</Link></li>
                      </ul>
                    </li>
                    <li className={`has-submenu ${isDropdownActive('health') ? 'mobile-active' : ''}`}>
                      <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'health')}>Health & Safety</div>
                      <ul className="submenu">
                        <li><Link to="/trekking/health/vaccinations">Vaccinations</Link></li>
                        <li><Link to="/trekking/health/altitude-sickness">Altitude Sickness</Link></li>
                        <li><Link to="/trekking/health/diamox">Diamox</Link></li>
                        <li><Link to="/trekking/health/oxygen">Oxygen on Kilimanjaro</Link></li>
                      </ul>
                    </li>
                    <li className={`has-submenu ${isDropdownActive('during') ? 'mobile-active' : ''}`}>
                      <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'during')}>During the Trek</div>
                      <ul className="submenu">
                        <li><Link to="/trekking/during/daily-routine">Daily Routine</Link></li>
                        <li><Link to="/trekking/during/food-and-drinks">Food & Drinks</Link></li>
                        <li><Link to="/trekking/during/pack-your-daypack">Pack Your Daypack</Link></li>
                        <li><Link to="/trekking/during/connectivity">Connectivity</Link></li>
                      </ul>
                    </li>
                    <li className={`has-submenu ${isDropdownActive('before') ? 'mobile-active' : ''}`}>
                      <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'before')}>Before You Go</div>
                      <ul className="submenu">
                        <li><Link to="/trekking/after/training">Training Guide</Link></li>
                        <li><Link to="/trekking/after/gear-list">Gear List</Link></li>
                        <li><Link to="/trekking/after/getting-there">Getting There</Link></li>
                        <li><Link to="/trekking/after/visa">Visa Information</Link></li>
                      </ul>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>

            {/* Safaris Dropdown */}
            <li className={`dropdown mega-dropdown ${isDropdownActive('safaris') ? 'mobile-active' : ''}`}>
              <Link to="/safaris" className="dropdown-toggle" onClick={(e) => handleToggle(e, 'safaris')}>
                Safaris
                <svg viewBox="0 0 10 6" fill="none"><path d="M1 1l4 4 4-4" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round" /></svg>
              </Link>
              
              {/* ─── HORIZON MEGA MENU (Desktop) ─── */}
              <div className="mega-menu">
                <div className="mega-menu-inner" style={{ gridTemplateColumns: '1fr 1fr 1fr' }}>
                  {/* Column 1: Destinations */}
                    <div className="mega-col">
                      <h3 className="mega-heading">Destinations</h3>
                      <ul className="mega-sub-links">
                        {safariDestinations.length > 0 ? (
                          safariDestinations.map(dest => (
                            <li key={dest.id}>
                              <Link to={`/safaris/destinations/${dest.id}`}>{dest.name}</Link>
                            </li>
                          ))
                        ) : (
                          <>
                            <li><Link to="/safaris/tanzania">Tanzania Safaris</Link></li>
                            <li><Link to="/safaris/kenya">Kenya Safaris</Link></li>
                            <li><Link to="/safaris/uganda">Uganda Safaris</Link></li>
                            <li><Link to="/safaris/rwanda">Rwanda Safaris</Link></li>
                          </>
                        )}
                      </ul>
                    </div>


                  {/* Column 3: Packages */}
                  <div className="mega-col">
                    <h3 className="mega-heading">Packages</h3>
                    <ul className="mega-sub-links">
                      <li><Link to="/safaris">Safari Overview</Link></li>
                      <li><Link to="/safaris/packages">Featured Packages</Link></li>
                      <li><Link to="/safaris/group-joining">Group Joining</Link></li>
                    </ul>
                  </div>

                  {/* Column 4: Safari Guide */}
                  <div className="mega-col">
                    <h3 className="mega-heading">Safari Guide</h3>
                    <ul className="mega-sub-links">
                      <li><Link to="/safari-guide/what-to-wear">What to Wear</Link></li>
                      <li><Link to="/safari-guide/packing-guide">Packing List</Link></li>
                      <li><Link to="/safari-guide/health-and-safety">Health & Safety</Link></li>
                      <li><Link to="/safari-guide/local-custom">Safari Etiquette</Link></li>
                    </ul>
                  </div>
                </div>
              </div>

              {/* ─── MOBILE ACCORDION (Hidden on Desktop) ─── */}
              <ul className="dropdown-menu mobile-only">
                <li className={`has-submenu ${isDropdownActive('safari-dest') ? 'mobile-active' : ''}`}>
                  <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'safari-dest')}>Destinations</div>
                  <ul className="submenu">
                    {safariDestinations.length > 0 ? (
                      safariDestinations.map(dest => (
                        <li key={dest.id}><Link to={`/safaris/destinations/${dest.id}`}>{dest.name}</Link></li>
                      ))
                    ) : (
                      <>
                        <li><Link to="/safaris/tanzania">Tanzania</Link></li>
                        <li><Link to="/safaris/kenya">Kenya</Link></li>
                      </>
                    )}
                  </ul>
                </li>
                <li><Link to="/safaris/packages">Packages</Link></li>
                <li className={`has-submenu ${isDropdownActive('safari-guide') ? 'mobile-active' : ''}`}>
                  <div className="dropdown-toggle" onClick={(e) => handleToggle(e, 'safari-guide')}>Safari Guide</div>
                  <ul className="submenu">
                    <li><Link to="/safari-guide/what-to-wear">What to Wear</Link></li>
                    <li><Link to="/safari-guide/packing-list">Packing List</Link></li>
                    <li><Link to="/safari-guide/best-time">Best Time</Link></li>
                  </ul>
                </li>
              </ul>
            </li>

            <li><Link to="/zanzibar">Zanzibar</Link></li>
            <li><Link to="/group-departures">Departures</Link></li>
            <li><Link to="/about">About Us</Link></li>
            <li><Link to="/contact">Contact</Link></li>
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
