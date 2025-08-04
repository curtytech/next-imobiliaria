<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Next Imobiliária' }}</title>
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
