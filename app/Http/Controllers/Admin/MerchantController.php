<?php

namespace App\Http\Controllers\Admin;

use App\Actions\FetchMerchantOrders;
use App\Http\Controllers\Controller;
use App\Services\Merchant\MerchantService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    public $merchantService;

    public function __construct(MerchantService $merchantService)
    {
        $this->merchantService = $merchantService;
        $this->middleware('permission:merchant-list')->only('index');
        $this->middleware('permission:merchant-show')->only('show');
        $this->middleware('permission:merchant-active')->only('active');
        $this->middleware('permission:merchant-inactive')->only('inactive');
    }

    public function index(Request $request)
    {
        $merchants = $this->merchantService->getAllMerchant($request);
        if ($request->ajax()) {
            return view('components.merchant.table', ['entity' => $merchants])->render();
        }

        return view('Admin::merchant.index', compact('merchants'));
    }

    public function show(Request $request, $id, FetchMerchantOrders $fetchMerchantOrders)
    {

        $request->merge(['merchant_id' => $id]);
        $products = ProductService::requestProducts($request);

        if ($request->ajax()) {
            return view('components.merchant.product_table', ['entity' => $products])->render();
        }

        $shopStatuses = \App\Enums\ShopProductStatus::label();
        $merchant = $this->merchantService->getMerchantById($id);
        $orders = $fetchMerchantOrders->execute($request);

        // count product and orders
        $count = $this->merchantService->getCount($id);

        return view('Admin::merchant.show', compact('merchant', 'products', 'shopStatuses', 'orders', 'count'));
    }

    public function active($id)
    {
        $this->merchantService->activeMerchant($id);

        return redirect()->back();
    }


    public function ajaxMerchants(Request $request)
    {
        $merchants = MerchantService::getMerchantBySearch($request);
        return success('Merchant fetched successfully', $merchants);
    }
}
