<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'cake_id',
        'quantity',
        'price',
        'customization', // JSON field for custom message, etc.
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2',
        'customization' => 'array',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
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
        if (!$this->customization) return 'No customizations';
        
        $text = [];
        foreach ($this->customization as $key => $value) {
            $text[] = ucfirst($key) . ': ' . $value;
        }
        return implode(', ', $text);
    }
}