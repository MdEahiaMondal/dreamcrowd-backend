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
        Schema::create('chat_lists', function (Blueprint $table) {
            $table->id();
            $table->string('teacher')->nullable();
            $table->string('user')->nullable();
            $table->tinyInteger('admin')->default(0);
            $table->longText('sms')->nullable();
            $table->tinyInteger('type')->default(0);
            $table->tinyInteger('block')->default(0);
            $table->string('block_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_lists');
    }
};
