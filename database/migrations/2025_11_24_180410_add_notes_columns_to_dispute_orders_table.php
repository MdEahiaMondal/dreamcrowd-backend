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
        Schema::table('dispute_orders', function (Blueprint $table) {
            $table->text('user_reason')->nullable()->after('reason');
            $table->text('teacher_reason')->nullable()->after('user_reason');
            $table->text('admin_notes')->nullable()->after('teacher_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dispute_orders', function (Blueprint $table) {
            $table->dropColumn(['user_reason', 'teacher_reason', 'admin_notes']);
        });
    }
};
