<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CakeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true) . ' Cake',
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 15, 150),
            'image' => fake()->imageUrl(400, 300, 'food'),
            'category_id' => Category::factory(),
            'flavor' => fake()->randomElement(['Chocolate', 'Vanilla', 'Strawberry', 'Red Velvet', 'Lemon']),
            'size' => fake()->randomElement(['Small', 'Medium', 'Large']),
            'occasion' => fake()->randomElement(['Birthday', 'Wedding', 'Anniversary', 'Celebration']),
            'is_available' => fake()->boolean(80),
            'ingredients' => fake()->words(5, true),
            'dietary_options' => fake()->randomElements(['gluten-free', 'vegan', 'sugar-free'], rand(0, 2)),
        ];
    }
}