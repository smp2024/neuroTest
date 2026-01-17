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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('paternal_surname')->nullable();
            $table->string('maternal_surname')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->nullable();
            $table->string('gender')->nullable();
            $table->string('education')->nullable();
            $table->string('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('n_document')->nullable();
            $table->string('avatar')->nullable();
            $table->string('antecedent_family')->nullable();
            $table->string('antecedent_personal')->nullable();
            $table->string('antecedent_allergic')->nullable();
            $table->string('pa', 50)->comment('presión arterial')->nullable();
            $table->string('temperatura', 50)->comment('temperatura')->nullable();
            $table->string('fc', 50)->comment('frecuencia cardiaca')->nullable();
            $table->string('fr', 50)->comment('frecuencia respiratoria')->nullable();
            $table->string('ta', 50)->comment('temperatura ambiente')->nullable();
            $table->string('peso')->nullable();
            $table->string('current_disease', 50)->comment('padecimiento actual')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
