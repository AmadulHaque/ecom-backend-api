<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderReturnResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // "item_case": {
        //     "id": 23,
        //     "order_item_id": 133,
        //     "status": "0",
        //     "status_label": "Pending"
        // }
        return [
            'id' => $this->id,
            'tracking_id' => $this->merchant->tracking_id,
            'total_amount' => $this->merchant->total_amount,
            'shipping_amount' => $this->merchant->shipping_amount,
            'charge' => $this->merchant->charge,
            'status' => $this->itemCase->status_label,
            'shop_id' => $this->merchant->merchant->id,
            'shop_name' => $this->merchant->merchant->shop_name,
            'shop_image' => $this->merchant->merchant->image ?? null,
            'items' => [new OrderItemResource($this)],
        ];
    }
}
