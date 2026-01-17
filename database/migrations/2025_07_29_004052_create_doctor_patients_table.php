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
        Schema::create('doctor_patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignId('office_id')->constrained('offices')->onDelete('cascade');
            $table->string('relationship')->default('primary'); // e.g., primary, secondary
            $table->string('status')->default('active'); // e.g., active, inactive
            $table->text('notes')->nullable(); // Additional notes about the relationship
            $table->timestamp('started_at')->nullable(); // When the relationship started
            $table->timestamp('ended_at')->nullable(); // When the relationship ended, if applicable
            $table->string('source')->default('manual'); // e.g., manual, automated
            $table->string('recorded_by')->nullable(); // e.g., name or ID of the person who recorded the relationship
            $table->string('location')->nullable(); // e.g., location where the relationship was established
            $table->string('device_id')->nullable(); // ID of the device used for recording the relationship
            $table->string('vital_signs_type')->default('general'); // e.g., general, emergency
            $table->string('vital_signs_source')->default('manual'); // e.g., manual, automated
            $table->string('vital_signs_device_id')->nullable(); // ID of the device used for recording vital signs
            $table->string('vital_signs_recorded_by')->nullable(); // e.g., name or ID of the person who recorded the vital signs
            $table->string('vital_signs_location')->nullable(); // e.g., location where the vital signs were recorded

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_patients');
    }
};
