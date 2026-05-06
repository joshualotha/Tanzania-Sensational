import React from 'react';
import { Hero } from '../components/sections/Hero';
import { StatsStrip } from '../components/sections/StatsStrip';
import { RoutesSection } from '../components/sections/Routes';
import { Experience } from '../components/sections/Experience';
import { Departures } from '../components/sections/Departures';
import { Testimonials } from '../components/sections/Testimonials';
import { Extensions } from '../components/sections/Extensions';
import { CTA } from '../components/sections/CTA';
import { CmsSection } from '../components/cms/CmsSection';

const HomePage = ({ cms }) => {
    return (
        <main>
            {cms?.content ? <CmsSection html={cms.content} /> : null}
            <Hero />
            <StatsStrip />
            <RoutesSection />
            <Extensions />
            <Experience />
            <Departures />
            <Testimonials />
            <CTA />
        </main>
    );
};

export default HomePage;
