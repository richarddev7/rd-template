{{-- Dynamic App Logo from Settings --}}
@php
    $appLogo = setting('app_logo');
    $appName = setting('app_name', env('APP_NAME', 'Laravel'));
@endphp

@if($appLogo)
    {{-- Custom Logo from Settings --}}
    <div class="flex items-center space-x-2">
        <img src="{{ Storage::url($appLogo) }}" alt="{{ $appName }}" class="h-8 w-auto object-contain">
        <div class="grid flex-1 text-start text-sm">
            <span class="mb-0.5 truncate leading-tight font-semibold">{{ $appName }}</span>
        </div>
    </div>
@else
    {{-- Default Logo --}}
    <div class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
        <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
    </div>
    <div class="ms-1 grid flex-1 text-start text-sm">
        <span class="mb-0.5 truncate leading-tight font-semibold">{{ $appName }}</span>
    </div>
@endif