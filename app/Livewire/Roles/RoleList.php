<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);

        // Prevent deleting Super Admin
        if ($role->name === 'Super Admin') {
            session()->flash('error', 'Cannot delete Super Admin role.');
            return;
        }

        $role->delete();
        session()->flash('success', 'Role deleted successfully.');
    }

    public function render()
    {
        $roles = Role::where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.roles.role-list', [
            'roles' => $roles
        ]);
    }
}
