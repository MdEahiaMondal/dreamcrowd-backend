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
        Schema::create('zoom_settings', function (Blueprint $table) {
            $table->id();
            $table->text('client_id'); // Encrypted
            $table->text('client_secret'); // Encrypted
            $table->string('redirect_uri');
            $table->string('account_id')->nullable();
            $table->string('base_url')->default('https://api.zoom.us/v2');
            $table->text('webhook_secret')->nullable(); // Encrypted
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('updated_by')->nullable(); // Admin user ID
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoom_settings');
    }
};
