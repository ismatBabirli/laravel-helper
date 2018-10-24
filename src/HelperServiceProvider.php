<?php

namespace Ismat\Helper;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{


    public function boot(){

        $this->mergeConfigFrom(
            __DIR__ . '/config/iConfig.php', 'iAuth'
        );


        $this->publishes([
            __DIR__ . '/config/iConfig.php' => config_path('iConfig.php'),
        ]);
        $this->commands([

        ]);
        $this->loadRoutesFrom(__DIR__.'/Auth/web.php');

        Validator::extend('base64', function ($attribute, $value, $parameters, $validator) {
            if (preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $value)) {
                return true;
            } else {
                return false;
            }
        });
        Validator::extend('base64image', function ($attribute, $value, $parameters, $validator) {
            $explode = explode(',', $value);
            $allow = config("iConfig.allowed_types");
            $format = str_replace(
                [
                    'data:image/',
                    ';',
                    'base64',
                ],
                [
                    '', '', '',
                ],
                $explode[0]
            );
            // check file format
            if (!in_array($format, $allow)) {
                return false;
            }
            // check base64 format
            if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
                return false;
            }
            return true;
        }, [
            "Incorrect Base64 image format"
        ]);
    }


    public function register()
    {

    }
}
