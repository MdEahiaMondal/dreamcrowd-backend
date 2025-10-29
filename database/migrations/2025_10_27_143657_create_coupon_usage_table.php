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
        Schema::create('coupon_usage', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coupon_id');
            $table->string('coupon_code');
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('seller_id')->nullable();
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable(); // If you have orders table
            $table->decimal('discount_amount', 10, 2)->comment('Actual discount applied');
            $table->decimal('original_amount', 10, 2)->comment('Amount before discount');
            $table->decimal('final_amount', 10, 2)->comment('Amount after discount');
            $table->timestamp('used_at')->useCurrent();
            $table->timestamps();

            // Foreign keys
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('set null');

            // Indexes
            $table->index('coupon_id');
            $table->index('buyer_id');
            $table->index('used_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_usage');
    }
};
