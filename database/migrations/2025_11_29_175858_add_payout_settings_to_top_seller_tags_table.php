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
        Schema::table('top_seller_tags', function (Blueprint $table) {
            $table->integer('holding_period_days')->default(14)->after('buyer_commission_rate');
            $table->decimal('minimum_withdrawal', 10, 2)->default(25.00)->after('holding_period_days');
            $table->boolean('auto_payout_enabled')->default(true)->after('minimum_withdrawal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('top_seller_tags', function (Blueprint $table) {
            $table->dropColumn(['holding_period_days', 'minimum_withdrawal', 'auto_payout_enabled']);
        });
    }
};
