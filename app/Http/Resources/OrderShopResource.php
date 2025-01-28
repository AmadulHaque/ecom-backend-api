<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderShopResource extends JsonResource
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
            'tracking_id' => $this->tracking_id,
            'total_amount' => $this->total_amount,
            'shipping_amount' => $this->shipping_amount,
            'charge' => $this->charge,
            'status' => $this->status_label,
            'shop_id' => $this->merchant->id,
            'shop_name' => $this->merchant->shop_name,
            'shop_image' => $this->merchant->image ?? null,
            'items' => OrderItemResource::collection($this->orderItems),
        ];
    }
}
