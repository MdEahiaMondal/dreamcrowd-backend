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
            $table->timestamp('seller_accepted_at')->nullable()->after('counter_sent_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_offers', function (Blueprint $table) {
            $table->dropColumn('seller_accepted_at');
        });
    }
};
