import React, { createContext, useContext, useMemo } from 'react';
import { visualsData } from '../data/visualsData';

const VisualsContext = createContext(null);

function normalizeUrl(url) {
    if (!url) return '';
    return String(url).trim();
}

/**
 * Read Inertia page data from the DOM's data-page attribute.
 * This works because the server-rendered HTML sets data-page on <div id="app">
 * before any JavaScript runs. Unlike usePage(), this can be called from
 * providers that wrap the Inertia <App> component.
 */
function readInertiaPageData() {
    try {
        const el = document.getElementById('app');
        if (!el) return null;
        const raw = el.getAttribute('data-page');
        if (!raw) return null;
        return JSON.parse(raw);
    } catch {
        return null;
    }
}

export function VisualsProvider({ children }) {
    // Read visuals from the DOM's data-page attribute (works outside Inertia context).
    const pageData = readInertiaPageData();
    const inertiaVisuals = pageData?.props?.visuals ?? null;

    const sections = useMemo(() => {
        if (inertiaVisuals && typeof inertiaVisuals === 'object') {
            return inertiaVisuals;
        }
        return {};
    }, [inertiaVisuals]);

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
            loaded: true,
            getSingle,
            getList,
            // Backwards compat for the existing Home hero rotation usage.
            getHeroArray: (section, fallbackArray = []) => (section === 'home.hero' ? getList('home.hero', fallbackArray) : getList(section, fallbackArray)),
            home: {
                hero: homeHero,
            },
        };
    }, [sections]);

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
