<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CakeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            'flavor' => $this->flavor,
            'size' => $this->size,
            'occasion' => $this->occasion,
            'is_available' => $this->is_available,
            'ingredients' => $this->ingredients,
            'dietary_options' => $this->dietary_options,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category' => new CategoryResource($this->whenLoaded('category')),
        ];
    }
}