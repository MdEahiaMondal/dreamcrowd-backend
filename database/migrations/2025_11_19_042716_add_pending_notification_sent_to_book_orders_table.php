<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration adds a field to track if buyer has been notified
     * about order still being pending after 48 hours (CRITICAL-1 fix).
     */
    public function up(): void
    {
        Schema::table('book_orders', function (Blueprint $table) {
            $table->tinyInteger('pending_notification_sent')->default(0)->after('status')
                ->comment('Tracks if buyer was notified about order pending > 48h');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_orders', function (Blueprint $table) {
            $table->dropColumn('pending_notification_sent');
        });
    }
};
