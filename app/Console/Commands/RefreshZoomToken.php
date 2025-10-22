<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class RefreshZoomToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-zoom-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // app/Console/Commands/RefreshZoomToken.php
        $response = Http::asForm()->post('https://zoom.us/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $user->zoom_refresh_token,
        ])->withBasicAuth(env('ZOOM_CLIENT_ID'), env('ZOOM_CLIENT_SECRET'))->json();

    }
}
