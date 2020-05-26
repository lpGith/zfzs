<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        Validator::extend('phone', function ($attribute, $value, $parameters, $validator) {
            $reg1 = '/^\+86-1[3-9]\d{9}/$';
            $reg2 = '/^1[3-9]\d{9}/$';
            return preg_match($reg1, $value) || preg_match($reg2, $value);
        });

    }
}
