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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('currency', 10)->default('USD');

            // Withdrawal method: stripe, paypal, bank_transfer
            $table->enum('method', ['stripe', 'paypal', 'bank_transfer'])->default('stripe');

            // Status: pending, processing, completed, failed, cancelled
            $table->enum('status', ['pending', 'processing', 'completed', 'failed', 'cancelled'])->default('pending');

            // Payment details (JSON for flexibility)
            $table->json('payment_details')->nullable(); // stores email, account_id, bank details etc.

            // Transaction IDs from payment providers
            $table->string('stripe_transfer_id')->nullable();
            $table->string('paypal_payout_id')->nullable();
            $table->string('bank_reference')->nullable();

            // Admin processing
            $table->foreignId('processed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('processed_at')->nullable();

            // Notes and reason (for failed/cancelled)
            $table->text('seller_notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->text('failure_reason')->nullable();

            // Fee tracking
            $table->decimal('processing_fee', 10, 2)->default(0);
            $table->decimal('net_amount', 10, 2); // amount - processing_fee

            $table->timestamps();

            // Indexes
            $table->index(['seller_id', 'status']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdrawals');
    }
};
