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
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->string('facebook_link')->nullable();
            $table->tinyInteger('facebook_status')->default(0);
            $table->string('insta_link')->nullable();
            $table->tinyInteger('insta_status')->default(0);
            $table->string('twitter_link')->nullable();
            $table->tinyInteger('twitter_status')->default(0);
            $table->string('youtube_link')->nullable();
            $table->tinyInteger('youtube_status')->default(0);
            $table->string('tiktok_link')->nullable();
            $table->tinyInteger('tiktok_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};
