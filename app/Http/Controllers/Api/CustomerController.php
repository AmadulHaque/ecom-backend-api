<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerAddress;
use App\Http\Requests\OrderCancelRequest;
use App\Http\Requests\OrderReturnRequest;
use App\Services\CustomerAddressService;
use App\Services\CustomerOrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerAddressService;

    public function __construct(CustomerAddressService $customerAddressService)
    {
        $this->customerAddressService = $customerAddressService;
    }

    public function customerAddressStore(CustomerAddress $request): JsonResponse
    {
        $data = $request->validated();

        return $this->customerAddressService->create($data);
    }

    public function customerAddressList(): JsonResponse
    {
        return $this->customerAddressService->getAll();
    }

    public function customerOrders(Request $request)
    {
        return CustomerOrderService::getCustomerOrder($request);
    }

    public function customerOrderDetails($tracking_id)
    {
        return CustomerOrderService::getCustomerOrderDetails($tracking_id);
    }

    public function cancelOrderItem(OrderCancelRequest $request, $tracking_id): JsonResponse
    {
        $data = $request->validated();

        return CustomerOrderService::OrderItemCancel($data, $tracking_id);
    }

    public function returnOrderItem(OrderReturnRequest $request, $tracking_id): JsonResponse
    {
        $data = $request->validated();

        return CustomerOrderService::OrderItemReturn($data, $tracking_id);
    }

    public function customerReturns(Request $request): JsonResponse
    {
        return CustomerOrderService::getCustomerReturns($request);
    }

    public function returnDetails($id, $tracking_id): JsonResponse
    {
        return CustomerOrderService::getCustomerReturnDetails($id, $tracking_id);
    }
}
