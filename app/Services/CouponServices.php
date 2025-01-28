<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\CouponProductVariant;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CouponServices
{
    public function getAllCoupons($request)
    {
        $perPage = $request->perPage ?? 10;
        $search = $request->search ?? null;
        $discount_type = $request->discount_type ?? null;
        $page = $request->page ?? 1;
        $startDate = $request->start_date ? date('Y-m-d 00:00:00', strtotime($request->start_date)) : now()->subDays(6)->startOfDay();
        $endDate = $request->end_date ? date('Y-m-d 23:59:59', strtotime($request->end_date)) : now()->endOfDay();

        return Coupon::query()
            ->with('merchants', 'user', 'type')
            ->when($search, function ($query) use ($search) {
                $query->whereAny(['name', 'code'], 'like', '%'.$search.'%');
            })
            ->when($discount_type, function ($query) use ($discount_type) {
                $query->where('discount_type', $discount_type);
            })
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            })
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page)
            ->withQueryString();
    }

    public function createCoupon($data): JsonResponse
    {

        DB::beginTransaction();
        try {
            $coupon = Coupon::create([
                'name' => $data->name,
                'coupon_type_id' => $data->coupon_type_id,
                'code' => $data->code,
                'discount_value' => $data->discount_value,
                'max_discount_value' => $data->max_discount_value,
                'description' => $data->description,
                'min_purchase' => $data->min_purchase,
                'max_purchase' => $data->max_purchase,
                'usage_limit_per_user' => $data->usage_limit_per_user,
                'usage_limit_total' => $data->usage_limit_total,
                'discount_type' => $data->type,
                'status' => $data->status,
                'start_date' => $data->start_date,
                'end_date' => $data->end_date,
                'merchant_type' => $data->merchant_type,
                'category_type' => $data->category_type,
                'brand_type' => $data->brand_type,
                'product_type' => $data->product_type,
                'added_by' => auth()->id(),
            ]);

            // Attach related entities if they exist
            if (! empty($data->merchant_ids)) {
                $coupon->merchants()->attach($data->merchant_ids);
            }

            if (! empty($data->category_ids)) {
                $coupon->categories()->attach($data->category_ids);
            }

            if (! empty($data->brand_ids)) {
                $coupon->brands()->attach($data->brand_ids);
            }

            if (! empty($data->product_ids)) {
                $coupon->products()->attach($data->product_ids);

                foreach ($data->product_ids as $productId) {
                    if (isset($data->varient[$productId]) && is_array($data->varient[$productId])) {
                        foreach ($data->varient[$productId] as $variantId) {
                            CouponProductVariant::create([
                                'coupon_id' => $coupon->id,
                                'product_id' => $productId,
                                'product_variation_id' => $variantId,
                            ]);
                        }
                    }
                }
            }
            DB::commit();

            return response()->json(['message' => 'Coupon created successfully']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getCouponById($id): Coupon
    {
        return Coupon::findOrFail($id);
    }

    public function updateCoupon($data, $id): JsonResponse
    {
        DB::beginTransaction();
        try {
            // Find the coupon by ID
            $coupon = Coupon::findOrFail($id);

            // Update coupon with validated data
            $coupon->update([
                'name' => $data['name'],
                'coupon_type_id' => $data['coupon_type_id'],
                'code' => $data['code'],
                'discount_value' => $data['discount_value'],
                'max_discount_value' => $data['max_discount_value'],
                'description' => $data['description'],
                'min_purchase' => $data['min_purchase'],
                'max_purchase' => $data['max_purchase'],
                'usage_limit_per_user' => $data['usage_limit_per_user'],
                'usage_limit_total' => $data['usage_limit_total'],
                'discount_type' => $data['type'],
                'status' => $data['status'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'merchant_type' => $data['merchant_type'],
                'category_type' => $data['category_type'],
                'brand_type' => $data['brand_type'],
                'product_type' => $data['product_type'],
            ]);

            // Before syncing the products, delete existing variants for those products
            if (! empty($data['product_ids'])) {
                // Get the current product ids that are associated with this coupon
                $currentProductIds = $coupon->products->pluck('id')->toArray();

                // Find the product IDs that are no longer associated with this coupon (to be removed)
                $removedProductIds = array_diff($currentProductIds, $data['product_ids']);

                // Delete the product variants for the removed products
                foreach ($removedProductIds as $productId) {
                    CouponProductVariant::where('coupon_id', $coupon->id)
                        ->where('product_id', $productId)
                        ->delete();
                }

                // Sync the products
                $coupon->products()->sync($data['product_ids']);

                // Attach product variants for the coupon
                foreach ($data['product_ids'] as $productId) {
                    if (isset($data['varient'][$productId]) && is_array($data['varient'][$productId])) {
                        foreach ($data['varient'][$productId] as $variantId) {
                            CouponProductVariant::create([
                                'coupon_id' => $coupon->id,
                                'product_id' => $productId,
                                'product_variation_id' => $variantId,
                            ]);
                        }
                    }
                }
            }

            // Update related entities (merchants, categories, brands, products)
            if (! empty($data['merchant_ids'])) {
                $coupon->merchants()->sync($data['merchant_ids']);
            }

            if (! empty($data['category_ids'])) {
                $coupon->categories()->sync($data['category_ids']);
            }

            if (! empty($data['brand_ids'])) {
                $coupon->brands()->sync($data['brand_ids']);
            }

            if (empty($data['product_type'])) {
                $coupon->products()->detach();
                $coupon->productVariants()->delete();
            }

            if (empty($data['category_type'])) {
                $coupon->categories()->detach();  // Detach categories
            }

            if (empty($data['brand_type'])) {
                $coupon->brands()->detach();  // Detach brands
            }

            if (empty($data['merchant_type'])) {
                $coupon->merchants()->detach();  // Detach merchants
            }

            DB::commit();

            return response()->json(['message' => 'Coupon updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function deleteCoupon($id): void
    {
        $coupon = $this->getCouponById($id);
        $coupon->delete();
    }
}
