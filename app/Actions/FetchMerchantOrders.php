<?php

namespace App\Actions;

use App\Models\MerchantOrder;

class FetchMerchantOrders
{
    public function execute($request)
    {
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $merchant_id = $request->input('merchant_id', '');
        $status = $request->input('status', '');

        $orders = MerchantOrder::query()
            ->with('merchant:id,name,shop_name', 'order:id,invoice_id')
            ->withCount('orderItems')
            ->when($merchant_id, function ($query, $merchant_id) {
                return $query->where('merchant_id', $merchant_id);
            })
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('tracking_id', 'like', "%{$search}%")
                        ->orWhereHas('merchant', function ($query) use ($search) {
                            $query->whereAny(['phone', 'shop_name'], 'like', "%{$search}%");
                        });
                });
            })
            ->when($status, function ($query, $status) {
                return $query->where('status_id', $status);
            })
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        return $orders;
    }
}
