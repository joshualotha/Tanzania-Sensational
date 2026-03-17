import React, { useEffect, useMemo, useState } from 'react';
import { useParams, Link } from 'react-router-dom';
import { motion, useScroll, useTransform } from 'framer-motion';
import { blogService } from '../../services/api';
import DOMPurify from 'dompurify';
import '../../styles/blog-premium.css';

export const BlogDetail = () => {
    const { slug } = useParams();
    const { scrollYProgress } = useScroll();
    const bgY = useTransform(scrollYProgress, [0, 1], ['0%', '30%']);

    const [post, setPost] = useState(null);
    const [allPosts, setAllPosts] = useState([]);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState(null);

    const safeHtml = useMemo(() => {
        if (!post?.content_html) return '';
        return DOMPurify.sanitize(post.content_html, { USE_PROFILES: { html: true } });
    }, [post?.content_html]);

    useEffect(() => {
        window.scrollTo(0, 0);
    }, [slug]);

    useEffect(() => {
        let mounted = true;
        const run = async () => {
            setLoading(true);
            setError(null);
            try {
                const [postRes, listRes] = await Promise.all([
                    blogService.getBySlug(slug),
                    blogService.getAll(),
                ]);
                if (!mounted) return;
                setPost(postRes.data || null);
                setAllPosts(Array.isArray(listRes.data) ? listRes.data : []);
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
    }, [slug]);

    const relatedPosts = useMemo(() => {
        if (!post) return [];
        return allPosts.filter((b) => b.slug && b.slug !== post.slug).slice(0, 2);
    }, [allPosts, post]);

    const share = useMemo(() => {
        const url = typeof window !== 'undefined' ? window.location.href : '';
        const title = post?.title ? String(post.title) : '';
        const u = encodeURIComponent(url);
        const t = encodeURIComponent(title);
        return {
            linkedIn: `https://www.linkedin.com/sharing/share-offsite/?url=${u}`,
            twitter: `https://twitter.com/intent/tweet?url=${u}&text=${t}`,
            facebook: `https://www.facebook.com/sharer/sharer.php?u=${u}`,
        };
    }, [post?.title]);

    if (!loading && (!post || error)) return (
        <div style={{ padding: '150px 20px', textAlign: 'center', background: 'var(--dark)', color: 'white', minHeight: '100vh' }}>
            <h1 style={{ fontFamily: 'Playfair Display', fontSize: '3rem' }}>Article Not Found</h1>
            <Link to="/blog" style={{ color: 'var(--gold)', marginTop: '20px', display: 'inline-block' }}>Return to Journal</Link>
        </div>
    );

    if (loading || !post) {
        return (
            <div style={{ padding: '150px 20px', textAlign: 'center', background: 'var(--dark)', color: 'white', minHeight: '100vh' }}>
                <h1 style={{ fontFamily: 'Playfair Display', fontSize: '3rem' }}>Loading…</h1>
                <Link to="/blog" style={{ color: 'var(--gold)', marginTop: '20px', display: 'inline-block' }}>Return to Journal</Link>
            </div>
        );
    }

    const fadeInUp = {
        hidden: { opacity: 0, y: 50 },
        visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
    };

    const renderBlock = (block, idx) => {
        switch (block.type) {
            case 'paragraph':
                return <p key={idx} className="blog-block-p">{block.content}</p>;
            case 'heading':
                return <h2 key={idx} className="blog-block-h2">{block.content}</h2>;
            case 'image':
                return (
                    <motion.div
                        key={idx} className="blog-block-img"
                        initial={{ opacity: 0, scale: 0.98 }}
                        whileInView={{ opacity: 1, scale: 1 }}
                        viewport={{ once: true, margin: "-100px" }}
                        transition={{ duration: 1.2, ease: [0.16, 1, 0.3, 1] }}
                    >
                        <img src={block.src} alt={block.alt} />
                    </motion.div>
                );
            case 'quote':
                return (
                    <motion.div
                        key={idx} className="blog-block-quote"
                        style={{ borderLeft: 'none', fontStyle: 'italic', color: 'white', opacity: 0.9, padding: '40px 0', borderTop: '1px solid rgba(255,255,255,0.1)', borderBottom: '1px solid rgba(255,255,255,0.1)' }}
                        initial="hidden" whileInView="visible" viewport={{ once: true }} variants={fadeInUp}
                    >
                        "{block.content}"
                    </motion.div>
                );
            default:
                return null;
        }
    };

    return (
        <div className="blog-root">
            {/* ─── 100VH MASSIVE HERO ─── */}
            <section className="blog-article-hero">
                <motion.div style={{ y: bgY }} className="blog-article-bg">
                    <img src={post.hero_image} alt={post.title} />
                </motion.div>
                <div className="blog-article-overlay"></div>

                <div className="blog-back-wrapper">
                    <Link to="/blog" className="blog-back-mag">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        Trekker's Journal
                    </Link>
                </div>

                <motion.div
                    className="blog-article-header"
                    initial="hidden" animate="visible" variants={{
                        hidden: { opacity: 0 },
                        visible: { opacity: 1, transition: { staggerChildren: 0.2, delayChildren: 0.2 } }
                    }}
                >
                    <motion.h1 className="blog-article-title" variants={fadeInUp}>{post.title}</motion.h1>
                    <motion.div className="blog-article-meta" variants={fadeInUp}>
                        <span><span className="gold">By</span> {post.author}</span>
                        <span><span className="gold">|</span></span>
                        <span>{post.category}</span>
                        <span><span className="gold">|</span></span>
                        <span>
                            {post.published_at
                                ? new Date(post.published_at).toLocaleDateString(undefined, { year: 'numeric', month: 'short', day: 'numeric' })
                                : "—"}
                        </span>
                    </motion.div>
                </motion.div>
            </section>

            {/* ─── TWO-COLUMN SPREAD ─── */}
            <section className="blog-article-layout">

                {/* Main Reading Column */}
                <article className="blog-article-body">
                    <motion.div
                        initial="hidden" whileInView="visible" viewport={{ once: true, margin: "-100px" }}
                        variants={{
                            hidden: { opacity: 0, y: 50 },
                            visible: { opacity: 1, y: 0, transition: { duration: 1.2, ease: [0.16, 1, 0.3, 1] } }
                        }}
                    >
                        {safeHtml ? (
                            <div dangerouslySetInnerHTML={{ __html: safeHtml }} />
                        ) : (
                            Array.isArray(post.content) ? post.content.map((block, idx) => renderBlock(block, idx)) : null
                        )}
                    </motion.div>

                    {/* Footer separator within reading column */}
                    <div style={{ height: '1px', background: 'rgba(255,255,255,0.1)', marginTop: '80px', marginBottom: '40px' }}></div>
                    <div style={{ display: 'flex', justifyContent: 'flex-start', gap: '30px', letterSpacing: '0.1em', textTransform: 'uppercase', fontSize: '0.75rem' }}>
                        <span style={{ color: 'rgba(255,255,255,0.4)' }}>Share Story:</span>
                        <a href={share.linkedIn} target="_blank" rel="noreferrer" style={{ color: 'white', textDecoration: 'none' }}>LinkedIn</a>
                        <a href={share.twitter} target="_blank" rel="noreferrer" style={{ color: 'white', textDecoration: 'none' }}>Twitter</a>
                        <a href={share.facebook} target="_blank" rel="noreferrer" style={{ color: 'white', textDecoration: 'none' }}>Facebook</a>
                    </div>
                </article>

                {/* Vertical Sticky Side Pane */}
                <aside className="blog-side-pane">

                    {/* ─── SIDEBAR: SHARE SECTION ─── */}
                    <div className="blog-side-share">
                        <span className="blog-side-heading">Share Story</span>
                        <div className="blog-share-links">
                            <a href={share.linkedIn} target="_blank" rel="noreferrer" className="blog-share-btn" aria-label="Share on LinkedIn">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                            </a>
                            <a href={share.twitter} target="_blank" rel="noreferrer" className="blog-share-btn" aria-label="Share on Twitter">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
                            </a>
                            <a href={share.facebook} target="_blank" rel="noreferrer" className="blog-share-btn" aria-label="Share on Facebook">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5" strokeLinecap="round" strokeLinejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path></svg>
                            </a>
                        </div>
                    </div>

                    {/* ─── SIDEBAR: RELATED STORIES ─── */}
                    <div className="blog-side-related">
                        <span className="blog-side-heading">Related Stories</span>

                        {relatedPosts.map((relatedPost) => (
                            <Link to={`/blog/${relatedPost.slug}`} className="blog-related-card" key={relatedPost.slug}>
                                <div className="blog-related-img">
                                    <img
                                        src={relatedPost.hero_image || post.hero_image}
                                        alt={relatedPost.title || 'Related story'}
                                    />
                                </div>
                                <div className="blog-related-info">
                                    <span className="blog-related-cat">{relatedPost.category || 'Travel'}</span>
                                    <span className="blog-related-title">
                                        {String(relatedPost.title || '').length > 40
                                            ? String(relatedPost.title || '').substring(0, 40) + '...'
                                            : (relatedPost.title || 'Untitled')}
                                    </span>
                                </div>
                            </Link>
                        ))}
                    </div>

                </aside>

            </section>
        </div>
    );
};
