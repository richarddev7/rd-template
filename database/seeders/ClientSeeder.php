<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 40 clientes activos + 10 inactivos
        Client::factory()->count(40)->active()->create();
        Client::factory()->count(10)->inactive()->create();
    }
}
