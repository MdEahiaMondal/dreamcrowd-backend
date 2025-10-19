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
        Schema::create('about_us_dynamics', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('section_1')->default(0);
            $table->string('image_heading')->nullable();
            $table->string('cover_image_1')->nullable();
            $table->longText('about')->nullable();
            $table->tinyInteger('section_2')->default(0);
            $table->string('cover_image_2')->nullable();
            $table->string('tag_line')->nullable();
            $table->string('heading_1')->nullable();
            $table->longText('details_1')->nullable();
            $table->string('heading_2')->nullable();
            $table->longText('details_2')->nullable();
            $table->string('heading_3')->nullable();
            $table->longText('details_3')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us_dynamics');
    }
};
