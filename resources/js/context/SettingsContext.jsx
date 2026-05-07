import React, { createContext, useContext, useMemo } from 'react';

const SettingsContext = createContext(null);

export const useSettings = () => useContext(SettingsContext);

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

export const SettingsProvider = ({ children }) => {
    // Read settings from the DOM's data-page attribute (works outside Inertia context).
    const pageData = readInertiaPageData();
    const inertiaSettings = pageData?.props?.settings ?? null;

    const settings = useMemo(() => {
        if (inertiaSettings) {
            return { settings: inertiaSettings };
        }
        return {};
    }, [inertiaSettings]);

    return (
        <SettingsContext.Provider value={{ settings, loading: false }}>
            {children}
        </SettingsContext.Provider>
    );
};
