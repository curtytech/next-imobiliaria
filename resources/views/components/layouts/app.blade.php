<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Mc Boutique' }}</title>

    <!-- Favicons -->
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="theme-color" content="#ffffff">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ?? 'Mc Boutique Imobiliária' }}">
    <meta property="og:description" content="Encontre o imóvel dos seus sonhos com a Mc Boutique Imobiliária">
    <meta property="og:image" content="{{ asset('img/logo_mcboutique.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:title" content="{{ $title ?? 'Mc Boutique Imobiliária' }}">
    <meta property="twitter:description" content="Encontre o imóvel dos seus sonhos com a Mc Boutique Imobiliária">
    <meta property="twitter:image" content="{{ asset('img/logo_mcboutique.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#B91C1C">
    <meta name="theme-color" content="#B91C1C">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    <x-navbar />

    {{ $slot }}

    <x-footer />

    <!-- Botão flutuante do WhatsApp -->
    <x-whatsapp-float />
</body>

</html>