<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserForm extends Component
{
    use WithFileUploads;

    public ?User $user = null;
    public $name = '';
    public $email = '';
    public $password = '';
    public $selectedRoles = [];
    public $language = 'es';
    public $client_id = null;
    public $showPassword = false;

    // Profile photo
    public $photo = null;
    public $currentPhotoPath = null;

    public function mount(User $user = null)
    {
        if ($user && $user->exists) {
            $this->user = $user;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->language = $user->language ?? 'es';
            $this->client_id = $user->client_id;
            $this->selectedRoles = $user->roles->pluck('name')->toArray();
            $this->currentPhotoPath = $user->profile_photo_path;
        }
    }

    public function removePhoto()
    {
        if ($this->user && $this->user->profile_photo_path) {
            Storage::disk('public')->delete($this->user->profile_photo_path);
            $this->user->update(['profile_photo_path' => null]);
            $this->currentPhotoPath = null;
        }
        $this->photo = null;
    }

    public function save()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user?->id)],
            'language' => 'required|in:en,es',
            'client_id' => 'nullable|exists:clients,id',
            'selectedRoles' => 'array',
            'photo' => 'nullable|image|max:2048',
        ];

        if (!$this->user) {
            $rules['password'] = 'required|string|min:8';
        } else {
            $rules['password'] = 'nullable|string|min:8';
        }

        $this->validate($rules);

        // Handle photo upload
        $photoPath = $this->currentPhotoPath;
        if ($this->photo) {
            // Delete old photo if exists
            if ($photoPath) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $this->photo->store('profile-photos', 'public');
        }

        if ($this->user) {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'language' => $this->language,
                'client_id' => $this->client_id ?: null,
                'profile_photo_path' => $photoPath,
            ];
            if ($this->password) {
                $data['password'] = Hash::make($this->password);
            }
            $this->user->update($data);
            $this->user->syncRoles($this->selectedRoles);
            $message = 'User updated successfully.';
        } else {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'language' => $this->language,
                'client_id' => $this->client_id ?: null,
                'password' => Hash::make($this->password),
                'profile_photo_path' => $photoPath,
            ]);
            $user->syncRoles($this->selectedRoles);
            $message = 'User created successfully.';
        }

        session()->flash('success', $message);
        return redirect()->route('users.index');
    }

    public function togglePasswordVisibility()
    {
        $this->showPassword = !$this->showPassword;
    }

    public function render()
    {
        $roles = Role::all();
        $clients = Client::orderBy('name')->get();
        return view('livewire.users.user-form', [
            'roles' => $roles,
            'clients' => $clients
        ]);
    }
}
