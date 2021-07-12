<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone_number' => $this->faker->randomElement([$this->faker->numerify('0#########'), $this->faker->numerify('0########')]),
            'address_1' => $this->faker->address(),
            'city' => 'Phnom Penh',
            'payment_method' => $this->faker->randomElement(["aba_payment", "cash_payment"]),
            'status' => $this->faker->randomElement(['pending', 'completed', 'delivered']),
            'district' => $this->faker->randomElement(['chamkar-mon', 'daun-penh', 'prampir-makara', 'toul-kork', 'dangkao', 'mean-chey', 'russey-keo', 'sen-sok', 'pou-senchey', 'prek-pnov', 'chbar-ampov', 'boeng-keng-kang', 'kamboul']),
            'buyer_id' => $this->faker->randomElement(null, User::whereHas('roles', function ($q) {
                $q->where('name', 'buyer');
            })->inRandomOrder()->limit(1)->get()->pluck('id'))
        ];
    }
}
