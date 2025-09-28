<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'total_amount' => $this->total_amount,
            'status' => $this->status,
            'delivery_address' => $this->delivery_address,
            'delivery_phone' => $this->delivery_phone,
            'delivery_date' => $this->delivery_date,
            'special_instructions' => $this->special_instructions,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user' => new UserResource($this->whenLoaded('user')),
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
        ];
    }
}