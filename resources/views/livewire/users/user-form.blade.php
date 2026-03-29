<div class="h-full w-full flex-1 flex flex-col gap-4 rounded-xl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                {{ $user ? __('Edit User') : __('Create New User') }}
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ $user ? __('Update user details and role assignments.') : __('Onboard a new user and assign roles.') }}
            </p>
        </div>
    </div>

    <div
        class="bg-white dark:bg-sidebar-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <form wire:submit="save" class="space-y-6">

                {{-- Profile Photo --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        {{ __('Profile Photo') }}
                    </label>
                    <div class="flex items-center gap-5">
                        {{-- Avatar preview --}}
                        <div class="shrink-0">
                            @if ($photo)
                                <img src="{{ $photo->temporaryUrl() }}"
                                    class="w-20 h-20 rounded-full object-cover border-2 border-primary shadow"
                                    alt="{{ __('Preview') }}">
                            @elseif ($currentPhotoPath)
                                <img src="{{ Storage::disk('public')->url($currentPhotoPath) }}"
                                    class="w-20 h-20 rounded-full object-cover border-2 border-primary shadow"
                                    alt="{{ $name }}">
                            @else
                                <div
                                    class="w-20 h-20 rounded-full bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center border-2 border-gray-200 dark:border-gray-700 shadow">
                                    <span class="text-xl font-bold text-indigo-700 dark:text-indigo-300 uppercase">
                                        {{ $name ? mb_strtoupper(mb_substr($name, 0, 1)) : '?' }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex flex-col gap-2">
                            <label for="photo-upload"
                                class="cursor-pointer inline-flex items-center gap-2 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-sidebar-dark hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                </svg>
                                {{ __('Upload photo') }}
                            </label>
                            <input id="photo-upload" type="file" wire:model="photo" accept="image/*" class="hidden">

                            @if ($currentPhotoPath && !$photo)
                                <flux:button type="button" wire:click="removePhoto" variant="danger" size="xs" icon="trash">
                                    {{ __('Remove photo') }}
                                </flux:button>
                            @endif
                        </div>
                    </div>
                    @error('photo') <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span> @enderror

                    {{-- Upload progress indicator --}}
                    <div wire:loading wire:target="photo"
                        class="mt-2 text-sm text-blue-500 dark:text-blue-400 flex items-center gap-1">
                        <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        {{ __('Uploading...') }}
                    </div>
                </div>

                <div>
                    <label for="name"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Name') }}</label>
                    <input type="text" id="name" wire:model="name" placeholder="John Doe"
                        class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                    @error('name') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="email"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Email') }}</label>
                    <input type="email" id="email" wire:model="email" placeholder="john@example.com"
                        class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                    @error('email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="language"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Language') }}</label>
                    <select id="language" wire:model="language"
                        class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                        <option value="es">{{ __('Spanish') }}</option>
                        <option value="en">{{ __('English') }}</option>
                    </select>
                    @error('language') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="client_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Associated Client') }}</label>
                    <select id="client_id" wire:model="client_id"
                        class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                        <option value="">{{ __('None (Internal User)') }}</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                        @endforeach
                    </select>
                    @error('client_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ $user ? __('Password (leave blank to keep current)') : __('Password') }}
                    </label>
                    <div class="relative">
                        <input type="{{ $showPassword ? 'text' : 'password' }}" id="password" wire:model="password"
                            class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm pr-10">
                        <flux:button type="button" wire:click="togglePasswordVisibility" variant="ghost" size="xs"
                            icon="{{ $showPassword ? 'eye' : 'eye-slash' }}" class="absolute inset-y-0 right-0 px-3">
                        </flux:button>
                    </div>
                    @error('password') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="roles"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('Assign Roles') }}</label>
                    <select id="roles" wire:model="selectedRoles" multiple
                        class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm h-32">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        {{ __('Hold Ctrl (Windows) or Command (Mac) to select multiple roles.') }}
                    </p>
                </div>

                <div class="flex justify-end gap-3 py-3 border-t border-gray-200 dark:border-gray-700">
                    <flux:button href="{{ route('users.index') }}" variant="ghost">
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