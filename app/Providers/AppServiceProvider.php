<?php

namespace App\Providers;

use App\Services\SucursalService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('app.env') === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }

        $this->app->bind('SucursalService', function () {
            return new SucursalService();
        });

    }
}
