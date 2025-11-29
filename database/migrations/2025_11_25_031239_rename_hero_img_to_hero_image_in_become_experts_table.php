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
        // Check if column 'hero_img' exists before renaming
        $columnExists = DB::select("
            SELECT COLUMN_NAME
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'become_experts'
            AND COLUMN_NAME = 'hero_img'
        ");

        if (!empty($columnExists)) {
            Schema::table('become_experts', function (Blueprint $table) {
                $table->renameColumn('hero_img', 'hero_image');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if column 'hero_image' exists before renaming back
        $columnExists = DB::select("
            SELECT COLUMN_NAME
            FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA = DATABASE()
            AND TABLE_NAME = 'become_experts'
            AND COLUMN_NAME = 'hero_image'
        ");

        if (!empty($columnExists)) {
            Schema::table('become_experts', function (Blueprint $table) {
                $table->renameColumn('hero_image', 'hero_img');
            });
        }
    }
};
