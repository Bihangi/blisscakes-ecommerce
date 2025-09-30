<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Birthday Cakes',
                'description' => 'Special cakes for birthday celebrations',
                'image' => null, 
            ],
            [
                'name' => 'Wedding Cakes',
                'description' => 'Elegant cakes for your special day',
                'image' => null,
            ],
            [
                'name' => 'Anniversary Cakes',
                'description' => 'Celebrate your love with our anniversary cakes',
                'image' => null,
            ],
            [
                'name' => 'Custom Cakes',
                'description' => 'Fully customizable cakes for any occasion',
                'image' => null,
            ],
            [
                'name' => 'Cupcakes',
                'description' => 'Delicious cupcakes in various flavors',
                'image' => null,
            ],
            [
                'name' => 'Dietary Special',
                'description' => 'Vegan and gluten-free options',
                'image' => null,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}