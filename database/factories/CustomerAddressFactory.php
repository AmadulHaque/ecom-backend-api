<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomerAddress>
 */
class CustomerAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'landmark' => $this->faker->streetName(),
            'address' => $this->faker->address(),
            'address_type' => $this->faker->randomElement(['home', 'office']),
            'contact_number' => $this->faker->phoneNumber(),
            'is_default_bill' => $this->faker->boolean(),
            'is_default_ship' => $this->faker->boolean(),
        ];
    }
}
