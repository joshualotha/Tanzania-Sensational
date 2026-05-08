<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title inertia>{{ $meta['title'] ?? 'Tanzania Sensational — Kilimanjaro & Meru Trekking' }}</title>
    <meta name="description" content="{{ $meta['description'] ?? 'Premium Kilimanjaro & Meru trekking expeditions, Tanzania safaris, and Zanzibar beach extensions. Expert-led adventures since 2010.' }}">
    <meta property="og:title" content="{{ $meta['og_title'] ?? ($meta['title'] ?? 'Tanzania Sensational — Kilimanjaro & Meru Trekking') }}">
    <meta property="og:description" content="{{ $meta['og_description'] ?? ($meta['description'] ?? 'Premium Kilimanjaro & Meru trekking expeditions, Tanzania safaris, and Zanzibar beach extensions.') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $meta['canonical'] ?? config('app.url') }}">
    @if(!empty($meta['og_image']))
        <meta property="og:image" content="{{ $meta['og_image'] }}">
    @endif
    <link rel="canonical" href="{{ $meta['canonical'] ?? config('app.url') }}">
    <link rel="alternate" hreflang="en" href="{{ $meta['canonical'] ?? config('app.url') }}">
    <link rel="alternate" hreflang="x-default" href="{{ $meta['canonical'] ?? config('app.url') }}">
    <link rel="icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
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
