<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public const AVAILABLE_PRODUCT = "available";
    public const UNAVAILABLE_PRODUCT = "unavailable";
    public static $productStatus = [self::AVAILABLE_PRODUCT, self::UNAVAILABLE_PRODUCT];
    protected $fillable = [
        'name',
        'description',
        'seller_id',
        'quantity',
        'price',
        'rating',
        'status',
    ];

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function product_collections()
    {
        return $this->belongsToMany(ProductCollection::class);
    }
}
