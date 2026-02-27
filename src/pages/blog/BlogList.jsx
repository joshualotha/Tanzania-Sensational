import React, { useEffect } from 'react';
import { motion, useScroll, useTransform } from 'framer-motion';
import { Link } from 'react-router-dom';
import { blogsData } from '../../data/blogsData';
import '../../styles/blog-premium.css';

export const BlogList = () => {
    const { scrollYProgress } = useScroll();
    const bgY = useTransform(scrollYProgress, [0, 1], ['0%', '20%']);

    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 50 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.2, delayChildren: 0.1 } }
    };

    // Separate the first post as the "Featured" hero post
    const featuredPost = blogsData[0];
    const remainingPosts = blogsData.slice(1);

    return (
        <div className="blog-root">
            {/* ─── MASSIVE FEATURED HERO POST ─── */}
            <section className="blog-featured-hero">
                <motion.div style={{ y: bgY }} className="blog-featured-bg">
                    <img src={featuredPost.coverImg} alt={featuredPost.title} />
                </motion.div>
                <div className="blog-featured-overlay"></div>

                <motion.div
                    className="blog-featured-content"
                    initial="hidden" animate="visible" variants={staggerContainer}
                >
                    <motion.span className="blog-featured-eyebrow" variants={fadeInUp}>Featured Journal</motion.span>
                    <motion.h1 className="blog-featured-title" variants={fadeInUp}>
                        {featuredPost.title}
                    </motion.h1>
                    <motion.div className="blog-featured-meta" variants={fadeInUp}>
                        <span>{featuredPost.category}</span>
                        <span style={{ color: 'var(--gold)' }}>|</span>
                        <span>{featuredPost.date}</span>
                        <span style={{ color: 'var(--gold)' }}>|</span>
                        <span>By {featuredPost.author}</span>
                    </motion.div>

                    <motion.div variants={fadeInUp} style={{ marginTop: '40px' }}>
                        <Link to={`/blog/${featuredPost.slug}`} className="blog-ed-read" style={{ fontSize: '1rem' }}>
                            Read Featured Story
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5">
                                <line x1="0" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </Link>
                    </motion.div>
                </motion.div>
            </section>

            {/* ─── STAGGERED EDITORIAL GRID ─── */}
            <section className="blog-editorial-grid">
                {remainingPosts.map((blog, i) => (
                    <motion.div
                        key={blog.slug}
                        initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-150px" }}
                        variants={fadeInUp}
                    >
                        <Link to={`/blog/${blog.slug}`} className="blog-ed-card">
                            <div className="blog-ed-img-wrap">
                                <img src={blog.coverImg} alt={blog.title} />
                            </div>
                            <div className="blog-ed-info">
                                <span className="blog-ed-cat">{blog.category}</span>
                                <span className="blog-ed-date">{blog.date}</span>
                                <h2 className="blog-ed-title">{blog.title}</h2>
                                <p className="blog-ed-exc">{blog.excerpt}</p>

                                <span className="blog-ed-read">
                                    Continue Reading
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5">
                                        <line x1="0" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </span>
                            </div>
                        </Link>
                    </motion.div>
                ))}
            </section>
        </div>
    );
};
