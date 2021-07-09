<?php

namespace Database\Factories;

use App\Models\ProductCollection;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductCollection::class;

    public const productCollections = [
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

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }
}
