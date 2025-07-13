<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Imobiliária' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">
    {{ $slot }}
    <script>
        if (window.lucide) window.lucide.createIcons();
    </script>
</body>

</html>
