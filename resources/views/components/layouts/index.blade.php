<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>GIS</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet" />
    <!-- Styles / Scripts -->
    {{-- @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot'))) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @endif --}}
</head>

<body class="font-[raleway] antialiased">
    {{ $slot }}
</body>

</html>
