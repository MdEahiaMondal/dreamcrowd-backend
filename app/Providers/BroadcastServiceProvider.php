<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register broadcast routes with authentication middleware
        Broadcast::routes(['middleware' => ['web', 'auth']]);

        // Load channel authorization routes
        require base_path('routes/channels.php');
    }
}