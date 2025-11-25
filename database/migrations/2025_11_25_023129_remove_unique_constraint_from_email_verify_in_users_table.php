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
        Schema::table('users', function (Blueprint $table) {
            // Drop the incorrect unique constraint on email_verify
            // This allows multiple users to have 'verified' status
            $table->dropUnique('users_email_verify_unique');
        });
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
