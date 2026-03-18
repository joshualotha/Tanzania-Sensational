import React, { useEffect, useMemo, useState } from 'react';
import { motion, useScroll, useTransform } from 'framer-motion';
import { Link } from 'react-router-dom';
import { blogService } from '../../services/api';
import { useVisuals } from '../../context/VisualsContext';
import '../../styles/blog-premium.css';

export const BlogList = () => {
    const { scrollYProgress } = useScroll();
    const bgY = useTransform(scrollYProgress, [0, 1], ['0%', '20%']);
    const visuals = useVisuals();

    const [posts, setPosts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    useEffect(() => {
        window.scrollTo(0, 0);
    }, []);

    useEffect(() => {
        let mounted = true;
        const run = async () => {
            setLoading(true);
            setError(null);
            try {
                const res = await blogService.getAll();
                if (!mounted) return;
                setPosts(Array.isArray(res.data) ? res.data : []);
            } catch (e) {
                if (!mounted) return;
                setError(e);
            } finally {
                if (!mounted) return;
                setLoading(false);
            }
        };
        run();
        return () => { mounted = false; };
    }, []);

    const fadeInUp = {
        hidden: { opacity: 0, y: 50 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const staggerContainer = {
        hidden: { opacity: 0 },
        visible: { opacity: 1, transition: { staggerChildren: 0.2, delayChildren: 0.1 } }
    };

    const sortedPosts = useMemo(() => {
        return [...posts].sort((a, b) => {
            const ad = a.published_at ? new Date(a.published_at).getTime() : 0;
            const bd = b.published_at ? new Date(b.published_at).getTime() : 0;
            return bd - ad;
        });
    }, [posts]);

    const featuredPost = sortedPosts[0] || null;
    const remainingPosts = featuredPost ? sortedPosts.slice(1) : [];

    return (
        <div className="blog-root">
            {/* ─── MASSIVE FEATURED HERO POST ─── */}
            <section className="blog-featured-hero">
                <motion.div style={{ y: bgY }} className="blog-featured-bg">
                    <img
                        src={featuredPost?.hero_image || visuals.getSingle('blog.hero', "https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&q=80")}
                        alt={featuredPost?.title || "Journal"}
                    />
                </motion.div>
                <div className="blog-featured-overlay"></div>

                <motion.div
                    className="blog-featured-content"
                    initial="hidden" animate="visible" variants={staggerContainer}
                >
                    <motion.span className="blog-featured-eyebrow" variants={fadeInUp}>Featured Journal</motion.span>
                    <motion.h1 className="blog-featured-title" variants={fadeInUp}>
                        {loading ? "Loading…" : (featuredPost?.title || (error ? "Journal Unavailable" : "No Posts Yet"))}
                    </motion.h1>
                    <motion.div className="blog-featured-meta" variants={fadeInUp}>
                        <span>{featuredPost?.category || "Travel"}</span>
                        <span style={{ color: 'var(--gold)' }}>|</span>
                        <span>
                            {featuredPost?.published_at
                                ? new Date(featuredPost.published_at).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' })
                                : "—"}
                        </span>
                        <span style={{ color: 'var(--gold)' }}>|</span>
                        <span>By {featuredPost?.author || "Editorial"}</span>
                    </motion.div>

                    <motion.div variants={fadeInUp} style={{ marginTop: '40px' }}>
                        {featuredPost?.slug ? (
                            <Link to={`/blog/${featuredPost.slug}`} className="blog-ed-read" style={{ fontSize: '1rem' }}>
                                Read Featured Story
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5">
                                    <line x1="0" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </Link>
                        ) : null}
                    </motion.div>
                </motion.div>
            </section>

            {/* ─── STAGGERED EDITORIAL GRID ─── */}
            <section className="blog-editorial-grid">
                {!loading && error ? (
                    <div style={{ color: 'rgba(255,255,255,0.6)', padding: '60px 20px', textAlign: 'center' }}>
                        Couldn’t load posts right now. Please refresh and try again.
                    </div>
                ) : remainingPosts.map((blog, i) => (
                    <motion.div
                        key={blog.slug || i}
                        initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-150px" }}
                        variants={fadeInUp}
                    >
                        <Link to={`/blog/${blog.slug}`} className="blog-ed-card">
                            <div className="blog-ed-img-wrap">
                                <img src={blog.hero_image} alt={blog.title} />
                            </div>
                            <div className="blog-ed-info">
                                <span className="blog-ed-cat">{blog.category}</span>
                                <span className="blog-ed-date">
                                    {blog.published_at
                                        ? new Date(blog.published_at).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' })
                                        : "—"}
                                </span>
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
