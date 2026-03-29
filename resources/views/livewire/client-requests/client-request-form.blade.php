<div class="h-full w-full flex-1 flex flex-col gap-4 rounded-xl">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                {{ $clientRequest ? 'Editar Solicitud' : 'Crear Nueva Solicitud' }}
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ $clientRequest ? 'Actualizar información de la solicitud' : 'Agregar una nueva solicitud de cliente' }}
            </p>
        </div>
    </div>

    <div
        class="bg-white dark:bg-sidebar-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6">
            <form wire:submit="save" class="space-y-8">
                {{-- Sección 1: Información General --}}
                <div class="space-y-4">
                    <h3
                        class="text-lg font-medium text-gray-900 dark:text-white border-b pb-2 border-gray-200 dark:border-gray-700">
                        Información General
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Client Selection --}}
                        <div>
                            <label for="client_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cliente</label>
                            <select id="client_id" wire:model="client_id"
                                class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                                <option value="">Seleccione un cliente</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @endforeach
                            </select>
                            @error('client_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Status Selection --}}
                        <div>
                            <label for="status_id"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Estado
                                <span class="text-red-500">*</span></label>
                            <select id="status_id" wire:model="status_id"
                                class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                                <option value="">Seleccione un estado</option>
                                @foreach($requestStatuses as $status)
                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                @endforeach
                            </select>
                            @error('status_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Start Date --}}
                        <div>
                            <label for="start_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fecha
                                Inicial</label>
                            <input type="datetime-local" id="start_date" wire:model="start_date"
                                class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                            @error('start_date') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Deadline Date --}}
                        <div>
                            <label for="deadline_date"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Fecha
                                Límite</label>
                            <input type="datetime-local" id="deadline_date" wire:model="deadline_date"
                                class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                            @error('deadline_date') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Responsible --}}
                        <div>
                            <label for="responsible"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Responsable
                                <span class="text-red-500">*</span></label>
                            <input type="text" id="responsible" wire:model="responsible"
                                placeholder="Nombre de la persona que realiza la solicitud"
                                class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                            @error('responsible') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Assignees (Super Admin Only) --}}
                        @if(auth()->user()->hasRole('Super Admin'))
                            <div>
                                <label for="assigned_users"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Asignar a
                                    Usuarios</label>
                                <select id="assigned_users" wire:model="assigned_users" multiple size="4"
                                    class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                <p class="mt-1 text-xs text-gray-500">Mantén presionado Ctrl (Windows) o Command (Mac) para
                                    seleccionar múltiples.</p>
                                @error('assigned_users') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif

                        {{-- Email --}}
                        <div>
                            <label for="contact_email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Correo Electrónico
                            </label>
                            <input type="email" id="contact_email" wire:model="contact_email"
                                placeholder="correo@ejemplo.com"
                                class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                            @error('contact_email') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Phone --}}
                        <div>
                            <label for="contact_phone"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Teléfono
                            </label>
                            <input type="tel" id="contact_phone" wire:model="contact_phone"
                                placeholder="+58 412 1234567"
                                class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                            @error('contact_phone') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Source --}}
                        <div class="md:col-span-2">
                            <label for="source" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Fuente de la Solicitud
                            </label>
                            <input type="text" id="source" wire:model="source"
                                placeholder="Indique cómo llegó el cliente (Ej: Referido, Redes Sociales, Página Web)"
                                class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                            @error('source') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Title --}}
                        <div class="md:col-span-2">
                            <label for="title"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Título
                                <span class="text-red-500">*</span></label>
                            <input type="text" id="title" wire:model="title"
                                placeholder="Ingrese el título de la solicitud"
                                class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm">
                            @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Sección 2: Contexto --}}
                <div class="space-y-4">
                    <h3
                        class="text-lg font-medium text-gray-900 dark:text-white border-b pb-2 border-gray-200 dark:border-gray-700">
                        Detalles de la Consulta
                    </h3>

                    {{-- Context (Required) --}}
                    <div>
                        <label for="context"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Contexto de la
                            Solicitud
                            <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                            Por favor describa:<br>
                            • ¿Cuándo ocurrió? (fechas, periodos, horas si son relevantes)<br>
                            • ¿Cómo ocurrió? (forma, antecedentes, comunicaciones, acuerdos)<br>
                            • ¿Dónde ocurrió? (empresa, ciudad, área, jurisdicción)<br>
                            • ¿Por qué consulta ahora? (qué detonó la consulta)<br>
                            • ¿Qué le preocupa al cliente? (riesgo, conflicto, consecuencia)
                        </p>
                        <textarea id="context" wire:model="context" rows="6"
                            placeholder="Describa el contexto completo de la solicitud..."
                            class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm"></textarea>
                        @error('context') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Sección 3: Clasificación y Expectativas --}}
                <div class="space-y-4">
                    <h3
                        class="text-lg font-medium text-gray-900 dark:text-white border-b pb-2 border-gray-200 dark:border-gray-700">
                        Clasificación y Resultados Esperados
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Left Column: Request Types --}}
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 bg-gray-50 dark:bg-slate-800 p-2 rounded">
                                Tipo de Solicitud (seleccione una o más)
                            </label>
                            <div class="space-y-2 max-h-60 overflow-y-auto pr-2">
                                @foreach($availableRequestTypes as $key => $label)
                                    <div class="flex items-start">
                                        <input type="checkbox" id="request_type_{{ $key }}" wire:model="request_types"
                                            value="{{ $key }}"
                                            class="mt-1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="request_type_{{ $key }}"
                                            class="ms-2 text-sm text-gray-700 dark:text-gray-300">
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('request_types') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Right Column: Expected Results --}}
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3 bg-gray-50 dark:bg-slate-800 p-2 rounded">
                                ¿Qué espera lograr con nuestra asesoría?
                            </label>
                            <div class="space-y-2 max-h-60 overflow-y-auto pr-2">
                                @foreach($availableExpectedResults as $key => $label)
                                    <div class="flex items-start">
                                        <input type="checkbox" id="expected_result_{{ $key }}" wire:model="expected_results"
                                            value="{{ $key }}"
                                            class="mt-1 w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label for="expected_result_{{ $key }}"
                                            class="ms-2 text-sm text-gray-700 dark:text-gray-300">
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('expected_results') <span
                                class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Full width: Description --}}
                        <div class="md:col-span-2">
                            <label for="expected_result_description"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                ¿Qué está solicitando usted concretamente? (Producto o actuación jurídica específica que
                                usted
                                pide)
                            </label>
                            <textarea id="expected_result_description" wire:model="expected_result_description" rows="3"
                                placeholder="Describa lo que espera lograr..."
                                class="block w-full px-3 py-3 border border-gray-200 dark:border-gray-700 rounded-lg leading-5 bg-white dark:bg-sidebar-dark placeholder-gray-400 dark:placeholder-gray-500 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary dark:focus:ring-blue-500 focus:border-transparent sm:text-sm transition-shadow shadow-sm"></textarea>
                            @error('expected_result_description') <span
                                class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Sección 4: Archivos --}}
                <div class="space-y-4">
                    <h3
                        class="text-lg font-medium text-gray-900 dark:text-white border-b pb-2 border-gray-200 dark:border-gray-700">
                        Documentos Adjuntos
                    </h3>

                    {{-- Documents Upload --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Documentos y Soportes Aportados
                        </label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                            Puede cargar múltiples archivos (máximo 10MB por archivo)
                        </p>

                        <div
                            class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors">
                            <input type="file" id="documents" wire:model="documents" multiple class="hidden">
                            <label for="documents" class="cursor-pointer">
                                <flux:icon.arrow-up-tray class="w-8 h-8 mx-auto text-gray-400 mb-2" />
                                <span class="text-sm text-gray-600 dark:text-gray-400 block mb-1">Haga clic o arrastre
                                    archivos aquí</span>
                                <span class="text-xs text-gray-500 dark:text-gray-500">Soporta PDF, Imagenes, Word,
                                    Excel</span>
                            </label>
                        </div>

                        {{-- Fallback file input if JS drag/drop not fully implemented or simple style preferred --}}
                        <input type="file" id="documents_fallback" wire:model="documents" multiple class="mt-2 block w-full text-sm text-gray-900 dark:text-white
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-lg file:border-0
                               file:text-sm file:font-semibold
                               file:bg-primary file:text-white
                               hover:file:bg-blue-600
                               file:cursor-pointer">

                        @error('documents.*') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror

                        {{-- Show temporary uploaded documents --}}
                        @if($documents)
                            <div class="mt-4 mb-2 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($documents as $tempDoc)
                                    <div
                                        class="flex items-center justify-between p-3 bg-blue-50 dark:bg-blue-900/10 rounded-lg border border-blue-100 dark:border-blue-800">
                                        <div class="flex items-center gap-3 overflow-hidden">
                                            <div class="flex-shrink-0">
                                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                    {{ $tempDoc->getClientOriginalName() }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ number_format($tempDoc->getSize() / 1024, 2) }} KB
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-xs font-medium text-blue-600 dark:text-blue-400">
                                            Nuevo
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Show existing documents --}}
                        @if(!empty($existingDocuments))
                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($existingDocuments as $index => $doc)
                                    <div
                                        class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-800 rounded-lg border border-gray-100 dark:border-gray-700">
                                        <div class="flex items-center gap-3 overflow-hidden">
                                            <div class="flex-shrink-0">
                                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                    {{ $doc['name'] ?? 'Documento ' . ($index + 1) }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    {{ number_format(($doc['size'] ?? 0) / 1024, 2) }} KB
                                                </p>
                                            </div>
                                        </div>
                                        <a href="{{ asset('storage/' . ($doc['path'] ?? '')) }}" target="_blank"
                                            class="text-xs font-medium text-blue-600 hover:text-blue-500 px-2 py-1 bg-blue-50 dark:bg-blue-900/20 rounded">
                                            Ver
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Show uploading state --}}
                        <div wire:loading wire:target="documents" class="mt-2 text-sm text-blue-600 animate-pulse">
                            Cargando archivos...
                        </div>
                    </div>
                </div>

                {{-- Form Actions --}}
                <div class="flex justify-end gap-3 py-3 border-t border-gray-200 dark:border-gray-700 pt-6">
                    <flux:button href="{{ route('client-requests.index') }}" variant="ghost">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Guardar Solicitud
                    </flux:button>
                </div>
            </form>
        </div>
    </div>
</div>