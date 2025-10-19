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
        Schema::create('expert_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->tinyInteger('show_full_name')->default(0);
            $table->string('gender')->nullable();
            $table->string('profession')->nullable();
            $table->string('service_role')->nullable();
            $table->string('service_type')->nullable();
            $table->string('first_service')->default('All Services');
            $table->decimal('latitude')->nullable();
            $table->decimal('longitude')->nullable();
            $table->string('street_address')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->longText('category_class')->nullable();
            $table->longText('sub_category_class')->nullable();
            $table->string('positive_search_class')->nullable();
            $table->longText('category_freelance')->nullable();
            $table->longText('sub_category_freelance')->nullable();
            $table->string('positive_search_freelance')->nullable();
            $table->string('experience')->nullable();
            $table->string('experience_graphic')->nullable();
            $table->string('experience_web')->nullable();
            $table->string('portfolio')->nullable();
            $table->longText('portfolio_url')->nullable();
            $table->string('primary_language')->nullable();
            $table->string('fluent_english')->nullable();
            $table->tinyInteger('speak_other_language')->default(0);
            $table->string('fluent_other_language')->nullable();
            $table->longText('overview')->nullable();
            $table->longText('about_me')->nullable();
            $table->string('main_image')->nullable();
            $table->string('more_image_1')->nullable();
            $table->string('more_image_2')->nullable();
            $table->string('more_image_3')->nullable();
            $table->string('more_image_4')->nullable();
            $table->string('more_image_5')->nullable();
            $table->string('more_image_6')->nullable();
            $table->string('video')->nullable();
            $table->string('option_1')->nullable();
            $table->string('option_2')->nullable();
            $table->string('option_3')->nullable();
            $table->string('app_date')->nullable();
            $table->string('action_date')->nullable();
            $table->tinyInteger('app_type')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expert_profiles');
    }
};
