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
            // Ban tracking fields
            $table->timestamp('banned_at')->nullable()->after('status');
            $table->text('banned_reason')->nullable()->after('banned_at');

            // Activity tracking
            $table->timestamp('last_active_at')->nullable()->after('deleted_at');

            // Active status flag
            $table->boolean('is_active')->default(true)->after('last_active_at');
        });

        // Note: status and deleted_at columns already exist
        // The status column is currently a tinyint but will be treated as enum in the application layer
        // We'll use integer values mapped to enum strings in the model
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'banned_at',
                'banned_reason',
                'last_active_at',
                'is_active'
            ]);
        });
    }
};
