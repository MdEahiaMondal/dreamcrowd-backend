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
        Schema::table('class_dates', function (Blueprint $table) {
            $table->text('zoom_link')->nullable()->after('duration')->comment('Zoom meeting join link');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_dates', function (Blueprint $table) {
            $table->dropColumn('zoom_link');
        });
    }
};
