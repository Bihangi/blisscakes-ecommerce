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
        'quantity' => 'integer',
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

    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    public function getFormattedSubtotalAttribute()
    {
        return 'Rs. ' . number_format($this->subtotal, 2);
    }

    public function getCustomizationTextAttribute()
    {
        if (!$this->customization) return 'Standard';
        
        $text = [];
        foreach ($this->customization as $key => $value) {
            $text[] = ucfirst($key) . ': ' . $value;
        }
        return implode(', ', $text);
    }
}