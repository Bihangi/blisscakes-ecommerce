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
        'dietary_options', // JSON field for gluten-free, vegan, etc.
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
}