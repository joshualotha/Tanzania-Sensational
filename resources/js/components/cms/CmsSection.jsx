import React from 'react';
import DOMPurify from 'dompurify';

export function CmsSection({ html }) {
    if (!html) return null;
    const safe = DOMPurify.sanitize(html, { USE_PROFILES: { html: true } });
    return (
        <div className="cms-section" dangerouslySetInnerHTML={{ __html: safe }} />
    );
}

