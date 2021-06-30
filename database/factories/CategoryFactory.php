<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    public const parentCategories = [
        [
            // id = 1
            'name' => 'Alcohol',
            'parent_id' => null,
            'image_url' => 'https://weesel.s3.ap-southeast-1.amazonaws.com/category/placeholder-square.jpg'
        ],
        [
            // id = 2
            'name' => 'Bakery',
            'parent_id' => null,
            'image_url' => 'https://weesel.s3.ap-southeast-1.amazonaws.com/category/placeholder-square.jpg'
        ],
        [
            // id = 3
            'name' => 'Beverage',
            'parent_id' => null,
            'image_url' => 'https://weesel.s3.ap-southeast-1.amazonaws.com/category/placeholder-square.jpg'
        ],
        [
            // id = 4
            'name' => 'Frozen',
            'parent_id' => null,
            'image_url' => 'https://weesel.s3.ap-southeast-1.amazonaws.com/category/placeholder-square.jpg'
        ],
        [
            // id = 5
            'name' => 'Fruits',
            'parent_id' => null,
            'image_url' => 'https://weesel.s3.ap-southeast-1.amazonaws.com/category/placeholder-square.jpg'
        ],
    ];

    public const alcoholChildren = [
        [
            // id = 5
            'name' => 'Beer | Ciders',
            'parent_id' => 1,
        ],
        [
            // id = 6
            'name' => 'Organic Alcohol',
            'parent_id' => 1,
        ],
        [
            // id = 7
            'name' => 'Pre-Mixed Cocktails',
            'parent_id' => 1,
        ],
        [
            // id = 9
            'name' => 'Spirits | Cocktails',
            'parent_id' => 1,
        ]
    ];

    public const bakeryChildren = [
        [
            // id = 10
            'name' => 'Bread',
            'parent_id' => 2,
        ],
        [
            // id = 11
            'name' => 'Chocolate',
            'parent_id' => 2,
        ],
        [
            // id = 12
            'name' => 'Cracker | Biscuits | Cookies',
            'parent_id' => 2
        ],
        [
            // id = 13
            'name' => 'Crumbs Special',
            'parent_id' => 2,
        ]
    ];

    public const beverageChildren = [
        [
            // id = 14
            'name' => 'Coffee | Chocolate Drinks',
            'parent_id' => 3,
        ],
        [
            // id = 15
            'name' => 'Cold Press',
            'parent_id' => 3,
        ],
        [
            // id = 16
            'name' => 'Juice | Nectars | Syrups',
            'parent_id' => 3,
        ],
        [
            // id = 17
            'name' => 'Kombucha | Probiotics',
            'parent_id' => 3,
        ]
    ];

    public const fruitChildren = [
        [
            // id = 18
            'name' => 'Seasonal Fruits',
            'parent_id' => 5,
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
            'name' => $this->faker->word(),
            'description' => $this->faker->paragraph(1),
            'parent_id' => $this->faker->randomElement([null, Category::all()->where('parent_id', '=', User::BUYER)->random()->id])
        ];
    }
}
