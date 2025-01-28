<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Services\CouponServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    protected $couponServices;

    public function __construct(
        CouponServices $couponServices,
    ) {
        $this->couponServices = $couponServices;
    }

    public function index(Request $request)
    {
        $coupons = $this->couponServices->getAllCoupons($request);
        $startDate = $request->start_date ?? now()->subDays(6)->startOfDay();
        $endDate = $request->end_date ?? now()->endOfDay();

        return customView(['ajax' => 'components.coupon.table', 'default' => 'Admin::coupons.index'], compact('coupons', 'startDate', 'endDate'));
    }

    public function create()
    {
        $categories = DB::table('categories')->get();
        $coupon_types = DB::table('coupon_types')->get();

        return view('Admin::coupons.create', compact('categories', 'coupon_types'));
    }

    public function store(CouponRequest $request)
    {
        return $this->couponServices->createCoupon($request);
    }

    public function edit($id)
    {
        $categories = DB::table('categories')->get();
        $coupon_types = DB::table('coupon_types')->get();
        $coupon = $this->couponServices->getCouponById($id);

        return view('Admin::coupons.edit', compact('categories', 'coupon_types', 'coupon'));
    }

    public function update(CouponRequest $request, $id)
    {
        return $this->couponServices->updateCoupon($request, $id);
    }

    public function destroy($id)
    {
        $this->couponServices->deleteCoupon($id);

        return response()->json(['success' => 'Coupon deleted successfully']);
    }
}
