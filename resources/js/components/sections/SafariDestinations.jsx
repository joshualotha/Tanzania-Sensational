import React from 'react';
import { Link } from '@inertiajs/react';
import { motion } from 'framer-motion';
import { ArrowRight, MapPin } from 'lucide-react';
import '../../styles/safari-destinations-home.css';

export const SafariDestinations = ({ destinations }) => {
  if (!destinations || destinations.length === 0) return null;

  const getHeroImage = (dest) => {
    if (dest.hero_image) return dest.hero_image;
    return 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&q=80&w=800';
  };

  const fadeInUp = {
    hidden: { opacity: 0, y: 30 },
    visible: { opacity: 1, y: 0, transition: { duration: 0.8, ease: [0.16, 1, 0.3, 1] } }
  };

  const stagger = {
    hidden: { opacity: 0 },
    visible: { opacity: 1, transition: { staggerChildren: 0.1 } }
  };

  // Split: first destination is large, rest are smaller
  const featured = destinations[0];
  const rest = destinations.slice(1, 5);

  return (
    <section className="dest-home">
      <div className="dest-home-inner">
        <motion.div
          className="dest-home-header"
          initial="hidden"
          whileInView="visible"
          viewport={{ once: true, margin: '-80px' }}
          variants={fadeInUp}
        >
          <div>
            <span className="dest-home-eyebrow">Explore the Wild</span>
            <h2 className="dest-home-title">Safari <em>Destinations</em></h2>
          </div>
          <Link href="/safaris/destinations" className="dest-home-viewall">
            All Destinations <ArrowRight size={16} />
          </Link>
        </motion.div>

        <motion.div
          className="dest-home-layout"
          initial="hidden"
          whileInView="visible"
          viewport={{ once: true, margin: '-80px' }}
          variants={stagger}
        >
          {/* Featured large card */}
          {featured && (
            <motion.div className="dest-home-featured" variants={fadeInUp}>
              <Link href={`/safaris/destinations/${featured.slug}`} className="dest-home-card dest-home-card-lg">
                <div className="dest-home-card-img">
                  <img src={getHeroImage(featured)} alt={featured.name} loading="lazy" />
                  <div className="dest-home-card-gradient"></div>
                </div>
                <div className="dest-home-card-content">
                  {featured.meta_tag && (
                    <span className="dest-home-card-region"><MapPin size={12} /> {featured.meta_tag}</span>
                  )}
                  <h3 className="dest-home-card-name">{featured.name}</h3>
                  {featured.meta_subtitle && (
                    <p className="dest-home-card-tagline">{featured.meta_subtitle}</p>
                  )}
                  <span className="dest-home-card-link">
                    Explore <ArrowRight size={14} />
                  </span>
                </div>
              </Link>
            </motion.div>
          )}

          {/* Smaller cards grid */}
          <div className="dest-home-small-grid">
            {rest.map((dest) => (
              <motion.div key={dest.id} variants={fadeInUp}>
                <Link href={`/safaris/destinations/${dest.slug}`} className="dest-home-card dest-home-card-sm">
                  <div className="dest-home-card-img">
                    <img src={getHeroImage(dest)} alt={dest.name} loading="lazy" />
                    <div className="dest-home-card-gradient"></div>
                  </div>
                  <div className="dest-home-card-content">
                    {dest.meta_tag && (
                      <span className="dest-home-card-region"><MapPin size={11} /> {dest.meta_tag}</span>
                    )}
                    <h3 className="dest-home-card-name">{dest.name}</h3>
                    {dest.meta_subtitle && (
                      <p className="dest-home-card-tagline">{dest.meta_subtitle}</p>
                    )}
                    <span className="dest-home-card-link">
                      Explore <ArrowRight size={13} />
                    </span>
                  </div>
                </Link>
              </motion.div>
            ))}
          </div>
        </motion.div>
      </div>
    </section>
  );
};
