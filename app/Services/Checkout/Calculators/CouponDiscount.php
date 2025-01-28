<?php

namespace App\Services\Checkout\Calculators;

use App\Models\Coupon;

class CouponDiscount
{
    public function calculate(Coupon $coupon, $total)
    {
        if ($coupon->discount_type == 'percentage') {
            $totalDiscount = $total * $coupon->discount_value / 100;
            if ($coupon->max_discount_value && ($totalDiscount > $coupon->max_discount_value)) {
                // throw new \Exception('Discount amount is greater than max discount value');

                return $coupon->max_discount_value;
            }

            return $totalDiscount;
        }
        if ($coupon->discount_type == 'fixed') {
            return $coupon->discount_value;
        }

    }
}
