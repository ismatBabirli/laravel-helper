<?php

namespace Ismat\Helper;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{


    public function boot(){

        $this->mergeConfigFrom(
            __DIR__.'/config/iAuth.php', 'iAuth'
        );


        $this->publishes([
            __DIR__.'/config/iAuth.php' => config_path('iAuth.php'),
        ]);
        $this->commands([

        ]);
        $this->loadRoutesFrom(__DIR__.'/Auth/web.php');

    }


    public function register()
    {

    }
}
