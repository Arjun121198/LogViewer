<?php

namespace Logviewer\Logviewer;
use Illuminate\Support\ServiceProvider;

Class LogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'logviewer');
    }

    public function register(){
       
    }
}

?>