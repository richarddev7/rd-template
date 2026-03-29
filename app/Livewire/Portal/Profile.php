<?php

namespace App\Livewire\Portal;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $user;

    // Profile fields
    public $name = '';
    public $email = '';
    public $photo = null;

    // Password fields
    public $current_password = '';
    public $password = '';
    public $password_confirmation = '';

    // UI state
    public $activeSection = 'profile'; // 'profile' | 'password'
    public $successMessage = '';

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    public function updateProfile(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $updateData = ['name' => $this->name];

        if ($this->photo) {
            // Delete old photo if exists
            if ($this->user->profile_photo_path) {
                Storage::disk('public')->delete($this->user->profile_photo_path);
            }
            $path = $this->photo->store('profile-photos', 'public');
            $updateData['profile_photo_path'] = $path;
        }

        $this->user->update($updateData);
        $this->photo = null;
        $this->successMessage = '¡Perfil actualizado correctamente!';
    }

    public function updatePassword(): void
    {
        $this->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($this->current_password, $this->user->password)) {
            $this->addError('current_password', 'La contraseña actual es incorrecta.');
            return;
        }

        $this->user->update(['password' => $this->password]);
        $this->reset(['current_password', 'password', 'password_confirmation']);
        $this->successMessage = '¡Contraseña cambiada correctamente!';
    }

    public function render()
    {
        return view('livewire.portal.profile')
            ->layout('components.layouts.client');
    }
}
