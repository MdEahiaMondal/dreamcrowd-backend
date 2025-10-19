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
        Schema::create('expert_fast_payments', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('cvv')->nullable();
            $table->string('date')->nullable();
            $table->tinyInteger('return')->default(0); 
            $table->tinyInteger('status')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expert_fast_payments');
    }
};
