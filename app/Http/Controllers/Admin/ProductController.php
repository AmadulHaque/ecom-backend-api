<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:product-request-list')->only('requestProducts');
        $this->middleware('permission:product-request-update')->only('requestProductStatus');

        $this->middleware('permission:shop-product-list')->only('shopProducts');
        // "shop-product-show" and "product-request-show" permissions are checked in show method
    }

    public function requestProducts(Request $request)
    {
        $shopStatuses = \App\Enums\ShopProductStatus::label();
        $products = ProductService::requestProducts($request);

        if ($request->ajax()) {
            return view('components.product.request_table', compact('products'))->render();
        }

        return view('Admin::product.product_request', compact('products', 'shopStatuses'));
    }

    public function requestProductStatus(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'status' => 'required',
        ]);

        ProductService::requestProductStatus((object) $data);

        return response()->json(['message' => 'Product status updated successfully']);
    }

    public function shopProducts(Request $request)
    {
        $products = ProductService::getShopProducts($request);
        if ($request->ajax()) {
            return view('components.product.table', compact('products'))->render();
        }

        return view('Admin::product.shop_products', compact('products'));
    }

    public function show($slug)
    {
        $user = auth()->user();

        if (! $user->can('shop-product-show') && ! $user->can('product-request-show') && auth()->user()->role->value != 5) {
            return redirect()->back()->with('error', 'You do not have permission to access this resource.');
        }

        $product = ProductService::getProductBySlug($slug);

        return view('Admin::product.show', compact('product'));
    }

    public function MerchantCategoryProducts(Request $request)
    {
        return ProductService::getMerchantCategoryProducts($request);
    }

    public function productVariant($id)
    {
        $product = Product::find($id);
        $variant = $product->variations()->get()->map(function ($item) {
            return [
                'id' => $item->id,
                'sku' => $item->sku,
                'variant' => OrderService::getOrderItemVariantText($item->variations ?? []),
            ];
        });

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'variant' => $variant,
        ]);
    }
}
