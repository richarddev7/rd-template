<?php

namespace App\Livewire\Portal;

use App\Models\ClientRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $user;
    public $requestsTotal;
    public $requestsInProgress;
    public $requestsPending;
    public $recentRequests;

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->loadStats();
    }

    public function loadStats(): void
    {
        $clientId = $this->user->client_id;

        // Only count requests for this client
        $requestsQuery = ClientRequest::when($clientId, fn($q) => $q->where('client_id', $clientId))
            ->when(!$clientId, fn($q) => $q->where('created_by', $this->user->id));

        $this->requestsTotal = $requestsQuery->count();
        $this->requestsInProgress = (clone $requestsQuery)->whereHas('status', fn($q) => $q->where('name', 'like', '%proceso%'))->count();
        $this->requestsPending = (clone $requestsQuery)->whereHas('status', fn($q) => $q->where('name', 'like', '%pendiente%'))->count();

        // Recent 5 requests for the table
        $this->recentRequests = $requestsQuery->with('status')
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.portal.dashboard')->layout('components.layouts.client');
    }
}
