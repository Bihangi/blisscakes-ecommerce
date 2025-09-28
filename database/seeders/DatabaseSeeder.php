<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Cake;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'BlissCakes Admin',
            'email' => 'admin@blisscakes.com',
            'password' => Hash::make('admin123'),
            'user_type' => 'admin',
            'phone' => '+94771234567',
            'address' => 'Colombo, Sri Lanka',
        ]);

        // Create test customer
        User::factory()->customer()->create([
            'name' => 'Test Customer',
            'email' => 'customer@test.com',
            'password' => Hash::make('password'),
        ]);

        // Create additional customers
        User::factory(10)->customer()->create();

        // Create categories
        $categories = [
            [
                'name' => 'Birthday Cakes',
                'description' => 'Special cakes for birthday celebrations',
                'image' => 'https://via.placeholder.com/300x200/FFB6C1/000000?text=Birthday+Cakes',
            ],
            [
                'name' => 'Wedding Cakes',
                'description' => 'Elegant cakes for weddings',
                'image' => 'https://via.placeholder.com/300x200/F0F8FF/000000?text=Wedding+Cakes',
            ],
            [
                'name' => 'Anniversary Cakes',
                'description' => 'Romantic cakes for anniversaries',
                'image' => 'https://via.placeholder.com/300x200/FFC0CB/000000?text=Anniversary+Cakes',
            ],
            [
                'name' => 'Custom Cakes',
                'description' => 'Personalized cakes for any occasion',
                'image' => 'https://via.placeholder.com/300x200/DDA0DD/000000?text=Custom+Cakes',
            ],
            [
                'name' => 'Cupcakes',
                'description' => 'Delicious individual cupcakes',
                'image' => 'https://via.placeholder.com/300x200/98FB98/000000?text=Cupcakes',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample cakes for each category
        $cakeData = [
            // Birthday Cakes
            [
                'name' => 'Chocolate Birthday Delight',
                'description' => 'Rich chocolate cake with vanilla buttercream and colorful sprinkles',
                'price' => 2500.00,
                'category_id' => 1,
                'flavor' => 'Chocolate',
                'size' => 'Medium',
                'occasion' => 'Birthday',
                'ingredients' => 'Flour, cocoa powder, eggs, butter, vanilla',
                'dietary_options' => [],
                'image' => 'https://via.placeholder.com/400x300/8B4513/FFFFFF?text=Chocolate+Birthday',
            ],
            [
                'name' => 'Vanilla Rainbow Cake',
                'description' => 'Light vanilla sponge with rainbow layers and cream cheese frosting',
                'price' => 3000.00,
                'category_id' => 1,
                'flavor' => 'Vanilla',
                'size' => 'Large',
                'occasion' => 'Birthday',
                'ingredients' => 'Flour, vanilla extract, eggs, butter, food coloring',
                'dietary_options' => [],
                'image' => 'https://via.placeholder.com/400x300/FF69B4/FFFFFF?text=Rainbow+Cake',
            ],
            
            // Wedding Cakes
            [
                'name' => 'Elegant White Wedding',
                'description' => 'Three-tier white cake with pearl decorations and fresh flowers',
                'price' => 15000.00,
                'category_id' => 2,
                'flavor' => 'Vanilla',
                'size' => 'Large',
                'occasion' => 'Wedding',
                'ingredients' => 'Premium flour, vanilla, eggs, butter, fondant',
                'dietary_options' => [],
                'image' => 'https://via.placeholder.com/400x300/F8F8FF/000000?text=Wedding+Cake',
            ],
            
            // Anniversary Cakes
            [
                'name' => 'Red Velvet Romance',
                'description' => 'Classic red velvet with cream cheese frosting and rose decorations',
                'price' => 4500.00,
                'category_id' => 3,
                'flavor' => 'Red Velvet',
                'size' => 'Medium',
                'occasion' => 'Anniversary',
                'ingredients' => 'Flour, cocoa, red food coloring, buttermilk, cream cheese',
                'dietary_options' => [],
                'image' => 'https://via.placeholder.com/400x300/DC143C/FFFFFF?text=Red+Velvet',
            ],
            
            // Custom Cakes
            [
                'name' => 'Photo Print Special',
                'description' => 'Personalized cake with edible photo print and custom message',
                'price' => 3500.00,
                'category_id' => 4,
                'flavor' => 'Chocolate',
                'size' => 'Medium',
                'occasion' => 'Celebration',
                'ingredients' => 'Flour, cocoa, eggs, butter, edible ink',
                'dietary_options' => [],
                'image' => 'https://via.placeholder.com/400x300/DDA0DD/000000?text=Photo+Print',
            ],
            
            // Cupcakes
            [
                'name' => 'Assorted Cupcake Box',
                'description' => 'Box of 12 assorted flavor cupcakes with different toppings',
                'price' => 1800.00,
                'category_id' => 5,
                'flavor' => 'Assorted',
                'size' => 'Small',
                'occasion' => 'Any',
                'ingredients' => 'Flour, various flavors, butter, frosting',
                'dietary_options' => [],
                'image' => 'https://via.placeholder.com/400x300/98FB98/000000?text=Cupcakes',
            ],
        ];

        foreach ($cakeData as $cake) {
            Cake::create($cake);
        }

        // Create additional random cakes
        Cake::factory(20)->create();
    }
}