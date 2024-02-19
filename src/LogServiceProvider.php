<?php

namespace Logviewer\Logviewer;
use Illuminate\Support\ServiceProvider;

Class LogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
    }

    public function register(){
        
    }
}

?>