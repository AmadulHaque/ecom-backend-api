<?php

namespace App\Http\Controllers\Api;

use App\Actions\FetchCoupon;
use App\Http\Controllers\Controller;
use App\Http\Requests\CouponProductEligibilityRequest;
use Illuminate\Http\JsonResponse;

class CouponController extends Controller
{
    public function coupons($product_id): JsonResponse
    {
        $coupons = (new FetchCoupon)->handle($product_id);

        return success('Coupons fetched successfully', $coupons);
    }

    public function couponProductEligibility(CouponProductEligibilityRequest $request): JsonResponse
    {
        $coupons = (new FetchCoupon)->execute($request);

        return success('Coupons fetched successfully', $coupons);
    }
}
