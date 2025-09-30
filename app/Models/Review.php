<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Review extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reviews';

    protected $fillable = [
        'cake_id',
        'user_id',
        'user_name',
        'rating',
        'comment',
        'is_verified_purchase',
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_verified_purchase' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Helper to get average rating for a cake
    public static function getAverageRating($cakeId)
    {
        $avg = self::where('cake_id', $cakeId)->avg('rating');
        return round($avg, 1);
    }

    // Helper to get total reviews for a cake
    public static function getTotalReviews($cakeId)
    {
        return self::where('cake_id', $cakeId)->count();
    }
}