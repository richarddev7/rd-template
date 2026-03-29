<div class="h-full w-full flex-1 flex flex-col gap-4 rounded-xl">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight dark:text-gray-100">{{ __('Dashboard') }}</h2>
            <p class="text-slate-500 text-sm mt-1 dark:text-gray-400">
                {{ __('Welcome back') }}, {{ $user->name }}. {{ __('Check your latest updates.') }}
            </p>
        </div>
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-100 dark:bg-slate-800 rounded-lg">
                <span class="material-icons-round text-sm text-primary">calendar_today</span>
                <span class="text-xs font-bold text-slate-600 dark:text-slate-300">
                    {{ now()->translatedFormat('M d, Y') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-slate-200 dark:border-zinc-700 shadow-sm">
            <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Total Requests') }}</h3>
            <p class="text-3xl font-bold dark:text-white mt-2">{{ $requestsCount }}</p>
        </div>
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-slate-200 dark:border-zinc-700 shadow-sm">
            <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Total Clients') }}</h3>
            <p class="text-3xl font-bold dark:text-white mt-2">{{ $clientsCount }}</p>
        </div>
        @if($user->hasRole('Super Admin'))
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-slate-200 dark:border-zinc-700 shadow-sm">
                <h3 class="text-sm font-medium text-slate-500 dark:text-slate-400">{{ __('Total Users') }}</h3>
                <p class="text-3xl font-bold dark:text-white mt-2">{{ $usersCount }}</p>
            </div>
        @endif
    </div>

    <!-- Mis Solicitudes - Card Grid -->
    <section>
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold dark:text-white flex items-center gap-2">
                <span class="material-icons-round text-primary text-xl">assignment</span>
                {{ __('Recent Requests') }}
            </h3>
            <a href="{{ route('client-requests.index') }}"
                class="text-sm font-medium text-primary hover:underline">{{ __('View All') }}</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($recentRequests as $request)
                @php
                    $reqStatusColor = match(strtolower($request->status->name ?? 'pending')) {
                        'pendiente', 'pending', 'draft' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                        'aprobada', 'approved', 'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                        'rechazada', 'rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                        'en proceso', 'in_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                        default => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                    };
                @endphp
                <a href="{{ route('client-requests.show', $request) }}" wire:navigate
                    class="block bg-white dark:bg-zinc-900 p-5 rounded-xl border border-slate-200 dark:border-zinc-700 shadow-sm hover:shadow-md hover:border-primary/30 transition-all group">
                    <div class="flex justify-between items-start mb-2">
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium {{ $reqStatusColor }}">
                            {{ $request->status->name ?? __('Pending') }}
                        </span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">#{{ $request->id }}</span>
                    </div>
                    <h4 class="font-semibold text-slate-800 dark:text-white mb-1 truncate group-hover:text-primary transition-colors">{{ $request->title }}</h4>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-4 line-clamp-2">
                        {{ $request->client->name ?? __('Unknown Client') }}
                    </p>
                    <div class="flex items-center justify-between text-xs text-slate-500 dark:text-slate-400 pt-3 border-t border-slate-200 dark:border-zinc-700">
                        <span class="flex items-center gap-1">
                            <span class="material-icons-round text-sm">schedule</span>
                            {{ $request->created_at->diffForHumans() }}
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-white dark:bg-zinc-900 p-8 rounded-xl border border-slate-200 dark:border-zinc-700 text-center text-slate-400 text-sm">
                    {{ __('No recent requests found.') }}
                </div>
            @endforelse
        </div>
    </section>
</div>
