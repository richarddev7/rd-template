<div class="h-full w-full flex-1 flex flex-col gap-4 rounded-xl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">{{ __('Users') }}</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('Manage users and their roles') }}</p>
        </div>
        <flux:button href="{{ route('users.create') }}" variant="primary" icon="plus">
            {{ __('Create User') }}
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
                placeholder="{{ __('Search users...') }}" type="text" />
        </div>
        <div class="w-full sm:w-1/3">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 p-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </div>
                <select wire:model.live="roleFilter"
                    class="block w-full pl-10 py-3 p-8 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm appearance-none">
                    <option value="">{{ __('All Roles') }}</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
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
                            scope="col">{{ __('Name') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">{{ __('Email') }}</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">{{ __('Roles') }}</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400"
                            scope="col">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-sidebar-dark divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    {{-- Avatar --}}
                                    @if ($user->profile_photo_path)
                                        <img src="{{ Storage::disk('public')->url($user->profile_photo_path) }}"
                                            alt="{{ $user->name }}"
                                            class="w-9 h-9 rounded-full object-cover shrink-0 border border-gray-200 dark:border-gray-700 shadow-sm">
                                    @else
                                        <div
                                            class="w-9 h-9 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center shrink-0 border border-gray-200 dark:border-gray-700 shadow-sm">
                                            <span class="text-xs font-bold text-indigo-700 dark:text-indigo-300 uppercase">
                                                {{ $user->initials() }}
                                            </span>
                                        </div>
                                    @endif
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->email }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($user->roles as $role)
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <flux:button href="{{ route('users.edit', $user) }}" variant="ghost" size="xs"
                                        icon="pencil">
                                        {{ __('Edit') }}
                                    </flux:button>
                                    @if($user->id !== auth()->id())
                                        <flux:button wire:click="delete({{ $user->id }})"
                                            wire:confirm="{{ __('Are you sure you want to delete this user?') }}"
                                            variant="danger" size="xs" icon="trash">
                                            {{ __('Delete') }}
                                        </flux:button>
                                    @else
                                        <flux:button variant="subtle" size="xs" icon="user" disabled>
                                            {{ __('You') }}
                                        </flux:button>
                                    @endif
                                    @can('edit users')
                                        <flux:button wire:click="confirmPasswordChange({{ $user->id }})" variant="ghost"
                                            size="xs" icon="key">
                                            {{ __('Password') }}
                                        </flux:button>
                                    @endcan
                                    @if(auth()->user()->isSuperAdmin() && $user->id !== auth()->id())
                                        <form method="POST" action="{{ route('impersonate.start', $user) }}" class="inline">
                                            @csrf
                                            <flux:button type="submit" variant="primary" size="xs" icon="user-circle">
                                                {{ __('Login as') }}
                                            </flux:button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                {{ __('No users found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="bg-gray-50 dark:bg-slate-800/50 px-6 py-3 border-t border-gray-200 dark:border-gray-700">
            {{ $users->links() }}
        </div>
    </div>

    {{-- Password Update Modal --}}
    <flux:modal name="password-update" :open="$showPasswordModal" wire:model="showPasswordModal">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">{{ __('Update Password') }}</h2>
            @if($userToUpdate)
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                    {{ __('Updating password for') }} <strong>{{ $userToUpdate->name }}</strong>
                </p>
            @endif

            <div class="space-y-4">
                <flux:input wire:model="password" type="password" label="{{ __('New Password') }}" />
                <flux:input wire:model="password_confirmation" type="password" label="{{ __('Confirm Password') }}" />
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <flux:button wire:click="$set('showPasswordModal', false)" variant="ghost">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button wire:click="updatePassword" variant="primary">
                    {{ __('Update Password') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>