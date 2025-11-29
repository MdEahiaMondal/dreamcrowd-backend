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
        Schema::create('admin_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade')->comment('Admin who performed the action');
            $table->foreignId('target_admin_id')->nullable()->constrained('users')->onDelete('set null')->comment('Admin being acted upon (if applicable)');
            $table->string('activity_type', 50)->comment('e.g., admin_created, admin_updated, admin_deleted, role_changed, etc.');
            $table->text('activity_description')->nullable()->comment('Human-readable description');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->json('metadata')->nullable()->comment('Additional context (old/new values, etc.)');
            $table->timestamps();

            $table->index(['admin_id', 'created_at']);
            $table->index('target_admin_id');
            $table->index('activity_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_activities');
    }
};
