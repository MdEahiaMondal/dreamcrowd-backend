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
        Schema::create('teacher_profile_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_id')->unique()->nullable();
            $table->string('profile_image')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->tinyInteger('show_full_name')->default(0);
            $table->string('gender')->nullable();
            $table->string('profession')->nullable();
            $table->string('first_service')->nullable();
            $table->string('primary_language')->nullable();
            $table->string('fluent_english')->nullable();
            $table->tinyInteger('speak_other_language')->default(0);
            $table->string('other_language')->nullable();
            $table->string('main_image')->nullable();
            $table->string('more_image_1')->nullable();
            $table->string('more_image_2')->nullable();
            $table->string('more_image_3')->nullable();
            $table->string('more_image_4')->nullable();
            $table->string('more_image_5')->nullable();
            $table->string('more_image_6')->nullable();
            $table->string('video')->nullable();
            $table->longText('overview')->nullable();
            $table->longText('about_me')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_profile_requests');
    }
};
