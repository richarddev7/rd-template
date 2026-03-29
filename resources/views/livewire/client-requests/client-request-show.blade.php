<div class="max-w-7xl mx-auto px-6 py-8">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 border-b border-gray-200 dark:border-gray-700 pb-6 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border
                                {{ $clientRequest->status ? $clientRequest->status->badgeClasses() : 'bg-gray-100 text-gray-800 border-gray-200' }}">
                    {{ $clientRequest->status->name ?? 'Sin Estado' }}
                </span>
                <span class="text-sm text-gray-500 dark:text-gray-400">
                    #{{ $clientRequest->id }}
                </span>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white leading-tight tracking-tight">
                {{ $clientRequest->title }}
            </h1>
            <div class="mt-3 flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-gray-500 dark:text-gray-400">
                <div class="flex items-center gap-2">
                    <flux:icon.calendar class="w-4 h-4" />
                    <span>Solicitado el {{ $clientRequest->request_date->format('d M, Y') }} at
                        {{ $clientRequest->request_date->format('h:i A') }}</span>
                </div>
                @if($clientRequest->source)
                    <div class="flex items-center gap-2">
                        <flux:icon.globe-alt class="w-4 h-4" />
                        <span>Vía {{ $clientRequest->source }}</span>
                    </div>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-3">
            <flux:button href="{{ route('client-requests.index') }}" variant="ghost" icon="arrow-left">
                Volver
            </flux:button>
            @can('edit requests')
                <flux:button href="{{ route('client-requests.edit', $clientRequest) }}" variant="primary" icon="pencil">
                    Editar
                </flux:button>
            @endcan
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Main Content (2/3) --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Context --}}
            <div class="bg-white dark:bg-sidebar-dark rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm">
                <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    <flux:icon.document-text class="w-5 h-5 text-primary-500" />
                    Contexto de la Solicitud
                </h3>
                <div
                    class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300  leading-relaxed">
                    {{ $clientRequest->context ?? 'Sin contexto proporcionado.' }}
                </div>
            </div>

            {{-- Specific Request / Description --}}
            @if($clientRequest->expected_result_description)
                <div class="bg-white dark:bg-sidebar-dark rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm">
                    <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <flux:icon.chat-bubble-bottom-center-text class="w-5 h-5 text-primary-500" />
                        Descripción de la Solicitud
                    </h3>
                    <div
                        class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300  leading-relaxed">
                        {{ $clientRequest->expected_result_description }}
                    </div>
                </div>
            @endif

            {{-- Documents --}}
            @if($clientRequest->documents && count($clientRequest->documents) > 0)
                <div class="bg-white dark:bg-sidebar-dark rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm">
                    <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        <flux:icon.paper-clip class="w-5 h-5 text-gray-500" />
                        Documentos Adjuntos ({{ count($clientRequest->documents) }})
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($clientRequest->documents as $document)
                            @php
                                $path = is_array($document) ? ($document['path'] ?? '') : $document;
                                $name = is_array($document) ? ($document['name'] ?? basename($path)) : basename($path);
                                $size = is_array($document) ? ($document['size'] ?? 0) : 0;
                                $extension = pathinfo($name, PATHINFO_EXTENSION);
                            @endphp
                            <a href="{{ Storage::url($path) }}" target="_blank"
                                class="group flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-800/50 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-primary-500 dark:hover:border-primary-500 hover:shadow-sm transition-all">
                                <div
                                    class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-white dark:bg-slate-700 rounded-lg text-gray-500 font-medium uppercase text-xs border border-gray-200 dark:border-gray-600">
                                    {{ $extension }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p
                                        class="text-sm font-medium text-gray-900 dark:text-white truncate group-hover:text-primary-600 dark:group-hover:text-primary-400">
                                        {{ $name }}
                                    </p>
                                    @if($size > 0)
                                        <p class="text-xs text-gray-500">
                                            {{ number_format($size / 1024, 2) }} KB
                                        </p>
                                    @endif
                                </div>
                                <flux:icon.arrow-top-right-on-square
                                    class="w-4 h-4 text-gray-400 group-hover:text-primary-500" />
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Tasks Section --}}
            <div class="bg-white dark:bg-sidebar-dark rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                     <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-900 dark:text-white">
                        <flux:icon.clipboard-document-list class="w-5 h-5 text-primary-500" />
                        Tareas y Actividades
                    </h3>
                </div>
                <div class="p-6">
                    <livewire:client-requests.tasks-for-request :requestId="$clientRequest->id"
                        :key="'tasks-' . $clientRequest->id" />
                </div>
            </div>
        </div>

        {{-- Right Column: Metadata (1/3) --}}
        <div class="space-y-6">
            {{-- People --}}
            <div
                class="bg-white dark:bg-sidebar-dark rounded-xl border border-gray-200 dark:border-gray-700 divide-y divide-gray-100 dark:divide-gray-700 overflow-hidden shadow-sm">
                {{-- Assigned Users --}}
                <div class="p-5">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Asignado a</h4>
                    @if($clientRequest->assignees->count() > 0)
                        <div class="flex flex-col gap-3">
                            @foreach($clientRequest->assignees as $assignee)
                                <div class="flex items-center gap-3">
                                    @if($assignee->profile_photo_url)
                                        <img src="{{ $assignee->profile_photo_url }}" alt="{{ $assignee->name }}" class="w-8 h-8 rounded-full object-cover shrink-0 border border-indigo-200 dark:border-indigo-800 shadow-sm">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-sm shrink-0">
                                            {{ $assignee->initials() }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-sm text-gray-900 dark:text-white">
                                            {{ $assignee->name }}
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $assignee->email }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 italic">Sin usuarios asignados</p>
                    @endif
                </div>

                {{-- Client --}}
                <div class="p-5">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Cliente</h4>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold text-sm">
                            {{ substr($clientRequest->client->name ?? '?', 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-sm text-gray-900 dark:text-white">
                                {{ $clientRequest->client->name ?? 'Sin asignar' }}
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Responsible --}}
                <div class="p-5">
                    <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Solicitante</h4>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-400 font-bold text-sm">
                            {{ substr($clientRequest->responsible, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-sm text-gray-900 dark:text-white">
                                {{ $clientRequest->responsible }}
                            </p>
                            <div class="flex flex-col gap-1.5 mt-2">
                                @if($clientRequest->contact_email)
                                    <a href="mailto:{{ $clientRequest->contact_email }}"
                                        class="text-xs text-gray-500 hover:text-blue-600 flex items-center gap-2">
                                        <flux:icon.envelope class="w-3.5 h-3.5" />
                                        {{ $clientRequest->contact_email }}
                                    </a>
                                @endif
                                @if($clientRequest->contact_phone)
                                    <a href="tel:{{ $clientRequest->contact_phone }}"
                                        class="text-xs text-gray-500 hover:text-blue-600 flex items-center gap-2">
                                        <flux:icon.phone class="w-3.5 h-3.5" />
                                        {{ $clientRequest->contact_phone }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Metadata Cards --}}
            <div class="space-y-4">
                 {{-- Dates --}}
                 <div class="bg-white dark:bg-sidebar-dark rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                    <h4 class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-4">
                        <flux:icon.calendar-days class="w-4 h-4 text-gray-500" />
                        Fechas Importantes
                    </h4>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Fecha Inicial:</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                {{ $clientRequest->start_date ? $clientRequest->start_date->format('d/m/Y h:i A') : 'N/A' }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-500">Fecha Límite:</span>
                            <span class="font-medium {{ $clientRequest->deadline_date && $clientRequest->deadline_date->isPast() ? 'text-red-600' : 'text-gray-900 dark:text-white' }}">
                                {{ $clientRequest->deadline_date ? $clientRequest->deadline_date->format('d/m/Y h:i A') : 'N/A' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Request Types --}}
                @if($clientRequest->request_types && count($clientRequest->request_types) > 0)
                    <div
                        class="bg-white dark:bg-sidebar-dark rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                        <h4 class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-3">
                            <flux:icon.tag class="w-4 h-4 text-gray-500" />
                            Categorías
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($clientRequest->request_types as $type)
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                                    {{ $type }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Expected Results --}}
                @if($clientRequest->expected_results && count($clientRequest->expected_results) > 0)
                    <div
                        class="bg-white dark:bg-sidebar-dark rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                        <h4 class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-3">
                            <flux:icon.check-circle class="w-4 h-4 text-gray-500" />
                            Objetivos
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($clientRequest->expected_results as $result)
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-300 border border-green-100 dark:border-green-800">
                                    {{ $result }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- System Info --}}
                <div class="bg-gray-50 dark:bg-slate-800/50 rounded-xl p-4 text-xs text-gray-500 space-y-2 border border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between">
                        <span>Creado el:</span>
                        <span class="font-medium">{{ $clientRequest->created_at->format('d/m/Y h:i A') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Por:</span>
                        <span class="font-medium">{{ $clientRequest->createdBy->name ?? 'Sistema' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Última actualización:</span>
                        <span class="font-medium">{{ $clientRequest->updated_at->diffForHumans() }}</span>
                    </div>
                </div>

                {{-- Worked Hours Summary --}}
                @if($this->workedHoursPerUser['total'] > 0)
                    <div class="bg-white dark:bg-sidebar-dark rounded-xl border border-gray-200 dark:border-gray-700 p-5 shadow-sm">
                        <h4 class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white mb-3">
                            <flux:icon.clock class="w-4 h-4 text-gray-500" />
                            Resumen de Horas
                        </h4>
                        <div class="space-y-3">
                            @foreach($this->workedHoursPerUser['users'] as $userHours)
                                <div class="flex items-center justify-between text-sm">
                                    <div class="flex items-center gap-2 overflow-hidden">
                                        @if($userHours['user']->profile_photo_url)
                                            <img src="{{ $userHours['user']->profile_photo_url }}" alt="{{ $userHours['user']->name }}" class="w-7 h-7 rounded-full object-cover shrink-0 border border-indigo-100 dark:border-indigo-800 shadow-sm">
                                        @else
                                            <div class="w-7 h-7 rounded-full bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center flex-shrink-0">
                                                <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase">
                                                    {{ $userHours['user']->initials() }}
                                                </span>
                                            </div>
                                        @endif
                                        <span class="text-gray-600 dark:text-gray-300 truncate" title="{{ $userHours['user']->name }}">
                                            {{ $userHours['user']->name }}
                                        </span>
                                    </div>
                                    <span class="font-semibold text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ number_format($userHours['hours'], 1) }}h
                                    </span>
                                </div>
                            @endforeach
                            
                            <div class="pt-3 mt-3 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                                <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Acumulado</span>
                                <span class="text-base font-bold text-indigo-600 dark:text-indigo-400">
                                    {{ number_format($this->workedHoursPerUser['total'], 1) }}h
                                </span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
