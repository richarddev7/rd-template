<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inicializar el starter kit: migrar, seedear y crear superadmin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando instalación del RD Starter Kit...');

        $this->call('migrate:fresh', ['--force' => true]);
        
        $this->info('Migraciones completadas. Ejecutando seeders principales...');
        $this->call('db:seed', ['--class' => 'RolePermissionSeeder', '--force' => true]);
        $this->call('db:seed', ['--class' => 'SettingsSeeder', '--force' => true]);
        $this->call('db:seed', ['--class' => 'RequestStatusSeeder', '--force' => true]);
        
        $this->info('Seeders completados.');

        $this->info('✅ RD Starter Kit instalado correctamente.');
        $this->comment('Accede con el usuario configurado en tu .env: ' . env('ADMIN_EMAIL', 'admin@example.com'));
    }
}
