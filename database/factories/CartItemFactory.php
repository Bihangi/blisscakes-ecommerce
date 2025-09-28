<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\Cake;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    public function definition(): array
    {
        $cake = Cake::factory()->create();
        
        return [
            'cart_id' => Cart::factory(),
            'cake_id' => $cake->id,
            'quantity' => fake()->numberBetween(1, 3),
            'price' => $cake->price,
            'customization' => fake()->randomElement([
                null,
                ['message' => 'Happy Birthday!'],
                ['message' => 'Congratulations!', 'color' => 'pink'],
                ['message' => 'Best Wishes', 'size' => 'large'],
            ]),
        ];
    }
}