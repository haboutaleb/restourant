<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema, View;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        View::composer('*', function($view){
          return $view->with('auth', auth()->user());
        });
    }

    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
