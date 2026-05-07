import React, { createContext, useContext, useMemo } from 'react';
import { usePage } from '@inertiajs/react';

const SettingsContext = createContext(null);

export const useSettings = () => useContext(SettingsContext);

export const SettingsProvider = ({ children }) => {
    // Read settings from Inertia's shared props.
    // This provider must be rendered INSIDE the Inertia <App> component
    // so that usePage() is available.
    const page = usePage();
    const { props } = page;
    const inertiaSettings = props?.settings ?? null;

    // inertiaSettings is already the grouped settings object from HandleInertiaRequests.php
    // e.g. { contact: { phone: "...", ... }, social: {...}, general: {...}, branding: {...} }
    // Provide it directly — do NOT double-wrap in { settings: inertiaSettings }
    // because consumers do: const { settings } = useSettings(); settings?.contact?.phone
    const settings = useMemo(() => {
        return inertiaSettings ?? {};
    }, [inertiaSettings]);

    return (
        <SettingsContext.Provider value={{ settings, loading: false }}>
            {children}
        </SettingsContext.Provider>
    );
};
