<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductDetailsResource;
use App\Http\Resources\ProductsResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function products(Request $request): JsonResponse
    {
        return ProductService::getProducts($request);
    }

    public function productDetails($slug): JsonResponse
    {
        $product = ProductService::getProductBySlug($slug);

        return success('show product details', $product);
    }

    public function productVariant($slug): JsonResponse
    {
        return ProductService::getProductVariantBySlug($slug);
    }

    public function productSuggestions(Request $request)
    {
        $products = ProductService::getProductSuggestions($request);

        return success('Product suggestions fetched successfully', $products);
    }

    public function shopProducts(Request $request): JsonResponse
    {
        $products = $this->productService->getNewShopProducts($request);

        return response()->json([
            'message' => 'ok',
            'data' => ProductsResource::collection($products->items()),
            'total' => $products->total(),
            'last_page' => $products->lastPage(),
            'current_page' => $products->currentPage(),
            'next_page_url' => $products->nextPageUrl(),
        ], 200);
    }

    public function shopProductDetails($slug): JsonResponse
    {
        $products = $this->productService->getNewShopProductDetails($slug);

        return success('Product details fetched successfully', new ProductDetailsResource($products));
    }
}
