<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use App\Models\VisualAsset;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     */
    public function share(Request $request): array
    {
        $appUrl = rtrim((string)config('app.url', url('/')), '/');

        $orgSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => config('app.name'),
            'url' => $appUrl,
            'logo' => $appUrl . '/logo.png',
            'description' => 'Premium Kilimanjaro & Meru trekking expeditions, Tanzania safaris, and Zanzibar beach extensions. Expert-led adventures since 2010.',
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

        // Build default breadcrumbs based on the current URL path
        $path = $request->getPathInfo();
        $defaultBreadcrumbs = $this->buildDefaultBreadcrumbs($path, $appUrl);

        return [
            ...parent::share($request),
            'settings' => fn () => SiteSetting::all()
                ->groupBy('group')
                ->map(function ($items) {
                    return $items->mapWithKeys(function ($s) {
                        // value is stored as ['value' => '...'] – unwrap it for the frontend
                        $raw = $s->value;
                        $unwrapped = is_array($raw) && array_key_exists('value', $raw) ? $raw['value'] : $raw;
                        return [$s->key => $unwrapped];
                    });
                }),
            'visuals' => fn () => VisualAsset::all(['section', 'url'])
                ->groupBy('section')
                ->map(fn ($items) => $items->pluck('url')),
            'orgSchema' => $orgSchema,
            'meta' => [
                'title' => 'Tanzania Sensational — Kilimanjaro & Meru Trekking',
                'description' => 'Premium Kilimanjaro & Meru trekking expeditions, Tanzania safaris, and Zanzibar beach extensions. Expert-led adventures since 2010.',
                'og_title' => 'Tanzania Sensational — Kilimanjaro & Meru Trekking',
                'og_description' => 'Premium Kilimanjaro & Meru trekking expeditions, Tanzania safaris, and Zanzibar beach extensions.',
                'og_image' => null,
                'canonical' => $appUrl . ($path === '/' ? '' : $path),
                'schema' => $defaultBreadcrumbs,
            ],
        ];
    }

    /**
     * Build default BreadcrumbList schema based on the current URL path.
     * Used as a fallback for pages that don't override meta (e.g. closure-based routes).
     */
    private function buildDefaultBreadcrumbs(string $path, string $appUrl): ?array
    {
        // Map URL paths to breadcrumb labels
        $pageLabels = [
            '/' => null, // Homepage — no breadcrumbs needed
            '/about' => 'About',
            '/contact' => 'Contact',
            '/safaris' => 'Safaris',
            '/safaris/tanzania' => 'Tanzania Safaris',
            '/safaris/kenya' => 'Kenya Safaris',
            '/safaris/uganda' => 'Uganda Safaris',
            '/safaris/rwanda' => 'Rwanda Safaris',
            '/safaris/packages' => 'Safari Packages',
            '/safaris/family' => 'Family Safaris',
            '/safaris/honeymoon' => 'Honeymoon Safaris',
            '/safaris/luxury' => 'Luxury Safaris',
            '/safaris/photographic' => 'Photographic Safaris',
            '/safaris/group-joining' => 'Group Joining Safaris',
            '/blog' => 'Blog',
            '/zanzibar' => 'Zanzibar',
            '/group-departures' => 'Group Departures',
            '/gear-checklist' => 'Gear Checklist',
            '/training-guide' => 'Training Guide',
            '/faq' => 'FAQ',
            '/safari-addons' => 'Safari Add-ons',
            '/booking' => 'Book Your Trip',
            '/trekking/health/vaccinations' => 'Vaccinations',
            '/trekking/health/altitude-sickness' => 'Altitude Sickness',
            '/trekking/health/diamox' => 'Diamox',
            '/trekking/health/oxygen' => 'Oxygen',
            '/trekking/prep/best-routes' => 'Best Routes',
            '/trekking/prep/best-time' => 'Best Time to Climb',
            '/trekking/prep/why-us' => 'Why Choose Us',
            '/trekking/prep/tipping-guide' => 'Tipping Guide',
            '/trekking/prep/toilets' => 'Toilets on Kilimanjaro',
            '/trekking/prep/park-fees' => 'Park Fees',
            '/trekking/after/training' => 'Training',
            '/trekking/after/gear-list' => 'Gear List',
            '/trekking/after/getting-there' => 'Getting There',
            '/trekking/after/visa' => 'Visa Information',
            '/trekking/during/daily-routine' => 'Daily Routine',
            '/trekking/during/food-and-drinks' => 'Food & Drinks',
            '/trekking/during/pack-your-daypack' => 'Pack Your Daypack',
            '/trekking/during/connectivity' => 'Connectivity',
            '/safari-guide/what-to-wear' => 'What to Wear on Safari',
            '/safari-guide/packing-guide' => 'Safari Packing Guide',
            '/safari-guide/packing-list' => 'Safari Packing List',
            '/safari-guide/health-and-safety' => 'Health & Safety',
            '/safari-guide/local-customs' => 'Local Customs',
            '/safari-guide/local-custom' => 'Local Customs',
        ];

        // Homepage — no breadcrumbs
        if ($path === '/' || !isset($pageLabels[$path])) {
            return null;
        }

        $label = $pageLabels[$path];

        // For pages under /trekking/ or /safari-guide/, add parent breadcrumb
        $crumbs = [['label' => 'Home', 'url' => '/']];

        if (str_starts_with($path, '/trekking/')) {
            $crumbs[] = ['label' => 'Trekking', 'url' => '/trekking/kilimanjaro/lemosho'];
        } elseif (str_starts_with($path, '/safari-guide/')) {
            $crumbs[] = ['label' => 'Safari Guide', 'url' => '/safari-guide/what-to-wear'];
        } elseif (str_starts_with($path, '/safaris/') && $path !== '/safaris') {
            $crumbs[] = ['label' => 'Safaris', 'url' => '/safaris'];
        }

        $crumbs[] = ['label' => $label, 'url' => $path];

        return [
            [
                '@context' => 'https://schema.org',
                '@type' => 'BreadcrumbList',
                'itemListElement' => array_map(function ($i, $crumb) {
                    return [
                        '@type' => 'ListItem',
                        'position' => $i + 1,
                        'name' => $crumb['label'],
                        'item' => url($crumb['url']),
                    ];
                }, array_keys($crumbs), $crumbs),
            ],
        ];
    }
}
