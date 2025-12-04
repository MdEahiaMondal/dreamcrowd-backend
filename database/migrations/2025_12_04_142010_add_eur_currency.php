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
        // Add EUR to currencies table
        DB::table('currencies')->insert([
            'code' => 'EUR',
            'name' => 'Euro',
            'symbol' => '€',
            'symbol_position' => 'before',
            'decimal_places' => 2,
            'is_default' => false,
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Get currency IDs
        $usd = DB::table('currencies')->where('code', 'USD')->first();
        $gbp = DB::table('currencies')->where('code', 'GBP')->first();
        $eur = DB::table('currencies')->where('code', 'EUR')->first();

        if ($usd && $eur) {
            // Add USD to EUR rate
            DB::table('exchange_rates')->insert([
                'from_currency_id' => $usd->id,
                'to_currency_id' => $eur->id,
                'rate' => 0.92,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add EUR to USD rate
            DB::table('exchange_rates')->insert([
                'from_currency_id' => $eur->id,
                'to_currency_id' => $usd->id,
                'rate' => 1.09,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        if ($gbp && $eur) {
            // Add GBP to EUR rate
            DB::table('exchange_rates')->insert([
                'from_currency_id' => $gbp->id,
                'to_currency_id' => $eur->id,
                'rate' => 1.17,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Add EUR to GBP rate
            DB::table('exchange_rates')->insert([
                'from_currency_id' => $eur->id,
                'to_currency_id' => $gbp->id,
                'rate' => 0.86,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Get EUR currency ID
        $eur = DB::table('currencies')->where('code', 'EUR')->first();

        if ($eur) {
            // Remove exchange rates involving EUR
            DB::table('exchange_rates')
                ->where('from_currency_id', $eur->id)
                ->orWhere('to_currency_id', $eur->id)
                ->delete();

            // Remove EUR currency
            DB::table('currencies')->where('code', 'EUR')->delete();
        }
    }
};
