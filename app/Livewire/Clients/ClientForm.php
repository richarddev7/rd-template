<?php

namespace App\Livewire\Clients;

use App\Models\Client;
use Livewire\Component;
use Illuminate\Validation\Rule;

class ClientForm extends Component
{
    public ?Client $client = null;
    public $name = '';
    public $email = '';
    public $phone = '';
    public $address = '';
    public $notes = '';
    public $is_active = true;

    public function mount(Client $client = null)
    {
        if ($client && $client->exists) {
            $this->client = $client;
            $this->name = $client->name;
            $this->email = $client->email;
            $this->phone = $client->phone;
            $this->address = $client->address;
            $this->notes = $client->notes;
            $this->is_active = $client->is_active;
        }
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ];

        $this->validate($rules);

        if ($this->client) {
            $this->client->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'notes' => $this->notes,
                'is_active' => $this->is_active,
            ]);
            $message = __('Client updated successfully');
        } else {
            Client::create([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'notes' => $this->notes,
                'is_active' => $this->is_active,
                'created_by' => auth()->id(),
            ]);
            $message = __('Client created successfully');
        }

        session()->flash('success', $message);
        return redirect()->route('clients.index');
    }

    public function render()
    {
        return view('livewire.clients.client-form');
    }
}
