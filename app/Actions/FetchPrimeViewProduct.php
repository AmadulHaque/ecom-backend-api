<?php

namespace App\Actions;

use App\Models\PrimeView;
use Exception;

class FetchPrimeViewProduct
{
    // public static function execute1($request)
    // {
    //     $limit = min($request->input('limit', 10), 30);

    //     $products = PrimeView::where('status', 'active')
    //         ->with([
    //             'products' => function ($query) {
    //                 $query
    //                     ->with([
    //                         'productDetail:id,product_id,regular_price,discount_price',
    //                         'reviews:id,product_id,rating,review',
    //                     ])
    //                     ->withCount('reviews')
    //                     ->withAvg('reviews', 'rating')
    //                     ->select('id', 'name', 'slug');
    //                 },
    //         ])
    //         ->select('id', 'name', 'slug')
    //         ->limit($limit)
    //         ->get();

    //         return $products;
    // }

    public static function execute($request)
    {
        // Validate and set limit
        $limit = $request->input('limit', 10);
        $limit = is_numeric($limit) && $limit > 0 ? min($limit, 30) : 10;

        try {
            $products = PrimeView::where('status', 'active')
                ->with([
                    'products' => function ($query) {
                        $query->with([
                            'reviews:id,product_id,rating,review',
                            'media',
                        ])
                            ->join('product_details', 'products.id', '=', 'product_details.product_id')
                            ->select(
                                'products.id',
                                'products.name',
                                'products.slug',
                                'product_details.regular_price',
                                'product_details.discount_price'
                            );
                    },
                ])
                ->select('prime_views.id', 'prime_views.name', 'prime_views.slug')
                ->limit($limit)
                ->get();

            return $products;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}

/*

{
    "id": 8,
    "name": "Monitor",
    "slug": "monitor",
    "image": [
        {
            "url": "http://192.168.10.236:8000/storage/media/ii9RhqxAbMhRo7JrtpzJgqHwKqB4wAlGaAUxDVci.png"
        }
    ],
    "is_variant": "1",
    "specification": "",
    "thumbnail": "http://192.168.10.236:8000/storage/media/ii9RhqxAbMhRo7JrtpzJgqHwKqB4wAlGaAUxDVci.png",
    "rating_avg": 0,
    "rating_count": 0,
    "pivot": {
        "prime_view_id": 1,
        "product_id": 8
    },
    "product_detail": {
        "id": 8,
        "product_id": 8,
        "regular_price": "9000.00",
        "discount_price": "8000.00"
    },
    "reviews": []
},

{
    "id": 1,
    "name": "Product1",
    "slug": "product1",
    "reviews_count": 0,
    "reviews_avg_rating": null,
    "image": [
        {
            "url": "http://192.168.10.236:8000/storage/media/Rm5wnu0pxo8sMENQXfhyykAs39gzTFOqGfFsfD8i.png"
        }
    ],
    "is_variant": "1",
    "specification": "",
    "thumbnail": "http://192.168.10.236:8000/storage/media/Rm5wnu0pxo8sMENQXfhyykAs39gzTFOqGfFsfD8i.png",
    "rating_avg": 0,
    "rating_count": 0,
    "product_detail": {
        "id": 1,
        "product_id": 1,
        "regular_price": "2500.00",
        "discount_price": "2200.00"
    },
    "reviews": []
},

*/
