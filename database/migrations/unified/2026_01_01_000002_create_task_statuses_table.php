<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('task_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('color', 50)->default('blue');
            $table->string('icon', 50)->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_default')->default(false);
            $table->text('column_classes')->nullable();
            $table->timestamps();
        });

        DB::table('task_statuses')->insert([
            ['name' => 'Pendiente',    'slug' => 'pending',      'color' => 'gray',   'order' => 1, 'is_default' => true, 'column_classes' => 'bg-gray-50 dark:bg-gray-800',         'created_at' => now(), 'updated_at' => now()],
            ['name' => 'En Progreso',  'slug' => 'in_progress',  'color' => 'blue',   'order' => 2, 'is_default' => true, 'column_classes' => 'bg-blue-50 dark:bg-blue-900/20',       'created_at' => now(), 'updated_at' => now()],
            ['name' => 'En Revisión',  'slug' => 'under_review', 'color' => 'yellow', 'order' => 3, 'is_default' => true, 'column_classes' => 'bg-yellow-50 dark:bg-yellow-900/20',   'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bloqueada',    'slug' => 'blocked',      'color' => 'red',    'order' => 4, 'is_default' => true, 'column_classes' => 'bg-red-50 dark:bg-red-900/20',         'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Completada',   'slug' => 'completed',    'color' => 'green',  'order' => 5, 'is_default' => true, 'column_classes' => 'bg-green-50 dark:bg-green-900/20',     'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_statuses');
    }
};
