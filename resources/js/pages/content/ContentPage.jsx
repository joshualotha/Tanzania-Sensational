import React, { useEffect, useMemo, useState } from 'react';
import { useLocation, useParams } from 'react-router-dom';
import { Loader2 } from 'lucide-react';
import { pageService } from '../../services/api';
import { CmsSection } from '../../components/cms/CmsSection';
import '../../styles/admin-premium.css';

function toSlugPart(input) {
    return String(input || '')
        .trim()
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
}

export const ContentPage = ({ fixedSection = null }) => {
    const { section, page } = useParams();
    const location = useLocation();

    const derivedSlug = useMemo(() => {
        const s = toSlugPart(section || fixedSection);
        const p = toSlugPart(page);
        if (!s || !p) return null;
        return `${s}-${p}`;
    }, [fixedSection, section, page]);

    const [data, setData] = useState(null);
    const [loading, setLoading] = useState(true);
    const [error, setError] = useState('');
    const [notFound, setNotFound] = useState(false);

    useEffect(() => {
        window.scrollTo(0, 0);
    }, [location.pathname]);

    useEffect(() => {
        let mounted = true;
        const run = async () => {
            setLoading(true);
            setError('');
            setNotFound(false);
            setData(null);

            if (!derivedSlug) {
                setLoading(false);
                setNotFound(true);
                return;
            }

            try {
                const res = await pageService.getBySlug(derivedSlug);
                if (!mounted) return;
                setData(res.data);
            } catch (e) {
                if (!mounted) return;
                if (e?.response?.status === 404) {
                    setNotFound(true);
                } else {
                    setError('Unable to load this page right now.');
                }
            } finally {
                if (!mounted) return;
                setLoading(false);
            }
        };

        run();
        return () => { mounted = false; };
    }, [derivedSlug]);

    if (loading) {
        return (
            <div style={{ minHeight: '60vh', display: 'grid', placeItems: 'center' }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: 12, color: 'rgba(255,255,255,0.7)' }}>
                    <Loader2 className="animate-spin" size={22} color="var(--gold)" />
                    <span>Loading…</span>
                </div>
            </div>
        );
    }

    if (notFound) {
        return (
            <div style={{ minHeight: '60vh', display: 'grid', placeItems: 'center', padding: 20 }}>
                <div className="admin-panel shadow-premium" style={{ padding: 26, maxWidth: 760 }}>
                    <h1 style={{ color: 'white', fontWeight: 300, margin: 0, fontSize: '2rem' }}>Page not found</h1>
                    <p style={{ color: 'rgba(255,255,255,0.6)', marginTop: 10 }}>
                        This page hasn’t been published in the dashboard yet.
                    </p>
                </div>
            </div>
        );
    }

    if (error) {
        return (
            <div style={{ minHeight: '60vh', display: 'grid', placeItems: 'center', padding: 20 }}>
                <div className="admin-panel shadow-premium" style={{ padding: 26, maxWidth: 760 }}>
                    <h1 style={{ color: 'white', fontWeight: 300, margin: 0, fontSize: '2rem' }}>Something went wrong</h1>
                    <p style={{ color: 'rgba(255,255,255,0.6)', marginTop: 10 }}>{error}</p>
                    <button
                        className="admin-btn-primary"
                        style={{ marginTop: 16 }}
                        onClick={() => window.location.reload()}
                    >
                        Retry
                    </button>
                </div>
            </div>
        );
    }

    return (
        <main className="utility-root" style={{ paddingTop: 40 }}>
            <section className="utility-content">
                <div style={{ marginBottom: 18 }}>
                    <h1 style={{ color: 'white', fontWeight: 300, fontSize: '2.6rem', margin: 0 }}>
                        {data?.title || 'Information'}
                    </h1>
                </div>
                <div className="admin-panel shadow-premium" style={{ padding: 22 }}>
                    <CmsSection html={data?.content || ''} />
                </div>
            </section>
        </main>
    );
};

