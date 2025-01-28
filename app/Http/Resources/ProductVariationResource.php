<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariationResource extends JsonResource
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
            'sku' => $this->sku,
            'discount_price' => $this->discount_price,
            'regular_price' => $this->regular_price,
            'quantity' => intval($this->total_stock_qty),
            'image' => $this->image,
            'variant' => ProductVariantResource::collection($this->variationAttributes()->get()),
        ];
    }
}
