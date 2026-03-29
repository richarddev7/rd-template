<div class="h-full w-full flex-1 flex flex-col gap-4 rounded-xl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">{{ __('Roles') }}</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Manage user roles and permissions') }}</p>
        </div>
        <flux:button href="{{ route('roles.create') }}" variant="primary" icon="plus">
            {{ __('Create Role') }}
        </flux:button>
    </div>

    <div class="mb-6">
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center p-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input wire:model.live.debounce.300ms="search"
                class="block w-full pl-10 px-10 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm"
                placeholder="{{ __('Search roles...') }}" type="text" />
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
                            scope="col">{{ __('Permissions') }}</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-sidebar-dark divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($roles as $role)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $role->name }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($role->permissions->take(5) as $permission)
                                        <span
                                            class="text-sm font-medium text-blue-600 dark:text-blue-400 cursor-pointer hover:underline">{{ $permission->name }}</span>
                                        @if(!$loop->last)<span
                                        class="text-gray-300 dark:text-gray-600 select-none">•</span>@endif
                                    @endforeach
                                    @if($role->permissions->count() > 5)
                                        <span class="text-gray-300 dark:text-gray-600 select-none">•</span>
                                        <span
                                            class="text-sm font-medium text-gray-500 dark:text-gray-400 pointer-events-none">+{{ $role->permissions->count() - 5 }}
                                            more</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button href="{{ route('roles.edit', $role) }}" variant="ghost" size="xs"
                                        icon="pencil">
                                        {{ __('Edit') }}
                                    </flux:button>
                                    @if($role->name !== 'Super Admin')
                                        <flux:button wire:click="delete({{ $role->id }})"
                                            wire:confirm="{{ __('Are you sure you want to delete this role?') }}"
                                            variant="danger" size="xs" icon="trash">
                                            {{ __('Delete') }}
                                        </flux:button>
                                    @else
                                        <flux:button variant="subtle" size="xs" icon="lock-closed" disabled>
                                            {{ __('Protected') }}
                                        </flux:button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                {{ __('No roles found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 dark:bg-slate-800/50 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
            {{ $roles->links() }}
        </div>
    </div>
</div>