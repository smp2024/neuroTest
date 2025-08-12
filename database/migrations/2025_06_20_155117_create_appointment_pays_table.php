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
        Schema::create('appointment_pays', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('appointment_id')->nullable();
            $table->foreign('appointment_id')
                ->references('id')->on('appointments');
            $table->string('amount')->nullable();
            $table->enum('status_pay', [1, 2, 0])->default(1);
            $table->string('method_payment')->nullable(); // e.g., 'credit_card', 'paypal', etc.
            $table->string('transaction_id')->nullable(); // Unique identifier for the transaction
            $table->string('currency')->default('MXN'); // Currency of the payment
            $table->timestamp('payment_date')->useCurrent(); // Date of the payment
            $table->string('payer_email')->nullable(); // Email of the payer
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_pays');
    }
};
