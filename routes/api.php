<?php

use Illuminate\Support\Facades\Route;
use Sajed13\Commodity\Http\Controllers\CommodityController;

Route::prefix('api/v1')->group(function () {
    Route::get('/commodities', [CommodityController::class, 'fetchCommodities']);
});
