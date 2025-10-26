<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('teacher_gig_payments', function (Blueprint $table) {
            $table->boolean('is_trial')->default(0)->after('duration')->comment('Is this a trial class');
            $table->string('trial_type')->nullable()->after('is_trial')->comment('Trial class type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_gig_payments', function (Blueprint $table) {
            $table->dropColumn(['is_trial', 'trial_type']);
        });
    }
};
