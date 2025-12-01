<?php

namespace App\Console\Commands;

use App\Jobs\UpdateExchangeRates;
use Illuminate\Console\Command;

class UpdateCurrencyRateByAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-currency-rate-by-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'payment currency rate update';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        dispatch(new UpdateExchangeRates());
    }
}
