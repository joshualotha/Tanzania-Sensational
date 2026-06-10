<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Inertia\Inertia;

class MainPageController extends Controller
{
    /**
     * Build page-specific meta array from a CMS Page model.
     */
    private function buildPageMeta(Page $page): array
    {
        $appUrl = rtrim((string)config('app.url', url('/')), '/');

        // Determine the path based on the page slug
        $pathMap = [
            'home' => '/',
            'about' => '/about',
            'contact' => '/contact',
        ];

        $path = $pathMap[$page->slug] ?? '/' . $page->slug;

        // Build breadcrumbs (homepage has only one crumb)
        $crumbs = [['label' => 'Home', 'url' => '/']];
        if ($page->slug !== 'home') {
            $label = match ($page->slug) {
                'about' => 'About',
                'contact' => 'Contact',
                default => $page->title,
            };
            $crumbs[] = ['label' => $label, 'url' => $path];
        }
        $breadcrumbs = $this->buildBreadcrumbs($crumbs);

        // Resolve hero image for <link rel="preload"> (LCP optimization)
        $heroFallbacks = [
            'home' => 'https://images.unsplash.com/photo-1516422213484-2af298bf06ad?auto=format&fit=crop&q=80&w=1600',
            'about' => 'https://images.unsplash.com/photo-1585409677983-0f6c41ca9c3b?auto=format&fit=crop&q=80&w=1600',
            'contact' => 'https://images.unsplash.com/photo-1516422213484-2af298bf06ad?auto=format&fit=crop&q=80&w=1600',
        ];
        $heroImage = $this->heroImageFromVisuals(
            $page->slug . '.hero',
            $heroFallbacks[$page->slug] ?? ''
        );

        return [
            'title' => $page->meta_title ?? $page->title . ' | Tanzania Sensational',
            'description' => $page->meta_description ?? 'Explore ' . $page->title . ' with Tanzania Sensational.',
            'og_title' => $page->meta_title ?? $page->title . ' | Tanzania Sensational',
            'og_description' => $page->meta_description ?? 'Explore ' . $page->title . ' with Tanzania Sensational.',
            'og_image' => null,
            'canonical' => $appUrl . ($path === '/' ? '' : $path),
            'schema' => [$breadcrumbs],
            'hero_image' => $heroImage,
        ];
    }

    /**
     * Display the homepage.
     */
    public function home()
    {
        $page = Page::where('slug', 'home')->first();

        return Inertia::render('HomePage', [
            'cms' => $page,
            'meta' => $page ? $this->buildPageMeta($page) : null,
        ]);
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        $page = Page::where('slug', 'about')->first();

        return Inertia::render('AboutPage', [
            'cms' => $page,
            'meta' => $page ? $this->buildPageMeta($page) : null,
        ]);
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        $page = Page::where('slug', 'contact')->first();

        return Inertia::render('ContactPage', [
            'cms' => $page,
            'meta' => $page ? $this->buildPageMeta($page) : null,
        ]);
    }

    /**
     * Display the 404 fallback page.
     * Must be a controller method (not a closure) so route:cache can serialize it.
     */
    public function notFound()
    {
        $appUrl = rtrim((string)config('app.url', url('/')), '/');

        $meta = [
            'title' => 'Page Not Found — Tanzania Sensational',
            'description' => 'The page you are looking for does not exist. Explore our Tanzania safaris, Kilimanjaro trekking, and Zanzibar beach extensions.',
            'og_title' => 'Page Not Found — Tanzania Sensational',
            'og_description' => 'The page you are looking for does not exist.',
            'og_image' => null,
            'canonical' => $appUrl,
            'schema' => null,
        ];

        $orgSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => $appUrl,
            'logo' => $appUrl . '/logo.png',
            'description' => 'Premium Tanzania safaris, Kilimanjaro & Meru trekking expeditions, and Zanzibar beach extensions. Expert-led adventures since 2010.',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Moshi',
                'addressRegion' => 'Kilimanjaro',
                'addressCountry' => 'TZ',
            ],
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'availableLanguage' => ['English', 'Swahili'],
            ],
            'sameAs' => [
                'https://www.instagram.com/tanzaniasensational/',
                'https://www.facebook.com/tanzaniasensational/',
                'https://www.tripadvisor.com/Attraction_Review-g297913-d1234567-Reviews-Tanzania_Sensational-Moshi_Kilimanjaro_Region.html',
            ],
        ];

        return Inertia::render('NotFound', [
            'meta' => $meta,
            'orgSchema' => $orgSchema,
        ])->toResponse(request())->setStatusCode(404);
    }
}
