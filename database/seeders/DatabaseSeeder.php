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
use Spatie\Permission\Models\Role;

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
        DB::table('users')->truncate();
        DB::table('categories')->truncate();
        DB::table('products')->truncate();
        DB::table('category_product')->truncate();
        DB::table('product_product_collection')->truncate();
        DB::table('order_product')->truncate();
        DB::table('orders')->truncate();


        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            ProductCollectionSeeder::class,
        ]);
    }
}
