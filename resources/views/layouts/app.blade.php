<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DevTrack') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0B0E14] text-on-surface font-sans antialiased min-h-screen flex overflow-hidden">

{{-- Sidebar Navigation --}}
<nav class="bg-surface-container-low fixed left-0 top-0 h-screen w-64 z-50 border-r border-outline-variant/30 flex flex-col py-6 hidden md:flex">
    {{-- Logo --}}
    <div class="px-6 mb-6 flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-primary-container/20 flex items-center justify-center border border-dt-primary/20">
            <span class="material-symbols-outlined text-dt-primary text-2xl">code_blocks</span>
        </div>
        <div>
            <h1 class="text-h2 font-bold text-dt-primary leading-none">DevTrack</h1>
            <p class="text-label-sm text-on-surface-variant mt-1">Engineering Team</p>
        </div>
    </div>

    {{-- New Project Button --}}
    <div class="px-4 mb-6">
        <a href="{{ route('projects.create') }}"
           class="w-full py-2 px-4 rounded-lg btn-primary-gradient text-white font-medium flex items-center justify-center gap-2 hover:opacity-90 transition-opacity text-body-md">
            <span class="material-symbols-outlined text-[18px]">add</span>
            New Project
        </a>
    </div>

    {{-- Main Nav Links --}}
    <div class="flex-1 overflow-y-auto px-3 space-y-1">
        <a href="{{ route('dashboard') }}"
           class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link-active' : '' }}">
            <span class="material-symbols-outlined text-[20px]" @if(request()->routeIs('dashboard')) style="font-variation-settings: 'FILL' 1;" @endif>dashboard</span>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('projects.index') }}"
           class="sidebar-link {{ request()->routeIs('projects.*') && !request()->routeIs('projects.archives') ? 'sidebar-link-active' : '' }}">
            <span class="material-symbols-outlined text-[20px]" @if(request()->routeIs('projects.*') && !request()->routeIs('projects.archives')) style="font-variation-settings: 'FILL' 1;" @endif>folder_open</span>
            <span>Projects</span>
        </a>
        <a href="{{ route('tasks.index') }}"
           class="sidebar-link {{ request()->routeIs('tasks.*') ? 'sidebar-link-active' : '' }}">
            <span class="material-symbols-outlined text-[20px]" @if(request()->routeIs('tasks.*')) style="font-variation-settings: 'FILL' 1;" @endif>checklist</span>
            <span>Tasks</span>
        </a>
        <a href="{{ route('team.index') }}"
           class="sidebar-link {{ request()->routeIs('team.*') ? 'sidebar-link-active' : '' }}">
            <span class="material-symbols-outlined text-[20px]" @if(request()->routeIs('team.*')) style="font-variation-settings: 'FILL' 1;" @endif>group</span>
            <span>Team</span>
        </a>
        <a href="{{ route('projects.archives') }}"
           class="sidebar-link {{ request()->routeIs('projects.archives') ? 'sidebar-link-active' : '' }}">
            <span class="material-symbols-outlined text-[20px]" @if(request()->routeIs('projects.archives')) style="font-variation-settings: 'FILL' 1;" @endif>archive</span>
            <span>Archive</span>
        </a>
    </div>

    {{-- Bottom Links --}}
    <div class="px-3 pt-4 border-t border-outline-variant/30 space-y-1 mt-auto">
        <a href="#" class="sidebar-link">
            <span class="material-symbols-outlined text-[20px]">description</span>
            <span>Docs</span>
        </a>
        <a href="#" class="sidebar-link">
            <span class="material-symbols-outlined text-[20px]">contact_support</span>
            <span>Support</span>
        </a>
    </div>
</nav>

{{-- Main Content Area --}}
<div class="flex-1 flex flex-col md:ml-64 h-screen w-full">
    {{-- Top Navigation Bar --}}
    <header class="bg-surface-container-lowest/80 backdrop-blur-xl sticky top-0 z-40 border-b border-outline-variant/30 flex justify-between items-center w-full px-6 py-2">
        <div class="flex items-center gap-3 flex-1">
            {{-- Mobile logo --}}
            <h2 class="text-h2 font-bold text-dt-primary md:hidden">DevTrack</h2>
            {{-- Search --}}
            <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-surface-container-low rounded-lg border border-outline-variant/30 w-full max-w-md focus-within:border-dt-primary transition-colors">
                <span class="material-symbols-outlined text-on-surface-variant text-[20px]">search</span>
                <input class="bg-transparent border-none focus:ring-0 text-on-surface text-body-md w-full placeholder:text-outline p-0"
                       placeholder="Search projects, tasks..." type="text"/>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button class="p-2 text-on-surface-variant hover:bg-surface-container-high/50 hover:text-on-surface transition-all active:scale-95 duration-200 rounded-full">
                <span class="material-symbols-outlined">notifications</span>
            </button>
            <button class="p-2 text-on-surface-variant hover:bg-surface-container-high/50 hover:text-on-surface transition-all active:scale-95 duration-200 rounded-full">
                <span class="material-symbols-outlined">help</span>
            </button>
            <a href="{{ route('profile.edit') }}" class="p-2 text-on-surface-variant hover:bg-surface-container-high/50 hover:text-on-surface transition-all active:scale-95 duration-200 rounded-full">
                <span class="material-symbols-outlined">settings</span>
            </a>
            {{-- User avatar dropdown --}}
            <div class="ml-2 pl-2 border-l border-outline-variant/30 flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container text-sm font-bold cursor-pointer border border-outline-variant/30 hover:border-dt-primary/50 transition-colors">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="hidden lg:block">
                    <p class="text-body-md text-on-surface font-medium leading-none">{{ Auth::user()->name }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-1 text-on-surface-variant hover:text-dt-error transition-colors" title="Logout">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- Page Content --}}
    <main class="flex-1 overflow-y-auto p-6 custom-scrollbar">
        <div class="max-w-[1440px] mx-auto">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="flex items-center gap-3 p-4 bg-[#81c995]/10 border border-[#81c995]/20 text-[#81c995] rounded-xl mb-6">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    <span class="text-body-md font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if($errors->any())
                <div class="flex items-start gap-3 p-4 bg-dt-error/10 border border-dt-error/20 text-dt-error rounded-xl mb-6">
                    <span class="material-symbols-outlined text-[20px] mt-0.5">error</span>
                    <ul class="text-body-md space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{ $slot }}
        </div>
    </main>
</div>

</body>
</html>
