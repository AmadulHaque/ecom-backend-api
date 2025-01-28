<?php

namespace App\Services\Checkout\Processors;

use App\Enums\OrderStatus;
use App\Models\CouponUsage;
use App\Models\MerchantOrder;
use App\Models\Order;
use App\Models\OrderItem;

class MerchantOrderProcessor
{
    public function createMerchantOrders(Order $order, array $orderItems, array $shippingDetails, array $coupon)
    {
        foreach ($orderItems as $merchantId => $items) {
            $merchantTotal = $this->calculateMerchantTotal($items);
            $merchantOrder = $this->createMerchantOrder(
                $order,
                $merchantId,
                $merchantTotal,
                $shippingDetails,
                $coupon,
            );
            $this->createOrderItems($merchantOrder, $items);
        }
    }

    private function calculateMerchantTotal(array $items): float
    {
        return collect($items)->sum(fn ($item) => $item['price'] * $item['quantity']);
    }

    private function createMerchantOrder(Order $order, int $merchantId, float $merchantTotal, array $shippingDetails, $coupon): MerchantOrder
    {

        $merchantOrder = MerchantOrder::create([
            'order_id' => $order->id,
            'merchant_id' => $merchantId,
            'tracking_id' => getInvoiceNo('merchant_orders', 'tracking_id', 'TRK'),
            'status_id' => OrderStatus::PENDING->value,
            'total_amount' => ($merchantTotal + $shippingDetails['delivery_charge_per_item'] + $shippingDetails['shipping_fee_per_item']) - $coupon['discount_amount'] ?? 0,
            'sub_total' => $merchantTotal,
            'shipping_amount' => $shippingDetails['shipping_fee_per_item'],
            'charge' => $shippingDetails['delivery_charge_per_item'],
            'discount_amount' => $coupon['discount_amount'] ?? 0,
        ]);

        if ($coupon) {
            $this->createCouponUages($coupon, $merchantOrder->id);
        }

        return $merchantOrder;
    }

    private function createOrderItems(MerchantOrder $merchantOrder, array $items): void
    {
        foreach ($items as $item) {
            OrderItem::create([
                'merchant_order_id' => $merchantOrder->id,
                'product_id' => $item['product_id'],
                'product_variation_id' => $item['product_variation_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'status_id' => OrderStatus::PENDING->value,
            ]);
        }
    }

    private function createCouponUages($coupon, $orderId)
    {
        if ($coupon && $coupon['id']) {
            return CouponUsage::create([
                'user_id' => auth()->user()->id,
                'coupon_id' => $coupon['id'],
                'merchant_order_id' => $orderId,
            ]);
        }

    }
}
