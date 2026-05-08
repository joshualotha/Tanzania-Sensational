import React from 'react';
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import PublicLayout from './components/layout/PublicLayout';
import './styles/index.css';

// Global Shim for production compatibility with specific libraries
if (typeof window !== 'undefined') {
    window.React = React;
}

createInertiaApp({
    resolve: (name) => {
        // Map Inertia page names to their components — lazy loading for code-splitting
        const pages = import.meta.glob('./pages/**/*.jsx');
        const page = pages[`./pages/${name}.jsx`];
        if (!page) {
            throw new Error(`Page not found: ${name}`);
        }
        // Set PublicLayout for non-admin pages so Navbar/Footer render
        // within Inertia's context provider (usePage() must be inside Inertia <App>)
        return page().then((module) => {
            const component = module.default;
            if (!name.startsWith('admin/')) {
                component.layout = PublicLayout;
            }
            return component;
        });
    },
    setup({ el, App, props }) {
        const root = createRoot(el);
        
        root.render(<App {...props} />);
    },
    progress: {
        color: '#C9A84C',
        showSpinner: false,
    },
});
