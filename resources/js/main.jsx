import React from 'react';
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import { SettingsProvider } from './context/SettingsContext';
import { VisualsProvider } from './context/VisualsContext';
import PublicLayout from './components/layout/PublicLayout';
import './styles/index.css';

// Global Shim for production compatibility with specific libraries
if (typeof window !== 'undefined') {
    window.React = React;
}

createInertiaApp({
    resolve: (name) => {
        // Map Inertia page names to their components
        const pages = import.meta.glob('./pages/**/*.jsx', { eager: true });
        const page = pages[`./pages/${name}.jsx`];
        if (!page) {
            throw new Error(`Page not found: ${name}`);
        }
        return page;
    },
    setup({ el, App, props }) {
        const root = createRoot(el);
        
        // Wrap non-admin pages with PublicLayout (Navbar + Footer)
        // Admin pages (admin/*) have their own layout in AdminApp.jsx
        const isAdmin = props.initialPage?.component?.startsWith('admin/');
        
        root.render(
            <SettingsProvider>
            <VisualsProvider>
                {isAdmin ? (
                    <App {...props} />
                ) : (
                    <PublicLayout>
                        <App {...props} />
                    </PublicLayout>
                )}
            </VisualsProvider>
            </SettingsProvider>
        );
    },
    progress: {
        color: '#C9A84C',
        showSpinner: false,
    },
});
