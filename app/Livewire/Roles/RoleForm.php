<?php

namespace App\Livewire\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleForm extends Component
{
    public ?Role $role = null;
    public $name = '';
    public $description = '';
    public $selectedPermissions = [];

    public function mount(Role $role = null)
    {
        if ($role && $role->exists) {
            $this->role = $role;
            $this->name = $role->name;
            $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        }
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|unique:roles,name,' . ($this->role?->id),
            'selectedPermissions' => 'array'
        ]);

        if ($this->role) {
            $this->role->update(['name' => $this->name]);
            $this->role->syncPermissions($this->selectedPermissions);
            $message = 'Role updated successfully.';
        } else {
            $role = Role::create(['name' => $this->name]);
            $role->syncPermissions($this->selectedPermissions);
            $message = 'Role created successfully.';
        }

        session()->flash('success', $message);
        return redirect()->route('roles.index');
    }

    public function render()
    {
        $permissions = Permission::all();
        return view('livewire.roles.role-form', [
            'permissions' => $permissions
        ]);
    }
}
