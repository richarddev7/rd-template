<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

@php
    // Get theme colors from settings with fallbacks
    $bgColor = setting('background_color', '#ffffff');
    $primaryColor = setting('theme_primary_color', '#0ea5e9');
@endphp

<body class="min-h-screen bg-white dark:bg-zinc-800 antialiased"
    style="--app-bg-color: {{ $bgColor }}; --app-primary-color: {{ $primaryColor }};">
    <flux:sidebar sticky collapsible="mobile"
        class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
        <flux:sidebar.header>
            <a href="{{ route('dashboard') }}" class="flex items-center" wire:navigate>
                <x-app-logo />
            </a>

            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        {{-- Global Search --}}
        <div class="py-3 border-b border-zinc-200 dark:border-zinc-700">
            @livewire('global-search')
        </div>

        <flux:sidebar.nav>
            <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                wire:navigate>
                {{ __('Dashboard') }}
            </flux:sidebar.item>

            {{-- Usuario submenu --}}
            @if(auth()->user()->can('view users') || auth()->user()->can('view roles'))
                <flux:sidebar.group expandable expanded="false" :heading="__('Usuario')" class="grid">
                    @can('view users')
                        <flux:sidebar.item icon="users" :href="route('users.index')" :current="request()->routeIs('users.*')"
                            wire:navigate>
                            {{ __('Users') }}
                        </flux:sidebar.item>
                    @endcan
                    @can('view roles')
                        <flux:sidebar.item icon="lock-closed" :href="route('roles.index')"
                            :current="request()->routeIs('roles.*')" wire:navigate>
                            {{ __('Roles') }}
                        </flux:sidebar.item>
                    @endcan
                </flux:sidebar.group>
            @endif

            @can('view tasks')
                <flux:sidebar.item icon="clipboard-document-list" :href="route('tasks.index')"
                    :current="request()->routeIs('tasks.*')" wire:navigate>{{ __('Tasks') }}</flux:sidebar.item>
            @endcan
            @can('view clients')
                <flux:sidebar.item icon="building-office-2" :href="route('clients.index')"
                    :current="request()->routeIs('clients.*')" wire:navigate>{{ __('Clients') }}</flux:sidebar.item>
            @endcan
            @can('view requests')
                <flux:sidebar.item icon="document-text" :href="route('client-requests.index')"
                    :current="request()->routeIs('client-requests.*')" wire:navigate>Solicitudes
                </flux:sidebar.item>
            @endcan

            @can('view_assigned_cases')
                <flux:sidebar.item icon="briefcase" :href="route('legal-cases.index')"
                    :current="request()->routeIs('legal-cases.*')" wire:navigate>Expedientes
                </flux:sidebar.item>
            @endcan

            @can('view_reports_menu')
                <flux:sidebar.item icon="document-chart-bar" :href="route('reports.index')"
                    :current="request()->routeIs('reports.*')" wire:navigate>Reportes
                </flux:sidebar.item>
            @endcan

            @can('view events')
                <flux:sidebar.group expandable expanded="false" :heading="__('Events')" class="grid">
                    <flux:sidebar.item icon="calendar" :href="route('events.index')"
                        :current="request()->routeIs('events.index')" wire:navigate>
                        {{ __('Calendar') }}
                    </flux:sidebar.item>

                    @can('create events')
                        <flux:sidebar.item icon="tag" :href="route('event-types.index')"
                            :current="request()->routeIs('event-types.index')" wire:navigate>
                            {{ __('Event Types') }}
                        </flux:sidebar.item>
                    @endcan
                </flux:sidebar.group>
            @endcan

            @can('manage_email_templates')
                <flux:sidebar.item icon="envelope" :href="route('email-templates.index')"
                    :current="request()->routeIs('email-templates.*')" wire:navigate>
                    {{ __('Email Templates') }}
                </flux:sidebar.item>
            @endcan

            @can('view settings')
                <flux:sidebar.item icon="cog-6-tooth" :href="route('settings.app')"
                    :current="request()->routeIs('settings.app')" wire:navigate>{{ __('App Settings') }}
                </flux:sidebar.item>
            @endcan
        </flux:sidebar.nav>

        <flux:sidebar.spacer />

        <flux:sidebar.nav>
            {{-- Additional nav items can go here --}}
        </flux:sidebar.nav>

        <flux:dropdown position="top" align="start" class="max-lg:hidden">
            <flux:sidebar.profile :avatar="auth()->user()->profile_photo_url" :initials="auth()->user()->initials()"
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
                                @if(auth()->user()->roles->isNotEmpty())
                                    <span
                                        class="truncate text-xs text-zinc-500 dark:text-zinc-400">{{ auth()->user()->roles->first()->name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}
                </flux:menu.item>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full"
                        data-test="logout-button">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:sidebar>

    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="start">
            <flux:profile :avatar="auth()->user()->profile_photo_url" :initials="auth()->user()->initials()" />

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
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}
                </flux:menu.item>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full"
                        data-test="logout-button">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{-- Leave Impersonation Button --}}
    @if(session()->has('impersonating'))
        <form method="POST" action="{{ route('impersonate.stop') }}" class="fixed bottom-4 right-4 z-50">
            @csrf
            <flux:button type="submit" variant="primary" icon="arrow-uturn-left" class="shadow-lg">
                {{ __('Return to my account') }}
            </flux:button>
        </form>
    @endif

    <flux:main>
        {{ $slot }}
    </flux:main>

    @fluxScripts
    @stack('scripts')

</body>

</html>