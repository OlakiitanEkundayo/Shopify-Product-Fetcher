<?php

use App\Http\Controllers\ShopifyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/shopify-products', [ShopifyController::class, 'fetchProducts']);
