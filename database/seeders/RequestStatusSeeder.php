<?php

namespace Database\Seeders;

use App\Models\RequestStatus;
use Illuminate\Database\Seeder;

class RequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Pendiente',
                'slug' => 'pendiente',
                'color' => 'gray',
                'icon' => null,
                'order' => 1,
                'is_default' => true,
                'column_classes' => 'bg-gray-50 dark:bg-gray-900/20',
            ],
            [
                'name' => 'En Progreso',
                'slug' => 'en_progreso',
                'color' => 'blue',
                'icon' => null,
                'order' => 2,
                'is_default' => true,
                'column_classes' => 'bg-blue-50 dark:bg-blue-900/20',
            ],
            [
                'name' => 'En Revisión',
                'slug' => 'en_revision',
                'color' => 'yellow',
                'icon' => null,
                'order' => 3,
                'is_default' => true,
                'column_classes' => 'bg-yellow-50 dark:bg-yellow-900/20',
            ],
            [
                'name' => 'Completada',
                'slug' => 'completada',
                'color' => 'green',
                'icon' => null,
                'order' => 4,
                'is_default' => true,
                'column_classes' => 'bg-green-50 dark:bg-green-900/20',
            ],
            [
                'name' => 'Cancelada',
                'slug' => 'cancelada',
                'color' => 'red',
                'icon' => null,
                'order' => 5,
                'is_default' => true,
                'column_classes' => 'bg-red-50 dark:bg-red-900/20',
            ],
        ];

        foreach ($statuses as $status) {
            RequestStatus::updateOrCreate(
                ['slug' => $status['slug']],
                $status
            );
        }
    }
}
