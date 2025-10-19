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
        Schema::create('teacher_gig_data', function (Blueprint $table) {
            $table->id();
            $table->string('gig_id')->nullable(); 
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('experience_level')->nullable();
            $table->string('class_type')->nullable();
            $table->string('lesson_type')->nullable();
            $table->string('freelance_type')->nullable();
            $table->string('freelance_service')->nullable();
            $table->string('video_call')->nullable();
            $table->string('max_distance')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->longText('requirements')->nullable();
            $table->string('main_file')->nullable();
            $table->string('other')->nullable();
            $table->string('video')->nullable();
            $table->longText('course')->nullable();
            $table->string('resource')->nullable();

            $table->string('payment_type')->nullable();
            $table->string('recurring_type')->nullable();
            $table->string('group_type')->nullable();
            $table->string('service_delivery')->nullable();
            $table->string('work_site')->nullable();
            $table->string('positive_term')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_gig_data');
    }
};
