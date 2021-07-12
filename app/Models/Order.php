<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'address_1',
        'address_2',
        'phone_number',
        'district',
        'city',
        'payment_method',
        'aba_transaction_id',
        'user_id'
    ];
    function products()
    {
        return $this->belongsToMany(Product::class, "order_product")->withPivot("order_product_quantity");
    }

    function sellers()
    {
        return $this->belongsToMany(Seller::class);
    }

    function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }
}
