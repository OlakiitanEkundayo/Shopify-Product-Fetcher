<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ShopifyService
{
    private $baseUrl;
    private $accessToken;

    public function __construct()
    {
        $this->baseUrl = config('services.shopify.shop_domain');
        $this->accessToken = config('services.shopify.access_token');
    }

    public function getProducts($limit = 10)
    {
        /** @var \Illuminate\Http\Client\Response $response */

        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->accessToken
        ])->get($this->baseUrl . 'products.json', [
            'limit' => $limit
        ]);

        if ($response->successful()) {
            return $response->json()['products'];
        }
    }
}
