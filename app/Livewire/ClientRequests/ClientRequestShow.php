<?php

namespace App\Livewire\ClientRequests;

use App\Models\ClientRequest;
use Livewire\Component;

class ClientRequestShow extends Component
{
    public ClientRequest $clientRequest;

    public function mount(ClientRequest $clientRequest)
    {
        $this->clientRequest = $clientRequest->load(['client', 'createdBy', 'status']);

        // Check view permission
        if (auth()->user()->cannot('view', $clientRequest)) {
            abort(403, 'No tiene permiso para ver esta solicitud');
        }
    }

    public function render()
    {
        return view('livewire.client-requests.client-request-show');
    }
}
