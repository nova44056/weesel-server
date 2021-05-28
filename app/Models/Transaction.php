<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    public function buyer()
    {
        $this->belongsTo(Buyer::class);
    }
    public function product()
    {
        $this->belongsTo(Product::class);
    }
}
