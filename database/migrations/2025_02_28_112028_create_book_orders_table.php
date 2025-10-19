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
        Schema::create('book_orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('gig_id')->nullable();
            $table->string('teacher_id')->nullable();
            $table->longText('zoom_link')->nullable();
            $table->string('title')->nullable();
            $table->string('frequency')->nullable();
            $table->string('group_type')->nullable();
            $table->string('emails')->nullable();
            $table->string('extra_guests')->nullable();
            $table->string('guests')->nullable();
            $table->string('childs')->nullable();
            $table->string('total_people')->nullable();
            $table->string('service_delivery')->nullable();
            $table->longText('work_site')->nullable();
            $table->string('price')->nullable();
            $table->string('buyer_commission')->nullable();
            $table->string('coupen')->nullable();
            $table->string('discount')->nullable();
            $table->string('finel_price')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('holder_name')->nullable();
            $table->string('card_number')->nullable();
            $table->string('cvv')->nullable();
            $table->string('date')->nullable();
            $table->string('action_date')->nullable();
            $table->tinyInteger('teacher_reschedule')->default(0);
            $table->tinyInteger('user_reschedule')->default(0);
            $table->tinyInteger('teacher_reschedule_time')->default(0);
            $table->tinyInteger('user_dispute')->default(0);
            $table->tinyInteger('teacher_dispute')->default(0);
            $table->tinyInteger('refund')->default(0); 
            $table->tinyInteger('start_job')->default(0); 
            $table->string('status')->default(0);
             $table->boolean('auto_dispute_processed')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_orders');
    }
};
