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
        Schema::create('teacher_gig_payments', function (Blueprint $table) {
            $table->id();
            $table->string('gig_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('rate')->nullable();
            $table->string('earning')->nullable();
            $table->string('public_rate')->nullable();
            $table->string('public_earning')->nullable();
            $table->string('public_group_size')->nullable();
            $table->string('public_discount')->nullable();
            $table->string('private_rate')->nullable();
            $table->string('private_group_size')->nullable();
            $table->string('private_discount')->nullable();
            $table->string('private_earning')->nullable();
            $table->string('duration')->nullable();
            $table->tinyInteger('minor_attend')->default(0);
            $table->string('age_limit')->nullable();
            $table->string('childs')->nullable();
            $table->string('full_available')->nullable();
            // $table->string('group_size')->nullable();
            // $table->string('discount')->nullable();
            $table->string('positive_term')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('revision')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_gig_payments');
    }
};
