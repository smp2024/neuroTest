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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specialitie_id')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('surname')->nullable();
            $table->string('paternal_surname')->nullable();
            $table->string('maternal_surname')->nullable();
            $table->string('mobile')->nullable();
            $table->date('birth_date')->nullable();
            $table->boolean('gender')->nullable();
            $table->string('education')->nullable();
            $table->string('designation')->nullable();
            $table->text('address')->nullable();
            $table->text('cp')->nullable();
            $table->text('street')->nullable();
            $table->text('colony')->nullable();
            $table->text('state')->nullable();
            $table->text('city')->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
