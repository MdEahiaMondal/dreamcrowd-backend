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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon_name');
            $table->string('coupon_code')->unique();
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('discount_value', 10, 2)->comment('Percentage or fixed amount');
            $table->date('start_date');
            $table->date('expiry_date');
            $table->enum('coupon_type', ['seller-wide', 'custom'])->default('seller-wide');
            $table->string('seller_email')->nullable()->comment('For custom seller-specific coupons');
            $table->unsignedBigInteger('seller_id')->nullable()->comment('Seller ID if custom');
            $table->boolean('is_active')->default(1);
            $table->boolean('one_time_use')->default(0)->comment('Can be used only once per user');
            $table->integer('usage_limit')->nullable()->comment('Total usage limit (null = unlimited)');
            $table->integer('usage_count')->default(0)->comment('Number of times used');
            $table->decimal('total_discount_given', 12, 2)->default(0)->comment('Total discount amount given');
            $table->text('description')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('coupon_code');
            $table->index('is_active');
            $table->index(['start_date', 'expiry_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
