<?php

namespace App\Http\Controllers;


use App\Services\ShopifyService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShopifyController extends Controller
{
    public function fetchProducts(ShopifyService $shopify)
    {
        try {
            $products = $shopify->getProducts(15);
            dd($products);
        } catch (\Throwable $e) {

            Log::error("Shopify error: " . $e->getMessage());

            return back()->with('error', 'Unable to fetch products, Please try again  later!');
        }
    }
}
