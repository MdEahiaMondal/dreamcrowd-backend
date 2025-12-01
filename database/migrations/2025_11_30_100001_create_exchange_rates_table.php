<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('exchange_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_currency_id')->constrained('currencies')->onDelete('cascade');
            $table->foreignId('to_currency_id')->constrained('currencies')->onDelete('cascade');
            $table->decimal('rate', 15, 6);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['from_currency_id', 'to_currency_id']);
        });

        // Seed initial exchange rates (USD <-> GBP)
        $usd = DB::table('currencies')->where('code', 'USD')->first();
        $gbp = DB::table('currencies')->where('code', 'GBP')->first();

        if ($usd && $gbp) {
            DB::table('exchange_rates')->insert([
                [
                    'from_currency_id' => $usd->id,
                    'to_currency_id' => $gbp->id,
                    'rate' => 0.79, // Initial rate - will be updated by API
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'from_currency_id' => $gbp->id,
                    'to_currency_id' => $usd->id,
                    'rate' => 1.27, // Initial rate - will be updated by API
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};
