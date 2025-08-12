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
        Schema::create('appointment_attentions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')
                ->references('id')->on('patients');

            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')
                ->references('id')->on('users');

            $table->timestamp('date_appointment')->useCurrent();

            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->foreign('appointment_id')
                ->references('id')->on('appointments');

            $table->text('date_attention')->nullable(); // Notes from the doctor about the attention
            $table->text('prescription')->nullable(); // Prescription details
            $table->text('diagnosis')->nullable(); // Diagnosis made by the doctor
            $table->text('observations')->nullable(); // Additional observations from the doctor
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_attentions');
    }
};
