<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\ClientRequest;
use Livewire\Component;

class GlobalSearch extends Component
{
    public $query = '';
    public $results = [
        'clients' => [],
        'solicitudes' => [],
    ];

    public function updatedQuery()
    {
        $this->results = [
            'clients' => [],
            'solicitudes' => [],
        ];

        if (strlen($this->query) < 2) {
            return;
        }

        $user = auth()->user();

        // Search Clients
        $clients = Client::visibleTo($user)
            ->where(function ($q) {
                $q->where('name', 'like', '%' . $this->query . '%')
                  ->orWhere('email', 'like', '%' . $this->query . '%');
            })
            ->take(5)
            ->get();

        foreach ($clients as $client) {
            $this->results['clients'][] = [
                'name' => $client->name,
                'email' => $client->email,
                'contact_person' => $client->contact_person,
                'is_active' => $client->is_active,
                'url' => $user->isClient() 
                            ? route('portal.dashboard') // Portal clients have limited views
                            : route('clients.show', $client),
            ];
        }

        // Search Solicitudes
        $solicitudes = ClientRequest::visibleTo($user)
            ->where('title', 'like', '%' . $this->query . '%')
            ->with(['client', 'status'])
            ->take(5)
            ->get();

        foreach ($solicitudes as $request) {
            $this->results['solicitudes'][] = [
                'title' => $request->title,
                'client' => $request->client->name ?? 'Sin Cliente',
                'status' => $request->status->name ?? 'Pendiente',
                'url' => $user->isClient() 
                            ? route('portal.requests.show', $request) 
                            : route('client-requests.show', $request),
            ];
        }
    }

    public function clearSearch()
    {
        $this->query = '';
        $this->results = [
            'clients' => [],
            'solicitudes' => [],
        ];
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
