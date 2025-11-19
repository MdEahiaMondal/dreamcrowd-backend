<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration fixes LOG-1: Seller Listing Null Teacher Data
     * by cleaning up orphaned teacher_gigs records and adding foreign key constraints.
     */
    public function up(): void
    {
        // Step 1: Log orphaned gigs before deletion
        $orphanedGigs = DB::table('teacher_gigs as tg')
            ->leftJoin('users as u', 'tg.user_id', '=', 'u.id')
            ->whereNull('u.id')
            ->select('tg.id', 'tg.title', 'tg.user_id')
            ->get();

        Log::info('LOG-1 Fix: Orphaned teacher_gigs found', [
            'count' => $orphanedGigs->count(),
            'gigs' => $orphanedGigs->toArray()
        ]);

        // Step 2: Soft delete orphaned gigs (set status to 0 instead of hard delete)
        $affected = DB::table('teacher_gigs')
            ->whereNotIn('user_id', function($query) {
                $query->select('id')->from('users');
            })
            ->update(['status' => 0]);

        Log::info('LOG-1 Fix: Orphaned teacher_gigs soft-deleted', [
            'affected_count' => $affected
        ]);

        // Step 3: Check if foreign key constraint already exists before adding
        // Note: SQLite doesn't support adding foreign keys to existing tables
        // This will only work for MySQL/PostgreSQL
        $driver = DB::connection()->getDriverName();

        if ($driver !== 'sqlite') {
            try {
                // Check if constraint exists
                $constraintExists = DB::select("
                    SELECT CONSTRAINT_NAME
                    FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
                    WHERE TABLE_NAME = 'teacher_gigs'
                    AND CONSTRAINT_NAME = 'teacher_gigs_user_id_foreign'
                ");

                if (empty($constraintExists)) {
                    Schema::table('teacher_gigs', function (Blueprint $table) {
                        $table->foreign('user_id')
                              ->references('id')
                              ->on('users')
                              ->onDelete('cascade')
                              ->onUpdate('cascade');
                    });

                    Log::info('LOG-1 Fix: Foreign key constraint added to teacher_gigs.user_id');
                } else {
                    Log::info('LOG-1 Fix: Foreign key constraint already exists, skipping');
                }
            } catch (\Exception $e) {
                Log::warning('LOG-1 Fix: Could not add foreign key constraint', [
                    'error' => $e->getMessage()
                ]);
            }
        } else {
            Log::info('LOG-1 Fix: SQLite detected - foreign key constraints cannot be added to existing tables');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver !== 'sqlite') {
            try {
                Schema::table('teacher_gigs', function (Blueprint $table) {
                    $table->dropForeign(['user_id']);
                });
            } catch (\Exception $e) {
                Log::warning('LOG-1 Rollback: Could not drop foreign key constraint', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Note: We don't restore the deleted gigs as they were invalid data
        Log::info('LOG-1 Rollback: Foreign key constraint dropped (orphaned gigs remain deleted)');
    }
};
