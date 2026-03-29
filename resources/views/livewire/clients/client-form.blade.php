<div class="max-w-7xl mx-auto px-6 py-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                {{ $client ? __('Edit Client') : __('Create New Client') }}
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ $client ? __('Update client information') : __('Add a new client to your system') }}
            </p>
        </div>
    </div>

    <div
        class="bg-white dark:bg-sidebar-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-3">
            <form wire:submit="save" class="space-y-6">
                <div>
                    <label for="name"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Client Name') }}</label>
                    <input type="text" id="name" wire:model="name" placeholder="{{ __('Acme Corporation') }}"
                        class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                    @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="email"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Email') }}</label>
                    <input type="email" id="email" wire:model="email" placeholder="{{ __('contact@example.com') }}"
                        class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                    @error('email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="phone"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Phone') }}</label>
                    <input type="text" id="phone" wire:model="phone" placeholder="{{ __('+1 (555) 123-4567') }}"
                        class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                    @error('phone') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="address"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Address') }}</label>
                    <textarea id="address" wire:model="address" rows="3"
                        placeholder="{{ __('123 Main Street, City, Country') }}"
                        class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm"></textarea>
                    @error('address') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="notes"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Notes') }}</label>
                    <textarea id="notes" wire:model="notes" rows="4"
                        placeholder="{{ __('Additional information about this client...') }}"
                        class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm"></textarea>
                    @error('notes') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="is_active" wire:model="is_active"
                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="is_active" class="ms-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Active') }}
                    </label>
                    @error('is_active') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end gap-3 py-3 border-t border-gray-200 dark:border-gray-700">
                    <flux:button href="{{ route('clients.index') }}" variant="ghost">
                        {{ __('Cancel') }}
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        {{ __('Save Changes') }}
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>