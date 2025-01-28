<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
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
            'attribute_option_id' => $this->attribute_option_id,
            'attribute_id' => $this->attribute_id,
            'attribute_name' => $this->attribute->name,
            'attribute_option' => $this->attributeOption->attribute_value,
        ];
    }
}
