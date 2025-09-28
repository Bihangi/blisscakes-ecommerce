<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'customization' => $this->customization,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'cake' => new CakeResource($this->whenLoaded('cake')),
        ];
    }
}