<?php

namespace App\Http\Resources;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $thumbnail = $this->orderItem->product->thumbnail;
        if (isset($this->orderItem->product_variant) and $this->orderItem->product_variant->image) {
            $thumbnail = $this->orderItem->product_variant->image;
        }

        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'review' => $this->review,
            'created_at' => $this->created_at,
            'feedback_images' => $this->images,
            'product_name' => $this->orderItem->product->name,
            'product_slug' => $this->orderItem->product->slug,
            'product_thumbnail' => $thumbnail,
            'product_variant' => OrderService::getOrderItemVariantText($this->orderItem->product_variant->variations ?? []),
        ];
    }
}
