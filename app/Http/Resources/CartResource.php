<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'cart_items' => CartItemResource::collection($this->whenLoaded('cartItems')),
            'items_count' => $this->when($this->relationLoaded('cartItems'), $this->cartItems->count()),
        ];
    }
}