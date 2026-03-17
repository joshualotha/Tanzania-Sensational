<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tanzania Sensational | Luxury Expeditions</title>

    <!-- SEO & Metadata -->
    <meta name="description" content="Discover the ultimate African wilderness with Tanzania Sensational. Bespoke safaris, Kilimanjaro treks, and Zanzibar retreats.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Inter:wght@300;400;500;600&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @viteReactRefresh
    @vite(['resources/js/main.jsx'])
</head>
<body class="antialiased">
    <div id="root"></div>
</body>
</html>
