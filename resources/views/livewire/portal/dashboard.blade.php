<div class="space-y-6">
    {{-- Page title --}}
    <div>
        <flux:heading size="xl">Dashboard</flux:heading>
        <flux:subheading>Bienvenido, {{ $this->user->name }}. Aquí está el resumen de tu cuenta.</flux:subheading>
    </div>

    {{-- Stats cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div
            class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5 flex flex-col gap-1">
            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Total
                Solicitudes</span>
            <span class="text-3xl font-bold text-zinc-900 dark:text-white">{{ $this->requestsTotal }}</span>
        </div>
        <div
            class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5 flex flex-col gap-1">
            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">En Proceso</span>
            <span class="text-3xl font-bold text-sky-500">{{ $this->requestsInProgress }}</span>
        </div>
        <div
            class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5 flex flex-col gap-1">
            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Tareas
                Activas</span>
            <span class="text-3xl font-bold text-amber-500">{{ $this->tasksActive }}</span>
        </div>
        <div
            class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5 flex flex-col gap-1">
            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide">Eventos
                Próximos</span>
            <span class="text-3xl font-bold text-emerald-500">{{ $this->eventsUpcoming }}</span>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        {{-- Recent requests table --}}
        <div class="md:col-span-2 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="sm">Solicitudes Recientes</flux:heading>
                <flux:button variant="ghost" size="sm" href="{{ route('portal.requests') }}" wire:navigate>Ver todas
                </flux:button>
            </div>
            @forelse($this->recentRequests as $request)
                <div
                    class="flex items-center justify-between py-3 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                    <div>
                        <p class="text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ $request->title }}</p>
                        <p class="text-xs text-zinc-500">{{ $request->request_date?->format('d/m/Y') }}</p>
                    </div>
                    @if($request->status)
                        <flux:badge size="sm" color="blue">{{ $request->status->name }}</flux:badge>
                    @endif
                </div>
            @empty
                <p class="text-sm text-zinc-500 py-4 text-center">Aún no tienes solicitudes.</p>
            @endforelse
        </div>

        {{-- Upcoming events --}}
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-5">
            <div class="flex items-center justify-between mb-4">
                <flux:heading size="sm">Próximos Eventos</flux:heading>
                <flux:button variant="ghost" size="sm" href="{{ route('portal.events') }}" wire:navigate>Ver todos
                </flux:button>
            </div>
            @forelse($upcomingEvents as $event)
                <div class="flex flex-col gap-1 py-3 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
                    <p class="text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ $event->title }}</p>
                    <div class="flex items-center gap-2 text-xs text-zinc-500">
                        <flux:icon name="calendar" class="size-3.5" />
                        {{ $event->start_datetime->format('d/m/Y H:i') }}
                    </div>
                    @if($event->location)
                        <div class="flex items-center gap-2 text-xs text-zinc-500">
                            <flux:icon name="map-pin" class="size-3.5" />
                            {{ $event->location }}
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-sm text-zinc-500 py-4 text-center">No tienes eventos próximos.</p>
            @endforelse
        </div>
    </div>
</div>