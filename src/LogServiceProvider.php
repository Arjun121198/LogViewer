<?php

namespace Logviewer\Logviewer;
use Illuminate\Support\ServiceProvider;
use Logviewer\Logviewer\Http\Middleware\CheckLogin;
use Logviewer\Logviewer\Http\Middleware\Login;

Class LogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'logviewer');
        // Register the 'auth' middleware alias
        $this->app['router']->aliasMiddleware('login', Login::class);
        $this->app['router']->aliasMiddleware('auth', CheckLogin::class);
    }

    public function register() 
    {
        $this->publishes([
            __DIR__.'/config/logviewer.php' => config_path('logviewer.php'),
        ]);
        $this->publishes([
            __DIR__.'/public/css/log-viewer.css' => public_path('css/log-viewer.css'),
        ], 'public');
    }
}
