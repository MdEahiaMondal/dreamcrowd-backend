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
        // Add 'disputed' status to the transactions status enum
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'completed', 'refunded', 'failed', 'disputed') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'disputed' status from the transactions status enum
        DB::statement("ALTER TABLE transactions MODIFY COLUMN status ENUM('pending', 'completed', 'refunded', 'failed') DEFAULT 'pending'");
    }
};
