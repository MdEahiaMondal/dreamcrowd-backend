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
        Schema::create('zoom_secure_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_date_id');
            $table->unsignedBigInteger('user_id')->nullable(); // Null for guests
            $table->text('token'); // Encrypted JWT
            $table->string('email');
            $table->dateTime('expires_at');
            $table->dateTime('used_at')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->foreign('class_date_id')->references('id')->on('class_dates')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoom_secure_tokens');
    }
};
