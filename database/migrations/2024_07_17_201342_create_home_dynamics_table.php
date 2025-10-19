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
        Schema::create('home_dynamics', function (Blueprint $table) {
            $table->id();
            $table->string('site_logo')->nullable();
            $table->string('fav_icon')->nullable();
            $table->tinyInteger('notification_bar')->default(0);
            $table->string('notification_heading')->nullable();
            $table->string('notification')->nullable();
            $table->string('hero_text')->nullable();
            $table->longText('hero_discription')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('hero_note')->nullable();
            $table->string('counter_heading_1')->nullable();
            $table->string('counter_number_1')->nullable();
            $table->string('counter_heading_2')->nullable();
            $table->string('counter_number_2')->nullable();
            $table->string('counter_heading_3')->nullable();
            $table->string('counter_number_3')->nullable();
            $table->string('counter_heading_4')->nullable();
            $table->string('counter_number_4')->nullable();
            $table->string('rating_heading')->nullable();
            $table->string('rating_stars')->nullable();
            $table->string('rating_image_1')->nullable();
            $table->string('rating_image_2')->nullable();
            $table->string('rating_image_3')->nullable();
            $table->string('rating_image_4')->nullable();
            $table->string('rating_image_5')->nullable();
            $table->string('rating_image_6')->nullable();

            
            $table->string('work_heading')->nullable();
            $table->string('work_tagline')->nullable();
            $table->string('work_image_1')->nullable();
            $table->string('work_heading_1')->nullable();
            $table->longText('work_description_1')->nullable();
            $table->string('work_image_2')->nullable();
            $table->string('work_heading_2')->nullable();
            $table->longText('work_description_2')->nullable();
            $table->string('work_image_3')->nullable();
            $table->string('work_heading_3')->nullable();
            $table->longText('work_description_3')->nullable();
            $table->string('category_heading')->nullable();
            $table->string('category_tagline')->nullable();
            $table->string('category_image_1')->nullable();
            $table->string('category_name_1')->nullable();
            $table->string('category_image_2')->nullable();
            $table->string('category_name_2')->nullable();
            $table->string('category_image_3')->nullable();
            $table->string('category_name_3')->nullable();
            $table->string('category_image_4')->nullable();
            $table->string('category_name_4')->nullable();
            $table->string('category_image_5')->nullable();
            $table->string('category_name_5')->nullable();
            $table->string('category_image_6')->nullable();
            $table->string('category_name_6')->nullable();
            $table->string('category_image_7')->nullable();
            $table->string('category_name_7')->nullable();
            $table->string('category_image_8')->nullable();
            $table->string('category_name_8')->nullable();
            $table->string('expert_heading')->nullable();
            $table->string('expert_tagline')->nullable();
            $table->string('expert_link_1')->nullable();
            $table->string('expert_link_2')->nullable();
            $table->string('expert_link_3')->nullable();
            $table->string('expert_link_4')->nullable();
            $table->string('expert_link_5')->nullable();
            $table->string('expert_link_6')->nullable();
            $table->string('expert_link_7')->nullable();
            $table->string('expert_link_8')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_dynamics');
    }
};
