<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Unifies: create_tasks_table + add_client_id_to_tasks_table
     *          + update_tasks_table_status_column + create_task_user_table
     *          + change_tasks_dates_to_datetime + add_client_request_id_to_tasks_table
     *          + create_task_histories_table + create_task_activities_table
     *          + add_title_and_url_to_task_activities + add_hours_to_task_activities_table
     */
    public function up(): void
    {
        // -----------------------------------------------------------------------
        // tasks
        // -----------------------------------------------------------------------
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->foreignId('status_id')->constrained('task_statuses')->restrictOnDelete();
            $table->datetime('start_date')->nullable();
            $table->datetime('delivery_date')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('client_request_id')->nullable()->constrained('client_requests')->nullOnDelete();
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->index('status_id');
            $table->index('priority');
            $table->index(['status_id', 'order']);
        });

        // -----------------------------------------------------------------------
        // task_user  (pivot: asignados a la tarea)
        // -----------------------------------------------------------------------
        Schema::create('task_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('assignee'); // assignee, watcher …
            $table->timestamps();

            $table->unique(['task_id', 'user_id']);
        });

        // -----------------------------------------------------------------------
        // task_histories
        // -----------------------------------------------------------------------
        Schema::create('task_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained('tasks')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('action'); // created, updated, status_changed, file_uploaded …
            $table->string('field_changed')->nullable();
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->timestamps();

            $table->index('task_id');
            $table->index('created_at');
        });

        // -----------------------------------------------------------------------
        // task_activities
        // -----------------------------------------------------------------------
        Schema::create('task_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['nota', 'llamada', 'imagen', 'documento']);
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->text('content')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('file_size')->nullable();
            $table->unsignedSmallInteger('hours')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_activities');
        Schema::dropIfExists('task_histories');
        Schema::dropIfExists('task_user');
        Schema::dropIfExists('tasks');
    }
};
