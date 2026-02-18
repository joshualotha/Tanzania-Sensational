import React from 'react';
import { Hero } from '../components/sections/Hero';
import { StatsStrip } from '../components/sections/StatsStrip';
import { Routes } from '../components/sections/Routes';
import { Experience } from '../components/sections/Experience';
import { Departures } from '../components/sections/Departures';
import { Testimonials } from '../components/sections/Testimonials';
import { Extensions } from '../components/sections/Extensions';
import { CTA } from '../components/sections/CTA';

export const HomePage = () => {
    return (
        <main>
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
