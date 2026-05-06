import React from 'react';
import { createInertiaApp } from '@inertiajs/react';
import { createRoot } from 'react-dom/client';
import { renderToString } from 'react-dom/server';
import './styles/index.css';

// Global Shim for production compatibility with specific libraries
if (typeof window !== 'undefined') {
    window.React = React;
}

export function render(page) {
    return createInertiaApp({
        page,
        render: renderToString,
        resolve: (name) => {
            const pages = import.meta.glob('./pages/**/*.jsx', { eager: true });
            const page = pages[`./pages/${name}.jsx`];
            if (!page) {
                throw new Error(`Page not found: ${name}`);
            }
            return page;
        },
        setup({ App, props }) {
            return <App {...props} />;
        },
    });
}
