<?php

namespace App\Livewire\ClientRequests;

use App\Models\Client;
use App\Models\ClientRequest;
use App\Models\RequestStatus;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class ClientRequestForm extends Component
{
    use WithFileUploads;

    public ?ClientRequest $clientRequest = null;
    public $client_id = '';
    public $status_id = '';
    public $title = '';
    public $responsible = '';
    public $contact_email = '';
    public $contact_phone = '';
    public $source = '';
    public $context = '';
    public $expected_result_description = '';
    public $start_date = '';
    public $deadline_date = '';

    // Checkbox arrays
    public $request_types = [];
    public $expected_results = [];
    public $assigned_users = []; // NEW property

    // ... (skipped lines)

    public function mount(ClientRequest $clientRequest = null)
    {
        if ($clientRequest && $clientRequest->exists) {
            // Check if user can update this request
            if (auth()->user()->cannot('update', $clientRequest)) {
                abort(403, 'No tiene permiso para editar esta solicitud');
            }

            $this->clientRequest = $clientRequest;
            $this->client_id = $clientRequest->client_id;
            $this->status_id = $clientRequest->status_id;
            $this->title = $clientRequest->title;
            $this->responsible = $clientRequest->responsible;
            $this->contact_email = $clientRequest->contact_email;
            $this->contact_phone = $clientRequest->contact_phone;
            $this->source = $clientRequest->source;
            $this->context = $clientRequest->context;
            $this->expected_result_description = $clientRequest->expected_result_description;
            $this->start_date = $clientRequest->start_date ? $clientRequest->start_date->format('Y-m-d\TH:i') : '';
            $this->deadline_date = $clientRequest->deadline_date ? $clientRequest->deadline_date->format('Y-m-d\TH:i') : '';
            $this->request_types = $clientRequest->request_types ?? [];
            $this->expected_results = $clientRequest->expected_results ?? [];
            $this->assigned_users = $clientRequest->assignees->pluck('id')->toArray();
            $this->existingDocuments = $clientRequest->documents ?? [];
        } else {
            // Check if user can create requests
            if (auth()->user()->cannot('create', ClientRequest::class)) {
                abort(403, 'No tiene permiso para crear solicitudes');
            }

            // Set default status to 'Pendiente' for new requests
            $defaultStatus = RequestStatus::where('slug', 'pendiente')->first();
            $this->status_id = $defaultStatus?->id;
            $this->assigned_users = [];
            // Set start_date to now for new requests
            $this->start_date = now()->format('Y-m-d\TH:i');
        }
    }

    public function save()
    {
        $rules = [
            'client_id' => 'nullable|exists:clients,id',
            'status_id' => 'required|exists:request_statuses,id',
            'title' => 'required|string|max:255',
            'responsible' => 'required|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'source' => 'nullable|string|max:255',
            'context' => 'required|string',
            'expected_result_description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'deadline_date' => 'nullable|date|after_or_equal:start_date',
            'request_types' => 'nullable|array',
            'expected_results' => 'nullable|array',
            'documents.*' => 'nullable|file|max:10240', // Max 10MB per file
            'assigned_users' => 'nullable|array',
            'assigned_users.*' => 'exists:users,id',
        ];

        $this->validate($rules);

        // Handle document uploads
        $documentPaths = $this->existingDocuments;
        if (!empty($this->documents)) {
            try {
                // Ensure directory exists and is writable
                $storage = \Storage::disk('public');
                $directory = 'client-request-documents';

                if (!$storage->exists($directory)) {
                    $storage->makeDirectory($directory);
                }

                // Verify permissions by attempting a test write if possible, or using check
                // For local driver, we can be more specific
                if (config('filesystems.default') === 'public' || config('filesystems.default') === 'local') {
                    $fullPath = $storage->path($directory);
                    if (!is_writable($fullPath)) {
                        throw new \Exception("El directorio de destino no tiene permisos de escritura: " . $fullPath);
                    }
                }

                foreach ($this->documents as $document) {
                    $originalName = $document->getClientOriginalName();
                    $filePath = $directory . '/' . $originalName;

                    // Check if file already exists in the existing documents
                    $isDuplicate = false;
                    foreach ($documentPaths as $existingDoc) {
                        if ($existingDoc['name'] === $originalName) {
                            $isDuplicate = true;
                            break;
                        }
                    }

                    if ($isDuplicate) {
                        \Log::warning("Duplicate file skipped: " . $originalName);
                        session()->flash('warning', "El archivo '{$originalName}' ya fue cargado previamente y se omitió.");
                        continue;
                    }

                    // Check if file exists in storage
                    if ($storage->exists($filePath)) {
                        \Log::warning("File already exists in storage: " . $originalName);
                        session()->flash('warning', "El archivo '{$originalName}' ya existe en el sistema y se omitió.");
                        continue;
                    }

                    // Store with original filename
                    $path = $document->storeAs($directory, $originalName, 'public');
                    $documentPaths[] = [
                        'name' => $originalName,
                        'path' => $path,
                        'size' => $document->getSize(),
                        'uploaded_at' => now()->toDateTimeString(),
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('File upload failed: ' . $e->getMessage());
                session()->flash('error', 'Error al subir archivos: ' . $e->getMessage());
                return;
            }
        }

        $data = [
            'client_id' => $this->client_id,
            'status_id' => $this->status_id,
            'title' => $this->title,
            'responsible' => $this->responsible,
            'contact_email' => $this->contact_email,
            'contact_phone' => $this->contact_phone,
            'source' => $this->source,
            'context' => $this->context,
            'expected_result_description' => $this->expected_result_description,
            'start_date' => $this->start_date,
            'deadline_date' => $this->deadline_date,
            'request_types' => $this->request_types,
            'expected_results' => $this->expected_results,
            'documents' => $documentPaths,
        ];

        // Determine the original assignees to compare later
        $originalAssignees = $this->clientRequest ? $this->clientRequest->assignees->pluck('id')->toArray() : [];

        if ($this->clientRequest) {
            // Check authorization using Policy
            if (auth()->user()->cannot('update', $this->clientRequest)) {
                session()->flash('error', 'No tiene permiso para editar esta solicitud');
                return redirect()->route('client-requests.index');
            }

            $this->clientRequest->update($data);
            $this->clientRequest->assignees()->sync($this->assigned_users);
            $message = 'Solicitud actualizada exitosamente';
        } else {
            // Check authorization using Policy
            if (auth()->user()->cannot('create', ClientRequest::class)) {
                session()->flash('error', 'No tiene permiso para crear solicitudes');
                return redirect()->route('client-requests.index');
            }

            $data['created_by'] = auth()->id();
            $data['request_date'] = now();
            $this->clientRequest = ClientRequest::create($data); // assign to property to use below
            $this->clientRequest->assignees()->sync($this->assigned_users);
            $message = 'Solicitud creada exitosamente';

            // Send email notification to admin using custom mail helper
            $adminEmail = env('ADMIN_EMAIL');
            if ($adminEmail && function_exists('send_custom_mail')) {
                try {
                    $mailable = new \App\Mail\AdminNewRequestMail($this->clientRequest);

                    // We need to render the blade view manually to get the HTML string
                    // This is a bit tricky with Mailables outside the Mail facade, so we extract subject and body
                    $subject = clone $mailable;
                    $subject = $subject->envelope()->subject;

                    $content = clone $mailable;
                    $contentView = $content->content();
                    $htmlMessage = \Illuminate\Support\Facades\View::make($contentView->view, $contentView->with)->render();

                    send_custom_mail($adminEmail, $subject, $htmlMessage);

                } catch (\Exception $e) {
                    \Log::error('Failed to send admin notification email via custom helper: ' . $e->getMessage());
                }
            }
        }

        // Notify NEW assigned users
        $newAssigneesIds = array_diff($this->assigned_users, $originalAssignees);
        if (!empty($newAssigneesIds) && function_exists('send_custom_mail')) {
            $newUsers = \App\Models\User::whereIn('id', $newAssigneesIds)->get();
            /** @var \App\Models\User $user */
            foreach ($newUsers as $user) {
                try {
                    $mailable = new \App\Mail\RequestAssignedMail($this->clientRequest, $user);

                    $subject = clone $mailable;
                    $subject = $subject->envelope()->subject;

                    $content = clone $mailable;
                    $contentView = $content->content();
                    $htmlMessage = \Illuminate\Support\Facades\View::make($contentView->view, $contentView->with)->render();

                    send_custom_mail($user->email, $subject, $htmlMessage);
                } catch (\Exception $e) {
                    \Log::error("Failed to send assignment email to User ID {$user->id}: " . $e->getMessage());
                }
            }
        }

        session()->flash('success', $message);
        return redirect()->route('client-requests.index');
    }

    // File uploads
    public $documents = [];
    public $existingDocuments = [];

    // Available options
    public $availableRequestTypes = [
        'elaboracion_revision_contrato' => 'Elaboración / revisión de contrato',
        'emision_concepto_juridico' => 'Emisión de concepto jurídico',
        'estrategia_juridica' => 'Estrategia jurídica / preventiva',
        'respuesta_requerimiento' => 'Respuesta a requerimiento de tercero',
        'acompanamiento_negociacion' => 'Acompañamiento en negociación',
        'elaboracion_documento_interno' => 'Elaboración / revisión de documento interno (política, circular, reglamento)',
        'acompanamiento_terminacion' => 'Acompañamiento en terminación de relación (laboral o comercial)',
        'analisis_riesgos' => 'Análisis de riesgos / cumplimiento normativo',
        'otro_tipo' => 'Otro',
    ];

    public $availableExpectedResults = [
        'tomar_decision' => 'Tomar una decisión informada',
        'minimizar_riesgos' => 'Minimizar riesgos legales',
        'evitar_contingencia' => 'Evitar una contingencia jurídica',
        'cumplir_obligacion' => 'Cumplir una obligación legal',
        'establecer_estrategia' => 'Establecer una estrategia clara',
        'cerrar_conflicto' => 'Cerrar o prevenir un conflicto',
        'proteger_relacion' => 'Proteger una relación laboral o comercial',
        'otro_resultado' => 'Otro',
    ];



    public function render()
    {
        $clients = Client::active()->orderBy('name')->get();
        $users = User::orderBy('name')->get();
        $requestStatuses = RequestStatus::ordered()->get();

        return view('livewire.client-requests.client-request-form', [
            'clients' => $clients,
            'users' => $users,
            'requestStatuses' => $requestStatuses,
        ]);
    }
}
