<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderShopResource;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function shopOrders(Request $request): JsonResponse
    {
        $orders = $this->orderService->getCustomerOrder($request);

        return resourceFormatPagination('Orders fetched successfully', OrderShopResource::collection($orders->items()), $orders);
    }

    public function orderCancelDetails($id): JsonResponse
    {
        return $this->orderService->getCancelDetails($id);
    }
}
