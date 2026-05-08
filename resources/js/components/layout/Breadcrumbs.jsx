import React from 'react';
import { Link, usePage } from '@inertiajs/react';
import { ChevronRight, Home } from 'lucide-react';

/**
 * Visible breadcrumb navigation component.
 * Renders breadcrumbs based on the current URL path.
 * Works alongside the BreadcrumbList JSON-LD schema already implemented server-side.
 */
export const Breadcrumbs = () => {
    const { url } = usePage();
    const path = url.split('?')[0]; // Strip query params

    // Don't show breadcrumbs on homepage
    if (path === '/') return null;

    // Define breadcrumb labels for known paths
    const pageLabels = {
        '/about': 'About',
        '/contact': 'Contact',
        '/safaris': 'Safaris',
        '/safaris/guide': 'Safari Guide',
        '/safaris/tanzania': 'Tanzania Safaris',
        '/safaris/kenya': 'Kenya Safaris',
        '/safaris/uganda': 'Uganda Safaris',
        '/safaris/rwanda': 'Rwanda Safaris',
        '/safaris/packages': 'Safari Packages',
        '/safaris/family': 'Family Safaris',
        '/safaris/honeymoon': 'Honeymoon Safaris',
        '/safaris/luxury': 'Luxury Safaris',
        '/safaris/photographic': 'Photographic Safaris',
        '/safaris/group-joining': 'Group Joining Safaris',
        '/blog': 'Blog',
        '/trekking/kilimanjaro': 'Kilimanjaro Trekking',
        '/zanzibar': 'Zanzibar',
        '/group-departures': 'Group Departures',
        '/gear-checklist': 'Gear Checklist',
        '/training-guide': 'Training Guide',
        '/faq': 'FAQ',
        '/safari-addons': 'Safari Add-ons',
        '/booking': 'Book Your Trip',
        '/trekking/health/vaccinations': 'Vaccinations',
        '/trekking/health/altitude-sickness': 'Altitude Sickness',
        '/trekking/health/diamox': 'Diamox',
        '/trekking/health/oxygen': 'Oxygen',
        '/trekking/prep/best-routes': 'Best Routes',
        '/trekking/prep/best-time': 'Best Time to Climb',
        '/trekking/prep/why-us': 'Why Choose Us',
        '/trekking/prep/tipping-guide': 'Tipping Guide',
        '/trekking/prep/toilets': 'Toilets on Kilimanjaro',
        '/trekking/prep/park-fees': 'Park Fees',
        '/trekking/prep/choose-operator': 'How to Choose a Tour Operator',
        '/trekking/prep/cost-breakdown': 'Kilimanjaro Cost Breakdown',
        '/trekking/after/training': 'Training',
        '/trekking/after/gear-list': 'Gear List',
        '/trekking/after/getting-there': 'Getting There',
        '/trekking/after/visa': 'Visa Information',
        '/trekking/during/daily-routine': 'Daily Routine',
        '/trekking/during/food-and-drinks': 'Food & Drinks',
        '/trekking/during/pack-your-daypack': 'Pack Your Daypack',
        '/trekking/during/connectivity': 'Connectivity',
        '/safari-guide/what-to-wear': 'What to Wear on Safari',
        '/safari-guide/packing-guide': 'Safari Packing Guide',
        '/safari-guide/packing-list': 'Safari Packing List',
        '/safari-guide/health-and-safety': 'Health & Safety',
        '/safari-guide/local-customs': 'Local Customs',
        '/safari-guide/local-custom': 'Local Customs',
        '/safari-guide/accommodation-style': 'Accommodation Style',
        '/safari-guide/visa-guide': 'Visa Guide',
    };

    // Build breadcrumb trail from URL segments
    const segments = path.split('/').filter(Boolean);
    const crumbs = [];

    // Always start with Home
    crumbs.push({ label: 'Home', href: '/' });

    // Build parent breadcrumbs for nested paths
    let accumulatedPath = '';
    for (let i = 0; i < segments.length; i++) {
        accumulatedPath += '/' + segments[i];

        // Check if we have a label for this exact path
        if (pageLabels[accumulatedPath]) {
            crumbs.push({ label: pageLabels[accumulatedPath], href: accumulatedPath });
        } else {
            // For dynamic paths (trekking routes, blog posts, etc.), 
            // try to find a parent label or use a formatted segment
            const parentPath = '/' + segments.slice(0, i).join('/');
            
            // For trekking routes: /trekking/kilimanjaro/{slug}
            if (segments[0] === 'trekking' && segments[1] === 'kilimanjaro' && i === 2) {
                // Don't add the route name here — it's handled by the parent
                // Just add a generic "Route" label or skip
                crumbs.push({ label: segments[2].replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()), href: accumulatedPath });
            }
            // For blog posts: /blog/{slug}
            else if (segments[0] === 'blog' && i === 1 && segments.length > 1) {
                // Skip — the blog post title is dynamic and handled by the page component
                // Just show "Blog" as the current page
            }
            // For safari packages: /safaris/packages/{slug}
            else if (segments[0] === 'safaris' && segments[1] === 'packages' && i === 2) {
                crumbs.push({ label: segments[2].replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()), href: accumulatedPath });
            }
            // For safari destinations: /safaris/destinations/{slug}
            else if (segments[0] === 'safaris' && segments[1] === 'destinations' && i === 2) {
                crumbs.push({ label: segments[2].replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()), href: accumulatedPath });
            }
            // For company pages: /company/{page}
            else if (segments[0] === 'company' && i === 1) {
                crumbs.push({ label: segments[1].replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()), href: accumulatedPath });
            }
            // For safari guide pages: /safari-guide/{page}
            else if (segments[0] === 'safari-guide' && i === 1) {
                crumbs.push({ label: segments[1].replace(/-/g, ' ').replace(/\b\w/g, c => c.toUpperCase()), href: accumulatedPath });
            }
            // For group departure detail: /group-departures/{id}
            else if (segments[0] === 'group-departures' && i === 1) {
                crumbs.push({ label: 'Departure Detail', href: accumulatedPath });
            }
            // For booking pages: /booking/departure/{id} or /booking/safari/{id}
            else if (segments[0] === 'booking' && i >= 1) {
                if (i === 1) {
                    crumbs.push({ label: 'Booking', href: '/booking' });
                }
            }
        }
    }

    // Deduplicate: if the last two crumbs have the same label, remove the last one
    if (crumbs.length >= 2) {
        const last = crumbs[crumbs.length - 1];
        const secondLast = crumbs[crumbs.length - 2];
        if (last.label === secondLast.label) {
            crumbs.pop();
        }
    }

    // If we only have Home, don't show breadcrumbs (we're on a top-level page)
    if (crumbs.length <= 1) return null;

    return (
        <nav aria-label="Breadcrumb" className="breadcrumbs-nav">
            <ol className="breadcrumbs-list">
                {crumbs.map((crumb, index) => {
                    const isLast = index === crumbs.length - 1;
                    return (
                        <li key={crumb.href} className="breadcrumbs-item">
                            {index > 0 && (
                                <ChevronRight size={14} className="breadcrumbs-separator" aria-hidden="true" />
                            )}
                            {isLast ? (
                                <span className="breadcrumbs-current" aria-current="page">
                                    {crumb.label}
                                </span>
                            ) : (
                                <Link href={crumb.href} className="breadcrumbs-link">
                                    {index === 0 ? <Home size={14} className="breadcrumbs-home-icon" /> : null}
                                    {index === 0 ? <span className="breadcrumbs-home-label">Home</span> : crumb.label}
                                </Link>
                            )}
                        </li>
                    );
                })}
            </ol>
        </nav>
    );
};

export default Breadcrumbs;
