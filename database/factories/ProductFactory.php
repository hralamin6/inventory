<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $price =rand(200, 5000);
        return [
            'name' => $this->faker->userName,
            'overview' => $this->faker->word(200),
            'description' => $this->faker->word(500),
//            'status' => $this->faker->randomElement(['active', 'inactive']),
            'regular_price' => $price,
            'actual_price' => $price-100,
            'category_id' => rand(1, 10),
            'brand_id' => rand(1, 10),
            'buying_unit_id' => rand(1, 10),
            'selling_unit_id' => rand(1, 10),
        ];
    }
}
