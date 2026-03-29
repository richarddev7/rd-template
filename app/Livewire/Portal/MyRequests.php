<?php

namespace App\Livewire\Portal;

use App\Models\ClientRequest;
use App\Models\RequestStatus;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class MyRequests extends Component
{
    use WithPagination, WithFileUploads;

    public $user;
    public $showForm = false;
    public $isViewing = false;
    public $editingRequestId = null;
    public $showCancelForm = false;
    public $cancelRequestId = null;
    public $cancellationReason = '';
    public $existingDocuments = [];
    public $title = '';
    public $context = '';
    public $contact_email = '';
    public $contact_phone = '';
    public $expected_result_description = '';
    public $request_types = [];
    public $expected_results = [];
    public $documents = [];

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

    protected $rules = [
        'title' => 'required|string|max:255',
        'context' => 'required|string',
        'contact_email' => 'nullable|email|max:255',
        'contact_phone' => 'nullable|string|max:30',
        'expected_result_description' => 'nullable|string',
        'request_types' => 'nullable|array',
        'expected_results' => 'nullable|array',
        'documents.*' => 'nullable|file|max:10240', // Max 10MB per file
        'cancellationReason' => 'required_if:showCancelForm,true|string|max:1000',
    ];

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->contact_email = $this->user->email;
    }

    public function saveRequest(): void
    {
        $this->validate();

        // Skip document upload and strict validation logic if we are just canceling
        if ($this->showCancelForm) {
            $this->validateOnly('cancellationReason');
            return;
        }

        $this->validate();

        // Find the default/first status (Pending)
        $defaultStatus = RequestStatus::where('slug', 'pendiente')->first() ?? RequestStatus::first();

        // Handle document uploads
        $documentPaths = [];
        if (!empty($this->documents)) {
            try {
                $storage = \Storage::disk('public');
                $directory = 'client-request-documents';

                if (!$storage->exists($directory)) {
                    $storage->makeDirectory($directory);
                }

                foreach ($this->documents as $document) {
                    $originalName = $document->getClientOriginalName();
                    $filePath = $directory . '/' . $originalName;

                    if ($storage->exists($filePath)) {
                        \Log::warning("File already exists in storage: " . $originalName);
                        session()->flash('warning', "El archivo '{$originalName}' ya existe en el sistema y se omitió.");
                        continue;
                    }

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

        if ($this->editingRequestId) {
            $request = ClientRequest::where('id', $this->editingRequestId)->where('client_id', $this->user->client_id)->firstOrFail();
            
            // Allow adding files only if NOT completada or cancelada
            $statusSlug = $request->status ? $request->status->slug : '';
            if (!in_array($statusSlug, ['cancelada', 'completada'])) {
                if (!empty($documentPaths)) {
                    $request->update([
                        'documents' => array_merge($request->documents ?? [], $documentPaths),
                    ]);
                    session()->flash('success', '¡Archivos agregados exitosamente a la solicitud!');
                } else {
                    session()->flash('warning', 'No se seleccionaron nuevos archivos para adjuntar.');
                }
            } else {
                session()->flash('error', 'No se puede modificar una solicitud completada o cancelada.');
            }
        } else {
            $request = ClientRequest::create([
                'client_id' => $this->user->client_id,
                'status_id' => $defaultStatus?->id,
                'title' => $this->title,
                'context' => $this->context,
                'contact_email' => $this->contact_email,
                'contact_phone' => $this->contact_phone,
                'expected_result_description' => $this->expected_result_description,
                'request_types' => $this->request_types,
                'expected_results' => $this->expected_results,
                'documents' => $documentPaths,
                'request_date' => now(),
                'created_by' => $this->user->id,
                'source' => 'Formulario cuenta cliente',
                'responsible' => 'Por asignar',  // admin will assign later
            ]);

            // Send email notification to admin using custom mail helper
            $adminEmail = env('ADMIN_EMAIL');
            if ($adminEmail && function_exists('send_custom_mail')) {
                try {
                    $mailable = new \App\Mail\AdminNewRequestMail($request);
                    $subject = clone $mailable;
                    $subject = $subject->envelope()->subject;
                    $content = clone $mailable;
                    $contentView = $content->content();
                    $htmlMessage = \Illuminate\Support\Facades\View::make($contentView->view, $contentView->with)->render();
                    send_custom_mail($adminEmail, $subject, $htmlMessage);
                } catch (\Exception $e) {
                    \Log::error('Failed to send admin notification email: ' . $e->getMessage());
                }
            }
            session()->flash('success', '¡Solicitud enviada con éxito! El equipo legal la revisará pronto.');
        }

        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->reset(['title', 'context', 'contact_phone', 'expected_result_description', 'request_types', 'expected_results', 'documents', 'showForm', 'editingRequestId', 'showCancelForm', 'cancelRequestId', 'cancellationReason', 'isViewing', 'existingDocuments']);
        $this->contact_email = $this->user->email;
    }

    public function createNewRequest(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function editRequest($id): void
    {
        $request = ClientRequest::where('id', $id)
            ->where('client_id', $this->user->client_id)
            ->firstOrFail();

        $statusSlug = $request->status ? $request->status->slug : '';
        if (in_array($statusSlug, ['cancelada', 'completada'])) {
            session()->flash('error', 'No se puede editar una solicitud completada o cancelada.');
            return;
        }

        $this->editingRequestId = $request->id;
        $this->isViewing = false;
        $this->title = $request->title;
        $this->context = $request->context;
        $this->contact_email = $request->contact_email;
        $this->contact_phone = $request->contact_phone;
        $this->expected_result_description = $request->expected_result_description;
        $this->request_types = $request->request_types ?? [];
        $this->expected_results = $request->expected_results ?? [];
        $this->existingDocuments = $request->documents ?? [];
        
        $this->showForm = true;
    }

    public function confirmCancel($id): void
    {
        $request = ClientRequest::where('id', $id)
            ->where('client_id', $this->user->client_id)
            ->firstOrFail();

        $statusSlug = $request->status ? $request->status->slug : '';
        if (in_array($statusSlug, ['cancelada', 'completada'])) {
            session()->flash('error', 'No se puede cancelar una solicitud completada o cancelada.');
            return;
        }

        $this->cancelRequestId = $request->id;
        $this->cancellationReason = '';
        $this->showCancelForm = true;
    }

    public function cancelRequest(): void
    {
        $this->validate(['cancellationReason' => 'required|string|max:1000']);

        $request = ClientRequest::where('id', $this->cancelRequestId)
            ->where('client_id', $this->user->client_id)
            ->firstOrFail();

        $cancelStatus = RequestStatus::where('slug', 'cancelada')->first();

        if ($cancelStatus) {
            $request->update([
                'status_id' => $cancelStatus->id,
                'cancellation_reason' => $this->cancellationReason,
            ]);
            session()->flash('success', 'La solicitud ha sido cancelada.');
        } else {
            session()->flash('error', 'El estado de cancelación no está configurado en el sistema.');
        }

        $this->showCancelForm = false;
        $this->cancelRequestId = null;
        $this->cancellationReason = '';
    }

    private function requestsQuery()
    {
        $clientId = $this->user->client_id;
        return ClientRequest::with('status')
            ->when($clientId, fn($q) => $q->where('client_id', $clientId))
            ->when(!$clientId, fn($q) => $q->where('created_by', $this->user->id))
            ->latest();
    }

    public function render()
    {
        $requests = $this->requestsQuery()->paginate(10);

        return view('livewire.portal.my-requests', [
            'requests' => $requests,
        ])->layout('components.layouts.client');
    }
}
