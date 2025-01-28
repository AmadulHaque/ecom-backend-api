<?php

namespace App\Services\Checkout\Processors;

use App\DTOs\CheckoutData;
use App\Models\CustomerAddress;
use App\Models\Order;

class OrderProcessor
{
    public function createOrder(
        CheckoutData $data,
        CustomerAddress $address,
        array $orderItems,
        array $shippingDetails,
        array $coupon = [],
    ): Order {

        $totalPrice = $this->calculateTotalPrice($orderItems);
        $discount_amount = $coupon['discount_amount'] ?? 0;
        $grandTotal = ($totalPrice + $shippingDetails['shipping_fee'] + $shippingDetails['delivery_charge']) - $discount_amount;

        return Order::create([
            'invoice_id' => getInvoiceNo('orders', 'invoice_id', 'INV'),
            'user_id' => auth()->id(),
            'customer_location_id' => $address->location_id,
            'customer_name' => $address->name,
            'customer_address' => $address->address,
            'customer_landmark' => $address->landmark,
            'customer_number' => $address->contact_number,
            'total_price' => $totalPrice,
            'total_amount' => $grandTotal,
            'total_discount' => $discount_amount,
            'delivery_type' => $data->deliveryType,
            'shipping_type' => $shippingDetails['shipping_type'],
            'total_shipping_fee' => $shippingDetails['shipping_fee'],
            'charge' => $shippingDetails['delivery_charge'],
        ]);
    }

    private function calculateTotalPrice(array $orderItems): float
    {
        return collect($orderItems)
            ->flatten(1)
            ->sum(fn ($item) => $item['price'] * $item['quantity']);
    }
}
