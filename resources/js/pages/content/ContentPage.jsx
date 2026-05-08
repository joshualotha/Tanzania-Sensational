import React from 'react';
import { usePage } from '@inertiajs/react';
import { CmsSection } from '../../components/cms/CmsSection';
import '../../styles/utility-pages-premium.css';

const ContentPage = ({ data, fixedSection }) => {
    const { visuals } = usePage().props;

    const getVisual = (section, fallback) => {
        if (visuals && visuals[section] && visuals[section].length > 0) {
            return visuals[section][visuals[section].length - 1];
        }
        return fallback;
    };

    if (!data) {
        return (
            <div style={{ minHeight: '60vh', display: 'grid', placeItems: 'center', padding: 20 }}>
                <div className="admin-panel shadow-premium" style={{ padding: 26, maxWidth: 760 }}>
                    <h1 style={{ color: 'white', fontWeight: 300, margin: 0, fontSize: '2rem' }}>Page not found</h1>
                    <p style={{ color: 'rgba(255,255,255,0.6)', marginTop: 10 }}>
                        This page hasn't been published in the dashboard yet.
                    </p>
                </div>
            </div>
        );
    }

    return (
        <main className="utility-root">
            <section className="utility-hero">
                <div className="utility-hero-bg">
                    <img
                        src={data?.og_image || getVisual('common.placeholderHero', 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=2000&q=80')}
                        alt={`${data?.title || 'Tanzania travel guide'} — information page on Tanzania Sensational`}
                    />
                </div>
                <div className="utility-hero-overlay" />
                <div className="utility-hero-content">
                    <span className="utility-hero-eyebrow">{fixedSection || 'Guide'}</span>
                    <h1 className="utility-hero-title">{data?.title || 'Information'}</h1>
                    {data?.meta_description ? (
                        <p className="utility-hero-subtitle">{data.meta_description}</p>
                    ) : null}
                </div>
            </section>

            <section className="utility-content">
                <div className="util-card" style={{ padding: 28 }}>
                    <CmsSection html={data?.content || ''} />
                </div>
            </section>
        </main>
    );
};

export default ContentPage;
