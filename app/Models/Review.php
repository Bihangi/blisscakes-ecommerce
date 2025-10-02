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

    public static function getAverageRating($cakeId)
    {
        $reviews = self::where('cake_id', (int)$cakeId)->get();
        
        if ($reviews->isEmpty()) {
            return 0;
        }
        
        $total = $reviews->sum('rating');
        return round($total / $reviews->count(), 1);
    }

    public static function getTotalReviews($cakeId)
    {
        return self::where('cake_id', (int)$cakeId)->count();
    }
}