<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Unifies: create_event_types_table + create_events_table
     *          + rename_datetime_columns_in_events_table
     *          + add_event_type_and_created_by_to_events_table
     *          + drop_created_by_from_events_table
     *          + add_banner_path_to_events_table
     *          + create_event_user_table
     */
    public function up(): void
    {
        // -----------------------------------------------------------------------
        // event_types
        // -----------------------------------------------------------------------
        Schema::create('event_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color_code', 7)->default('#3B82F6'); // Hex #RRGGBB
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // -----------------------------------------------------------------------
        // events
        // -----------------------------------------------------------------------
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('banner_path')->nullable();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime')->nullable();
            $table->string('location')->nullable();
            $table->foreignId('event_type_id')->constrained('event_types')->cascadeOnDelete();
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('start_datetime');
            $table->index('event_type_id');
        });

        // -----------------------------------------------------------------------
        // event_user  (pivot: invitados al evento)
        // -----------------------------------------------------------------------
        Schema::create('event_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['pending', 'confirmed', 'declined'])->default('pending');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->unique(['event_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_user');
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_types');
    }
};
