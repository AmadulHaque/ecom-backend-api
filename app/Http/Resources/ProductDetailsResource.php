<?php

namespace App\Http\Resources;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailsResource extends JsonResource
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
            'thumbnail' => $this->thumbnail,
            'images' => $this->image,
            'description' => $this->description,
            'category_id' => intval($this->category_id),
            'specification' => $this->specification,
            'quantity' => intval($this->quantity),
            'rating_avg' => $this->rating_avg,
            'rating_count' => $this->rating_count,
            'regular_price' => $this->productDetail->regular_price ?? 0,
            'discount_price' => $this->productDetail->discount_price ?? 0,
            'shop_id' => $this->merchant->id,
            'shop_name' => $this->merchant->shop_name,
            'shop_image' => $this->merchant->image,
            'merchant_name' => $this->merchant->name,
            'is_variant' => $this->is_variant,
            'default_variant' => $this->productDetail->selectedVariation->sku ?? null,
            'variations' => ProductVariationResource::collection($this->variations()->where('regular_price', '>', 0)->where('total_stock_qty', '>', 0)->where('status', 1)->get()),
            'attributes' => ProductService::getAttributes($this),
        ];
    }
}
