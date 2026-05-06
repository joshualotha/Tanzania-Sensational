import React, { createContext, useContext, useEffect, useState } from 'react';

const SettingsContext = createContext(null);

export const useSettings = () => useContext(SettingsContext);

export const SettingsProvider = ({ children }) => {
    const [settings, setSettings] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        // Settings are provided by HandleInertiaRequests middleware for all Inertia pages.
        // The admin panel still uses CSR, so we check for Inertia shared data here.
        try {
            const inertiaData = window.__inertia_data?.props?.settings;
            if (inertiaData) {
                setSettings({ settings: inertiaData });
                setLoading(false);
                return;
            }
        } catch (e) {
            // Not in Inertia context
        }

        // Fallback for admin CSR pages — settings are not critical for admin functionality
        setSettings({});
        setLoading(false);
    }, []);

    return (
        <SettingsContext.Provider value={{ settings, loading }}>
            {children}
        </SettingsContext.Provider>
    );
};
