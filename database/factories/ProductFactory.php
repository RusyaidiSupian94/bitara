<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_name' => fake()->name(),
            'cost_price' => rand(1, 99),
            'unit_price' => rand(1, 99),
            'total_stock' => rand(1, 99),
            'category_id' => 1,
            'product_img' => fake()->name(),
            'uom_id' => 1,
        ];
    }
}
