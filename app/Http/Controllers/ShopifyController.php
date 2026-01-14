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
            $page_Info = request()->query('page_info');

            $data = $shopify->getProducts(10, $page_Info);

            $products = $data['products'];
            $nextPageInfo = $data['next_page_info'];
            $prevPageInfo = $data['prev_page_info'];
            $hasNextPage = $data['has_next_page'];
            $hasPrevPage = $data['has_prev_page'];

            return view('products.index', [
                'products' => $products,
                'nextPageInfo' => $nextPageInfo,
                'prevPageInfo' => $prevPageInfo,
                'hasNextPage' => $hasNextPage,
                'hasPrevPage' => $hasPrevPage
            ]);
            // dd($products);
        } catch (\Throwable $e) {

            Log::error("Shopify error: " . $e->getMessage());

            return back()->with('error', 'Unable to fetch products, Please try again  later!');
        }
    }
}
