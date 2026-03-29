<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

class ClientList extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $showDeleteModal = false;
    public $clientToDelete = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        $this->clientToDelete = $id;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->clientToDelete = null;
        $this->showDeleteModal = false;
    }

    public function delete()
    {
        if ($this->clientToDelete) {
            $client = Client::findOrFail($this->clientToDelete);
            $client->delete();

            session()->flash('success', __('Client deleted successfully'));

            $this->clientToDelete = null;
            $this->showDeleteModal = false;
        }
    }

    public function render()
    {
        $clients = Client::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter !== '', function ($query) {
                $query->where('is_active', $this->statusFilter);
            })
            ->withCount('requests')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.clients.client-list', [
            'clients' => $clients,
        ]);
    }
}
