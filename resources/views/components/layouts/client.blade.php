<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

@php
    $bgColor = setting('background_color', '#ffffff');
    $primaryColor = setting('theme_primary_color', '#0ea5e9');
    // Define the active tab based on current route
    $activeTab = match (true) {
        request()->routeIs('portal.dashboard') => 'dashboard',
        request()->routeIs('portal.requests') => 'requests',
        request()->routeIs('portal.events') => 'events',
        request()->routeIs('portal.profile') => 'profile',
        default => 'dashboard',
    };
@endphp

<body class="min-h-screen bg-white dark:bg-zinc-800 antialiased"
    style="--app-bg-color: {{ $bgColor }}; --app-primary-color: {{ $primaryColor }};">

    {{-- TOP NAVBAR --}}
    <flux:header
        class="border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-900 px-4 sticky top-0 z-40">
        {{-- Logo --}}
        <a href="{{ route('portal.dashboard') }}" class="flex items-center mr-6" wire:navigate>
            <x-app-logo />
        </a>

        {{-- Horizontal navigation tabs --}}
        <flux:navbar class="hidden sm:flex gap-1 flex-1">
            <flux:navbar.item href="{{ route('portal.dashboard') }}" :current="$activeTab === 'dashboard'" icon="home"
                wire:navigate>
                {{ __('Dashboard') }}
            </flux:navbar.item>

            <flux:navbar.item href="{{ route('portal.requests') }}" :current="$activeTab === 'requests'"
                icon="document-text" wire:navigate>
                Mis Solicitudes
            </flux:navbar.item>

            <flux:navbar.item href="{{ route('portal.events') }}" :current="$activeTab === 'events'" icon="calendar"
                wire:navigate>
                Eventos
            </flux:navbar.item>

            <flux:navbar.item href="{{ route('portal.profile') }}" :current="$activeTab === 'profile'" icon="user"
                wire:navigate>
                Mi Perfil
            </flux:navbar.item>
        </flux:navbar>

        <flux:spacer />

        {{-- User dropdown --}}
        <flux:dropdown position="bottom" align="end">
            <flux:profile :avatar="auth()->user()->profile_photo_url" :initials="auth()->user()->initials()"
                :name="auth()->user()->name" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                @if(auth()->user()->profile_photo_url)
                                    <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
                                        {{ auth()->user()->initials() }}
                                    </span>
                                @endif
                            </span>
                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                <span class="truncate text-xs text-zinc-500 dark:text-zinc-400">Cliente</span>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.item :href="route('portal.profile')" icon="cog" wire:navigate>
                    {{ __('Mi Perfil') }}
                </flux:menu.item>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ __('Cerrar Sesión') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{-- Mobile bottom navigation bar --}}
    <nav
        class="sm:hidden fixed bottom-0 left-0 right-0 z-40 bg-white dark:bg-zinc-900 border-t border-zinc-200 dark:border-zinc-700 flex">
        <a href="{{ route('portal.dashboard') }}"
            class="flex flex-col items-center flex-1 py-2 text-xs gap-0.5 {{ $activeTab === 'dashboard' ? 'text-sky-500' : 'text-zinc-500 dark:text-zinc-400' }}"
            wire:navigate>
            <flux:icon name="home" class="size-5" />
            Dashboard
        </a>
        <a href="{{ route('portal.requests') }}"
            class="flex flex-col items-center flex-1 py-2 text-xs gap-0.5 {{ $activeTab === 'requests' ? 'text-sky-500' : 'text-zinc-500 dark:text-zinc-400' }}"
            wire:navigate>
            <flux:icon name="document-text" class="size-5" />
            Solicitudes
        </a>
        <a href="{{ route('portal.events') }}"
            class="flex flex-col items-center flex-1 py-2 text-xs gap-0.5 {{ $activeTab === 'events' ? 'text-sky-500' : 'text-zinc-500 dark:text-zinc-400' }}"
            wire:navigate>
            <flux:icon name="calendar" class="size-5" />
            Eventos
        </a>
        <a href="{{ route('portal.profile') }}"
            class="flex flex-col items-center flex-1 py-2 text-xs gap-0.5 {{ $activeTab === 'profile' ? 'text-sky-500' : 'text-zinc-500 dark:text-zinc-400' }}"
            wire:navigate>
            <flux:icon name="user" class="size-5" />
            Perfil
        </a>
    </nav>

    {{-- Leave Impersonation Button (visible when admin is viewing a client portal) --}}
    @if(session()->has('impersonating'))
        <form method="POST" action="{{ route('impersonate.stop') }}" class="fixed bottom-4 right-4 z-50">
            @csrf
            <flux:button type="submit" variant="primary" icon="arrow-uturn-left" class="shadow-lg">
                {{ __('Return to my account') }}
            </flux:button>
        </form>
    @endif

    {{-- Main content --}}
    <flux:main container class="pb-20 sm:pb-8">
        {{ $slot }}
    </flux:main>

    @fluxScripts
    @stack('scripts')

</body>

</html>