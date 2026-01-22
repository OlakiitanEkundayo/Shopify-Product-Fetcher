<?php

namespace App\Http\Controllers;


use App\Services\ShopifyService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Services\SyncService;

class ShopifyController extends Controller
{
    public function index(ShopifyService $shopify)
    {
        try {
            $products = Product::paginate(15);
            // $page_Info = request()->query('page_info');

            // $data = $shopify->getProducts(10, $page_Info);

            // $products = $data['products'];
            // $nextPageInfo = $data['next_page_info'];
            // $prevPageInfo = $data['prev_page_info'];
            // $hasNextPage = $data['has_next_page'];
            // $hasPrevPage = $data['has_prev_page'];

            // return view('products.index', [
            //     'products' => $products,
            //     'nextPageInfo' => $nextPageInfo,
            //     'prevPageInfo' => $prevPageInfo,
            //     'hasNextPage' => $hasNextPage,
            //     'hasPrevPage' => $hasPrevPage
            // ]);

            return view('products.index', ['products' => $products]);
        } catch (\Throwable $e) {

            Log::error("Shopify error: " . $e->getMessage());

            return back()->with('error', 'Unable to fetch products, Please try again  later!');
        }
    }

    public function sync(SyncService $sync)
    {
        try {

            $count = $sync->syncProducts();

            return redirect('/')->with('success', "{$count} products synced successfully!");
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'An error occured:' . $e->getMessage());
        }
    }
}
