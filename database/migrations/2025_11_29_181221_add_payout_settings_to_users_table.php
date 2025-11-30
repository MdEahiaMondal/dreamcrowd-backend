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
        Schema::table('users', function (Blueprint $table) {
            // Stripe Connect
            $table->string('stripe_account_id')->nullable()->after('email');
            $table->boolean('stripe_payouts_enabled')->default(false)->after('stripe_account_id');

            // PayPal
            $table->string('paypal_email')->nullable()->after('stripe_payouts_enabled');

            // Bank Transfer details (encrypted JSON)
            $table->text('bank_details')->nullable()->after('paypal_email');

            // Preferred withdrawal method
            $table->enum('preferred_payout_method', ['stripe', 'paypal', 'bank_transfer'])->nullable()->after('bank_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_account_id',
                'stripe_payouts_enabled',
                'paypal_email',
                'bank_details',
                'preferred_payout_method'
            ]);
        });
    }
};
