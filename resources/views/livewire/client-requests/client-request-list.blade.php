<div class="h-full w-full flex-1 flex flex-col gap-4 rounded-xl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Solicitudes de Clientes</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Gestiona las solicitudes de tus clientes
            </p>
        </div>
        @can('create requests')
            <flux:button href="{{ route('client-requests.create') }}" variant="primary" icon="plus">
                Crear Solicitud
            </flux:button>
        @endcan
    </div>

    <div class="mb-6 flex flex-col sm:flex-row gap-4">
        <div class="relative w-full sm:w-1/2">
            <div class="absolute inset-y-0 start-0 flex items-center p-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search"
                class="block w-full pl-10 px-10 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm"
                placeholder="Buscar solicitudes..." type="text" />
        </div>
        <div class="w-full sm:w-1/2">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 p-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </div>
                <select wire:model.live="clientFilter"
                    class="block w-full pl-10 py-3 p-8 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm appearance-none">
                    <option value="">Todos los Clientes</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 top-[-2px] items-center p-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div
        class="bg-white dark:bg-sidebar-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-slate-800/50 border-b border-gray-200 dark:border-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">Fecha</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">Título</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">Cliente</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">Solicitante</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">Asignado</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">Creado Por</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">Estado</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-sidebar-dark divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($requests as $request)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">
                                    {{ $request->request_date->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $request->request_date->format('h:i A') }}
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $request->title }}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $request->client->name ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $request->responsible }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex -space-x-2 overflow-hidden">
                                    @forelse($request->assignees->take(3) as $assignee)
                                        @if($assignee->profile_photo_url)
                                            <img src="{{ $assignee->profile_photo_url }}" alt="{{ $assignee->name }}"
                                                title="{{ $assignee->name }}"
                                                class="inline-block h-6 w-6 rounded-full object-cover shrink-0 ring-2 ring-white dark:ring-gray-800 shadow-sm border border-gray-200 dark:border-gray-700">
                                        @else
                                            <div title="{{ $assignee->name }}"
                                                class="inline-flex h-6 w-6 rounded-full ring-2 ring-white dark:ring-gray-800 bg-gray-100 items-center justify-center text-[10px] font-bold text-gray-600 dark:text-gray-300 dark:bg-gray-700 shrink-0">
                                                {{ $assignee->initials() }}
                                            </div>
                                        @endif
                                    @empty
                                        <span class="text-xs text-gray-400 italic">Sin asignar</span>
                                    @endforelse
                                    @if($request->assignees->count() > 3)
                                        <div
                                            class="inline-block h-6 w-6 rounded-full ring-2 ring-white dark:ring-gray-800 bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                            +{{ $request->assignees->count() - 3 }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $request->createdBy->name ?? '-' }}
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($request->status)
                                    <span
                                        class="px-2 py-1 rounded-full text-xs font-medium {{ $request->status->badgeClasses() }}">
                                        {{ $request->status->name }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @can('view requests')
                                        <flux:button href="{{ route('client-requests.pdf', $request) }}" variant="ghost"
                                            size="xs" icon="document-text" target="_blank" title="Exportar a PDF">
                                        </flux:button>
                                        <flux:button href="{{ route('client-requests.show', $request) }}" variant="ghost"
                                            size="xs" icon="eye">
                                            Ver
                                        </flux:button>
                                    @endcan
                                    @can('edit requests')
                                        <flux:button href="{{ route('client-requests.edit', $request) }}" variant="ghost"
                                            size="xs" icon="pencil">
                                            Editar
                                        </flux:button>
                                    @endcan
                                    @can('delete requests')
                                        <flux:button wire:click="delete({{ $request->id }})"
                                            wire:confirm="¿Está seguro de eliminar esta solicitud?" variant="danger" size="xs"
                                            icon="trash">
                                            Eliminar
                                        </flux:button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                No se encontraron solicitudes.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 dark:bg-slate-800/50 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
            {{ $requests->links() }}
        </div>
    </div>


</div>