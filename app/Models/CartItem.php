<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'cake_id',
        'quantity',
        'price',
        'customization',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'customization' => 'array',
    ];

    // Relationships
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function cake()
    {
        return $this->belongsTo(Cake::class);
    }
}