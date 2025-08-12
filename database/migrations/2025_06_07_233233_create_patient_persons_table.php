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
        Schema::create('patient_persons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')
                ->references('id')->on('patients');
            $table->string('type_person')->comment('1: paciente, 2: acompañante, 3: responsable')->default(1);
            $table->string('name_companion')->nullable();
            $table->string('surname_companion')->nullable();
            $table->string('email_companion')->unique()->nullable();
            $table->string('mobile_companion')->nullable();
            $table->string('relationship_companion')->nullable();
            $table->string('name_responsible')->nullable();
            $table->string('surname_responsible')->nullable();
            $table->string('email_responsible')->unique()->nullable();
            $table->string('mobile_responsible')->nullable();
            $table->string('relationship_responsible')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_persons');
    }
};
