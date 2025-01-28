<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ShopProduct;
use App\Models\VariationAttribute;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public static function getProducts($request): JsonResponse
    {
        try {
            $perPage = $request->input('perPage', 10);
            $search = $request->input('search');
            $sort = $request->input('sort');
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            $category_id = $request->input('category_id');
            $sub_category_id = $request->input('sub_category_id');
            $sub_category_child_id = $request->input('sub_category_child_id');
            $prime_view_slug = $request->input('prime_view_slug');
            $merchant_id = $request->input('merchant_id');
            $related_product_id = $request->input('related_product_id');

            $query = Product::where('status', 1)
                // where shopProduct exists
                ->whereHas('shopProduct', function ($query) {
                    $query->where('status', 2);
                })
                ->with(['productDetail:id,product_id,regular_price,discount_price'])
                ->leftJoin('product_details', 'products.id', '=', 'product_details.product_id')
                ->select(
                    'products.id',
                    'products.name',
                    'products.slug',
                    'products.product_type_id',
                    'product_details.regular_price',
                    'product_details.discount_price'
                );
            if ($prime_view_slug) {
                $query->whereHas('primeViews', function ($q) use ($prime_view_slug) {
                    $q->where('slug', $prime_view_slug);
                });
            }
            if ($merchant_id) {
                $query->whereHas('merchant', function ($q) use ($merchant_id) {
                    $q->where('id', $merchant_id);
                });
            }
            if ($related_product_id) {
                $query->whereNot('id', $related_product_id);
            }
            if ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            }

            if ($category_id) {
                $query->where('category_id', $category_id);
            }

            if ($sub_category_id) {
                $query->where('sub_category_id', $sub_category_id);
            }

            if ($sub_category_child_id) {
                $query->where('sub_category_child_id', $sub_category_child_id);
            }

            if ($minPrice > 0 && $maxPrice > 0) {
                $query->whereHas('productDetail', function ($q) use ($minPrice, $maxPrice) {
                    $q->whereBetween(DB::raw('CASE WHEN discount_price > 0 THEN discount_price ELSE regular_price END'), [$minPrice, $maxPrice]);
                });
            } elseif ($minPrice > 0) {
                $query->whereHas('productDetail', function ($q) use ($minPrice) {
                    $q->where(DB::raw('CASE WHEN discount_price > 0 THEN discount_price ELSE regular_price END'), '>', $minPrice);
                });
            } elseif ($maxPrice > 0) {
                $query->whereHas('productDetail', function ($q) use ($maxPrice) {
                    $q->where(DB::raw('CASE WHEN discount_price > 0 THEN discount_price ELSE regular_price END'), '<', $maxPrice);
                });
            }
            if ($sort == 'low_price') {
                $query->orderBy(DB::raw('CASE WHEN product_details.discount_price > 0 THEN product_details.discount_price ELSE product_details.regular_price END'), 'ASC');
            }
            if ($sort == 'high_price') {
                $query->orderBy(DB::raw('CASE WHEN product_details.discount_price > 0 THEN product_details.discount_price ELSE product_details.regular_price END'), 'DESC');
            }

            $products = $query->paginate($perPage);

            return formatPagination('show all popular products', $products);
        } catch (\Exception $e) {
            return failure($e->getMessage(), 500);
        }
    }

    public function getNewShopProducts($request)
    {
        try {
            $perPage = $request->input('perPage', 10);
            $search = $request->input('search');
            $sort = $request->input('sort');
            $minPrice = $request->input('min_price');
            $maxPrice = $request->input('max_price');
            $category_id = $request->input('category_id');
            $sub_category_id = $request->input('sub_category_id');
            $sub_category_child_id = $request->input('sub_category_child_id');
            $prime_view_slug = $request->input('prime_view_slug');
            $merchant_id = $request->input('merchant_id');
            $related_product_id = $request->input('related_product_id');

            $query = Product::where('status', 1)
                ->whereHas('shopProduct', function ($query) {
                    $query->where('status', 2);
                })
                ->with(['productDetail:id,product_id,regular_price,discount_price'])
                ->leftJoin('product_details', 'products.id', '=', 'product_details.product_id')
                ->select(
                    'products.id',
                    'products.name',
                    'products.slug',
                    'products.total_stock_qty',
                    'products.product_type_id',
                    'product_details.regular_price',
                    'product_details.discount_price'
                );
            if ($prime_view_slug) {
                $query->whereHas('primeViews', function ($q) use ($prime_view_slug) {
                    $q->where('slug', $prime_view_slug);
                });
            }
            if ($merchant_id) {
                $query->whereHas('merchant', function ($q) use ($merchant_id) {
                    $q->where('id', $merchant_id);
                });
            }

            if ($search) {
                $query->where('name', 'like', '%'.$search.'%');
            }
            if ($related_product_id) {
                $query->whereNot('id', $related_product_id);
            }

            if ($category_id) {
                $query->where('category_id', $category_id);
            }

            if ($sub_category_id) {
                $query->where('sub_category_id', $sub_category_id);
            }

            if ($sub_category_child_id) {
                $query->where('sub_category_child_id', $sub_category_child_id);
            }

            if ($minPrice > 0 && $maxPrice > 0) {
                $query->whereHas('productDetail', function ($q) use ($minPrice, $maxPrice) {
                    $q->whereBetween(DB::raw('CASE WHEN discount_price > 0 THEN discount_price ELSE regular_price END'), [$minPrice, $maxPrice]);
                });
            } elseif ($minPrice > 0) {
                $query->whereHas('productDetail', function ($q) use ($minPrice) {
                    $q->where(DB::raw('CASE WHEN discount_price > 0 THEN discount_price ELSE regular_price END'), '>', $minPrice);
                });
            } elseif ($maxPrice > 0) {
                $query->whereHas('productDetail', function ($q) use ($maxPrice) {
                    $q->where(DB::raw('CASE WHEN discount_price > 0 THEN discount_price ELSE regular_price END'), '<', $maxPrice);
                });
            }
            if ($sort == 'low_price') {
                $query->orderBy(DB::raw('CASE WHEN product_details.discount_price > 0 THEN product_details.discount_price ELSE product_details.regular_price END'), 'ASC');
            }
            if ($sort == 'high_price') {
                $query->orderBy(DB::raw('CASE WHEN product_details.discount_price > 0 THEN product_details.discount_price ELSE product_details.regular_price END'), 'DESC');
            }

            return $query->paginate($perPage);

            // return formatPagination('show all popular products', $products);
        } catch (\Exception $e) {
            return failure($e->getMessage(), 500);
        }
    }

    public function getNewShopProductDetails($slug)
    {
        $product = Product::where('slug', $slug)
            ->select('id', 'name', 'category_id', 'product_type_id', 'category_id', 'sub_category_id', 'sub_category_child_id', 'brand_id', 'slug', 'description', 'merchant_id', 'total_stock_qty')
            ->with([
                'productDetail:id,product_id,regular_price,discount_price,default_variation_id',
                'productDetail.selectedVariation:id,sku,regular_price,discount_price',
                'variations.variationAttributes.attribute',
                'variations.variationAttributes.attributeOption',
                'merchant:id,shop_name',
                'brand',
            ])
            ->first();

        return $product;
    }

    public static function getProductBySlug($slug)
    {
        $product = Product::where('slug', $slug)
            ->select('id', 'name', 'category_id', 'sku', 'product_type_id', 'category_id', 'sub_category_id', 'sub_category_child_id', 'brand_id', 'slug', 'description', 'merchant_id', 'total_stock_qty')
            ->with([
                'productDetail:id,product_id,regular_price,discount_price',
                'variations.variationAttributes.attribute',
                'variations.variationAttributes.attributeOption',
                'merchant:id,shop_name',
                'brand',
            ])
            ->first();

        return $product;
    }

    public static function getProductVariantBySlug($slug): JsonResponse
    {
        try {
            // find product
            $product = Product::with([
                'variations.variationAttributes.attribute',
                'variations.variationAttributes.attributeOption',
                'media',
            ])->where('slug', $slug)->first();

            // check if product exists
            if (! $product) {
                return failure('Product not found', 404);
            }

            // get product attributes & variations
            $attributes = self::getAttributes($product);
            $variations = self::getVariations(
                $product->variations()
                    ->whereHas('stockInventory', function ($query) {
                        $query->where('stock_qty', '>', 0);
                    })->get()
            );

            // return  product attributes & variations
            return success('Product variations fetched successfully', [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'attributes' => $attributes,
                'variations' => $variations,
            ]);
        } catch (\Exception $e) {
            return failure($e->getMessage(), 500);
        }
    }

    public static function requestProducts(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $status = $request->input('status', '');
        $merchant_id = $request->input('merchant_id', '');
        $search = $request->input('search', '');

        $products = ShopProduct::query()
            ->with([
                'merchant:id,name,shop_status',
                'product:id,name,slug',
                'product.media',
            ])
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($merchant_id, function ($query) use ($merchant_id) {
                return $query->where('merchant_id', $merchant_id);
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('product', function ($query) use ($search) {
                    return $query->where('name', 'like', '%'.$search.'%');
                });
            })
            ->orderBy('status', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return $products;

    }

    public static function requestProductStatus($request)
    {
        $product = ShopProduct::find($request->id);
        $product->status = $request->status;
        $product->save();

        return $product;
    }

    public static function getShopProducts(Request $request)
    {
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $merchant_id = $request->input('merchant_id', '');

        $products = ShopProduct::query()
            ->with([
                'merchant:id,name,shop_status',
                'product',
                'product.productDetail:id,product_id,regular_price,discount_price',
                'product.media',
                'product.category:id,name',
            ])->active()
            ->when($search, function ($query) use ($search) {
                $query->whereHas('product', function ($query) use ($search) {
                    return $query->where('name', 'like', '%'.$search.'%');
                });
            })
            ->when($merchant_id, function ($query) use ($merchant_id) {
                return $query->where('merchant_id', $merchant_id);
            })
            ->paginate($perPage, ['*'], 'page', $page);

        return $products;
    }

    public static function getShopLimitProducts($search = '', $limit = 10)
    {

        $products = ShopProduct::query()
            ->active()
            ->with('product:id,name', 'product.media', 'product.reviews')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('product', function ($query) use ($search) {
                    return $query->where('name', 'like', '%'.$search.'%');
                });
            })
            ->limit($limit)->get();

        return $products;
    }

    public static function getProductSuggestions($request)
    {
        $search = $request->search ?? '';
        $limit = is_numeric($request->limit) && $request->limit > 0 ? min($request->limit, 100) : 10;

        return DB::table('products')
            ->where('status', 1)
            ->where('name', 'like', '%'.$search.'%')
            ->orWhereRaw('SOUNDEX(name) = SOUNDEX(?)', [$search])
            ->select('id', 'name', 'slug')
            ->limit($limit)->get();

    }

    public static function getMerchantCategoryProducts($request)
    {
        $search = $request->search ?? '';
        $merchant_ids = $request->merchant_ids ?? [];
        $category_ids = $request->category_ids ?? [];
        $brand_ids = $request->brand_ids ?? [];
        $merchant_type = $request->merchant_type ?? '';
        $category_type = $request->category_type ?? '';
        $brand_type = $request->brand_type ?? '';

        $query = Product::where('status', 1)
            ->with('media')
            ->whereHas('shopProduct', function ($query) {
                $query->where('status', 2);
            });
        if ($merchant_type == '1' && $merchant_ids) {
            $query->whereNotIn('merchant_id', $merchant_ids);
        }
        if ($merchant_type == '2' && $merchant_ids) {
            $query->whereIn('merchant_id', $merchant_ids);
        }
        if ($category_type == '1' && $category_ids) {
            $query->whereNotIn('category_id', $category_ids);
        }
        if ($category_type == '2' && $category_ids) {
            $query->whereIn('category_id', $category_ids);
        }
        if ($brand_type == '2' && $category_ids) {
            $query->whereIn('brand_ids', $brand_ids);
        }
        if ($brand_type == '1' && $category_ids) {
            $query->whereNotIn('brand_ids', $brand_ids);
        }

        return $query->limit(20)->select('id', 'name', 'slug')->get();

    }

    // ----------------------all support methods----------------------
    public static function getAttributes($product)
    {

        $attributes = [];
        $productVariationIds = $product->variations()->pluck('id')->toArray();
        $variationAttributes = VariationAttribute::whereIn('product_variation_id', $productVariationIds)
            ->orderBy('attribute_id', 'ASC')->get()->unique('attribute_option_id');
        foreach ($variationAttributes as $variationAttribute) {
            $attributeName = $variationAttribute->attribute->name;
            $optionValue = $variationAttribute->attributeOption->attribute_value;
            $attributes[] = [
                'id' => $variationAttribute->attribute_id,
                'name' => $attributeName,
                'value' => $optionValue,
                'valueId' => $variationAttribute->attributeOption->id,
                'image' => $variationAttribute->variation->image,
            ];
        }

        return $attributes;
    }

    public static function getVariations($variations)
    {
        return $variations->map(function ($variation) {
            return [
                'id' => $variation->id,
                'sku' => $variation->sku,
                'regular_price' => $variation->stockInventory->regular_price,
                'discount_price' => $variation->stockInventory->discount_price,
                'quantity' => $variation->stockInventory->stock_qty,
                'image' => $variation->image,
                'variant' => $variation->variationAttributes->map(function ($variationAttribute) {
                    return [
                        'attribute_id' => $variationAttribute->attribute->id,
                        'attribute_name' => $variationAttribute->attribute->name,
                        'attribute_option' => $variationAttribute->attributeOption->attribute_value,
                        'attribute_option_id' => $variationAttribute->attributeOption->id,
                    ];
                }),
            ];
        });

    }
}
