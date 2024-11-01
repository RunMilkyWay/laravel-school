<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->time('time')->nullable(); // Time of the seminar
            $table->string('speakers')->nullable(); // Speaker names
            $table->string('location')->nullable(); // Location of the seminar
            $table->unsignedBigInteger('created_by');
            $table->string('status')->default('planned'); // Planned, upcoming, concluded
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seminars');
    }
};
