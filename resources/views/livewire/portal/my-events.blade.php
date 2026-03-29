<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">Mis Eventos</flux:heading>
            <flux:subheading>Eventos a los que has sido invitado.</flux:subheading>
        </div>
        <div class="flex gap-2">
            <flux:button :variant="$filter === 'upcoming' ? 'primary' : 'ghost'" wire:click="$set('filter', 'upcoming')"
                size="sm">
                Próximos
            </flux:button>
            <flux:button :variant="$filter === 'past' ? 'primary' : 'ghost'" wire:click="$set('filter', 'past')"
                size="sm">
                Pasados
            </flux:button>
        </div>
    </div>

    @if($events->count() > 0)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($events as $event)
                <div
                    class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5 flex flex-col gap-3">
                    {{-- Event type badge --}}
                    @if($event->eventType)
                        <flux:badge size="sm" color="purple">{{ $event->eventType->name }}</flux:badge>
                    @endif

                    <h3 class="text-sm font-semibold text-zinc-800 dark:text-zinc-200 leading-tight">
                        {{ $event->title }}
                    </h3>

                    @if($event->description)
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-2">
                            {{ $event->description }}
                        </p>
                    @endif

                    <div class="flex flex-col gap-1.5 mt-auto">
                        <div class="flex items-center gap-2 text-xs text-zinc-600 dark:text-zinc-400">
                            <flux:icon name="calendar" class="size-3.5 shrink-0 text-sky-500" />
                            <span>{{ $event->start_datetime->format('d/m/Y') }}</span>
                            <span>{{ $event->start_datetime->format('H:i') }}
                                @if($event->end_datetime)
                                    – {{ $event->end_datetime->format('H:i') }}
                                @endif
                            </span>
                        </div>
                        @if($event->location)
                            <div class="flex items-center gap-2 text-xs text-zinc-600 dark:text-zinc-400">
                                <flux:icon name="map-pin" class="size-3.5 shrink-0 text-rose-400" />
                                {{ $event->location }}
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 py-16 text-center">
            <flux:icon name="calendar" class="size-10 text-zinc-300 dark:text-zinc-600 mx-auto mb-3" />
            <p class="text-zinc-500">
                {{ $filter === 'upcoming' ? 'No tienes eventos próximos.' : 'No hay eventos pasados.' }}
            </p>
        </div>
    @endif
</div>