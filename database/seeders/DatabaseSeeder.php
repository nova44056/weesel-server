<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
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
        // \App\Models\User::factory(10)->create();

        User::factory(1000)->create();
        // Product::factory(100)->create();
        // Category::factory(10)->create();

        // $categories = Category::all();
        // Product::all()->each(function ($product) use ($categories) {
        //     $product->categories()->attach(
        //         $categories->random(rand(1, 10))->pluck('id')->toArray()
        //     );
        // });
    }
}
