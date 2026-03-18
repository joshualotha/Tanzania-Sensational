import React, { useEffect, useState, useMemo } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { ChevronRight, Diamond, Search, X, Loader2 } from 'lucide-react';
import { safariService } from '../../services/api';
import { visualsData } from '../../data/visualsData';
import { useVisuals } from '../../context/VisualsContext';
import '../../styles/safari-packages.css';

export const SafariPackagesList = () => {
    const visuals = useVisuals();
    const [searchQuery, setSearchQuery] = useState('');
    const [activeFilter, setActiveFilter] = useState('ALL');
    const [packages, setPackages] = useState([]);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        window.scrollTo(0, 0);
        const fetchPackages = async () => {
            try {
                const response = await safariService.getAll();
                setPackages(response.data);
            } catch (error) {
                console.error("Failed to fetch safari packages", error);
            } finally {
                setLoading(false);
            }
        };
        fetchPackages();
    }, []);

    const filteredPackages = useMemo(() => {
        return packages.filter(pkg => {
            const matchesSearch = 
                pkg.name.toLowerCase().includes(searchQuery.toLowerCase()) ||
                (pkg.meta_tag && pkg.meta_tag.toLowerCase().includes(searchQuery.toLowerCase()));
            
            const matchesCategory = 
                activeFilter === 'ALL' || 
                (pkg.category && pkg.category.toUpperCase() === activeFilter.toUpperCase());

            return matchesSearch && matchesCategory;
        });
    }, [searchQuery, activeFilter, packages]);

    const categories = ['ALL', 'SIGNATURE', 'CLASSIC', 'EXCLUSIVE'];

    const fadeInUp = {
        hidden: { opacity: 0, y: 40 },
        visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.22, 1, 0.36, 1] } }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.15, delayChildren: 0.1 } }
    };

    return (
        <div className="safari-pkgs-root">
            {/* HERITAGE COLLECTION HERO */}
            <section className="safari-pkgs-hero">
                <div className="safari-pkgs-bg">
                    <img src={visuals.getSingle('safaris.listHero', visualsData.safaris.listHero)} alt="Safari Heritage Hero" />
                </div>
                <div className="safari-pkgs-overlay"></div>
                
                <motion.div
                    className="safari-pkgs-content"
                    initial="hidden" animate="visible" variants={staggerContainer}
                >
                    <motion.div className="heritage-status-badge" variants={fadeInUp}>
                        <Diamond size={14} fill="currentColor" />
                        <span>Curated Heritage Collections</span>
                    </motion.div>
                    
                    <motion.h1 className="safari-pkgs-title" variants={fadeInUp}>
                        Wilderness <em>Archive.</em>
                    </motion.h1>
                    
                    <motion.p className="safari-pkgs-subtitle" variants={fadeInUp}>
                        An authoritative collection of uncompromising expeditions, curated for the discerning traveler seeking depth and authenticity.
                    </motion.p>
                </motion.div>
            </section>

            {/* DISCOVERY FILTERS */}
            <section className="discovery-filter-sec">
                <div className="filter-bar">
                    <div className="search-archive">
                        <Search className="search-icon" size={18} />
                        <input 
                            type="text" 
                            placeholder="Search Archive by Name or Area..." 
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                        />
                    </div>

                    <div className="filter-categories">
                        {categories.map(cat => (
                            <button 
                                key={cat}
                                className={`category-btn ${activeFilter === cat ? 'active' : ''}`}
                                onClick={() => setActiveFilter(cat)}
                            >
                                {cat}
                            </button>
                        ))}
                    </div>
                </div>
            </section>

            {/* HERITAGE GRID */}
            <section className="safari-pkgs-grid-sec">
                {loading ? (
                    <div style={{ padding: '100px', textAlign: 'center' }}>
                        <Loader2 className="animate-spin" size={48} color="var(--gold)" />
                        <p style={{ marginTop: '20px', color: 'rgba(255,255,255,0.4)', fontFamily: 'var(--font-heading)', letterSpacing: '2px' }}>UNPACKING ARCHIVES...</p>
                    </div>
                ) : (
                    <motion.div
                        className="heritage-grid"
                        initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-50px" }}
                        variants={staggerContainer}
                    >
                        {filteredPackages.length > 0 ? (
                            filteredPackages.map((pkg) => (
                                <motion.div key={pkg.id} variants={fadeInUp}>
                                    <Link to={`/safaris/packages/${pkg.id}`} className="heritage-card-solid">
                                        <div className="heritage-card-media">
                                            <img src={pkg.hero_image || visualsData.safaris.listHero} alt={pkg.name} />
                                            <div className="card-heritage-label">{pkg.category || 'SIGNATURE'}</div>
                                        </div>
                                        
                                        <div className="heritage-card-info">
                                            <div className="card-meta-line">{pkg.duration} Days • {pkg.meta_tag}</div>
                                            <h2 className="card-pkg-title">{pkg.name}</h2>
                                            <p className="card-pkg-desc">
                                                {pkg.description ? pkg.description.substring(0, 110) + '...' : 'An exclusive expedition through Tanzania\'s most magnificent wilderness.'}
                                            </p>

                                            <div className="card-pkg-footer">
                                                <div className="card-pkg-price">
                                                    <span>From</span>${Math.round(pkg.base_price)}
                                                </div>
                                                <div className="card-pkg-arrow">
                                                    <ChevronRight size={20} />
                                                </div>
                                            </div>
                                        </div>
                                    </Link>
                                </motion.div>
                            ))
                        ) : (
                            <div className="no-results">
                                <h2 className="no-results-title">No Expeditions Found</h2>
                                <p className="no-results-text">We couldn't find any journeys matching your criteria in the archive.</p>
                                <button 
                                    className="category-btn" 
                                    style={{ marginTop: '30px', display: 'inline-block' }}
                                    onClick={() => { setSearchQuery(''); setActiveFilter('ALL'); }}
                                >
                                    Clear All Filters
                                </button>
                            </div>
                        )}
                    </motion.div>
                )}
            </section>
        </div>
    );
};
