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
        Schema::create('teacher_gigs', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('title')->nullable();
            $table->string('service_role')->nullable();
            $table->string('service_type')->nullable();
            $table->string('main_file')->nullable();
            $table->string('category')->nullable();
            $table->string('category_name')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('rate')->nullable();
            $table->string('public_rate')->nullable();
            $table->string('private_rate')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('freelance_type')->nullable();
            $table->string('freelance_service')->nullable();
            $table->string('class_type')->nullable();
            $table->string('lesson_type')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('revision')->nullable();
            $table->string('full_available')->nullable();
            $table->date('start_date')->nullable();
            $table->time('start_time')->nullable();
            $table->string('impressions')->default(0);
            $table->string('clicks')->default(0);
            $table->string('cancelation')->default(0);
            $table->string('orders')->default(0);
            $table->string('reviews')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_gigs');
    }
};
