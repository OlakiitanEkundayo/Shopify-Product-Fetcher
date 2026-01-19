<?php

namespace App\Services;

use App\Services\ShopifyService;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class SyncService
{
    /**
     * Create a new class instance.
     */

    private $shopify;
    public function __construct(ShopifyService $shopify)
    {
        $this->shopify = $shopify;
    }

    public function syncProducts()
    {
        $pageInfo = null;
        $totalSynced = 0;
        $pageCount = 0;
        try {
            Log::info('Starting product sync...');

            do {
                $pageCount++;
                Log::info("Fetching page {$pageCount}...");

                $data = $this->shopify->getProducts(50, $pageInfo);
                foreach ($data['products'] as $shopifyProduct) {

                    $shopifyId = $shopifyProduct['id'];
                    $title = $shopifyProduct['title'];

                    $vendor = $shopifyProduct['vendor'] ?? null;
                    $productType = $shopifyProduct['product_type'] ?? null;
                    $status = $shopifyProduct['status'] ?? 'draft';

                    $imageUrl = $shopifyProduct['image']['src'] ?? null;

                    $price = isset($shopifyProduct['variants'][0]) ?
                        $shopifyProduct['variants'][0]['price'] : null;

                    $stockQuantity = isset($shopifyProduct['variants'][0]) ?
                        $shopifyProduct['variants'][0]['inventory_quantity'] : null;

                    Product::updateOrCreate(['shopify_id' => $shopifyId], [
                        'title' => $title,
                        'vendor' => $vendor,
                        'product_type' => $productType,
                        'status' => $status,
                        'image_url' => $imageUrl,
                        'price' => $price,
                        'stock_quantity' => $stockQuantity,
                        'raw_data' => $shopifyProduct,
                        'synced_at' => now()
                    ]);
                    $totalSynced++;
                }

                $pageInfo = $data['next_page_info'];
            } while ($pageInfo !== null);
            Log::info("Sync complete! Synced {$totalSynced} products across {$pageCount} pages");

            return $totalSynced;
        } catch (\Exception $e) {
            Log::error('Sync failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
