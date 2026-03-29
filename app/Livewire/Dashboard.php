<?php

namespace App\Livewire;

use App\Models\ClientRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $requestsCount;
    public $clientsCount;
    public $usersCount;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->requestsCount = ClientRequest::visibleTo($this->user)->count();
        $this->clientsCount = Client::visibleTo($this->user)->count();
        $this->usersCount = $this->user->hasRole('Super Admin') ? User::count() : 0;
    }

    public function render()
    {
        $recentRequests = ClientRequest::visibleTo($this->user)
            ->with(['client', 'status'])
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.dashboard', [
            'recentRequests' => $recentRequests,
        ]);
    }
}
