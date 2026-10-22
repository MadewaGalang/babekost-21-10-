@props(['title' => 'Babekost'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-ink font-sans text-ink antialiased">
    <div class="relative mx-auto min-h-dvh w-full max-w-[430px] bg-canvas pb-20 sm:min-h-[932px]">
        {{ $slot }}
        {{ $nav ?? '' }}
    </div>
</body>
</html>