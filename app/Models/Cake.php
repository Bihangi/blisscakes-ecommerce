<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cake extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'flavor',
        'size',
        'occasion',
        'is_available',
        'ingredients',
        'dietary_options', 
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_available' => 'boolean',
        'dietary_options' => 'array',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByOccasion($query, $occasion)
    {
        return $query->where('occasion', $occasion);
    }

    public function scopeByFlavor($query, $flavor)
    {
        return $query->where('flavor', $flavor);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/cake-placeholder.jpg');
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rs. ' . number_format($this->price, 2);
    }

    public function getDietaryOptionsListAttribute()
    {
        return $this->dietary_options ? implode(', ', $this->dietary_options) : 'None';
    }

    public function getAverageRatingAttribute()
    {
        return \App\Models\Review::getAverageRating($this->id);
    }

    public function getTotalReviewsAttribute()
    {
        return \App\Models\Review::getTotalReviews($this->id);
    }
    
}