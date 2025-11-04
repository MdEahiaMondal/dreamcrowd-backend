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
        Schema::create('zoom_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('meeting_id');
            $table->unsignedBigInteger('user_id')->nullable(); // Null for guests
            $table->string('user_email');
            $table->string('user_name');
            $table->enum('role', ['host', 'participant', 'guest'])->default('participant');
            $table->dateTime('join_time');
            $table->dateTime('leave_time')->nullable();
            $table->integer('duration_seconds')->default(0);
            $table->timestamps();

            $table->foreign('meeting_id')->references('id')->on('zoom_meetings')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoom_participants');
    }
};
