<?php

namespace Database\Seeders;

use App\Models\ClientRequest;
use Illuminate\Database\Seeder;

class ClientRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 50 solicitudes de clientes con datos realistas
        ClientRequest::factory()->count(50)->create();
    }
}
