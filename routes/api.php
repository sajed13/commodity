<?php

use Illuminate\Support\Facades\Route;
use Sajed13\Commodity\Http\Controllers\CommodityController;

Route::get('/commodities', [CommodityController::class, 'fetchCommodities']);
