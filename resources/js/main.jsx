import React from 'react';
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import PublicLayout from './components/layout/PublicLayout';
import './styles/index.css';

// Global Shim for production compatibility with specific libraries
if (typeof window !== 'undefined') {
    window.React = React;
}

const pages = import.meta.glob('./pages/**/*.jsx');

createInertiaApp({
    resolve: (name) => {
        const page = pages[`./pages/${name}.jsx`];
        if (!page) {
            throw new Error(`Page not found: ${name}`);
        }
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

        // Prefetch all public page JS chunks after initial render for instant navigation
        const prefetchPages = () => {
            Object.entries(pages).forEach(([path]) => {
                if (!path.includes('/admin/')) {
                    pages[path]();
                }
            });
        };
        if (typeof requestIdleCallback !== 'undefined') {
            requestIdleCallback(prefetchPages);
        } else {
            setTimeout(prefetchPages, 2000);
        }
    },
    progress: {
        color: '#C9A84C',
        showSpinner: false,
    },
});
