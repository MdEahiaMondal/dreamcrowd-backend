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
        Schema::table('teacher_gigs', function (Blueprint $table) {
            $table->enum('approval_mode', ['manual', 'instant'])
                ->default('manual')
                ->after('status')
                ->comment('Manual requires seller approval, Instant auto-approves orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_gigs', function (Blueprint $table) {
            $table->dropColumn('approval_mode');
        });
    }
};
