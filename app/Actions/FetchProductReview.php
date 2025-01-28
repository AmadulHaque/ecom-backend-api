<?php

namespace App\Actions;

use App\Models\Product;
use App\Services\OrderService;

class FetchProductReview
{
    public function execute($request, $slug)
    {
        $product = Product::with('reviews')->where('slug', $slug)->first();
        if (! $product) {
            return failure('Product not found', 404);
        }

        $reviewsQuery = $product->reviews()
            ->with([
                'user:id,name,phone',
                'user.media',
                'orderItem:id,product_variation_id',
                'orderItem.product_variant:id',
                'orderItem.product_variant.variationAttributes:id,attribute_option_id,attribute_id,product_variation_id',
                'orderItem.product_variant.variationAttributes.attribute:id,name',
                'orderItem.product_variant.variationAttributes.attributeOption:id,attribute_value',
            ])
            ->select('id', 'rating', 'review', 'order_item_id', 'user_id', 'created_at', 'order_item_id');

        if ($request->has('with_image')) {
            $reviewsQuery->whereHas('media', function ($query) {
                $query->where('collection_name', 'images');
            });
        }

        $reviews = $reviewsQuery->paginate();

        // Use map to combine all orderItems into a single collection
        $toReview = $reviews->getCollection()->map(function ($review) {
            return [
                'id' => $review->id,
                'rating' => $review->rating,
                'review' => $review->review,
                'user_name' => $review->user->name,
                'user_phone' => $review->user->phone,
                'user_avatar' => $review->user->avatar ?: null,
                'feedback_images' => $review->images,
                'created_at' => $review->created_at,
                'product_variant' => OrderService::getOrderItemVariantText($review->orderItem->product_variant->variationAttributes ?? []),
            ];
        });

        return response()->json([
            'message' => 'to review get successfully',
            'data' => $toReview,
            'total' => $reviews->total(),
            'last_page' => $reviews->lastPage(),
            'current_page' => $reviews->currentPage(),
            'next_page_url' => $reviews->nextPageUrl(),
        ], 200);

        // return formatPagination('Review created successfully', $reviews);
    }
}
