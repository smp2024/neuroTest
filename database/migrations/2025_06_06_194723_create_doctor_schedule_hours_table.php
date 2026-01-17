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
        Schema::create('doctor_schedule_hours', function (Blueprint $table) {
            $table->id();
            $table->string('hour')->nullable(); // e.g., '08:00:00'
            $table->time('hour_start')->nullable(); // e.g., '08:00:00'
            $table->time('hour_end')->nullable(); // e.g., '09:00:00'
            $table->boolean('state')->default(true)->nullable(); // 1 for active, 0 for inactive
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_schedule_hours');
    }
};
