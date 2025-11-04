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
        Schema::create('zoom_meetings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('class_date_id')->nullable();
            $table->unsignedBigInteger('teacher_id');
            $table->string('meeting_id')->unique(); // Zoom meeting ID
            $table->string('meeting_password')->nullable();
            $table->text('join_url');
            $table->text('start_url');
            $table->string('host_email');
            $table->string('topic');
            $table->dateTime('start_time');
            $table->integer('duration'); // Minutes
            $table->string('timezone')->default('Asia/Dhaka');
            $table->enum('status', ['scheduled', 'started', 'ended', 'cancelled'])->default('scheduled');
            $table->dateTime('actual_start_time')->nullable();
            $table->dateTime('actual_end_time')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('book_orders')->onDelete('cascade');
            $table->foreign('class_date_id')->references('id')->on('class_dates')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zoom_meetings');
    }
};
