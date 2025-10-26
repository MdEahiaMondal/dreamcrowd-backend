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
            $table->string('duration', 10)->nullable()->after('status')->comment('Class duration HH:MM format');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_gigs', function (Blueprint $table) {
            $table->dropColumn('duration');
        });
    }
};
