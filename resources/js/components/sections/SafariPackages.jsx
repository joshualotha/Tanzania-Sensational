import React from 'react';
import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight, Clock, MapPin } from 'lucide-react';
import '../../styles/safari-home-section.css';

export const SafariPackages = ({ packages }) => {
  if (!packages || packages.length === 0) return null;

  const getHeroImage = (pkg) => {
    if (pkg.hero_image) return pkg.hero_image;
    return 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&q=80&w=800';
  };

  const fadeInUp = {
    hidden: { opacity: 0, y: 30 },
    visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.16, 1, 0.3, 1] } }
  };

  const stagger = {
    hidden: { opacity: 0 },
    visible: { opacity: 1, transition: { staggerChildren: 0.12 } }
  };

  return (
    <section className="safari-home">
      <div className="safari-home-inner">
        <motion.div
          className="safari-home-header"
          initial="hidden"
          whileInView="visible"
          viewport={{ once: true, margin: '-80px' }}
          variants={fadeInUp}
        >
          <div>
            <span className="safari-home-eyebrow">Curated Expeditions</span>
            <h2 className="safari-home-title">Safari <em>Packages</em></h2>
            <p className="safari-home-sub">
              From intimate 3-day getaways to comprehensive 14-day expeditions — each safari is designed
              to immerse you in the raw beauty of East Africa's wildlife.
            </p>
          </div>
          <Link href="/safaris/packages" className="safari-home-viewall">
            View All Packages <ArrowRight size={16} />
          </Link>
        </motion.div>

        <motion.div
          className="safari-home-grid"
          initial="hidden"
          whileInView="visible"
          viewport={{ once: true, margin: '-80px' }}
          variants={stagger}
        >
          {packages.slice(0, 6).map((pkg) => (
            <motion.div key={pkg.id} variants={fadeInUp}>
              <Link href={`/safaris/packages/${pkg.slug}`} className="safari-home-card">
                <div className="safari-home-card-img">
                  <img src={getHeroImage(pkg)} alt={pkg.name} loading="lazy" />
                  <div className="safari-home-card-overlay"></div>
                  {pkg.category && (
                    <span className="safari-home-card-badge">{pkg.category}</span>
                  )}
                </div>
                <div className="safari-home-card-body">
                  <div className="safari-home-card-meta">
                    <span><Clock size={13} /> {pkg.duration} Days</span>
                    <span><MapPin size={13} /> {pkg.meta_tag || 'Tanzania'}</span>
                  </div>
                  <h3 className="safari-home-card-title">{pkg.name}</h3>
                  <p className="safari-home-card-desc">
                    {pkg.description
                      ? pkg.description.substring(0, 110) + '...'
                      : 'A curated safari expedition through Tanzania\'s most magnificent wilderness.'}
                  </p>
                  <div className="safari-home-card-price">
                    From ${Math.round(pkg.base_price).toLocaleString()} <span>per person</span>
                  </div>
                  <div className="safari-home-card-cta">
                    Explore Safari <ArrowRight size={14} />
                  </div>
                </div>
              </Link>
            </motion.div>
          ))}
        </motion.div>
      </div>
    </section>
  );
};
