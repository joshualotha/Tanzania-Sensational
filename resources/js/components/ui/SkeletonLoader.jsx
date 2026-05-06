import React from 'react';

/* ─── CSS-IN-JS SKELETON STYLES ─── */
const keyframes = `
@keyframes skeleton-pulse {
    0% { opacity: 0.6; }
    50% { opacity: 0.3; }
    100% { opacity: 0.6; }
}
@keyframes skeleton-shimmer {
    0% { background-position: -200px 0; }
    100% { background-position: calc(200px + 100%) 0; }
}
`;

const skeletonBase = {
    background: 'linear-gradient(90deg, rgba(255,255,255,0.08) 25%, rgba(255,255,255,0.15) 50%, rgba(255,255,255,0.08) 75%)',
    backgroundSize: '200px 100%',
    animation: 'skeleton-shimmer 1.5s ease-in-out infinite',
    borderRadius: '4px',
};

/* ─── BLOG DETAIL SKELETON ─── */
export const BlogDetailSkeleton = () => (
    <div className="blog-root">
        <style>{keyframes}</style>
        {/* Hero skeleton */}
        <section className="blog-article-hero" style={{ background: '#111' }}>
            <div style={{ position: 'absolute', inset: 0, ...skeletonBase }} />
            <div className="blog-article-overlay" />
            <div className="blog-back-wrapper">
                <div style={{ ...skeletonBase, width: 160, height: 20 }} />
            </div>
            <div className="blog-article-header" style={{ position: 'relative', zIndex: 2 }}>
                <div style={{ ...skeletonBase, width: '70%', maxWidth: 700, height: 48, margin: '0 auto 20px' }} />
                <div style={{ ...skeletonBase, width: 300, height: 20, margin: '0 auto' }} />
            </div>
        </section>

        {/* Content skeleton */}
        <section className="blog-article-layout">
            <article className="blog-article-body" style={{ padding: '60px 40px' }}>
                <div style={{ ...skeletonBase, width: '100%', height: 20, marginBottom: 16 }} />
                <div style={{ ...skeletonBase, width: '100%', height: 20, marginBottom: 16 }} />
                <div style={{ ...skeletonBase, width: '75%', height: 20, marginBottom: 32 }} />
                <div style={{ ...skeletonBase, width: '100%', height: 200, marginBottom: 32 }} />
                <div style={{ ...skeletonBase, width: '100%', height: 20, marginBottom: 16 }} />
                <div style={{ ...skeletonBase, width: '100%', height: 20, marginBottom: 16 }} />
                <div style={{ ...skeletonBase, width: '60%', height: 20, marginBottom: 32 }} />
                <div style={{ ...skeletonBase, width: '100%', height: 20, marginBottom: 16 }} />
                <div style={{ ...skeletonBase, width: '85%', height: 20, marginBottom: 16 }} />
                <div style={{ ...skeletonBase, width: '100%', height: 20, marginBottom: 16 }} />
            </article>
            <aside className="blog-side-pane" style={{ padding: '60px 20px' }}>
                <div style={{ ...skeletonBase, width: '80%', height: 16, marginBottom: 24 }} />
                <div style={{ ...skeletonBase, width: 40, height: 40, marginBottom: 40, borderRadius: '50%' }} />
                <div style={{ ...skeletonBase, width: '80%', height: 16, marginBottom: 24 }} />
                <div style={{ ...skeletonBase, width: '100%', height: 80, marginBottom: 16 }} />
                <div style={{ ...skeletonBase, width: '100%', height: 80 }} />
            </aside>
        </section>
    </div>
);

/* ─── BLOG LIST SKELETON ─── */
export const BlogListSkeleton = () => (
    <div className="blog-root">
        <style>{keyframes}</style>
        {/* Featured hero skeleton */}
        <section className="blog-featured-hero" style={{ background: '#111' }}>
            <div style={{ position: 'absolute', inset: 0, ...skeletonBase }} />
            <div className="blog-featured-overlay" />
            <div className="blog-featured-content" style={{ position: 'relative', zIndex: 2 }}>
                <div style={{ ...skeletonBase, width: 140, height: 16, marginBottom: 20 }} />
                <div style={{ ...skeletonBase, width: '60%', maxWidth: 600, height: 48, marginBottom: 16 }} />
                <div style={{ ...skeletonBase, width: 280, height: 20, marginBottom: 40 }} />
                <div style={{ ...skeletonBase, width: 200, height: 20 }} />
            </div>
        </section>

        {/* Grid skeleton */}
        <section className="blog-editorial-grid">
            {[1, 2, 3, 4].map((i) => (
                <div key={i} style={{ padding: '20px' }}>
                    <div style={{ ...skeletonBase, width: '100%', height: 240, marginBottom: 16 }} />
                    <div style={{ ...skeletonBase, width: 100, height: 14, marginBottom: 12 }} />
                    <div style={{ ...skeletonBase, width: '80%', height: 22, marginBottom: 10 }} />
                    <div style={{ ...skeletonBase, width: '100%', height: 16, marginBottom: 6 }} />
                    <div style={{ ...skeletonBase, width: '60%', height: 16 }} />
                </div>
            ))}
        </section>
    </div>
);

/* ─── GENERIC CONTENT SKELETON ─── */
export const ContentSkeleton = ({ lines = 8, heroHeight = 400 }) => (
    <div style={{ minHeight: '100vh', background: 'var(--dark)' }}>
        <style>{keyframes}</style>
        {/* Hero area */}
        <div style={{ height: heroHeight, background: '#111', position: 'relative', ...skeletonBase }} />
        
        {/* Content lines */}
        <div style={{ maxWidth: 800, margin: '0 auto', padding: '60px 24px' }}>
            <div style={{ ...skeletonBase, width: '50%', height: 32, marginBottom: 32 }} />
            {Array.from({ length: lines }).map((_, i) => (
                <div
                    key={i}
                    style={{
                        ...skeletonBase,
                        width: i === lines - 1 ? '55%' : '100%',
                        height: 18,
                        marginBottom: 14,
                    }}
                />
            ))}
        </div>
    </div>
);

/* ─── CARD SKELETON (for safari/destination cards) ─── */
export const CardSkeleton = ({ count = 3 }) => (
    <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fill, minmax(320px, 1fr))', gap: 24, padding: '40px 24px' }}>
        <style>{keyframes}</style>
        {Array.from({ length: count }).map((_, i) => (
            <div key={i} style={{ background: 'rgba(255,255,255,0.03)', borderRadius: 8, overflow: 'hidden' }}>
                <div style={{ ...skeletonBase, height: 200 }} />
                <div style={{ padding: 20 }}>
                    <div style={{ ...skeletonBase, width: '60%', height: 22, marginBottom: 12 }} />
                    <div style={{ ...skeletonBase, width: '100%', height: 16, marginBottom: 8 }} />
                    <div style={{ ...skeletonBase, width: '80%', height: 16 }} />
                </div>
            </div>
        ))}
    </div>
);
