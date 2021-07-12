<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Product::factory(1000)->create();

        Product::all()->each(function ($product) {
            $parentCategories =
                Category::where('parent_id', '=', null)->get()->random(1)->pluck('id');
            $childrenCategories = Category::where('parent_id', '=', $parentCategories[0])->get();
            if (count($childrenCategories) > 0) {
                $childrenCategories = $childrenCategories->random(1, count($childrenCategories))->pluck('id');
            }
            $categories = array_merge($parentCategories->toArray(), $childrenCategories->toArray());
            $product->categories()->attach($categories);
            for ($i = 0; $i < rand(1, 5); $i++) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'url' => 'https://weesel.s3.ap-southeast-1.amazonaws.com/category/placeholder-square.jpg'
                ]);
            }
        });

        /**
         * generating discounts for product
         */
        Product::all()->random(100)->each(function ($product) {
            $product->discount = rand(10, 20);
            $product->save();
        });
    }
}
