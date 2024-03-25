<?php

namespace Logviewer\Logviewer;
use Illuminate\Support\ServiceProvider;
use Logviewer\Logviewer\Http\Middleware\CheckLogin;

Class LogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'logviewer');
        // Register the 'auth' middleware alias
        $this->app['router']->aliasMiddleware('auth', CheckLogin::class);
    }

    public function register()
    {
        //
    }
}
