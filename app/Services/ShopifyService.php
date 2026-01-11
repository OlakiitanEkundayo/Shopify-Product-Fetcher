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

    public function getProducts($limit = 10, $pageInfo = null)
    {
        /** @var \Illuminate\Http\Client\Response $response */

        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->accessToken
        ])->get($this->baseUrl . 'products.json', [
            'limit' => $limit
        ]);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch products from Shopify. Status:' . $response->status());
        }


        return [
            'products' => $response->json()['products'],
            'next_page_info' => '...extracted from Link header...',
            'prev_page_info' => '...extracted from Link header...',
            'has_next_page' => true / false,
            'has_prev_page' => true / false
        ];
    }
}
