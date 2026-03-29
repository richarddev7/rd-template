<?php

namespace App\Livewire\ClientRequests;

use App\Models\Client;
use App\Models\ClientRequest;
use Livewire\Component;
use Livewire\WithPagination;

class ClientRequestList extends Component
{
    use WithPagination;

    public $search = '';
    public $clientFilter = '';

    protected $queryString = ['search', 'clientFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingClientFilter()
    {
        $this->resetPage();
    }



    public function delete($id)
    {
        $request = ClientRequest::findOrFail($id);

        // Use Policy to check if user can delete
        if (auth()->user()->cannot('delete', $request)) {
            session()->flash('error', 'No tiene permiso para eliminar esta solicitud');
            return;
        }

        $request->delete();
        session()->flash('success', 'Solicitud eliminada exitosamente');
    }

    public function render()
    {
        $query = ClientRequest::with(['client', 'createdBy', 'status'])
            ->visibleTo(auth()->user()) // Filter by user permissions and assignments
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('responsible', 'like', '%' . $this->search . '%')
                        ->orWhereHas('client', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->clientFilter, function ($query) {
                $query->where('client_id', $this->clientFilter);
            })
            ->orderBy('request_date', 'desc')
            ->paginate(15);

        $clients = Client::active()->orderBy('name')->get();

        return view('livewire.client-requests.client-request-list', [
            'requests' => $query,
            'clients' => $clients,
        ]);
    }
}
