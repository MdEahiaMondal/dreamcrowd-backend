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
        Schema::create('class_dates', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->string('teacher_date')->nullable();
            $table->string('user_date')->nullable();
            $table->string('teacher_time_zone')->nullable();
            $table->string('user_time_zone')->nullable();
            $table->tinyInteger('teacher_attend')->default(0);
            $table->tinyInteger('user_attend')->default(0);
            $table->string('duration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_dates');
    }
};
