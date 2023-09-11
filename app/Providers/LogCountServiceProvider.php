<?php

namespace App\Providers;

use App\Models\Log;
use Illuminate\Support\ServiceProvider;

class LogCountServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $proses = Log::count();
        view()->share('proses', $proses);
    }
}
