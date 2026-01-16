<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'shopify_id',
        'title',
        'vendor',
        'product_type',
        'price',
        'image_url',
        'status',
        'stock_quantity',
        'raw_data',
        'synced_at'
    ];

    protected $casts = [
        'raw_data' => 'array',
        'synced_at' => 'datetime',
        'price' => 'decimal:2',
        'stock_quantity' => 'integer'
    ];
}
