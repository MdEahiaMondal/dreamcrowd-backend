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
        Schema::table('custom_offer_milestones', function (Blueprint $table) {
            // Milestone status: pending, in_progress, delivered, completed, released
            $table->string('status')->default('pending')->after('order');
            $table->timestamp('started_at')->nullable()->after('status');
            $table->timestamp('delivered_at')->nullable()->after('started_at');
            $table->timestamp('completed_at')->nullable()->after('delivered_at');
            $table->timestamp('released_at')->nullable()->after('completed_at'); // Payment released to seller
            $table->text('delivery_note')->nullable()->after('released_at'); // Seller's delivery message
            $table->text('revision_note')->nullable()->after('delivery_note'); // Buyer's revision request
            $table->integer('revisions_used')->default(0)->after('revision_note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_offer_milestones', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'started_at',
                'delivered_at',
                'completed_at',
                'released_at',
                'delivery_note',
                'revision_note',
                'revisions_used',
            ]);
        });
    }
};
