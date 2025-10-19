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
        Schema::create('become_experts', function (Blueprint $table) {
            $table->id();
            $table->string('hero_heading')->nullable();
            $table->longText('hero_description')->nullable();
            $table->string('hero_btn_link')->nullable();
            $table->string('hero_img')->nullable();
            $table->string('work_heading_1')->nullable();
            $table->longText('work_detail_1')->nullable();
            $table->string('work_image_1')->nullable();
            $table->string('work_heading_2')->nullable();
            $table->longText('work_detail_2')->nullable();
            $table->string('work_image_2')->nullable();
            $table->string('work_heading_3')->nullable();
            $table->longText('work_detail_3')->nullable();
            $table->string('work_image_3')->nullable();
            $table->string('host_heading')->nullable();
            $table->longText('host_description')->nullable();
            $table->string('host_image_1')->nullable();
            $table->string('host_image_2')->nullable();
            $table->string('host_image_3')->nullable();
            $table->string('host_image_4')->nullable();
            $table->string('feature_heading')->nullable();
            $table->string('banner_heading')->nullable();
            $table->string('banner_btn_link')->nullable();
            $table->string('expert_heading')->nullable();
            $table->string('expert_btn_link')->nullable();
            $table->string('expert_image')->nullable();
            $table->tinyInteger('faqs')->default(0);
            $table->tinyInteger('verification_center')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('become_experts');
    }
};
