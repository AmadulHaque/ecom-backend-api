<?php

namespace App\Actions;

use App\Enums\ReviewStatus;
use App\Models\OrderItem;

class ReviewStore
{
    public function handle($request)
    {
        $orderItem = OrderItem::find($request->order_item_id);
        $review = $orderItem->review()->create([
            'product_id' => $orderItem->product_id,
            'user_id' => auth()->user()->id,
            'review' => $request->review,
            'rating' => $request->rating,
            'seller_rating' => $request->seller_rating,
            'shipping_rating' => $request->shipping_rating,
            'is_approved' => ReviewStatus::IS_APPROVED->value,
            'is_public' => ReviewStatus::IS_NOT_PUBLIC->value,
        ]);

        $review->images = $request->images;

        return $review;
    }
}
