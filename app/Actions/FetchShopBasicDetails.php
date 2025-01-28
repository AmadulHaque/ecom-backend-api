<?php

namespace App\Actions;

use App\Models\Category;
use App\Models\Merchant;
use App\Models\Product;

class FetchShopBasicDetails
{
    public function execute($id)
    {
        $merchant = Merchant::where('id', $id)->first();

        if (! $merchant) {
            return failure('Shop not found', 404);
        }

        $categories = Category::whereIn('id',
            Product::where('merchant_id', $id)
                ->Active()
                ->pluck('category_id')
                ->unique()
        )
            ->select('id', 'name', 'slug')
            ->get();

        $data = [
            'shop' => [
                'id' => $merchant->id,
                'name' => $merchant->shop_name,
            ],
            'categories' => $categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                ];
            }),
        ];

        return success('Shop basic details fetched successfully', $data);
    }
}
