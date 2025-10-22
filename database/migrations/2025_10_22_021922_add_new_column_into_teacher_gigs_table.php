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
            $table->enum('meeting_platform', ['Zoom', 'Google'])
                ->nullable()
                ->after('class_type')
                ->comment('For Live Online Classes');

            $table->enum('trial_type', ['Free', 'Paid'])
                ->nullable()
                ->after('payment_type')
                ->comment('For Trial Classes');
        });

        Schema::table('teacher_gig_data', function (Blueprint $table) {
            $table->enum('meeting_platform', ['Zoom', 'Google'])
                ->nullable()
                ->after('class_type')
                ->comment('For Live Online Classes');

            $table->enum('trial_type', ['Free', 'Paid'])
                ->nullable()
                ->after('recurring_type')
                ->comment('For Trial Classes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teacher_gigs', function (Blueprint $table) {
            $table->dropColumn(['meeting_platform', 'trial_type']);
        });
        Schema::table('teacher_gig_data', function (Blueprint $table) {
            $table->dropColumn(['meeting_platform', 'trial_type']);
        });
    }
};
