import React, { createContext, useContext, useMemo } from 'react';
import { usePage } from '@inertiajs/react';

const SettingsContext = createContext(null);

export const useSettings = () => useContext(SettingsContext);

export const SettingsProvider = ({ children }) => {
    // Use Inertia's usePage() hook to access shared props (works in Inertia context).
    // Falls back gracefully for admin CSR pages where Inertia context may not exist.
    let inertiaSettings = null;
    try {
        const { props } = usePage();
        inertiaSettings = props?.settings;
    } catch (e) {
        // Not in Inertia context (admin CSR pages)
    }

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
