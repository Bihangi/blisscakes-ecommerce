<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total_amount' => fake()->randomFloat(2, 20, 500),
            'status' => fake()->randomElement(['pending', 'confirmed', 'preparing', 'ready', 'delivered']),
            'delivery_address' => fake()->address(),
            'delivery_phone' => fake()->phoneNumber(),
            'delivery_date' => fake()->dateTimeBetween('now', '+7 days'),
            'special_instructions' => fake()->sentence(),
            'payment_status' => fake()->randomElement(['pending', 'paid']),
        ];
    }
}