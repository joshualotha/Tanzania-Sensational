import React, { useState, useEffect } from 'react';
import { Link, useLocation } from 'react-router-dom';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import { trekkingService, destinationService } from '../../services/api';

export const Navbar = () => {
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
      <nav id="navbar" className={isMobileOpen ? 'mobile-open' : ''}>
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
                      <li><Link to="/trekking/prep/why-us">Why Choose us</Link></li>
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
                      <li><Link to="/safari-guide/packing-list">Packing List</Link></li>
                      <li><Link to="/safari-guide/health-safety">Health & Safety</Link></li>
                      <li><Link to="/safari-guide/safari-etiquette">Safari Etiquette</Link></li>
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
                    <li><Link to="/safari-guide/health-safety">Health & Safety</Link></li>
                    <li><Link to="/safari-guide/safari-etiquette">Safari Etiquette</Link></li>
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

          {/* Mobile Toggle inside the island */}
          <button
            className={`mobile-hamburger ${isMobileOpen ? 'open' : ''}`}
            onClick={() => setIsMobileOpen(!isMobileOpen)}
            aria-label="Toggle navigation"
          >
            <span></span><span></span><span></span>
          </button>
        </div>
      </nav>

      {/* ─── FULL-SCREEN MOBILE DRAWER ─── */}
      <div className={`mobile-drawer ${isMobileOpen ? 'is-open' : ''}`}>
        <div className="mobile-drawer-backdrop" onClick={() => setIsMobileOpen(false)} />
        <div className="mobile-drawer-panel">
          {/* Close button */}
          <button className="mobile-drawer-close" onClick={() => setIsMobileOpen(false)} aria-label="Close menu">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M18 6L6 18M6 6l12 12" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round"/>
            </svg>
          </button>

          {/* Scrollable content */}
          <div className="mobile-drawer-scroll">
            {/* Primary Links */}
            <div className="mobile-drawer-primary">
              <div className="mobile-drawer-group">
                <button
                  className={`mobile-drawer-link has-children ${isDropdownActive('trekking') ? 'expanded' : ''}`}
                  onClick={(e) => handleToggle(e, 'trekking')}
                >
                  <span>Trekking</span>
                  <svg className="mobile-drawer-chevron" width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M3.5 5.25L7 8.75l3.5-3.5" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
                  </svg>
                </button>
                {isDropdownActive('trekking') && (
                  <div className="mobile-drawer-sub">
                    <div className="mobile-drawer-sub-group">
                      <span className="mobile-drawer-label">Kilimanjaro</span>
                      <Link to="/trekking/kilimanjaro/lemosho">Lemosho Route</Link>
                      <Link to="/trekking/kilimanjaro/machame">Machame Route</Link>
                      <Link to="/trekking/kilimanjaro/marangu">Marangu Route</Link>
                      <Link to="/trekking/kilimanjaro/rongai">Rongai Route</Link>
                      <Link to="/trekking/kilimanjaro/northern-circuit">Northern Circuit</Link>
                      <Link to="/trekking/kilimanjaro/umbwe">Umbwe Route</Link>
                    </div>
                    <div className="mobile-drawer-sub-group">
                      <span className="mobile-drawer-label">Mount Meru</span>
                      {meruPackages.length > 0 ? meruPackages.map(pkg => (
                        <Link key={pkg.id} to={`/trekking/meru/${pkg.slug}`}>{pkg.name}</Link>
                      )) : (
                        <Link to="/trekking/meru/4-day-mount-meru-trekking">Mount Meru Trek</Link>
                      )}
                    </div>
                    <div className="mobile-drawer-sub-group">
                      <span className="mobile-drawer-label">Preparation</span>
                      <Link to="/trekking/prep/best-routes">Best Routes</Link>
                      <Link to="/trekking/prep/best-time">Best Time to Climb</Link>
                      <Link to="/trekking/prep/why-us">Why Climb With Us</Link>
                      <Link to="/trekking/after/gear-list">Gear List</Link>
                    </div>
                  </div>
                )}
              </div>

              <div className="mobile-drawer-group">
                <button
                  className={`mobile-drawer-link has-children ${isDropdownActive('safaris') ? 'expanded' : ''}`}
                  onClick={(e) => handleToggle(e, 'safaris')}
                >
                  <span>Safaris</span>
                  <svg className="mobile-drawer-chevron" width="14" height="14" viewBox="0 0 14 14" fill="none">
                    <path d="M3.5 5.25L7 8.75l3.5-3.5" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
                  </svg>
                </button>
                {isDropdownActive('safaris') && (
                  <div className="mobile-drawer-sub">
                    <div className="mobile-drawer-sub-group">
                      <span className="mobile-drawer-label">Destinations</span>
                      {safariDestinations.length > 0 ? safariDestinations.map(dest => (
                        <Link key={dest.id} to={`/safaris/destinations/${dest.id}`}>{dest.name}</Link>
                      )) : (
                        <>
                          <Link to="/safaris/tanzania">Tanzania</Link>
                          <Link to="/safaris/kenya">Kenya</Link>
                        </>
                      )}
                    </div>
                    <div className="mobile-drawer-sub-group">
                      <span className="mobile-drawer-label">Packages</span>
                      <Link to="/safaris">Safari Overview</Link>
                      <Link to="/safaris/packages">Featured Packages</Link>
                    </div>
                  </div>
                )}
              </div>

              <Link to="/zanzibar" className="mobile-drawer-link">Zanzibar</Link>
              <Link to="/group-departures" className="mobile-drawer-link">Departures</Link>
              <Link to="/about" className="mobile-drawer-link">About Us</Link>
              <Link to="/contact" className="mobile-drawer-link">Contact</Link>
            </div>

            {/* CTA */}
            <div className="mobile-drawer-footer">
              <Link to="/contact" className="mobile-drawer-cta" onClick={() => setIsMobileOpen(false)}>
                Plan Your Journey
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
                  <path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"/>
                </svg>
              </Link>
              <a href="https://wa.me/255700000000" target="_blank" rel="noopener noreferrer" className="mobile-drawer-whatsapp">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.832-1.438A9.955 9.955 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/></svg>
                WhatsApp Us
              </a>
            </div>
          </div>
        </div>
      </div>
    </>
  );
};
