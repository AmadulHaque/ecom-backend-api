<?php

namespace App\Http\Resources;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $thumbnail = $this->product->thumbnail;
        if (isset($this->product_variant) and $this->product_variant->image) {
            $thumbnail = $this->product_variant->image;
        }

        return [
            'id' => $this->id,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'status' => $this->status_label,
            'product_name' => $this->product->name,
            'product_slug' => $this->product->slug,
            'product_thumbnail' => $thumbnail,
            'product_rating_avg' => $this->product->rating_avg,
            'product_rating_count' => $this->product->rating_count,
            'product_variant' => OrderService::getOrderItemVariantText($this->product_variant->variations ?? []),
        ];
    }
}
