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
        // Check if constraint exists before trying to drop it
        $constraintExists = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'users'
            AND CONSTRAINT_NAME = 'users_email_verify_unique'
        ");

        if (!empty($constraintExists)) {
            Schema::table('users', function (Blueprint $table) {
                // Drop the incorrect unique constraint on email_verify
                // This allows multiple users to have 'verified' status
                $table->dropUnique('users_email_verify_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Re-add the unique constraint (not recommended, but for rollback)
            $table->unique('email_verify', 'users_email_verify_unique');
        });
    }
};
