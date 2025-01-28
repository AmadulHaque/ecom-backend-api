<?php

namespace App\Actions;

use App\Enums\CommonType;
use App\Models\Coupon;
use App\Models\Product;

class FetchCoupon
{
    public function handle($product_id)
    {
        // Fetch the product details
        $product = Product::find($product_id);

        if (! $product) {
            throw new \Exception('Product not found');
        }

        // Fetch all coupons that have not expired
        $coupons = Coupon::where('end_date', '>=', now())
            ->with(['merchants', 'products', 'categories', 'brands'])
            ->get();

        // Filter coupons based on rules
        $eligibleCoupons = $coupons->filter(function ($coupon) use ($product) {
            // Merchant type rules
            if ($coupon->merchant_type === CommonType::EXCLUDE) {
                if ($coupon->merchants->pluck('id')->contains($product->merchant_id)) {
                    return false;
                }
            } elseif ($coupon->merchant_type === CommonType::INCLUDE) {
                if (! $coupon->merchants->pluck('id')->contains($product->merchant_id)) {
                    return false;
                }
            }

            // Product type rules
            if ($coupon->product_type === CommonType::EXCLUDE) {
                if ($coupon->products->pluck('id')->contains($product->id)) {
                    return false;
                }
            } elseif ($coupon->product_type === CommonType::INCLUDE) {
                if (! $coupon->products->pluck('id')->contains($product->id)) {
                    return false;
                }
            }

            // Category type rules
            if ($coupon->category_type === CommonType::EXCLUDE) {
                if ($coupon->categories->pluck('id')->contains($product->category_id)) {
                    return false;
                }
            } elseif ($coupon->category_type === CommonType::INCLUDE) {
                if (! $coupon->categories->pluck('id')->contains($product->category_id)) {
                    return false;
                }
            }

            // Brand type rules
            if ($coupon->brand_type === CommonType::EXCLUDE) {
                if ($coupon->brands->pluck('id')->contains($product->brand_id)) {
                    return false;
                }
            } elseif ($coupon->brand_type === CommonType::INCLUDE) {
                if (! $coupon->brands->pluck('id')->contains($product->brand_id)) {
                    return false;
                }
            }

            // If all checks pass, the coupon is eligible
            return true;
        });

        // Map the eligible coupons to the required structure
        $result = $eligibleCoupons->map(function ($coupon) {
            return [
                'id' => $coupon->id,
                'name' => $coupon->name,
                'code' => $coupon->code,
                'description' => $coupon->description,
                'min_purchase' => $coupon->min_purchase,
                'discount_value' => $coupon->discount_value,
                'max_discount' => $coupon->max_discount_value,
                'discount_type' => $coupon->discount_type,
                'expires_at' => $coupon->end_date,
            ];
        });

        return $result->values();
    }

    // public function execute($request)
    // {
    //     // Retrieve product and coupon IDs from the request
    //     $product_ids = $request->product_ids; // example: [1, 2]
    //     $coupon_ids = $request->coupon_ids;   // example: [1, 2, 3]

    //     // Fetch coupons by unique IDs and filter based on expiration date
    //     $coupons = Coupon::whereIn('id', $coupon_ids)
    //                     ->with('products')
    //                     ->where('end_date', '>=', now())
    //                     ->get()
    //                     ->map(function ($coupon) use ($product_ids) {
    //                         $products = $coupon->products->pluck('id');

    //                         // Check if all products in the request are ineligible
    //                         $all_products_ineligible = collect($product_ids)->every(function ($product_id) use ($products) {
    //                             return $products->contains($product_id);
    //                         });

    //                         return [
    //                             'id' => $coupon->id,
    //                             'name' => $coupon->name,
    //                             'code' => $coupon->code,
    //                             'description' => $coupon->description,
    //                             'min_purchase' => $coupon->min_purchase,
    //                             'discount_value' => $coupon->discount_value,
    //                             'max_discount' => $coupon->max_discount_value,
    //                             'discount_type' => $coupon->discount_type,
    //                             'expires_at' => $coupon->end_date,
    //                             'is_valid' => $all_products_ineligible,
    //                         ];
    //                     });

    //     // Return the response
    //     return $coupons;
    // }

    public function execute($request)
    {
        // Validate request input
        $product_ids = $request->product_ids ?? []; // e.g., [1, 2]
        $coupon_ids = $request->coupon_ids ?? [];   // e.g., [1, 2, 3]

        if (empty($product_ids) || empty($coupon_ids)) {
            throw new \Exception('Product IDs or Coupon IDs are missing');
        }

        // Fetch coupons with relationships and ensure they are not expired
        $coupons = Coupon::whereIn('id', $coupon_ids)
            ->with(['products', 'merchants', 'categories', 'brands'])
            ->where('end_date', '>=', now())
            ->get();
        // dd($coupons);
        // Process coupons to determine eligibility for the provided product IDs
        $result = $coupons->map(function ($coupon) use ($product_ids) {
            // dd()
            // Extract related product IDs
            $relatedProductIds = $coupon->products->pluck('id');
            // dd($relatedProductIds);
            // Check if all provided products are ineligible
            $allProductsIneligible = collect($product_ids)->every(function ($product_id) use ($relatedProductIds) {
                return $relatedProductIds->contains($product_id);
            });

            return [
                'id' => $coupon->id,
                'name' => $coupon->name,
                'code' => $coupon->code,
                'description' => $coupon->description,
                'min_purchase' => $coupon->min_purchase,
                'discount_value' => $coupon->discount_value,
                'max_discount' => $coupon->max_discount_value,
                'discount_type' => $coupon->discount_type,
                'expires_at' => $coupon->end_date,
                'is_valid' => $allProductsIneligible,
            ];
        });

        // Return the filtered result
        return $result->values();
    }
}
