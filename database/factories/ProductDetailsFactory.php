<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_enable_accounting' => $this->faker->randomElement(['1', '0']),
            'purchase_price' => $this->faker->randomFloat(2, 10, 100),
            'regular_price' => $this->faker->randomFloat(2, 10, 100),
            'discount_price' => $this->faker->randomFloat(2, 10, 100),
            'wholesale_price' => $this->faker->randomFloat(2, 10, 100),
            'minimum_qty' => $this->faker->randomNumber(2, true),
        ];
    }
}
