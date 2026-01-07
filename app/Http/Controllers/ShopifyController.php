<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Services\ShopifyService;
use Illuminate\Support\Facades\Http;

class ShopifyController extends Controller
{
    public function fetchProducts(ShopifyService $shopify)
    {
        $products = $shopify->getProducts(10);
        dd($products);
    }
}
