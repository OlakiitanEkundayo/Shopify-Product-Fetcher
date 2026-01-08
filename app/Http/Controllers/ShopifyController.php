<?php

namespace App\Http\Controllers;


use App\Services\ShopifyService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShopifyController extends Controller
{
    public function index(ShopifyService $shopify)
    {
        try {
            $products = $shopify->getProducts(15);

            return view('products.index', ['products' => $products]);
            // dd($products);
        } catch (\Throwable $e) {

            Log::error("Shopify error: " . $e->getMessage());

            return back()->with('error', 'Unable to fetch products, Please try again  later!');
        }
    }
}
