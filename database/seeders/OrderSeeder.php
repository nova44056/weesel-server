<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Product;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Container\Container;

class OrderSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return \Faker\Generator
     */
    protected function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory(300)->create();
        $orders = Order::all();
        foreach ($orders as $order) {
            if ($order->payment_method === "aba_payment") {
                $order->aba_transaction_id = $this->faker->numerify('#########');
            }
            $products = Product::all()->random(random_int(1, 6));
            $seller_ids = [];
            foreach ($products as $product) {
                $order->products()->attach($product->id, ['order_product_quantity' => random_int(1, 4)]);
                array_push($seller_ids, $product->seller_id);
            }
            $seller_ids = array_unique($seller_ids);
            foreach ($seller_ids as $seller_id) {
                $order->sellers()->attach($seller_id);
            }
        }
    }
}
