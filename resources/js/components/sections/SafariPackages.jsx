import React from 'react';
import { Link } from '@inertiajs/react';
import { ArrowRight, Clock } from 'lucide-react';
import { visualsData } from '../../data/visualsData';

export const SafariPackages = ({ packages }) => {
  if (!packages || packages.length === 0) return null;

  const getHeroImage = (pkg) => {
    if (pkg.hero_image) return pkg.hero_image;
    return 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&q=80&w=800';
  };

  return (
    <section className="carousel-routes-wrapper" style={{ background: '#fff' }}>
      <div className="carousel-routes-header">
        <div className="carousel-header-left">
          <span className="carousel-eyebrow">Curated Expeditions</span>
          <h2 className="carousel-title">Safari <em>Packages</em></h2>
        </div>
        <div className="carousel-header-right">
          <Link href="/safaris/packages" className="carousel-view-all">
            View All Packages <ArrowRight size={16} />
          </Link>
        </div>
      </div>

      <div className="carousel-track-container">
        <div className="carousel-track">
          {packages.map((pkg) => (
            <Link key={pkg.id} href={`/safaris/packages/${pkg.id}`} className="carousel-card">
              <div className="carousel-card-media">
                {pkg.category && <span className="carousel-badge">{pkg.category}</span>}
                <img
                  src={getHeroImage(pkg)}
                  alt={pkg.name}
                  loading="lazy"
                />
              </div>
              <div className="carousel-card-content">
                <div className="carousel-card-meta">
                  <span>{pkg.duration} Days</span>
                  <span>•</span>
                  <span>{pkg.meta_tag || 'Tanzania'}</span>
                </div>
                <h3 className="carousel-card-title">{pkg.name}</h3>
                <p className="carousel-card-desc">
                  {pkg.description || 'A curated safari expedition through Tanzania\'s most magnificent wilderness areas.'}
                </p>
                <div className="carousel-card-cta">
                  View Package <ArrowRight size={14} />
                </div>
              </div>
            </Link>
          ))}
        </div>
      </div>
    </section>
  );
};
