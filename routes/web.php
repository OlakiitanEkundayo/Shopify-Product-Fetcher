<?php

use App\Http\Controllers\ShopifyController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ShopifyController::class, 'index']);

Route::post('/sync', [ShopifyController::class, 'sync']);
