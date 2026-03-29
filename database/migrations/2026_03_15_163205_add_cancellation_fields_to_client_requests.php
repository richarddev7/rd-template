<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('client_requests', function (Blueprint $table) {
            $table->text('cancellation_reason')->nullable()->after('context');
        });

        // Add 'Cancelada' status if it doesn't exist
        DB::table('request_statuses')->updateOrInsert(
            ['slug' => 'cancelada'],
            [
                'name' => 'Cancelada',
                'color' => 'red',
                'icon' => null,
                'order' => 5,
                'is_default' => true,
                'column_classes' => 'bg-red-50 dark:bg-red-900/20',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'Cancelada' status
        DB::table('request_statuses')->where('slug', 'cancelada')->delete();

        Schema::table('client_requests', function (Blueprint $table) {
            $table->dropColumn('cancellation_reason');
        });
    }
};
