<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'regular_price' => $this->regular_price,
            'discount_price' => $this->discount_price,
            'is_variant' => $this->is_variant,
            'thumbnail' => $this->thumbnail,
            'rating_avg' => $this->rating_avg,
            'rating_count' => $this->rating_count,
            'available_stock' => intval($this->available_stock),
        ];
    }
}
