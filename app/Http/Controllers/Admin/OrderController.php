<?php

namespace App\Http\Controllers\Admin;

use App\Actions\FetchMerchantOrders;
use App\Http\Controllers\Controller;
use App\Services\Merchant\MerchantService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:order-list')->only('index');
        $this->middleware('permission:order-show')->only('show');
    }

    public function index(Request $request)
    {
        $orders = OrderService::getOrders($request);
        if ($request->ajax()) {
            return view('components.orders.table', ['entity' => $orders])->render();
        }

        return view('Admin::orders.index', compact('orders'));
    }

    public function show($invoice_id)
    {
        $order = OrderService::getOrderByInvoiceId($invoice_id);

        return view('Admin::orders.show', compact('order'));
    }

    public function merchantOrders(Request $request, FetchMerchantOrders $fetchMerchantOrders)
    {
        $orders = $fetchMerchantOrders->execute($request);
        if ($request->ajax()) {
            return view('components.orders.merchant_table', ['entity' => $orders])->render();
        }

        return view('Admin::orders.merchant_orders', compact('orders'));
    }
}
