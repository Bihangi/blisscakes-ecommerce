<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
    ];

    // Relationships
    public function cakes()
    {
        return $this->hasMany(Cake::class);
    }

    public function availableCakes()
    {
        return $this->hasMany(Cake::class)->where('is_available', true);
    }

    public function getActiveCakesCountAttribute()
    {
        return $this->cakes()->where('is_available', true)->count();
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : asset('images/category-placeholder.jpg');
    }
}