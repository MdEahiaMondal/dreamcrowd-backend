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
        Schema::create('custom_offer_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('custom_offer_id')->constrained('custom_offers')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('revisions')->default(0);
            $table->integer('delivery_days')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();

            // Index for efficient querying
            $table->index(['custom_offer_id', 'order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_offer_milestones');
    }
};
