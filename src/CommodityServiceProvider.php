<?php

namespace Sajed13\Commodity;

use Illuminate\Support\ServiceProvider;

class CommodityServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // routes and migrations
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }

    public function register()
    {
        //
    }
}
