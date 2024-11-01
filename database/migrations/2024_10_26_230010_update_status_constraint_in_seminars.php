<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('seminars', function (Blueprint $table) {
            // Drop the existing status column with the old constraint
            $table->dropColumn('status');
        });

        Schema::table('seminars', function (Blueprint $table) {
            // Re-add the status column with the updated constraint
            $table->string('status')->default('planned')->checkIn(['planned', 'upcoming', 'completed']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminars', function (Blueprint $table) {
            // Drop the modified column
            $table->dropColumn('status');
        });

        Schema::table('seminars', function (Blueprint $table) {
            // Revert to the original constraint, if needed
            $table->string('status')->default('upcoming')->checkIn(['upcoming', 'completed']);
        });
    }
};
