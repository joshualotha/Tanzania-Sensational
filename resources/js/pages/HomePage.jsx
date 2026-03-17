import React, { useEffect, useState } from 'react';
import { Hero } from '../components/sections/Hero';
import { StatsStrip } from '../components/sections/StatsStrip';
import { Routes } from '../components/sections/Routes';
import { Experience } from '../components/sections/Experience';
import { Departures } from '../components/sections/Departures';
import { Testimonials } from '../components/sections/Testimonials';
import { Extensions } from '../components/sections/Extensions';
import { CTA } from '../components/sections/CTA';
import { pageService } from '../services/api';
import { CmsSection } from '../components/cms/CmsSection';

export const HomePage = () => {
    const [cms, setCms] = useState(null);

    useEffect(() => {
        let mounted = true;
        pageService.getBySlug('home')
            .then((res) => { if (mounted) setCms(res.data); })
            .catch(() => {});
        return () => { mounted = false; };
    }, []);

    return (
        <main>
            {cms?.content ? <CmsSection html={cms.content} /> : null}
            <Hero />
            <StatsStrip />
            <Routes />
            <Extensions />
            <Experience />
            <Departures />
            <Testimonials />
            <CTA />
        </main>
    );
};
