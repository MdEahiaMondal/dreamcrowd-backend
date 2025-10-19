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
        Schema::create('booking_durations', function (Blueprint $table) {
            $table->id();
            $table->string('class_online')->nullable();
            $table->string('class_inperson')->nullable();
            $table->string('class_oneday')->nullable();
            $table->string('freelance_online_normal')->nullable();
            $table->string('freelance_online_consultation')->nullable();
            $table->string('freelance_inperson')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_durations');
    }
};
