<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Unifies: create_case_types_table + create_legal_cases_table
     *          + create_case_updates_table + create_case_user_table
     *          + add_title_hours_to_case_updates_table
     *          + add_link_and_file_to_case_updates_table
     */
    public function up(): void
    {
        // -----------------------------------------------------------------------
        // case_types
        // -----------------------------------------------------------------------
        Schema::create('case_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // -----------------------------------------------------------------------
        // legal_cases
        // -----------------------------------------------------------------------
        Schema::create('legal_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->unique();
            $table->string('internal_code')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('service_type_id')->nullable()->constrained('case_types')->nullOnDelete();
            $table->string('priority')->default('medium');   // low | medium | high | critical
            $table->string('status')->default('draft');      // draft | active | suspended | closed
            $table->string('opposing_party')->nullable();
            $table->foreignId('lead_lawyer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('supervisor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('next_deadline_at')->nullable();
            $table->string('billing_type')->default('hourly'); // hourly | fixed | contingency
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('priority');
            $table->index('client_id');
        });

        // -----------------------------------------------------------------------
        // case_updates
        // -----------------------------------------------------------------------
        Schema::create('case_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('legal_cases')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('type')->default('note'); // note | hearing | filing | call | email
            $table->string('title')->nullable();
            $table->text('description');
            $table->string('link')->nullable();
            $table->string('attachment_path')->nullable();
            $table->boolean('is_private')->default(false);
            $table->unsignedSmallInteger('hours')->nullable()->default(0);
            $table->timestamps();
        });

        // -----------------------------------------------------------------------
        // case_user  (pivot: abogados / paralegales asignados)
        // -----------------------------------------------------------------------
        Schema::create('case_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('case_id')->constrained('legal_cases')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('role')->nullable(); // lawyer | paralegal | intern
            $table->timestamps();

            $table->unique(['case_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_user');
        Schema::dropIfExists('case_updates');
        Schema::dropIfExists('legal_cases');
        Schema::dropIfExists('case_types');
    }
};
