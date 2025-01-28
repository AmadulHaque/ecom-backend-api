<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\MerchantOrder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderService
{
    public static function getOrders($request)
    {
        $perPage = $request->input('perPage', 10);
        $page = $request->input('page', 1);
        $search = $request->input('search', '');
        $shipping_type = $request->input('ship_type', '');
        $delivery_type = $request->input('delivery_type', '');

        $orders = Order::query()
            ->withCount('orderItems')
            ->when($search, function ($query) use ($search) {
                $query->whereAny(['invoice_id', 'customer_number'], 'like', "%{$search}%");
            })
            ->when($shipping_type, function ($query) use ($shipping_type) {
                $query->where('shipping_type', $shipping_type);
            })
            ->when($delivery_type, function ($query) use ($delivery_type) {
                $query->where('delivery_type', $delivery_type);
            })
            ->latest()
            ->paginate($perPage, ['*'], 'page', $page);

        return $orders;
    }

    public static function getOrderByInvoiceId($id)
    {
        return Order::where('invoice_id', $id)
            ->with([
                'merchantOrders',
                'merchantOrders.merchant',
                'merchantOrders.orderItems.product_variant.variationAttributes.attribute',
                'merchantOrders.orderItems.product_variant.variationAttributes.attributeOption',
                'merchantOrders.orderItems.product',
                'customer_location.parent.parent',
            ])
            ->first();
    }

    public function getCancelDetails($id)
    {
        $order = OrderItem::where('id', $id)->where('status_id', OrderStatus::CANCELLED->value)->first();
        if (! $order) {
            return failure('Order not found');
        }

        return success('Order cancel details fetched successfully', [
            'id' => $order->id,
            'tracking_id' => $order->merchant->tracking_id,
            'status' => $order->status_label,
            'cancel_reason' => $order->itemCase->reason->name,
            'created_at' => $order->created_at->format('M d, Y'),
            'shop_id' => $order->merchant->merchant->id,
            'shop_name' => $order->merchant->merchant->shop_name,
            'shop_image' => $order->merchant->merchant->image ?? null,
            'product_name' => $order->product->name,
            'product_slug' => $order->product->slug,
            'product_thumbnail' => $order->product->thumbnail,
            'product_variant' => self::getOrderItemVariantText($order->product_variant->variations ?? []),
            'quantity' => $order->quantity,
            'price' => $order->price,
            'total_amount' => ($order->price * $order->quantity),
            'cancel_date' => $order->itemCase->created_at->format('M d, Y'),
        ]);
    }

    // -------------Api service-------------------#

    public function getCustomerOrder($request)
    {
        $user = userInfo();
        $status = $request->status ?? null;
        $perPage = $request->input('per_page', 10);

        $orders = MerchantOrder::query()
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status_id', $status);
            })
            ->with([
                'merchant:id,name,shop_name',
                'orderItems:id,merchant_order_id,product_id,product_variation_id,price,quantity,status_id',
                'orderItems.product:id,name,slug',
                'orderItems.product_variant.variations',
                'orderItems.product_variant.variationAttributes.attributeOption:id,attribute_value',
                'orderItems.product_variant.variationAttributes.attribute:id,name',
            ])
            ->select('id', 'tracking_id', 'total_amount', 'shipping_amount', 'merchant_id', 'charge', 'status_id')
            ->orderBy('id', 'desc')
            ->paginate($perPage);

        return $orders;
    }

    // -------------Api service helper -------------------#

    public static function getOrderItemVariantText($variations = [])
    {
        if (empty($variations)) {
            return null;
        }

        $text = '';
        foreach ($variations as $variation) {
            $text .= $variation->attribute->name.': '.$variation->attributeOption->attribute_value.', ';
        }

        return rtrim($text, ', ');
    }
}
