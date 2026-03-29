<div class="max-w-7xl mx-auto px-6 py-8 space-y-6">
    {{-- Breadcrumb Navigation --}}
    <div class="flex justify-between items-center mb-2">
        <nav class="flex text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ route('clients.index') }}" class="hover:text-gray-700 dark:hover:text-gray-200 cursor-pointer">
                {{ __('Clientes') }}
            </a>
            <span class="mx-2">/</span>
            <span class="font-medium text-gray-800 dark:text-white">{{ $client->name }}</span>
        </nav>
        <div class="flex space-x-3">
            <flux:button href="{{ route('clients.edit', $client) }}" variant="ghost" icon="pencil">
                {{ __('Edit Profile') }}
            </flux:button>
            <flux:button href="{{ route('client-requests.index') }}" variant="primary" icon="plus">
                {{ __('Requests') }}
            </flux:button>
        </div>
    </div>

    {{-- Client Header Card --}}
    <div class="bg-white dark:bg-sidebar-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center gap-5">
                {{-- Avatar --}}
                <div class="h-16 w-16 rounded-full flex items-center justify-center shadow-lg"
                    style="background-color: #4f46e5;">
                    <span class="text-2xl font-bold text-white">{{ $client->initials }}</span>
                </div>

                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                        {{ $client->name }}
                        @if($client->is_active)
                            <span
                                class="px-2.5 py-0.5 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium border border-green-200 dark:border-green-800">
                                {{ __('Active Client') }}
                            </span>
                        @else
                            <span
                                class="px-2.5 py-0.5 rounded-full bg-gray-100 dark:bg-gray-900/30 text-gray-700 dark:text-gray-400 text-xs font-medium border border-gray-200 dark:border-gray-800">
                                {{ __('Inactive') }}
                            </span>
                        @endif
                    </h2>
                    <div class="flex flex-wrap items-center gap-4 mt-1 text-sm text-gray-500 dark:text-gray-400">
                        @if($client->website)
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                </svg>
                                <a href="{{ $client->website }}" target="_blank"
                                    class="hover:text-primary">{{ $client->website }}</a>
                            </span>
                        @endif
                        @if($client->location)
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $client->location }}
                            </span>
                        @endif
                        @if($client->contact_person)
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ __('Contact') }}: {{ $client->contact_person }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}


        {{-- Pending Requests Card --}}
        <div
            class="bg-white dark:bg-sidebar-dark p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col justify-between group hover:border-indigo-200 dark:hover:border-indigo-900/50 transition-all">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Pending Requests') }}</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-1">{{ $pendingRequestsCount }}</h3>
                </div>
                <div class="p-2 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-center text-xs text-gray-500 dark:text-gray-400">
                @if($pendingRequestsCount > 0)
                    <span class="text-amber-600 dark:text-amber-400 font-medium mr-1">
                        {{ __('High Priority') }}
                    </span>
                    {{ __('needs attention') }}
                @else
                    <span class="text-gray-400 font-medium">
                        {{ __('All clear') }}
                    </span>
                @endif
            </div>
        </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Tabbed Content Area --}}
    {{-- Tabbed Content Area --}}
    <div
        class="bg-white dark:bg-sidebar-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col min-h-[400px]">
        {{-- Tab Headers --}}
        <div class="flex border-b border-gray-200 dark:border-gray-700 px-6 gap-8">
            <button wire:click="setActiveTab('cases')"
                class="custom-tab-link {{ $activeTab === 'cases' ? 'custom-tab-active' : '' }}">
                {{ __('Expedientes') }}
            </button>
            <button wire:click="setActiveTab('requests')"
                class="custom-tab-link {{ $activeTab === 'requests' ? 'custom-tab-active' : '' }}">
                {{ __('Solicitudes') }}
                @if($pendingRequestsCount > 0)
                    <span
                        class="ml-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 py-0.5 px-2 rounded-full text-xs">{{ $pendingRequestsCount }}</span>
                @endif
            </button>

            <button wire:click="setActiveTab('team')"
                class="custom-tab-link {{ $activeTab === 'team' ? 'custom-tab-active' : '' }}">
                {{ __('Asignaciones del Equipo') }}
            </button>
            <button wire:click="setActiveTab('documents')"
                class="custom-tab-link {{ $activeTab === 'documents' ? 'custom-tab-active' : '' }}">
                {{ __('Documentos') }}
            </button>
        </div>

        {{-- Tab Content --}}
        <div class="p-6">
            @if($activeTab === 'cases')
                <div class="space-y-4">
                    @forelse($legalCases as $case)
                        <div class="flex items-start p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800/50 hover:shadow-md transition-shadow cursor-pointer"
                            onclick="window.location.href='{{ route('legal-cases.show', $case) }}'">
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                        <span class="text-indigo-600 dark:text-indigo-400">#{{ $case->case_number }}</span>
                                        {{ $case->title }}
                                    </h4>
                                    <span
                                        class="text-xs font-medium px-2 py-1 rounded {{ $case->status?->badgeClasses() ?? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-700 dark:text-indigo-300' }}">
                                        {{ $case->status?->label() ?? __('Activo') }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ Str::limit($case->description, 150) }}
                                </p>
                                <div class="flex flex-wrap items-center mt-3 gap-4 text-xs text-gray-500 dark:text-gray-400">
                                    @if($case->serviceType)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                            </svg>
                                            {{ $case->serviceType->name }}
                                        </div>
                                    @endif
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $case->created_at->format('M d, Y') }}
                                    </div>
                                    @if($case->leadLawyer)
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $case->leadLawyer->name }}
                                        </div>
                                    @endif
                                    @if($case->updates_sum_hours > 0)
                                        <div class="flex items-center text-indigo-600 dark:text-indigo-400 font-medium ml-auto">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ number_format($case->updates_sum_hours, 1) }}h
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            {{ __('No hay expedientes asociados a este cliente.') }}
                        </div>
                    @endforelse
                </div>

            @elseif($activeTab === 'requests')
                <div class="space-y-4">
                    @forelse($client->requests()->orderBy('created_at', 'desc')->get() as $request)
                        <div
                            class="flex items-start p-4 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-slate-800/50">
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $request->title }}</h4>
                                    <span
                                        class="text-xs font-medium px-2 py-1 rounded bg-amber-50 dark:bg-amber-900/20 text-amber-700 dark:text-amber-300">
                                        {{ __('Pending') }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    {{ Str::limit($request->context, 100) }}
                                </p>
                                <div class="flex items-center mt-3 gap-4 text-xs text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $request->request_date->format('M d, Y') }}
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                            {{ __('No requests found for this client.') }}
                        </div>
                    @endforelse
                </div>
            @elseif($activeTab === 'team')
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    {{ __('Team assignments will be displayed here.') }}
                </div>
            @elseif($activeTab === 'documents')
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    {{ __('Documents will be displayed here.') }}
                </div>
            @endif
        </div>
    </div>
</div>