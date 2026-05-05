import React, { createContext, useContext, useEffect, useState } from 'react';
import { settingsService } from '../services/api';

const SettingsContext = createContext(null);

export const useSettings = () => useContext(SettingsContext);

export const SettingsProvider = ({ children }) => {
    const [settings, setSettings] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        let mounted = true;
        settingsService.getPublic()
            .then((res) => {
                if (!mounted) return;
                setSettings(res.data?.settings || {});
            })
            .catch(() => {
                // Silently fail – the app works with fallback hardcoded values
                if (!mounted) return;
                setSettings({});
            })
            .finally(() => {
                if (mounted) setLoading(false);
            });
        return () => { mounted = false; };
    }, []);

    return (
        <SettingsContext.Provider value={{ settings, loading }}>
            {children}
        </SettingsContext.Provider>
    );
};
