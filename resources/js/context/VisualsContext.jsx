import React, { createContext, useContext, useEffect, useMemo, useState } from 'react';
import { visualsData } from '../data/visualsData';

const VisualsContext = createContext(null);

function normalizeUrl(url) {
    if (!url) return '';
    return String(url).trim();
}

export function VisualsProvider({ children }) {
    const [sections, setSections] = useState({});
    const [loaded, setLoaded] = useState(false);

    useEffect(() => {
        // Visuals are provided by HandleInertiaRequests middleware for all Inertia pages.
        try {
            const inertiaVisuals = window.__inertia_data?.props?.visuals;
            if (inertiaVisuals && typeof inertiaVisuals === 'object') {
                setSections(inertiaVisuals);
                setLoaded(true);
                return;
            }
        } catch (e) {
            // Not in Inertia context
        }

        // Fallback for admin CSR pages — visuals are not critical for admin functionality
        setLoaded(true);
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
