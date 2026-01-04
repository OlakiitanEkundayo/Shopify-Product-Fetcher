<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ShopifyController extends Controller
{
    public function fetchProducts()
    {
        $response = Http::get('https://kiitan-store-2.myshopify.com/');
        dd($response);
    }
}
