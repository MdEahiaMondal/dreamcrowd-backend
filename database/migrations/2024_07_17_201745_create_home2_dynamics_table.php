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
        Schema::create('home2_dynamics', function (Blueprint $table) {
            $table->id();
            $table->string('banner_1_heading')->nullable();
            $table->longText('banner_1_description')->nullable();
            $table->string('banner_1_image')->nullable();
            $table->string('banner_1_btn1_name')->nullable();
            $table->string('banner_1_btn1_link')->nullable();
            $table->string('banner_1_btn2_name')->nullable();
            $table->string('banner_1_btn2_link')->nullable();
            $table->string('service_heading')->nullable();
            $table->string('service_tagline')->nullable();
            $table->string('service_link_1')->nullable();
            $table->string('service_link_2')->nullable();
            $table->string('service_link_3')->nullable();
            $table->string('service_link_4')->nullable();
            $table->string('banner_2_heading')->nullable();
            $table->longText('banner_2_description')->nullable();
            $table->string('banner_2_image')->nullable();
            $table->string('banner_2_btn1_name')->nullable();
            $table->string('banner_2_btn1_link')->nullable();
            $table->string('banner_2_btn2_name')->nullable();
            $table->string('banner_2_btn2_link')->nullable();
            $table->string('review_heading')->nullable();
            $table->string('review_tagline')->nullable();
            $table->string('review_image_1')->nullable();
            $table->string('review_name_1')->nullable();
            $table->string('review_designation_1')->nullable();
            $table->string('review_rating_1')->nullable();
            $table->longText('review_review_1')->nullable();
            $table->string('review_image_2')->nullable();
            $table->string('review_name_2')->nullable();
            $table->string('review_designation_2')->nullable();
            $table->string('review_rating_2')->nullable();
            $table->longText('review_review_2')->nullable();
            $table->string('review_image_3')->nullable();
            $table->string('review_name_3')->nullable();
            $table->string('review_designation_3')->nullable();
            $table->string('review_rating_3')->nullable();
            $table->longText('review_review_3')->nullable();
            $table->string('review_image_4')->nullable();
            $table->string('review_name_4')->nullable();
            $table->string('review_designation_4')->nullable();
            $table->string('review_rating_4')->nullable();
            $table->longText('review_review_4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home2_dynamics');
    }
};
