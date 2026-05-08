<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DevTrack') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'dt-bg': '#0B0E14',
                        'outline': '#908fa0',
                        'on-secondary-container': '#e6ecff',
                        'primary-fixed-dim': '#c0c1ff',
                        'on-primary-fixed': '#07006c',
                        'surface-container-highest': '#31353e',
                        'on-secondary': '#002e6a',
                        'secondary-container': '#0566d9',
                        'on-tertiary-fixed-variant': '#6900b3',
                        'surface-dim': '#0f131b',
                        'primary-fixed': '#e1e0ff',
                        'surface-container-high': '#262a32',
                        'dt-error': '#ffb4ab',
                        'surface-variant': '#31353e',
                        'surface': '#0f131b',
                        'on-error-container': '#ffdad6',
                        'dt-primary': '#c0c1ff',
                        'tertiary-fixed-dim': '#ddb7ff',
                        'dt-secondary': '#adc6ff',
                        'primary-container': '#8083ff',
                        'on-error': '#690005',
                        'outline-variant': '#464554',
                        'surface-tint': '#c0c1ff',
                        'secondary-fixed': '#d8e2ff',
                        'secondary-fixed-dim': '#adc6ff',
                        'on-primary-container': '#0d0096',
                        'inverse-surface': '#dfe2ee',
                        'dt-tertiary': '#ddb7ff',
                        'on-tertiary-container': '#400071',
                        'on-surface-variant': '#c7c4d7',
                        'surface-container': '#1c2028',
                        'on-tertiary-fixed': '#2c0051',
                        'on-surface': '#dfe2ee',
                        'tertiary-container': '#b76dff',
                        'inverse-primary': '#494bd6',
                        'on-secondary-fixed': '#001a42',
                        'on-primary': '#1000a9',
                        'on-background': '#dfe2ee',
                        'on-tertiary': '#490080',
                        'background': '#0f131b',
                        'surface-bright': '#353942',
                        'on-secondary-fixed-variant': '#004395',
                        'error-container': '#93000a',
                        'surface-container-lowest': '#0a0e16',
                        'inverse-on-surface': '#2c3039',
                        'tertiary-fixed': '#f0dbff',
                        'surface-container-low': '#181c24',
                        'on-primary-fixed-variant': '#2f2ebe',
                    },
                    fontFamily: {
                        sans: ['Geist', 'sans-serif'],
                        mono: ['JetBrains Mono', 'monospace'],
                    },
                    fontSize: {
                        'display': ['48px', { lineHeight: '1.1', letterSpacing: '-0.02em', fontWeight: '700' }],
                        'h1': ['32px', { lineHeight: '1.2', letterSpacing: '-0.02em', fontWeight: '600' }],
                        'h2': ['24px', { lineHeight: '1.3', letterSpacing: '-0.01em', fontWeight: '600' }],
                        'h3': ['18px', { lineHeight: '1.4', letterSpacing: '0', fontWeight: '600' }],
                        'body-lg': ['16px', { lineHeight: '1.6', letterSpacing: '0', fontWeight: '400' }],
                        'body-md': ['14px', { lineHeight: '1.5', letterSpacing: '0', fontWeight: '400' }],
                        'label-sm': ['12px', { lineHeight: '1', letterSpacing: '0.02em', fontWeight: '500' }],
                        'code': ['13px', { lineHeight: '1.5', letterSpacing: '0', fontWeight: '400' }],
                    },
                    borderRadius: {
                        'DEFAULT': '0.25rem',
                        'lg': '0.5rem',
                        'xl': '0.75rem',
                        'full': '9999px',
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        @layer base {
            html { font-family: 'Geist', sans-serif; }
        }

        @layer components {
            .glass-card {
                background: rgba(30, 35, 45, 0.6);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }
            .glass-panel {
                background: rgba(30, 35, 45, 0.8);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(255, 255, 255, 0.08);
            }
            .btn-primary-gradient {
                background: linear-gradient(135deg, #494bd6, #0566d9);
                border: 1px solid rgba(255, 255, 255, 0.1);
            }
            .btn-primary-gradient:hover {
                opacity: 0.9;
            }
            .devtrack-input {
                background-color: #0B0E14;
                border: 1px solid rgba(255, 255, 255, 0.08);
                transition: all 0.2s ease;
            }
            .devtrack-input:focus {
                border-color: #c0c1ff;
                box-shadow: 0 0 0 1px #c0c1ff;
                outline: none;
            }
            .mesh-bg {
                background-image: radial-gradient(at 40% 20%, hsla(240,60%,15%,1) 0px, transparent 50%),
                                  radial-gradient(at 80% 0%, hsla(220,60%,15%,1) 0px, transparent 50%),
                                  radial-gradient(at 0% 50%, hsla(260,60%,10%,1) 0px, transparent 50%);
            }
            .sidebar-link {
                @apply text-on-surface-variant px-4 py-2 flex items-center gap-3 rounded-lg transition-all duration-150;
            }
            .sidebar-link:hover {
                @apply bg-surface-container-highest/40 text-on-surface;
            }
            .sidebar-link:active {
                @apply translate-x-1;
            }
            .sidebar-link-active {
                @apply bg-secondary-container/20 text-dt-primary border-r-2 border-dt-primary;
            }
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #31353e; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #464554; }

        /* Material Symbols */
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
