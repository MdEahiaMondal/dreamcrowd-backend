<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->string('service_type')->default('service')->comment('service or class');
            $table->decimal('commission_rate', 5, 2)->default(15.00)->comment('Custom service commission %');
            $table->boolean('is_active')->default(1);
            $table->text('notes')->nullable()->comment('Admin notes');
            $table->timestamps();
            $table->foreign('service_id')->references('id')->on('teacher_gigs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_commissions');
    }
};
