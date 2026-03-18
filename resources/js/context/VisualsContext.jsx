import React, { createContext, useContext, useEffect, useMemo, useState } from 'react';
import { visualAssetService } from '../services/api';
import { visualsData } from '../data/visualsData';

const VisualsContext = createContext(null);

function normalizeUrl(url) {
    if (!url) return '';
    return String(url).trim();
}

function urlsFromResponse(res) {
    const rows = Array.isArray(res?.data?.data) ? res.data.data : (Array.isArray(res?.data) ? res.data : []);
    return rows.map((r) => normalizeUrl(r?.url)).filter(Boolean);
}

function collectSectionsFromVisuals(obj, prefix = '') {
    const out = [];
    if (!obj || typeof obj !== 'object') return out;

    for (const [k, v] of Object.entries(obj)) {
        const path = prefix ? `${prefix}.${k}` : k;
        if (typeof v === 'string') {
            out.push({ section: path, kind: 'single' });
        } else if (Array.isArray(v)) {
            if (v.every((x) => typeof x === 'string')) {
                out.push({ section: path, kind: 'list' });
            }
        } else if (v && typeof v === 'object') {
            out.push(...collectSectionsFromVisuals(v, path));
        }
    }
    return out;
}

export function VisualsProvider({ children }) {
    const [sections, setSections] = useState({});
    const [loaded, setLoaded] = useState(false);

    useEffect(() => {
        let alive = true;
        (async () => {
            try {
                const discovered = collectSectionsFromVisuals(visualsData);
                const uniqueSections = Array.from(new Set(discovered.map((d) => d.section)));

                const results = await Promise.all(
                    uniqueSections.map((section) =>
                        visualAssetService
                            .getAll({ params: { section, per_page: 96 } })
                            .then((res) => ({ section, res }))
                            .catch(() => ({ section, res: null }))
                    )
                );

                const nextSections = {};
                for (const { section, res } of results) {
                    if (!res) continue;
                    const urls = urlsFromResponse(res);
                    if (urls.length > 0) nextSections[section] = urls;
                }

                if (alive) setSections(nextSections);
            } catch (e) {
                // Silent fallback to static visualsData.
            } finally {
                if (alive) setLoaded(true);
            }
        })();
        return () => { alive = false; };
    }, []);

    const value = useMemo(() => {
        const fallbackHomeHero = normalizeUrl(visualsData?.home?.hero);
        const homeHero = (sections['home.hero'] && sections['home.hero'].length > 0)
            ? sections['home.hero']
            : (fallbackHomeHero ? [fallbackHomeHero] : []);

        const getList = (section, fallbackArray = []) => {
            const arr = Array.isArray(sections?.[section]) ? sections[section] : [];
            if (arr.length > 0) return arr;
            return Array.isArray(fallbackArray) ? fallbackArray.map(normalizeUrl).filter(Boolean) : [];
        };

        const getSingle = (section, fallbackUrl = '') => {
            const arr = getList(section, []);
            const newest = arr.length > 0 ? arr[arr.length - 1] : '';
            return newest || normalizeUrl(fallbackUrl);
        };

        return {
            loaded,
            getSingle,
            getList,
            // Backwards compat for the existing Home hero rotation usage.
            getHeroArray: (section, fallbackArray = []) => (section === 'home.hero' ? getList('home.hero', fallbackArray) : getList(section, fallbackArray)),
            home: {
                hero: homeHero,
            },
        };
    }, [loaded, sections]);

    return (
        <VisualsContext.Provider value={value}>
            {children}
        </VisualsContext.Provider>
    );
}

export function useVisuals() {
    const ctx = useContext(VisualsContext);
    if (!ctx) {
        const fallbackHomeHero = [normalizeUrl(visualsData?.home?.hero)].filter(Boolean);
        return {
            loaded: true,
            getSingle: (_section, fallbackUrl = '') => normalizeUrl(fallbackUrl),
            getList: (_section, fallbackArray = []) => (Array.isArray(fallbackArray) ? fallbackArray.map(normalizeUrl).filter(Boolean) : []),
            getHeroArray: (_section, fallbackArray = []) => (Array.isArray(fallbackArray) ? fallbackArray.map(normalizeUrl).filter(Boolean) : []),
            home: { hero: fallbackHomeHero },
        };
    }
    return ctx;
}

