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
        Schema::table('book_orders', function (Blueprint $table) {
            $table->unsignedBigInteger('custom_offer_id')->nullable()->after('id');
            $table->foreign('custom_offer_id')
                  ->references('id')
                  ->on('custom_offers')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_orders', function (Blueprint $table) {
            $table->dropForeign(['custom_offer_id']);
            $table->dropColumn('custom_offer_id');
        });
    }
};
