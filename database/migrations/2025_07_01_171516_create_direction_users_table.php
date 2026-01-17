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
        Schema::create('direction_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')
                ->references('id')->on('patients');
            $table->text('model')->nullable();
            $table->text('street')->nullable();
            $table->text('exterior_number')->nullable();
            $table->text('interior_number')->nullable();
            $table->text('neighborhood')->nullable();
            $table->text('reference')->nullable();
            $table->text('country')->nullable();
            $table->text('state_code')->nullable();
            $table->text('municipality')->nullable();
            $table->text('locality')->nullable();
            $table->text('postal_code')->nullable();
            $table->text('federal_entity')->nullable();
            $table->text('colony')->nullable();
            $table->text('state')->nullable();
            $table->text('city')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direction_users');
    }
};
