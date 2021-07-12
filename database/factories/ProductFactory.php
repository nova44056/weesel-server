<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(1),
            'quantity' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(1, 1, 100),
            'rating' => $this->faker->numberBetween(1, 5),
            'discount' => $this->faker->numberBetween(10, 20),
            'status' => $this->faker->randomElement([Product::AVAILABLE_PRODUCT, Product::UNAVAILABLE_PRODUCT]),
            'seller_id' => User::whereHas("roles", function ($q) {
                $q->where('name', 'merchant');
            })->get()->random(1)->pluck('id')[0]
        ];
    }
}
