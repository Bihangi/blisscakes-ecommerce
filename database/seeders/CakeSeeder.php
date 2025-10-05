<?php

namespace Database\Seeders;

use App\Models\Cake;
use Illuminate\Database\Seeder;

class CakeSeeder extends Seeder
{
    public function run(): void
    {
        $cakes = [
            [
                'name' => 'Chocolate Dream Birthday Cake',
                'description' => 'Rich chocolate cake with chocolate ganache',
                'price' => 4500.00,
                'category_id' => 1,
                'flavor' => 'Chocolate',
                'size' => 'Medium',
                'occasion' => 'Birthday',
                'is_available' => true,
                'ingredients' => 'Flour, Cocoa, Sugar, Eggs, Butter',
                'dietary_options' => null,
            ],
            [
                'name' => 'Vanilla Elegance Wedding Cake',
                'description' => 'Classic vanilla cake with buttercream frosting',
                'price' => 15000.00,
                'category_id' => 2,
                'flavor' => 'Vanilla',
                'size' => 'Large',
                'occasion' => 'Wedding',
                'is_available' => true,
                'ingredients' => 'Flour, Vanilla, Sugar, Eggs, Butter',
                'dietary_options' => null,
            ],
            [
                'name' => 'Red Velvet Anniversary Cake',
                'description' => 'Luxurious red velvet with cream cheese frosting',
                'price' => 5500.00,
                'category_id' => 3,
                'flavor' => 'Red Velvet',
                'size' => 'Medium',
                'occasion' => 'Anniversary',
                'is_available' => true,
                'ingredients' => 'Flour, Cocoa, Buttermilk, Eggs, Red Food Color',
                'dietary_options' => null,
            ],
            [
                'name' => 'Vegan Chocolate Delight',
                'description' => 'Delicious vegan chocolate cake',
                'price' => 5000.00,
                'category_id' => 5,
                'flavor' => 'Chocolate',
                'size' => 'Medium',
                'occasion' => 'Any',
                'is_available' => true,
                'ingredients' => 'Flour, Cocoa, Almond Milk, Coconut Oil',
                'dietary_options' => ['vegan'],
            ],
            [
                'name' => 'Gluten-Free Vanilla Cupcakes',
                'description' => 'Pack of 12 gluten-free vanilla cupcakes',
                'price' => 2500.00,
                'category_id' => 5,
                'flavor' => 'Vanilla',
                'size' => 'Small',
                'occasion' => 'Any',
                'is_available' => true,
                'ingredients' => 'Gluten-Free Flour, Vanilla, Sugar, Eggs',
                'dietary_options' => ['gluten_free'],
            ],
            [
                'name' => 'Strawberry Shortcake',
                'description' => 'Fresh strawberries with whipped cream',
                'price' => 4000.00,
                'category_id' => 1,
                'flavor' => 'Strawberry',
                'size' => 'Medium',
                'occasion' => 'Birthday',
                'is_available' => true,
                'ingredients' => 'Flour, Sugar, Strawberries, Cream, Eggs',
                'dietary_options' => null,
            ],
            [
                'name' => 'Black Forest Cake',
                'description' => 'Chocolate cake with cherries and whipped cream',
                'price' => 4800.00,
                'category_id' => 1,
                'flavor' => 'Chocolate',
                'size' => 'Large',
                'occasion' => 'Birthday',
                'is_available' => true,
                'ingredients' => 'Flour, Cocoa, Cherries, Cream, Eggs',
                'dietary_options' => null,
            ],
            [
                'name' => 'Mini Chocolate Bento Cake',
                'description' => 'A cute single-serve chocolate bento cake with rich ganache and sprinkles',
                'price' => 1800.00,
                'category_id' => 1, 
                'flavor' => 'Chocolate',
                'size' => 'Small',
                'occasion' => 'Birthday',
                'is_available' => true,
                'ingredients' => 'Flour, Cocoa Powder, Sugar, Butter, Eggs, Cream',
                'dietary_options' => null,
            ],
            [
                'name' => 'Classic Bettenberg Loaf',
                'description' => 'A traditional almond sponge loaf with pink and yellow checker pattern wrapped in apricot jam and marzipan.',
                'price' => 3200.00,
                'category_id' => 5, 
                'flavor' => 'Almond',
                'size' => 'Medium',
                'occasion' => 'Any',
                'is_available' => true,
                'ingredients' => 'Flour, Sugar, Eggs, Butter, Almond Extract, Apricot Jam, Marzipan, Food Coloring',
                'dietary_options' => 'Vegetarian',
            ],

        ];

        foreach ($cakes as $cake) {
            Cake::create($cake);
        }
    }
}