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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->foreignId('office_id')->constrained('offices')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('active'); // e.g., active, inactive, completed
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('priority')->default('medium'); // e.g., low, medium, high
            $table->string('source')->default('manual'); // e.g., manual, automated
            $table->string('recorded_by')->nullable(); // e.g., name or ID of the person who recorded the project
            $table->string('location')->nullable(); // e.g., location where the project was recorded
            $table->string('device_id')->nullable(); // ID of the device used for recording the project
            $table->string('project_type')->default('general'); // e.g., general, emergency
            $table->string('project_source')->default('manual'); // e.g., manual, automated
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
