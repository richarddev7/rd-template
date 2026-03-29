<div class="h-full w-full flex-1 flex flex-col gap-4 rounded-xl">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 ">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                    {{ __('Application Settings') }}
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('Configure logo, colors, language, and registration settings.') }}
                </p>
            </div>
        </div>

        {{-- Success Message --}}
        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
                <p class="text-sm font-medium text-green-800 dark:text-green-200">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        {{-- Settings Form --}}
        <div
            class="bg-white dark:bg-sidebar-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6">
                <form wire:submit="save" class="space-y-8">

                    {{-- Section 1: Application Identity --}}
                    <div class="space-y-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ __('Application Identity') }}
                        </h2>

                        {{-- App Name --}}
                        <flux:field>
                            <flux:label>{{ __('Application Name') }}</flux:label>
                            <flux:input wire:model="appName" placeholder="RD Task Manager" />
                            <flux:error name="appName" />
                        </flux:field>

                        {{-- Logo Upload --}}
                        <div class="space-y-3">
                            <flux:label>{{ __('Application Logo') }}</flux:label>
                            <flux:description>{{ __('Upload a logo image (JPG, PNG, SVG - Max 2MB)') }}
                            </flux:description>

                            @if ($currentLogoPath)
                                <div class="flex items-center gap-4">
                                    <img src="{{ Storage::url($currentLogoPath) }}" alt="Current Logo"
                                        class="h-16 w-auto object-contain border border-gray-200 dark:border-gray-700 rounded-lg p-2 bg-white dark:bg-gray-800">
                                    <flux:button type="button" wire:click="removeLogo" variant="ghost" icon="trash"
                                        size="sm">
                                        {{ __('Remove Logo') }}
                                    </flux:button>
                                </div>
                            @endif

                            @if ($logo)
                                <div class="flex items-center gap-4">
                                    <img src="{{ $logo->temporaryUrl() }}" alt="New Logo Preview"
                                        class="h-16 w-auto object-contain border border-green-200 dark:border-green-700 rounded-lg p-2 bg-green-50 dark:bg-green-900/20">
                                    <span
                                        class="text-sm text-green-600 dark:text-green-400">{{ __('New logo preview') }}</span>
                                </div>
                            @endif

                            <input type="file" wire:model="logo" accept="image/jpeg,image/png,image/svg+xml" class="block w-full text-sm text-gray-500 dark:text-gray-400
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-sky-50 file:text-sky-700 dark:file:bg-sky-900/30 dark:file:text-sky-400
                                      hover:file:bg-sky-100 dark:hover:file:bg-sky-900/50
                                      file:cursor-pointer cursor-pointer">

                            <flux:error name="logo" />
                            <div wire:loading wire:target="logo" class="text-sm text-gray-500">{{ __('Uploading...') }}
                            </div>
                        </div>

                        {{-- Favicon Upload --}}
                        <div class="space-y-3">
                            <flux:label>{{ __('Favicon') }}</flux:label>
                            <flux:description>{{ __('Upload a favicon (ICO, PNG, SVG - Max 512KB)') }}
                            </flux:description>

                            @if ($currentFaviconPath)
                                <div class="flex items-center gap-4">
                                    <img src="{{ Storage::url($currentFaviconPath) }}" alt="Current Favicon"
                                        class="h-8 w-8 object-contain border border-gray-200 dark:border-gray-700 rounded p-1 bg-white dark:bg-gray-800">
                                    <flux:button type="button" wire:click="removeFavicon" variant="ghost" icon="trash"
                                        size="sm">
                                        {{ __('Remove Favicon') }}
                                    </flux:button>
                                </div>
                            @endif

                            @if ($favicon)
                                <div class="flex items-center gap-4">
                                    <img src="{{ $favicon->temporaryUrl() }}" alt="New Favicon Preview"
                                        class="h-8 w-8 object-contain border border-green-200 dark:border-green-700 rounded p-1 bg-green-50 dark:bg-green-900/20">
                                    <span
                                        class="text-sm text-green-600 dark:text-green-400">{{ __('New favicon preview') }}</span>
                                </div>
                            @endif

                            <input type="file" wire:model="favicon" accept="image/x-icon,image/png,image/svg+xml" class="block w-full text-sm text-gray-500 dark:text-gray-400
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-sky-50 file:text-sky-700 dark:file:bg-sky-900/30 dark:file:text-sky-400
                                      hover:file:bg-sky-100 dark:hover:file:bg-sky-900/50
                                      file:cursor-pointer cursor-pointer">

                            <flux:error name="favicon" />
                            <div wire:loading wire:target="favicon" class="text-sm text-gray-500">
                                {{ __('Uploading...') }}
                            </div>
                        </div>
                    </div>

                    <flux:separator />

                    {{-- Section 2: Theme & Appearance --}}
                    <div class="space-y-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ __('Theme & Appearance') }}
                        </h2>

                        {{-- Primary Color --}}
                        <div class="space-y-2">
                            <flux:label>{{ __('Primary Theme Color') }}</flux:label>
                            <div class="flex items-center gap-4">
                                <input type="color" wire:model.live="themePrimaryColor"
                                    class="h-12 w-24 rounded-lg border border-gray-300 dark:border-gray-600 cursor-pointer">
                                <flux:input wire:model="themePrimaryColor" placeholder="#0ea5e9"
                                    class="flex-1 max-w-xs" />
                                <div class="h-12 w-12 rounded-lg border border-gray-300 dark:border-gray-600"
                                    style="background-color: {{ $themePrimaryColor }}"></div>
                            </div>
                            <flux:error name="themePrimaryColor" />
                        </div>

                        {{-- Background Color --}}
                        <div class="space-y-2">
                            <flux:label>{{ __('Background Color') }}</flux:label>
                            <div class="flex items-center gap-4">
                                <input type="color" wire:model.live="backgroundColor"
                                    class="h-12 w-24 rounded-lg border border-gray-300 dark:border-gray-600 cursor-pointer">
                                <flux:input wire:model="backgroundColor" placeholder="#ffffff"
                                    class="flex-1 max-w-xs" />
                                <div class="h-12 w-12 rounded-lg border border-gray-300 dark:border-gray-600"
                                    style="background-color: {{ $backgroundColor }}"></div>
                            </div>
                            <flux:error name="backgroundColor" />
                        </div>
                    </div>

                    <flux:separator />

                    {{-- Section 3: User Settings --}}
                    <div class="space-y-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                            {{ __('User Configuration') }}
                        </h2>

                        {{-- Registration Toggle --}}
                        <flux:field>
                            <div class="flex items-start gap-4">
                                <flux:switch wire:model="registrationEnabled" />
                                <div class="flex-1">
                                    <flux:label>{{ __('Enable User Registration') }}</flux:label>
                                    <flux:description>
                                        {{ __('Allow new users to create accounts from the login page.') }}
                                    </flux:description>
                                </div>
                            </div>
                        </flux:field>

                        {{-- Default Language --}}
                        <flux:field>
                            <flux:label>{{ __('Default Language') }}</flux:label>
                            <flux:description>
                                {{ __('Language shown to new users and visitors.') }}
                            </flux:description>
                            <flux:select wire:model="defaultLanguage" placeholder="{{ __('Choose language...') }}">
                                <flux:select.option value="es">{{ __('Spanish') }}</flux:select.option>
                                <flux:select.option value="en">{{ __('English') }}</flux:select.option>
                            </flux:select>
                            <flux:error name="defaultLanguage" />
                        </flux:field>
                    </div>

                    <flux:separator />

                    {{-- Save Button --}}
                    <div class="flex justify-end">
                        <flux:button type="submit" variant="primary" icon="check-circle">
                            {{ __('Save Settings') }}
                        </flux:button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Advanced Settings Section (Outside Form) --}}
        <div
            class="bg-white dark:bg-sidebar-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mt-6">
            <div class="p-6">
                <div class="space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">
                        {{ __('Advanced Settings') }}
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                        {{-- Request Status Management Card --}}
                        <button type="button" @click="$flux.modal('request-status-modal').show()"
                            class="group relative flex flex-col items-center justify-center p-6 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-green-500 dark:hover:border-green-400 hover:shadow-md transition-all duration-200 text-center space-y-3 cursor-pointer">
                            <div
                                class="p-3 bg-green-50 dark:bg-green-900/20 rounded-full group-hover:bg-green-100 dark:group-hover:bg-green-900/40 transition-colors">
                                <span class="material-icons-round text-3xl text-green-500">assignment</span>
                            </div>
                            <div>
                                <h3
                                    class="font-medium text-gray-900 dark:text-white group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                    {{ __('Request Statuses') }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                    {{ __('Manage client request statuses') }}
                                </p>
                            </div>
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-md bg-gray-100 dark:bg-gray-800 text-xs font-medium text-gray-600 dark:text-gray-300">
                                {{ \App\Models\RequestStatus::count() }} {{ __('statuses') }}
                            </span>
                        </button>

                        {{-- Test Email Card --}}
                        <button type="button" @click="$flux.modal('test-email-modal').show()"
                            class="group relative flex flex-col items-center justify-center p-6 bg-white dark:bg-slate-800 rounded-xl border border-gray-200 dark:border-gray-700 hover:border-purple-500 dark:hover:border-purple-400 hover:shadow-md transition-all duration-200 text-center space-y-3 cursor-pointer">
                            <div
                                class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-full group-hover:bg-purple-100 dark:group-hover:bg-purple-900/40 transition-colors">
                                <span class="material-icons-round text-3xl text-purple-500">send</span>
                            </div>
                            <div>
                                <h3
                                    class="font-medium text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                                    {{ __('Test Email') }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-2">
                                    {{ __('Validate email sending configuration') }}
                                </p>
                            </div>
                            <span
                                class="inline-flex items-center px-2 py-1 rounded-md bg-purple-100 dark:bg-purple-900/30 text-xs font-medium text-purple-600 dark:text-purple-300">
                                {{ strtoupper(config('mail.default')) }}
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modals - wrapped in wire:ignore due to Flux teleportation --}}
        
        <flux:modal name="request-status-modal" class="!max-w-4xl">
            <livewire:settings.request-statuses />
        </flux:modal>

        {{-- Test Email Modal --}}
        <flux:modal name="test-email-modal" class="!max-w-lg">
            <div class="space-y-6 p-1">
                {{-- Modal Header --}}
                <div>
                    <flux:heading size="lg">{{ __('Send Test Email') }}</flux:heading>
                    <flux:subheading>{{ __('Send a test email to verify your SMTP configuration.') }}</flux:subheading>
                </div>

                {{-- Current config info --}}
                <div class="grid grid-cols-2 gap-3 p-4 bg-gray-50 dark:bg-slate-700/40 rounded-lg text-sm">
                    <div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('Mailer') }}</span>
                        <p class="font-medium text-gray-800 dark:text-gray-200 mt-1">{{ strtoupper(config('mail.default')) }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('Host') }}</span>
                        <p class="font-medium text-gray-800 dark:text-gray-200 mt-1">{{ config('mail.mailers.' . config('mail.default') . '.host', 'N/A') }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('Port') }}</span>
                        <p class="font-medium text-gray-800 dark:text-gray-200 mt-1">{{ config('mail.mailers.' . config('mail.default') . '.port', 'N/A') }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">{{ __('From') }}</span>
                        <p class="font-medium text-gray-800 dark:text-gray-200 mt-1 truncate">{{ config('mail.from.address') }}</p>
                    </div>
                </div>

                {{-- Email input --}}
                <flux:field>
                    <flux:label>{{ __('Destination Email') }}</flux:label>
                    <flux:description>{{ __('Enter the email address where you want to receive the test.') }}</flux:description>
                    <flux:input
                        wire:model="testEmailAddress"
                        type="email"
                        placeholder="you@example.com"
                        icon="envelope"
                    />
                    <flux:error name="testEmailAddress" />
                </flux:field>

                {{-- Feedback --}}
                @if ($testEmailStatus === 'success')
                    <div class="flex items-start gap-3 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg">
                        <span class="material-icons-round text-green-500 text-xl mt-0.5">check_circle</span>
                        <p class="text-sm text-green-800 dark:text-green-200">{{ $testEmailMessage }}</p>
                    </div>
                @elseif ($testEmailStatus === 'error')
                    <div class="flex items-start gap-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg">
                        <span class="material-icons-round text-red-500 text-xl mt-0.5">error</span>
                        <p class="text-sm text-red-800 dark:text-red-200">{{ $testEmailMessage }}</p>
                    </div>
                @endif

                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <flux:button
                        type="button"
                        variant="ghost"
                        @click="$flux.modal('test-email-modal').close(); $wire.set('testEmailStatus', null); $wire.set('testEmailAddress', '')"
                    >
                        {{ __('Close') }}
                    </flux:button>
                    <flux:button
                        type="button"
                        variant="primary"
                        icon="paper-airplane"
                        wire:click="sendTestEmail"
                        wire:loading.attr="disabled"
                        wire:target="sendTestEmail"
                    >
                        <span wire:loading.remove wire:target="sendTestEmail">{{ __('Send Test Email') }}</span>
                        <span wire:loading wire:target="sendTestEmail">{{ __('Sending...') }}</span>
                    </flux:button>
                </div>
            </div>
        </flux:modal>


    </div>
