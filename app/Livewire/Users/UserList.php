<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';

    public $showPasswordModal = false;
    public $userToUpdate = null;
    public $password = '';
    public $password_confirmation = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting self
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        $user->delete();
        session()->flash('success', 'User deleted successfully.');
    }

    public function confirmPasswordChange($userId)
    {
        $this->userToUpdate = User::findOrFail($userId);
        $this->password = '';
        $this->password_confirmation = '';
        $this->showPasswordModal = true;
    }

    public function updatePassword()
    {
        $this->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        if ($this->userToUpdate) {
            $this->userToUpdate->update([
                'password' => Hash::make($this->password),
            ]);

            $this->showPasswordModal = false;
            $this->userToUpdate = null;
            $this->password = '';
            $this->password_confirmation = '';

            $this->dispatch('notify', variant: 'success', message: 'Password updated successfully.');
        }
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->roleFilter, function ($query) {
                $query->role($this->roleFilter);
            })
            ->with('roles')
            ->orderBy('name')
            ->paginate(10);

        $roles = Role::orderBy('name')->get();

        return view('livewire.users.user-list', [
            'users' => $users,
            'roles' => $roles
        ]);
    }
}
