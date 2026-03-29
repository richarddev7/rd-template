<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar caché de roles/permisos
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Permisos de Usuarios y Roles ──
        Permission::firstOrCreate(['name' => 'view users']);
        Permission::firstOrCreate(['name' => 'create users']);
        Permission::firstOrCreate(['name' => 'edit users']);
        Permission::firstOrCreate(['name' => 'delete users']);
        Permission::firstOrCreate(['name' => 'manage users']);
        
        Permission::firstOrCreate(['name' => 'view roles']);
        Permission::firstOrCreate(['name' => 'create roles']);
        Permission::firstOrCreate(['name' => 'edit roles']);
        Permission::firstOrCreate(['name' => 'delete roles']);
        Permission::firstOrCreate(['name' => 'assign permissions']);

        // ── Permisos de App ──
        Permission::firstOrCreate(['name' => 'view settings']);
        Permission::firstOrCreate(['name' => 'edit settings']);

        // ── Permisos de Cliente y Solicitudes (Conservados) ──
        Permission::firstOrCreate(['name' => 'view clients']);
        Permission::firstOrCreate(['name' => 'create clients']);
        Permission::firstOrCreate(['name' => 'edit clients']);
        Permission::firstOrCreate(['name' => 'delete clients']);

        Permission::firstOrCreate(['name' => 'view requests']);
        Permission::firstOrCreate(['name' => 'create requests']);
        Permission::firstOrCreate(['name' => 'edit requests']);
        Permission::firstOrCreate(['name' => 'delete requests']);

        // ── Rol Super Admin ──
        $roleAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $roleAdmin->syncPermissions(Permission::all());

        // ── Rol Cliente ──
        $roleClient = Role::firstOrCreate(['name' => 'Cliente']);
        $roleClient->syncPermissions([
            'view requests',
            'create requests',
        ]);

        // ── Usuario Super Admin ──
        $user = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@example.com')],
            [
                'name'              => env('ADMIN_NAME', 'Super Admin'),
                'password'          => Hash::make(env('ADMIN_PASSWORD', 'password')),
                'email_verified_at' => now(),
            ]
        );
        $user->assignRole($roleAdmin);
    }
}
