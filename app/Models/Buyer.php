<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends User
{
    protected $table = 'users';
    public function orders()
    {
        return $this->hasMany(Order::class)->with("products");
    }
}
