<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Cake;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'cake_id' => Cake::factory(),
            'quantity' => fake()->numberBetween(1, 3),
            'price' => fake()->randomFloat(2, 15, 150),
            'customization' => fake()->randomElement([
                null,
                ['message' => 'Happy Birthday!'],
                ['message' => 'Congratulations!', 'color' => 'pink'],
            ]),
        ];
    }
}