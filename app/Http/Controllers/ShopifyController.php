<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ShopifyController extends Controller
{
    public function fetchProducts()
    {
        // $response = Http::get('https://kiitan-store-2.myshopify.com/admin/api/2026-01/product.json');

        $response = Http::withHeader(
            [
                'X-Shopify-Access-Token' => 'SHOPIFY_ACCESS_TOKEN'
            ]
        )->get('https://kiitan-store-2.myshopify.com/admin/api/2026-01/product.json');
        dd($response->products);
    }
}
