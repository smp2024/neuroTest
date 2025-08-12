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
        Schema::create('office_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('role')->default('staff'); // Example role, can be 'admin', 'staff', etc.
            $table->boolean('is_active')->default(true);
            $table->softDeletes();
            $table->timestamp('joined_at')->nullable(); // When the user joined the office
            $table->timestamp('left_at')->nullable(); // When the user left the office, if applicable
            $table->string('device_id')->nullable(); // ID of the device used for the office user
            $table->string('location')->nullable(); // Location where the office user was recorded
            $table->string('recorded_by')->nullable(); // Name or ID of the person who recorded the office user
            $table->string('source')->default('manual'); // Source of the office user record, e.g., manual, automated
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('office_users');
    }
};
