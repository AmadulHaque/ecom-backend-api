<?php

namespace App\Actions;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class FetchShopProducts
{
    public function execute($request, $id)
    {
        // Get pagination and filter parameters
        $perPage = $request->input('perPage', 10);
        $search = $request->input('search');
        $sort = $request->input('sort');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $category_id = $request->input('category_id');

        // Get merchant's products with essential relations
        $productsQuery = Product::where('merchant_id', $id)
            ->Active()
            ->with([
                'media',
            ])
            ->leftJoin('product_details', 'products.id', '=', 'product_details.product_id')
            ->select(
                'products.id',
                'products.category_id',
                'products.name',
                'products.slug',
                'products.product_type_id',
                'product_details.regular_price',
                'product_details.discount_price'
            );

        // Apply filters
        if ($search) {
            $productsQuery->where('products.name', 'like', '%'.$search.'%');
        }

        if ($category_id) {
            $productsQuery->where('products.category_id', $category_id);
        }

        if ($minPrice > 0 && $maxPrice > 0) {
            $productsQuery->whereBetween(DB::raw('CASE WHEN product_details.discount_price > 0 THEN product_details.discount_price ELSE product_details.regular_price END'), [$minPrice, $maxPrice]);
        } elseif ($minPrice > 0) {
            $productsQuery->where(DB::raw('CASE WHEN product_details.discount_price > 0 THEN product_details.discount_price ELSE product_details.regular_price END'), '>=', $minPrice);
        } elseif ($maxPrice > 0) {
            $productsQuery->where(DB::raw('CASE WHEN product_details.discount_price > 0 THEN product_details.discount_price ELSE product_details.regular_price END'), '<=', $maxPrice);
        }

        // Apply sorting
        if ($sort == 'low_price') {
            $productsQuery->orderBy(DB::raw('CASE WHEN product_details.discount_price > 0 THEN product_details.discount_price ELSE product_details.regular_price END'), 'ASC');
        } elseif ($sort == 'high_price') {
            $productsQuery->orderBy(DB::raw('CASE WHEN product_details.discount_price > 0 THEN product_details.discount_price ELSE product_details.regular_price END'), 'DESC');
        }

        // Get paginated products
        $products = $productsQuery->paginate($perPage);

        return formatPagination('All products of this shop fetched successfully', $products);
    }
}
