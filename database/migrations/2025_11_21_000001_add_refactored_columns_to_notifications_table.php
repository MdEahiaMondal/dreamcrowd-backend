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
        // First, remove old columns if they exist
        Schema::table('notifications', function (Blueprint $table) {
            if (Schema::hasColumn('notifications', 'buyer_id')) {
                $table->dropForeign(['buyer_id']);
                $table->dropColumn('buyer_id');
            }
            if (Schema::hasColumn('notifications', 'seller_id')) {
                $table->dropForeign(['seller_id']);
                $table->dropColumn('seller_id');
            }
            if (Schema::hasColumn('notifications', 'priority')) {
                $table->dropColumn('priority');
            }
            if (Schema::hasColumn('notifications', 'channels')) {
                $table->dropColumn('channels');
            }
        });

        // Drop existing foreign keys if they exist (from old migration)
        Schema::table('notifications', function (Blueprint $table) {
            // Try to drop old foreign keys
            try {
                if (Schema::hasColumn('notifications', 'order_id')) {
                    $table->dropForeign(['order_id']);
                }
                if (Schema::hasColumn('notifications', 'service_id')) {
                    $table->dropForeign(['service_id']);
                }
                if (Schema::hasColumn('notifications', 'sent_by_admin_id')) {
                    $table->dropForeign(['sent_by_admin_id']);
                }
            } catch (\Exception $e) {
                // Foreign key might not exist, continue
            }
        });

        // Now add new columns
        Schema::table('notifications', function (Blueprint $table) {
            // Actor and Target users (NEW - replaces buyer_id/seller_id)
            if (!Schema::hasColumn('notifications', 'actor_user_id')) {
                $table->unsignedBigInteger('actor_user_id')->nullable()->after('user_id')
                    ->comment('User who performed the action');
            }
            if (!Schema::hasColumn('notifications', 'target_user_id')) {
                $table->unsignedBigInteger('target_user_id')->nullable()->after('actor_user_id')
                    ->comment('User affected by the action');
            }

            // Related entities
            if (!Schema::hasColumn('notifications', 'order_id')) {
                $table->unsignedBigInteger('order_id')->nullable()->after('target_user_id');
            }
            if (!Schema::hasColumn('notifications', 'service_id')) {
                $table->unsignedBigInteger('service_id')->nullable()->after('order_id');
            }

            // Emergency flag (NEW - replaces priority enum)
            if (!Schema::hasColumn('notifications', 'is_emergency')) {
                $table->boolean('is_emergency')->default(false)->after('type');
            }

            // Email sent flag (NEW - replaces channels JSON)
            if (!Schema::hasColumn('notifications', 'sent_email')) {
                $table->boolean('sent_email')->default(true)->after('is_emergency')
                    ->comment('Whether email notification was sent');
            }

            // Admin tracking
            if (!Schema::hasColumn('notifications', 'sent_by_admin_id')) {
                $table->unsignedBigInteger('sent_by_admin_id')->nullable()->after('data');
            }

            // Scheduling capability
            if (!Schema::hasColumn('notifications', 'scheduled_at')) {
                $table->timestamp('scheduled_at')->nullable()->after('sent_by_admin_id');
            }
        });

        // Add foreign key constraints and indexes
        Schema::table('notifications', function (Blueprint $table) {
            try {
                $table->foreign('actor_user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('target_user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('order_id')->references('id')->on('book_orders')->onDelete('set null');
                $table->foreign('service_id')->references('id')->on('teacher_gigs')->onDelete('set null');
                $table->foreign('sent_by_admin_id')->references('id')->on('users')->onDelete('set null');
            } catch (\Exception $e) {
                // Foreign key might already exist
            }

            // Indexes for performance
            try {
                $table->index('actor_user_id');
                $table->index('target_user_id');
                $table->index('order_id');
                $table->index('service_id');
                $table->index('type');
                $table->index('is_emergency');
            } catch (\Exception $e) {
                // Index might already exist
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['actor_user_id']);
            $table->dropForeign(['target_user_id']);
            $table->dropForeign(['order_id']);
            $table->dropForeign(['service_id']);
            $table->dropForeign(['sent_by_admin_id']);

            // Drop indexes
            $table->dropIndex(['actor_user_id']);
            $table->dropIndex(['target_user_id']);
            $table->dropIndex(['order_id']);
            $table->dropIndex(['service_id']);
            $table->dropIndex(['type']);
            $table->dropIndex(['is_emergency']);

            // Drop columns
            $table->dropColumn([
                'actor_user_id',
                'target_user_id',
                'order_id',
                'service_id',
                'is_emergency',
                'sent_email',
                'sent_by_admin_id',
                'scheduled_at'
            ]);
        });
    }
};
