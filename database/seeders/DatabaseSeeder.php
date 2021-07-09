<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductImage;
use App\Models\User;
use Database\Factories\CategoryFactory;
use Database\Factories\ProductCollectionFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        // \App\Models\User::factory(10)->create();
        DB::table('users')->truncate();
        DB::table('categories')->truncate();
        DB::table('products')->truncate();
        DB::table('transactions')->truncate();
        DB::table('category_product')->truncate();
        DB::table('product_product_collection')->truncate();

        // \App\Models\User::factory(10)->create();


        ProductCollection::insert(ProductCollectionFactory::productCollections);
        User::factory(100)->create();
        Category::insert(CategoryFactory::parentCategories);
        Category::insert(CategoryFactory::alcoholChildren);
        Category::insert(CategoryFactory::bakeryChildren);
        Category::insert(CategoryFactory::beverageChildren);
        Category::insert(CategoryFactory::fruitChildren);
        Product::factory(500)->create();
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

        ProductCollection::all()->each(function ($productCollection) {
            for ($i = 0; $i < rand(10, 20); $i++) {
                $product =  Product::where('id', '=', rand(1, 499))->first();
                $product->product_collections()->attach($productCollection);
            }
        });
    }
}
