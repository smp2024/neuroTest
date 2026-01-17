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
        Schema::create('form_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id')->nullable();
            $table->foreign('form_id')
                ->references('id')->on('forms');
            $table->string('question_text')->nullable();
            $table->enum('question_type', ['text', 'number', 'date', 'select', 'checkbox', 'radio'])->default('text')->nullable();
            $table->integer('order')->default(0)->nullable();
            $table->text('options')->nullable();
            $table->text('category')->nullable();
            $table->boolean('active')->default(true)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_questions');
    }
};
