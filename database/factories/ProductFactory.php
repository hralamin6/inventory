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
        return [
            'name' => $this->faker->userName,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'category_id' => rand(1, 10),
            'brand_id' => rand(1, 10),
            'buying_unit_id' => rand(1, 10),
            'selling_unit_id' => rand(1, 10),
        ];
    }
}
