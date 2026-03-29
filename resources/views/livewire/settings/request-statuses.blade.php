<div class="space-y-6">
    <div class="flex items-start justify-between border-b border-gray-200 dark:border-gray-700 pb-4">
        <div>
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <span class="material-icons-round text-blue-500">assignment</span>
                {{ __('Gestión de Estados de Solicitudes') }}
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Configura los estados para las solicitudes de clientes') }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <flux:button @click="$flux.modal('request-status-modal').close()" type="button" variant="ghost"
                icon="x-mark" size="sm">
            </flux:button>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="p-4 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="p-4 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- Inline Form for Create/Edit --}}
    <div class="bg-gray-50 dark:bg-slate-800/50 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
        <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">
            {{ $editingStatusId ? __('Editar Estado') : __('Agregar Nuevo Estado') }}
        </h3>

        <form wire:submit="saveStatus">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                {{-- Name --}}
                <div class="col-span-1 md:col-span-2 lg:col-span-1">
                    <flux:input wire:model="statusForm.name" placeholder="{{ __('Nombre del Estado') }}" required />
                    <flux:error name="statusForm.name" />
                </div>

                {{-- Slug --}}
                <div class="col-span-1 md:col-span-2 lg:col-span-1">
                    <flux:input wire:model="statusForm.slug" placeholder="{{ __('Identificador') }}" required />
                    <flux:error name="statusForm.slug" />
                </div>

                {{-- Color --}}
                <div>
                    <flux:select wire:model="statusForm.color" required placeholder="{{ __('Color') }}">
                        <flux:select.option value="gray">{{ __('Gris') }}</flux:select.option>
                        <flux:select.option value="blue">{{ __('Azul') }}</flux:select.option>
                        <flux:select.option value="green">{{ __('Verde') }}</flux:select.option>
                        <flux:select.option value="yellow">{{ __('Amarillo') }}</flux:select.option>
                        <flux:select.option value="red">{{ __('Rojo') }}</flux:select.option>
                        <flux:select.option value="purple">{{ __('Púrpura') }}</flux:select.option>
                        <flux:select.option value="pink">{{ __('Rosa') }}</flux:select.option>
                        <flux:select.option value="indigo">{{ __('Índigo') }}</flux:select.option>
                    </flux:select>
                    <flux:error name="statusForm.color" />
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-2">
                    <flux:button type="submit" variant="primary" size="sm" class="w-full">
                        {{ $editingStatusId ? __('Actualizar') : __('Agregar') }}
                    </flux:button>
                    @if($editingStatusId)
                        <flux:button type="button" wire:click="cancelEdit" variant="ghost" size="sm">
                            {{ __('Cancelar') }}
                        </flux:button>
                    @endif
                </div>
            </div>


        </form>
    </div>

    {{-- Lista de estados --}}
    <div class="space-y-2 max-h-[400px] overflow-y-auto pr-1" id="status-list">
        @forelse($requestStatuses as $status)
            <div wire:key="status-{{ $status->id }}"
                class="flex items-center gap-4 p-3 bg-white dark:bg-slate-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-gray-300 dark:hover:border-gray-600 transition-colors {{ $editingStatusId === $status->id ? 'ring-2 ring-blue-500 border-transparent' : '' }}"
                data-status-id="{{ $status->id }}">
                {{-- Handle para drag & drop --}}
                <span
                    class="material-icons-round cursor-move text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">drag_indicator</span>

                {{-- Preview de color --}}
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 rounded border border-gray-300 dark:border-gray-600 {{ $status->badgeClasses() }}">
                    </div>
                </div>

                {{-- Badge de color --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            {{ $status->name }}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-medium {{ $status->badgeClasses() }}">
                            {{ $status->slug }}
                        </span>
                        @if($status->is_default)
                            <span
                                class="text-[10px] bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200 px-2 py-0.5 rounded font-medium">
                                {{ __('Por Defecto') }}
                            </span>
                        @endif
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        {{ $status->clientRequests()->count() }} {{ __('solicitudes') }}
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="flex items-center gap-1">
                    <flux:button wire:click="editStatus({{ $status->id }})" type="button" variant="ghost" icon="pencil"
                        size="xs">
                    </flux:button>

                    @if($status->clientRequests()->count() === 0)
                        <flux:button wire:click="deleteStatus({{ $status->id }})" type="button" variant="ghost" icon="trash"
                            size="xs" class="text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20">
                        </flux:button>
                    @else
                        <div class="w-6 h-6 flex items-center justify-center"
                            title="{{ __('No se puede eliminar: tiene solicitudes asociadas') }}">
                            <span class="material-icons-round text-gray-300 text-sm">block</span>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-6 text-gray-500">
                {{ __('No se encontraron estados.') }}
            </div>
        @endforelse
    </div>
</div>