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
        Schema::create('top_seller_tags', function (Blueprint $table) {
            $table->id();
            $table->string('earning')->nullable();
            $table->string('booking')->nullable();
            $table->string('review')->nullable();
            $table->string('sorting_impressions')->nullable();
            $table->string('sorting_clicks')->nullable();
            $table->string('sorting_orders')->nullable();
            $table->string('sorting_reviews')->nullable();
            $table->string('commission')->nullable();
            $table->tinyInteger('buyer_commission')->default(0);
            $table->string('buyer_commission_rate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('top_seller_tags');
    }
};
