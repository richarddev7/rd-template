<div class="max-w-5xl mx-auto px-6 py-8">
    <div class="flex flex-col gap-1 mb-8">
        <nav class="flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
            <span class="hover:text-gray-700 dark:hover:text-gray-300 transition-colors">{{ __('Roles') }}</span>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-900 dark:text-white">{{ $role ? __('Edit') : __('Create') }}</span>
        </nav>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">
            {{ $role ? __('Edit Role') : __('Create New Role') }}
        </h1>
        <p class="text-gray-500 dark:text-gray-400">
            {{ __('Define a new role and configure its access permissions.') }}
        </p>
    </div>

    <div
        class="bg-white dark:bg-sidebar-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <form wire:submit="save" class="p-8">
            <div class="space-y-8">
                <!-- Role Details -->
                <div class="space-y-6">
                    <div>
                        <label for="name"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Role Name') }}</label>
                        <input type="text" id="name" wire:model="name" placeholder="Ej. Gerente de Proyecto"
                            class="block w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent transition-all shadow-sm">
                        @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="description"
                            class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Description') }}
                            <span class="text-gray-400 font-normal">({{ __('Optional') }})</span></label>
                        <textarea id="description" wire:model="description" rows="3"
                            placeholder="{{ __('Briefly describe the responsibilities of this role...') }}"
                            class="block w-full px-4 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent transition-all shadow-sm resize-none"></textarea>
                    </div>
                </div>

                <!-- Permissions Section -->
                <div class="pt-6 border-t border-gray-100 dark:border-gray-800">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ __('System Permissions') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                        {{ __('Select the permissions this role will have. You can select complete groups or individual permissions.') }}
                    </p>

                    <!-- Permissions Grid -->
                    <div class="space-y-3">
                        @foreach($permissions as $permission)
                            <label
                                class="flex items-center p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 cursor-pointer transition-all group">
                                <div class="flex items-center flex-1">
                                    <input type="checkbox" wire:model.live="selectedPermissions"
                                        value="{{ $permission->name }}"
                                        class="w-5 h-5 text-blue-600 bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded focus:ring-blue-500 dark:focus:ring-blue-600 focus:ring-2 cursor-pointer">
                                    <div class="ml-4 flex-1">
                                        <div class="font-semibold text-gray-900 dark:text-white capitalize">
                                            {{ str_replace('_', ' ', $permission->name) }}
                                        </div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                                            {{ __('Enable access for') }} {{ str_replace('_', ' ', $permission->name) }}
                                            {{ __('in the system.') }}
                                        </p>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                        @error('selectedPermissions')
                            <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-end gap-3 py-3 border-t border-gray-100 dark:border-gray-800 mt-6">
                <flux:button href="{{ route('roles.index') }}" variant="ghost">
                    {{ __('Cancel') }}
                </flux:button>
                <flux:button type="submit" variant="primary">
                    {{ $role ? __('Save Changes') : __('Save Role') }}
                </flux:button>
            </div>
        </form>
    </div>
</div>