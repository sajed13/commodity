<?php

namespace Sajed13\Commodity;

use Illuminate\Support\ServiceProvider;

class CommodityServiceProvider extends ServiceProvider
{
    protected $commands = [
        \Sajed13\Commodity\Console\Commands\FetchCommodities::class,
    ];
    public function boot()
    {
        // routes and migrations
        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }

    public function register()
    {
        $this->commands($this->commands);
    }
}
