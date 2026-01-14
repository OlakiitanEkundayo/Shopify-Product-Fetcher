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
        'stock_quantity',
        'image_url',
        'status'
    ];
}
