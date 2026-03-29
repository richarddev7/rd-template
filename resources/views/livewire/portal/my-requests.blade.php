<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <flux:heading size="xl">Mis Solicitudes</flux:heading>
            <flux:subheading>Gestiona tus solicitudes legales.</flux:subheading>
        </div>
        <flux:button variant="primary" icon="plus" wire:click="createNewRequest">
            Nueva Solicitud
        </flux:button>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 dark:border-emerald-800 dark:bg-emerald-900/30 px-4 py-3 text-sm text-emerald-700 dark:text-emerald-300">
            <svg class="size-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- New/Edit/View request modal --}}
    <flux:modal wire:model="showForm" class="w-full max-w-4xl lg:max-w-5xl xl:max-w-6xl">
        <div class="space-y-6">
            <div class="flex items-center justify-between mb-5">
                <flux:heading size="lg">{{ $isViewing ? 'Ver Solicitud' : ($editingRequestId ? 'Adjuntar Archivos a Solicitud' : 'Nueva Solicitud') }}</flux:heading>
                <flux:button variant="ghost" icon="x-mark" wire:click="resetForm" />
            </div>

            <form wire:submit="saveRequest" class="space-y-8">
                {{-- Sección 1: Información General --}}
                <div class="space-y-4">
                    <flux:heading size="md">Información General</flux:heading>

                    <flux:field>
                        <flux:label>Título de la Solicitud *</flux:label>
                        <flux:input wire:model="title" placeholder="Ingrese el título de la solicitud" :disabled="$editingRequestId !== null" />
                        <flux:error name="title" />
                    </flux:field>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <flux:field>
                            <flux:label>Correo Electrónico</flux:label>
                            <flux:input wire:model="contact_email" type="email" placeholder="correo@ejemplo.com" :disabled="$editingRequestId !== null" />
                            <flux:error name="contact_email" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Teléfono</flux:label>
                            <flux:input wire:model="contact_phone" type="tel" placeholder="+1 (809) 000-0000" :disabled="$editingRequestId !== null" />
                            <flux:error name="contact_phone" />
                        </flux:field>
                    </div>
                </div>

                <flux:separator />

                {{-- Sección 2: Detalles de la Consulta --}}
                <div class="space-y-4">
                    <flux:heading size="md">Detalles de la Consulta</flux:heading>
                    
                    <flux:field>
                        <flux:label>Contexto de la Solicitud *</flux:label>
                        <flux:description class="mb-2">
                            Por favor describa:
                            <ul class="list-disc pl-5 mt-1">
                                <li>¿Cuándo ocurrió? (fechas, periodos, horas si son relevantes)</li>
                                <li>¿Cómo ocurrió? (forma, antecedentes, comunicaciones, acuerdos)</li>
                                <li>¿Dónde ocurrió? (empresa, ciudad, área, jurisdicción)</li>
                                <li>¿Por qué consulta ahora? (qué detonó la consulta)</li>
                                <li>¿Qué le preocupa al cliente? (riesgo, conflicto, consecuencia)</li>
                            </ul>
                        </flux:description>
                        <flux:textarea wire:model="context" rows="6"
                            placeholder="Describa el contexto completo de la solicitud..." :disabled="$editingRequestId !== null" />
                        <flux:error name="context" />
                    </flux:field>
                </div>

                <flux:separator />

                {{-- Sección 3: Clasificación y Resultados Esperados --}}
                <div class="space-y-4">
                    <flux:heading size="md">Clasificación y Resultados Esperados</flux:heading>

                    <div class="grid md:grid-cols-2 gap-6">
                        <flux:fieldset>
                            <flux:legend>Tipo de Solicitud (seleccione una o más)</flux:legend>
                            <div class="mt-3 space-y-2 max-h-60 overflow-y-auto pr-2">
                                @foreach($this->availableRequestTypes as $value => $label)
                                    <flux:checkbox wire:model="request_types" :value="$value" :label="$label" :disabled="$editingRequestId !== null" />
                                @endforeach
                            </div>
                        </flux:fieldset>

                        <flux:fieldset>
                            <flux:legend>¿Qué espera lograr con nuestra asesoría?</flux:legend>
                            <div class="mt-3 space-y-2 max-h-60 overflow-y-auto pr-2">
                                @foreach($this->availableExpectedResults as $value => $label)
                                    <flux:checkbox wire:model="expected_results" :value="$value" :label="$label" :disabled="$editingRequestId !== null" />
                                @endforeach
                            </div>
                        </flux:fieldset>
                    </div>

                    <flux:field class="pt-4">
                        <flux:label>¿Qué está solicitando usted concretamente? (Producto o actuación jurídica específica que usted pide)</flux:label>
                        <flux:textarea wire:model="expected_result_description" rows="3"
                            placeholder="Describa lo que espera lograr..." :disabled="$editingRequestId !== null" />
                        <flux:error name="expected_result_description" />
                    </flux:field>
                </div>

                <flux:separator />

                {{-- Sección 4: Documentos Adjuntos --}}
                <div class="space-y-4">
                    <flux:heading size="md">Documentos Adjuntos</flux:heading>
                    
                    @if($editingRequestId && !empty($existingDocuments))
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-zinc-900 dark:text-white mb-3">Documentos y Soportes Actuales:</h4>
                            <ul class="border border-zinc-200 dark:border-zinc-700 rounded-lg divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach($existingDocuments as $doc)
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <div class="flex items-center">
                                            <flux:icon name="document" class="size-5 shrink-0 text-zinc-400 mr-3" />
                                            <a href="{{ Storage::url($doc['path']) }}" target="_blank" class="truncate text-sky-600 hover:text-sky-500 hover:underline">{{ $doc['name'] }}</a>
                                        </div>
                                        <span class="text-zinc-500">{{ number_format($doc['size'] / 1024, 1) }} KB</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(!$isViewing)
                    <flux:field>
                        <flux:legend>{{ $editingRequestId ? 'Adjuntar Nuevos Documentos' : 'Documentos y Soportes Aportados' }}</flux:legend>
                        <flux:description class="mb-3">Puede cargar múltiples archivos (máximo 10MB por archivo)</flux:description>

                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-zinc-300 dark:border-zinc-700 px-6 py-10"
                            x-data="{ isDropping: false }"
                            x-on:dragover.prevent="isDropping = true"
                            x-on:dragleave.prevent="isDropping = false"
                            x-on:drop.prevent="isDropping = false; $refs.fileInput.files = $event.dataTransfer.files; $refs.fileInput.dispatchEvent(new Event('change'))"
                            :class="{ 'bg-zinc-50 dark:bg-zinc-800/50 border-sky-400 dark:border-sky-500': isDropping }">
                            
                            <div class="text-center">
                                <flux:icon name="arrow-up-tray" class="mx-auto size-8 text-zinc-300 dark:text-zinc-600" />
                                <div class="mt-4 flex text-sm leading-6 text-zinc-600 dark:text-zinc-400">
                                    <label for="documents-upload" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-sky-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-sky-600 focus-within:ring-offset-2 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300">
                                        <span>Haga clic o arrastre archivos aquí</span>
                                        <input id="documents-upload" x-ref="fileInput" wire:model="documents" type="file" multiple class="sr-only">
                                    </label>
                                </div>
                                <p class="text-xs leading-5 text-zinc-500 mt-1">Soporta PDF, Imagenes, Word, Excel</p>
                            </div>
                        </div>

                        <div wire:loading wire:target="documents" class="mt-2 text-sm text-zinc-500">
                            Subiendo archivos...
                        </div>
                        <flux:error name="documents.*" class="mt-2" />
                    </flux:field>
                    @endif

                    {{-- Local Preview of Uploaded Files --}}
                    @if($documents)
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-zinc-900 dark:text-white mb-3">Archivos seleccionados:</h4>
                            <ul class="border border-zinc-200 dark:border-zinc-700 rounded-lg divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach($documents as $doc)
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <div class="flex items-center">
                                            <flux:icon name="document" class="size-5 shrink-0 text-zinc-400 mr-3" />
                                            <span class="truncate">{{ $doc->getClientOriginalName() }}</span>
                                        </div>
                                        <span class="text-zinc-500">{{ number_format($doc->getSize() / 1024, 1) }} KB</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button variant="ghost" wire:click="resetForm">{{ $isViewing ? 'Cerrar' : 'Cancelar' }}</flux:button>
                    @if(!$isViewing)
                        <flux:button type="submit" variant="primary" class="w-full sm:w-auto">{{ $editingRequestId ? 'Subir Archivos' : 'Guardar Solicitud' }}</flux:button>
                    @endif
                </div>
            </form>
        </div>
    </flux:modal>

    {{-- Requests table --}}
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        @if($requests->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide" scope="col">Título</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide" scope="col">Estado</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide" scope="col">Fecha</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide" scope="col">Responsable</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wide" scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @foreach($requests as $request)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition-colors">
                                <td class="px-4 py-3 text-sm font-medium text-zinc-800 dark:text-zinc-200">
                                    {{ $request->title }}
                                </td>
                                <td class="px-4 py-3">
                                    @if($request->status)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-sky-100 text-sky-800 dark:bg-sky-900/30 dark:text-sky-300">
                                            {{ $request->status->name }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400">
                                            Sin estado
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $request->request_date?->format('d/m/Y') ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                    {{ $request->responsible ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                                    <div class="flex gap-2">
                                        <flux:button href="{{ route('portal.requests.show', $request->id) }}" size="sm" variant="ghost" icon="eye" title="Ver Solicitud" />
                                        @if($request->status && !in_array($request->status->slug, ['completada', 'cancelada']))
                                            <flux:button size="sm" variant="ghost" icon="document-plus" wire:click="editRequest({{ $request->id }})" title="Adjuntar Archivos" />
                                            <flux:button size="sm" variant="ghost" icon="trash" class="text-red-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30" wire:click="confirmCancel({{ $request->id }})" title="Cancelar Solicitud" />
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-zinc-50 dark:bg-zinc-800/50 px-4 py-3 border-t border-zinc-200 dark:border-zinc-700">
                {{ $requests->links() }}
            </div>
        @else
            <div class="py-16 text-center">
                <svg class="mx-auto mb-3 size-10 text-zinc-300 dark:text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <p class="text-zinc-500 text-sm">No tienes solicitudes aún.</p>
                <flux:button class="mt-4" variant="primary" wire:click="createNewRequest">
                    Crear tu primera solicitud
                </flux:button>
            </div>
        @endif
    </div>

    {{-- Cancel Request Modal --}}
    <flux:modal wire:model="showCancelForm" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Cancelar Solicitud</flux:heading>
                <flux:subheading>
                    <p class="mt-1">¿Estás seguro de que deseas cancelar esta solicitud?</p>
                </flux:subheading>
            </div>

            <form wire:submit.prevent="cancelRequest" class="space-y-4">
                <flux:field>
                    <flux:label>Motivo de cancelación *</flux:label>
                    <flux:textarea wire:model="cancellationReason" rows="3" placeholder="Indica el motivo por el cual cancelas la solicitud..." required />
                    <flux:error name="cancellationReason" />
                </flux:field>

                <div class="flex justify-end gap-3 pt-2">
                    <flux:button variant="ghost" wire:click="$set('showCancelForm', false)">Cerrar</flux:button>
                    <flux:button type="submit" variant="danger">Confirmar Cancelación</flux:button>
                </div>
            </form>
        </div>
    </flux:modal>
</div>