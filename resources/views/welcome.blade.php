<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>DevTrack - Engineering the future of task management</title>
    <meta name="description" content="A high-performance workflow engine designed for engineering teams. Minimal noise, maximum focus.">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .nav-link { position: relative; }
        .nav-link::after { content: ''; position: absolute; bottom: -4px; left: 0; width: 0; height: 2px; background: #c0c1ff; transition: width 0.3s ease; }
        .nav-link:hover::after { width: 100%; }
    </style>
</head>
<body class="font-sans bg-surface antialiased text-on-surface min-h-screen flex flex-col relative mesh-bg">

{{-- Navbar --}}
<nav class="fixed w-full z-50 glass-panel border-b-0 border-outline-variant/30 top-0">
    <div class="max-w-7xl mx-auto px-6 py-2 flex justify-between items-center w-full">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-inverse-primary to-secondary-container flex items-center justify-center shadow-lg">
                    <span class="material-symbols-outlined text-white text-[18px]">terminal</span>
                </div>
                <span class="text-h2 font-bold tracking-tight text-dt-primary">DevTrack</span>
            </div>
        </div>
        <div class="hidden md:flex gap-6 items-center">
            <a class="text-body-md text-on-surface-variant hover:text-dt-primary transition-colors nav-link" href="#features">Features</a>
            <a class="text-body-md text-on-surface-variant hover:text-dt-primary transition-colors nav-link" href="#pricing">Pricing</a>
            <a class="text-body-md text-on-surface-variant hover:text-dt-primary transition-colors nav-link" href="#docs">Docs</a>
        </div>
        <div class="flex items-center gap-4">
            @auth
                <a href="{{ url('/dashboard') }}" class="text-body-md text-on-surface-variant hover:text-on-surface transition-colors px-4 py-2">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="text-body-md text-on-surface-variant hover:text-on-surface transition-colors px-4 py-2">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-primary-gradient px-4 py-2 text-body-md font-semibold text-white hover:opacity-90 transition-opacity rounded-lg">Get Started</a>
                @endif
            @endauth
        </div>
    </div>
</nav>

{{-- Main Content --}}
<main class="flex-grow pt-32 pb-24 px-5 max-w-7xl mx-auto w-full relative z-10 flex flex-col items-center">

    {{-- Hero Section --}}
    <section class="text-center max-w-4xl mx-auto mb-32 flex flex-col items-center justify-center pt-24">
        <div class="inline-flex items-center gap-2 px-4 py-1 rounded-full border border-dt-primary/30 bg-dt-primary/10 text-dt-primary mb-6 text-label-sm">
            <span class="material-symbols-outlined text-[14px]">rocket_launch</span>
            DevTrack v2.0 is live
        </div>
        <h1 class="text-display text-on-surface mb-6">Engineering the future of <br/><span class="text-transparent bg-clip-text bg-gradient-to-r from-dt-primary to-dt-secondary">task management</span></h1>
        <p class="text-body-lg text-on-surface-variant max-w-2xl mb-12 mx-auto">
            A high-performance workflow engine designed for engineering teams. Minimal noise, maximum focus. Build your next great product with precision.
        </p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="{{ route('register') }}" class="btn-primary-gradient px-12 py-4 text-body-lg flex items-center gap-2 hover:scale-105 transition-transform duration-200 rounded-lg text-white font-semibold shadow-[0_0_30px_rgba(73,75,214,0.3)]">
                Get Started Free
                <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
            </a>
            <a href="{{ route('login') }}" class="bg-transparent border border-outline-variant/30 px-12 py-4 text-body-lg text-on-surface-variant hover:bg-surface-container-high transition-colors flex items-center gap-2 rounded-lg">
                <span class="material-symbols-outlined text-[18px]">play_circle</span>
                Watch Demo
            </a>
        </div>
    </section>

    {{-- Product Preview --}}
    <div class="w-full max-w-5xl mx-auto mb-32 relative rounded-xl border border-outline-variant/30 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.6)] overflow-hidden group">
        <div class="absolute inset-0 bg-gradient-to-t from-background to-transparent z-10 pointer-events-none"></div>
        <img alt="DevTrack Dashboard Interface"
             class="w-full h-auto object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out"
             src="https://lh3.googleusercontent.com/aida-public/AB6AXuCskN2_wNI56HGUcld4SuDobntPvFcIcUlocA2mNQa3-5ltaoPbQDGrCYeT0mCvoXClFgfBvknH9S-jIMnd2ORkxd05wY_nrDJ5veyZkp-igq2oxQhlk4RT8m7_drCbD5h8QQYZgxl3ClzlGgGD4c7WOFlc2XNCv1usqm6_kTPTH3JaiyhWCIhwimg19EuU7rEAo1N5YYsBh1AwIpZTFEYgxJfx56ZYQiggQ8t3AOvRawlyJEgAGB1hwfLdNpu9VUnk0D734QdQnmlu"/>
    </div>

    {{-- Trusted By Section --}}
    <section class="w-full text-center mb-32">
        <p class="text-label-sm text-on-surface-variant uppercase tracking-widest mb-6 opacity-60">Trusted by innovative engineering teams</p>
        <div class="flex flex-wrap justify-center gap-12 items-center opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
            <span class="text-h3 font-bold text-on-surface">AcmeCorp</span>
            <span class="text-h3 font-bold text-on-surface flex items-center gap-1"><span class="material-symbols-outlined">api</span> NovaLabs</span>
            <span class="text-h3 font-bold text-on-surface">Quantum</span>
            <span class="text-h3 font-bold text-on-surface flex items-center gap-1"><span class="material-symbols-outlined">data_object</span> Vertex</span>
            <span class="text-h3 font-bold text-on-surface">SynergyTech</span>
        </div>
    </section>

    {{-- Feature Grid (Bento Style) --}}
    <section id="features" class="w-full mb-32">
        <div class="text-center mb-12">
            <h2 class="text-h1 text-on-surface mb-2">Built for velocity</h2>
            <p class="text-body-md text-on-surface-variant max-w-lg mx-auto">Everything you need to plan, track, and ship software faster without the clutter.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Feature 1: Kanban --}}
            <div class="glass-panel p-6 rounded-xl md:col-span-2 flex flex-col justify-between group hover:border-dt-primary/50 transition-colors duration-300">
                <div class="mb-12">
                    <div class="w-12 h-12 rounded-lg bg-secondary-container/20 flex items-center justify-center mb-4 border border-secondary-container/30">
                        <span class="material-symbols-outlined text-dt-primary text-[24px]">view_kanban</span>
                    </div>
                    <h3 class="text-h3 text-on-surface mb-2">High-Performance Kanban</h3>
                    <p class="text-body-md text-on-surface-variant">Visualize your workflow with fluid, real-time boards. Snap to grid, categorize with tags, and drag-and-drop with zero latency.</p>
                </div>
                <div class="w-full h-48 bg-surface-container-low rounded-lg border border-outline-variant/20 overflow-hidden relative">
                    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&q=80&w=800')] bg-cover bg-center opacity-30 mix-blend-luminosity"></div>
                </div>
            </div>

            {{-- Feature 2: Docs --}}
            <div class="glass-panel p-6 rounded-xl flex flex-col justify-between group hover:border-dt-primary/50 transition-colors duration-300">
                <div class="mb-6">
                    <div class="w-12 h-12 rounded-lg bg-tertiary-container/20 flex items-center justify-center mb-4 border border-tertiary-container/30">
                        <span class="material-symbols-outlined text-dt-tertiary text-[24px]">description</span>
                    </div>
                    <h3 class="text-h3 text-on-surface mb-2">Built-in Docs</h3>
                    <p class="text-body-md text-on-surface-variant">Write specs, RFCs, and documentation natively within your tasks using Markdown.</p>
                </div>
                <div class="mt-auto">
                    <div class="font-mono text-code text-primary-fixed-dim bg-surface-container p-2 rounded border border-outline-variant/30">
                        &gt; _Status:_ In Review<br/>
                        &gt; **Deploy to Prod**
                    </div>
                </div>
            </div>

            {{-- Feature 3: Team Collaboration --}}
            <div class="glass-panel p-6 rounded-xl flex flex-col justify-between group hover:border-dt-primary/50 transition-colors duration-300">
                <div class="mb-6">
                    <div class="w-12 h-12 rounded-lg bg-primary-container/20 flex items-center justify-center mb-4 border border-primary-container/30">
                        <span class="material-symbols-outlined text-dt-primary text-[24px]">group</span>
                    </div>
                    <h3 class="text-h3 text-on-surface mb-2">Seamless Sync</h3>
                    <p class="text-body-md text-on-surface-variant">Real-time presence and instant updates keep your team aligned across timezones.</p>
                </div>
                <div class="flex -space-x-2 overflow-hidden mt-auto pt-2">
                    <div class="inline-block h-8 w-8 rounded-full ring-2 ring-surface bg-surface-container-high border border-outline-variant flex items-center justify-center"><span class="material-symbols-outlined text-[16px] text-on-surface-variant">person</span></div>
                    <div class="inline-block h-8 w-8 rounded-full ring-2 ring-surface bg-surface-container-high border border-outline-variant flex items-center justify-center"><span class="material-symbols-outlined text-[16px] text-on-surface-variant">person</span></div>
                    <div class="inline-block h-8 w-8 rounded-full ring-2 ring-surface bg-dt-primary/20 border border-dt-primary/50 flex items-center justify-center text-dt-primary text-label-sm text-[10px]">+3</div>
                </div>
            </div>

            {{-- Feature 4: Analytics --}}
            <div class="glass-panel p-6 rounded-xl md:col-span-2 flex flex-col justify-between group hover:border-dt-primary/50 transition-colors duration-300">
                <div class="flex md:flex-row flex-col gap-6 h-full">
                    <div class="flex-1 flex flex-col justify-center">
                        <div class="w-12 h-12 rounded-lg bg-secondary-container/20 flex items-center justify-center mb-4 border border-secondary-container/30">
                            <span class="material-symbols-outlined text-dt-secondary text-[24px]">monitoring</span>
                        </div>
                        <h3 class="text-h3 text-on-surface mb-2">Engineering Insights</h3>
                        <p class="text-body-md text-on-surface-variant">Track velocity, identify bottlenecks, and measure impact with automated reporting designed for technical leads.</p>
                    </div>
                    <div class="flex-1 bg-surface-container-lowest rounded-lg border border-outline-variant/20 p-4 flex items-end gap-2 h-40">
                        {{-- Simulated Chart --}}
                        <div class="w-1/6 bg-dt-primary/20 rounded-t h-1/3"></div>
                        <div class="w-1/6 bg-dt-primary/40 rounded-t h-1/2"></div>
                        <div class="w-1/6 bg-dt-primary/60 rounded-t h-3/4"></div>
                        <div class="w-1/6 bg-dt-primary/80 rounded-t h-full"></div>
                        <div class="w-1/6 bg-secondary-container/80 rounded-t h-5/6 relative"><div class="absolute -top-6 left-1/2 -translate-x-1/2 font-mono text-[10px] text-dt-secondary">Peak</div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

{{-- Footer --}}
<footer class="w-full border-t border-outline-variant/20 bg-surface-container-lowest/50 py-12 relative z-10">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-12">
        <div class="col-span-2 md:col-span-1">
            <span class="text-h2 font-bold tracking-tight text-dt-primary mb-4 block">DevTrack</span>
            <p class="text-body-md text-on-surface-variant opacity-80 max-w-xs">Engineered for the modern workflow. Minimalist, fast, and powerful.</p>
        </div>
        <div>
            <h4 class="text-label-sm text-on-surface mb-4 font-semibold tracking-wider uppercase">Product</h4>
            <ul class="space-y-2 flex flex-col">
                <li><a class="text-body-md text-on-surface-variant hover:text-dt-primary transition-colors" href="#">Features</a></li>
                <li><a class="text-body-md text-on-surface-variant hover:text-dt-primary transition-colors" href="#">Integrations</a></li>
                <li><a class="text-body-md text-on-surface-variant hover:text-dt-primary transition-colors" href="#">Pricing</a></li>
                <li><a class="text-body-md text-on-surface-variant hover:text-dt-primary transition-colors" href="#">Changelog</a></li>
            </ul>
        </div>
        <div>
            <h4 class="text-label-sm text-on-surface mb-4 font-semibold tracking-wider uppercase">Resources</h4>
            <ul class="space-y-2 flex flex-col">
                <li><a class="text-body-md text-on-surface-variant hover:text-dt-primary transition-colors" href="#">Documentation</a></li>
                <li><a class="text-body-md text-on-surface-variant hover:text-dt-primary transition-colors" href="#">API Reference</a></li>
                <li><a class="text-body-md text-on-surface-variant hover:text-dt-primary transition-colors" href="#">Community</a></li>
                <li><a class="text-body-md text-on-surface-variant hover:text-dt-primary transition-colors" href="#">Blog</a></li>
            </ul>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-6 mt-12 pt-6 border-t border-outline-variant/10 flex flex-col md:flex-row justify-between items-center text-label-sm text-on-surface-variant opacity-60">
        <p>© {{ date('Y') }} DevTrack Systems Inc. All rights reserved.</p>
        <div class="flex gap-4 mt-2 md:mt-0">
            <a class="hover:text-dt-primary transition-colors" href="#">Privacy Policy</a>
            <a class="hover:text-dt-primary transition-colors" href="#">Terms of Service</a>
        </div>
    </div>
</footer>

</body>
</html>
