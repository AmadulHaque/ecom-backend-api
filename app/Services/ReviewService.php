<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Http\Resources\MyReviewResource;

class ReviewService
{
    public static function getReviews($request)
    {
        $reviews = auth()->user()->reviews()
            ->with([
                'user:id,name,phone',
                'user.media',
                'orderItem:id,product_variation_id,product_id',
                'orderItem.product:id,name,slug',
                'orderItem.product_variant',
                'orderItem.product_variant.variationAttributes:id,attribute_option_id,attribute_id,product_variation_id',
                'orderItem.product_variant.variationAttributes.attribute:id,name',
                'orderItem.product_variant.variationAttributes.attributeOption:id,attribute_value',
            ])
            // ->where('is_public', ReviewStatus::IS_PUBLIC->value)
            ->select('id', 'rating', 'review', 'order_item_id', 'user_id', 'created_at', 'order_item_id')->orderBy('created_at', 'desc')->paginate();

        return resourceFormatPagination('Review get successfully', MyReviewResource::collection($reviews), $reviews);
    }

    public static function getToReviews($request)
    {
        $orders = auth()->user()->orders()
            ->with([
                'orderItems.product_variant:id',
                'orderItems.product_variant.variationAttributes:id,attribute_option_id,attribute_id,product_variation_id',
                'orderItems.product_variant.variationAttributes.attribute:id,name',
                'orderItems.product_variant.variationAttributes.attributeOption:id,attribute_value',
                'orderItems.product',
            ])
            ->whereHas('merchantOrders', function ($query) {
                $query->where('status_id', OrderStatus::DELIVERED->value);
            })
            ->where(function ($query) {
                $query->whereHas('orderItems', function ($query) {
                    $query->whereDoesntHave('review');
                });
            })
            ->latest()
            ->paginate();

        $toReview = $orders->getCollection()->flatMap(function ($order) {
            // an additional check to only include unreviewed items
            return $order->orderItems->filter(function ($item) {
                return ! $item->review;
            })->map(function ($item) {
                $thumbnail = $item->product->thumbnail;
                if (isset($item->product_variant) and $item->product_variant->image) {
                    $thumbnail = $item->product_variant->image;
                }

                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_slug' => $item->product->slug,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'product_thumbnail' => $thumbnail,
                    'product_variant' => OrderService::getOrderItemVariantText($item->product_variant->variationAttributes ?? []),
                ];
            });
        });

        return response()->json([
            'message' => 'to review get successfully',
            'data' => $toReview,
            'total' => $orders->total(),
            'last_page' => $orders->lastPage(),
            'current_page' => $orders->currentPage(),
            'next_page_url' => $orders->nextPageUrl(),
        ], 200);
    }
}
