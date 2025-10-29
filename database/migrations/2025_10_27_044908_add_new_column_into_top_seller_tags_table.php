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
        Schema::table('top_seller_tags', function (Blueprint $table) {
            if (!Schema::hasColumn('top_seller_tags', 'commission_type')) {
                $table->enum('commission_type', ['seller', 'buyer', 'both'])->default('seller')->after('buyer_commission_rate');
            }

            if (!Schema::hasColumn('top_seller_tags', 'currency')) {
                $table->string('currency', 10)->default('USD')->after('commission_type');
            }

            if (!Schema::hasColumn('top_seller_tags', 'stripe_currency')) {
                $table->string('stripe_currency', 10)->default('GBP')->after('currency')->comment('Stripe account currency');
            }

            if (!Schema::hasColumn('top_seller_tags', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('stripe_currency');
            }

            if (!Schema::hasColumn('top_seller_tags', 'enable_custom_seller_commission')) {
                $table->boolean('enable_custom_seller_commission')->default(0)->after('is_active')->comment('Allow custom commission per seller');
            }

            if (!Schema::hasColumn('top_seller_tags', 'enable_custom_service_commission')) {
                $table->boolean('enable_custom_service_commission')->default(0)->after('enable_custom_seller_commission')->comment('Allow custom commission per service');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('top_seller_tags', function (Blueprint $table) {
            $table->dropColumn([
                'commission_type',
                'currency',
                'stripe_currency',
                'is_active',
                'enable_custom_seller_commission',
                'enable_custom_service_commission'
            ]);
        });
    }
};
