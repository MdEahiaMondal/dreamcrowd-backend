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
        Schema::table('custom_offers', function (Blueprint $table) {
            // Parent offer reference for counter offers
            $table->unsignedBigInteger('parent_offer_id')->nullable()->after('id');
            $table->foreign('parent_offer_id')->references('id')->on('custom_offers')->onDelete('cascade');

            // Counter offer flag
            $table->boolean('is_counter_offer')->default(false)->after('parent_offer_id');

            // Counter offer message from buyer
            $table->text('counter_message')->nullable()->after('rejection_reason');

            // Timestamp when counter was sent
            $table->timestamp('counter_sent_at')->nullable()->after('counter_message');

            // Index for better query performance
            $table->index(['parent_offer_id', 'is_counter_offer']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_offers', function (Blueprint $table) {
            $table->dropIndex(['parent_offer_id', 'is_counter_offer']);
            $table->dropForeign(['parent_offer_id']);
            $table->dropColumn(['parent_offer_id', 'is_counter_offer', 'counter_message', 'counter_sent_at']);
        });
    }
};
