<?php

namespace App\Services\Checkout\Validators;

use App\DTOs\CheckoutData;
use App\Enums\CommonType;
use App\Models\Coupon;
use App\Models\Product;

class CouponValidator
{
    public function validate(CheckoutData $data, $totalAmount)
    {
        // Validate coupon
        // rules :
        // - exists in coupons table  ✅
        // - eligible for the selected all products ✅
        // - not expired  ✅
        // - not used by the same user before limit exceeded ✅
        // - order in only for one eligible merchant ✅
        // - order total amount is greater than or equal to the coupon minimum amount ✅
        // - when coupon discount_type is percentage, the discount amount is less than max_discount_value

        $userId = auth()->id();
        $products = Product::whereIn('id', $data->productIds)->get();
        $coupon = Coupon::with(['products', 'couponUsages'])
            ->where('code', $data->coupon_code)
            ->first();

        if (! $coupon) {
            return null;
        }

        if (! $this->isEligibleForAllProducts($coupon, $data->productIds)) {
            throw new \Exception('Coupon is not eligible for all products');
        }

        if (! $this->notExpired($coupon)) {
            throw new \Exception('Coupon has expired');
        }

        if ($this->usedByUser($coupon, $userId)) {
            throw new \Exception('Coupon has already been used by this user');
        }

        if (! $this->couponEligibleForMerchant($coupon, $products)) {
            throw new \Exception('Coupon is not eligible for this merchant');
        }

        if ($coupon->min_purchase > $totalAmount) {
            throw new \Exception('Minimum purchase amount not met');
        }

        return $coupon;
    }

    private function isEligibleForAllProducts(Coupon $coupon, array $productIds): bool
    {
        $eligibleProductIds = $coupon->products->pluck('id')->toArray();

        return empty(array_diff($productIds, $eligibleProductIds));
    }

    private function notExpired(Coupon $coupon): bool
    {
        return $coupon->end_date > now();
    }

    private function usedByUser(Coupon $coupon, $userId): bool
    {
        try {
            $perUserLimit = $coupon->usage_limit_per_user;

            return $coupon->couponUsages()->where('user_id', $userId)->count() >= $perUserLimit;
        } catch (\Throwable $th) {
            return true;
        }
    }

    private function couponEligibleForMerchant(Coupon $coupon, $products): bool
    {

        if ($coupon->merchant_type == CommonType::EXCLUDE) {
            $merchantIds = $coupon->merchants->pluck('id');
            $merchantIds = $merchantIds->unique();  // 1,2,3,4
            foreach ($products as $product) {
                if ($merchantIds->contains($product->merchant_id)) {
                    return false;
                }
            }
        }

        if ($coupon->merchant_type == CommonType::INCLUDE) {
            $merchantIds = $coupon->merchants->pluck('id');
            $merchantIds = $merchantIds->unique();  // 1,2,3,4
            foreach ($products as $product) {
                if (! $merchantIds->contains($product->merchant_id)) {
                    return false;
                }
            }
        }

        if ($products->pluck('merchant_id')->unique()->count() > 1) {
            return false;
        }

        return true;

    }
}
