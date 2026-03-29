<div class="max-w-2xl mx-auto space-y-6">
    <div>
        <flux:heading size="xl">Mi Perfil</flux:heading>
        <flux:subheading>Actualiza tu información personal y credenciales.</flux:subheading>
    </div>

    @if($successMessage)
        <flux:callout variant="success" icon="check-circle" class="mb-4">
            {{ $successMessage }}
        </flux:callout>
    @endif

    {{-- Section tabs --}}
    <div class="flex gap-2 border-b border-zinc-200 dark:border-zinc-700">
        <button wire:click="$set('activeSection', 'profile')" class="pb-2 px-1 text-sm font-medium border-b-2 transition-colors
                {{ $activeSection === 'profile'
    ? 'border-sky-500 text-sky-600 dark:text-sky-400'
    : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
            Información Personal
        </button>
        <button wire:click="$set('activeSection', 'password')" class="pb-2 px-1 text-sm font-medium border-b-2 transition-colors
                {{ $activeSection === 'password'
    ? 'border-sky-500 text-sky-600 dark:text-sky-400'
    : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
            Cambiar Contraseña
        </button>
    </div>

    {{-- Profile info section --}}
    @if($activeSection === 'profile')
        <form wire:submit="updateProfile"
            class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 space-y-5">

            {{-- Photo preview --}}
            <div class="flex items-center gap-5">
                <div class="relative">
                    @if($photo)
                        <img src="{{ $photo->temporaryUrl() }}" alt="Preview"
                            class="w-20 h-20 rounded-full object-cover ring-2 ring-sky-400">
                    @elseif(auth()->user()->profile_photo_url)
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}"
                            class="w-20 h-20 rounded-full object-cover">
                    @else
                        <span
                            class="flex w-20 h-20 rounded-full bg-zinc-200 dark:bg-zinc-700 items-center justify-center text-2xl font-bold text-zinc-600 dark:text-zinc-300">
                            {{ auth()->user()->initials() }}
                        </span>
                    @endif
                </div>
                <div class="flex flex-col gap-1">
                    <flux:label>Foto de perfil</flux:label>
                    <input type="file" wire:model="photo" accept="image/*" class="text-sm text-zinc-600 dark:text-zinc-400
                                      file:mr-3 file:py-1.5 file:px-4 file:rounded-lg file:border-0
                                      file:text-sm file:font-medium file:bg-zinc-100 dark:file:bg-zinc-800
                                      file:text-zinc-700 dark:file:text-zinc-300 hover:file:bg-zinc-200 cursor-pointer">
                    <flux:error name="photo" />
                </div>
            </div>

            <flux:field>
                <flux:label>Nombre Completo *</flux:label>
                <flux:input wire:model="name" />
                <flux:error name="name" />
            </flux:field>

            <flux:field>
                <flux:label>Correo Electrónico</flux:label>
                <flux:input value="{{ $email }}" disabled class="opacity-60" />
                <flux:description>El correo no puede modificarse desde el portal.</flux:description>
            </flux:field>

            <flux:button type="submit" variant="primary">Guardar Cambios</flux:button>
        </form>
    @endif

    {{-- Password section --}}
    @if($activeSection === 'password')
        <form wire:submit="updatePassword"
            class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 space-y-5">

            <flux:field>
                <flux:label>Contraseña Actual *</flux:label>
                <flux:input wire:model="current_password" type="password" autocomplete="current-password" />
                <flux:error name="current_password" />
            </flux:field>

            <flux:field>
                <flux:label>Nueva Contraseña *</flux:label>
                <flux:input wire:model="password" type="password" autocomplete="new-password" />
                <flux:error name="password" />
            </flux:field>

            <flux:field>
                <flux:label>Confirmar Nueva Contraseña *</flux:label>
                <flux:input wire:model="password_confirmation" type="password" autocomplete="new-password" />
            </flux:field>

            <flux:button type="submit" variant="primary">Cambiar Contraseña</flux:button>
        </form>
    @endif
</div>