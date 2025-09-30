<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'cake_id' => 1,
                'user_id' => 2,
                'user_name' => 'Test Customer',
                'rating' => 5,
                'comment' => 'Absolutely delicious! The chocolate flavor was rich and perfectly moist. Highly recommend for any celebration!',
                'is_verified_purchase' => true,
            ],
            [
                'cake_id' => 1,
                'user_id' => 2,
                'user_name' => 'Sarah Fernando',
                'rating' => 4,
                'comment' => 'Great cake! My kids loved it. Would have given 5 stars but delivery was slightly delayed.',
                'is_verified_purchase' => true,
            ],
            [
                'cake_id' => 2,
                'user_id' => 2,
                'user_name' => 'Test Customer',
                'rating' => 5,
                'comment' => 'Perfect for our wedding! Everyone complimented how beautiful and tasty it was. Thank you BlissCakes!',
                'is_verified_purchase' => true,
            ],
            [
                'cake_id' => 3,
                'user_id' => 2,
                'user_name' => 'Kamal Silva',
                'rating' => 5,
                'comment' => 'Best red velvet cake I have ever tasted. The cream cheese frosting was amazing!',
                'is_verified_purchase' => false,
            ],
            [
                'cake_id' => 4,
                'user_id' => 2,
                'user_name' => 'Priya Perera',
                'rating' => 5,
                'comment' => 'As a vegan, I am so happy to find such delicious options. This cake was moist and flavorful!',
                'is_verified_purchase' => true,
            ],
            [
                'cake_id' => 5,
                'user_id' => 2,
                'user_name' => 'Nimal Rodrigo',
                'rating' => 4,
                'comment' => 'Good gluten-free option. Taste was great, texture could be slightly better.',
                'is_verified_purchase' => true,
            ],
            [
                'cake_id' => 6,
                'user_id' => 2,
                'user_name' => 'Malini Jayasuriya',
                'rating' => 5,
                'comment' => 'Fresh strawberries and light cream - perfect combination! Will order again.',
                'is_verified_purchase' => false,
            ],
            [
                'cake_id' => 7,
                'user_id' => 2,
                'user_name' => 'Roshan De Silva',
                'rating' => 5,
                'comment' => 'Classic Black Forest done right! Cherries were fresh and chocolate was rich.',
                'is_verified_purchase' => true,
            ],
        ];

        foreach ($reviews as $reviewData) {
            Review::create($reviewData);
        }
    }
}