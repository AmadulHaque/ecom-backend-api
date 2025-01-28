<?php

namespace App\Services\Merchant;

use App\Models\Merchant;
use App\Enums\OrderStatus;
use App\Enums\MerchantStatus;
use Illuminate\Database\Eloquent\Collection;


class MerchantService
{
    public function getAllMerchant($request)
    {
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $shop_status = $request->input('shop_status', '');

    
        $merchant = Merchant::query()
            ->when($search, function ($query) use ($search) {
                $query->whereAny(['phone', 'name', 'shop_name'], 'like', '%'.$search.'%');
            })
            ->when($shop_status != '', function ($query) use ($shop_status) {
                $query->where('shop_status', $shop_status);
            })
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        return $merchant;
    }

    public static function getMerchantBySearch($request)
    {
        $limit = $request->input('limit', 20);
        $search = $request->input('search', '');

        $merchant = Merchant::query()
            ->when($search, function ($query) use ($search) {
                $query->whereAny(['phone', 'name', 'shop_name'], 'like', '%'.$search.'%');
            })
            ->limit($limit)->get();

        return $merchant;
    }

    public function getMerchantById($id)
    {
        return Merchant::find($id);
    }

    public function activeMerchant($id)
    {
        $merchant = Merchant::find($id);

        if (! $merchant) {
            return redirect()->back()->with('message', 'Merchant not found');
        }

        $merchant->update([
            'shop_status' => MerchantStatus::Active->value
        ]);

        $merchant->shop_products()
            ->with('productHoldStatus')
            ->chunk(100, function (Collection $products) {
                foreach ($products as $product) {
                    if ($product->productHoldStatus) {
                        $product->update([
                            'status' => $product->productHoldStatus->status_id
                        ]);
                    }
                }
            });
        return redirect()->back()->with('message', 'Merchant activated successfully');
    }


    





    public function getCount($id)
    {
        $merchant = Merchant::find($id);
        $count = [
            'products' => $merchant->products()->count(),
            'shop_products' => $merchant->shop_products()->count(),
            'orders' => $merchant->orders()->count(),
            'cancel_orders' => $merchant->orders()->where('status_id', OrderStatus::CANCELLED->value)->count(),
            'customers' => $merchant->customers()->count(),
        ];

        return $count;
    }
}
