import React, { createContext, useContext, useMemo } from 'react';
import { usePage } from '@inertiajs/react';

const SettingsContext = createContext(null);

export const useSettings = () => useContext(SettingsContext);

export const SettingsProvider = ({ children }) => {
    // Read settings from Inertia's shared props.
    // This provider must be rendered INSIDE the Inertia <App> component
    // so that usePage() is available.
    const { props } = usePage();
    const inertiaSettings = props?.settings ?? null;

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
