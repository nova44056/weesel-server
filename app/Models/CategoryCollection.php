<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryCollection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id'
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
