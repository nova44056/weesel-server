<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCollection;
use Illuminate\Database\Seeder;

class ProductCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $productCollections = [
            [
                'name' => 'best seller',
            ],
            [
                'name' => 'trending',
            ],
            [
                'name' => 'featured'
            ],
            [
                'name' => 'recommended'
            ],
            [
                'name' => 'promotion'
            ]
        ];
        ProductCollection::insert($productCollections);

        ProductCollection::all()->each(function ($productCollection) {
            for ($i = 0; $i < rand(10, 20); $i++) {
                $product =  Product::where('id', '=', rand(1, 499))->first();
                $product->product_collections()->attach($productCollection);
            }
        });
    }
}
