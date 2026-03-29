<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;

class ClientOverview extends Component
{
    public Client $client;
    public $activeTab = 'requests';

    public function mount(Client $client)
    {
        $this->client = $client;
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function getActivitiesProperty()
    {
        $requests = $this->client->requests()
            ->with('status')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($request) {
                return [
                    'type' => 'request',
                    'title' => $request->title,
                    'description' => $request->context,
                    'status' => $request->status->name ?? 'Pending',
                    'status_color' => $this->getStatusColor($request->status->name ?? ''),
                    'date' => $request->request_date,
                    'created_at' => $request->created_at,
                ];
            });

        return $requests;
    }

    private function getStatusColor($status)
    {
        return match (strtolower($status)) {
            'completed', 'done', 'aprobada' => 'green',
            'in progress', 'doing', 'en proceso' => 'blue',
            'pending', 'todo', 'pendiente' => 'amber',
            'rechazada', 'rejected' => 'red',
            default => 'gray',
        };
    }

    public function render()
    {
        $pendingRequestsCount = $this->client->requests()->count();

        return view('livewire.clients.client-overview', [
            'pendingRequestsCount' => $pendingRequestsCount,
            'activities' => $this->activities,
        ]);
    }
}
