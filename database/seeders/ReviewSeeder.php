<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // clear existing reviews
        Review::truncate();

        $reviews = [
            [
                'cake_id' => 1,
                'user_id' => 2,
                'user_name' => 'Test Customer',
                'rating' => 5,
                'comment' => 'Absolutely delicious! The chocolate flavor was rich and perfectly moist.',
                'is_verified_purchase' => true,
            ],
            [
                'cake_id' => 1,
                'user_id' => 2,
                'user_name' => 'Sarah Fernando',
                'rating' => 4,
                'comment' => 'Great cake! My kids loved it.',
                'is_verified_purchase' => true,
            ],
            [
                'cake_id' => 2,
                'user_id' => 2,
                'user_name' => 'Test Customer',
                'rating' => 5,
                'comment' => 'Perfect for our wedding!',
                'is_verified_purchase' => true,
            ],
            [
                'cake_id' => 3,
                'user_id' => 2,
                'user_name' => 'Kamal Silva',
                'rating' => 5,
                'comment' => 'Best red velvet cake ever!',
                'is_verified_purchase' => false,
            ],
        ];

        foreach ($reviews as $reviewData) {
            $review = new Review($reviewData);
            $review->save();
        }

        echo "Created " . Review::count() . " reviews\n";
    }
}