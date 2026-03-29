<div>
    {{-- Search Trigger --}}
    <flux:modal.trigger name="search">
        <button type="button"
            class="flex items-center w-full px-3 py-2 text-sm text-zinc-600 dark:text-zinc-400 bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
            <flux:icon.magnifying-glass variant="mini" class="mr-2 text-zinc-400" />
            <span class="flex-1 text-left">{{ __('Buscar...') }}</span>
        </button>
    </flux:modal.trigger>

    {{-- Search Modal --}}
    @teleport('body')
    <flux:modal name="search" variant="bare" class="w-full max-w-[28rem] my-[10vh]">
        <div
            class="flex flex-col h-full bg-white dark:bg-zinc-900 rounded-xl shadow-2xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
            {{-- Search Input --}}
            <div class="relative shrink-0 border-b border-zinc-200 dark:border-zinc-800">
                <flux:icon.magnifying-glass class="absolute left-6 top-5 text-zinc-400 dark:text-zinc-500"
                    variant="mini" />
                <input type="text" wire:model.live.debounce.300ms="query"
                    placeholder="{{ __('Buscar clientes o solicitudes...') }}"
                    class="w-full h-16 pl-14 pr-12 bg-transparent border-none focus:ring-0 text-base placeholder-zinc-400 dark:placeholder-zinc-500 text-zinc-900 dark:text-zinc-100 font-medium"
                    x-init="setTimeout(() => $el.focus(), 100)" autofocus />
                @if($query)
                    <button wire:click="clearSearch"
                        class="absolute right-6 top-5 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                        <flux:icon.x-mark variant="mini" />
                    </button>
                @endif
            </div>

            {{-- Results Area --}}
            <div class="flex-1 max-h-[60vh] overflow-y-auto p-2 scroll-py-2 custom-scrollbar">

                {{-- Clients Results --}}
                @if(isset($results['clients']) && count($results['clients']) > 0)
                    <div
                        class="px-2 pt-3 pb-1 text-[10px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider flex items-center">
                        {{ __('Clientes') }}
                    </div>
                    @foreach($results['clients'] as $client)
                        <a href="{{ $client['url'] }}" wire:navigate
                            class="flex items-center px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800/50 transition-colors group">
                            <flux:icon.building-office-2 class="mr-3 text-zinc-400 group-hover:text-green-500 transition-colors"
                                variant="mini" />
                            <div class="flex-1 flex flex-col">
                                <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $client['name'] }}</span>
                                <span
                                    class="text-xs text-zinc-500 dark:text-zinc-400">{{ $client['contact_person'] ?? $client['email'] }}</span>
                            </div>
                            @if($client['is_active'])
                                <div class="w-1.5 h-1.5 rounded-full bg-green-500"></div>
                            @endif
                        </a>
                    @endforeach
                @endif

                {{-- Solicitudes Results --}}
                @if(isset($results['solicitudes']) && count($results['solicitudes']) > 0)
                    <div
                        class="px-2 pt-3 pb-1 text-[10px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider flex items-center">
                        {{ __('Solicitudes') }}
                    </div>
                    @foreach($results['solicitudes'] as $solicitud)
                        <a href="{{ $solicitud['url'] }}" wire:navigate
                            class="flex items-center px-3 py-2.5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800/50 transition-colors group">
                            <flux:icon.document-text class="mr-3 text-zinc-400 group-hover:text-amber-500 transition-colors"
                                variant="mini" />
                            <div class="flex-1 flex flex-col min-w-0">
                                <span
                                    class="text-sm font-medium text-zinc-900 dark:text-zinc-100 truncate">{{ $solicitud['title'] }}</span>
                                <span class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ $solicitud['client'] }} •
                                    {{ $solicitud['status'] }}</span>
                            </div>
                        </a>
                    @endforeach
                @endif

                {{-- No Results --}}
                @if(
                        $query &&
                        (!isset($results['clients']) || count($results['clients']) === 0) &&
                        (!isset($results['solicitudes']) || count($results['solicitudes']) === 0)
                    )
                    <div class="px-4 py-12 text-center text-zinc-500 dark:text-zinc-400">
                        <flux:icon.magnifying-glass class="mx-auto mb-3 h-8 w-8 text-zinc-300 dark:text-zinc-600"
                            variant="mini" />
                        <p>{{ __('No se encontraron resultados para') }} "{{ $query }}"</p>
                    </div>
                @endif
            </div>
        </div>
    </flux:modal>
    @endteleport
</div>