<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;

class RouteServiceProvider extends ServiceProvider
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
        $this->configureRateLimiting();

        // $this->routes(function () {
        //     Route::middleware('web')->group(base_path('routes/web.php'));

        //     Route::middleware('api')->prefix('api')->group(base_path('routes/api.php'));

        //     Route::middleware('web')->prefix('admin')->namespace($this->namespace)->group(base_path('routes/admin.php'));
        // });
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            if ($request->isMethod('get')) {
                return Limit::perMinute(60);
            }
            return Limit::perMinute(10);
        });
    }
}
