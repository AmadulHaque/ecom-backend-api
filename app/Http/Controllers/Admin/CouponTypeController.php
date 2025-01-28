<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponType;
use Illuminate\Http\Request;

class CouponTypeController extends Controller
{
    public function index(Request $request)
    {
        $couponTypes = CouponType::all();
        if ($request->ajax()) {
            return view('components.coupon-type.table', ['entity' => $couponTypes])->render();
        }

        return view('Admin::coupon_types.index', compact('couponTypes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:coupon_types,name',
        ]);
        CouponType::create($data);

        return response()->json(['message' => 'Coupon Type Created Successfully']);
    }

    public function edit(CouponType $couponType)
    {
        return view('components.coupon-type.form', ['data' => $couponType])->render();
    }

    public function update(Request $request, CouponType $couponType)
    {
        $data = $request->validate([
            'name' => 'required|unique:coupon_types,name,'.$couponType->id,
        ]);
        $couponType->update($data);

        return response()->json(['message' => 'Coupon Type updated Successfully']);
    }

    public function destroy(string $id)
    {
        $couponType = CouponType::find($id);
        $coupons = Coupon::where('coupon_type_id', $id)->count();
        if ($coupons > 0) {
            return response()->json(['message' => 'This Coupon Type is used in some coupons']);
        }
        $couponType->delete();

        return response()->json(['message' => 'Coupon Type deleted Successfully']);
    }
}
