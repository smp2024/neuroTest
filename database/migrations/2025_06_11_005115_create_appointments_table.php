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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')
                ->references('id')->on('users');

            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')
                ->references('id')->on('patients');

            $table->unsignedBigInteger('specialitie_id')->nullable();
            $table->foreign('specialitie_id')
                ->references('id')->on('specialities');

            $table->unsignedBigInteger('doctor_schedule_join_hour_id')->nullable();
            $table->foreign('doctor_schedule_join_hour_id')
                ->references('id')->on('doctor_schedule_join_hours');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users');

            $table->timestamp('date_appointment')->useCurrent();
            $table->string('amount')->nullable();
            $table->enum('status_pay', [1, 2, 0])->default(1);
            $table->enum('status', [1, 2, 3 ])->default(2);

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
