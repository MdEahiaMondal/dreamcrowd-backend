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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('buyer_id');
            $table->unsignedBigInteger('service_id')->nullable();
            $table->string('service_type')->default('service'); // 'service' or 'class'

            // Amount details
            $table->decimal('total_amount', 10, 2);
            $table->string('currency', 10)->default('USD');

            // Commission details
            $table->decimal('seller_commission_rate', 5, 2)->comment('Commission % used');
            $table->decimal('seller_commission_amount', 10, 2)->comment('Admin commission from seller');
            $table->decimal('buyer_commission_rate', 5, 2)->default(0);
            $table->decimal('buyer_commission_amount', 10, 2)->default(0)->comment('Admin commission from buyer');
            $table->decimal('total_admin_commission', 10, 2)->comment('Total commission earned');
            $table->decimal('seller_earnings', 10, 2)->comment('Amount seller receives');

            // Stripe details
            $table->decimal('stripe_amount', 10, 2)->comment('Amount in Stripe currency');
            $table->string('stripe_currency', 10)->default('GBP');
            $table->string('stripe_transaction_id')->nullable();
            $table->string('stripe_payout_id')->nullable();

            // Coupon/Discount handling
            $table->decimal('coupon_discount', 10, 2)->default(0);
            $table->boolean('admin_absorbed_discount')->default(0)->comment('Did admin absorb discount?');

            // Status
            $table->enum('status', ['pending', 'completed', 'refunded', 'failed'])->default('pending');
            $table->enum('payout_status', ['pending', 'paid', 'failed'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('payout_at')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('buyer_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes for performance
            $table->index('seller_id');
            $table->index('buyer_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
