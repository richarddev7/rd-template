<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Infraestructura base
        $this->call(RolePermissionSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(RequestStatusSeeder::class);

        // Datos de negocio (Módulos de Cliente/Solicitud conservados)
        $this->call(ClientSeeder::class);
        $this->call(ClientRequestSeeder::class);
    }
}
