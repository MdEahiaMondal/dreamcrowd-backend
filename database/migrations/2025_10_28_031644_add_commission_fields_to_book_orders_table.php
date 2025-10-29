<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('book_orders', function (Blueprint $table) {
            // Buyer commission fields
            if (!Schema::hasColumn('book_orders', 'buyer_commission_rate')) {
                $table->decimal('buyer_commission_rate', 5, 2)->default(0)->after('price');
            }
            if (!Schema::hasColumn('book_orders', 'buyer_commission_amount')) {
                $table->decimal('buyer_commission_amount', 10, 2)->default(0)->after('buyer_commission_rate');
            }

            // Seller commission fields
            if (!Schema::hasColumn('book_orders', 'seller_commission_rate')) {
                $table->decimal('seller_commission_rate', 5, 2)->default(0)->after('buyer_commission_amount');
            }
            if (!Schema::hasColumn('book_orders', 'seller_commission_amount')) {
                $table->decimal('seller_commission_amount', 10, 2)->default(0)->after('seller_commission_rate');
            }

            // Total admin commission
            if (!Schema::hasColumn('book_orders', 'total_admin_commission')) {
                $table->decimal('total_admin_commission', 10, 2)->default(0)->after('seller_commission_amount');
            }

            // Seller earnings
            if (!Schema::hasColumn('book_orders', 'seller_earnings')) {
                $table->decimal('seller_earnings', 10, 2)->default(0)->after('total_admin_commission');
            }

            // Admin absorbed discount flag
            if (!Schema::hasColumn('book_orders', 'admin_absorbed_discount')) {
                $table->boolean('admin_absorbed_discount')->default(0)->after('discount');
            }

            // Payment status
            if (!Schema::hasColumn('book_orders', 'payment_status')) {
                $table->enum('payment_status', ['pending', 'completed', 'failed', 'refunded'])->default('pending')->after('payment_id');
            }
            $table->renameColumn('coupen', 'coupon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_orders', function (Blueprint $table) {
            $table->dropColumn([
                'buyer_commission_rate',
                'buyer_commission_amount',
                'seller_commission_rate',
                'seller_commission_amount',
                'total_admin_commission',
                'seller_earnings',
                'admin_absorbed_discount',
                'payment_status',
            ]);
        });
    }
};
