<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DevTrack') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface-container-lowest text-on-surface min-h-screen flex overflow-hidden antialiased">
    {{-- Left Side: Brand Visual --}}
    <div class="hidden lg:flex lg:w-1/2 relative bg-surface-dim items-center justify-center overflow-hidden border-r border-outline-variant/10">
        {{-- Mesh gradient background --}}
        <div class="absolute inset-0 mesh-bg"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/80 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-transparent to-surface-container-lowest/90"></div>

        <div class="relative z-10 p-12 max-w-lg mt-auto mb-12 mr-auto ml-12">
            {{-- Logo --}}
            <div class="flex items-center gap-3 mb-12">
                <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-inverse-primary to-secondary-container flex items-center justify-center shadow-lg">
                    <span class="material-symbols-outlined text-white">terminal</span>
                </div>
                <span class="text-h2 font-bold tracking-tight text-dt-primary">DevTrack</span>
            </div>
            {{-- Tagline --}}
            <h1 class="text-display text-on-surface mb-6">Engineering the future.</h1>
            <p class="text-body-lg text-on-surface-variant">
                The premier platform for high-performance developer workflows. Streamline your processes, collaborate with precision, and ship faster.
            </p>
            {{-- Quote panel --}}
            <div class="mt-12 pt-6 border-t border-outline-variant/30 glass-panel p-6 rounded-xl">
                <p class="text-h3 text-on-surface mb-2">"Engineering the future requires tools that get out of the way."</p>
                <p class="text-body-md text-on-surface-variant flex items-center gap-1">
                    <span class="material-symbols-outlined text-dt-primary text-[18px]">bolt</span>
                    High-performance workflow
                </p>
            </div>
        </div>
    </div>

    {{-- Right Side: Form Content --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative z-10 bg-[#0B0E14]">
        {{-- Subtle glow --}}
        <div class="absolute top-1/4 right-1/4 w-64 h-64 bg-dt-primary/10 rounded-full blur-[100px] pointer-events-none"></div>

        <div class="w-full max-w-[420px] relative z-10">
            {{-- Mobile Logo --}}
            <div class="flex items-center gap-3 mb-10 lg:hidden justify-center">
                <div class="w-8 h-8 rounded bg-primary-container flex items-center justify-center">
                    <span class="material-symbols-outlined text-on-primary-container">terminal</span>
                </div>
                <span class="text-h2 font-bold tracking-tight text-dt-primary">DevTrack</span>
            </div>

            {{ $slot }}
        </div>
    </div>
</body>
</html>
