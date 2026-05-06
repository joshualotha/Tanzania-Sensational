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

        return [
            ...parent::share($request),
            'settings' => fn () => SiteSetting::all()->pluck('value', 'key'),
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
                'canonical' => $appUrl . ($request->getPathInfo() === '/' ? '' : $request->getPathInfo()),
                'schema' => null,
            ],
        ];
    }
}
