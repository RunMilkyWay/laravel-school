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
            $table->time('time')->nullable(); // Time of the day
            $table->string('speakers')->nullable(); // Speakers (can be a comma-separated list if multiple)
            $table->string('location')->nullable(); // Location of the seminar
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seminars', function (Blueprint $table) {
            $table->dropColumn(['time', 'speakers', 'location']);
        });
    }
};
