<?php

namespace App\Services;

use App\Models\PrimeView;
use App\Models\PrimeViewProduct;

class PrimeViewProductService
{
    public function getProducts($request)
    {
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $prime_view_id = $request->input('prime_view_id', '');
        
        $products = PrimeViewProduct::query()
            ->with([
                'product',
                'product.media',
                'product.category:id,name',
                'product.productDetail',
                'prime_view',
            ])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('product', function ($query) use ($search) {
                    return $query->where('name', 'like', '%'.$search.'%');
                });
            })
            ->when($prime_view_id, function ($query) use ($prime_view_id) {
                $query->where('prime_view_id', $prime_view_id);
            })
            ->paginate($perPage, ['*'], 'page', $page);

        return $products;
    }

    public function storePrimeViewProduct($data)
    {
        try {
            $prime_view = PrimeView::find($data['prime_view_id']);
            $existingProducts =
                $prime_view->products()
                    ->whereIn('product_id', $data['products'])
                    ->pluck('product_id')->toArray();

            $newProducts = array_diff($data['products'], $existingProducts);

            if (! empty($newProducts)) {
                $prime_view->products()->attach($newProducts);
            }

            return $newProducts;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function deletePrimeViewProduct($id)
    {
        $prime_view = PrimeViewProduct::find($id)->delete();

        return $prime_view;
    }
}
