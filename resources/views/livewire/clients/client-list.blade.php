<div class="h-full w-full flex-1 flex flex-col gap-4 rounded-xl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">{{ __('Clients') }}</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Manage your clients and their information') }}
            </p>
        </div>
        <flux:button href="{{ route('clients.create') }}" variant="primary" icon="plus">
            {{ __('Create Client') }}
        </flux:button>
    </div>

    <div class="mb-6 flex flex-col sm:flex-row gap-4">
        <div class="relative w-full sm:w-2/3">
            <div class="absolute inset-y-0 start-0 flex items-center p-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search"
                class="block w-full pl-10 px-10 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm"
                placeholder="{{ __('Search clients...') }}" type="text" />
        </div>
        <div class="w-full sm:w-1/3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 p-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </div>
                <select wire:model.live="statusFilter"
                    class="block w-full pl-10 py-3 p-8 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm appearance-none">
                    <option value="">{{ __('All Statuses') }}</option>
                    <option value="1">{{ __('Active') }}</option>
                    <option value="0">{{ __('Inactive') }}</option>
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
                            scope="col">{{ __('Name') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">{{ __('Email') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">{{ __('Phone') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">{{ __('Status') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">{{ __('Requests') }}</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-sidebar-dark divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($clients as $client)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->name }}</div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $client->email ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $client->phone ?? '-' }}
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($client->is_active)
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                        {{ __('Active') }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                        {{ __('Inactive') }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $client->requests_count }}
                                </span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @can('view clients')
                                        <flux:button href="{{ route('clients.show', $client) }}" variant="primary" size="xs"
                                            icon="eye">
                                            {{ __('View') }}
                                        </flux:button>
                                    @endcan
                                    @can('edit clients')
                                        <flux:button href="{{ route('clients.edit', $client) }}" variant="ghost" size="xs"
                                            icon="pencil">
                                            {{ __('Edit') }}
                                        </flux:button>
                                    @endcan
                                    @can('delete clients')
                                        <flux:button wire:click="confirmDelete({{ $client->id }})" variant="danger" size="xs"
                                            icon="trash">
                                            {{ __('Delete') }}
                                        </flux:button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                {{ __('No clients found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 dark:bg-slate-800/50 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
            {{ $clients->links() }}
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <flux:modal name="delete-client" :open="$showDeleteModal" wire:model="showDeleteModal">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Delete Client') }}</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                {{ __('Are you sure you want to delete this client? This action cannot be undone.') }}
            </p>
            <div class="flex justify-end gap-3">
                <flux:button wire:click="cancelDelete" variant="ghost">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button wire:click="delete" variant="danger">
                    {{ __('Delete') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>