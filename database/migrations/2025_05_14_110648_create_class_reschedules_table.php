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
        Schema::create('class_reschedules', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable();
            $table->string('class_id')->nullable();
            $table->string('user_id')->nullable();
            $table->string('teacher_id')->nullable(); 
            $table->string('teacher_date')->nullable();
            $table->string('user_date')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_reschedules');
    }
};
