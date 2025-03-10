<?php

namespace Sajed13\Commodity\Console\Commands;

use Illuminate\Console\Command;
use Sajed13\Commodity\Http\Controllers\CommodityController;

class FetchCommodities extends Command
{
    protected $signature = 'commodities:fetch';
    protected $description = 'Fetch commodities data every three hours';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Call the method from your controller
        $controller = new CommodityController();
        $controller->fetchCommodities(request());
    }
}
