<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //if (\App::environment(['staging', 'production'])) {
        //    \URL::forceScheme('https');
        //}
        
        if (\App::environment('production')) {
            \URL::forceScheme('https');
        }
        
        
    }
}
