<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php($m = $meta ?? [])
    <title>{{ $m['title'] ?? 'Tanzania Sensational — Kilimanjaro & Meru Trekking' }}</title>
    <meta name="description" content="{{ $m['description'] ?? 'Premium Kilimanjaro & Meru trekking expeditions, Tanzania safaris, and Zanzibar beach extensions. Expert-led adventures since 2010.' }}">
    <meta property="og:title" content="{{ $m['og_title'] ?? ($m['title'] ?? 'Tanzania Sensational — Kilimanjaro & Meru Trekking') }}">
    <meta property="og:description" content="{{ $m['og_description'] ?? ($m['description'] ?? 'Premium Kilimanjaro & Meru trekking expeditions, Tanzania safaris, and Zanzibar beach extensions.') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $m['canonical'] ?? config('app.url') }}">
    @if(!empty($m['og_image']))
        <meta property="og:image" content="{{ $m['og_image'] }}">
    @endif
    <link rel="canonical" href="{{ $m['canonical'] ?? config('app.url') }}">
    <link rel="icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600&family=Playfair+Display:ital,wght@0,700;0,900;1,400&display=swap" rel="stylesheet">
    @viteReactRefresh
    @vite(['resources/js/main.jsx'])

    @if(!empty($orgSchema))
        <script type="application/ld+json">{!! json_encode($orgSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endif
    @if(!empty($m['schema']))
        <script type="application/ld+json">{!! json_encode($m['schema'], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
    @endif
    @if(isset($initialVisuals))
        <script>window.__INITIAL_VISUALS__ = {!! json_encode($initialVisuals, JSON_UNESCAPED_SLASHES) !!};</script>
    @endif

    <!-- GTranslate Integration -->
    <script>window.gtranslateSettings = {"default_language":"en","languages":["en","fr","it","es","de","zh-CN"],"wrapper_selector":".gtranslate_wrapper"}</script>
    <script src="https://cdn.gtranslate.net/widgets/latest/flags.js" defer></script>
</head>
<body>
    <div id="root"></div>
</body>
</html>
