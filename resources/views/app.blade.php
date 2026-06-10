<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title inertia>{{ $meta['title'] ?? 'Tanzania Safari & Kilimanjaro Trekking | Tanzania Sensational' }}</title>
    <meta name="description" content="{{ $meta['description'] ?? 'Premium Tanzania safari tours, Kilimanjaro trekking expeditions, and Zanzibar beach holidays. Expert-led adventures since 2009. Book your once-in-a-lifetime experience.' }}">
    <meta property="og:title" content="{{ $meta['og_title'] ?? ($meta['title'] ?? 'Tanzania Safari & Kilimanjaro Trekking | Tanzania Sensational') }}">
    <meta property="og:description" content="{{ $meta['og_description'] ?? ($meta['description'] ?? 'Premium Tanzania safari tours, Kilimanjaro trekking expeditions, and Zanzibar beach holidays.') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $meta['canonical'] ?? config('app.url') }}">
    @if(!empty($meta['og_image']))
        <meta property="og:image" content="{{ $meta['og_image'] }}">
    @endif
    <link rel="canonical" href="{{ $meta['canonical'] ?? config('app.url') }}">
    <link rel="alternate" hreflang="en" href="{{ $meta['canonical'] ?? config('app.url') }}">
    <link rel="alternate" hreflang="x-default" href="{{ $meta['canonical'] ?? config('app.url') }}">
    {{-- Preload hero LCP image for eligible pages (resolved server-side from VisualAsset DB) --}}
    @php $heroImage = $heroImage ?? ($meta['hero_image'] ?? null); @endphp
    @if(!empty($heroImage))
    <link rel="preload" as="image" href="{{ $heroImage }}" fetchpriority="high">
    @endif
    <link rel="icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- Preload critical font: Playfair Display (headings above the fold) --}}
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,400&family=Outfit:wght@300;400;500;600&family=DM+Sans:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&display=swap" />
    {{-- Load fonts asynchronously with fallback --}}
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,400&family=Outfit:wght@300;400;500;600&family=DM+Sans:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&display=swap" rel="stylesheet" media="print" onload="this.media='all'" />
    {{-- Fallback for browsers without JS/onload support --}}
    <noscript><link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,400&family=Outfit:wght@300;400;500;600&family=DM+Sans:wght@400;500;600;700&family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&display=swap" rel="stylesheet" /></noscript>
    @viteReactRefresh
    @vite(['resources/js/main.jsx'])

    @if(!empty($orgSchema))
        <script type="application/ld+json">{!! json_encode($orgSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endif
    @if(!empty($meta['schema']))
        @if(isset($meta['schema'][0]))
            {{-- Array of schema objects --}}
            @foreach($meta['schema'] as $schemaItem)
        <script type="application/ld+json">{!! json_encode($schemaItem, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
            @endforeach
        @else
            {{-- Single schema object (backward compatibility) --}}
        <script type="application/ld+json">{!! json_encode($meta['schema'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
        @endif
    @endif
    @inertiaHead
</head>
<body>
    @inertia
</body>
</html>
