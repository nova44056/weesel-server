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

        User::factory(100)->create();
        // $categories = [
        //     [
        //         // id = 1
        //         'name' => 'Bakery',
        //         'parent_id' => null
        //     ],
        //     [
        //         // id = 2
        //         'name' => 'Bread',
        //         'parent_id' => 1
        //     ],
        //     [
        //         // id = 3
        //         'name' => 'Chocolate',
        //         'parent_id' => 1
        //     ],
        //     [
        //         // id = 4
        //         'name' => 'Cracker | Biscuits | Cookies',
        //         'parent_id' => 1
        //     ],
        //     [
        //         // id = 5
        //         'name' => 'Crumbs Special',
        //         'parent_id' => 1
        //     ],
        //     [
        //         // id = 6
        //         'name' => 'Eggs',
        //         'parent_id' => 1
        //     ],            [
        //         // id = 7
        //         'name' => 'Flour',
        //         'parent_id' => 1
        //     ],            [
        //         // id = 8
        //         'name' => 'Pastry',
        //         'parent_id' => 1
        //     ],
        //     [
        //         // id = 9
        //         'name' => 'Sugar',
        //         'parent_id' => 1
        //     ],
        //     [
        //         // id = 10
        //         'name' => 'Fruits',
        //         'parent_id' => null
        //     ],
        //     [
        //         // id = 11
        //         'name' => 'Seasonal Fruits',
        //         'parent_id' => 10
        //     ],
        //     [
        //         // id = 12
        //         'name' => 'Vegetables',
        //         'parent_id' => null
        //     ],
        //     [
        //         // id = 13
        //         'name' => 'Beans | Okra | Eggplant',
        //         'parent_id' => 12
        //     ],
        //     [
        //         // id = 14
        //         'name' => 'Broccoli | Cabbage | Cauliflower',
        //         'parent_id' => 12
        //     ],
        //     [
        //         // id = 15
        //         'name' => 'Herb | Chilli | Aromatics',
        //         'parent_id' => 12
        //     ],
        //     [
        //         // id = 16
        //         'name' => 'Leafy Greens',
        //         'parent_id' => 12
        //     ],
        //     [
        //         // id = 17
        //         'name' => 'Mushrooms',
        //         'parent_id' => 12
        //     ],
        //     [
        //         // id = 18
        //         'name' => 'Pre-Cut',
        //         'parent_id' => 12
        //     ],
        //     [
        //         // id = 19
        //         'name' => 'Root Vegetables | Leeks | Baby Corn',
        //         'parent_id' => 12
        //     ],
        //     [
        //         // id = 20
        //         'name' => 'Tomato | Cucumber | Capsicum | Avocados',
        //         'parent_id' => 12
        //     ],
        //     [
        //         // id = 21
        //         'name' => 'Zucchini | Pumpkin | Gourd',
        //         'parent_id' => 12
        //     ],
        //     [
        //         // id = 22
        //         'name' => 'Alcohol',
        //         'parent_id' => null
        //     ],
        //     [
        //         // id = 23
        //         'name' => 'Beer | Ciders',
        //         'parent_id' => 22
        //     ],
        //     [
        //         // id = 24
        //         'name' => 'Organic Alcohol',
        //         'parent_id' => 22
        //     ],
        //     [
        //         // id = 25
        //         'name' => 'Pre-Mixed Cocktails',
        //         'parent_id' => 22
        //     ],
        //     [
        //         // id = 26
        //         'name' => 'Spirits | Cocktails',
        //         'parent_id' => 22
        //     ],
        //     [
        //         // id = 27
        //         'name' => 'Wines | Sparkings wines | Champagnes',
        //         'parent_id' => 22
        //     ],
        //     [
        //         // id = 28
        //         'name' => 'Beverages',
        //         'parent_id' => null
        //     ],
        //     [
        //         // id = 29
        //         'name' => 'Coffee | Chocolate Drinks',
        //         'parent_id' => 28
        //     ],
        //     [
        //         // id = 30
        //         'name' => 'Cold Press',
        //         'parent_id' => 28
        //     ],
        //     [
        //         // id = 31
        //         'name' => 'Juice | Nectars | Syrups',
        //         'parent_id' => 28
        //     ],
        //     [
        //         // id = 32
        //         'name' => 'Kombucha | Probiotics',
        //         'parent_id' => 28
        //     ],
        //     [
        //         // id = 33
        //         'name' => 'Organic Beverages',
        //         'parent_id' => 28
        //     ],
        //     [
        //         // id = 34
        //         'name' => 'Sodas & Lemonades',
        //         'parent_id' => 28
        //     ],
        //     [
        //         // id = 35
        //         'name' => 'Tea | Infusions',
        //         'parent_id' => 28
        //     ],
        //     [
        //         // id = 36
        //         'name' => 'Water & Sparkling Water',
        //         'parent_id' => 28
        //     ],
        //     [
        //         // id = 37
        //         'name' => 'Breakfast',
        //         'parent_id' => null
        //     ],
        //     [
        //         // id = 38
        //         'name' => 'Breakfast Cereals',
        //         'parent_id' => 37
        //     ],
        //     [
        //         // id = 39
        //         'name' => 'Coffee | Chocolate Drinks',
        //         'parent_id' => 37
        //     ],
        //     [
        //         // id = 40
        //         'name' => 'Jams | Honey | Spreads',
        //         'parent_id' => 37
        //     ],
        //     [
        //         // id = 41
        //         'name' => 'Milk',
        //         'parent_id' => 37
        //     ],
        //     [
        //         // id = 42
        //         'name' => 'Tea | Infusions',
        //         'parent_id' => 37
        //     ]
        // ];
        // Category::insert($categories);
        // Product::factory(100)->create();

        // $categories = Category::all();
        // Product::all()->each(function ($product) use ($categories) {
        //     $product->categories()->attach(
        //         $categories->random(rand(1, 10))->pluck('id')->toArray()
        //     );
        // });
    }
}
