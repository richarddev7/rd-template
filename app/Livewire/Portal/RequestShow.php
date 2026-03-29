<?php

namespace App\Livewire\Portal;

use App\Models\ClientRequest;
use Livewire\Component;

class RequestShow extends Component
{
    public ClientRequest $clientRequest;

    public function mount(ClientRequest $clientRequest)
    {
        $this->clientRequest = $clientRequest->load(['client', 'createdBy', 'status']);

        // Check if the request belongs to the authenticated client or was created by them
        $user = auth()->user();
        if ($this->clientRequest->client_id !== $user->client_id && $this->clientRequest->created_by !== $user->id) {
            abort(403, 'No tiene permiso para ver esta solicitud');
        }
    }

    public function render()
    {
        return view('livewire.portal.request-show')->layout('components.layouts.client');
    }
}
