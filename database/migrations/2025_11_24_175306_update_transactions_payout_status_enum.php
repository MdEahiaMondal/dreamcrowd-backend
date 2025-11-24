<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Alter the payout_status ENUM to match code expectations
        // Change from: ['pending', 'paid', 'failed']
        // Change to: ['pending', 'approved', 'completed', 'failed']

        DB::statement("ALTER TABLE `transactions` MODIFY COLUMN `payout_status` ENUM('pending', 'approved', 'completed', 'failed') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original ENUM values
        DB::statement("ALTER TABLE `transactions` MODIFY COLUMN `payout_status` ENUM('pending', 'paid', 'failed') NOT NULL DEFAULT 'pending'");
    }
};
