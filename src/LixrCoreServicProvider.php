<?php

namespace Lixr\Core;

use Illuminate\Support\ServiceProvider;
use Lixr\Core\Commands\GenerateVueRoute;
use Lixr\Core\LixrCoreRouteServiceProvider;

class LixrCoreServicProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateVueRoute::class,
            ]);
        }

        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }
}
