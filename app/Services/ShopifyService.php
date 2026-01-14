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
        $params = ['limit' => $limit];
        if ($pageInfo) {
            $params['page_info'] = $pageInfo;
        }
        /** @var \Illuminate\Http\Client\Response $response */


        $response = Http::withHeaders([
            'X-Shopify-Access-Token' => $this->accessToken
        ])->get($this->baseUrl . 'products.json', $params);

        if ($response->failed()) {
            throw new \Exception('Failed to fetch products from Shopify. Status:' . $response->status());
        }
        // Get the Link header
        $linkHeader = $response->header('Link');

        $nextPageInfo = null;
        $prevPageInfo = null;

        if ($linkHeader) {

            // Split by comma to separate links
            $links = explode(', ', $linkHeader);

            // Loop through each link
            foreach ($links as $link) {

                // Extract the URL (between < and >)
                $start = strpos($link, '<') + 1;
                $end = strpos($link, '>');
                $url = substr($link, $start, $end - $start);

                // Parse the URL to get query parameters
                $urlParts = parse_url($url);

                // Check if query exists
                if (isset($urlParts['query'])) {
                    parse_str($urlParts['query'], $queryParams);

                    // Check if this is the "next" link
                    if (strpos($link, 'rel="next"') !== false) {
                        $nextPageInfo = $queryParams['page_info'] ?? null;
                    }

                    // Check if this is the "prev" link
                    if (strpos($link, 'rel="previous"') !== false) {
                        $prevPageInfo = $queryParams['page_info'] ?? null;
                    }
                }
            }
        }

        return [
            'products' => $response->json()['products'],
            'next_page_info' => $nextPageInfo,
            'prev_page_info' => $prevPageInfo,
            'has_next_page' => $nextPageInfo !== null,
            'has_prev_page' => $prevPageInfo !== null
        ];
    }
}
