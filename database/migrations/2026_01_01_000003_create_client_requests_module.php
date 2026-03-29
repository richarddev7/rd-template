<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     * Unifies: create_request_statuses_table + create_client_requests_table
     *          + add_documents_to_client_requests_table
     *          + add_contact_fields_to_client_requests_table
     *          + add_source_to_client_requests_table
     *          + add_status_to_client_requests_table
     *          + add_date_fields_to_client_requests_table
     *          + create_client_request_user_table
     *          + make_client_id_nullable_in_client_requests_table
     *          + make_created_by_nullable_in_client_requests_table
     */
    public function up(): void
    {
        // -----------------------------------------------------------------------
        // request_statuses
        // -----------------------------------------------------------------------
        Schema::create('request_statuses', function (Blueprint $table) {
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

        DB::table('request_statuses')->insert([
            ['name' => 'Pendiente',   'slug' => 'pendiente',   'color' => 'gray',   'order' => 1, 'is_default' => true, 'column_classes' => 'bg-gray-50 dark:bg-gray-800',       'created_at' => now(), 'updated_at' => now()],
            ['name' => 'En Progreso', 'slug' => 'en_progreso', 'color' => 'blue',   'order' => 2, 'is_default' => true, 'column_classes' => 'bg-blue-50 dark:bg-blue-900/20',     'created_at' => now(), 'updated_at' => now()],
            ['name' => 'En Revisión', 'slug' => 'en_revision', 'color' => 'yellow', 'order' => 3, 'is_default' => true, 'column_classes' => 'bg-yellow-50 dark:bg-yellow-900/20', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Completada',  'slug' => 'completada',  'color' => 'green',  'order' => 4, 'is_default' => true, 'column_classes' => 'bg-green-50 dark:bg-green-900/20',   'created_at' => now(), 'updated_at' => now()],
        ]);

        // -----------------------------------------------------------------------
        // client_requests
        // -----------------------------------------------------------------------
        Schema::create('client_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('status_id')->constrained('request_statuses')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('request_date');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('deadline_date')->nullable();
            $table->string('title');
            $table->string('responsible');
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('source')->nullable();
            $table->longText('context');
            $table->text('expected_result_description')->nullable();
            $table->json('request_types')->nullable();
            $table->json('expected_results')->nullable();
            $table->json('documents')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('client_id');
            $table->index('status_id');
            $table->index('request_date');
            $table->index('created_by');
        });

        // -----------------------------------------------------------------------
        // client_request_user  (pivot: usuarios asignados a la solicitud)
        // -----------------------------------------------------------------------
        Schema::create('client_request_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_request_id')->constrained('client_requests')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['client_request_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_request_user');
        Schema::dropIfExists('client_requests');
        Schema::dropIfExists('request_statuses');
    }
};
